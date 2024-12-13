<?php
// .htaccess alternative - place this in index.php
declare(strict_types=1);

if (APP_SEO_LINKS) {
    // Get the request URI
    $requestUri = $_SERVER['REQUEST_URI'];

    // Remove query string if present
    $path = parse_url($requestUri, PHP_URL_PATH);

    // Remove leading/trailing slashes and split
    $segments = array_filter(explode('/', trim($path, '/')));

    // Map segments to parameters
    $_GET['section'] = $segments[0] ?? '';

    if (count($segments) === 3) {
        $_GET['subsection'] = $segments[1] ?? '';
        $_GET['page'] = $segments[2] ?? '';
    } elseif (count($segments) === 2) {
        $_GET['subsection'] = '';
        $_GET['page'] = $segments[1] ?? '';
    } else {
        $_GET = [];
    }
}
