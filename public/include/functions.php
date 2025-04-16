<?php

function running_time(float $microtimeEnd, float $microtimeStart): string {
    $timeDif = ($microtimeEnd - $microtimeStart);
    return (string)($timeDif > 0.001 ? round($timeDif, 3) : '< 0.001');
}

function memory_usage(float $endMemory, float $startMemory): string {
    $memoryUsed = $endMemory - $startMemory;
    return round($memoryUsed / 1024 / 1024, 3);
}

function ucshortwords(string $text) {
    return str_ireplace(['Llm', 'Ai ', ' Ai', ' Ml', ' For ', ' And '], ['LLM', 'AI ', ' AI', ' ML', ' for ', ' and '], $text);
}

function dd($data = [], bool $exit = false): void {
    echo '<pre>';
    print_r($data);
    echo '</pre>';

    if ($exit) {
        exit;
    }
}

function ddd($data = []): void {
    dd($data, true);
}

function humanize($data) {
    $data = str_replace(['-', '_'], ' ', $data);
    $data = ucwords($data);
    $data = str_ireplace(['Php', 'Llm', 'PHPml'], ['PHP', 'LLM', 'PHP-ML'], $data);
    return $data;
}

function array_flatten(array $array = []): array {
    $return = [];
    array_walk_recursive($array, function ($a) use (&$return) {
        $return[] = $a;
    });
    return $return;
}

function array_to_matrix(array $matrix): string {
    $result = [];

    foreach ($matrix as $row) {
        // Convert each row to a string with brackets
        $result[] = '[' . implode(', ', $row) . ']';
    }

    // Join rows with newlines
    return implode("\n", $result);
}

function array_to_vector(array $vector): string {
    return '[' . implode(', ', $vector) . ']';
}

function array_reduce_samples(array $samples, int $index): array {
    return array_map(function ($subArray) use ($index) {
        return isset($subArray[$index]) ? [$subArray[$index]] : [];
    }, $samples);
}

function verify_fields(array|string &$features, array $verificationData, array|string $defaultData): void {
    if (empty($features)) {
        $features = $defaultData;
    } else {
        if (is_array($features)) {
            foreach ($features as $feature) {
                if (!in_array($feature, $verificationData)) {
                    $features = $defaultData;
                    break;
                }
            }
        } else {
            if (!in_array($features, $verificationData)) {
                $features = $defaultData;
            }
        }
    }
}

function create_show_code_button(string $title, string $section, string $subsection, string $page): string {
    $output = '<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h2 class="h4">' . $title . '</h2>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group">
            <a href="' . create_href($section, $subsection, $page) . '" class="btn btn-sm btn-outline-primary">Show Code</a>
        </div>
    </div>
</div>';

    return $output;
}

function create_run_code_button(
    string $title,
    string $section1,
    string $subsection1,
    string $page1,
    string $buttonText1 = 'Run Code',
    string $section2 = '',
    string $subsection2 = '',
    string $page2 = '',
    string $buttonText2 = 'Run Code',
    string $section3 = '',
    string $subsection3 = '',
    string $page3 = '',
    string $buttonText3 = 'Run Code'
): string {
    $output = '<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <h2 class="h4">' . $title . '</h2>
        <div class="btn-toolbar mb-2 mb-md-0">';

        if ($section3 && $subsection3 && $page3) {
            $output .= '<div class="btn-group me-3">
                    <a href="' . create_href($section3, $subsection3, $page3) . '" class="btn btn-sm btn-outline-primary">&#9654;&nbsp; '.$buttonText3.'</a>
                </div>';
        }

        if ($section2 && $subsection2 && $page2) {
            $output .= '<div class="btn-group me-3">
                <a href="' . create_href($section2, $subsection2, $page2) . '" class="btn btn-sm btn-outline-primary">&#9654;&nbsp; '.$buttonText2.'</a>
            </div>';
        }

        $output .= '<div class="btn-group">
                <a href="' . create_href($section1, $subsection1, $page1) . '" class="btn btn-sm btn-outline-primary">&#9654;&nbsp; '.$buttonText1.'</a>
            </div>';

        $output .= '</div>
    </div>';

    return $output;
}

/**
 * @param string $datasetFile
 * @param string $title
 * @param bool $opened
 * @param string $language      php|js
 * @param string $copyButtonId
 * @return string
 */
