<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

// Jika file yang diminta ada, tampilkan langsung (misal: gambar, css)
if (php_sapi_name() === 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__.'/public'.$url['path'];
    if (is_file($file)) {
        return false;
    }
}

// Jalankan aplikasi dari public/index.php
require_once __DIR__.'/public/index.php';