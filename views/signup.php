<?php

require $_SERVER['DOCUMENT_ROOT'] . '/connection.php';

session_start();

if (!empty($_SESSION['user'])) {
  header('Location: /');
  exit();
}

$message = "";

$fullname = $_POST['fullname'];
$dni = $_POST['dni'];
$numberPhone = $_POST['numberPhone'];
$email = $_POST['email'];
$password = $_POST['password'];

if (!empty($fullname) && !empty($dni) && !empty($numberPhone) && !empty($email) && !empty($password)) {

  $stmt = $mysqli->stmt_init();

  try {
    $stmt->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($result);

    if (!$stmt->fetch()) {
      $hashPassword = password_hash($password, PASSWORD_BCRYPT);
      $stmt->prepare("INSERT INTO users (fullname, dni, numberPhone, email, password) VALUES(?, ?, ?, ?, ?)");
      $stmt->bind_param("sssss", $fullname, $dni, $numberPhone, $email, $hashPassword);
      $stmt->execute();

      if ($stmt->affected_rows >= 1) {
        header('Location: /signin');
      }
    } else {
      $message = "El correo electrónico ya existe";
    }

    $stmt->close();
  } catch (Exception $e) {
    $message = "Algo salio mal";
  } finally {
    $mysqli->close();
  }
}

?>

