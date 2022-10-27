<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/router.php");

/* GET PUBLIC ROUTES */
get('/', 'views/index.php');
get('/signin', 'views/signin.php');
get('/signup', 'views/signup.php');

/* GET PRIVATE ROUTES */
get('/logout', 'views/logout.php');
get('/favorites', 'views/favorites.php');
get('/admin', 'views/admin.php');

/* POST PUBLIC ROUTES */
post('/', 'views/index.php');
post('/signin', 'views/signin.php');
post('/signup', 'views/signup.php');
post('/admin', 'views/admin.php');
post('/favorites', 'views/favorites.php');

/* NOT FOUND PAGE */
any('/404','views/404.php');