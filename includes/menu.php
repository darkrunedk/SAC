<?php

echo "<ul class='main'>";
echo "<li><a href='/'>" . $lang["MENU_HOME"] . "</a></li>";
echo "<li><a href='/faq.php' title='" . $lang["MENU_FAQ_TITLE"] . "'>" . $lang["MENU_FAQ"] . "</a></li>";
echo "</ul>";
echo "<ul class='languages'>";
echo "<li><a href='?lang=da_DK'><img src='images/flags/da_DK.png' alt='Dansk' /></a></li>";
echo "<li><a href='?lang=en_US'><img src='images/flags/en_US.png' alt='English' /></a></li>";
echo "</ul>";

?>