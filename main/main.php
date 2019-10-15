<?php
session_start();
include 'db/connect.php';
include 'config/const.php';
include 'config/pages.php';
include 'config/functions.php';

$msg = '';
if (!empty($_SESSION[MSG])) {
    $msg = $_SESSION[MSG];
    unset($_SESSION[MSG]);
}

$count = empty($_SESSION[PRODUCTS]) ? 0 : count($_SESSION[PRODUCTS]);

if (!empty($_SESSION[USER_ID]) && (bool)$_SESSION[IS_ADMIN]) {
    $html_tmpl = file_get_contents(__DIR__ . '/mainAdmin.tmpl');
} else {
    $html_tmpl = file_get_contents(__DIR__ . '/main.tmpl');
}

echo str_replace(['{CONTENT}', '{MSG}', '{COUNT}'], [$html, $msg, $count], $html_tmpl);