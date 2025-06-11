<?php

namespace app\classes\pages;

class SearchPages {
    /**
     * Maximum number of search results to return
     */
    private const MAX_SEARCH_RESULTS = 25;

    /**
     * Maximum recursion depth
     */
    private const MAX_DEPTH = 5;

    /**
     * Maximum number of files to process
     */
    private const MAX_PROCESSED_FILES = 1000;

    /**
     * Number of bytes in MB
     */
    private const BYTES_IN_MB = 1048576;

    /**
     * Base directory to search in
     * @var string
     */
    private string $baseDir;

    /**
     * Search keyword
     * @var string
     */
    private string $keyword = '';

    /**
     * Search results array
     * @var array
     */
    private array $results = [];

    /**
     * Start time of search
     * @var float
     */
    private float $startTime;

    /**
     * Finish time of search
     * @var float
     */
    private float $finishTime;

    /**
     * Words to ignore in search
     * @var array
     */
    private array $ignoredWords = ['on', 'for', 'a', 'in', 'the', 'this'];

    /**
     * @var bool
     */
    private bool $isFound = false;

    /**
     * @var bool
     */
    private bool $isError = false;

    /**
     * @var string
     */
    private string $errorMessage = '';

    /**
     * @var int
     */
    private int $processedFiles = 0;

    /**
     * Constructor
     *
     * @param string|null $baseDir Base directory to search in
     */
    public function __construct(?string $baseDir = null) {
        $this->baseDir = $this->sanitizeBaseDir($baseDir);
    }

    /**
     * Sanitize the base directory
     *
     * @param string|null $baseDir
     * @return string
     */
    private function sanitizeBaseDir(?string $baseDir): string {
        $baseDir = is_string($baseDir) ? trim($baseDir) : '';
        $baseDir = rtrim($baseDir, '/') . '/';

        // Add validation
        if (!is_dir($baseDir) || !is_readable($baseDir)) {
            $this->isError = true;
            $this->errorMessage = 'Invalid or inaccessible base directory';
            return '';
        }

        return $baseDir;
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
        // Removing spaces and other hidden characters
        $keyword = trim($keyword);

        // Apply a whitelist approach - only allow alphanumeric and some safe characters
        $keyword = preg_replace('/[^a-zA-Z0-9\s\-_\'\,\:\.]/', '', $keyword);

        // Limit keyword length
        $keyword = substr($keyword, 0, 100);

        return $keyword;
    }

    /**
     * Recursively searches for files in directory and subdirectories
     *
     * @param string $dir Directory to search in
     * @param int $depth
     * @return void
     */
    private function listFiles($dir, $depth = 0): void {
        $realBase = realpath($this->baseDir);
        $realPath = is_dir($dir) ? realpath($dir) : false;

        // Limit access to not real paths
        if (empty($realBase) || !$realPath || strpos($realPath . DIRECTORY_SEPARATOR, $realBase . DIRECTORY_SEPARATOR) !== 0) {
            return;
        }

        // Limit recursive search depth
        if ($depth > self::MAX_DEPTH) {
            return;
        }

        if ($this->keyword == '' || strlen($this->keyword) < 3 || in_array($this->keyword, $this->ignoredWords)) {
            return;
        }

        if (!is_dir($dir) || !($handle = opendir($dir))) {
            $this->isError = true;
            $this->errorMessage = 'Cannot open directory: ' . basename($dir);
            return;
        }

        while (false !== ($file = readdir($handle))) {

            if ($file == '.' || $file == '..' || preg_match('/-js\.php$/', $file)) {
                continue;
            }

            $path = $dir . '/' . $file;

            // If it's a directory, recursively search it
            if (is_dir($path)) {
                $this->listFiles($path, $depth + 1);
                continue;
            }

            if (count($this->results) >= self::MAX_SEARCH_RESULTS || $this->processedFiles >= self::MAX_PROCESSED_FILES) {
                return;
            }

            // Only process PHP files
            if (preg_match('/\.php$/i', $file)) {
                $data = $this->readFileContents($path);

                if ($data === null) {
                    continue; // Skip unreadable files
                }

                $stripedBody = strip_tags($data);

                if (stripos($stripedBody, $this->keyword) !== false) {
                    if (preg_match('/<h2(.*)>(.*)<\/h2>/s', $data, $m)) {
                        $title = htmlspecialchars($m[2] ?? 'No Title', ENT_QUOTES, 'UTF-8');
                    } elseif (preg_match('/<h1(.*)>(.*)<\/h1>/s', $data, $m)) {
                        $title = htmlspecialchars($m[2] ?? 'No Title', ENT_QUOTES, 'UTF-8');
                    } else {
                        $title = 'No Title';
                    }

                    $resultText = substr(str_replace([$title, '¶'], '', $stripedBody), 0, 500);

                    // Store relative path from base directory
                    $rel_path = str_replace([$this->baseDir, '.php'], [''], $path);
                    $this->results[] = $rel_path . '##' . $title . '##' . $resultText;
                    $this->processedFiles++;
                }
            }
        }

        closedir($handle);
    }

