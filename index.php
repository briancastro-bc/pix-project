<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/router.php");

/* GET PUBLIC ROUTES */
get('/', 'views/index.php');
get('/signin', 'views/signin.php');
get('/signup', 'views/signup.php');

/* POST PUBLIC ROUTES */
post('/signin', 'views/signin.php');

/* NOT FOUND PAGE */
any('/404','views/404.php');