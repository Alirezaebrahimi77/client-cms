<?php
session_start();
if (!isset($_SESSION['user'])) {
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
  <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
  <div class="sidebar">
    <div class="logo_content">
      <div class="logo">
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
            <i class='bx bx-user'></i>
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
            <i class='bx bx-category-alt'></i>
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
        <p class="main_title">Dashboard</p>
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

    <?php

      $clientSql = $conn->prepare("SELECT * FROM clients");
      $clientSql->execute();
      $numOfClients = $clientSql->rowCount();

      $categorySql = $conn->prepare("SELECT * FROM categories");
      $categorySql->execute();
      $numOfCategories = $categorySql->rowCount();

      $productSql = $conn->prepare("SELECT * FROM products");
      $productSql->execute();
      $numOfProducts = $productSql->rowCount();

      $userSql = $conn->prepare("SELECT * FROM users");
      $userSql->execute();
      $numOfUsers = $userSql->rowCount();
  
    ?>

    <div class="analytics">
      <div class="card cardCyan">
        <div class="cardHeader">
          <p>Yrityksien määrä</p>
          <i class="bx bx-dots-horizontal-rounded"></i>
        </div>
        <div class="cardCenter">
          <p><?php echo $numOfClients;?></p>
        </div>
      </div>

      <div class="card cardPurpole">
        <div class="cardHeader">
          <p>Kategoriat</p>
          <i class="bx bx-dots-horizontal-rounded"></i>
        </div>
        <div class="cardCenter">
          <p><?php echo $numOfCategories;?></p>
        </div>

      </div>

      <div class="card cardBlue">
        <div class="cardHeader">
          <p>Myyjät</p>
          <i class="bx bx-dots-horizontal-rounded"></i>
        </div>
        <div class="cardCenter">
          <p><?php echo $numOfUsers;?></p>
        </div>
      </div>

      <div class="card cardOrange">
        <div class="cardHeader">
          <p>Tuotteet</p>
          <i class="bx bx-dots-horizontal-rounded"></i>
        </div>
        <div class="cardCenter">
          <p><?php echo $numOfProducts;?></p>
        </div>
      </div>
    </div>

    <div class="data">
      <div class="dataHeader">
        <div class="dataHeaderLeft">
          <p>Yritykset</p>
        </div>
        <input type="hidden" id="hiddenQuery2" name="hiddenQuery2">
        
        <?php
        if ($_SESSION['user_role'] === "yllapito") {
          ?>
        <div class="dataHeaderRight">
          <a href="addData.php">
            <button class="btn addBtn">
              <div class="circle">+</div>
              Lisää yritys
            </button>
          </a>
          <form action="ajax/dashboard/download.php" method="POST">
          <input type="hidden" id="hiddenQuery" name="hiddenQuery">
            <button class="btn" style="margin-left: 30px;" id="downloadFiltereddData" type="submit">Lataa tietokoneeseen</button>
          </form>
        </div>
        <?php
        }
        ?>

      </div>

      <div class="dataContent">
        <div class="dataContentHeader">
          <div class="searchInput">
            <input type="text" placeholder="Hae" id="searchInput" />
            <i class="bx bx-search" id="searchClientsBtn"></i>
          </div>

          <div class="filterContainer">
            <span style="margin-right: 10px;">Filter: </span>
            <select name="productCategory" id="productCategory" style="margin: 20px 0;">
              <option value="" selected disabled>Valitse Kategoria</option>
              <?php
              include_once "config/database/connect.php";
              $categorySql = $conn->prepare("SELECT * FROM categories");
              $categorySql->execute();
              $categoriesResult = $categorySql->fetchAll(PDO::FETCH_OBJ);
              foreach ($categoriesResult as $category) {
              ?>
                <option value="<?php echo $category->category_id; ?>"><?php echo $category->category_name; ?></option>
              <?php
              }
              ?>

            </select>
            <select name="hinta" id="hinta">
              <option value="" selected disabled>Hinta</option>
              <option value="55">55</option>
              <option value="35">35</option>
              <option value="15">15</option>
            </select>
            <select name="loppumis_vuosi" id="loppumis_vuosi">
            </select>
            <select name="loppumis_kuukausi" id="loppumis_kuukausi">
              <option value="" selected disabled>Valitse loppumis kuukausi</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
            <select name="kesto" id="kesto">
              <option value="" selected disabled>Kesto</option>
              <option value="määräaikainen">Määräaikainen</option>
              <option value="säästö">Säästö</option>
              <option value="ei jatka">Ei jatka</option>
            </select>
            <button class="btn filterBtn" id="filterSearchBtn">Hae</button>
          </div>
        </div>

        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Yiryts</th>
              <th>Sähköposti</th>
              <th>Alkamisaika</th>
              <th>loppumissaika</th>
              <th>Kesto</th>
              <th>Hinta</th>
              <th>Y-tunnus</th>
            </tr>
          </thead>
          <tbody id="dashboardTableBody">
            <?php
            include_once "config/database/connect.php";

            $sql = $conn->prepare("SELECT * FROM clients LIMIT 30");
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
                  if ($_SESSION['user_role'] === "yllapito") {
                  ?>
                    <div class="actionContent">
                      <a href="edit.php?id=<?php echo $client->client_id; ?>">
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
              <div class="loaderContainer">
                <div class="loader"></div>
              </div>

            <?php
              $count++;
            }
            ?>


          </tbody>
        </table>
      </div>
    </div>
  </main>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/sidebar.js"></script>
  <script src="assets/js/welcomeMessage.js"></script>
  <script src="assets/js/dashboard.js"></script>

</body>

</html>