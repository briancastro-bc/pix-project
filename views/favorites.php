<?php

require $_SERVER['DOCUMENT_ROOT'] . '/connection.php';

if (!isset($_SESSION)) {
  session_start();
}

if (empty($_SESSION['user']['id']) || !isset($_SESSION['user']['id'])) {
  header('Location: /signin');
  exit();
}

$stmt = $mysqli->stmt_init();
$stmt->prepare("SELECT p.* FROM users AS u INNER JOIN user_products AS up ON u.id = up.userId INNER JOIN products AS p ON p.id = up.productId WHERE u.id = ?");
$stmt->bind_param("i", $_SESSION['user']['id']);
$stmt->execute();
$productsFavorites = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $favorite_id = $_POST['favorite_id'];

  if (!empty($favorite_id)) {
    $stmt->prepare("DELETE FROM user_products WHERE userId = ? AND productId = ?");
    $stmt->bind_param('ii', $_SESSION['user']['id'], $favorite_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
      header('Location: /favorites');
      exit();
    }
  }
}

?>

<!DOCTYPE html>
<html lang="es" translate="no">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pix - Favoritos</title>
  <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>

  <?php include('views/layout/navbar.php'); ?>

  <section class="favorites">
    <div class="favorites__container">
      <div class="heading">
        <h2 class="title">Favoritos</h2>
      </div>
      <div class="body">
        <?php if (count($productsFavorites) > 0) : ?>
          <div class="wrapper">
            <?php foreach ($productsFavorites as $favorite) { ?>
              <article class="product-card">
                <div class="header">
                  <img class="product-img" src="<?php echo $favorite['image'] ?>" alt="product-img">
                </div>
                <div class="content">
                  <h2 class="name">
                    <?php echo $favorite['name'] ?>
                  </h2>
                  <h3 class="price">
                    <?php echo $favorite['price'] ?> $
                  </h3>
                  <!-- <span class="stock">4</span> -->
                  <form action="/favorites" method="POST">
                    <input type="hidden" name="favorite_id" value="<?php echo $favorite['id'] ?>">
                    <button type="submit" class="btn btn-primary btn-full">
                      <i class="icon fa fa-heart"></i>
                      Eliminar de favoritos
                    </button>
                  </form>
                </div>
              </article>
            <?php } ?>
          </div>
        <?php else : ?>
          <div class="no-products">
            <h2>No hay productos favoritos</h2>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

</body>

</html>