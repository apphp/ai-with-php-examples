<?php

$section = !empty($section) ? htmlspecialchars($section) : '';
$subSection = !empty($subSection) ? htmlspecialchars($subSection) : '';
$page = $page ?? 'index';

$menu = include('menu.php');

?>
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar overflow-auto">
    <div class="position-sticky pt-3">
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
</nav>
