<?php
// logout.php
session_start();

if (empty($_SESSION['klantnr']))
	echo "<p>U bent uitgelogd.</p>";
else 
	unset($_SESSION['klantnr']);

if (empty($_SESSION['klantnaam']))
	echo "<p>U ben nu uitgelogd.</p>";
else 
	unset($_SESSION['klantnaam']);

// Direct door naar de homepagina.
header("Location: index.php"); ;

?> 
