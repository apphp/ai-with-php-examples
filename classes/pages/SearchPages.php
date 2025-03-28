<?php

namespace app\classes\pages;

class SearchPages {
    /**
     * Maximum number of search results to return
     */
    const MAX_SEARCH_RESULTS = 25;

    /**
     * Base directory to search in
     * @var string
     */
    private $baseDir;

    /**
     * Search keyword
     * @var string
     */
    private $keyword;

    /**
     * Search results array
     * @var array
     */
    private $results = [];

    /**
     * Start time of search
     * @var float
     */
    private $startTime;

    /**
     * Finish time of search
     * @var float
     */
    private $finishTime;

    /**
     * Words to ignore in search
     * @var array
     */
    private $ignoredWords = ['on', 'for', 'a', 'in', 'the', 'this'];

    /**
     * @var bool
     */
    private $isFound = false;

    /**
     * @var bool
     */
    private bool $isError = false;

    /**
     * @var string
     */
    private string $errorMessage = '';

    /**
     * Constructor
     *
     * @param string|null $baseDir Base directory to search in
     */
    public function __construct(?string $baseDir = null) {
        $this->baseDir = $baseDir ?: '';
    }

    /**
     * Return if result was found
     *
     * @return bool
     */
    public function isFound(): bool {
        return $this->isFound;
    }

    /**
     * Returns formatted microtime
     *
     * @return float
     */
    private function getFormattedMicrotime(): float {
        [$usec, $sec] = explode(' ', microtime());
        return ((float)$usec + (float)$sec);
    }

    /**
     * Sanitize the search keyword
     *
     * @param string $keyword Raw keyword from user input
     * @return string Sanitized keyword
     */
    private function sanitizeKeyword(string $keyword): string {
        $keyword = is_string($keyword) ? trim($keyword) : '';
        $keyword = str_ireplace(['\\', ':', '../', '%00'], '', $keyword);
        $keyword = str_ireplace(['(', ')', '[', ']'], ['\(', '\)', '\[', '\]'], $keyword);

        // Remove unexpected characters if length more than 255 symbols
        $detect_encoding = function_exists("mb_detect_encoding") ? mb_detect_encoding($keyword) : 'ASCII';
        if ($detect_encoding == 'ASCII') {
            $keyword = substr($keyword, 0, 255);
        } else {
            $keyword = mb_substr($keyword, 0, 255, 'UTF-8');
        }

        return $keyword;
    }

    /**
     * Recursively searches for files in directory and subdirectories
     *
     * @param string $dir Directory to search in
     * @return void
     */
    private function listFiles($dir): void {
        if ($this->keyword == '' || strlen($this->keyword) < 3 || in_array($this->keyword, $this->ignoredWords)) {
            return;
        }

        if (!is_dir($dir) || !($handle = opendir($dir))) {
            return;
        }

        while (false !== ($file = readdir($handle))) {

            if ($file == '.' || $file == '..' || strstr($file, '-js.php')) continue;

            $path = $dir . '/' . $file;

            // If it's a directory, recursively search it
            if (is_dir($path)) {
                $this->listFiles($path);
                continue;
            }

            if (count($this->results) >= self::MAX_SEARCH_RESULTS) {
                return;
            }

            // Only process PHP files
            if (preg_match('/\.php/i', $file)) {
                $data = file_get_contents($path);
                $stripedBody = strip_tags($data);

                if (preg_match('/' . preg_quote($this->keyword) . '/i', $stripedBody)) {
                    if (preg_match('/<h2(.*)>(.*)<\/h2>/s', $data, $m)) {
                        $title = $m[2] ?? 'No Title';
                    } elseif (preg_match('/<h1(.*)>(.*)<\/h1>/s', $data, $m)) {
                        $title = $m[2] ?? 'No Title';
                    } else {
                        $title = 'No Title';
                    }

                    $resultText = substr(str_replace([$title, '¶'], '', $stripedBody), 0, 500);

                    // Store relative path from base directory
                    $rel_path = str_replace([$this->baseDir, '.php'], [''], $path);
                    $this->results[] = $rel_path . '##' . $title . '##' . $resultText;
                }
            }
        }

        closedir($handle);
    }

    /**
     * Perform search with the given keyword
     *
     * @param string $keyword Keyword to search for
     * @return SearchPages Returns self for method chaining
     */
    public function search(string $keyword): self {
        if (strlen($keyword) > 100){
            $this->keyword = '';
            $this->isFound = false;
            $this->isError = true;
            $this->errorMessage = 'Search string is too long, should be 100 characters maximum.';
            return $this;
        }

        $this->keyword = $this->sanitizeKeyword($keyword);
        $this->results = [];

        $this->startTime = $this->getFormattedMicrotime();
        $this->listFiles($this->baseDir);
        $this->finishTime = $this->getFormattedMicrotime();

        return $this;
    }

    /**
     * Get number of search results
     *
     * @return int
     */
    public function getResultCount(): int {
        return count($this->results);
    }

    /**
     * Get raw search results
     *
     * @return array
     */
    public function getRawResults(): array {
        return $this->results;
    }

    /**
     * Get search execution time
     *
     * @return float
     */
    public function getExecutionTime(): float {
        return round((float)$this->finishTime - (float)$this->startTime, 5);
    }

    /**
     * Get formatted HTML search results
     *
     * @param callable|null $humanizeFunction Function to humanize breadcrumb parts
     * @return string HTML results
     */
    public function getFormattedResults($humanizeFunction = null): string {
        $result = '';
        $resultnum = $this->getResultCount();

        if (!empty($this->results)) {
            $this->isFound = true;

            $keyword_display = htmlentities(str_ireplace(['\(', '\)', '\[', '\]'], ['(', ')', '[', ']'], $this->keyword));
            $result .= '<br>Found ' . $resultnum . ' results for: <i>' . $keyword_display . '</i>';
            $result .= '<br>Total running time: ' . $this->getExecutionTime() . ' sec.';
            $result .= '<br><br>';

            $result .= '<ul class="search-result">';
            foreach ($this->results as $value) {
                [$filedir, $title, $resultText] = explode('##', $value, 3);

                // Highlight text
                $resultText = preg_replace('@(' . $this->keyword . ')@si', '<strong style="background-color:yellow">$1</strong>', $resultText);

                $result .= '<li style="margin-bottom:20px">';
                $result .= '<a href="' . $filedir . '" target="_blank" rel="noopener noreferrer">' . $title . '</a>';

                // Prepare breadcrumbs
                $filedirParts = explode('/', $filedir);
                if ($filedirParts) {
                    $breadcrumbs = '<br>';
                    foreach ($filedirParts as $part) {
                        if (empty($part)) {
                            continue;
                        }
                        $humanizedPart = is_callable($humanizeFunction) ? call_user_func($humanizeFunction, $part) : $part;
                        $breadcrumbs .= $humanizedPart . ' / ';
                    }
                    $result .= '<i>' . trim($breadcrumbs, ' / ') . '</i>';
                }

                $result .= '<br>' . $resultText . '...</li>' . "\n";
            }
            $result .= '</ul>';
        } elseif ($this->isError) {
            $result .= '<br><i class="text-danger">' . $this->errorMessage . '</i>';
        } elseif ($this->keyword) {
            $result .= '<br>No results found for: <i>' . htmlspecialchars($this->keyword) . '</i>';
        }

        return $result;
    }
}