function create_example_of_use_links(string $datasetFile = '', string $title = 'Example of use', bool $opened = false, string $language = 'php', string $copyButtonId = 'copyButton'): string {

    if ($opened) {
        $output = ($title ? '<p>' . $title . ':</p>' : '') . '
        <div class="bd-clipboard">
            <button id="'  .$copyButtonId . '" type="button" class="btn-clipboard" onclick="copyToClipboard(\''  .$copyButtonId . '\')">
            Copy
            </button>&nbsp;
        </div>';

        if ($language === 'js') {
            $output .= '<div id="'  .$copyButtonId . '-code" class="code-wrapper p-0"><pre><code id="code" class="language-javascript">' . htmlentities(file_get_contents($datasetFile)) . '</code></pre></div>';
        } else {
            $output .= '<div id="'  .$copyButtonId . '-code" class="code-wrapper"><code id="code"><span>' . highlight_file($datasetFile, true) . '</code></div>';
        }
    } else {
        $output = '
        <p class="btn btn-link px-0 py-0" id="toggleExampleOfUse" data-bs-toggle="collapse" href="#collapseExampleOfUse" role="button" aria-expanded="false" aria-controls="collapseExampleOfUse" title="Click to expand">
            ' . $title . ' <i id="toggleIcon" class="fa-regular fa-square-plus"></i>
        </p>
        <div class="collapse pb-4" id="collapseExampleOfUse">
            <div class="bd-clipboard">
                <button id="'  .$copyButtonId . '" type="button" class="btn-clipboard" onclick="copyToClipboard(\''  .$copyButtonId . '\')">Copy</button>&nbsp;
            </div>
            <div id="'  .$copyButtonId . '-code" class="code-wrapper">
                <code id="code">' . highlight_file($datasetFile, true) . '</code>
            </div>
        </div>';
    }

    return $output;
}

function create_dataset_and_test_data_links(array|string $datasetData = '', array $testData = [], bool $fullWidth = false): string {
    $output = '<p class="btn btn-link px-0 py-0 me-4" id="toggleDataset" data-bs-toggle="collapse" href="#collapseDataset" role="button" aria-expanded="false" aria-controls="collapseDataset" title="Click to expand">
        Dataset <i id="toggleIconDataset" class="fa-regular fa-square-plus"></i>
    </p>';

    if ($testData) {
        $output .= '<p class="btn btn-link px-0 py-0" id="toggleTestData" data-bs-toggle="collapse" href="#collapseTestData" role="button" aria-expanded="false" aria-controls="collapseTestData" title="Click to expand">
        Test Data <i id="toggleIconTestData" class="fa-regular fa-square-plus"></i>
        </p>';
    }

    $output .= '<div class="row">';

    if (is_array($datasetData) && empty($testData)) {
        $output .= '<div class="collapse col-md-12 ' . ($fullWidth ? 'col-lg-12' : 'col-lg-7 pe-4') . ' mb-4 pe-4" id="collapseDataset">
                <div class="card card-body pb-0">
                    <code class="gray">
            <pre>';

        foreach ($datasetData as $test) {
            $output .= $test . PHP_EOL;
        }

        $output .= '</pre>
                    </code>
                </div>
            </div>';
    } else {
        if ($datasetData) {
            $output .= '<div class="collapse col-md-12 ' . ($fullWidth ? 'col-lg-12' : 'col-lg-7 pe-4') . ' mb-4" id="collapseDataset">
                    <div class="card card-body pb-0">
                    <code id="dataset">
                        ' . highlight_file($datasetData, true) . '
                    </code>
                    </div>
                    </div>';
        }

        if ($testData) {
            $output .= '<div class="collapse col-md-12 col-lg-5 mb-4 ps-2" id="collapseTestData">
                    <div class="card card-body pb-0">
                    <code class="gray">
                    <pre>';

            foreach ($testData as $test) {
                $output .= $test . PHP_EOL;
            }

            $output .= '</pre>
                    </code>
                    </div>
                    </div>';
        }
    }

    $output .= '</div>';

    return $output;
}

function create_link(string $section, string $subsection, string $page, string $link, array $pages, string $urlSection, string $urlSubSection, string $urlPage): string {
    $active = '';
    if ($urlSection === $section && $urlSubSection === $subsection && in_array($urlPage, $pages)) {
        $active = ' active';
    }

    if (APP_SEO_LINKS) {
        $output = '<a class="nav-link' . $active . '" href="' . create_href($section, $subsection, $page) . '">';
    } else {
        $output = '<a class="nav-link' . $active . '" href="index.php?section=' . $section . '&subsection=' . $subsection . '&page=' . $page . '">';
    }
    $output .= '<span data-feather="file-text">&bull; </span>';
    $output .= '<small>' . $link . '</small>';
    $output .= '</a>';

    return $output;
}

function create_href(string $section = '', string $subsection = '', string $page = ''): string {
    if (APP_SEO_LINKS) {
        return APP_URL . ($section ? $section . '/' : '') . ($subsection ? $subsection . '/' : '') . $page;
    }

    return 'index.php?section=' . $section . '&subsection=' . $subsection . '&page=' . $page;
}

function create_form_fields(string $section, string $subsection, string $page): string {
    $output = '<input type="hidden" name="section" value="' . $section . '" />';
    $output .= '<input type="hidden" name="subsection" value="' . $subsection . '" />';
    $output .= '<input type="hidden" name="page" value="' . $page . '" />';

    return $output;
}

