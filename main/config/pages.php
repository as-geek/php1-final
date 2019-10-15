<?php
$page = !empty($_GET['p']) ? $_GET['p'] : 'index';
$function = !empty($_GET['f']) ? $_GET['f'] : 'index';

$dir = dirname(__DIR__);
if (!file_exists($dir . '/' . PAGES . $page . '.php' )) {
    $page = 'index';
}
include ($dir . '/' . PAGES . $page . '.php');
if (!function_exists($function)) {
    $function = 'index';
}

$html = $function();