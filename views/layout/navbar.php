<header class="navbar">
  <div class="navbar__container">
    <div class="navbar__container__left">
      <img class="logo" src="public/images/logo.svg" alt="pix-logo">
    </div>
    <div class="navbar__container__center">
      <form action="/" method="GET" class="wrapper">
        <input class="pix-input" class="search-input" placeholder="Buscar aquí" type="search" name="search" id="search">
      </form>
    </div>
    <div class="navbar__container__right">
      <?php if (empty($_SESSION['user'])) : ?>
        <a href="/signin" class="link">
          Log In
        </a>
        <a href="/signup" class="btn btn-primary">
          Sign Up
        </a>
      <?php else : ?>
        <a class="link">
          <?php echo $_SESSION['user']['fullname'] ?>
        </a>
        <button type="button" class="btn btn-icon">
          <i class="icon fa fa-heart"></i>
        </button>
        <a href="/logout" class="btn btn-icon">
          <i class="icon fa fa-right-from-bracket"></i>
        </a>
      <?php endif; ?>
    </div>
  </div>
</header>