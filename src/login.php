<?php
$head_html = file_get_contents('./view/html/templates/head.html');

// Replace any variables in the html files.
$head_html = str_replace('{title}', 'Login: Spotify', $head_html);
$head_html = str_replace('{css2}', './view/css/login.css', $head_html);

// BODY HTML 
$login_html = file_get_contents('./view/html/login.html');
$foot_html = file_get_contents('./view/html/templates/foot.html');

// Echo the login page.
echo $head_html;
echo $login_html;
echo '<script src="./view/js/login.js"></script>';
echo $foot_html;
?>