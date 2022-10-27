<?php

require $_SERVER['DOCUMENT_ROOT'] . '/connection.php';

if (!isset($_SESSION)) {
  session_start();
}

if (empty($_SESSION['user']['id'] && $_SESSION['user']['isAdmin'])) {
  header('Location: /404');
  exit();
}

// product info
$message = "";
$stmt = $mysqli->stmt_init();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $process = $_POST['process'];

  switch ($process) {
    case 'create-product':
      $name = $_POST['name'];
      $image = $_POST['image'];
      $price = $_POST['price'];
      $stock = $_POST['stock'];

      if (!empty($name) && !empty($image) && !empty($price)) {
        try {
          $stmt->prepare("INSERT INTO products(name, price, image, stock, userId) VALUES(?, ?, ?, ?, ?)");
          $stmt->bind_param("sdsii", $name, $price, $image, $stock, $_SESSION['user']['id']);
          $stmt->execute();

          if ($stmt->affected_rows >= 1) {
            $message = "Se ha insertado el producto en la base de datos";
            header('Location: /admin');
            exit();
          } else {
            $message = "No se ha insertado en la base de datos";
          }
        } catch (Exception $e) {
          $message = $e->getMessage();
        } finally {
          $stmt->close();
        }
      } else {
        $message = 'Asegúrate de rellenar los campos';
      }
      break;
    case 'update-product':
      $id = $_POST['id'];
      $name = $_POST['name'];
      $price = $_POST['price'];
      $stock = $_POST['stock'];
      $action = $_POST['action'];

      switch ($action) {
        case 'update':
          if (!empty($name) && !empty($price) && !empty($stock)) {
            try {
              $stmt->prepare("UPDATE products SET name=?, price=?, stock=? WHERE id=?");
              $stmt->bind_param("sdii", $name, $price, $stock, $id);
              $stmt->execute();

              if ($stmt->affected_rows >= 1) {
                header('Location: /admin');
                exit();
              }
            } catch (Exception $e) {
              // something
            } finally {
              $stmt->close();
            }
          }
          break;
        case 'delete':
          $stmt->prepare("DELETE FROM user_products WHERE productId = ?");
          $stmt->bind_param("i", $id);
          $stmt->execute();
          $stmt->prepare("DELETE FROM products WHERE id = ?");
          $stmt->bind_param("i", $id);
          $stmt->execute();

          if ($stmt->affected_rows >= 1) {
            header('Location: /admin');
            $stmt->close();
            exit();
          }
          break;
      }
      break;
  }
}

$stmt->prepare("SELECT * FROM products");
$stmt->execute();

$results = $stmt->get_result();
$products = $results->fetch_all(MYSQLI_ASSOC);

$mysqli->close();

?>

<!DOCTYPE html>
<html lang="es" translate="no">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pix - Panel</title>
  <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>

  <?php include('views/layout/navbar.php'); ?>

  <section class="admin-products">
    <div class="container">
      <div class="col col__left">
        <article class="create-card">
          <div class="header">
            <h2>Crear producto</h2>
            <?php if (!empty($message)) : ?>
              <p class="error-message"><?php echo $message; ?></p>
            <?php endif; ?>
          </div>
          <form action="/admin" method="POST" class="body">
            <input type="hidden" name="process" value="create-product">
            <div class="pix-input-group">
              <input type="text" class="pix-input" name="name" placeholder="Nombre">
            </div>
            <div class="pix-input-group">
              <input type="url" class="pix-input" name="image" placeholder="Imagen">
            </div>
            <div class="pix-input-group">
              <input type="number" class="pix-input" name="price" placeholder="Precio">
            </div>
            <div class="pix-input-group">
              <input type="number" class="pix-input" name="stock" placeholder="Disponibilidad">
            </div>
            <div class="pix-input-group">
              <button type="submit" class="btn btn-primary btn-full">
                Crear
              </button>
            </div>
          </form>
        </article>
      </div>
      <div class="col col__right">
        <?php if (count($products) > 0) : ?>
          <div class="wrapper">
            <?php foreach ($products as $product) { ?>
              <form action="/admin" method="POST" class="wrapper-element">
                <input type="hidden" name="process" value="update-product">
                <div class="id">
                  <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                  <span>
                    <?php echo $product['id']; ?>
                  </span>
                </div>
                <div class="product-name">
                  <input class="pix-input" type="text" name="name" value="<?php echo $product['name'] ?>">
                </div>
                <div class="price">
                  <input class="pix-input" type="number" name="price" value="<?php echo $product['price'] ?>">
                </div>
                <div class="stock">
                  <input class="pix-input" type="number" name="stock" value="<?php echo $product['stock'] ?>">
                </div>
                <div class="actions">
                  <button type="submit" class="btn btn-icon" name="action" value="update">
                    <i class="icon fa fa-save"></i>
                  </button>
                  <button type="submit" class="btn btn-icon" name="action" value="delete">
                    <i class="icon fa fa-trash"></i>
                  </button>
                </div>
              </form>
            <?php } ?>
          </div>
        <?php else : ?>
          <h2>No hay productos</h2>
        <?php endif; ?>
      </div>
    </div>
  </section>

</body>

</html>