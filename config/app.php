<?php
// Hitung BASE_URL secara dinamis (http/https + host + subfolder)
$https  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
$scheme = $https ? 'https' : 'http';
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
define('BASE_URL', $scheme . '://' . $_SERVER['HTTP_HOST'] . ($basePath ? $basePath : '') . '/');

function asset($path) {
  return BASE_URL . ltrim($path, '/');
}
