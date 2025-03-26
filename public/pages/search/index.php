<?php

use app\classes\pages\SearchPages;

$search = new SearchPages(__DIR__ . '/../');
$keyword = isset($_GET['s']) && is_string($_GET['s']) ? $_GET['s'] : '';
$result = $search->search($keyword)->getFormattedResults('humanize');
?>

<div>
    <?= $result; ?>
</div>

<?php if (!$keyword || !$search->isFound()): ?>
    <div class="search-container-page col-lg-4 offset-lg-4">
        <p class="mb-1">Enter text or keyword to search</p>
        <form action="<?= create_href('search', 'index') ?>" method="get">
            <div class="input-group mb-3">
                <input type="text" name="s" maxlength="100" class="form-control" placeholder="Search..." aria-label="Search" autofocus>
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
    </div>
<?php endif; ?>
