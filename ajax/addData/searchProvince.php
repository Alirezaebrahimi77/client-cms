<?php

include_once "../../config/database/connect.php";

$word = $_POST['data'];

$sql = $conn->prepare("SELECT * FROM provinces WHERE maakunta LIKE '%$word%'");
$sql->execute();
$results = $sql->fetchAll(PDO::FETCH_OBJ);
if($results){
    foreach($results as $res){
        ?>
        <div class="singleProvince onSearch">
            <span id="<?php echo $res->maakunnan_id; ?>"><?php echo $res->maakunta; ?></span>     
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