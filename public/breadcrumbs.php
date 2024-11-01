<?php
    $section = $section ?? '';
    $page = $page ?? 'index';
?>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <?php if($section): ?>
            <li class="breadcrumb-item"><a href="index.php?section=<?=$section?>&page=index"><?= ucwords($section); ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= ucwords(str_ireplace('-', ' ', $page)); ?></li>
        <?php else: ?>
            <li class="breadcrumb-item active" aria-current="page">Getting Started</li>
        <?php endif; ?>
    </ol>
</nav>
