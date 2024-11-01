<?php

function running_time(float $microtimeEnd, float $microtimeStart): string {
    $timeDif = ($microtimeEnd - $microtimeStart);
    return (string)($timeDif > 0.001 ? round($timeDif, 3) : '< 0.001');
}

function create_link(string $section, string $subsection, string $page, string $link, array $pages, string $urlSection, string $urlSubSection, string $urlPage): string {
    $active = '';
    if($urlSection === $section && $urlSubSection === $subsection && in_array($urlPage, $pages)) {
        $active = ' active';
    }

    $output = '<a class="nav-link'.$active.'" href="index.php?section='.$section.'&subsection='.$subsection.'&page='.$page.'">';
    $output .= '<span data-feather="file-text"></span>';
    $output .= '<small>'.$link.'</small>';
    $output .= '</a>';

    return $output;
}
