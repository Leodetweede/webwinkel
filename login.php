<?php
//index.php
//startscherm van de webwinkel

// Zet het niveau van foutmeldingen zo dat alleen ernstige fouten worden getoond.
error_reporting(E_ERROR | E_PARSE);

$page_title = 'Welkom in de WebWinkel';
include ('includes/header.html');

// Inclusief het bestand met de databaseverbinding voor de specifieke server.
include ('includes/mysqli_connect_'.$_SERVER['SERVER_NAME'].'.php');

// Toon de titel van de pagina.
echo '<h1>Login</h1>';

// Als het formulier is ingediend, verwerk het.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    verwerkLoginFormulier();
}

// Toon het inlogformulier.
toonLoginFormulier();

// Inclusief de footer van de pagina.
include ('includes/footer.html');

// Functie om het ingediende inlogformulier te verwerken.
function verwerkLoginFormulier() {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Maak verbinding met de database.
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Controleer of de verbinding is gelukt.
    if (mysqli_connect_errno()) {
        toonDatabaseVerbindingsFout();
    }

    // Zoek de gebruiker in de database op basis van het ingevoerde e-mailadres en wachtwoord.
    $sql = "SELECT `klantnr`, `naam` FROM `klant` WHERE `emailadres`='$email' AND `password`='$password'";
    $result = mysqli_query($conn, $sql);

    // Als er een overeenkomst is gevonden, sla de gebruikersgegevens op in de sessie en stuur door naar de startpagina.
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['klantnr'] = $row["klantnr"];
        $_SESSION['klantnaam'] = $row["naam"];
        mysqli_close($conn);

        header('Location: index.php');
        exit();
    } else {
        // Als er geen overeenkomst is gevonden, toon een foutmelding.
        echo "Geen gebruiker gevonden met dat e-mailadres en wachtwoord.";
    }
}

// Functie om een foutmelding weer te geven als de databaseverbinding mislukt.
function toonDatabaseVerbindingsFout() {
    printf("<p><b>Fout: Verbinding met de database is mislukt.</b><br/>\n%s</p>\n", mysqli_connect_error());
    include ('includes/footer.html');
    exit();
}

// Functie om het inlogformulier weer te geven.
function toonLoginFormulier() {
    echo '<p>Voer hier uw e-mailadres in. Nieuwe klant? <a href="registreer.php">Registreer hier</a>.</p>';

    echo '<form action="login.php" method="post" class="formulier">';
    echo '<fieldset>';
    echo '<legend>Login</legend>';
    echo '<ol>';
    echo '<li>';
    echo '<label for="email">E-mail</label>';
    echo '<input id="email" name="email" value="' . (isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '') . '" />';
    echo '<label for="password">Wachtwoord</label>';
    echo '<input id="password" name="password" value="' . (isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '') . '" />';
    echo '</li>';
    echo '</ol>';
    echo '<input type="submit" value="Login" class="button"/>';
    echo '</fieldset>';
    echo '</form>';
}
?>