    /**
     * Read file contents with error handling
     *
     * @param string $path
     * @return string|null
     */
    private function readFileContents($path): ?string {
        if (!file_exists($path)) {
            $this->isError = true;
            $this->errorMessage = "File does not exist: $path";
            return null;
        }

        if (!is_readable($path) || strpos(realpath($path), realpath($this->baseDir)) !== 0) {
            $this->isError = true;
            $this->errorMessage = "File is not readable or outside of base directory: $path";
            return null;
        }

        if (filesize($path) > self::BYTES_IN_MB) { // 1MB limit
            $this->isError = true;
            $this->errorMessage = "File too large: $path";
            return null;
        }

        $content = '';
        $handle = fopen($path, 'r');
        if ($handle) {
            while (!feof($handle)) {
                $content .= fgets($handle, 4096);
                if (strlen($content) > self::BYTES_IN_MB) { // Stop if content exceeds 1MB
                    $this->isError = true;
                    $this->errorMessage = "File content too large: $path";
                    fclose($handle);
                    return null;
                }
            }
            fclose($handle);
        }
        return $content;
    }

    /**
     * Perform search with the given keyword
     *
     * @param string $keyword Keyword to search for
     * @return SearchPages Returns self for method chaining
     */
    public function search(string $keyword): self {
        if (empty(trim($keyword))) {
            $this->isError = true;
            $this->errorMessage = 'Search keyword cannot be empty.';
            return $this;
        }

        if (strlen($keyword) > 100) {
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
        if (!is_string($this->keyword)) {
            $this->keyword = '';
        }

        $result = '';
        $resultnum = $this->getResultCount();

        if (!empty($this->results)) {
            $this->isFound = true;

            $safeKeyword = htmlspecialchars($this->keyword, ENT_QUOTES, 'UTF-8');
            $keywordDisplay = htmlentities(str_ireplace(['\(', '\)', '\[', '\]'], ['(', ')', '[', ']'], $safeKeyword));
            $result .= '<br>Found ' . $resultnum . ' results for: <i>' . $keywordDisplay . '</i>';
            $result .= '<br>Total running time: ' . $this->getExecutionTime() . ' sec.';
            $result .= '<br><br>';

            $result .= '<ul class="search-result">';
            foreach ($this->results as $value) {
                [$filedir, $title, $resultText] = explode('##', $value, 3);

                // Highlight text
                $resultText = preg_replace('@(' . preg_quote($safeKeyword, '/') . ')@si', '<strong class="bg-yellow">$1</strong>', htmlspecialchars($resultText, ENT_QUOTES, 'UTF-8'));

                $result .= '<li style="margin-bottom:20px">';
                $result .= '<a href="' . trim(APP_URL, '/') . htmlspecialchars($filedir, ENT_QUOTES, 'UTF-8') . '" target="_blank" rel="noopener noreferrer">' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</a>';

                // Prepare breadcrumbs
                $filedirParts = explode('/', $filedir);
                if ($filedirParts) {
                    $breadcrumbs = '<br>';
                    foreach ($filedirParts as $part) {
                        if (empty($part)) {
                            continue;
                        }
                        $humanizedPart = is_callable($humanizeFunction) ? call_user_func($humanizeFunction, $part) : $part;
                        $breadcrumbs .= htmlspecialchars($humanizedPart, ENT_QUOTES, 'UTF-8') . ' / ';
                    }
                    $result .= '<i>' . trim($breadcrumbs, ' / ') . '</i>';
                }

                $result .= '<br>' . $resultText . '...</li>' . "\n";
            }
            $result .= '</ul>';
        } elseif ($this->isError) {
            $result .= '<br><i class="text-danger">' . $this->errorMessage . '</i>';
        } elseif ($this->keyword) {
            $result .= '<br>No results found for: <i>' . htmlspecialchars(str_ireplace(['&#39;', '&#34;'], ["'", '"'], $this->keyword), ENT_QUOTES, 'UTF-8') . '</i>';
        }

        return $result;
    }
}
