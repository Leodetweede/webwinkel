
<?php
error_reporting(E_ERROR | E_PARSE);

$page_title = 'Winkelwagen';
include ('includes/header.html');

// mysqli_connect.php bevat de inloggegevens voor de database.
// Per server is er een apart inlogbestand - localhost vs. remote server
include ('includes/mysqli_connect_'.$_SERVER['SERVER_NAME'].'.php');

// Page header:
echo '<h1>Winkelwagen</h1>';

// cart.php
// winkelwagen met bijbehorende functionaliteit
session_start();

// Kijk of er iets in de winkelwagen zit
if (empty($_SESSION['cart'])) {
    echo "<p>Winkelwagen is leeg</p>\n";
}
else {
    // Exploden
    $cart = explode("|",$_SESSION['cart']);

    // Tellen inhoud winkelwagen
    $count = count($cart);
    if ($count == 1) {
        echo "<p>Er staat 1 product in je winkelwagen.</p>\n";
    } else {
        echo "<p>Er staan ".$count." producten in je winkelwagen</p>\n";
    }

    // Wat javascriptjes voor het weghalen van producten
    // En daarna het begin van een tabel met de inhoud
    ?>
    <script type="text/javascript">
    <!--
    function removeItem(item) {
        var answer = confirm ('Weet je zeker dat je dit product wilt verwijderen?')
        if (answer)
            window.location="delete_cart_item.php?item=" + item;
    }

    function removeCart() {
        var answer = confirm ('Weet je zeker dat je de winkelwagen wilt leeghalen?')
        if (answer)
            window.location="delete_cart.php";
    }
    //-->
    </script>
    <form method="post" name="form" action="update_cart.php">
    <table>
	<thead>
    <tr>
        <th>Productnr</th>
        <th>Productnaam</th>
        <th>Hoeveelheid</th>
        <th>Prijs p/s</th>
        <th>Totaal</th>
        <th>&nbsp;</th> 
    </tr>
	</thead>
    <?php

    // Totaal (komt later terug)
    $total = 0;
	
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

    // Toon de producten in de winkelwagen
    $i = 0;
    foreach($cart as $products) {
      // Splits het product in stukjes: $product[x] --> x == 0 -> product id, x == 1 -> hoeveelheid
      $product = explode(",", $products);

      if (strlen(trim($product[1])) <> 0) {
		  // Get product info
		  $sql = "SELECT productnummer, productnaam, prijs 
				  FROM product
				  WHERE productnummer = ".$product[0];  // Weet je nog, uit die sessie
				  
		  $result = mysqli_query($conn, $sql) or die (mysqli_error($conn)."<br>in file ".__FILE__." on line ".__LINE__);
		  $pro_cart = mysqli_fetch_object($result);
		  $i++;

		  echo "<tbody>\n<tr>\n";
		  echo "  <td>".$pro_cart->productnummer."</td>\n";   // nummer
		  echo "  <td>".$pro_cart->productnaam."</td>\n";     // naam
		  echo "  <td><input type=\"hidden\" name=\"productnummer_".$i."\" value=\"".$product[0]."\" />\n"; // wat onzichtbare vars voor het updaten
		  echo "      <input type=\"text\" name=\"hoeveelheid_".$i."\" value=\"".$product[1]."\" size=\"2\" maxlength=\"2\" /></td>\n";
		  echo "  <td>€ ".number_format($pro_cart->prijs, 2, ',', '.')."</td>\n";
		  $lineprice = $product[1] * $pro_cart->prijs;      // regelprijs uitrekenen > hoeveelheid * prijs
		  echo "  <td>€ ".number_format($lineprice, 2, ',', '')."</td>\n";
		  echo "  <td><a href=\"javascript:removeItem(".$i.")\">X</td>\n"; // Verwijder, mooi plaatje van prullebak ofzo
		  echo "</tr>\n</tbody>";
		  // Total
		  $total = $total + $lineprice;         // Totaal updaten
      }
    }
    ?>
	<tfoot>
    <tr>
        <td colspan="4"><strong>Totaal</strong></td>
        <td><strong><?php echo "€ ".number_format($total, 2, ',', '.'); ?></strong></td>
        <td>&nbsp;</td>
    </tr>
	</tfoot>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td colspan="4"><input type="submit" value="Ververs" /></td>
    </tr>
    </table>
    </form>
  <p>
  <ul>
		<li><a href="javascript:removeCart()">Winkelwagen leegmaken</a><br /></li>
		<li><a href="checkout.php">Afrekenen</a><br /></li>
		<li><a href="index.php">Verder winkelen</a></li>
	</ul>	
  </p>
  <?php
}
	
include ('includes/footer.html');

?> 
