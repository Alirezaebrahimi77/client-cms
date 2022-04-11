<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("location: index.php");
  exit;
}
if ($_SESSION['user_role'] === "myyja") {
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
        <p class="main_title">Lisää yritys</p>
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
            <input type="text" placeholder="Yrityksen nimi *" id="companyName" required>
            <div class="d-flex">
              <input type="text" placeholder="Etunimi" id="firstName" required>
              <input type="text" placeholder="Sukunimi *" id="lastName" required>
            </div>
            <input type="text" placeholder="Osoite *" id="address" required>
            <div class="d-flex">
              <input type="text" placeholder="Kaupunki *" id="city" required>
              <input type="text" placeholder="Postinumero *" id="postalCode" required>
            </div>
            <div class="d-flex">
              <input type="text" placeholder="puhelin *" id="phone" required>
              <input type="email" placeholder="Sähköposti *" id="email" required>
            </div>




            <div class="d-flex majorAndProvinceBox">

              <div class="majorBox">
                <input type="text" placeholder="Toimiala *" id="major">

                <!-- Box appears on searching -->
                <div class="majorSelected onSearch" id="majorSearchBox">


                </div>

                <!-- Selected item's box -->
                <div class="majorSelected" id="majorSelectedBox">


                </div>




              </div>

              <div class="ProvinceBox">
                <input type="text" placeholder="Maakunta *" id="province">

                <div class="majorSelected onSearch" id="provinceSearchBox">
                </div>


                <div class="majorSelected" id="provinceSelectedBox">
                </div>
              </div>

            </div>




            <div class="d-flex">
              <input type="number" placeholder="Asiakasnumero *" id="client_id">
              <input type="text" placeholder="Y-tunnus *" id="company_id" required>
            </div>
            <div class="d-flex">
              <input type="text" placeholder="Nettisivu" id="website">
            </div>


            <div class="addBulkEmail">
              <p>-Lisää kaikki tiedot kerralla Excelin tiedostolla. <span id="download">Lataa mallia</span></p>
              <form id="formBulk" enctype="multipart/form-data" action="ajax/addData/addBulk.php" method="POST">

                <select name="productCategory" id="productCategory" style="margin: 20px 0;">
                  <option value="" selected disabled>Valitse Kategoria *</option>
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
                <input type="file" name="media" id="media" style="border: none; height: 100%;">

                <button id="saveBulk" type="submit">Lähetä</button>
              </form>
            </div>

          </div>

        </div>
        <div class="dataRight">

          <div class="dataRightInputs">
            <label class="formLabel">Myyntipäivä *</label>
            <input type="date" id="saleDate">

            <select id="duration" required style="width: 100%; margin: 0 0 20px 0;">
              <option value="" disabled selected>Valitse kesto *</option>
              <option value="määräaikainen">Määräaikainen</option>
              <option value="säästö">säästö</option>
              <option value="ei jatka">Ei jatka</option>
            </select>

            <input type="text" placeholder="Myyjä" id="seller" required>

            <label class="formLabel">Alku *</label>
            <input type="text" id="alkupaiva" placeholder="Esim, 01/22" required>
            <label class="formLabel">Loppu *</label>
            <input type="text" id="loppupaiva" placeholder="Esim, 04/22" required>
            <input type="text" placeholder="maksanut?" id="paid" required>
            <input type="text" placeholder="Hinta *" id="price" required>
            <select name="productCategory" id="clientCategory" style="margin: 0 0 15px 0; width: 100%;">
              <option value="" selected disabled>Valitse Kategoria *</option>
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
            <textarea name="kommentti" id="lisatiedot" cols="30" rows="10" class="moreDetails">Lisätiedot</textarea>
            <div class="d-flex" style="justify-content: flex-end;">
              <button class="btn" id="addClientSubmit" style="margin-bottom: 15px;">Lisää</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="assets/js/jquery.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="assets/js/sidebar.js"></script>
  <script src="assets/js/welcomeMessage.js"></script>
  <script src="assets/js/addData.js"></script>
</body>

</html>
<?php

if (isset($_GET['status'])) {
  if($_GET['status'] == "empty"){
    ?>
    <script>
        alert("Älä jätä kategorin kenttää tyhjäksi.").then(() => location.reload())
    </script>

  <?php
  }
  if($_GET['status'] == "emptyFile")
  ?>
  <script>
      alert("Valitse tiedosto").then(() => location.reload())
  </script>

<?php

}
?>

