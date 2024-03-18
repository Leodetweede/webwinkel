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

// mysqli_connect.php bevat de inloggegevens voor de database.
// Per server is er een apart inlogbestand - localhost vs. remote server
include ('includes/mysqli_connect_'.$_SERVER['SERVER_NAME'].'.php');

//
// bestellingenbeheer.php
//
//

// Zet het niveau van foutmeldingen zo dat warnings niet getoond worden.
error_reporting(E_ERROR | E_PARSE);

echo "<h1>Mijn bestellingen</h1>\n";
echo "<p>Deze pagina geeft een overzicht de bestellingen van deze klant.</p>";

if (!empty($_SESSION['klantnr'])) {
	$klantnr = $_SESSION['klantnr'];
} else {
	echo "<p>Er is geen klant ingelogd, daarom de gegevens van klant met klantnr 1.</p>";
	$klantnr = 1;
}

// Stap 1: maak verbinding met MySQL.
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (mysqli_connect_errno()) {
	printf("<p><b>Fout: verbinding met de database mislukt.</b><br/>\n%s</p>\n", mysqli_connect_error());
	include ('includes/footer.html');
	exit();
}

// Maak de SQL query die onze bestellingen gaat opleveren.
$sql = "SELECT `naam`, `adres`, `postcode`, `plaats`, `emailadres` FROM `klant` WHERE `klantnr`='$klantnr';"; 

// Voer de query uit en sla het resultaat op 
		// Voer de query uit en vang fouten op 
if( !($result = mysqli_query($conn, $sql)) ) {
	echo "<p>Geen resultaten gevonden.</p>\n";
} else {
	// We zoeken één klant, dus slechts één row is nodig.
	$row = mysqli_fetch_array($result);

	echo "<table>\n" ;
	echo "<tr><td>Naam</td><td>".$row["naam"]."</td></tr>\n" ;
	echo "<tr><td>Adres</td><td>".$row["adres"]."</td></tr>\n" ;
	echo "<tr><td>&nbsp;</td><td>".$row["postcode"]."&nbsp;".$row['plaats']."</td></tr>\n" ;
	echo "<tr><td>Email</td><td>".$row["emailadres"]."</td></tr>\n" ;
	echo "</table>\n" ;
}

// $sql = "SELECT productnummer, productnaam, prijs, beschrijving, leverbaar, voorraad FROM product ORDER BY productnaam"; 
// Maak de SQL query die onze bestellingen gaat opleveren.
$sql = "SELECT `bestelnummer`, `besteldatum`, `status`, `totaalprijs` FROM `bestelling` WHERE `klantnummer`='$klantnr';"; 

// Voer de query uit en vang fouten op 
if( !($result = mysqli_query($conn, $sql)) ) {
	echo "<p>Geen bestellingen gevonden.</p>\n";
} else {
	while($row = mysqli_fetch_array($result)) {
		echo "<p>Bestelnr.: ".$row["bestelnummer"].", besteldatum: ".$row["besteldatum"].", status: ".$row["status"].", totaalprijs: ".$row["totaalprijs"].".</p>";

		$sqlbestelregel = "SELECT 
			`bestelregel`.`productnummer`, 
			`product`.`productnaam`,
			`bestelregel`.`productprijs`, 
			`bestelregel`.`aantal_besteld` 
			FROM `bestelregel`, `product` 
			WHERE `bestelregel`.`bestelnummer`='".$row["bestelnummer"]."'
			GROUP BY `bestelregel`.`productnummer`;"; 
		// Voer de query uit en vang fouten op 
		if( !($regels = mysqli_query($conn, $sqlbestelregel)) ) {
			echo "<p>Geen producten gevonden.</p>\n";
		} else {
			echo "\n<table>\n<thead><th>Productnr</th><th>Productnaam</th><th>Hoeveelheid</th><th>Prijs p/s</th></tr></thead>\n<tbody>";
			while($regel = mysqli_fetch_array($regels)) {
				echo "<tr><td>".$regel["productnummer"]."</td>";
				echo "<td>".$regel["productnaam"]."</td>";
				echo "<td>".$regel["aantal_besteld"]."</td>";
				echo "<td>€ ".number_format($regel["productprijs"], 2, ',', '.')."</td></tr>\n";
			}
			echo "</tbody></table>\n" ;
		}
	}
}

/* maak de resultset leeg */
mysqli_free_result($result);

/* sluit de connection */
mysqli_close($conn);

include ('includes/footer.html');
?>