function create_form_features(array $features = [], array $data = [], string $fieldName = 'features', string $type = 'checkbox', int|float $step = 1, bool $precisionCompare = false, string $class = '', string $style = '', string $event = '', int $initId = 0) {
    $output = '';
    $ind = $initId;
    $type = in_array($type, ['select', 'radio', 'checkbox', 'number']) ? $type : 'checkbox';

    if ($type === 'select') {
        $output = '<select class="form-select float-start ' . $class . '" id="select_' . $fieldName . '" name="' . $fieldName . '" ' . $event . '>';
        foreach ($features as $name => $feature) {
            if (str_starts_with($name, 'group')) {
                $label = $feature['label'] ?? '';
                $options = $feature['options'] ?? [];
                $output .= '<optgroup label="[ '.$label.' ]">';
                foreach ($options as $optionName => $optionValue) {
                    $output .= '<option value="' . $optionValue . '"' . (in_array($optionValue, $data) ? ' selected' : '') . '>' . $optionName . '</option>';
                }
                $output .= '</optgroup>';
            } else {
                $output .= '<option value="' . $feature . '"' . (in_array($feature, $data) ? ' selected' : '') . '>' . $name . '</option>';
            }
        }
        $output .= '</select>';
    } else {
        $totalFeatures = count($features);
        foreach ($features as $name => $feature) {
            $ind++;

            if ($type === 'number') {
                $min = min($feature);
                $max = max($feature);
                $maxLength = 5;

                // Loop through the array and compare the values - to prevent floating-point precision issues
                $found = false;
                if ($precisionCompare) {
                    foreach ($feature as $item) {
                        if (round($item, 2) === round($data[0], 2)) {
                            $found = true;
                            break;
                        }
                    }
                } else {
                    $found = in_array($data[0], $feature);
                }

                $output .= '<div class="form-check-inline mt-2 ml-0 pl-0 ' . $class . '">
                    <input class="form-inline-number" type="number" id="inlineNumber' . $ind . '" name="' . $fieldName . '" min="' . $min . '" max="' . $max . '" oninput="javascript:if (this.value.length > this.maxLength || this.value > ' . $max . ') this.value=' . $min . ';" maxlength="' . $maxLength . '" value="' . ($found ? $data[0] : '1') . '" step="' . $step . '" style="' . ($style ?: 'min-width:50px') . '">
                    <label class="form-check-label" for="inlineNumber' . $ind . '">&nbsp;' . $name . '</label>
                    </div>';
            } elseif ($type === 'radio') {
                $output .= '<div class="form-check form-check-inline mt-2 ' . $class . '">
                    <input class="form-check-input" type="radio" id="inlineRadio' . $ind . '" name="' . $fieldName . '" value="' . $feature . '"' . (in_array($feature, $data) ? ' checked' : '') . '>
                    <label class="form-check-label" for="inlineRadio' . $ind . '">' . $name . '</label>
                    </div>';
            } else {
                // Checkbox
                $output .= '<div class="form-check form-check-inline mt-1 ' . $class . '">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox' . $ind . '" name="' . $fieldName . ($totalFeatures > 1 ? '[]' : '') . '" value="' . $feature . '"' . (in_array($feature, $data) ? ' checked' : '') . '>
                    <label class="form-check-label" for="inlineCheckbox' . $ind . '">' . $name . '</label>
                    </div>';
            }
        }
    }

    return $output;
}

function create_result_block($memoryEnd, $memoryStart, $microtimeEnd, $microtimeStart, $result = '', $showResult = true) {
    $output = '<div class="mb-1">
                <b>Result:</b>
                <span class="float-end">Memory: '.memory_usage($memoryEnd, $memoryStart).' Mb</span>
                <span class="float-end me-2">Time <span class="d-xs-hide">running:</span> '.running_time($microtimeEnd, $microtimeStart).' sec.</span>
            </div>';

    if ($showResult) {
        $output .= '<code class="code-result">
                <pre>'.$result.'</pre>
            </code>';
    }

    return $output;
}

// Function to validate the GET parameters against the $menu array
function is_valid_page(array $menu, $section, $subSection, $page): bool {
    if (!is_string($section) || !is_string($subSection) || !is_string($page)) {
        return false;
    }

    foreach ($menu as $category => $items) {
        foreach ($items as $item) {
            if (isset($item['subMenu'])) {
                foreach ($item['subMenu'] as $subItem) {
                    if ($subItem['section'] === $section && $subItem['subSection'] === $subSection && in_array($page, $subItem['permissions'])) {
                        return true;
                    }
                }
            } elseif ($item['section'] === $section && $item['subSection'] === $subSection && in_array($page, $item['permissions'])) {
                return true;
            }
        }
    }

    return false;
}
