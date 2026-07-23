<?php

// Start session only if it hasn't started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}