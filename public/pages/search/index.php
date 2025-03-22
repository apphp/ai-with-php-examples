<?php
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
            if ($file == '.' || $file == '..') continue;

            $path = $dir . '/' . $file;

            // If it's a directory, recursively search it
            if (is_dir($path)) {
                listFiles($path, $keyword, $array);
                continue;
            }

            // Only process PHP files
            if (preg_match('/\.php/i', $file)) {

                $data = file_get_contents($path);
                $body = strip_tags($data);

                if (preg_match('/' . $keyword . '/i', $body)) {
                    if (preg_match('/<h1>(.*)<\/h1>/s', $data, $m)) {
                        $title = $m['1'];
                    } else {
                        $title = 'No Title';
                    }

                    $result_text = substr(str_replace([$title, '¶'], '', $body), 0, 350);

                    // Store relative path from base directory
                    $rel_path = str_replace(__DIR__ . '/../', '', $path);
                    $array[] = $rel_path . '##' . $title . '##' . $result_text;
                }
            }
        }

        closedir($handle);
        return true;
    }

    $array = [];
    $keyword = isset($_GET['s']) ? trim($_GET['s']) : '';
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
            [$filedir, $title, $result_text] = explode('##', $value, 3);

            // Highlight text
            $result_text = preg_replace('@(' . $keyword . ')@si', '<strong style="background-color:yellow">$1</strong>', $result_text);

            $result .= '<li style="margin-bottom:20px"><a href="index.php?page=' . $filedir . '" target="_blank">' . $title . '</a><br>' . $result_text . '...</li>' . "\n";
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
        <p>Enter text or keyword to search</p>
        <form action="<?= create_href('search', 'index')?>" method="get">
            <div class="input-group mb-3">
                <input type="text" name="s" maxlength="100" class="form-control" placeholder="Search..." aria-label="Search" autofocus>
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
    </div>
<?php endif; ?>
