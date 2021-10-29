<?php
session_start();
if (!isset($_SESSION['submit'])) {
    header('Location:login');
    // var_dump($_SESSION['submit']);
}