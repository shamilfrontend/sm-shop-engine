<?php define("_SMARTMEDIA", TRUE); session_start();

    header('Content-Type: text/html; charset=utf-8');

		require ("config.php");
		require ("library/PHPMailer/PHPMailerAutoload.php");
		require ("library/library.php");

	if (isset($_GET["do"]) == "logout") {
		unset($_SESSION['auth']); 
		if (!empty($_SESSION['RF'])) unset($_SESSION['RF']); 
			setcookie ("login", "", time() - (10 * 24 * 3600), "/", $_SERVER['HTTP_HOST'], 0, 1);
			setcookie ("password", "", time() - (10 * 24 * 3600), "/", $_SERVER['HTTP_HOST'], 0, 1);
		redirect();
	}	
    ###########################################
	if (($_SERVER['REQUEST_METHOD'] == "POST") || (!empty($_COOKIE['login']) && !empty($_COOKIE['password']))) {
		
		$login = !empty($_COOKIE['login']) ? $_COOKIE['login'] : (!empty($_POST["login"]) ? $_POST["login"] : '');
		$password = !empty($_COOKIE['password']) ? $_COOKIE['password'] : (!empty($_POST["password"]) ? $_POST["password"] : '');
		$error = '';
		$ajax = isset($_GET['ajax']) ? true : false;
		$ulogin = isset($_GET['ulogin']) ? true : false;
		$reg = isset($_GET['reg']) ? true : false;
		
		if ($reg) {
			connect(HOST, USER, PASS, DB);
				regUser(false,$ajax,$_POST['login'],$_POST['passw'],$_POST['passw2'],$_POST['email'],$_POST['phone'],$_POST['name'],$_POST['surname'],$_POST['middle'],$_POST['address']);
			//close_connect($connect);
		}
		
		if ($ulogin) {
			$error = "unknown";
			if (!empty($_POST['token'])) {
				$response = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
				$user = json_decode($response, true);
				//$user['network'] - соц. сеть, через которую авторизовался пользователь
				//$user['identity'] - уникальная строка определяющая конкретного пользователя соц. сети
				//$user['first_name'] - имя пользователя
				//$user['last_name'] - фамилия пользователя
				if (!empty($user['network']) && !empty($user['identity'])) {
					connect(HOST, USER, PASS, DB);
						$user_soc = soc_auth($user['network'], $user['identity']);
					//close_connect($connect);
					
					if (!empty($user_soc['user_id'])) {
						//auth
						$_SESSION['auth'] = $user_soc;
						$_SESSION['auth']['csrf_token'] = get_csrf_token();
						$_SESSION['auth']['photo'] = $user['photo'];
						$_SESSION['auth']['photo_big'] = $user['photo_big'];
						$_SESSION['auth']['link'] = $user['profile'];
						
						if (!empty($_GET['redirect_uri'])) redirect($_GET['redirect_uri']);
						
					} else {
						//reg
						//connect(HOST, USER, PASS, DB);
							regUser(true,false,false,false,false,false,false,$user['first_name'],$user['last_name'],false,false,$user['network'], $user['identity'],$user['photo'], $user['photo_big'], $user['profile']);
						//close_connect($connect);
					}
				}
			}
		}

		if (!empty($login) && !empty($password)) {

			if (!empty(GOOGLE_KEY) && !$ajax) {
				if (empty($_POST['g-recaptcha-response']) || !check_captcha($_POST['g-recaptcha-response'])) {$error .= 'Подтвердите что Вы не робот!<br>';}
			}
			if (empty($error)) {
				connect(HOST, USER, PASS, DB);
					$user = auth($login, $password);
				close_connect($connect);

				if (!empty($user['user_id'])) {
					$_SESSION['auth'] = $user;
					$_SESSION['auth']['csrf_token'] = get_csrf_token();
					if (isset($_POST['remember_me'])) {
						if ($ajax && $_POST['remember_me'] == "true") {
							setcookie("login", $login, time() + (10 * 24 * 3600), "/", $_SERVER['HTTP_HOST'], 0, 1);
							setcookie("password", $password, time() + (10 * 24 * 3600), "/", $_SERVER['HTTP_HOST'], 0, 1);
						}
					}
					if ($ajax) {
						header('Content-Type: application/json');
						die(json_encode(['response'=>'success']));
					}
					if (!empty($_SESSION['HTTP_REFERER'])) {
						$dummy = $_SESSION['HTTP_REFERER']; unset($_SESSION['HTTP_REFERER']);
						redirect($dummy);
					}
				} else {
					$error .= 'Неверная пара логин/пароль';
					if ($ajax) {header('Content-Type: application/json'); die(json_encode(['response'=>$error]));}
					if (isset($_COOKIE['login'])) setcookie ("login", "", time() - (10 * 24 * 3600), "/", $_SERVER['HTTP_HOST'], 0, 1);
					if (isset($_COOKIE['password'])) setcookie ("password", "", time() - (10 * 24 * 3600), "/", $_SERVER['HTTP_HOST'], 0, 1);
				}
			}

		} else {
			$error .= "Заполните все поля!";
			if ($ajax) {header('Content-Type: application/json'); die(json_encode(['response'=>$error], true));}
		}
	}
	##############################################
	if (isset($_SESSION['auth']['user_status'])) {
		if ($_SESSION['auth']['user_status'] == 1 || $_SESSION['auth']['user_status'] == 3 || $_SESSION['auth']['user_status'] == 4)
			redirect("/sm-admin/");
		else redirect();
	}
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="ru"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Авторизация на сайте</title>
	<link rel="stylesheet" href="/sm-admin/static/auth/css/style.css">
	<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<?php if (!empty(GOOGLE_KEY)): ?><script src='https://www.google.com/recaptcha/api.js'></script><?php endif; ?>
</head>
<body>

  <section class="container">
  
    <div class="login">
      <h1>Авторизация на сайте</h1>
	  <p><img style="margin-left:57px;width:200px;" src="/sm-admin/static/auth/img/logo.png"></p>
	  <?php if (isset($error)): ?><p style="color:red;padding:10px;border:1px dotted red;text-align:center;margin-bottom:5px;"><?=$error?></p><?php endif; ?>
      <form method="post" action="">
        <p><input type="text" name="login" value="" placeholder="Логин или ID"></p>
        <p><input type="password" name="password" value="" placeholder="Пароль"></p>
		<?php if (!empty(GOOGLE_KEY)): ?><div style="margin-top: 4px;margin-left: 4px;" class="g-recaptcha" data-sitekey="<?=GOOGLE_HTML_KEY?>"></div><?php endif; ?>
        <p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Запомнить меня
          </label>
        </p>
        <p class="submit"><input type="submit" name="commit" value="Войти"></p>
      </form>
    </div>

  </section>
</body>
</html>