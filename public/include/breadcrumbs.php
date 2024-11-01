<?php
    $section = !empty($section) ? htmlspecialchars($section) : '';
    $subSection = !empty($subSection) ? htmlspecialchars($subSection) : '';
    $page = $page ?? 'index';
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <?php if($section): ?>
            <li class="breadcrumb-item"><a href="index.php?section=<?=$section?>&page=index"><?= ucwords($section); ?></a></li>
            <?php if($subSection): ?>
                <li class="breadcrumb-item"><a href="index.php?section=<?=$section?>&subsection=<?=$subSection?>&page=index"><?= ucwords($subSection); ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active" aria-current="page"><?= ucwords(str_ireplace('-', ' ', $page)); ?></li>
        <?php else: ?>
            <li class="breadcrumb-item active" aria-current="page">Getting Started</li>
        <?php endif; ?>
    </ol>
</nav>
