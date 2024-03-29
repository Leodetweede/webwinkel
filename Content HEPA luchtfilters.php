<?php
// mysqli_connect.php bevat de inloggegevens voor de database.
// Per server is er een apart inlogbestand - localhost vs. remote server
include ('includes/mysqli_connect_'.$_SERVER['SERVER_NAME'].'.php');

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

// Maak de SQL query specifiek voor de HEPA luchtfilter
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
AND `product`.`productnaam` = 'HEPA filter';"; 

// Voer de query uit en sla het resultaat op 
$result = mysqli_query($conn, $sql);
	

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
?>
<html>
<div class="grid-container">
    <div style="flex: 1;">
        <h2>Productinformatie</h2>
        <p>Adem zuiverder met onze HEPA luchtfilter. Ontworpen om de lucht te zuiveren van microscopische deeltjes en allergenen, zorgt onze HEPA filter voor een frisse en gezonde omgeving. Geniet van schone lucht en verminder allergieën met ons betrouwbare luchtfiltratiesysteem.</p>
       
        <ul>
            <li><strong>Hoogwaardige Filtratie:</strong> Onze luchtfilters zijn ontworpen om een breed scala aan verontreinigende stoffen, zoals stof, pollen, rook en micro-organismen, uit de lucht te verwijderen, waardoor de luchtkwaliteit binnen je faciliteit aanzienlijk verbetert.</li>
            <li><strong>Optimale Efficiëntie:</strong> Dankzij hun electrostatische technologie bieden onze filters een uitzonderlijke filtratie-efficiëntie, waardoor ze betrouwbaar zijn in het vastleggen van zelfs de kleinste deeltjes en het handhaven van een schone en gezonde luchtomgeving.</li>
            <li><strong>Lange Levensduur:</strong> Met duurzame materialen en robuuste constructie bieden onze electrostatische luchtfilters een langdurige prestatie, waardoor je kosten bespaart op frequente vervangingen en onderhoud.</li>
            <li><strong>Maatwerk Oplossingen:</strong> We begrijpen dat elk luchtreinigingssysteem uniek is. Daarom bieden wij maatwerkoplossingen die perfect zijn afgestemd op de specificaties en vereisten van jouw installatie, zodat je optimale resultaten kunt behalen.</li>
            <li><strong>Compliance en Veiligheid:</strong> Onze electrostatische luchtfilters voldoen aan alle relevante veiligheids- en regelgevende normen, waardoor je gemoedsrust hebt dat je bedrijf voldoet aan de vereisten op het gebied van luchtkwaliteit en veiligheid.</li>
        </ul>

        <h2>Technische specificaties</h2>
        <li><strong>Filterefficiëntie:</strong> Onze HEPA-filter voldoet aan strenge normen door deeltjes van 0,3 micron met een efficiëntie van minimaal 99,97% te verwijderen, waardoor uw omgeving wordt beschermd tegen microscopische verontreinigingen.</li>

<li><strong>Luchtstroomcapaciteit:</strong> Ontworpen om een hoge luchtstroomcapaciteit te bieden, variërend van X kubieke meter per uur (m³/h) tot Y kubieke meter per uur (m³/h), afhankelijk van het model, waardoor een krachtige en consistente luchtcirculatie wordt gegarandeerd.</li>

<li><strong>Materiaal van het filtermedium:</strong> Vervaardigd met hoogwaardig glasvezelmedium met een hoge dichtheid, dat zorgt voor optimale filtratieprestaties en langdurige betrouwbaarheid.</li>

<li><strong>Filteroppervlakte:</strong> Onze HEPA-filter biedt een ruim filteroppervlak, wat resulteert in een langere levensduur en verbeterde filtratie-efficiëntie, waardoor uw lucht zuiver blijft.</li>

<li><strong>Drukdaling:</strong> Minimaliseert drukdaling over het filter om de energie-efficiëntie te verbeteren en de werking van HVAC-systemen te optimaliseren, wat resulteert in lagere operationele kosten en een verbeterde luchtkwaliteit.</li>

<li><strong>Kadermateriaal:</strong> Vervaardigd uit sterk en duurzaam kadermateriaal, zoals aluminium of roestvrij staal, voor langdurige prestaties en structurele integriteit, waardoor onze filters bestand zijn tegen de zwaarste omgevingen.</li>

<li><strong>Geschiktheid voor toepassingen:</strong> Onze HEPA-filter is geschikt voor een breed scala aan toepassingen, waaronder HVAC-systemen, cleanrooms, laboratoria, ziekenhuizen en industriële omgevingen, en biedt uitstekende prestaties in diverse omstandigheden.</li>

<li><strong>Certificeringen:</strong> Gecertificeerd volgens internationale normen zoals EN1822 voor HEPA-filters, en voldoet aan de vereisten van relevante regelgevingen en industrienormen, waardoor u gegarandeerd bent van kwaliteit en betrouwbaarheid.</li>
 
    </div>
    <div style="flex: 1;">
    </div>
</div>
</html>