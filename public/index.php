<?php
    include('include/global.php');
    include('include/functions.php');
    include('include/Chart.php');
    $menu = include_once('include/menu.php');

    $section = !empty($_GET['section']) ? $_GET['section'] : '';
    $subSection = !empty($_GET['subsection']) ? $_GET['subsection'] : '';
    $page = $_GET['page'] ?? 'home';
    $sideBar = $_COOKIE['sidebar'] ?? '';
    $darkSwitch = $_COOKIE['darkSwitch'] ?? '';

    $dataTheme = $darkSwitch === 'dark' ? ' data-theme="dark"' : '';

    // Check if the current page is valid; if not, set default values
    if (!is_valid_page($menu, $section, $subSection, $page)) {
        $section = '';
        $subSection = '';
        $page = 'home';

        header('location: index.php');
        exit;
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Artificial Intelligence with PHP</title>
    <link rel="icon" type="image/webp" href="favicon.webp">

    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/dist/css/dark-mode.css" rel="stylesheet">
    <link href="assets/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/dist/css/all.min.css" crossorigin="anonymous">
    <script src="assets/dist/js/chart.js"></script>
    <script src="assets/dist/js/plotly-latest.min.js"></script>
    <script src="assets/dist/js/mermaid.min.js"></script>
</head>
<body<?=$dataTheme;?>>
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="index.php">AI with PHP Examples</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="form-check form-switch mt-1" title="Swith Light/Dark mode" style="width: 50px; margin-bottom: -2px !important;">
        <input type="checkbox" class="form-check-input cursor-pointer" id="darkSwitch" <?= $darkSwitch ? 'checked' : ''?>>
        <label class="custom-control-label" for="darkSwitch"></label>
    </div>

    <!--    <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">-->
<!--    <div class="navbar-nav">-->
<!--        <div class="nav-item text-nowrap">-->
<!--            <a class="nav-link px-3" href="#"></a>-->
<!--        </div>-->
<!--    </div>-->
</header>

<div class="container-fluid">
    <div class="row">
        <?php include('include/navbar.php'); ?>

        <main id="main" class="<?= $sideBar === 'collapsed' ? 'col-md-12 col-lg-12 expanded' : 'col-md-9 col-lg-10'; ?> ms-sm-auto px-md-4 pt-3 pb-4">
            <?php include('include/breadcrumbs.php'); ?>

            <?php include('pages/'.($section ? $section . '/' : '').($subSection ? $subSection . '/' : '').$page.'.php'); ?>
        </main>
    </div>
</div>

<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/dist/js/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="assets/dashboard.js"></script>
<script src="assets/dist/js/dark-mode-switch.js"></script>

</body>
</html>
