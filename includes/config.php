<?php
/**
 * Database + site configuration.
 * Edit the DB_* values to match your MySQL server, then run /install once.
 */

// ---- Database ----
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'adyems_portfolio');
define('DB_USER', 'root');
define('DB_PASS', '');          // XAMPP default is empty
define('DB_CHARSET', 'utf8mb4');

// ---- App ----
define('APP_NAME', 'adyems');
define('UPLOAD_DIR', __DIR__ . '/../assets/uploads'); // where uploaded images go
define('UPLOAD_URL', 'assets/uploads');               // public path (relative to base)

// Show PHP errors while developing. Set to false in production.
define('APP_DEBUG', true);
