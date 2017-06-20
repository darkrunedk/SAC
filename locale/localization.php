<?php
session_start();
switch($_GET['lang']) {
	case "en_US":
		$_SESSION['lang'] = 'en_US';
	break;
	case "da_DK":
		$_SESSION['lang'] = 'da_DK';
	break;
	default:
		if (empty($_SESSION['lang'])) {
			$_SESSION['lang'] = 'da_DK';
		} else {
			$_SESSION['lang'] = $_SESSION['lang'];
		}
	break;
}
include_once($_SESSION['lang'] . '.php'); // include lang file
?>