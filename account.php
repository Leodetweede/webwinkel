<?php
//index.php
//start screen of the web store

$page_title = 'Welcome to the WebStore';
$active = 4;	// Zorgt ervoor dat header.html weet dat dit het actieve menu-item is.
include ('includes/header.html');


include ('includes/mysqli_connect_'.$_SERVER['SERVER_NAME'].'.php');

echo '<h1>Jouw account</h1>';

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if (mysqli_connect_errno()) {
    displayDatabaseConnectionError();
}

if (empty($_SESSION['klantnr'])) {
    echo "<li>U bent niet ingelogd | <a href=\"login.php\">login</a></li>\n";
} else {
    displayCustomerDetails($conn);
}

mysqli_close($conn);
include ('includes/footer.html');

function displayDatabaseConnectionError() {
    printf("<p><b>Error: Failed to connect to the database.</b><br/>\n%s</p>\n", mysqli_connect_error());
    include ('includes/footer.html');
    exit();
}

function displayCustomerDetails($conn) {
    $klantnr = $_SESSION['klantnr'];

    $sql = "SELECT `naam`, `adres`, `postcode`, `plaats`, `emailadres` FROM `klant` WHERE `klantnr`='".$klantnr."'";
    $result = mysqli_query($conn, $sql) or die (mysqli_error($conn)."<br>Error in file ".__FILE__." on line ".__LINE__);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    echo "<table>\n";
    displayRow('Name', $row["naam"]);
    displayRow('Address', $row["adres"]);
    displayRow('Postal Code', $row["postcode"]);
    displayRow('City', $row["plaats"]);
    displayRow('Email', $row["emailadres"]);
    displayRow('Customer Number', $klantnr);
    echo "</table>\n";
}

function displayRow($label, $value) {
    echo "<tr><td id='links'>$label</td><td id='rechts'>$value</td></tr>\n";
}
?>