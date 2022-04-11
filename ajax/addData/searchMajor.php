<?php

include_once "../../config/database/connect.php";

$word = $_POST['data'];

$sql = $conn->prepare("SELECT * FROM majors WHERE toimiala LIKE '%$word%'");
$sql->execute();
$results = $sql->fetchAll(PDO::FETCH_OBJ);
if($results){
    foreach($results as $res){
        ?>
        <div class="singleMajor onSearch">
            <span id="<?php echo $res->toimialan_id; ?>"><?php echo $res->toimiala; ?></span>     
        </div>
    
    
    <?php
    }

}else{
    ?>
    <div class="singleMajor">
        <span>Ei löydy!</span>   
    </div>


<?php

}



?>