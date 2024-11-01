<?php
    $section = !empty($section) ? htmlspecialchars($section) : '';
    $subSection = !empty($subSection) ? htmlspecialchars($subSection) : '';
    $page = $page ?? 'index';
?>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Introduction</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <?= create_link('', '', 'home', 'Getting Started', ['home'], $section, $subSection, $page); ?>
            </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Mathematics for ML</span>
            <a class="link-secondary" href="#" aria-label="Add a new report">
                <!--                        <span data-feather="plus-circle"></span>-->
            </a>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <?= create_link('mathematics', '', 'index', 'Index', ['index'], $section, $subSection, $page); ?>
            </li>
            <li class="nav-item">
                <?= create_link('mathematics', 'scalars', 'index', 'Scalars', ['index', 'scalars-run-code'], $section, $subSection, $page); ?>
            </li>
            <li class="nav-item">
                <?= create_link('mathematics', 'vectors', 'index', 'Vectors', ['index', 'vectors-run-code'], $section, $subSection, $page); ?>
            </li>
        </ul>
    </div>
</nav>
