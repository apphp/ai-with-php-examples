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