<!DOCTYPE html>
<html lang="es" translate="no">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pix - Registrarse</title>
  <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>
  <section class="signup">
    <div class="signup__container">
      <div class="col col__left">
        <article class="signup-card">
          <div class="header">
            <h2>Registrarse</h2>
            <?php if (!empty($message)) : ?>
              <p class="error-message"><?php echo $message; ?></p>
            <?php endif; ?>
          </div>
          <form action="/signup" method="POST" class="body">
            <div class="pix-input-group">
              <input class="pix-input" type="text" name="fullname" placeholder="Nombre completo">
            </div>
            <div class="pix-input-group">
              <input class="pix-input" type="text" name="dni" placeholder="N&uacute;mero de documento">
            </div>
            <div class="pix-input-group">
              <input class="pix-input" type="text" name="numberPhone" placeholder="N&uacute;mero de tel&eacute;fono">
            </div>
            <div class="pix-input-group">
              <input class="pix-input" type="email" name="email" placeholder="Correo electr&oacute;nico">
            </div>
            <div class="pix-input-group">
              <input class="pix-input" type="password" name="password" placeholder="Contrase&ntilde;a">
            </div>
            <div class="pix-input-group">
              <button type="submit" class="btn btn-primary btn-full">
                Registrarse
              </button>
            </div>
          </form>
          <div class="footer">
            <span>
              &iquest;Ya tienes una cuenta&quest;
              <a href="signin" class="link">
                Ingresar
              </a>
            </span>
          </div>
        </article>
      </div>
      <div class="col col__right">
        <svg class="illustration" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 709.23259 453.76178" xmlns:xlink="http://www.w3.org/1999/xlink">
          <path d="M761.55547,257.6033h-465.293a1.807,1.807,0,0,1,0-3.61318h465.293a1.807,1.807,0,0,1,0,3.61318Z" transform="translate(-245.38371 -223.11911)" fill="#cacaca" />
          <ellipse cx="81.80307" cy="10.82345" rx="10.58751" ry="10.82345" fill="#3f3d56" />
          <ellipse cx="118.37809" cy="10.82345" rx="10.58751" ry="10.82345" fill="#3f3d56" />
          <ellipse cx="154.95311" cy="10.82345" rx="10.58751" ry="10.82345" fill="#3f3d56" />
          <path d="M739.53421,225.80181h-25.981a1.96762,1.96762,0,0,0,0,3.93446h25.981a1.96762,1.96762,0,0,0,0-3.93446Z" transform="translate(-245.38371 -223.11911)" fill="#3f3d56" />
          <path d="M739.53421,233.18618h-25.981a1.96762,1.96762,0,0,0,0,3.93446h25.981a1.96762,1.96762,0,0,0,0-3.93446Z" transform="translate(-245.38371 -223.11911)" fill="#3f3d56" />
          <path d="M739.53421,240.56085h-25.981a1.96762,1.96762,0,0,0,0,3.93446h25.981a1.96762,1.96762,0,0,0,0-3.93446Z" transform="translate(-245.38371 -223.11911)" fill="#3f3d56" />
          <path d="M424.21746,585.305l.63744-229.92024A17.57236,17.57236,0,0,1,442.456,337.881l173.64083.48141a17.57234,17.57234,0,0,1,17.50366,17.60109L632.963,585.8837a17.57234,17.57234,0,0,1-17.601,17.50376l-173.64083-.48141A17.57235,17.57235,0,0,1,424.21746,585.305Z" transform="translate(-245.38371 -223.11911)" fill="#e6e6e6" />
          <path d="M437.72932,515.89635l.4098-147.81359A16.45672,16.45672,0,0,1,454.62307,351.69l149.22967.41373a16.45743,16.45743,0,0,1,16.39363,16.484l-.56723,204.59774a16.45744,16.45744,0,0,1-16.48479,16.3928l-92.44468-.2563A73.306,73.306,0,0,1,437.72932,515.89635Z" transform="translate(-245.38371 -223.11911)" fill="#fff" />
          <path d="M587.08939,467.07912H470.72854a6.98165,6.98165,0,0,1,0-13.9633H587.08939a6.98165,6.98165,0,1,1,0,13.9633Z" transform="translate(-245.38371 -223.11911)" fill="#d49d2f" />
          <path d="M496.32793,428.79122H470.72854a6.98165,6.98165,0,1,1,0-13.9633h25.59939a6.98165,6.98165,0,1,1,0,13.9633Z" transform="translate(-245.38371 -223.11911)" fill="#d49d2f" />
          <path d="M587.08939,528.46546H470.72854a6.98165,6.98165,0,1,1,0-13.9633H587.08939a6.98165,6.98165,0,1,1,0,13.9633Z" transform="translate(-245.38371 -223.11911)" fill="#d49d2f" />
          <path d="M587.08939,497.77229H470.72854a6.98165,6.98165,0,0,1,0-13.9633H587.08939a6.98165,6.98165,0,1,1,0,13.9633Z" transform="translate(-245.38371 -223.11911)" fill="#d49d2f" />
          <circle cx="27.78001" cy="425.98178" r="27.78" fill="#d49d2f" />
          <path d="M269.374,663.55909a3.08927,3.08927,0,0,1-2.47187-1.23631l-7.57881-10.10525a3.09007,3.09007,0,1,1,4.94423-3.70792l4.95832,6.61059,12.7348-19.10195a3.0902,3.0902,0,0,1,5.1424,3.42827L271.9454,662.183a3.09146,3.09146,0,0,1-2.48545,1.37514C269.43129,663.55859,269.40262,663.55909,269.374,663.55909Z" transform="translate(-245.38371 -223.11911)" fill="#fff" />
          <rect x="26.0277" y="365.11041" width="2" height="6" fill="#2f2e41" />
          <path d="M273.41141,576.77347h-2V565.31741h2Zm0-22.91309h-2V542.40433h2Zm0-22.91211h-2v-11.457h2Zm0-22.91308h-2V496.57913h2Zm0-22.91309h-2V473.66605h2Z" transform="translate(-245.38371 -223.11911)" fill="#2f2e41" />
          <polygon points="28.028 239.091 26.028 239.091 26.028 232.091 33.028 232.091 33.028 234.091 28.028 234.091 28.028 239.091" fill="#2f2e41" />
          <path d="M372.81375,457.21H361.01346v-2h11.80029Zm-23.60058,0h-11.8003v-2h11.8003Zm-23.60059,0H313.81229v-2h11.80029Zm-23.60058,0H290.2117v-2H302.012Z" transform="translate(-245.38371 -223.11911)" fill="#2f2e41" />
          <rect x="139.23083" y="232.09088" width="6" height="2" fill="#2f2e41" />
          <rect x="669.3402" y="304.76178" width="2" height="6" fill="#2f2e41" />
          <path d="M916.72391,514.7471h-2V501.61331h2Zm0-26.26855h-2V475.34476h2Z" transform="translate(-245.38371 -223.11911)" fill="#2f2e41" />
          <polygon points="671.34 239.091 669.34 239.091 669.34 234.091 664.34 234.091 664.34 232.091 671.34 232.091 671.34 239.091" fill="#2f2e41" />
          <path d="M897.29178,457.21H884.86014v-2h12.43164Zm-24.86328,0H859.99637v-2H872.4285Zm-24.86377,0H835.13309v-2h12.43164Zm-24.86328,0H810.26981v-2h12.43164Zm-24.86328,0H785.406v-2h12.43213Zm-24.86377,0H760.54276v-2H772.9744Zm-24.86328,0H735.67948v-2h12.43164Zm-24.86328,0H710.81571v-2h12.43213Zm-24.86377,0H685.95242v-2h12.43165Z" transform="translate(-245.38371 -223.11911)" fill="#2f2e41" />
          <rect x="422.13708" y="232.09088" width="6" height="2" fill="#2f2e41" />
          <circle cx="670.96861" cy="355.98178" r="27.78" fill="#d49d2f" />
          <path d="M921.81734,579.10094l5.465-5.465a3.86439,3.86439,0,0,0-5.465-5.46512l-5.465,5.465-5.465-5.465a3.86439,3.86439,0,0,0-5.465,5.46512l5.465,5.465-5.465,5.465a3.86436,3.86436,0,1,0,5.465,5.465l5.465-5.465,5.465,5.465a3.86436,3.86436,0,1,0,5.465-5.465Z" transform="translate(-245.38371 -223.11911)" fill="#fff" />
          <polygon points="593.025 189.762 599.025 225.376 656.025 194.762 593.025 189.762" fill="#2f2e41" />
          <polygon points="586.215 411.204 574.274 410.717 570.471 364.429 588.094 365.148 586.215 411.204" fill="#ffb6b6" />
          <path d="M832.409,501.88089c21.65988-6.6036,26.10513-34.83683,38-41-.03039-14.91117.56944-61.152-14.31576-60.27152-8.2895.49033-54.47586,85.03053-56.45564,99.03659-3.67322,25.98611,15.93847,92.30925,13.66277,96.86558l22.77418,1.44122.13307-1.79244c.361-4.86239,3.99152-19.5229-.14985-22.09625l-1.56926-.97511v0c.01381-5.05554,1.11721-13.66779-3.44268-15.85094l0,0a.45861.45861,0,0,1-.19274-.65367Z" transform="translate(-245.38371 -223.11911)" fill="#2f2e41" />
          <path d="M837.75119,644.68l-7.98509.47079-1.86978-7.45484-3.20593,7.75409L803.512,646.6987a4.769,4.769,0,0,1-3.21685-8.51882l16.22376-12.67745-.44935-7.62154,17.8515.013Z" transform="translate(-245.38371 -223.11911)" fill="#2f2e41" />
          <polygon points="677.229 327.78 689.141 328.745 698.531 283.261 680.951 281.836 677.229 327.78" fill="#ffb6b6" />
          <path d="M917.94337,435.62751c-10.68309,18.77387-29.7946,23.25606-49.61223,26.54068-8.61658-12.16958-21.7506-29.13594-9.10955-37.04469,7.03974-4.40434,68.06486-40.03448,77.48552-29.48267,24.59557,27.5487,7.04909,116.19975,8.56058,114.24006l-19.48222-.28322-1.14721-1.38366a13.09952,13.09952,0,0,1-1.99818-13.42189l.71379-1.70408,0,0a13.09953,13.09953,0,0,1-.80241-13.97121l.24682-.44529Z" transform="translate(-245.38371 -223.11911)" fill="#2f2e41" />
          <path d="M922.30074,534.30952l17.72124,2.15273-1.37061,7.51074,14.566,14.55193a4.769,4.769,0,0,1-4.22651,8.06567L928.1204,562.782l-2.2416-8.08574-2.76032,7.173-7.869-1.436Z" transform="translate(-245.38371 -223.11911)" fill="#2f2e41" />
          <path d="M875.997,285.88089h-8.1757a10.3291,10.3291,0,0,0-8.49234,4.44943l-5.92,8.55057-14.74955,2.68259a25.88127,25.88127,0,0,0-10.58115,31.24819c10.43685,27.29807,15.47506,78.4631,5.3307,101.06922,0,0,61.5424,5.57485,77-13s3-109,3-109l-23-13-5.91946-8.55032A10.32909,10.32909,0,0,0,875.997,285.88089Z" transform="translate(-245.38371 -223.11911)" fill="#d49d2f" />
          <path d="M914.13807,445.65388a6.87461,6.87461,0,0,0-1.202-10.47258L926.409,390.88089l-15-9-8.32411,55.63259a6.91183,6.91183,0,0,0,11.05321,8.1404Z" transform="translate(-245.38371 -223.11911)" fill="#ffb6b6" />
          <path d="M927.409,395.88089l-18-7,.76849-8.98724L888.7904,333.07744a17.33239,17.33239,0,0,1,11.56253-24.01672h0a17.35086,17.35086,0,0,1,21.01712,12.61282l14.05607,56.24312C937.0524,386.64621,935.21359,393.16592,927.409,395.88089Z" transform="translate(-245.38371 -223.11911)" fill="#d49d2f" />
          <path d="M902.50894,258.63089a30.55,30.55,0,1,0-61.1,0v19.15a4.10559,4.10559,0,0,0,4.1,4.1h.75a29.29623,29.29623,0,0,0,1.57-7.69,27.451,27.451,0,0,1,3.56,7.69h47.01a4.11416,4.11416,0,0,0,4.11-4.1C904.97891,272.74088,906.089,266.96091,902.50894,258.63089Z" transform="translate(-245.38371 -223.11911)" fill="#2f2e41" />
          <circle cx="625.34425" cy="36.17573" r="22.39729" fill="#ffb8b8" />
          <path d="M847.716,259.20858a2.28,2.28,0,0,1-.53365-1.81757l2.65312-18.475a2.283,2.283,0,0,1,1.28993-1.74989c13.54208-6.33791,27.27473-6.34593,40.81681-.024a2.29725,2.29725,0,0,1,1.30284,1.85676l2.771,14.499a2.28538,2.28538,0,0,1-.58219,1.75079c-.431.47376-1.03378,10.89224-1.675,10.89224.54071-6.20981-.76733-9.18094-5.504-6.146a2.28855,2.28855,0,0,1-2.06583-1.31531l-1.93847-4.15344a1.36775,1.36775,0,0,0-2.59678.40876l-.38293,3.06253a2.28306,2.28306,0,0,1-2.26215,1.99746c-7.91461,3.92717-18.29388,2.87025-29.56988,0A2.27983,2.27983,0,0,1,847.716,259.20858Z" transform="translate(-245.38371 -223.11911)" fill="#2f2e41" />
          <path d="M888.5875,383.82124H851.879a4.74663,4.74663,0,0,1-4.7412-4.74121V339.62209a4.74645,4.74645,0,0,1,4.7412-4.7412H888.5875a4.74645,4.74645,0,0,1,4.7412,4.7412V379.08A4.74663,4.74663,0,0,1,888.5875,383.82124Z" transform="translate(-245.38371 -223.11911)" fill="#3f3d56" />
          <circle cx="607.52797" cy="117.53564" r="2.74946" fill="#e6e6e6" />
          <circle cx="607.52797" cy="117.53564" r="1.64967" fill="#3f3d56" />
          <path d="M895.0998,357.22742a8.34008,8.34008,0,0,1-12.78038-.45842L849.409,365.88089l-5-11,39.79477-10.24809a8.38533,8.38533,0,0,1,10.89606,12.59462Z" transform="translate(-245.38371 -223.11911)" fill="#ffb8b8" />
          <path d="M853.3181,366.164l-9.23454,2.94767c-10.04267,10.61081-13.59628,2.91133-25.43174,2.11455-2.22689-.14975-3.9699-1.97783-5.17991-5.43236a21.25624,21.25624,0,0,1,.46348-14.894L830.376,309.696l6.881-5.638,9.60829,11.5139-7.37651,31.65426,12.11014,6.17244Z" transform="translate(-245.38371 -223.11911)" fill="#d49d2f" />
        </svg>
      </div>
    </div>
  </section>
</body>

</html>