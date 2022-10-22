<?php

// Connect to backend.
require_once './app/controller/register.php';

// get head template
$head_html = file_get_contents('./view/html/templates/head.html');

// replace head emplate variables 
$head_html = str_replace('{title}', 'Register', $head_html);
$head_html = str_replace('{css1}', './view/css/register.css', $head_html);

// get body template
$register_html = file_get_contents('./view/html/register.html');
$foot_html = file_get_contents('./view/html/templates/foot.html');

// add javascript file to the footer
$foot_html = str_replace('{js1}', './view/js/register.js', $foot_html);

// print template
echo $head_html;
echo $register_html;
echo $foot_html;
?>