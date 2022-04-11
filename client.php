<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex">
    <title>Levikki</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link
      href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css"
      rel="stylesheet"
    />
  </head>
  <body>
    <div class="sidebar">
      <div class="logo_content">
        <div class="logo">
          <!-- <i class='bx bxl-c-plus-plus'></i> -->
          <div class="logo_name">JDM Media Oy</div>
        </div>
        <i class="bx bx-menu" id="btn"></i>
      </div>
      <ul class="nav_list">
        <li>
          <a href="dashboard.php">
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Dashboard</span>
          </a>
          <span class="tooltip">Dashboard</span>
        </li>
        <?php
        if ($_SESSION['user_role'] === "yllapito") {
        ?>
        <li>
          <a href="sellers.php">
            <i class="bx bxs-user"></i>
            <span class="links_name">Myyjät</span>
          </a>
          <span class="tooltip">Myyjät</span>
        </li>

        <li>
          <a href="addData.php">
            <i class="bx bx-data"></i>
            <span class="links_name">Lisää data</span>
          </a>
          <span class="tooltip">Lisää data</span>
        </li>

        <li>
          <a href="products.php">
            <i class='bx bx-news'></i>
            <span class="links_name">Tuote</span>
          </a>
          <span class="tooltip">Tuote</span>
        </li>
        <li>
          <a href="categories.php">
              <i class='bx bx-category-alt' ></i>
            <span class="links_name">Kategoria</span>
          </a>
          <span class="tooltip">Kategoria</span>
        </li>
        <?php
      }
      ?>
      </ul>
      <?php
      include_once "config/database/connect.php";
      $userSql = $conn->prepare("SELECT * FROM users WHERE id = :id");
      $userSql->execute(array(
        ':id' => $_SESSION['user']
      ));
      $userResult = $userSql->fetch(PDO::FETCH_OBJ);
      ?>
      <div class="profile_content">
        <div class="profile">
          <div class="profile_details">
            <!-- <img src="" alt=""> -->
            <div class="name_job">
              <div class="name"><?php echo $userResult->user_role; ?></div>
              <div class="job"><?php echo $userResult->user_email; ?></div>
            </div>
          </div>
          <i class="bx bx-log-out" id="logout"></i>
        </div>
      </div>
    </div>
    <main class="home_content">
      <div class="mainHeader">
        <div class="mainHeaderLeft">
          <p class="main_title">Yrityksen tiedot</p>
          <p class="main-subTitle"></p>
        </div>
        <div class="mainHeaderRight">
          <div class="userDetails">
            <div class="userDetailsLeft"></div>
            <div class="userDetailsRight">
              <p class="user-name"><?php echo $userResult->user_email; ?></p>
              <p class="user-subName"><?php echo $userResult->user_role; ?></p>
            </div>
          </div>
        </div>
      </div>


      <div class="data" style="margin-top: 30px; height: 100%;">
        <div class="dataContent addDataContent">
            <div class="dataLeft">
                <div class="dataLeftInputs">
                  <?php
                  $singleClientSql = $conn->prepare("SELECT * FROM clients WHERE client_id = :id");
                  $singleClientSql->execute(array(
                    ':id' => $_REQUEST['id']
                  ));
                  $client = $singleClientSql->fetch(PDO::FETCH_OBJ);
                  ?>
                    <div class="clientSingleDataBlock">
                        <span>Yrityksen nimi</span>
                        <span><?php echo $client->yritys; ?></span>
                        
                    </div>
                    <div class="clientSingleDataBlock">
                        <span>Etunimi</span>
                        <span><?php echo $client->etunimi; ?></span>
                    </div>
                    <div class="clientSingleDataBlock">
                        <span>Sukunimi</span>
                        <span><?php echo $client->sukunimi; ?></span>
                    </div>
                    <div class="clientSingleDataBlock">
                        <span>Osoite</span>
                        <span><?php echo $client->osoite; ?></span>
                    </div>
                    <div class="clientSingleDataBlock">
                        <span>Kaupunki</span>
                        <span><?php echo $client->kaupunki; ?></span>
                    </div>
                    <div class="clientSingleDataBlock">
                        <span>Postinumero</span>
                        <span><?php echo $client->postinumero; ?></span>
                    </div>
                    <div class="clientSingleDataBlock">
                        <span>Puhelin</span>
                        <span><?php echo $client->puhelinnumero; ?></span>
                    </div>
                    <div class="clientSingleDataBlock">
                        <span>Sahköposti</span>
                        <span><?php echo $client->sahkoposti; ?></span>
                    </div>
                    <div class="clientSingleDataBlock">
                        <span>Toimiala</span>
                        <span><?php echo $client->toimiala; ?></span>
                    </div>
                    <div class="clientSingleDataBlock">
                        <span>Maakunta</span>
                        <span><?php echo $client->maakunta; ?></span>
                    </div>
                    <div class="clientSingleDataBlock">
                        <span>Asiakasnumero</span>
                        <span><?php echo $client->asiakas_nro; ?></span>
                    </div>
                    <div class="clientSingleDataBlock">
                        <span>Y-tunnus</span>
                        <span><?php echo $client->y_tunnus; ?></span>
                    </div>
                    <div class="clientSingleDataBlock">
                        <span>Nettisivu</span>
                        <span><?php echo $client->www; ?></span>
                    </div>
                </div>
            </div>


          <div class="dataRight">
            <div class="dataRightInputs">


                <div class="clientSingleDataBlock">
                    <span>Myyntipäivä/Aika</span>
                    <span><?php echo $client->aika; ?></span>
                </div>
                <div class="clientSingleDataBlock">
                    <span>Kesto</span>
                    <span><?php echo $client->kesto; ?></span>
                    
                </div>
                <div class="clientSingleDataBlock">
                    <span>Myyjä</span>
                    <span><?php echo $client->myyja; ?></span>
                    
                </div>
                <div class="clientSingleDataBlock">
                    <span>Alku</span>
                    <span><?php echo $client->alku; ?></span>
                    
                </div>
                <div class="clientSingleDataBlock">
                    <span>Loppu</span>
                    <span><?php echo $client->loppu; ?></span>
                    
                </div>
                <div class="clientSingleDataBlock">
                    <span>Hinta</span>
                    <span><?php echo $client->hinta; ?></span>
                    
                </div>
                <!-- <div class="clientSingleDataBlock">
                    <span>Last modified</span>
                    <span>2021-05-17</span>
                    
                </div> -->
            </div>
            </div>
        </div>
      </div>
    </main>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/sidebar.js"></script>
    <script src="assets/js/welcomeMessage.js"></script>
  </body>
</html>
