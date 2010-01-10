<?php
include 'Auth.php';

use rmtools as rm;
session_name('_rmtools_');
session_start();

if (!isset($_SESSION['username'])) {
	$username = $password = FALSE;

	if (isset($_POST['username'])) {
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);
		
		// Set magic cookie if login information is available
		if ($password && $username) {
			setcookie(
				"MAGIC_COOKIE",
				base64_encode("$username:$password"),
				time()+3600*24*12,
				'/',
				'.php.net',
				false, // Secure
				true   // HTTP Only
			);
		}
	}

	// Preserve information previously set in magic cookie if available
	if (isset($_COOKIE['MAGIC_COOKIE']) && !isset($_POST['user']) && !isset($_POST['pw'])) {
		list($user, $password) = explode(":", base64_decode($_COOKIE['MAGIC_COOKIE']), 2);
	}

	if (!$username || !$password || !rm\Auth::login($username, $password)) {
		$title = 'login';
		include TPL_PATH . '/header.php';
		include TPL_PATH . '/login.php';
		include TPL_PATH . '/footer.php';
		exit();
	}
	$_SESSION['username'] = $username;
	$_SESSION['time'] = time();
}
$username = $_SESSION['username'];