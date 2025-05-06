<?php
session_start();

$isAuthenticated = isset($_SESSION['user_id']);
$username = $_SESSION['username'] ?? null;
$role = $_SESSION['role'] ?? 'guest';

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
