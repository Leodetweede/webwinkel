<?php
//index.php
//startscherm van de webwinkel

// Zet het niveau van foutmeldingen zo dat warnings niet getoond worden.
error_reporting(E_ERROR | E_PARSE);

$page_title = 'Welkom in de WebWinkel';
include ('includes/header.html');

// mysqli_connect.php bevat de inloggegevens voor de database.
// Per server is er een apart inlogbestand - localhost vs. remote server
include ('includes/mysqli_connect_'.$_SERVER['SERVER_NAME'].'.php');

// Page header:
echo '<h1>Login</h1>';

// Toon eventuele foutmeldingen.
if ( $_SERVER['REQUEST_METHOD'] == 'POST') // && isset($_POST['email']) && isset($_POST['password']))
{
	// We gaan de errors in een array bijhouden
	// We kunnen dan alle foutmeldingen in één keer afdrukken.
	$aErrors = array();

	//  Kijk of een email adres is ingevoerd
	if ( empty($_POST['email'])) {
		$aErrors['email'] = 'Geen geldig email adres.';
		$aErrors['password'] = 'Ongeldig wachtwoord ingevoerd';
	}

	// Wanneer er geen foutieve invoer is gaan we naar de database.
	if ( count($aErrors) == 0 ) 
	{
		// Gebruiker uit database lezen.
		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
 
		// check connection
		if (mysqli_connect_errno()) {
			printf("<p><b>Fout: verbinding met de database mislukt.</b><br/>\n%s</p>\n", 
					mysqli_connect_error());
			include ('includes/footer.html');
			exit();
		}

		$sql = "SELECT `klantnr`, `naam` FROM `klant` WHERE `emailadres`='".$_POST['email']."';";
		// Voer de query uit 
		$result = mysqli_query($conn, $sql) or die (mysqli_error($conn)."<br>in file ".__FILE__." on line ".__LINE__);
		
		if(mysqli_num_rows($result) == 0) {
			$aErrors['email'] = 'Het emailadres is niet gevonden.';
			unset($_POST['email']);
		} else {
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

			// Bij een ingelogde gebruiker bewaren we de naam en het klantnr in de sessie.
			// Hiermee kunnen we de klantnaam op het scherm tonen, en de winkelwagen aan 
			// het juiste klantnr koppelen, zodat de bestelling later afgerond kan worden.
			$_SESSION['klantnr'] = $row["klantnr"];
			$_SESSION['klantnaam'] = $row["naam"];
			// Sluit de connection
			mysqli_close($conn);

			header('Location: index.php');
			exit();
		}
	}
}
?>
	<p>Voer hier uw emailadres in. Nieuwe klant? <a href="registreer.php">Registreer hier</a>.</p>

    <form action="login.php" method="post" class="formulier">
      <?php
      if ( isset($aErrors) and count($aErrors) > 0 ) {
			print '<ul class="errorlist">';
			foreach ( $aErrors as $error ) {
				print '<li>' . $error . '</li>';
			}
			print '</ul>';
      }
      ?>
      <fieldset>
        <legend>Login</legend>
        <ol>
          <li>
            <label for="email">E-mail</label>
            <input id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" />
			<label for="email">Wachtwoord</label>
			<input id="password" name= "password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '' ?>" />
          </li>
        </ol>
        <input type="submit" value="Login" class="button"/>
      </fieldset>
    </form>
<?php	
	include ('includes/footer.html');
?>