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


try{
    $sql = $conn->prepare("UPDATE clients SET asiakas_nro=?, aika=?, yritys=?, etunimi=?, sukunimi=?, osoite=?, postinumero=?, kaupunki=?, puhelinnumero=?, sahkoposti=?, www=?, maksanut=?, kesto=?, alku=?, loppu=?, hinta=?, myyja=?, toimiala=?, maakunta=?, nauha=?, y_tunnus=?,alkamis_kuukausi=?, alkamis_vuosi=?, loppumis_kuukausi=?, loppumis_vuosi=?, category_id=? WHERE client_id=?");
    $sql->execute([ $data->asiakas_nro, $data->aika, $data->yritys, $data->etunimi,  $data->sukunimi, $data->osoite,  $data->postinumero, $data->kaupunki,  $data->puhelinnumero, $data->sahkoposti,  $data->www, $data->maksanut,  $data->kesto, $data->alku,  $data->loppu, $data->hinta,  $data->myyja, $data->toimiala,  $data->maakunta, $data->nauha,  $data->y_tunnus, startedMonth($data->alku), startedYear($data->alku), finishedMonth($data->loppu), finishedYear($data->loppu), $data->category_id, $data->row_id]);
    echo $status = "success";

}catch(Exception $e){
    // echo 'Caught exception: ',  $e->getMessage(), "\n";
    echo $e->getMessage();
}














?>