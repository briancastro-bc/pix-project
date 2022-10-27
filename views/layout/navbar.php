<?php 

require $_SERVER['DOCUMENT_ROOT'] . '/connection.php';

if (!isset($_SESSION)) {
  session_start();
}

$stmt = $mysqli->stmt_init();
$stmt->prepare("SELECT COUNT(productId) as count FROM user_products WHERE userId = ?");
$stmt->bind_param("i", $_SESSION['user']['id']);
$stmt->execute();
$favorites = $stmt->get_result()->fetch_assoc();

?>

<header class="navbar">
  <div class="navbar__container">
    <div class="navbar__container__left">
      <a href="/">
        <img class="logo" src="public/images/logo.svg" alt="pix-logo">
      </a>
    </div>
    <div class="navbar__container__center">
      <form action="/" method="GET" class="wrapper">
        <input class="pix-input" class="search-input" placeholder="Buscar aquí" type="search" name="search">
      </form>
    </div>
    <div class="navbar__container__right">
      <?php if (!isset($_SESSION['user']['id'])) : ?>
        <a href="/signin" class="link">
          Log In
        </a>
        <a href="/signup" class="btn btn-primary">
          Sign Up
        </a>
      <?php else : ?>
        <span class="link">
          <?php echo $_SESSION['user']['fullname'] ?>
        </span>
        <a href="/favorites" type="button" class="btn btn-icon">
          <i class="icon fa fa-heart"></i>
          <span class="pix-badge"><?php echo $favorites['count'] ?></span>
        </a>
        <a href="/logout" class="btn btn-icon">
          <i class="icon fa fa-right-from-bracket"></i>
        </a>
      <?php endif; ?>
    </div>
  </div>
</header>