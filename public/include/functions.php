<?php

function running_time(float $microtimeEnd, float $microtimeStart): string {
    $timeDif = ($microtimeEnd - $microtimeStart);
    return (string)($timeDif > 0.001 ? round($timeDif, 3) : '< 0.001');
}

function memory_usage(float $endMemory, float $startMemory): string {
    $memoryUsed = $endMemory - $startMemory;
    return round($memoryUsed / 1024 / 1024, 3);
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

function create_run_code_button(string $title, string $section, string $subsection, string $page): string {
    $output = '<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <h2 class="h4">' . $title . '</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group">
                <a href="' . create_href($section, $subsection, $page) . '" class="btn btn-sm btn-outline-primary">&#9654;&nbsp; Run Code</a>
            </div>
        </div>
    </div>';

    return $output;
}

function create_example_of_use_links(string $datasetFile = '', string $title = 'Example of use', bool $opened = false): string {

    if ($opened) {
        $output = ($title ? '<p>' . $title . ':</p>' : '') . '
        <div class="bd-clipboard">
            <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">
            Copy
            </button>&nbsp;
        </div>
        <code id="code">' . highlight_file($datasetFile, true) . '</code>';
    } else {
        $output = '
        <p class="btn btn-link px-0 py-0" id="toggleExampleOfUse" data-bs-toggle="collapse" href="#collapseExampleOfUse" role="button" aria-expanded="false" aria-controls="collapseExampleOfUse" title="Click to expand">
            ' . $title . ' <i id="toggleIcon" class="fa-regular fa-square-plus"></i>
        </p>
        <div class="collapse pb-4" id="collapseExampleOfUse">
            <div class="bd-clipboard">
                <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">Copy</button>&nbsp;
            </div>
            <code id="code">' . highlight_file($datasetFile, true) . '</code>
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

function create_form_features(array $features = [], array $data = [], string $fieldName = 'features', string $type = 'checkbox') {
    $output = '';
    $ind = 0;
    $type = $type === 'radio' ? 'radio' : 'checkbox';

    foreach ($features as $name => $feature) {
        $ind++;

        if ($type === 'radio') {
            $output .= '<div class="form-check form-check-inline mt-2">
            <input class="form-check-input" type="radio" id="inlineRadio' . $ind . '" name="' . $fieldName . '" value="' . $feature . '"' . (in_array($feature, $data) ? ' checked' : '') . '>
            <label class="form-check-label" for="inlineRadio' . $ind . '">' . $name . '</label>
            </div>';
        } else {
            $output .= '<div class="form-check form-check-inline mt-2">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox' . $ind . '" name="' . $fieldName . '[]" value="' . $feature . '"' . (in_array($feature, $data) ? ' checked' : '') . '>
            <label class="form-check-label" for="inlineCheckbox' . $ind . '">' . $name . '</label>
            </div>';
        }
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
