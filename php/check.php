<?php

function checkDataValid($x, $y, $r): bool
{
    return in_array($x, array(-3, -2, -1, 0, 1, 2, 3, 4, 5), false) &&
        is_numeric($y) && $y > -5 && $y < 3 &&
        is_numeric($r) && $r >= 1 && $r <= 5;
}

//function checkDigitsAfterDot($x, $y, $r): bool
//{
//    if (is_numeric($x) && is_numeric($y) && is_numeric($r)) {
//        $xArray = explode(".", $x);
//        $yArray = explode(".", $y);
//        $rArray = explode(".", $r);
//        if ((strlen($xArray[1]) <= 14) && (strlen($yArray[1]) <= 14) && (strlen($rArray[1]) <= 14)) return true;
//    }
//    return false;
//}

function atArea($x, $y, $r): bool
{
    return
        (($x <= 0 && $y >= 0) && ($x ** 2 + $y ** 2 <= $r ** 2 / 4)) ||  // 1/4 square
        (($x <= 0 && $y <= 0) && ($x >= -$r / 2 && $y >= -$r)) ||        // rectangle
        (($x >= 0 && $y <= 0) && ($x - (1 / 2) * $y <= $r / 2));         // triangle
}

session_start();
$start = microtime(true);
date_default_timezone_set('Europe/Moscow');

$x = isset($_GET["x"]) ? $_GET["x"] : null;
$y = isset($_GET["y"]) ? str_replace(",", ".", $_GET["y"]) : null;
$r = isset($_GET["r"]) ? str_replace(",", ".", $_GET["r"]) : null;

if (!checkDataValid($x, $y, $r)) {
    http_response_code(400);
    return;
}

if (!isset($_SESSION["response"])) {
    $_SESSION["response"] = array();
}

$coordinatesAtArea = atArea($x, $y, $r);
$currentTime = date("H:i:s");
$time = round((microtime(true) - $start) * 1000, 2);
//$time = number_format(microtime(true) - $start, 10, ".", "") * 1000000;
$result = array($x, $y, $r, $currentTime, $time, $coordinatesAtArea);
array_push($_SESSION["response"], $result);

include "add_in_table.php";
