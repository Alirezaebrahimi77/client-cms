<?php
session_start();
include_once "../../config/database/connect.php";
$keyword = $_POST['keyword'];

if ($keyword) {
    $sql = $conn->prepare("SELECT * FROM clients WHERE yritys LIKE '%$keyword%'");
} else {
    $sql = $conn->prepare("SELECT * FROM clients LIMIT 30");
}

$sql->execute();
$clientsResults = $sql->fetchAll(PDO::FETCH_OBJ);
$count = 1;
foreach ($clientsResults as $client) {
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
                      <span style="color: red" class="deleteClientInfo" id="<?php echo $client->client_id; ?>">Poista</span>
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
