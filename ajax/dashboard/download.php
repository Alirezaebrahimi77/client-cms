<?php

include_once "../../config/database/connect.php";

$data = json_decode($_POST['hiddenQuery']);
$query = "SELECT * FROM clients WHERE ";

$counter = 1;
$dataLength = count((array)$data);

function checkValue($value){
    switch($value){
        case "määräaikainen":
            return "'%$value%'";
            break;
        case "säästö":
            return "'%$value%'";
            break;
        case "ei jatka":
            return "'%$value%'";
            break;
        default:
        return $value;
        
    }
}

foreach($data as $key => $value){
    if($key == "kesto"){
        $query .= $key . ' LIKE ' . checkValue($value);
    }else{
        $query .= $key . ' = ' . $value;
    }
    if($dataLength > 1 && $counter !== $dataLength ){
        $query .= ' AND ';
    }
    $counter++;
}


// download process, query is ready...
// Fetch records from database 
$sql = $conn->query($query);
 
if($sql->rowCount() > 0){ 
    $delimiter = ","; 
    $filename = "levikki_" . date('Y-m-d') . ".csv"; 
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('asiakas_nro', 'aika', 'yritys', 'etunimi', 'sukunimi', 'osoite', 'postinumero', 'kaupunki', 'puhelinnumero', 'sahkoposti', 'www', 'maksanut', 'kesto', 'alku', 'loppu', 'hinta', 'myyja', 'toimiala', 'maakunta', 'nauha', 'y_tunnus'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){

        $lineData = array($row['asiakas_nro'], $row['aika'], $row['yritys'], $row['etunimi'], $row['sukunimi'], $row['osoite'], $row['postinumero'], $row['kaupunki'], $row['puhelinnumero'], $row['sahkoposti'], $row['www'], $row['maksanut'], $row['kesto'], $row['alku'], $row['loppu'] , $row['hinta'] , $row['myyja'] , $row['toimiala'] , $row['maakunta'], $row['nauha'], $row['y_tunnus']); 
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
} 
exit;

?>
