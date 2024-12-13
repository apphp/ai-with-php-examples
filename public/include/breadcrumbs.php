
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?=create_href()?>">Home</a></li>
        <?php if($section): ?>
            <li class="breadcrumb-item"><a href="<?=create_href($section, page: 'index')?>"><?= ucwords(str_ireplace('-', ' ', $section)); ?></a></li>
            <?php if($subSection): ?>
                <li class="breadcrumb-item"><a href="<?=create_href($section, $subSection, 'index')?>"><?= ucwords(str_ireplace('-', ' ', $subSection)); ?></a></li>
            <?php endif; ?>
            <li class="breadcrumb-item active" aria-current="page"><?= ucwords(str_ireplace('-', ' ', $page)); ?></li>
        <?php else: ?>
            <li class="breadcrumb-item active" aria-current="page">Getting Started</li>
        <?php endif; ?>
    </ol>
</nav>
