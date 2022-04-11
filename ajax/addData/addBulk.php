<?php

include_once "../../config/database/connect.php";


if(empty($_FILES["media"]["tmp_name"])){
  header("Location: /levikki/addData.php?status=emptyFile");
  return;

}else{
  $fh = fopen($_FILES["media"]["tmp_name"], "r");
}
if(!empty($_POST['productCategory'])){

  $category = $_POST['productCategory'];

}else{
  header("Location: /levikki/addData.php?status=empty");
  return;

}


function startedYear ($startedYear){
  return "20" . substr($startedYear, -2);
}
function finishedYear ($finishedYear){
  return "20" . substr($finishedYear, -2);
}
function startedMonth ($startedMonth){
  return substr($startedMonth, 1, 1);
}
function finishedMonth ($finishedMonth){
  return substr($finishedMonth, 1, 1);
}
function clean($string){
    $string = str_replace(' ', '', $string);
    return mb_strtolower($string, 'UTF-8');
}


if(empty($fh)){
//   header("Location: /levikki/add_email.php?status=empty");
} 
$flag = true;
while (($row = fgetcsv($fh)) !== false) {
    try {
      // print_r($row);
      if($flag) { $flag = false; continue; }
      $stmt = $conn->prepare("INSERT INTO clients(asiakas_nro, aika, yritys, etunimi, sukunimi, osoite, postinumero, kaupunki, puhelinnumero, sahkoposti, www, maksanut, kesto, alku, loppu, hinta, myyja, toimiala, maakunta, nauha, y_tunnus,alkamis_kuukausi, alkamis_vuosi, loppumis_kuukausi, loppumis_vuosi, category_id, lisatiedot) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      // $stmt = $conn->prepare("INSERT INTO clients(asiakas_nro, aika, yritys, etunimi, sukunimi, osoite, postinumero, kaupunki, puhelinnumero, sahkoposti, www, toimiala, maakunta, maksanut, kesto, alku, loppu, hinta, myyja, nauha, y_tunnus,alkamis_kuukausi, alkamis_vuosi, loppumis_kuukausi, loppumis_vuosi, category_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $stmt->execute([ $row[0], $row[1],  $row[2], $row[3],  $row[4], $row[5],  $row[6], $row[7],  $row[8], $row[9],  $row[10], $row[11],  $row[12], $row[13],  $row[14], $row[15],  $row[16], $row[17],  $row[18], $row[19],  $row[20], startedMonth($row[13]), startedYear($row[13]), finishedMonth($row[14]), finishedYear($row[14]), $category, $row[21]]);
      // $stmt->execute([ $row[0], $row[1],  $row[2], $row[3],  $row[4], $row[5],  $row[6], $row[7],  $row[8], $row[9],  $row[10], $row[11],  $row[12], clean($row[15]),  $row[14], $row[15],  $row[16], $row[17],  $row[18], $row[19],  $row[20], startedMonth($row[15]), startedYear($row[15]), finishedMonth($row[16]), finishedYear($row[16]), $category]);

    } catch (Exception $ex) { echo $ex->getmessage(); }
  }
  fclose($fh);
  header("Location: /levikki/addData.php?status=success");
?>