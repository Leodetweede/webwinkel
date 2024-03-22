<?php
//
// categorieA.php
// Deze pagina toont de documenten uit een van de categorieën uit de webwinkel.
//

// Zet het niveau van foutmeldingen zo dat warnings niet getoond worden.
error_reporting(E_ERROR | E_PARSE);

// Zet de titel en laad de HTML header uit het externe bestand.
$page_title = 'Elektrostatische luchtfilter';
$active = 2;	// Zorgt ervoor dat header.html weet dat dit het actieve menu-item is.
include ('includes/header.html');

echo "<h1>Verbeter de luchtkwaliteit met onze Elektrostatische Luchtfilters!</h1>";
echo "<p>Op zoek naar een effectieve manier om de luchtkwaliteit binnen je bedrijf te verbeteren?</p>";

include ('includes/footer.html');
?>