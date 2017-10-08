<?php require_once('classes/SteamTracker.php'); ?>
<?php require_once('locale/localization.php'); ?>
<?php

if (!empty($_GET['user'])) {
	$user = $_GET['user'];
} elseif (!empty($_POST['user'])) {
	$user = $_POST['user'];
}

if (!empty($_GET['appid'])) {
	$appid = $_GET['appid'];
} elseif (!empty($_POST['appid'])) {
	$appid = $_POST['appid'];
}

if (!empty($user) && !empty($appid)) {
	$user_int = intval($user);

	$userType = 0;
	$baseUrl = SteamTracker::getBaseUrl();

	if (strlen($user) == strlen($user_int)) {
		$url = "{$baseUrl}/profiles/{$user_int}/stats/{$appid}/achievements/?xml=1";
	} else {
		$userType = 2;
		$url = "{$baseUrl}/id/{$user}/stats/{$appid}/achievements/?xml=1";
	}

	$SteamTracker = new SteamTracker($url);
}

?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">
<head>
	<meta charset="utf-8" />
	<title><?php echo $lang["MENU_HOME"]; ?> - SAC</title>

	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>

<div id="container">

<nav id="menu">
	<?php require_once('includes/menu.php'); ?>
</nav>

<form action="" method="post" class="formular">
<h1>SAC</h1>
<div class="group">
<input type="text" name="user" id="user" placeholder="<?php echo $lang["STEAM_USER_PLACEHOLDER_TEXT"]; ?>" autocomplete="off" />
</div>
<div class="group">
<input type="text" name="appid" id="appid" placeholder="<?php echo $lang["STEAM_GAME_ID"]; ?>" autocomplete="off" />
</div>

<button type="submit"><?php echo $lang["CHECK"]; ?></button>
</form>

<?php

if (!empty($SteamTracker)) {
	if ($SteamTracker->getSuccessStatus()) {
		if ($SteamTracker->isGameSupported()) {
			echo "<div class='gameinfo' style='background-image: url(" . $SteamTracker->getGameLogo() . ");'>";

			echo "<div class='info'>";
			echo "<h2 class='game_title'><a href='{$SteamTracker->getGameLink()}' target='_blank'>{$SteamTracker->getGameName()}</h2></a>";

			if (!$SteamTracker->getTimePlayed()) {
				echo "<p>" . $lang['GAME_NOT_PLAYED_MESSAGE'] . "</p>";
			} else {
				switch($userType) {
					case 2:
						$userText = ucfirst($user);
					break;
					default:
						$userText = $lang['USER'];
					break;
				}

				$text = sprintf($lang['THE_USER_HAVE_PLAYED'], $userText, $SteamTracker->getGameName(), $SteamTracker->getTimePlayed());
				switch($_SESSION['lang']){
					case "en_US":
					break;
					default:
						$text = str_ireplace(".", ",", $text);
					break;
				}
				echo "<p>" . $text . ":</p>";
			}

			echo "</div>";

			$neededAchievements = $SteamTracker->getNeededAchievements();
			if ($neededAchievements != null) {
				foreach($neededAchievements as $achievement) {
					$icon = $achievement->iconClosed;
					$name = $achievement->name;
					$description = $achievement->description;

					echo "<div class='achievement'>";
					echo "<h3>{$name}</h3>";
					echo "<img src='{$icon}' />";
					echo "<p>{$description}</p>";
					echo "</div>";
				}

				echo "<div class='clear'></div>";

				$totalAchivements_count = count($SteamTracker->getAllAchievements());
				$neededAchievements_count = count($neededAchievements);

				$percentage = number_format(($neededAchievements_count * 100) / $totalAchivements_count, 2);

				echo "<div class='info'>";
				echo "<p>" . sprintf($lang["NEEDS"], $neededAchievements_count, $totalAchivements_count, $percentage). "</p>";
				echo "</div>";
			} else {
				echo "<div class='info error'>";
				echo "<p>" . $lang["NO_ACHIEVEMENTS_ERROR"] . "</p>";
				echo "</div>";
			}

			echo "</div>";
		} else {
			echo "<div class='info error'>";
			echo "<p>" . $lang["NO_SUPPORT_ERROR"] . "</p>";
			echo "</div>";
		}
	} else {
		echo "<div class='info error'>";
		$errorCode = $SteamTracker->getHttpCode();
		switch($errorCode) {
			case 302:
				$error = $lang["HTTP_ERROR_302"];
			break;
			default:
				$error = sprintf($lang["HTTP_ERROR"], $errorCode);
			break;
		}

		echo "<p>{$error}</p>";
		echo "</div>";
	}
}

?>

<footer id="footer">
<p><?php echo $lang["MADE_BY"] ?> <a href="http://me.darkrune.dk/" target="_blank">DarkruneDK</a> © <?php echo date("Y"); ?> <a href="https://www.darkrune.dk/" target="_blank">Darkrune Gamer Site</a></p>
</footer>
</div>

</body>
</html>
