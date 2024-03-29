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
<div class="grid-layout">
	<div class="paragraph-item paragraph-item-1">
		<h2>Wie zijn wij?</h2>
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem placeat veniam voluptas ullam veritatis quo cupiditate. Exercitationem veniam ipsum voluptas architecto reiciendis dolores odio inventore? Ratione recusandae expedita fugit quia.</p>
	</div>
	<div class="paragraph-item paragraph-item-2">
		<h2>Waarom GBS Solutions?</h2>
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem placeat veniam voluptas ullam veritatis quo cupiditate. Exercitationem veniam ipsum voluptas architecto reiciendis dolores odio inventore? Ratione recusandae expedita fugit quia.</p>
	</div>
	<div class="paragraph-item paragraph-item-3">
		<h2>Waar staan wij voor?</h2>
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem placeat veniam voluptas ullam veritatis quo cupiditate. Exercitationem veniam ipsum voluptas architecto reiciendis dolores odio inventore? Ratione recusandae expedita fugit quia.</p>
	</div>
	<div class="paragraph-item paragraph-item-4">
		<h2>Waarom GBS Solutions?</h2>
		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem placeat veniam voluptas ullam veritatis quo cupiditate. Exercitationem veniam ipsum voluptas architecto reiciendis dolores odio inventore? Ratione recusandae expedita fugit quia.</p>
	</div>
    </html>
</style>
</head>
<body>

<?php	
	include ('includes/footer.html');
?>
