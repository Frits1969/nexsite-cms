<?php
require_once __DIR__ . '/app/Config.php';
require_once __DIR__ . '/app/Database.php';

use NexSite\Database;
use NexSite\Config;

// Load config
\NexSite\Config::load(__DIR__ . '/.env');

$db = Database::connect();
$prefix = Database::getPrefix();

$sql = "CREATE TABLE IF NOT EXISTS {$prefix}pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content LONGTEXT,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slug (slug),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

if ($db->query($sql)) {
    echo "Table {$prefix}pages created successfully.\n";
} else {
    echo "Error creating table: " . $db->error . "\n";
    exit(1);
}
