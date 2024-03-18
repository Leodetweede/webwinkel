<?php
//
// beheer.php
//

// Zet het niveau van foutmeldingen zo dat warnings niet getoond worden.
error_reporting(E_ERROR | E_PARSE);

// Zet de titel en laad de HTML header uit het externe bestand.
$page_title = 'Welkom in de WebWinkel';
$active = 4;	// Zorgt ervoor dat header.html weet dat dit het actieve menu-item is.
include ('includes/header.html');
?>
<h1>Beheer</h1>
<p>
Deze pagina maakt het mogelijk om klanten en afgeronde bestellingen in te zien, en 
om producten aan de winkel toe te voegen, te wijzigen of te verwijderen.
</p>

<p><a href="">Klanten beheren</a></p>
<p><a href="bestellingenbeheer.php">Bestellingen beheren</a></p>
<p><a href="">Producten beheren</a></p>

		
<?php
include ('includes/footer.html');
?>