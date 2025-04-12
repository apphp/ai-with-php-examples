<?php

$section = !empty($section) ? htmlspecialchars($section) : '';
$subSection = !empty($subSection) ? htmlspecialchars($subSection) : '';
$page ??= 'index';

$menu = include('menu.php');

?>

<nav id="sidebarMenu" class="<?= $sideBar === 'collapsed' ? 'col-md-1 col-lg-1 collapsed' : 'col-md-3 col-lg-2 collapse'; ?> d-md-block bg-light sidebar overflow-auto pb-4">
    <div class="position-sticky pt-3">
        <!-- Toggle Button -->
        <div id="btn-panel-close" title="<?= $sideBar === 'collapsed' ? 'Expand' : 'Collapse'; ?>">
            <svg id="svg-panel-close" class="<?= $sideBar === 'collapsed' ? 'rotate-180' : ''; ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18" preserveAspectRatio="xMidYMid meet" width="18" height="18" style="vertical-align: middle;"><g clip-path="url(#PanelLeftClose_svg__a)"><path stroke="#777" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M4.791 14.5v-13m8.653 13H2.556c-.413 0-.809-.152-1.1-.423A1.394 1.394 0 0 1 1 13.055V2.945C1 2.147 1.696 1.5 2.556 1.5h10.888c.86 0 1.556.647 1.556 1.445v10.11c0 .798-.697 1.445-1.556 1.445Z"></path><path fill="#777" d="M8.017 7.618a.4.4 0 0 0 0 .566l2.4 2.4a.4.4 0 0 0 .683-.283v-4.8a.4.4 0 0 0-.683-.283l-2.4 2.4Z"></path></g><defs><clipPath id="PanelLeftClose_svg__a"><path d="M0 0h18v18H0z"></path></clipPath></defs></svg>
        </div>

        <div id="navbar" class="<?= $sideBar === 'collapsed' ? 'nonvisible' : ''; ?>">
            <?php foreach ($menu as $category => $items): ?>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span><?= $category ?></span>
            </h6>
            <ul class="nav flex-column mb-2">
                <?php foreach ($items as $item): ?>
                    <li class="nav-item">
                        <?php if (isset($item['subMenu'])): ?>
                            <a class="nav-link nav-sub-link"><?= htmlspecialchars($item['title']) ?></a>
                            <ul class="nav flex-column">
                                <?php foreach ($item['subMenu'] as $subItem): ?>
                                    <li class="nav-item">
                                        <?= create_link(
                                            $subItem['section'],
                                            $subItem['subSection'],
                                            $subItem['page'],
                                            $subItem['title'],
                                            $subItem['permissions'],
                                            $section,
                                            $subSection,
                                            $page
                                        ); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <?= create_link(
                                $item['section'],
                                $item['subSection'],
                                $item['page'],
                                $item['title'],
                                $item['permissions'],
                                $section,
                                $subSection,
                                $page
                            ); ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
        </div>
    </div>
</nav>
