<?php
//
// index.php
// Dit is het startscherm van de webwinkel.
//

// Zet het niveau van foutmeldingen zo dat warnings niet getoond worden.
error_reporting(E_ERROR | E_PARSE);

// Zet de titel en laad de HTML header uit het externe bestand.
$page_title = 'Welkom in de WebWinkel';
$active = 1;	// Zorgt ervoor dat header.html weet dat dit het actieve menu-item is.
include ('includes/header.html');

// mysqli_connect.php bevat de inloggegevens voor de database.
// Per server is er een apart inlogbestand - localhost vs. remote server
include ('includes/mysqli_connect_'.$_SERVER['SERVER_NAME'].'.php');

echo '<h1>Welkom in de WebWinkel';

// Print aangepast welkomstbericht wanneer de gebruiker bekend is.
if (isset($_SESSION['klantnaam'])) 
	echo ", ".$_SESSION['klantnaam']."</h1>";
else echo "</h1>\n";	

?>

<html>
<div class="flex">
	<div class="paragraph-right">
		<h2>Waarom GBS Solutions?</h2>
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem placeat veniam voluptas ullam veritatis quo cupiditate. Exercitationem veniam ipsum voluptas architecto reiciendis dolores odio inventore? Ratione recusandae expedita fugit quia.</p>
	</div>
    <div style="flex: 1;">
        
		
		<ul>
		<li>Bij GBS Solutions combineren we onze diepgaande expertise op het gebied van luchtreinigingstechnologie met een toewijding aan innovatie en klanttevredenheid. Ons ervaren team van ingenieurs, technici en luchtkwaliteitsspecialisten staat klaar om op maat gemaakte oplossingen te bieden die voldoen aan de unieke behoeften en specificaties van onze klanten.</li>
</ul>
		<h2>Waar staan wij voor?</h2>
		<ul>
		<li><strong>Technologische Innovatie:</strong></li>
		<li>Vooroplopen in luchtreinigingstechnologie met electrostatische filters.</li>
		<li><strong>Klantgerichtheid:</strong></li>
		<li>Actief luisteren naar klantbehoeften en oplossingen bieden.</li>
		<li><strong>Kwaliteit en Betrouwbaarheid:</strong></li>
		<li>Hoogwaardige producten en betrouwbaarheid gegarandeerd.</li>
		<li><strong>Partnerschap en Samenwerking:</strong></li>
		<li>Langdurige relaties gebouwd op vertrouwen en succesvolle samenwerkingen.</li>
		</ul>

		<p>Bij GBS Solutions zijn we toegewijd aan het leveren van hoogwaardige luchtkwaliteitsoplossingen die een positieve impact hebben op mensen, bedrijven en gemeenschappen over de hele wereld. Neem vandaag nog contact met ons op en ontdek hoe we jou kunnen helpen om een schone en gezonde luchtomgeving te creëren voor jouw bedrijf.</p>
</html>
</style>
</head>
<body>

<?php	
	include ('includes/footer.html');
?>
