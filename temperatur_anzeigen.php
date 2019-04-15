<?php
 error_reporting(E_ALL);
  // Fehler in der Webseite anzeigen (nicht in Produktion verwenden)
  ini_set('display_errors', 'On');
 
 $db = new SQLite3('temperatur.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
 
 /*
$db->exec('BEGIN');
$db->query('INSERT INTO wohnzimmer (id,temperatur,luftfeuchtigkeit,zimmer,datum) VALUES (NULL,"20.20","49.50","wohnzimmer","2019-04-05 19:00")');
$db->exec('COMMIT');


*/

$results = $db->query('SELECT * FROM wohnzimmer ORDER BY datum DESC');
while ($row = $results->fetchArray()) {
    //var_dump($row);
    echo $row["datum"]." - ". $row["temperatur"] . "°C - " . $row["luftfeuchtigkeit"] ."%<br/>";
}



?>
