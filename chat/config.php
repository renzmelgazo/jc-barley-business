<?php

require_once "../config/database.php";

function db()
{
    global $conn;
    return $conn;
}