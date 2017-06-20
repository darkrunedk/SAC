<?php require_once('classes/SteamTracker.php'); ?>
<?php require_once('locale/localization.php'); ?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">
<head>
	<meta charset="utf-8" />
	<title><?php echo $lang["MENU_FAQ"] ?> - SAC</title>
	
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

<div id="container">

<nav id="menu">
	<?php require_once('includes/menu.php'); ?>
</nav>

<fieldset id="what_is_SAC">
<legend><?php echo $lang["WHAT_IS_SAC_FAQ"]; ?></legend>
<p><?php echo $lang["WHAT_IS_SAC_ANSWER"]; ?></p>
</fieldset>

<fieldset id="do_you_save_our_info">
<legend><?php echo $lang["SAVE_INFO_FAQ"]; ?></legend>
<p><?php echo $lang["SAVE_INFO_ANSWER"]; ?></p>
</fieldset>

<footer id="footer">
<p><?php echo $lang["MADE_BY"] ?> <a href="http://me.darkrune.dk/" target="_blank">DarkruneDK</a> © <?php echo date("Y"); ?> <a href="https://www.darkrune.dk/" target="_blank">Darkrune Gamer Site</a></p>
</footer>

</div>

</body>
</html>