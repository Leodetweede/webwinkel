<?php
// Path naar de afbeelding
$imagePath = 'C:\Users\Léon\Pictures\HEPA Filter.jpg';

// Lees de inhoud van de afbeelding
$imageData = file_get_contents($imagePath);

// Converteer de inhoud naar een base64-gecodeerde string
$base64Image = base64_encode($imageData);

// Toon de base64-gecodeerde string
echo $base64Image;
?>
