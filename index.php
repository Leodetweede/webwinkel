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

// 
// Stap 1: maak verbinding met MySQL.
// Zorg ervoor dat MySQL (via XAMPP) gestart is.
//
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
 
// check connection
if (mysqli_connect_errno()) {
	printf("<p><b>Fout: verbinding met de database mislukt.</b><br/>\n%s</p>\n", mysqli_connect_error());
	include ('includes/footer.html');
	exit();
}

// Maak de SQL query die onze producten gaat opleveren. 
$sql = "SELECT 
`product`.`productnummer`, 
`product`.`productnaam`, 
`product`.`prijs`, 
`product`.`beschrijving`,
`product`.`leverbaar`, 
`product`.`voorraad`, 
`product_afbeelding`.`image_id`
FROM `product`, `product_afbeelding`
WHERE `product`.`productnummer` = `product_afbeelding`.`productnummer`
GROUP BY `productnaam`
ORDER BY `productnaam`;"; 

// Voer de query uit en sla het resultaat op 
$result = mysqli_query($conn, $sql);
	
if($result === false) {
	echo "<p>Er zijn geen producten in de winkel gevonden.</p>\n";
} else {
	$num = 0;
	$num = mysqli_num_rows($result);
	echo "<p>Er zijn ".$num." producten gevonden.</p>\n";
}

// Laat de producten zien in een form, zodat de gebruiker ze kan selecteren.
// Haal een nieuwe regel op uit het resultaat, zolang er nog regels beschikbaar zijn.
// We gebruiken in dit geval een associatief array.
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
{
	echo "<!-- ---------------------------------- -->\n";
	echo "<div id=\"product\">\n<form action=\"add.php\" method=\"post\">\n";
	echo "<input type=\"hidden\" name=\"productnummer\" value=\"".$row["productnummer"]."\" />\n";
	// echo "<div id=\"prodnummer\">".$row["productnummer"]."</div>\n";

	echo '<p><img id=\'plaatje\' src="showfile.php?image_id='.$row["image_id"].'"></p>';
	
	echo "<div id=\"prijs\">€ ".number_format($row["prijs"], 2, ',', '.')."</div>\n";
	echo "<div id=\"prodnaam\">".$row["productnaam"]."</div>\n";
	echo "<div id=\"beschrijving\">".$row["beschrijving"]."</div>\n";
	echo "<div id=\"leverbaar\">Leverbaar: ".$row["leverbaar"]."</div>\n";
	echo "<div id=\"voorraad\">Voorraad: ".$row["voorraad"]."</div>\n";
	echo "<div id=\"selecteer\">Aantal: <input type=\"text\" name=\"hoeveelheid\" size=\"2\" maxlength=\"2\" value=\"1\" />";
	echo "<input type=\"submit\" value=\"Bestel\" class=\"button\" /></div>\n";
	echo "</form>\n</div>\n";
}

/* maak de resultset leeg */
mysqli_free_result($result);

/* sluit de connection */
mysqli_close($conn);

include ('includes/footer.html');
?>