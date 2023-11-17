<?php
session_start();

if (isset($_SESSION["response"])) {
    $_SESSION["response"] = array();
}

include "add_in_table.php";
