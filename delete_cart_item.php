<?php
// delete_cart_item.php
// item uit winkelwagen verwijderen
session_start();

// Variables
$item = $_GET['item'];

// Wederom, kijken of winkelwagen bestaat
if (empty($_SESSION['cart']))
{
    // Winkelwagen leeg, ga naar startscherm :)
    header("Location: index.php");
} else {
    // Winkelwagen uit elkaar plukken
    $cart2 = explode("|",$_SESSION['cart']);

    // Tellen aantal items in winkelwagen
    $count = count($cart2);

    // kijken of het in de winkelwagen staat
    $i=0;
    foreach($cart2 as $products) {
        // Split
        /*
        $product[x] -->
        x == 0 -> productnummer
        x == 1 -> hoeveelheid
        */
        $product = explode(",",$products);
        $i++;
        if ($i != $item) { // Dus als die niet die is die verwijderd moet worden
            // Var toevoegen aan nieuwe winkelwagen
            $inNewCart = $product[0].",".$product[1];
            $newCart = $newCart."|".$inNewCart;
        }
    }

    // Er staat nog een | vooraan, even weghalen (had natuurlijk ook eerder
    // een controle kunnen doen en die daar niet plaatsen
    $newCart = substr($newCart,1);
}

// Verwijder de 'oude' winkelwagen en bouw een nieuwe
unset($_SESSION['cart']);
$_SESSION['cart'] = $newCart;

// En terugsturen
header("Location: cart.php");
?> 