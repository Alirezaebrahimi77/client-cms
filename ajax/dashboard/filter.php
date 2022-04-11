<?php 
session_start();
include_once "../../config/database/connect.php";

$data = json_decode($_POST['data']);
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

if($dataLength < 1){
     $query = "SELECT * FROM clients LIMIT 30";
}

// search data
// var_dump($query);
$sql = $conn->prepare($query);
$sql->execute();
$finalResults = $sql->fetchAll(PDO::FETCH_OBJ);
$count = 1;
foreach($finalResults as $client){
    ?>
        <tr>
        <td><?php echo $count; ?></td>
        <td>
            <a href="client.php?id=<?php echo $client->client_id; ?>">
                <p><?php echo $client->yritys; ?></p>
            </a>
            <?php
                  if($_SESSION['user_role'] === "yllapito"){
                    ?>
                    <div class="actionContent">
                      <a href="edit.php?id=<?php echo $client->client_id;?>">
                        <span style="color: blue">Muokkaa</span>
                      </a>
                      <span style="color: red">Delete</span>
                    </div>
                    <?php
                  }
                ?>
        </td>
        <td><?php echo $client->sahkoposti; ?></td>
        <td><?php echo $client->alku; ?></td>
        <td><?php echo $client->loppu; ?></td>
        <td><?php echo $client->kesto; ?></td>
        <td><?php echo $client->hinta; ?></td>
        <td><?php echo $client->y_tunnus; ?></td>
    </tr>


<?php
$count++;
}










?>