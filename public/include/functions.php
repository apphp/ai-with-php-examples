<?php

function running_time(float $microtimeEnd, float $microtimeStart): string {
    $timeDif = ($microtimeEnd - $microtimeStart);
    return (string)($timeDif > 0.001 ? round($timeDif, 3) : '< 0.001');
}
function memory_usage(float $endMemory, float $startMemory): string {
    $memoryUsed = $endMemory - $startMemory;
    return round($memoryUsed / 1024 / 1024, 3);
}

function dd($data = [], bool $exit = false) :void {
    echo '<pre>';
    print_r($data);
    echo '</pre>';

    if ($exit) {
        exit;
    }
}

function ddd($data = []) :void {
    dd($data, true);
}

function create_example_of_use_links(string $datasetFile = '') :string {
    $output = '
        <p class="btn btn-link px-0 py-0" id="toggleExampleOfUse" data-bs-toggle="collapse" href="#collapseExampleOfUse" role="button" aria-expanded="false" aria-controls="collapseExampleOfUse" title="Click to expand">
            Example of use <i id="toggleIcon" class="fa-regular fa-square-plus"></i>
        </p>
        <div class="collapse pb-4" id="collapseExampleOfUse">
            <div class="bd-clipboard">
                <button id="copyButton" type="button" class="btn-clipboard" onclick="copyToClipboard()">Copy</button>&nbsp;
            </div>
            <code id="code">';
        $output .= highlight_file($datasetFile, true);
        $output .= '
            </code>
        </div>';

    return $output;
}

function create_dataset_and_test_data_links(array|string $datasetData = '', array $testData = [], bool $fullWidth = false) :string {
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
            $output .= '<div class="collapse col-md-12 col-lg-7 mb-4 pe-4" id="collapseDataset">
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
                $output .= '<div class="collapse col-md-12 '.($fullWidth ? 'col-lg-12' : 'col-lg-7 pe-4').' mb-4" id="collapseDataset">
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

    $output = '<a class="nav-link' . $active . '" href="index.php?section=' . $section . '&subsection=' . $subsection . '&page=' . $page . '">';
    $output .= '<span data-feather="file-text">&bull; </span>';
    $output .= '<small>' . $link . '</small>';
    $output .= '</a>';

    return $output;
}

function create_href(string $section, string $subsection, string $page): string {
    return 'index.php?section=' . $section . '&subsection=' . $subsection . '&page=' . $page;
}

function create_form_fields(string $section, string $subsection, string $page): string {
    $output = '<input type="hidden" name="section" value="' . $section . '" />';
    $output .= '<input type="hidden" name="subsection" value="' . $subsection . '" />';
    $output .= '<input type="hidden" name="page" value="' . $page . '" />';

    return $output;
}

function create_form_features(array $features = [], array $data = []) {
    $output = '';
    $ind = 0;
    $value = 0;
    foreach ($features as $feature) {
        $ind++;
        $output .= '<div class="form-check form-check-inline mt-2">
            <input class="form-check-input" type="checkbox" id="inlineCheckbox'.$ind.'" name="features[]" value="'.$value.'"' . (in_array($value, $data) ? ' checked' : '') . '>
            <label class="form-check-label" for="inlineCheckbox'.$ind.'">' . $feature . '</label>
        </div>';
        $value++;
    }
    return $output;
}

// Function to validate the GET parameters against the $menu array
function is_valid_page(array $menu, $section, $subSection, $page): bool {
    if(!is_string($section) || !is_string($subSection) || !is_string($page)){
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
