<?php

include_once "../../config/database/connect.php";

$data = json_decode($_POST['data']);

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

if(empty($data->yritys) || empty($data->sukunimi) || empty($data->osoite) ||empty($data->kaupunki) || empty($data->postinumero) || empty($data->puhelinnumero) || empty($data->sahkoposti) || empty($data->toimiala) || empty($data->maakunta) || empty($data->asiakas_nro) || empty($data->y_tunnus) || empty($data->kesto) || empty($data->alku) || empty($data->loppu) || empty($data->hinta) || empty($data->category_id) || empty($data->aika)){
  echo "Älä jätä pakolliset kentät tyhjäksi.";
  return;
  
}


try{
    $sql = $conn->prepare("INSERT INTO clients(asiakas_nro, aika, yritys, etunimi, sukunimi, osoite, postinumero, kaupunki, puhelinnumero, sahkoposti, www, maksanut, kesto, alku, loppu, hinta, myyja, toimiala, maakunta, nauha, y_tunnus,alkamis_kuukausi, alkamis_vuosi, loppumis_kuukausi, loppumis_vuosi, category_id, lisatiedot) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $sql->execute([ $data->asiakas_nro, $data->aika, $data->yritys, $data->etunimi,  $data->sukunimi, $data->osoite,  $data->postinumero, $data->kaupunki,  $data->puhelinnumero, $data->sahkoposti,  $data->www, $data->maksanut,  $data->kesto, $data->alku,  $data->loppu, $data->hinta,  $data->myyja, $data->toimiala,  $data->maakunta, $data->nauha,  $data->y_tunnus, startedMonth($data->alku), startedYear($data->alku), finishedMonth($data->loppu), finishedYear($data->loppu), $data->category_id, $data->lisatiedot]);
    echo $status = "success";

}catch(Exception $e){
    // echo 'Caught exception: ',  $e->getMessage(), "\n";
    echo $e->getMessage();
}

?>