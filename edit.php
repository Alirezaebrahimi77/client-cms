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
          <p class="main_title">Muokkaa</p>
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
      $id = $_REQUEST['id'];
      $clientSql = $conn->prepare("SELECT * FROM clients WHERE client_id = :client_id");
      $clientSql->execute(array(
        ':client_id' => $id
      ));
      $result = $clientSql->fetch(PDO::FETCH_OBJ);
      if(empty($result)){
        header("Location: /levikki/dashboard.php");
      }
      function clean($string){
        $string = str_replace(' ', '', $string);
        return mb_strtolower($string, 'UTF-8');
    }

      $kesto = clean($result->kesto);


?>

      <div class="data" style="margin-top: 30px; height: 100%;">
        <div class="dataContent addDataContent">
            <div class="dataLeft">


            <div class="dataLeftInputs">
            <input type="text" placeholder="Yrityksen nimi" id="companyName" value="<?php echo htmlentities($result->yritys); ?>" required>
            <div class="d-flex">
              <input type="text" placeholder="Etunimi" id="firstName" value="<?php echo htmlentities($result->etunimi); ?>" required>
              <input type="text" placeholder="Sukunimi" id="lastName" value="<?php echo htmlentities($result->sukunimi); ?>" required>
            </div>
            <input type="text" placeholder="Osoite" id="address" value="<?php echo htmlentities($result->osoite); ?>" required>
            <div class="d-flex">
              <input type="text" placeholder="Kaupunki" id="city" value="<?php echo htmlentities($result->kaupunki); ?>" required>
              <input type="text" placeholder="Postinumero" id="postalCode" value="<?php echo htmlentities($result->postinumero); ?>" required>
            </div>
            <div class="d-flex">
              <input type="text" placeholder="puhelin" id="phone" value="<?php echo htmlentities($result->puhelinnumero); ?>" required>
              <input type="email" placeholder="Sähköposti" id="email"  value="<?php echo htmlentities($result->sahkoposti); ?>" required>
            </div>
            <div class="d-flex">
              <input type="text" placeholder="Toimiala" id="major" value="<?php echo htmlentities($result->toimiala); ?>">
              <input type="text" placeholder="Maakunta" id="province" value="<?php echo htmlentities($result->maakunta); ?>">
            </div>
            <div class="d-flex">
              <input type="number" placeholder="Asiakasnumero" id="client_id" value="<?php echo htmlentities($result->asiakas_nro); ?>">
              <input type="text" placeholder="Y-tunnus" id="company_id" required value="<?php echo htmlentities($result->y_tunnus); ?>">
            </div>
            <div class="d-flex">
              <input type="text" placeholder="Nettisivu" id="website" value="<?php echo htmlentities($result->www); ?>">
            </div>

          </div>
                

            
            </div>
          <div class="dataRight">

          <div class="dataRightInputs">
            <label class="formLabel">Myyntipäivä</label>
            <input type="text" id="saleDate" value="<?php echo htmlentities($result->aika); ?>">

            <select  id="duration" required style="width: 100%; margin: 0 0 20px 0;">
                <option value="" disabled selected>Valitse kesto</option>
                <option value="määräaikainen" <?php echo ($kesto === 'määräaikainen' ? 'selected="selected"' : ''); ?>>Määräaikainen</option>
                <option value="säästö" <?php echo ($kesto === 'säästö' ? 'selected="selected"' : ''); ?>>säästö</option>
                <option value="ei jatka" <?php echo ($kesto === 'eijatka' ? 'selected="selected"' : ''); ?>>Ei jatka</option>
            </select>

            <input type="text" placeholder="Myyjä" id="seller" value="<?php echo htmlentities($result->myyja); ?>" required>
      
            <label class="formLabel">Alku</label>
            <input type="text" id="alkupaiva" placeholder="Esim, 01/22" value="<?php echo htmlentities($result->alku); ?>" required>
            <label class="formLabel">Loppu</label>
            <input type="text" id="loppupaiva" placeholder="Esim, 04/22" value="<?php echo htmlentities($result->loppu); ?>" required>
            <input type="text" placeholder="maksanut?" id="paid" value="<?php echo htmlentities($result->maksanut); ?>" required>
            <input type="text" placeholder="Hinta" id="price" value="<?php echo htmlentities($result->hinta); ?>" required>
            <input type="hidden" id="category_id" value="<?php echo htmlentities($result->category_id);?>">
            <input type="hidden" id="row_id" value="<?php echo htmlentities($id);?>">
            <select name="productCategory" id="clientCategory" style="margin: 0 0 15px 0; width: 100%;">

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

                <div class="d-flex" style="justify-content: flex-end;">
                    <button class="btn" id="editSubmit">Tallenna muutokset</button>
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
    <script src="assets/js/edit.js"></script>
  </body>
</html>
