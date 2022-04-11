<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location: index.php");
    exit;
}
if($_SESSION['user_role'] === "myyja"){
  header("location: dashboard.php");
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
          <p class="main_title">Lisää tuote</p>
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

    <div class="data" style="margin-top: 30px">
      <div class="dataContent sellerDataContent" style="display: flex">
        <div class="sellersLeft" style="flex: 1; flex-direction: column">
          <div class="sellerHeaderTitle">
            <p class="sellerTitle">Lisää tuote</p>
          </div>
          <div class="sellerContent">
            <input type="text" placeholder="Lehden/Tuotteen nimi" id="productName">
            <select name="productNumber" id="productNumber">
              <option value="" selected disabled>Valitse lehden numero</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="extra">Extra</option>
            </select>
            <select name="productCategory" id="productCategory">
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
            <select name="productYear" id="productYear">
            </select>
          </div>
          <div class="sellerBottom">
            <button class="btn" id="addProduct">Lisää</button>
          </div>
        </div>

        <div class="sellersRight" style="flex: 1">
          <div class="sellerHeaderTitle">
            <p class="sellerTitle">Tuotteet</p>
          </div>
          <table style="height: 100%">
            <thead>
              <tr class="productTableHeadRow">
                <th>#</th>
                <th>Lehden nimi</th>
                <th>Numero</th>
                <th>Vuosi</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $productsSql = $conn->prepare("SELECT * FROM products ORDER BY product_name ASC");
              $productsSql->execute();
              $resultProducts = $productsSql->fetchAll(PDO::FETCH_OBJ);
              $count = 1;
              foreach ($resultProducts as $product) {
              ?>
                <tr class="productTableDataRow">
                  <td><?php echo $count; ?></td>
                  <td><?php echo $product->product_name; ?></td>
                  <td><?php echo $product->product_number; ?></td>
                  <td><?php echo $product->product_year; ?></td>
                  <td><i class="bx bxs-trash-alt" id="deleteProduct" data-id="<?php echo $product->product_id; ?>"></i></td>
                </tr>
              <?php
                $count++;
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/products.js"></script>
  <script src="assets/js/sidebar.js"></script>
  <script src="assets/js/welcomeMessage.js"></script>
</body>

</html>








