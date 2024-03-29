<?php
//
// categorieA.php
// Deze pagina toont de documenten uit een van de categorieën uit de webwinkel.
//

// Zet het niveau van foutmeldingen zo dat warnings niet getoond worden.
error_reporting(E_ERROR | E_PARSE);

// Zet de titel en laad de HTML header uit het externe bestand.
$page_title = 'HEPA Luchtfilters';
$active = 3;    // Zorgt ervoor dat header.html weet dat dit het actieve menu-item is.
include ('includes/header.html');

echo "<h1>HEPA Luchtfilters</h1>";

// Include the HTML content from content.php
include ('Content HEPA luchtfilters.php');

include ('includes/footer.html');
?>