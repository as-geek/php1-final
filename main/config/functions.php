<?php
function getId() {
    return (int)isset($_GET['id']) ? $_GET['id'] : 0;
}