<?php
// checkout.php
$page_title = 'de WebWinkel';
include ('includes/header.html');

// mysqli_connect.php bevat de inloggegevens voor de database.
// Per server is er een apart inlogbestand - localhost vs. remote server
include ('includes/mysqli_connect_'.$_SERVER['SERVER_NAME'].'.php');

// Page header:
echo '<h1>Bestelling afronden</h1>';

if (empty($_SESSION['klantnr'])) {
    echo "<p>U ben nog niet ingelogd. Log eerst in om uw bestelling af te ronden.</p>\n";
} else {

	// afsluiten bestelling en bestelregel opslaan in database

	//connectie maken met database webwinkel
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	 
	// check connection
	if (mysqli_connect_errno()) {
		printf("<p><b>Fout: verbinding met de database mislukt.</b><br/>\n%s</p>\n", mysqli_connect_error());
		include ('includes/footer.html');
		exit();
	}

	// Stap 1, zet de order in de bestelling tabel
	// Een bestelling heeft ook een bestelnummer (autoincrement), besteldatum (huidege datumtijd), en status (default: open).
	$sql = "INSERT INTO bestelling (`klantnummer`) VALUES ('".$_SESSION['klantnr']."');"; 
	$result = mysqli_query($conn, $sql) or die (mysqli_error($conn)."<br>in file ".__FILE__." on line ".__LINE__);

	$bestelnr = mysqli_insert_id($conn); // insert_id geeft de id terug van het autoincrement veld - het bestelnr dus.

	// Stap 2, winkelwagen splitsen en in de database zetten
	$cart = explode("|",$_SESSION['cart']);

	foreach($cart as $products) {
		// Splits het product in stukjes: $product[x] --> x == 0 -> product id, x == 1 -> hoeveelheid
		$product = explode(",",$products);

		// Hier willen we productprijs toevoegen aan de productregel. We kunnen dan de totaalprijs berekenen.
		$sql = "INSERT INTO bestelregel (bestelnummer, productnummer, aantal_besteld) VALUES
		(".$bestelnr.", ".$product[0].", ".$product[1].")";
		$result = mysqli_query($conn, $sql) or die (mysqli_error($conn)."<br>in file ".__FILE__." on line ".__LINE__);
	}

	echo "<p>Uw bestelling is afgerond.</p>";

	// Sluit de sessie
	if(isset($_SESSION['cart']))
		unset($_SESSION['cart']);

	// Sluit de connection
	mysqli_close($conn);
}	
include ('includes/footer.html');

?> 
