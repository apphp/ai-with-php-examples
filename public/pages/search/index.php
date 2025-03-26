<?php
    const MAX_SEARCH_RESULTS = 25;

    /**
     * Returns formatted microtime
     * @return float
     */
    function wscGetFormattedMicrotime() {
        [$usec, $sec] = explode(' ', microtime());
        return ((float)$usec + (float)$sec);
    }

    /**
     * Recursively searches for files in directory and subdirectories
     * @param string $dir Directory to search in
     * @param string $keyword Keyword to search for
     * @param array &$array Results array
     * @return bool
     */
    function listFiles($dir, $keyword, &$array) {
        $ignored_words = ['on', 'for', 'a', 'in', 'the', 'this'];

        if ($keyword == '' || strlen($keyword) < 3 || in_array($keyword, $ignored_words)) {
            return false;
        }

        if (!is_dir($dir) || !($handle = opendir($dir))) {
            return false;
        }

        while (false !== ($file = readdir($handle))) {
            if ($file == '.' || $file == '..' || strstr($file, '-js.php')) continue;

            $path = $dir . '/' . $file;

            // If it's a directory, recursively search it
            if (is_dir($path)) {
                listFiles($path, $keyword, $array);
                continue;
            }

            if (count($array) >= MAX_SEARCH_RESULTS) {
                return false;
            }

            // Only process PHP files
            if (preg_match('/\.php/i', $file)) {
                $data = file_get_contents($path);
                $stripedBody = strip_tags($data);

                if (preg_match('/' . preg_quote($keyword) . '/i', $stripedBody)) {
                    if (preg_match('/<h2(.*)>(.*)<\/h2>/s', $data, $m)) {
                        $title = $m[2] ?? 'No Title';
                    } elseif (preg_match('/<h1(.*)>(.*)<\/h1>/s', $data, $m)) {
                        $title = $m[2] ?? 'No Title';
                    } else {
                        $title = 'No Title';
                    }

                    $resultText = substr(str_replace([$title, '¶'], '', $stripedBody), 0, 500);

                    // Store relative path from base directory
                    $rel_path = str_replace([__DIR__ . '/../', '.php'], [''], $path);
                    $array[] = $rel_path . '##' . $title . '##' . $resultText;
                }
            }
        }

        closedir($handle);
        return true;
    }

    $array = [];
    $keyword = isset($_GET['s']) && is_string($_GET['s']) ? trim($_GET['s']) : '';
    $keyword = str_ireplace(['\\', ':', '../', '%00'], '', $keyword);
    $keyword = str_ireplace(['(', ')', '[', ']'], ['\(', '\)', '\[', '\]'], $keyword);

    // Remove unexpected characters if length more than 255 symbols
    $detect_encoding = function_exists("mb_detect_encoding") ? mb_detect_encoding($keyword) : 'ASCII';
    if ($detect_encoding == 'ASCII') {
        $keyword = substr($keyword, 0, 255);
    } else {
        $keyword = mb_substr($keyword, 0, 255, 'UTF-8');
    }

    $startTime = wscGetFormattedMicrotime();
    listFiles(__DIR__ . '/../', $keyword, $array);
    $finishTime = wscGetFormattedMicrotime();

    $resultnum = count($array);
    $result = '';
    $found = false;

    if (!empty($array)) {
        $result .= '<br>Found ' . $resultnum . ' results for: <i>' . htmlentities(str_ireplace(['\(', '\)', '\[', '\]'], ['(', ')', '[', ']'], $keyword)) . '</i>';
        $result .= '<br>Total running time: ' . round((float)$finishTime - (float)$startTime, 5) . ' sec.';
        $result .= '<br><br>';

        $result .= '<ul class="search-result">';
        foreach ($array as $value) {
            [$filedir, $title, $resultText] = explode('##', $value, 3);

            // Highlight text
            $resultText = preg_replace('@(' . $keyword . ')@si', '<strong style="background-color:yellow">$1</strong>', $resultText);

            $result .= '<li style="margin-bottom:20px">';
            $result .= '<a href="' . $filedir . '" target="_blank" rel="noopener noreferrer">' . $title . '</a>';

            // Prepare breadcrumbs
            $filedirParts = explode('/', $filedir);
            if($filedirParts){
                $breadcrumbs = '<br>';
                foreach ($filedirParts as $part) {
                    if(empty($part)){
                        continue;
                    }
                    $breadcrumbs .= humanize($part) . ' / ';
                }
                $result .= '<i>' . trim($breadcrumbs, ' / ') . '</i>';
            }

            $result .= '<br>' . $resultText . '...</li>' . "\n";
        }
        $result .= '</ul>';

        $found = true;
    } elseif ($keyword) {
        $result .= '<br>No results found for: <i>' . htmlspecialchars($keyword) . '</i>';
    } else {
        $result .= '';
    }

?>

<div>
    <?= $result; ?>
</div>

<?php if (!$keyword || !$found): ?>
    <div class="search-container-page col-lg-4 offset-lg-4">
        <p class="mb-1">Enter text or keyword to search</p>
        <form action="<?= create_href('search', 'index')?>" method="get">
            <div class="input-group mb-3">
                <input type="text" name="s" maxlength="100" class="form-control" placeholder="Search..." aria-label="Search" autofocus>
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
    </div>
<?php endif; ?>
