<?php

/**
 * Admin/User Password Generator
 *
 * Download a SQLite Database Browser/GUI. sqlitebrowser, Adminer single
 * PHP file database GUI/Editor, just to name a few.
 *
 * Open /path/to/slim-turbo/database/slim-turbo.db database in your favorite
 * SQLite DB Editor/GUI, Go to the users table, edit the admin account with
 * your new password. Change the e-mail, name, etc. Save and close the DB.
 *
 * Now, you can login using your own personal e-mail and password! The Admin Dashboard
 * is at http://your-site.com/admin
 *
 */

// Your Personal Password
$myPass = 'p@55w0rd1!';

// Hash Your Password...
$encPass = password_hash($myPass, PASSWORD_DEFAULT);

// Show Results
echo $encPass . "\n";
