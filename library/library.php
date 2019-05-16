<?php defined("_SMARTMEDIA") or die();

function display_errors($display=true) {
	if ($display) {
		ini_set('error_reporting', E_ALL);
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
	} else {
		ini_set('error_reporting', 0);
		ini_set('display_errors', 0);
		ini_set('display_startup_errors', 0);
	}
}

function get_route() {
	$action = explode("?", $_SERVER["REQUEST_URI"]);
	$action = !empty($action[0]) ? explode("/", $action[0]) : '';
	$controller = !empty($action[1]) ? $action[1] : 'index';
	$action = !empty($action[2]) ? explode("/{$controller}/", explode("?", $_SERVER["REQUEST_URI"])[0])[1] : '';
	$action = (substr($action, -1) == '/') ? substr($action, 0, -1) : $action;
	
	return ['controller' => $controller, 'action' => $action];
}

function redirect($http = false) {
    header("HTTP/1.1 301 Moved Permanently");
	if ($http) header("Location: {$http}");
        else header("Location: /"); die();
}

function print_array($array, $die = true) {
    echo "<pre>";
        print_r($array);
    echo "</pre>";
    if ($die) die();
}

function check_captcha($response) {
	$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.GOOGLE_KEY.'&response='.$response.'');
	$obj = json_decode($response);
	if ($obj->success) {
		return true;
	} return false;
}

function auth($login, $passwd) {
	global $connect,$config;
	$login = clearObject($login);
	$passwd = clearObject($passwd);
	$passwd = md5(SECRET . md5(SALT.$passwd));
	
	$query = "SELECT * FROM {$config["prefix"]}users WHERE `user_login` = '{$login}' AND `user_password` = '{$passwd}' LIMIT 1";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : array();
}

function soc_auth($network, $identity) {
	global $connect, $config;
	$network = clearObject($network);
	$identity = clearObject($identity);
	
	$query = "SELECT * FROM {$config["prefix"]}users WHERE `user_network` = '{$network}' AND `user_identity` = '{$identity}' LIMIT 1";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : array();
}

function regUser($soc,$ajax,$login,$password,$password2,$email,$phone,$name,$surname,$middle,$address,$network=false,$identity=false,$photo=false,$photo_big=false,$link=false) { 
	global $connect,$config; $_SESSION['answer'] = "";
	
    $args['login'] = clearObject($login);
    $password = clearObject($password);
    $password2 = clearObject($password2);
	$args['email'] = clearObject($email);
	$args['phone'] = clearObject($phone);
	$args['name'] = clearObject($name);
	$args['surname'] = clearObject($surname);
	$args['middle'] = clearObject($middle);
	$args['address'] = clearObject($address);
	$network = clearObject($network);
	$identity = clearObject($identity);
	$photo = clearObject($photo);
	$photo_big = clearObject($photo_big);
	$link = clearObject($link);
	
	if ($soc) {
		$query = "SELECT `user_login` FROM `{$config["prefix"]}users` WHERE `user_login` LIKE 'guest%' ORDER BY `user_id` DESC LIMIT 1";
		$request = mysqli_query($connect, $query) or
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		$row = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0]['user_login'] : false;
		$args['login'] = !empty($row) ? abs((int)substr($row, 0, 4)) : 'guest1';
		$password = mt_rand(32767, 393210);
		$password2 = $password;
	}
	
	if (empty($args['login']) || empty($password) || empty($password2)) {
		$result = '<div class="alert alert-danger"><strong>Ошибка!</strong> Пожалуйста заполните поля логина и пароля!</div>';
		if ($ajax) {
			header('Content-Type: application/json');
			die(json_encode(['response'=>$result]));
		}
		$_SESSION['answer'] .= $result;
	}
	
	if ($password != $password2) {
		$result = '<div class="alert alert-danger"><strong>Ошибка!</strong> Введенные Вами пароли не совпадают!</div>';
		if ($ajax) {
			header('Content-Type: application/json');
			die(json_encode(['response'=>$result]));
		}
		$_SESSION['answer'] .= $result;
	}
	
	if (!empty($args['login'])) {
		$query = "SELECT `user_id` FROM `{$config["prefix"]}users` WHERE `user_login` = '{$args['login']}' LIMIT 1";
		$request = mysqli_query($connect, $query) or
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		$row = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0]['user_id'] : false;
		if ($row) {
			$result = '<div class="alert alert-danger"><strong>Ошибка!</strong> Выбранный Вами логин уже занят, пожалуйста придумайте другой!</div>';
			if ($ajax) {
				header('Content-Type: application/json');
				die(json_encode(['response'=>$result]));
			}
			$_SESSION['answer'] .= $result;
		}
	}
	
	if (!empty($_SESSION['answer'])) {
		redirect();
	}
	
	$args['password'] = md5(SECRET . md5(SALT.$password));
	
	$query = "INSERT INTO {$config["prefix"]}users (`user_network`, `user_identity`, `user_login`, `user_password`, `user_name`, `user_surname`, `user_middlename`, `user_email`, `user_phone`, `user_address`, `user_about`, `user_status`, `user_date`) 
					VALUES ('{$network}', '{$identity}', '{$args['login']}', '{$args['password']}', '{$args['name']}', '{$args['surname']}', '{$args['middle']}', '{$args['email']}', '{$args['phone']}', '{$args['address']}', '{$args['about']}', 3, NOW())";
    $request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$result = '<div class="alert alert-success"><strong>Поздравляем!</strong> Вы успешно зарегистрированны!</div>';
		if ($ajax) $result = 'success';
		//connect(HOST, USER, PASS, DB);
			$user = auth($args['login'], $password);
		//close_connect($connect);
		
		if (!empty($user)) {
			$_SESSION['auth'] = $user;
			$_SESSION['auth']['csrf_token'] = get_csrf_token();
			$_SESSION['auth']['photo'] = $photo;
			$_SESSION['auth']['photo_big'] = $photo_big;
			$_SESSION['auth']['link'] = $link;
		} else {
			die('что-то пошло не так!');
		}
		
		if (!empty($args['email']) && filter_var($args['email'], FILTER_VALIDATE_EMAIL)) {
			$sm_mail['link'] = 'http://' . $_SERVER['HTTP_HOST'] . '/login.php';
			$sm_mail['from'] = null;
			$sm_mail['to_name'] = explode('@', $args['email'])[0];
			$sm_mail['to_email'] = $args['email'];
			$sm_mail['subject'] = 'Вы зарегистрированны на сайте! ' . $config['settings']->title->value;
			$sm_mail['body'] = '
								Ваши данные для входа: 
								<table>
									<tbody>
										<tr>
											<td><strong>Логин:</strong> ' . $args['login'] . '</td>
											<td><strong>Пароль:</strong> ' . $args['password'] . '</td>
										</tr>
										<tr>
											<td><strong>Внимание:</strong> Если Вы считаете что получили это пись по ошибке, то пожалуйста проигнорируйте его!</td>
										</tr>
									</tbody>
								</table>
			';
			sm_mail($sm_mail);
		}
		
	} else {
		$result = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При регистрации произошел сбой! Пожалуйста сообщите об этом администратору!</div>';
	}
	
	if ($ajax) {
		header('Content-Type: application/json');
		die(json_encode(['response'=>$result]));
	}
	$_SESSION['answer'] .= $result;
	if (!empty($_GET['redirect_uri'])) redirect($_GET['redirect_uri']);
	redirect();  
}

function is_demo() {
	if ($_SESSION['auth']['user_status'] == 1) return true;
	return false;
}

function demoRedirect($json=false) {
	$message = '<div class="alert alert-danger"><strong>Доступ ограничен!</strong> Вы являетесь <b>DEMO</b> пользователем и часть функций системы для Вас ограничены!</div>';
	if ($json) {
		header('Content-Type: application/json');
		die(json_encode(['response'=>'error', 'result'=>$message]));
	} else {
		$_SESSION['answer'] = $message;
		redirect("?view=dashboard");
	}
}

function clearObject($item, $html=false) {
    global $connect;
	
    if ($html) {
		return mysqli_real_escape_string($connect, htmlspecialchars(trim($item), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
	} return mysqli_real_escape_string($connect, htmlspecialchars(strip_tags(trim($item)), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
}

function connect($host, $user, $pass, $db) {
    global $connect;
	if (!$connect) {
		$connect = mysqli_connect($host, $user, $pass, $db) or
			die("You have an error in function " . __FUNCTION__ . " on line " . __LINE__ . ".<br> " . mysqli_connect_errno() . ": " . mysqli_connect_error());

		mysqli_query($connect, "SET NAMES 'UTF8'") or die("You have an error in function " . __FUNCTION__ . " on line " . __LINE__ . ".<br> " . mysqli_errno($connect) . ": " . mysqli_error($connect));
	}
}

function get_csrf_token() {
	$userId = !empty($_SESSION['auth']['user_id']) ? $_SESSION['auth']['user_id'] : mt_rand(10000, 80000);
	return md5($userId . uniqid() . SECRET);
}

function check_csrf_token($csrf_token) {
	if (!empty($_SESSION['auth']['csrf_token']))
		if ($_SESSION['auth']['csrf_token'] == $csrf_token)
			return true;
	return false;
}

function get_csrf_alert($json=false) {
	$message = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Неверный CSRF Token для действия!</div>';
	if ($json) {
		header('Content-Type: application/json');
		die(json_encode(['response'=>'error', 'result'=>$message]));
	} else {
		$_SESSION['answer'] = $message;
		redirect("?view=dashboard");
	}
}

function close_connect($connect) {
	if ($connect) {
		mysqli_close($connect) or die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	}
}

function is_post() {
	if ($_SERVER["REQUEST_METHOD"] == "POST") return true;
	return false;
}

function getSettings() {
	global $config;
	
	if (file_exists($config["settings_path"]))
		return json_decode(file_get_contents($config["settings_path"]));
	else {
		$json = json_encode(
					array(
						"title" => array ("name" => "title", "value" => "Название сайта", "type" => "string", "object" => "text", "label" => "Название сайта:", "remove" => 0, "tags" => 0, "default" => 0),
						"tagline" => array ("name" => "tagline", "value" => "Слоган сайта", "type" => "string", "object" => "text", "label" => "Слоган сайта:", "remove" => 0, "tags" => 0, "default" => 0),
						"description" => array ("name" => "description", "value" => "Описание сайта", "type" => "string", "object" => "text", "label" => "Описание сайта:", "remove" => 0, "tags" => 0, "default" => 0),
						"keywords" => array ("name" => "keywords", "value" => "Ключевые слова", "type" => "string", "object" => "text", "label" => "Ключевые слова:", "remove" => 0, "tags" => 0, "default" => 0),
						"footer" => array ("name" => "footer", "value" => "Подвал сайта", "type" => "string", "object" => "text", "label" => "Подвал сайта:", "remove" => 0, "tags" => 0, "default" => 0),
						"email" => array ("name" => "email", "value" => "example@email.com", "type" => "string", "object" => "text", "label" => "Почта администратора:", "remove" => 0, "tags" => 0, "default" => 0),
						"phone" => array ("name" => "phone", "value" => "+7 (999) 999-99-99", "type" => "string", "object" => "text", "label" => "Контактный телефон:", "remove" => 0, "tags" => 0, "default" => 0),
						"perpage" => array ("name" => "perpage", "value" => 10, "type" => "integer", "object" => "number", "label" => "Количество объектов на страницу:", "remove" => 0, "tags" => 0, "default" => 0),
						"redirect" => array ("name" => "redirect", "value" => 0, "type" => "boolean", "object" => "checkbox", "label" => "Открывать созданный объект после его добавления?", "remove" => 0, "tags" => 0, "default" => 0),
						"checkdata" => array ("name" => "checkdata", "value" => 0, "type" => "boolean", "object" => "checkbox", "label" => "Проверять заголовки и названия с ранее добавленными?", "remove" => 0, "tags" => 0, "default" => 0),
						//"feedback" => array ("name" => "feedback", "value" => 0, "type" => "boolean", "object" => "checkbox", "label" => "Включить форму обратной связи?", "remove" => 0, "tags" => 0, "default" => 0),
						//"callback" => array ("name" => "callback", "value" => 0, "type" => "boolean", "object" => "checkbox", "label" => "Включить форму обратного звонка?", "remove" => 0, "tags" => 0, "default" => 0),
						//"default_user" => array ("name" => "default_user", "value" => array(array("key" => 1, "value" => "Пользователь"),array("key" => 2, "value" => "Администратор")), "type" => "integer", "object" => "select", "label" => "Роль пользователей по умолчанию:", "remove" => 0, "tags" => 0, "default" => 1),
						//"user_size" => array ("name" => "user_size", "value" => array(100,100), "type" => "custom", "object" => "multiplyText", "label" => "Размер аватара пользователей:", "remove" => 0, "tags" => 0, "default" => "px;"),
						//"quote" => array ("name" => "quote", "value" => "", "type" => "string", "object" => "textarea", "label" => "Цитата (небольшой текст):", "remove" => 0, "tags" => 0, "default" => 0),
						//"fulltext" => array ("name" => "fulltext", "value" => "", "type" => "string", "object" => "textarea", "label" => "Полный текст:", "remove" => 0, "tags" => 1, "default" => 0)
					)
		);
		file_put_contents($config["settings_path"], $json, LOCK_EX);
		return json_decode($json);
	}
}

function getObjectValue($object, $value = 0) {
	if (empty($object->type)) return false;
	switch($object->type) {
		case("string"):
			if ($object->tags)
				return htmlspecialchars_decode($object->value, ENT_QUOTES | ENT_SUBSTITUTE);
			else
				return $object->value;
		break;
		
		case("custom"):
			if ($object->object == "multiplyText") {
				return htmlspecialchars($object->value[$value], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
			} return "default custom value";
		break;
		
		case("integer"):
		case("boolean"):
			return abs((int)$object->value);
		break;
		
		default: return "default value";
	}
}

function htmlDecode($string) {
	return htmlspecialchars_decode($string, ENT_QUOTES | ENT_SUBSTITUTE);
}

function updateSettings() {
	global $config;
	
	$settings = getSettings();
	$_SESSION['answer'] = "";
	
	if (isset($_POST['updateSettings'])) {
		//updateSettings
		if (is_object($settings) && !empty($settings)) {
			foreach($settings as $item => $object) {
				//if (isset($_POST[$item])) {
					switch($settings->$item->object) {
						case("text"):
							if (isset($_POST[$item])) $settings->$item->value = htmlspecialchars(strip_tags(trim($_POST[$item])), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
							continue;
						break;
						
						case("textarea"):
							if (isset($_POST[$item]))
								if ($settings->$item->tags)
									$settings->$item->value = htmlspecialchars(trim($_POST[$item]), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
								else
									$settings->$item->value = htmlspecialchars(strip_tags(trim($_POST[$item])), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
							continue;
						break;
						
						case("number"):
							if (isset($_POST[$item])) {
								$dummy = abs((int)$_POST[$item]);
								$settings->$item->value = ($dummy > 100) ? 100 : (($dummy < 1) ? 1 : $dummy);
							}
						break;
						
						case("checkbox"):
                            $settings->$item->value = isset($_POST[$item]) ? 1 : 0;
						break;
                            
                        case("select"):
                            if (isset($_POST[$item])) {
							  foreach($settings->$item->value as $ID => $value) {
								if ($settings->$item->value[$ID]->key == $_POST[$item]) {
									$settings->$item->default = $_POST[$item];
									break;
								}	
							  }
                            }
						break;
						
						case("multiplyText"):
                            if (isset($_POST[$item]))
                                foreach($settings->$item->value as $ID => $value) {
                                    $settings->$item->value[$ID] = !empty($_POST[$item][$ID]) ? htmlspecialchars($_POST[$item][$ID], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : "";
                                }
						break;

						default: $_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Исключительная ошибка!</strong> Неверный тип объекта!</div>';
					}
				//}
			} 
			
			if (file_put_contents($config["settings_path"], json_encode($settings), LOCK_EX) !== FALSE) {
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Настройки успешно обновлены</div>';
			} else {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При обновлении настроек произошел сбой!</div>';
			}
		} else {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось идентифицировать настройки!</div>';
		}
	} else if (isset($_POST['addSettings'])) {
		//addSettings
		if (is_object($settings) && !empty($settings)) {
			foreach($settings as $item => $object) {
				if ($item == $_POST['name']) {
					$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Имя объекта <b>' . $item . '</b> уже используется, пожалуйста придумайте другой!</div>';
					redirect("?view=settings");
				}
				
				if (array_key_exists($item, $_POST)) {
					unset($_POST[$item]);
				} 
				
				if (isset($_POST['addSettings'])) {
					unset($_POST['addSettings']);
				}
			}
			
			if (empty($_POST['name']) || empty($_POST['label'])) {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Имя объекта и Значение метки не должны быть пусты!</div>';
				redirect("?view=settings");
			}
			
			if (!preg_match("/^[a-z_0-9]+$/", $_POST['name'])) {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Имя объекта <b>' . $_POST['name'] . '</b> содержит запрещенные символы, разрешаются только латинские буквы нижнего регистра, цифры и знак подчеркивания!</div>';
				redirect("?view=settings");
			}
			
			/*if (!preg_match("/^[а-яеА-Я ]+$/iu", $_POST['label'])) {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Значение метки <b>' . $_POST['label'] . '</b> содержит запрещенные символы, разрешаются только Русские буквы и пробел!</div>';
				redirect("?view=settings");
			}*/
			
			$args = array();
			$args['name'] = $_POST['name'];
			$args['label'] = $_POST['label'];
			$args['remove'] = 1;
			$args['tags'] = abs((int)$_POST['tags']);
			$args['default'] = 0;
			
			switch($_POST['object']) {
				case('text'):
					$args['value'] = htmlspecialchars(strip_tags(trim($_POST['value'])), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
					$args['object'] = 'text';
					$args['type'] = 'string';
				break;
				
				case('textarea'):
					if ($args['tags']) {
						$args['value'] = htmlspecialchars(trim($_POST['value']), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
					} else {
						$args['value'] = htmlspecialchars(strip_tags(trim($_POST['value'])), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
					}
					
					$args['object'] = 'textarea';
					$args['type'] = 'string';
					
				break;
				
				case('select'):	
					switch($_POST['type']) {
						case('string'):
							$args['type'] = 'string';
						break;
						
						case('integer'):
							$args['type'] = 'integer';
						break;
						
						default:
							$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Исключительная ошибка!</strong> Неверный тип объекта!</div>';
							redirect("?view=settings");
					}

					$args['object'] = 'select';
					
					if (!empty($_POST['key']) && is_array($_POST['key'])) {
						$i = 0;
						foreach($_POST['key'] as $ID => $item) {
							if (empty($item)) {
								$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Имя параметра для объекта <b>' . $args['name'] . '</b> не должно быть пустым!</div>';
							}
							
							if (!preg_match("/^[a-z_0-9]+$/", $item)) {
								$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Имя параметра <b>' . $item . '</b> для объекта <b>' . $args['name'] . '</b> содержит запрещенные символы, разрешаются только маленькие латинские буквы, цифры и знак подчеркивания!</div>';
							}
							
							if (empty($_POST['value'][$ID])) {
								$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Значение параметра <b>' . $item . '</b> не должно быть пустым!</div>';
							}
							
							if (!preg_match("/^[a-zA-Z_0-9а-яеА-Я ]+$/iu", $_POST['value'][$ID])) {
								$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Значение параметра <b>' . $item . '</b> содержит запрещенные символы, разрешаются большие и маленькие латинские и кириллические буквы, цифры, пробел и знак подчеркивания!</div>';
							}
						
							$args['value'][$i]['key'] = $item;
							$args['value'][$i]['value'] = ($args['type'] == 'string') ? htmlspecialchars(strip_tags(trim($_POST['value'][$ID])), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : abs((int)$_POST['value'][$ID]);
							$i++;
						}
						
						if (!empty($_SESSION['answer'])) {
							redirect("?view=settings");
						}
					} else {
						$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Исключительная ошибка!</strong> Неверные параметры для объекта <b>' . $args['name'] . '</b>!</div>';
						redirect("?view=settings");
					}
	
				break;
				
				case('number'):
					$dummy = abs((int)$_POST['value']);
					$args['value'] =  ($dummy > 100) ? 100 : (($dummy < 1) ? 1 : $dummy);
					$args['object'] = 'number';
					$args['type'] = 'integer';
				break;
				
				case('checkbox'):
					$args['value'] =  abs((int)$_POST['value']);
					$args['object'] = 'checkbox';
					$args['type'] = 'boolean';
				break;
				
				case('multiplyText'):
					if (!empty($_POST['value']) && is_array($_POST['value'])) {
						foreach($_POST['value'] as $item) {
							if (empty($item)) {
								$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Значения для объекта <b>' . $args['name'] . '</b> не должны быть пустыми!</div>';
							}
							
							$args['value'][] = htmlspecialchars(strip_tags(trim($item)), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
						}
					} else {
						$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Исключительная ошибка!</strong> Неверные значения для объекта <b>' . $args['name'] . '</b>!</div>';
						redirect("?view=settings");
					}
					
					if (!empty($_SESSION['answer'])) {
						redirect("?view=settings");
					}
					
					$args['object'] = 'multiplyText';
					$args['type'] = 'custom';
					$args['default'] = htmlspecialchars(strip_tags(trim($_POST['default'])), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
				break;
				
				default: $_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Исключительная ошибка!</strong> Неизвестный объект!</div>';
			}
			
			$settings->{$args['name']} = (object)$args;
			
			if (file_put_contents($config["settings_path"], json_encode($settings), LOCK_EX) !== FALSE) {
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Настройка успешно добавлена!</div>';
			} else {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При добавлении новой настройки произошел сбой!</div>';
			}
			
		} else {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось идентифицировать настройки!</div>';
		}
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Исключительная ошибка!</strong> Неверные параметры!</div>';
	}

	redirect("?view=settings");
}

function removeSetting($name) {
	global $config;
	$settings = getSettings();
	$_SESSION['answer'] = "";
	
	if (!preg_match("/^[a-z_0-9]+$/", $name)) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Неверные параметры для удаления!</div>';
		redirect("?view=settings");
	}
	
	if (!empty($settings->{$name})) {
		if ($settings->{$name}->remove) {
			unset($settings->{$name});
			
			if (file_put_contents($config["settings_path"], json_encode($settings), LOCK_EX) !== FALSE) {
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Настройка успешно удалена!</div>';
			} else {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При удалении настройки произошел сбой!</div>';
			}
			
		} else {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Настройку <b>' . $name . '</b> запрещено удалять!</div>';
		}
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Настройка <b>' . $name . '</b> которую вы пытаетесь удалить не существует!</div>';
	}
	
	redirect("?view=settings");
}

function getModules() {
	global $config;
	
	if (file_exists($config["modules_path"]))
		return json_decode(file_get_contents($config["modules_path"]));
	else {
		$json = json_encode(
					array(
						"settings" => array ("active" => 0, "name" => "Настройки системы", "description" => "Конструктор системных настроек"),
						"users" => array ("active" => 0, "name" => "Пользователи", "description" => "Пользователи и роли"),
						"plugins" => array ("active" => 0, "name" => "Плагины", "description" => "Возможности кастомных плагинов"),
						"pages" => array ("active" => 0, "name" => "Страницы", "description" => "Конструктор страниц"),
						"sliders" => array ("active" => 0, "name" => "Слайдеры", "description" => "Конструктор слайдов"),
						"mediafiles" => array ("active" => 0, "name" => "Медиафайлы", "description" => ""),
						"terms" => array ("active" => 0, "name" => "Рубрики", "description" => "Конструктор рубрик(категорий) к записям."),
						"posts" => array ("active" => 0, "name" => "Записи", "description" => "Конструктор записей"),
						"menus" => array ("active" => 0, "name" => "Меню", "description" => "Конструктор меню"),
						"cats" => array ("active" => 0, "name" => "Категории", "description" => "Категории для товаров"),
						"products" => array ("active" => 0, "name" => "Товары", "description" => "Конструктор товаров"),
						"filters" => array ("active" => 0, "name" => "Фильтры", "description" => "Конструктор фильтров для товаров"),
						"delivery" => array ("active" => 0, "name" => "Доставка", "description" => "Способы доставки ит-магазина"),
						"orders" => array ("active" => 0, "name" => "Заказы", "description" => "Заказы ит-магазина")
					)
		);
		file_put_contents($config["modules_path"], $json, LOCK_EX);
		return json_decode($json);
	}
}

function updateModules() {
	global $config;
	$_SESSION['answer'] = '';
	
	if ($_SESSION['auth']['user_status'] != 3) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Только пользователь с правами ROOT может изменять модули!</div>';
		redirect("?view=modules");
	}
	
	$action = ($_GET['action'] == 'activate') ? 1 : 0; 
	$module = preg_match("/^[a-z]+$/", $_GET['module']) ? $_GET['module'] : false;
	
	if (!$module) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Неверный <b>#ID</b> модуля!</div>';
		redirect("?view=modules");
	}
	
	$modules = $config['modules'];
	if (is_object($modules) && !empty($modules)) {
		foreach($modules as $ID => $item) {
			if ($ID == $module) {
				$modules->$ID->active = $action;
				disableModulePlugins($module);
				file_put_contents($config["modules_path"], json_encode($modules), LOCK_EX);
				$settings = $config['settings'];
				if ($action) {
					if ($module = 'sliders') {
						$label = "Размер миниатюры для слайдов:";
						$name[] = $module . '_imgsize';
						$settings->{$name[0]} = ["name" => $name[0], "value" => [260,260], "type" => "custom", "object" => "multiplyText", "label" => $label, "remove" => 0, "tags" => 0, "default" => "px;"];
						file_put_contents($config["settings_path"], json_encode($settings), LOCK_EX);
					}
					$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Модуль успешно активирован!</div>';
				} else {
					if ($module = 'sliders') {
						$name[] = $module . '_imgsize';
						if (!empty($settings->{$name[0]})) {
							unset($settings->{$name[0]});
						}
						file_put_contents($config["settings_path"], json_encode($settings), LOCK_EX);
					}
					$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Модуль успешно отключен!</div>';
				}
				redirect("?view=modules");
			}
		}
	}
	
	$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Модуль не найден!</div>';
	redirect("?view=modules");
}

function getPlugins() {
	global $config;
	
	if (file_exists($config["plugins_path"]))
		return json_decode(file_get_contents($config["plugins_path"]));
	else {
		$json = json_encode(
					array(
						"pages" => [
							"pagepicture" => ["active" => 0, "name" => "Миниатюра для страниц", "description" => "Возможность добавлять картинку миниатюры к страницам"],
							"pagegallery" => ["active" => 0, "name" => "Галерея для страниц", "description" => "Возможность добавлять галерею изображений к страницам"],
							"pageparams" => ["active" => 0, "name" => "Произвольные поля для страниц", "description" => "Возможность добавлять произвольные поля к страницам"],
							"pagemediafields" => ["active" => 0, "name" => "Медиа поля для страниц", "description" => "Возможность добавлять объекты из медиафайлов к страницам"]
						],
						"terms" => [
							"termpicture" => ["active" => 0, "name" => "Миниатюра для рубрик", "description" => "Возможность добавлять картинку миниатюры к рубрикам"],
							"termgallery" => ["active" => 0, "name" => "Галерея для рубрик", "description" => "Возможность добавлять галерею изображений к рубрикам"],
							"termparams" => ["active" => 0, "name" => "Произвольные поля для рубрик", "description" => "Возможность добавлять произвольные поля к рубрикам"],
							"termmediafields" => ["active" => 0, "name" => "Медиа поля для рубрик", "description" => "Возможность добавлять объекты из медиафайлов к рубрикам"]
						],
						"posts" => [
							"postquote" => ["active" => 0, "name" => "Краткая запись", "description" => "Возможность отдельно кратко описывать запись"],
							"postpicture" => ["active" => 0, "name" => "Миниатюра для записей", "description" => "Возможность добавлять картинку миниатюры к записям"],
							"postgallery" => ["active" => 0, "name" => "Галерея для записей", "description" => "Возможность добавлять галерею изображений к записям"],
							"postparams" => ["active" => 0, "name" => "Произвольные поля для записей", "description" => "Возможность добавлять произвольные поля к записям"],
							"postmediafields" => ["active" => 0, "name" => "Медиа поля для записей", "description" => "Возможность добавлять объекты из медиафайлов к записям"]
						],
						"menus" => [
							"menumediafields" => ["active" => 0, "name" => "Медиа поля для меню", "description" => "Возможность добавлять объекты из медиафайлов к меню"]
						],
						"cats" => [
							"catpicture" => ["active" => 0, "name" => "Миниатюра для категорий", "description" => "Возможность добавлять картинку миниатюры к категориям"],
							"catgallery" => ["active" => 0, "name" => "Галерея для категорий", "description" => "Возможность добавлять галерею изображений к категориям"],
							"catparams" => ["active" => 0, "name" => "Произвольные поля для категорий", "description" => "Возможность добавлять произвольные поля к категориям"],
							"catmediafields" => ["active" => 0, "name" => "Медиа поля для категорий", "description" => "Возможность добавлять объекты из медиафайлов к категориям"]
						],
						"products" => [
							"productquote" => ["active" => 0, "name" => "Краткая запись", "description" => "Возможность отдельно кратко описывать товар"],
							"productpicture" => ["active" => 0, "name" => "Миниатюра для товаров", "description" => "Возможность добавлять картинку миниатюры к товарам"],
							"productgallery" => ["active" => 0, "name" => "Галерея для товаров", "description" => "Возможность добавлять галерею изображений к товарам"],
							"productparams" => ["active" => 0, "name" => "Произвольные поля для товаров", "description" => "Возможность добавлять произвольные поля к товарам"],
							"productmediafields" => ["active" => 0, "name" => "Медиа поля для товаров", "description" => "Возможность добавлять объекты из медиафайлов к товарам"],
							"productsimular" => ["active" => 0, "name" => "Сопутствующие товары", "description" => "Возможность добавлять сопутствующие товары"]
						],
					)
		);
		file_put_contents($config["plugins_path"], $json, LOCK_EX);
		return json_decode($json);
	}
}

function updatePlugins() {
	global $config;
	$_SESSION['answer'] = '';
	
	$action = ($_GET['action'] == 'activate') ? 1 : 0; 
	$module = preg_match("/^[a-z]+$/", $_GET['module']) ? $_GET['module'] : false;
	$plugin = preg_match("/^[a-z]+$/", $_GET['plugin']) ? $_GET['plugin'] : false;
	
	if (!$module) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Неверный <b>#ID</b> модуля!</div>';
		redirect("?view=plugins");
	}
	
	if (!$plugin) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Неверный <b>#ID</b> плагина!</div>';
		redirect("?view=plugins");
	}
	
	$modules = $config['modules'];
	$plugins = $config['plugins'];
	$settings = $config['settings'];
	
	if (is_object($plugins->{$module}->{$plugin}) && !empty($plugins->{$module}->{$plugin})) {
		
		if (!$modules->{$module}->active && !$plugins->{$module}->{$plugin}->active) {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Для активации плагина <b>' . $plugin . '</b> в начале необходимо активировать модуль <b>' . $module . '</b></div>';
			redirect("?view=plugins");
		}
		
		if ($plugin == "pagemediafields" && !$modules->mediafiles->active) {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Для активации плагина <b>' . $plugin . '</b> в начале необходимо активировать <b>зависимый</b> модуль <b>mediafiles</b></div>';
			redirect("?view=plugins");
		}
		
		if ($plugin == "termmediafields" && !$modules->mediafiles->active) {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Для активации плагина <b>' . $plugin . '</b> в начале необходимо активировать <b>зависимый</b> модуль <b>mediafiles</b></div>';
			redirect("?view=plugins");
		}
		
		if ($plugin == "postmediafields" && !$modules->mediafiles->active) {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Для активации плагина <b>' . $plugin . '</b> в начале необходимо активировать <b>зависимый</b> модуль <b>mediafiles</b></div>';
			redirect("?view=plugins");
		}
		
		if ($plugin == "catmediafields" && !$modules->mediafiles->active) {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Для активации плагина <b>' . $plugin . '</b> в начале необходимо активировать <b>зависимый</b> модуль <b>mediafiles</b></div>';
			redirect("?view=plugins");
		}
		
		if ($plugin == "productmediafields" && !$modules->mediafiles->active) {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Для активации плагина <b>' . $plugin . '</b> в начале необходимо активировать <b>зависимый</b> модуль <b>mediafiles</b></div>';
			redirect("?view=plugins");
		}
		
		$label = '';
		switch($plugin) {
			case("pagepicture"):$label = "Размер миниатюры для страниц:";break;
			case("pagegallery"):$label = "Размер миниатюры галереи для страниц:";break;
			
			case("termpicture"):$label = "Размер миниатюры для рубрик:";break;
			case("termgallery"):$label = "Размер миниатюры галереи для рубрик:";break;
			
			case("postpicture"):$label = "Размер миниатюры для записей:";break;
			case("postgallery"):$label = "Размер миниатюры галереи для записей:";break;
			
			case("catpicture"):$label = "Размер миниатюры для категорий:";break;
			case("catgallery"):$label = "Размер миниатюры галереи для категорий:";break;
			
			case("productpicture"):$label = "Размер миниатюры для товаров:";break;
			case("productgallery"):$label = "Размер миниатюры галереи для товаров:";break;
		}
		
		if (!empty($label)) {
			$name[] = $module . '_' . $plugin . '_imgsize';
			if ($action) {
				//регистрация
				$settings->{$name[0]} = ["name" => $name[0], "value" => [260,260], "type" => "custom", "object" => "multiplyText", "label" => $label, "remove" => 0, "tags" => 0, "default" => "px;"];
			} else {
				//удаление
				if (!empty($settings->{$name[0]})) {unset($settings->{$name[0]});}
			}
		}
		
		/*
		if ($plugin == 'pagegallery') {
			$name[] = $module . '_' . $plugin . '_imgsize';
			if ($action) {
				//регистрация
				$settings->{$name[0]} = ["name" => $name[0], "value" => [260,260], "type" => "custom", "object" => "multiplyText", "label" => "Размер миниатюры галереи для страницы:", "remove" => 0, "tags" => 0, "default" => "px;"];
			} else {
				//удаление
				if (!empty($settings->{$name[0]})) {unset($settings->{$name[0]});}
			}
		}
		*/
		
		$plugins->{$module}->{$plugin}->active = $action;
		file_put_contents($config["plugins_path"], json_encode($plugins), LOCK_EX);
		file_put_contents($config["settings_path"], json_encode($settings), LOCK_EX);
		if ($action) {
			$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Плагин успешно активирован!</div>';
		} else {
			$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Плагин успешно отключен!</div>';
		}
		
		redirect("?view=plugins");
	}
	
	$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Плагин не найден!</div>';
	redirect("?view=plugins");
}

function disableModulePlugins($module) {
	global $config;
	$plugins = $config['plugins'];
	$settings = $config['settings'];
	
	if (!empty($plugins->{$module})) {
		foreach($plugins->{$module} as $plugin => $object) {
			$plugins->{$module}->{$plugin}->active = 0;
		}
		file_put_contents($config["plugins_path"], json_encode($plugins), LOCK_EX);
	}
	
	if (!empty($settings) && is_object($settings)) {
		foreach($settings as $item => $object) {
			$dummy = explode('_', $item);
			if ($dummy[0] == $module) {
				unset($settings->{$item});
			}
		}
		file_put_contents($config["settings_path"], json_encode($settings), LOCK_EX);
	}
}

function getWhere($order_by, $field, $value, $op, $like, $many, $prefix) {
	global $controller;
	if (empty($field) || empty($value)) return ''; $dummy = ''; $empty = '';
	$where = ''; if (!empty($prefix)) $prefix = true; else $prefix = false;
	$ids = ['post_datecreate','post_datepublic','post_dateupdate','product_datecreate','product_datepublic','product_dateupdate'];
	foreach($value as $ID => $item) {
		$value[$ID] = clearObject(urldecode($item));
		if ($field[$ID] == 'date') {
			$dummy = explode(':!', $item);
			if (empty($dummy[1]) && empty($dummy[2])) {$dummy = [];}
			unset($field[$ID]); unset($value[$ID]); sort($field); sort($value); break; //##!!!! BREAK!
		}
	}

	if (!empty($dummy) && !preg_match("/^[0-9]{4}-[0-9]{2}+$/s", $dummy[1])) {
		$dummy = [];
	}

	if (!empty($dummy) && !in_array($dummy[2], $ids)) {
		$dummy = [];
	}

	if (!empty($dummy)) {
		$field[] = $dummy[2];
		$value[] = $dummy[2];
		sort($field); sort($value);
		$dummy[1] = explode('-', $dummy[1]);
	}
	
	if (count($field) > 1 && count($value) < 2) {
		foreach($field as $item) {
			if (in_array($item, $ids)) {$where .= (!empty($where) ? ' ' . $op : '') . ' MONTH(' . (($prefix) ? explode('_', $item)[0] . '.' : '') . '`' . $item . '`) = ' . abs((int)$dummy[1][1]) . ' AND YEAR(' . (($prefix) ? explode('_', $item)[0] . '.' : '') . '`' . $item . '`) = ' . abs((int)$dummy[1][0]);}
			else $where .= (!empty($where) ? ' ' . $op : '') . " " . (($prefix) ? explode('_', $item)[0] . '.' : '') . "`{$item}` " . (($like) ? "LIKE '%{$value[0]}%'" : "= '{$value[0]}'");
		}
	}
	
	if (count($field) < 2 && count($value) > 1) {
		foreach($value as $item) {
			if ($many) {
				if ($where) {
					$where .= ", '{$item}'";
				} else {
					$where .= "'{$item}'";
				}
			} else {
				if (in_array($field[0], $ids)) {$where .= (!empty($where) ? ' ' . $op : '') . ' MONTH(' . (($prefix) ? explode('_', $field[0])[0] . '.' : '') . '`' . $field[0] . '`) = ' . abs((int)$dummy[1][1]) . ' AND YEAR(' . (($prefix) ? explode('_', $field[0])[0] . '.' : '') . '`' . $field[0] . '`) = ' . abs((int)$dummy[1][0]);}
				else $where .= (!empty($where) ? ' ' . $op : '') . " " . (($prefix) ? explode('_', $field[0])[0] . '.' : '') . "`{$field[0]}` " . (($like) ? "LIKE '%{$item}%'" : "= '{$item}'");
			}
		} if ($many) return " WHERE " . (($prefix) ? explode('_', $field[0])[0] . '.' : '') . "`{$field[0]}` IN ({$where})";
	}
	
	if (count($field) == count($value)) {
		if (count($field) > 1) {
			foreach($field as $ID => $item) {
				if (in_array($item, $ids)) {$where .= (!empty($where) ? ' ' . $op : '') . ' MONTH(' . (($prefix) ? explode('_', $item)[0] . '.' : '') . '`' . $item . '`) = ' . abs((int)$dummy[1][1]) . ' AND YEAR(' . (($prefix) ? explode('_', $item)[0] . '.' : '') . '`' . $item . '`) = ' . abs((int)$dummy[1][0]);}
				else $where .= (!empty($where) ? ' ' . $op : '') . " " . (($prefix) ? explode('_', $item)[0] . '.' : '') . "`{$item}` " . (($like) ? "LIKE '%{$value[$ID]}%'" : "= '{$value[$ID]}'");
			}
		} else {
			if (in_array($field[0], $ids)) {$where .= (!empty($where) ? ' ' . $op : '') . ' MONTH(' . (($prefix) ? explode('_', $field[0])[0] . '.' : '') . '`' . $field[0] . '`) = ' . abs((int)$dummy[1][1]) . ' AND YEAR(' . (($prefix) ? explode('_', $field[0])[0] . '.' : '') . '`' . $field[0] . '`) = ' . abs((int)$dummy[1][0]);}
			else $where .= " " . (($prefix) ? explode('_', $field[0])[0] . '.' : '') . "`{$field[0]}` " . (($like) ? "LIKE '%{$value[0]}%'" : "= '{$value[0]}'");
		}
	}

	//print_array($_GET, false);
	//print_array($field, false);
	//print_array($value, false);
	//print_array($dummy, false);
	//die($where);

	return " WHERE " . (($controller == 'search') ? explode('_', $field[0])[0] . ".`".explode('_', $field[0])[0]."_visible` = 1 and" : '') . $where;
}

function countRows($table, $order, $where, $prefix, $relationship, $relationship_prefix) {
	global $connect, $config; 
	
	$JOIN = ''; $DOT = '';
	if (!empty($prefix) && !empty($relationship) && !empty($relationship_prefix)) {
		$DOT = '.';
		$prefix = substr($prefix, 0, -1);
		$JOIN .= " LEFT JOIN `{$config["prefix"]}{$table}_relationships` relationship ON relationship.`{$prefix}_id` = {$prefix}.`{$prefix}_id`";
		$JOIN .= " LEFT JOIN `{$config["prefix"]}{$relationship}` {$relationship_prefix} ON relationship.`{$relationship_prefix}_id` = {$relationship_prefix}.`{$relationship_prefix}_id`";
		$JOIN .= " LEFT JOIN `{$config["prefix"]}users` user ON user.`user_id` = {$prefix}.`{$prefix}_author`";
	}
	
	$query = "SELECT COUNT(DISTINCT {$prefix}{$DOT}`{$order}`) as count FROM `{$config["prefix"]}{$table}` {$prefix}{$JOIN}{$where}";
    $request = mysqli_query($connect, $query) or
        die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0]['count'] : [];
}

function getObjects($args) {
	global $connect, $config;

	if (!is_array($args))  die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> invalid arguments");
	if (empty($args['table'])) die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> not enough arguments, missing required argument <b>table</b>");
	if (empty($args['function'])) die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> not enough arguments, missing required argument <b>function</b>");
	if (empty($args['order_by'])) die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> not enough arguments, missing required argument <b>order_by</b>");
	if (empty($args['field'])) $args['field'] = [];
	if (!empty($args['prefix'])) $prefix = $args['prefix'] . '.'; else $prefix = '';
	if (!empty($args['relationship'])) $relationship = $args['relationship']; else $relationship = '';
	if (!empty($args['relationship_prefix'])) $relationship_prefix = $args['relationship_prefix']; else $relationship_prefix = '';
	
	$perpage = !empty($_GET['perpage']) ? abs((int)$_GET['perpage']) : $config['settings']->perpage->value;
	$config['perpage'] = ($perpage < 1) ? 1 : (($perpage > 100) ? 100 : $perpage);
	
	$page = !empty($_GET['page']) ? abs((int)$_GET['page']) : 1;
	$config['page'] = ($page < 1) ? 1 : $page;
	
	$config['order_by'] = !empty($_GET['order_by']) ? (in_array($_GET['order_by'], $args['order_by']) ? $_GET['order_by'] : $args['order_by'][0]) : $args['order_by'][0];
	$config['op'] = !empty($_GET['op']) ? (in_array($_GET['op'], ['and', 'or']) ? $_GET['op'] : 'and') : 'and';
	$config['query'] = isset($_GET['query']) ? true : false;
	$config['many'] = isset($_GET['many']) ? true : false;
	$config['side'] = !empty($_GET['side']) && $_GET['side'] == 'asc' ? 'ASC' : 'DESC';

	$config['field'] = !empty($_GET['field']) ? explode(',', $_GET['field']) : false;
	if (count($config['field']) > 4) $config['field'] = false;
	if (is_array($config['field'])) {
		foreach($config['field'] as $item) {
			if (empty($item) || !in_array($item, $args['field'])) {
				$config['field'] = false;
				break;
			}
		}
	}

	$config['value'] = (isset($_GET['value']) && is_array($config['field'])) ? explode(',', $_GET['value']) : false;
	if (count($config['value']) > 4) $config['value'] = false;
	if (is_array($config['value'])) {
		foreach($config['value'] as $item) {
			if (empty($item) && $item !== '0') {
				$config['field'] = false;
				$config['value'] = false;
				break;
			}
		}
	}
	
	$where = getWhere($config['order_by'], $config['field'], $config['value'], $config['op'], $config['query'], $config['many'], $prefix);
	$count_rows = countRows($args['table'], $config['order_by'], $where, $prefix, $relationship, $relationship_prefix);
	$config['count_rows'] = $count_rows;

	$pages_count = ceil($count_rows / $config['perpage']);
	$config['pages_count'] = !$pages_count ? 1 : $pages_count;
	if (isset($_GET['ajax'])) if ($config['page'] > $config['pages_count']) return [];
	$config['page'] = ($config['page'] > $config['pages_count']) ? $config['pages_count'] : $config['page'];
	$config['start_pos'] = ($config['page'] - 1) * $config['perpage'];

	//$group_by = !empty($config['order_by']) ? explode('_', $config['order_by'])[0] . ".`{$config['order_by']}`" : '1';
	$config['where_order'] = empty($prefix) ? "ORDER BY `{$config['order_by']}`" : "GROUP BY {$args['prefix']}.`{$args['prefix']}_id` ORDER BY {$args['prefix']}.`{$config['order_by']}`";
	$config['where'] = $where . " {$config['where_order']} {$config['side']} LIMIT {$config['start_pos']}, {$config['perpage']}";

	$function = $args['function'];
	return $function($args);
}

function getObjectsWithRelationships($args) {
	global $connect, $config;
	
	$query = "
			SELECT 
				DISTINCT {$args['prefix']}.*, 
				group_concat({$args['relationship_prefix']}.`{$args['relationship_prefix']}_title` SEPARATOR '|') as objectNames, 
				group_concat({$args['relationship_prefix']}.`{$args['relationship_prefix']}_id` SEPARATOR '|') as objectIds,
				group_concat({$args['relationship_prefix']}.`{$args['relationship_prefix']}_fullslug` SEPARATOR '|') as objectUrls,
				user.`user_id` as user_id, user.`user_login` as user_login, user.`user_name` as user_name, user.`user_surname` as user_surname, user.`user_middlename` as user_middlename  
			FROM `{$config['prefix']}{$args['table']}` {$args['prefix']} 
				LEFT JOIN `{$config['prefix']}{$args['table']}_relationships` relationship ON relationship.`{$args['prefix']}_id` = {$args['prefix']}.`{$args['prefix']}_id` 
				LEFT JOIN `{$config['prefix']}{$args['relationship']}` {$args['relationship_prefix']} ON relationship.`{$args['relationship_prefix']}_id` = {$args['relationship_prefix']}.`{$args['relationship_prefix']}_id` 
				LEFT JOIN `{$config["prefix"]}users` user ON user.`user_id` = {$args['prefix']}.`{$args['prefix']}_author`
			{$config['where']}
	"; //die($query);
	$request = mysqli_query($connect, $query) or
        die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC) : [];
}

function getUsers($args) {
	global $connect, $config;
	
	$query = "SELECT * FROM `{$config["prefix"]}{$args['table']}`{$config['where']}";
	$request = mysqli_query($connect, $query) or
        die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC) : [];
}

function getOrdersNot() {
	global $connect, $config;

	$query = "SELECT count(order_id) as count FROM `{$config["prefix"]}orders` WHERE `order_proof` = 0";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0]['count'] : 0;
}

function getCallbackNot() {
	global $connect, $config;

	$query = "SELECT count(call_id) as count FROM `{$config["prefix"]}callback` WHERE `call_proof` = 0";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0]['count'] : 0;
}

function getUserNameByAdmin($args) {
	if (empty($args['user_id']) || empty($args['user_login'])) return "&mdash;";
	$username = '';
	if (!empty($args['user_surname'])) $username .= $args['user_surname'];
	if (!empty($args['user_name'])) $username .= ' ' . $args['user_name'];
	if (!empty($args['user_middlename'])) $username .= ' ' . $args['user_middlename'];
	$username = !empty($username) ? $username : $args['user_login'];
	return '<a href="?view=posts&order_by=post_id&field=post_author&value=' . $args['user_id'] . '">' . $username . '</a>';
}

function getUserName($args) {
	if (empty($args['user_id']) || empty($args['user_login'])) return '';
	$username = '';
	if (!empty($args['user_surname'])) $username .= $args['user_surname'];
	if (!empty($args['user_name'])) $username .= ' ' . $args['user_name'];
	if (!empty($args['user_middlename'])) $username .= ' ' . $args['user_middlename'];
	return $username;
}

function saveArgs($args) {
	if (empty($args) || !is_array($args)) return false;
	if (!isset($_SESSION['cache']['args'])) $_SESSION['cache']['args'] = array();
	foreach ($args as $k => $v) {
		$_SESSION['cache']['args'][$k] = $v;
	} return true;
}

function _arg($arg) {
	if (isset($_SESSION['cache']['args'][$arg])) {
		return !is_array($_SESSION['cache']['args'][$arg]) ? stripslashes($_SESSION['cache']['args'][$arg]) : $_SESSION['cache']['args'][$arg];
	} return false;
}

function cArgs() {
	if (isset($_SESSION['cache']['args']))
		unset($_SESSION['cache']['args']);
	return;
}

function getValue($item) {
	return htmlspecialchars_decode($item, ENT_QUOTES | ENT_SUBSTITUTE);
}

function getUser($user_id) {
	global $connect, $config;
	
	$query = "SELECT * FROM `{$config["prefix"]}users` WHERE `user_id` = {$user_id}";
	$request = mysqli_query($connect, $query) or
        die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];
}

function addUser() { 
	global $connect,$config;
	$args = array();
	$_SESSION['answer'] = "";
	
    $args['login'] = clearObject($_POST['login']);
    $password = clearObject($_POST['password']);
    $password2 = clearObject($_POST['password2']);
	$args['status'] = abs((int)$_POST['status']);
	$args['email'] = clearObject($_POST['email']);
	$args['phone'] = clearObject($_POST['phone']);
	$args['name'] = clearObject($_POST['name']);
	$args['surname'] = clearObject($_POST['surname']);
	$args['middle'] = clearObject($_POST['middle']);
	$args['about'] = clearObject($_POST['about']);
	$args['address'] = clearObject($_POST['address']);
	
	if (empty($args['login']) || empty($password) || empty($password2) || empty($args['email'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Пожалуйста заполните все обязательные поля!</div>';
	}
	
	if ($password != $password2) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Введенные Вами пароли не совпадают!</div>';
	}
	
	if (!filter_var($args['email'], FILTER_VALIDATE_EMAIL)) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Неверный формат Email адреса!</div>';
	}
	
	if (!empty($args['login'])) {
		$query = "SELECT `user_id` FROM `{$config["prefix"]}users` WHERE `user_login` = '{$args['login']}' LIMIT 1";
		$request = mysqli_query($connect, $query) or
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		$row = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0]['user_id'] : false;
		if ($row) {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Выбранный Вами логин уже занят, пожалуйста придумайте другой!</div>';
		}
	}
	
	if (!empty($args['email']) && filter_var($args['email'], FILTER_VALIDATE_EMAIL)) {
		$query = "SELECT `user_id` FROM `{$config["prefix"]}users` WHERE `user_email` = '{$args['email']}' LIMIT 1";
		$request = mysqli_query($connect, $query) or
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		$row = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0]['user_id'] : false;
		if ($row) {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Выбранный Вами Email уже зарегистрирован, возможно это Вы?</div>';
		}
	}
	
	if (!empty($_SESSION['answer'])) {
		saveArgs($args);
		redirect("?view=add_user");
	}
	
	$args['password'] = md5(SECRET . md5(SALT.$password));
	
	$query = "INSERT INTO {$config["prefix"]}users (`user_login`, `user_password`, `user_name`, `user_surname`, `user_middlename`, `user_email`, `user_phone`, `user_address`, `user_about`, `user_status`, `user_date`) 
					VALUES ('{$args['login']}', '{$args['password']}', '{$args['name']}', '{$args['surname']}', '{$args['middle']}', '{$args['email']}', '{$args['phone']}', '{$args['address']}', '{$args['about']}', {$args['status']}, NOW())";
    $request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Пользователь успешно добавлен!</div>';
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При добавлении пользователя произошел сбой!</div>';
	}
	
	redirect("?view=users");  
}

function updateUser($user_id) { 
	global $connect, $config;
	$args = array();
	$_SESSION['answer'] = "";
	
    $args['login'] = clearObject($_POST['login']);
    $password = clearObject($_POST['password']);
    $password2 = clearObject($_POST['password2']);
	$args['status'] = abs((int)$_POST['status']);
	$args['email'] = clearObject($_POST['email']);
	$args['phone'] = clearObject($_POST['phone']);
	$args['name'] = clearObject($_POST['name']);
	$args['surname'] = clearObject($_POST['surname']);
	$args['middle'] = clearObject($_POST['middle']);
	$args['about'] = clearObject($_POST['about']);
	$args['address'] = clearObject($_POST['address']);
	
	if (empty($args['login']) || empty($password) || empty($password2) || empty($args['email'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Пожалуйста заполните все обязательные поля!</div>';
	}
	
	if ($password != $password2) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Введенные Вами пароли не совпадают!</div>';
	}
	
	if (!filter_var($args['email'], FILTER_VALIDATE_EMAIL)) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Неверный формат Email адреса!</div>';
	}
	
	if (!empty($args['login'])) {
		$query = "SELECT `user_id` FROM `{$config["prefix"]}users` WHERE `user_login` = '{$args['login']}' AND `user_id` != {$user_id} LIMIT 1";
		$request = mysqli_query($connect, $query) or
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		$row = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0]['user_id'] : false;
		if ($row) {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Выбранный Вами логин уже занят, пожалуйста придумайте другой!</div>';
		}
	}
	
	if (!empty($args['email']) && filter_var($args['email'], FILTER_VALIDATE_EMAIL)) {
		$query = "SELECT `user_id` FROM `{$config["prefix"]}users` WHERE `user_email` = '{$args['email']}' AND `user_id` != {$user_id} LIMIT 1";
		$request = mysqli_query($connect, $query) or
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		$row = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0]['user_id'] : false;
		if ($row) {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Выбранный Вами Email уже зарегистрирован, возможно это Вы?</div>';
		}
	}
	
	if ($user_id == 1 && $_SESSION['auth']['user_id'] != 1) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Только пользователь с правами ROOT может редактировать свой профиль!</div>';
	}
	
	if (!empty($_SESSION['answer'])) {
		redirect("?view=add_user");
	}
	
	$args['password'] = md5(SECRET . md5(SALT.$password));
	
	$query = "UPDATE {$config["prefix"]}users SET 
				`user_login` = '{$args['login']}',
				`user_password` = '{$args['password']}',
				`user_name` = '{$args['name']}',
				`user_surname` = '{$args['surname']}',
				`user_middlename` = '{$args['middle']}',
				`user_address` = '{$args['address']}',
				`user_about` = '{$args['about']}',
				`user_status` = {$args['status']},
				`user_date` = NOW()
			WHERE `user_id` = {$user_id}";				
    $request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Пользователь успешно обновлен!</div>';
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При обновлении пользователя произошел сбой!</div>';
	}
	
	redirect("?view=users");  
}

function removeUser($user_id) {
	global $connect, $config;
	$_SESSION['answer'] = "";
	
	if ($user_id == 1 && $_SESSION['auth']['user_id'] != 1) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Нельзя удалить пользователя с правами ROOT!</div>';
	}
	
	if ($user_id == $_SESSION['auth']['user_id']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Нельзя удалить самого себя!</div>';
	}
	
	if (!empty($_SESSION['answer'])) {
		redirect("?view=users");
	}
	
	$query = "DELETE FROM `{$config["prefix"]}users` WHERE `user_id` = {$user_id}";
    $request = mysqli_query($connect, $query) or
        die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		
	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Пользователь успешно удален!</div>';
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При удалении пользователя произошел сбой!</div>';
	}
	
	redirect("?view=users");
}

function getGlobalArgs($args) {
	$gets = explode("&", $_SERVER['QUERY_STRING']);
	$query = '';
	if (!empty($gets) && is_array($gets) && is_array($args)) {
		foreach($gets as $get) {
			$get = explode("=", $get);
			if (!empty($get[0]) && !empty($get[1])) {
				if (in_array($get[0], $args)) continue;
				$query .= $get[0]. '=' . urldecode($get[1]) . '&';
			}
		} //$query = substr($query, 0, -1);
	} return $query;
}

function pageNavi() {
    global $config;
	
	if (empty($config["pages_count"]) || $config["pages_count"] < 2) return;
	$query = '?' . getGlobalArgs(['page']);
	$startpage = ''; $page1left = ''; $page2left = '';
	$endpage = ''; $page1right = ''; $page2right = '';
	if (empty($config['pagenavi'])) $config['pagenavi'] = [];

	//$config['pagenavi']['begin'] = !empty($config['pagenavi']['begin']) ? $config['pagenavi']['begin'] : '&laquo;';
	$config['pagenavi']['begin'] = '&laquo;';
	$config['pagenavi']['end'] =  '&raquo;';
	//$config['pagenavi']['end'] = !empty($config['pagenavi']['end']) ? $config['pagenavi']['end'] : '&raquo;';

	if (!isset($config['pagenavi']['main-container'])) $config['pagenavi']['main-container'] = 'div';
	if (!isset($config['pagenavi']['before-main-container'])) $config['pagenavi']['before-main-container'] = '';
	if (!isset($config['pagenavi']['after-main-container'])) $config['pagenavi']['after-main-container'] = '';
	if (!isset($config['pagenavi']['class-main-container'])) $config['pagenavi']['class-main-container'] = '';
	if (!isset($config['pagenavi']['id-main-container'])) $config['pagenavi']['id-main-container'] = '';
	if (!isset($config['pagenavi']['style-main-container'])) $config['pagenavi']['style-main-container'] = '';
	
	if (!isset($config['pagenavi']['container'])) $config['pagenavi']['container'] = 'ul';
	if (!isset($config['pagenavi']['before-container'])) $config['pagenavi']['before-container'] = '';
	if (!isset($config['pagenavi']['after-container'])) $config['pagenavi']['after-container'] = '';
	if (!isset($config['pagenavi']['class-container'])) $config['pagenavi']['class-container'] = '';
	if (!isset($config['pagenavi']['id-container'])) $config['pagenavi']['id-container'] = '';
	if (!isset($config['pagenavi']['style-container'])) $config['pagenavi']['style-container'] = '';
	
	if (!isset($config['pagenavi']['container-link'])) $config['pagenavi']['container-link'] = 'li';
	if (!isset($config['pagenavi']['before-link'])) $config['pagenavi']['before-link'] = '';
	if (!isset($config['pagenavi']['after-link'])) $config['pagenavi']['after-link'] = '';
	if (!isset($config['pagenavi']['class-link'])) $config['pagenavi']['class-link'] = '';
	if (!isset($config['pagenavi']['id-link'])) $config['pagenavi']['id-link'] = '';
	if (!isset($config['pagenavi']['style-link'])) $config['pagenavi']['style-link'] = '';
	
	if (!isset($config['pagenavi']['container-link-active'])) $config['pagenavi']['container-link-active'] = 'span';
	if (!isset($config['pagenavi']['before-link-active'])) $config['pagenavi']['before-link-active'] = '';
	if (!isset($config['pagenavi']['after-link-active'])) $config['pagenavi']['after-link-active'] = '';
	if (!isset($config['pagenavi']['class-link-active'])) $config['pagenavi']['class-link-active'] = '';
	if (!isset($config['pagenavi']['id-link-active'])) $config['pagenavi']['id-link-active'] = '';
	if (!isset($config['pagenavi']['style-link-active'])) $config['pagenavi']['style-link-active'] = '';
	
	//main-container admin-navi
	//link btn btn-sm btn-primary
	//active btn btn-sm btn-info
	
	$link = (!empty($config['pagenavi']['class-link'])) ? ' class="' . $config['pagenavi']['class-link'] . '"' : '';
	$link .= (!empty($config['pagenavi']['id-link'])) ? ' id="' . $config['pagenavi']['id-link'] . '"' : '';
	$link .= (!empty($config['pagenavi']['style-link'])) ? ' style="' . $config['pagenavi']['style-link'] . '"' : '';
	
	$link_active = (!empty($config['pagenavi']['class-link-active'])) ? ' class="' . $config['pagenavi']['class-link-active'] . '"' : '';
	$link_active .= (!empty($config['pagenavi']['id-link-active'])) ? ' id="' . $config['pagenavi']['id-link-active'] . '"' : '';
	$link_active .= (!empty($config['pagenavi']['style-link-active'])) ? ' style="' . $config['pagenavi']['style-link-active'] . '"' : '';
	
	$main_container = (!empty($config['pagenavi']['class-main-container'])) ? ' class="' . $config['pagenavi']['class-main-container'] . '"' : '';
	$main_container .= (!empty($config['pagenavi']['id-main-container'])) ? ' id="' . $config['pagenavi']['id-main-container'] . '"' : '';
	$main_container .= (!empty($config['pagenavi']['style-main-container'])) ? ' style="' . $config['pagenavi']['style-main-container'] . '"' : '';
	
	$container = (!empty($config['pagenavi']['class-container'])) ? ' class="' . $config['pagenavi']['class-container'] . '"' : '';
	$container .= (!empty($config['pagenavi']['id-container'])) ? ' id="' . $config['pagenavi']['id-container'] . '"' : '';
	$container .= (!empty($config['pagenavi']['style-container'])) ? ' style="' . $config['pagenavi']['style-container'] . '"' : '';
	
	$begin_link_container = !empty($config['pagenavi']['container-link']) ? '<' . $config['pagenavi']['container-link'] . '>' : '';
	$end_link_container = !empty($config['pagenavi']['container-link']) ? '</' . $config['pagenavi']['container-link'] . '>' : '';
	
	$begin_main_container = !empty($config['pagenavi']['main-container']) ? $config['pagenavi']['before-main-container'] . '<' . $config['pagenavi']['main-container'] . $main_container .'>' : '';
	$end_main_container = !empty($config['pagenavi']['main-container']) ? '</' . $config['pagenavi']['main-container'] . '>' . $config['pagenavi']['after-main-container'] : '';
	
	$begin_container = !empty($config['pagenavi']['container']) ? $config['pagenavi']['before-container'] . '<' . $config['pagenavi']['container'] . $container . '>' : '';
	$end_container = !empty($config['pagenavi']['container']) ? '</' . $config['pagenavi']['container'] . '>' . $config['pagenavi']['after-container'] : '';
	
	if ($config["page"] > 1) {
		$startpage = 
					$begin_link_container .
						$config['pagenavi']['before-link'] . 
							'<a href="' . $query . 'page=1"' . $link . '>' . $config['pagenavi']['begin'] . '</a>' .
						 $config['pagenavi']['after-link'] .
					$end_link_container;
	} else {
		if ($config['pagenavi']['config'] != 'admin') {
			$startpage =
				$begin_link_container .
					$config['pagenavi']['before-link'] .
						$config['pagenavi']['begin'] .
					$config['pagenavi']['after-link'] .
				$end_link_container;
		}
	}
    if ($config["page"] < $config["pages_count"]) {
		$endpage = 
					$begin_link_container .
						$config['pagenavi']['before-link'] . 
							'<a href="' . $query .'page=' . $config["pages_count"] . '"' . $link . '>' . $config['pagenavi']['end'] . '</a>' .
						$config['pagenavi']['after-link'] .
					$end_link_container;
	} else {
		if ($config['pagenavi']['config'] != 'admin') {
			$endpage =
				$begin_link_container .
					$config['pagenavi']['before-link'] .
						$config['pagenavi']['end'] .
					$config['pagenavi']['after-link'] .
				$end_link_container;
		}
	}
    if ($config["page"] - 2 > 0) {
		$page2left = 
					$begin_link_container .
						$config['pagenavi']['before-link'] . 
							'<a href="' . $query .'page=' . ($config["page"] - 2) . '"' . $link . '>' . ($config["page"] - 2) . '</a>' . 
						$config['pagenavi']['after-link'] .
					$end_link_container;
	}
    if ($config["page"] - 1 > 0) {
		$page1left = 
					$begin_link_container .
						$config['pagenavi']['before-link'] . 
							'<a href="' . $query .'page=' . ($config["page"] - 1) . '"' . $link . '>' . ($config["page"] - 1) . '</a>' . 
						$config['pagenavi']['after-link'] .
					$end_link_container;
	}
    if ($config["page"] + 2 <= $config["pages_count"]) {
		$page2right = 
					$begin_link_container .
						$config['pagenavi']['before-link'] . 
							'<a href="' . $query . 'page=' . ($config["page"] + 2) . '"' . $link . '>' . ($config["page"] + 2) . '</a>' . 
						$config['pagenavi']['after-link'] .
					$end_link_container;	
	}
    if ($config["page"] + 1 <= $config["pages_count"]) {
		$page1right = 
					$begin_link_container .
						$config['pagenavi']['before-link'] . 
							'<a href="' . $query . 'page=' . ($config["page"] + 1) . '"' . $link . '>' . ($config["page"] + 1) . '</a>' . 
						$config['pagenavi']['after-link'] .
					$end_link_container;	
	}
    
	return  $begin_main_container . 
				$begin_container .
					$startpage . $page2left . $page1left . 
						'<' . $config['pagenavi']['container-link-active'] . $link_active . '>' . $config['pagenavi']['before-link-active'] . $config["page"] . $config['pagenavi']['after-link-active'] . '</' . $config['pagenavi']['container-link-active'] . '>' .
					$page1right . $page2right . $endpage .
				$end_container .
			$end_main_container;
}

function activeUrl($url) {
	$url = explode(',', $url);
	if (in_array($_GET["view"], $url)) return 'class="active"';
	if (!$_GET["view"] && in_array("dashboard", $url)) return 'class="active"';
	return false;
}

function getObjectsTree($table, $prefix, $nosort=false) {
	global $connect, $config;
	//Выбираем данные из БД
	$result = mysqli_query($connect, "SELECT * FROM {$config["prefix"]}{$table}");
	//Если в базе данных есть записи, формируем массив
	$objects = [];
	
	if (mysqli_num_rows($result) > 0) {  
	  if ($nosort) {
		  $objects = mysqli_fetch_all($result, MYSQLI_ASSOC);
	  } else {
		  //В цикле формируем массив разделов, ключом будет id родительской категории, а также массив разделов, ключом будет id категории
		  $objectID = $prefix . '_id'; $objectParent = $prefix . '_parent';
		  while($object =  mysqli_fetch_assoc($result)) {
			$objectsID[$object[$objectID]][] = $object; //зачем?!
			$objects[$object[$objectParent]][$object[$objectID]] =  $object;
		  } 
	  }
	}
	return $objects;
}

function sortObjectsTree($items, $prefix) {
	$objects = array(); $prefix = $prefix . '_parent';
	foreach($items as $object)   
        $objects[$object[$prefix]][] = $object; 
    return $objects; 
}

function checkObjectsTreeParent($objects, $parentId, $prefix) { //возвращает ID всех потомков от $parentId
	$tree = '';
	if(is_array($objects) and isset($objects[$parentId])) {			
		foreach($objects[$parentId] as $object) {
			$tree .= $object[$prefix . '_id'].'|';
			$tree .= checkObjectsTreeParent($objects, $object[$prefix . '_id'], $prefix);
		}
	} else return null;
	return $tree;
}

function createObjectsTree($objects, $prefix, $style, $parentID=0, $space=0, $nbsp='') {

	if (empty($objects[$parentID])) return;
	$space = ($parentID) ? $space + 1 : 0;
	for ($i = 0; $i < $space; $i++) $nbsp .= '&#8212;&nbsp;';

	foreach ($objects[$parentID] as $item) {
		if ($style == 'table') {
			echo '
				<tr>
					<td>' . $item[$prefix . '_id'] . '</td>
					<td><a target="_blank" href="/' . (($prefix == 'cat') ? 'category' : $prefix) . '/' . $item[$prefix . '_fullslug'] . '/">' . $nbsp . $item[$prefix . '_title'] . ' (Уровень ' . $space . ')</a>' . (!$item[$prefix . '_visible'] ? ' <span style="color:#d43f3a;">(Скрыта)</span>' : '') . '</td>
					<td>' . date_format(date_create($item[$prefix . '_datecreate']), 'd.m.Y - H:i:s') . '</td>
					<td>' . date_format(date_create($item[$prefix . '_dateupdate']), 'd.m.Y - H:i:s') . '</td>
					<td style="text-align:center;">
						<a href="?view=update_' . $prefix . '&' . $prefix . '_id=' . $item[$prefix . '_id'] . '" type="button" class="btn btn-sm btn-success">Изменить</a>
						<a href="#" onclick="confirmUser(' . $item[$prefix . '_id'] . ');return false;" type="button" class="btn btn-sm btn-danger">Удалить</a>
					</td>
				</tr>
				';
		} elseif ($style == 'option') {
			$disabled = (isset($_GET[$prefix . '_id']) && $item[$prefix . '_id'] == $_GET[$prefix . '_id']) ? ' disabled="disabled"' : '';
			global $object;
			$dummy = !empty($object[$prefix . '_parent']) ? $object[$prefix . '_parent'] : 0;
			$selected = ($item[$prefix . '_id'] == $dummy) ? ' selected="selected"' : '';
			echo '<option value="' . $item[$prefix . '_id'] . '"' . $selected . $disabled . '>' . 'ID#' . $item[$prefix . '_id'] . ': ' . (($item[$prefix . '_id'] < 10) ? '&nbsp;&nbsp;' : '') . $nbsp . $item[$prefix . '_title'] . ' (Уровень ' . $space . ')</option>';
		}

		createObjectsTree($objects, $prefix, $style, $item[$prefix . '_id'], $space);
	}
}

function createCheckboxObjectsTree($objects, $prefix, $parentID=0, $px=0, $pId=array()) {

	if (empty($objects[$parentID])) return;
	$px = ($parentID) ? $px + 20 : $px = 0;
	$lvl = ($parentID) ? $px / 20 : $lvl = 0;
	$margin = "margin-left: {$px}px;";

	foreach($objects[$parentID] as $object) {
		switch ($prefix) {
			case('term'): $FULLSLUG =  '/term/' . $object[$prefix . '_fullslug'] . '/'; break;
			//case('post'): $FULLSLUG =  '/post/' . $object[$prefix . '_fullslug'] . '/'; break;
			case('page'): $FULLSLUG =  '/page/' . $object[$prefix . '_fullslug'] . '/'; break;
			case('cat'): $FULLSLUG =  '/category/' . $object[$prefix . '_fullslug'] . '/'; break;
			//case('product'): $FULLSLUG =  '/product/' . $object[$prefix . '_fullslug'] . '/'; break;
			default: $FULLSLUG =  '/' . $object[$prefix . '_fullslug'] . '/';
		}

		echo '
			<ul style="'.$margin.'">
				<li>
					<input' . (!$object[$prefix . '_visible'] ? ' disabled="disabled"' : '') . ' data-id="' . $object[$prefix . '_id'] . '" data-title="' . htmlspecialchars($object[$prefix . '_title']) . '" data-slug="' . $FULLSLUG . '" name="' . $prefix . 's[]" value="' . $object[$prefix . '_id'] . '" type="checkbox" id="' . $prefix . $object[$prefix . '_id'] . '"' . (in_array($object[$prefix . '_id'], $pId) ? ' checked="checked"' : '') . '>
					<label' . (!$object[$prefix . '_visible'] ? ' class="hiddenObject"' : '') . ' for="' . $prefix . $object[$prefix . '_id'] . '">' . 'ID#' . $object[$prefix . '_id'] . ': ' . $object[$prefix . '_title'] . (!$object[$prefix . '_visible'] ? ' <span style="color:#d43f3a;">(Скрытый)</span>' : '') . ' (Уровень ' . $lvl . ')</label>
				</li>
			</ul>
			';
		createCheckboxObjectsTree($objects, $prefix, $object[$prefix . '_id'], $px, $pId);
	}
}

function uploadAjaxGalleryImage() {
	global $connect, $config;
	$ID = abs((int)$_POST['object_id']);
	$table = clearObject($_POST["object_table"]);
	$prefix = clearObject($_POST["object_prefix"]);
	$img = clearObject($_POST["object_img"]);
	$module = clearObject($_POST["object_module"]);
	$size = $table . "_" . $img . "_imgsize";
	
    $image = $_FILES['userfile']['name'];
    $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $image));
    $types = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png");
		
    if ($_FILES['userfile']['size'] > SIZE) {
        die(json_encode(["answer" => "Ошибка! Максимальный вес файла - 1 Мб!"]));
    }
    
    if ($_FILES['userfile']['error']) {
        die(json_encode(["answer" => "Ошибка! Возможно, файл слишком большой."]));
    }
    
    if (!in_array($_FILES['userfile']['type'], $types)) {
        die(json_encode(["answer" => "Допустимые расширения - .gif, .jpg, .png"]));
    }
	
	$query = "SELECT * FROM `{$config["prefix"]}{$table}` WHERE `{$prefix}_id` = {$ID}";
    $request = mysqli_query($connect, $query) or
        die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
    $row = mysqli_fetch_assoc($request);
    if (!empty($row[$img])) {
        $images = explode("|", $row[$img]);
        $lastimg = end($images);
        //$lastnum = preg_replace("#\d+_(\d+)\.\w+#", "$1", $lastimg); // 1_1.ext
        $lastnum = explode('_', $lastimg); // 1_1.ext
        $lastnum = $lastnum[0]; // 1_1.ext
        $lastnum += 1;
		$newimg = "{$lastnum}_{$ID}.{$ext}";
        $images = "{$row[$img]}|{$newimg}"; 
    } else {
        $newimg = "0_{$ID}.{$ext}";
        $images = $newimg; 
    }
	
	if (empty($row[$img . '_path'])) {
		$path = "/files/" . $module . "/" . $img . "/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
	} else {
		$path = $row[$img . '_path'];
	}
	
	if (empty($config["settings"]->{$size}->value[0]) || empty($config["settings"]->{$size}->value[1])) {
		die(json_encode(["answer" => "Не верный размер фильтра!"]));
	}
	
	if (@move_uploaded_file($_FILES['userfile']['tmp_name'], "../files/tmp/{$newimg}")) {
		$dirname = $_SERVER['DOCUMENT_ROOT'] . $path; 
		
		if (!file_exists($dirname)) {
			mkdir($dirname . "thumb/", 0755, true);
		} require_once ('../library/ThumbLib/ThumbLib.php');
					
		PhpThumbFactory::create("../files/tmp/{$newimg}")
							->save($dirname . $newimg, $ext)
							->adaptiveResize($config["settings"]->{$size}->value[0], $config["settings"]->{$size}->value[1])
							->save($dirname . "thumb/" . $newimg, $ext);
		@unlink("../files/tmp/{$newimg}");
		
		$query = "UPDATE `{$config["prefix"]}{$table}` SET `{$img}` = '{$images}', `{$img}_path` = '{$path}', `{$prefix}_dateupdate` = NOW() WHERE `{$prefix}_id` = {$ID}";
		$request = mysqli_query($connect, $query) or
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

        die(json_encode(["answer" => "OK", "result" => $path . "thumb/" . $newimg]));

	} else {
		die(json_encode(["answer" => "Не удалось переместить загруженную фотографию. Проверьте права на папки в каталоге " . $path . $newimg]));
	}
	
}

function removeImage() {
    global $connect, $config; 

	$ID = abs((int)$_POST['object_id']);
	$table = clearObject($_POST["object_table"]);
	$prefix = clearObject($_POST["object_prefix"]);
	$img = clearObject($_POST["object_img"]);
	$path = clearObject($_POST["object_path"]);
	$remove = clearObject($_POST["object_remove"]);
	
	if (empty($table) || empty($prefix) || empty($ID)) {
		die(json_encode(["answer" => "Системная ошибка!!"]));
	}
	
	$query = "SELECT * FROM `{$config["prefix"]}{$table}` WHERE `{$prefix}_id` = {$ID}";
    $request = mysqli_query($connect, $query) or
        die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	$object = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];
	
	if (!empty($object[$img])) {
		$dummy = explode('|', $object[$img]);
		$image = ''; $dir = '';
		if (count($dummy) > 1) {
			foreach($dummy as $item) {
				if ($item == $remove) continue;
				if (empty($image)) $image = $item;
					else $image .= "|$item";
			}
			if (!empty($image)) $dir = $object[$path];
		}
		
		$query = "UPDATE `{$config["prefix"]}{$table}` SET `{$path}` = '{$dir}', `{$img}` = '{$image}', `{$prefix}_dateupdate` = NOW() WHERE `{$prefix}_id` = {$ID}";
		$request = mysqli_query($connect, $query) or
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
			
		if (mysqli_affected_rows($connect) > 0) {
			@unlink(DR . $object[$path] .'thumb/' . $remove);
			@unlink(DR . $object[$path] . $remove);
			die(json_encode(["answer" => "success"]));
		} else {
			die(json_encode(["answer" => "Не удалось удалить изображение!"]));
		}
		
	} else {
		die(json_encode(["answer" => "Системная ошибка!"]));
	}
	
}

function removeSlider() {
	global $connect, $config;
	header('Content-Type: application/json');
	$ID = abs((int)$_POST['object_id']);
	$remove = clearObject($_POST["object_remove"]);
	$responce = false;

	if (empty($remove) || empty($ID)) {
		die(json_encode(["answer" => "Системная ошибка!!"]));
	}

	$query = "SELECT * FROM `{$config["prefix"]}sliders` WHERE `slider_id` = {$ID}";
	$request = mysqli_query($connect, $query) or
	die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	$object = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];

	if (!empty($object['slider_sliders'])) {
		$object['slider_sliders'] = unserialize($object['slider_sliders']);
		foreach($object['slider_sliders'] as $key => $item) {
			if ($item['slider'] == $remove) {
				$responce = true;
				$object['slider_sliders'][$key]['slider'] = '';
				break;
			}
		}
		if ($responce) {
			$object['slider_sliders'] = serialize($object['slider_sliders']);
			$query = "UPDATE `{$config["prefix"]}sliders` SET `slider_sliders` = '{$object['slider_sliders']}', `slider_dateupdate` = NOW() WHERE `slider_id` = {$ID}";
			$request = mysqli_query($connect, $query) or
				die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

			if (mysqli_affected_rows($connect) > 0) {
				@unlink(DR . $object['slider_path'] .'thumb/' . $remove);
				@unlink(DR . $object['slider_path'] . $remove);
				die(json_encode(["answer" => "success"]));
			} else {
				die(json_encode(["answer" => "Не удалось удалить изображение!"]));
			}
		}
	} else {
		die(json_encode(["answer" => "Системная ошибка!"]));
	}

}

function getObjecPageForMenu($request, $perpage, $json=false) {
	global $connect, $config; $and = ' '; $end = '';
	if ($json) header('Content-Type: application/json');	
	$request = clearObject($request);
	$perpage = (abs((int)$perpage) > 100) ? 100 : ((abs((int)$perpage) < 1) ? 1 : abs((int)$perpage)); 
	if (!empty($_POST['simulars'][0]) && is_array($_POST['simulars'])) { 
		foreach($_POST['simulars'] as $item) {
			$and = $item . ', ';
		} $and = ' `page_id` NOT IN(' . substr($and, 0, -2) . ') AND ('; $end = ')';
	} 
	$query = "SELECT * FROM `{$config["prefix"]}pages` WHERE{$and}`page_title` LIKE '%{$request}%' OR `page_text` LIKE '%{$request}%'{$end} ORDER BY `page_id` DESC LIMIT 0,{$perpage}";
    $request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	return (mysqli_num_rows($request) > 0) ? ($json ? die(json_encode(['result' => mysqli_fetch_all($request, MYSQLI_ASSOC), 'request' => 'success'])) :  mysqli_fetch_all($request, MYSQLI_ASSOC)) : ($json ? die(json_encode(['result' => [], 'request' => 'notfound'])) : []);
}

function getObjecTermForMenu($request, $perpage, $json=false) {
	global $connect, $config; $and = ' '; $end = '';
	if ($json) header('Content-Type: application/json');
	$request = clearObject($request);
	$perpage = (abs((int)$perpage) > 100) ? 100 : ((abs((int)$perpage) < 1) ? 1 : abs((int)$perpage));
	if (!empty($_POST['simulars'][0]) && is_array($_POST['simulars'])) {
		foreach($_POST['simulars'] as $item) {
			$and = $item . ', ';
		} $and = ' `term_id` NOT IN(' . substr($and, 0, -2) . ') AND ('; $end = ')';
	}
	$query = "SELECT * FROM `{$config["prefix"]}terms` WHERE{$and}`term_title` LIKE '%{$request}%' {$end} ORDER BY `term_id` DESC LIMIT 0,{$perpage}";
	$request = mysqli_query($connect, $query) or
	die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	return (mysqli_num_rows($request) > 0) ? ($json ? die(json_encode(['result' => mysqli_fetch_all($request, MYSQLI_ASSOC), 'request' => 'success'])) :  mysqli_fetch_all($request, MYSQLI_ASSOC)) : ($json ? die(json_encode(['result' => [], 'request' => 'notfound'])) : []);
}

function getObjecPostForMenu($request, $perpage, $json=false) {
	global $connect, $config; $and = ' '; $end = '';
	if ($json) header('Content-Type: application/json');
	$request = clearObject($request);
	$perpage = (abs((int)$perpage) > 100) ? 100 : ((abs((int)$perpage) < 1) ? 1 : abs((int)$perpage));
	if (!empty($_POST['simulars'][0]) && is_array($_POST['simulars'])) {
		foreach($_POST['simulars'] as $item) {
			$and = $item . ', ';
		} $and = ' `post_id` NOT IN(' . substr($and, 0, -2) . ') AND ('; $end = ')';
	}
	$query = "SELECT * FROM `{$config["prefix"]}posts` WHERE{$and}`post_title` LIKE '%{$request}%' OR `post_text` LIKE '%{$request}%' OR `post_quote` LIKE '%{$request}%' {$end} ORDER BY `post_id` DESC LIMIT 0,{$perpage}";
	$request = mysqli_query($connect, $query) or
	die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	return (mysqli_num_rows($request) > 0) ? ($json ? die(json_encode(['result' => mysqli_fetch_all($request, MYSQLI_ASSOC), 'request' => 'success'])) :  mysqli_fetch_all($request, MYSQLI_ASSOC)) : ($json ? die(json_encode(['result' => [], 'request' => 'notfound'])) : []);
}

function getObjecCatForMenu($request, $perpage, $json=false) {
	global $connect, $config; $and = ' '; $end = '';
	if ($json) header('Content-Type: application/json');
	$request = clearObject($request);
	$perpage = (abs((int)$perpage) > 100) ? 100 : ((abs((int)$perpage) < 1) ? 1 : abs((int)$perpage));
	if (!empty($_POST['simulars'][0]) && is_array($_POST['simulars'])) {
		foreach($_POST['simulars'] as $item) {
			$and = $item . ', ';
		} $and = ' `cat_id` NOT IN(' . substr($and, 0, -2) . ') AND ('; $end = ')';
	}
	$query = "SELECT * FROM `{$config["prefix"]}cats` WHERE{$and}`cat_title` LIKE '%{$request}%' {$end} ORDER BY `cat_id` DESC LIMIT 0,{$perpage}";
	$request = mysqli_query($connect, $query) or
	die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	return (mysqli_num_rows($request) > 0) ? ($json ? die(json_encode(['result' => mysqli_fetch_all($request, MYSQLI_ASSOC), 'request' => 'success'])) :  mysqli_fetch_all($request, MYSQLI_ASSOC)) : ($json ? die(json_encode(['result' => [], 'request' => 'notfound'])) : []);
}

function getObjecProductForMenu($request, $perpage, $json=false) {
	global $connect, $config; $and = ' '; $end = '';
	if ($json) header('Content-Type: application/json');
	$request = clearObject($request);
	$perpage = (abs((int)$perpage) > 100) ? 100 : ((abs((int)$perpage) < 1) ? 1 : abs((int)$perpage));
	if (!empty($_POST['simulars'][0]) && is_array($_POST['simulars'])) {
		foreach($_POST['simulars'] as $item) {
			$and = $item . ', ';
		} $and = ' `product_id` NOT IN(' . substr($and, 0, -2) . ') AND ('; $end = ')';
	}
	$query = "SELECT * FROM `{$config["prefix"]}products` WHERE{$and}`product_title` LIKE '%{$request}%' OR `product_article` LIKE '%{$request}%' {$end} ORDER BY `product_id` DESC LIMIT 0,{$perpage}";
	$request = mysqli_query($connect, $query) or
	die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	return (mysqli_num_rows($request) > 0) ? ($json ? die(json_encode(['result' => mysqli_fetch_all($request, MYSQLI_ASSOC), 'request' => 'success'])) :  mysqli_fetch_all($request, MYSQLI_ASSOC)) : ($json ? die(json_encode(['result' => [], 'request' => 'notfound'])) : []);
}

function getSimularProductByArticle($article, $json=false) {
	global $connect, $config; $article = clearObject($article); $and = '';
	if ($json) header('Content-Type: application/json');
	if (!empty($_POST['simulars'][0]) && is_array($_POST['simulars'])) {
		foreach($_POST['simulars'] as $item) {
			$and = $item . ', ';
		} $and = ' AND product_id NOT IN(' . substr($and, 0, -2) . ')';
	}
	$query = "SELECT * FROM `{$config["prefix"]}products` WHERE `product_article` LIKE '%{$article}%'{$and} ORDER BY `product_id` DESC LIMIT 50";
    $request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	return (mysqli_num_rows($request) > 0) ? ($json ? die(json_encode(['result' => mysqli_fetch_all($request, MYSQLI_ASSOC), 'request' => 'success'])) :  mysqli_fetch_all($request, MYSQLI_ASSOC)) : ($json ? die(json_encode(['result' => [], 'request' => 'notfound'])) : []);
}

function checkSimularData() {
	global $connect, $config; $data = clearObject($_POST['value']);
	header('Content-Type: application/json');
	if ($_POST['id'] == 'title') $title = 'post_title'; else $title = 'post_name';
	$query = "SELECT * FROM `{$config["prefix"]}posts` WHERE `{$title}` = '{$data}' ORDER BY `post_id` DESC LIMIT 50";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	return (mysqli_num_rows($request) > 0) ? die(json_encode(['result' => 'true'])) :  die(json_encode(['result' => 'false']));
}

function getSimulars($array, $prefix) {
	global $connect, $config; $ID = '';
	if (empty($array) || !is_array($array)) return []; else {
		foreach($array as $item) {
			$ID = $item . ', ';
		} $ID = substr($ID, 0, -2);
	} if (empty($ID)) return [];
	
	$query = "SELECT * FROM `{$config["prefix"]}{$prefix}s` WHERE `{$prefix}_id` IN ({$ID})";
    $request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC) : [];
}

function getPageById($ID) {
	global $connect, $config;

	$query = "SELECT * FROM `{$config["prefix"]}pages` WHERE `page_id` = {$ID}";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];
}

function getQty() {
    //if (!empty($_SESSION['total_quantity'])) return $_SESSION['total_quantity']; return 0;
    if(!empty($_SESSION['shopbag'])) return count($_SESSION['shopbag']); return 0;
}

function getSum($discount=true) {
    if ($discount) if (!empty($_SESSION['total_sum_withDiscount'])) return $_SESSION['total_sum_withDiscount']; return 0;
    if (!$discount) if (!empty($_SESSION['total_sum'])) return $_SESSION['total_sum']; return 0;
}

function getLinks($links, $prefix=false, $slash=false) {
	$dummy = []; $prefix = ($prefix) ? '/' . $prefix . '/' : '';
	foreach($links as $link)
		$dummy[] = !empty($link['slug']) ? $prefix . $link['slug'] . (($slash) ? '/' : '') : '';
	return $dummy;
}

function getBreadCrumbs($prefix, $object) {
	if (empty($object[$prefix . '_fullslug'])) return [];

	$breadCrumbs = explode('/', $object[$prefix . '_fullslug']);
	$counter = count($breadCrumbs); $dummy = '';

	if ($counter > 1) {
		for ($i=$counter; $i > 0; $i--) {
			$dummy .= "'";
			for($y=0; $y < $i; $y++) {
				$dummy .= clearObject($breadCrumbs[$y]) . '/';
			} $dummy = substr($dummy, 0, -1); $dummy .= "',";
		} $dummy = substr($dummy, 0, -1);

		if (empty($dummy)) return [];
		global $connect, $config;
		$query = "SELECT * FROM `{$config["prefix"]}{$prefix}s` WHERE `{$prefix}_fullslug` IN ({$dummy}) ORDER BY `{$prefix}_id` ASC";
		$request = mysqli_query($connect, $query) or
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		if (mysqli_num_rows($request) > 0) {
			$items = mysqli_fetch_all($request, MYSQLI_ASSOC); $dummy = []; $i = 0;
			foreach($items as $item) {
				$dummy[$i]['title'] = $item[$prefix . '_title'];
				$dummy[$i]['slug'] = $item[$prefix . '_fullslug'];
				$dummy[$i]['active'] = ($item[$prefix . '_fullslug'] == $object[$prefix . '_fullslug']) ? 'current' : '';
				$i++;
			} return $dummy;
		} else {return [];}
	} else {
		return [0=>['title'=>$object[$prefix . '_title'], 'slug'=>$object[$prefix . '_fullslug'], 'active'=>'current']];
	}
}

function is_home() {
    global $controller;
    if ($controller == 'index') return true;
    return false;
}

function getPageBySlug($slug) {
	global $connect, $config; $slug = clearObject($slug);

	$query = "SELECT * FROM `{$config["prefix"]}pages` WHERE `page_fullslug` = '{$slug}'";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];
}

function getSliderById($ID) {
	global $connect, $config;

	$query = "SELECT * FROM `{$config["prefix"]}sliders` WHERE `slider_id` = {$ID}";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];
}

function getSliderByName($callname) {
	global $connect, $config; $callname = clearObject($callname);

	$query = "SELECT * FROM `{$config["prefix"]}sliders` WHERE `slider_callname` = '{$callname}'";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];
}

function getOrders($args) {
	global $connect, $config;

	$query = "SELECT * FROM `{$config["prefix"]}{$args['table']}` o LEFT JOIN `{$config["prefix"]}users` u ON u.`user_id` = o.`user_id`{$config['where']}";
	//$query = str_replace("%body%", "black", $query);
	//die($query);
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC) : [];
}

function getOrderById($orderId) {
	global $connect, $config; $dummy = [];

	$query = "SELECT * FROM `{$config["prefix"]}orders` o LEFT JOIN `{$config["prefix"]}users` u ON u.`user_id` = o.`user_id` WHERE o.`order_id` = {$orderId}";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	if (mysqli_num_rows($request) > 0) {
		$dummy = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];
		if (!empty($dummy['order_products'])) {
			$dummy['order_products'] = explode(',', $dummy['order_products']); $prdcts = ''; $qty = [];
			foreach($dummy['order_products'] as $item) {
				$prdcts .= explode('|', $item)[0] . ',';
				$qty[explode('|', $item)[0]] = explode('|', $item)[1];
			} $prdcts = substr($prdcts, 0, -1);
			$query = "SELECT * FROM `{$config["prefix"]}products` WHERE `product_id` IN ({$prdcts})";
			$request = mysqli_query($connect, $query) or
				die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
			if  (mysqli_num_rows($request) > 0) {
				while ($row = mysqli_fetch_assoc($request)) {
					$dummy['products'][$row['product_id']] = $row;
					if (!empty($qty[$row['product_id']])) $dummy['products'][$row['product_id']]['qty'] = $qty[$row['product_id']];
				}
			}
		}
	} return $dummy;
}

function getTermById($ID) {
	global $connect, $config;

	$query = "SELECT * FROM `{$config["prefix"]}terms` WHERE `term_id` = {$ID}";
    $request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];
}

function getFeedById($ID) {
	global $connect, $config;

	$query = "SELECT * FROM `{$config["prefix"]}callback` WHERE `call_id` = {$ID}";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];
}

function getDeliveryById($ID) {
	global $connect, $config;

	$query = "SELECT * FROM `{$config["prefix"]}delivery` WHERE `delivery_id` = {$ID}";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];
}

function getTermBySlug($slug) {
	global $connect, $config;
	$slug = clearObject($slug);
	$query = "SELECT * FROM `{$config["prefix"]}terms` WHERE `term_fullslug` = '{$slug}' AND `term_visible` = 1";
    $request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];
}

function getCatBySlug($slug) {
	global $connect, $config;
	$slug = clearObject($slug);
	$query = "SELECT * FROM `{$config["prefix"]}cats` WHERE `cat_fullslug` = '{$slug}' AND `cat_visible` = 1";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];
}

function getCatById($ID) {
	global $connect, $config;

	$query = "SELECT * FROM `{$config["prefix"]}cats` WHERE `cat_id` = {$ID}";
    $request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];
}

function getData($data) {
	global $config;
	if ($data == 'page') {
		return !empty($_GET['page']) ? abs((int)$_GET['page']) : 2;
	}
	if ($data == 'perpage') {
		return !empty($_GET['perpage']) ? abs((int)$_GET['perpage']) : $config['settings']->perpage->value;
	}
}

function getTreeSlug($controller) {
	$uri = explode('?', $_SERVER["REQUEST_URI"]);
	$uri = str_replace("/{$controller}/", "", $uri[0]);
	return substr($uri, 0, -1);
}

function addPage() {
 	global $connect, $config;
	$args = array(); $_SESSION['answer'] = ""; $slug = '';
	
    $args['title'] = clearObject($_POST['title']);
    $args['slug'] = clearObject($_POST['slug']);
    $args['keywords'] = clearObject($_POST['keywords']);
    $args['description'] = clearObject($_POST['description']);
    $args['text'] = clearObject($_POST['text'], true);
    $args['parent'] = abs((int)$_POST['parent']);
	$args['visible'] = abs((int)$_POST['visible']);
	
	//pageparams plugin
	$args['params'] = array();
	if (!empty($_POST['params']) && is_array($_POST['params']))
		foreach($_POST['params'] as $k => $v) {
			if (empty($v)) continue;
			$args['params'][clearObject($v)] = (isset($_POST['values'][$k])) ? clearObject($_POST['values'][$k], true): '';
		}
		
	//pagemediafields plugin
	$args['paramsmedia'] = array();
	if (!empty($_POST['paramsmedia']) && is_array($_POST['paramsmedia']))
		foreach($_POST['paramsmedia'] as $k => $v) {
			if (empty($v)) continue;
			$args['paramsmedia'][clearObject($v)] = (isset($_POST['valuesmedia'][$k])) ? clearObject($_POST['valuesmedia'][$k]): '';
		}
	
	if (!$args['title'] || !$args['slug']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У страницы <b>минимум</b> должен быть заголовок и адрес!</div>';
		saveArgs($args);
		redirect("?view=add_page"); 
	}
	
	if (!preg_match("/^[a-z_0-9-]+$/s", $args['slug'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Адрес страницы может состоять только из маленьких латинских букв, цифр, знаков подчеркивания и дефиса!</div>';
		saveArgs($args);
		redirect("?view=add_page"); 
	}

	if ($args['parent'] > 0) {
		/** генерация адреса для страницы **/
		$query = "SELECT * FROM {$config["prefix"]}pages WHERE `page_id` = {$args['parent']}";
		$request = mysqli_query($connect, $query) or 
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		
		$slug = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0]['page_fullslug'] : '';
		/** генерация адреса для страницы **/
	}
	
	$slug = !empty($slug) ? $slug . '/' . $args['slug'] : $args['slug'];
	
	/** проверка адреса страницы на уникальность (на своем уровне) **/
	$query = "SELECT `page_id` FROM `{$config["prefix"]}pages` WHERE `page_fullslug` = '{$slug}'";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	$row = mysqli_fetch_all($request, MYSQLI_ASSOC);
	if (!empty($row[0]["page_id"])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У страницы <b>должен быть уникальный</b> адрес! Введенный Вами адрес уже используется на этом уровне!</div>';
		saveArgs($args);
		redirect("?view=add_page");
	}
	/** проверка адреса страницы на уникальность (на своем уровне) **/	
	
	$args['params']	= serialize($args['params']); //массив с произвольными полями вернется в случае чего, так что не спешим его преобразовывать в строку
	$args['paramsmedia'] = serialize($args['paramsmedia']);
    
	$query = "INSERT INTO `{$config["prefix"]}pages` (`page_title`, `page_keywords`, `page_description`, `page_parent`, `page_text`, `page_params`, `page_datecreate`, `page_dateupdate`, `page_slug`, `page_fullslug`, `page_visible`, `page_mediafields`) 
					VALUES ('{$args['title']}', '{$args['keywords']}', '{$args['description']}', {$args['parent']}, '{$args['text']}', '{$args['params']}', NOW(), NOW(), '{$args['slug']}', '{$slug}', {$args['visible']}, '{$args['paramsmedia']}')";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Страница успешно опубликована!</div>';
		
		$ID = mysqli_insert_id($connect);	
		
		if (!empty($_FILES['pagepicture']['name']) && $config["plugins"]->pages->pagepicture->active) {
			$path = "/files/pages/pagepicture/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			$response = uploadImage($_FILES['pagepicture'], $ID, $path, 0, [$config["settings"]->pages_pagepicture_imgsize->value[0], $config["settings"]->pages_pagepicture_imgsize->value[1]]);
			
			if ($response) {
				$response = clearObject($response);				
				mysqli_query($connect, "UPDATE `{$config["prefix"]}pages` SET `pagepicture` = '{$response}', `pagepicture_path` = '{$path}' WHERE `page_id` = {$ID}") or 
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Миниатюра успешно загружена!</div>';
			} else {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать миниатюру для страницы!</div>';
			}
		}
		
		if (!empty($_FILES['pagegallery']['name'][0]) && $config["plugins"]->pages->pagegallery->active) {
			$response = []; $response['pagegallery'] = ''; $image = [];
			$path = "/files/pages/pagegallery/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			for($i = 0; $i < count($_FILES['pagegallery']['name']); $i++) {
				//create img from gallery
				$image['name'] = !empty($_FILES['pagegallery']['name'][$i]) ? $_FILES['pagegallery']['name'][$i] : '';
				$image['type'] = !empty($_FILES['pagegallery']['type'][$i]) ? $_FILES['pagegallery']['type'][$i] : '';
				$image['tmp_name'] = !empty($_FILES['pagegallery']['tmp_name'][$i]) ? $_FILES['pagegallery']['tmp_name'][$i] : '';
				$image['error'] = isset($_FILES['pagegallery']['error'][$i]) ? $_FILES['pagegallery']['error'][$i] : '';
				$image['size'] = !empty($_FILES['pagegallery']['size'][$i]) ? $_FILES['pagegallery']['size'][$i] : '';
				
				if (empty($image['name'])) continue;
				$response[$i] = uploadImage($image, $ID, $path, $i, [$config["settings"]->pages_pagegallery_imgsize->value[0], $config["settings"]->pages_pagegallery_imgsize->value[1]]);
				
				if ($response[$i]) {
					$response['pagegallery'] .= clearObject($response[$i]) . "|";
					$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Картинка галереи <b>' . $_FILES['pagegallery']['name'][$i] . '</b> успешно загружена!</div>';
				} else {
					$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать картинку галереи <b>' . $_FILES['pagegallery']['name'][$i] . '</b> для страницы!</div>';
				}
			}
			
			if (!empty($response['pagegallery'])) {
				$response['pagegallery'] = substr($response['pagegallery'], 0, -1);
				mysqli_query($connect, "UPDATE `{$config["prefix"]}pages` SET `pagegallery` = '{$response['pagegallery']}', `pagegallery_path` = '{$path}' WHERE `page_id` = {$ID}") or 
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
			}
		}
		
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При публикации страницы произошел сбой!</div>';
	} if (isset($ID) && !empty($ID) && $config["settings"]->redirect->value) redirect("?view=update_page&page_id=" . $ID); redirect("?view=pages");
}

function updatePage($ID) {
 	global $connect, $config;
	$args = array(); $_SESSION['answer'] = ""; $slug = '';
	
    $args['title'] = clearObject($_POST['title']);
    $args['slug'] = clearObject($_POST['slug']);
    $args['keywords'] = clearObject($_POST['keywords']);
    $args['description'] = clearObject($_POST['description']);
    $args['text'] = clearObject($_POST['text'], true);
    $args['parent'] = abs((int)$_POST['parent']);
	$args['visible'] = abs((int)$_POST['visible']);
	
	//pageparams plugin
	$args['params'] = array();
	if (!empty($_POST['params']) && is_array($_POST['params']))
		foreach($_POST['params'] as $k => $v) {
			if (empty($v)) continue;
			$args['params'][clearObject($v)] = (isset($_POST['values'][$k])) ? clearObject($_POST['values'][$k], true): '';
		}
		
	//pagemediafields plugin
	$args['paramsmedia'] = array();
	if (!empty($_POST['paramsmedia']) && is_array($_POST['paramsmedia']))
		foreach($_POST['paramsmedia'] as $k => $v) {
			if (empty($v)) continue;
			$args['paramsmedia'][clearObject($v)] = (isset($_POST['valuesmedia'][$k])) ? clearObject($_POST['valuesmedia'][$k]): '';
		}
	
	if (!$args['title'] || !$args['slug']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У страницы <b>минимум</b> должен быть заголовок и адрес!</div>';
		saveArgs($args);
		redirect("?view=update_page&page_id=" . $ID); 
	}
	
	if ($ID == $args['parent']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Страница <b>не может быть</b> своим родителем!</div>';
		saveArgs($args);
		redirect("?view=update_page&page_id=" . $ID); 
	}
	
	$objects = sortObjectsTree(getObjectsTree('pages', 'page', true), 'page');
	$objectParent = explode('|', checkObjectsTreeParent($objects, $ID, 'page'));

	if ($args['parent'] > 0 && in_array($args['parent'], $objectParent)) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Страница <b>не может быть</b> потомком своего потомка!</div>';
		saveArgs($args);
		redirect("?view=update_page&page_id=" . $ID);  
	}
	
	if (!preg_match("/^[a-z_0-9-]+$/s", $args['slug'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Адрес страницы может состоять только из маленьких латинских букв, цифр, знаков подчеркивания и дефиса!</div>';
		saveArgs($args);
		redirect("?view=update_page&page_id=" . $ID); 
	}

	if ($args['parent'] > 0) {
		/** генерация адреса для страницы **/
		$query = "SELECT * FROM `{$config["prefix"]}pages` WHERE `page_id` = {$args['parent']}";
		$request = mysqli_query($connect, $query) or 
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		
		$dummy = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : '';
		$slug = !empty($dummy['page_fullslug']) ? $dummy['page_fullslug'] : '';
		/** генерация адреса для страницы **/
	}

	$slug = !empty($slug) ? $slug . '/' . $args['slug'] : $args['slug'];
	
	/** проверка адреса страницы на уникальность (на своем уровне) **/
	$query = "SELECT `page_id` FROM `{$config["prefix"]}pages` WHERE `page_fullslug` = '{$slug}' AND `page_id` != {$ID}";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	$row = mysqli_fetch_all($request, MYSQLI_ASSOC);
	if (!empty($row[0]["page_id"])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У страницы <b>должен быть уникальный</b> адрес! Введенный Вами адрес уже используется на этом уровне!</div>';
		saveArgs($args);
		redirect("?view=update_page&page_id=" . $ID);
	}
	/** проверка адреса страницы на уникальность (на своем уровне) **/	
	
	$args['params']	= serialize($args['params']); //массив с произвольными полями вернется в случае чего, так что не спешим его преобразовывать в строку
	$args['paramsmedia'] = serialize($args['paramsmedia']);
	
	$query = "UPDATE `{$config["prefix"]}pages` SET 
					`page_title` = '{$args['title']}',
					`page_keywords` = '{$args['keywords']}',
					`page_description` = '{$args['description']}',
					`page_parent` = {$args['parent']},
					`page_text` = '{$args['text']}',
					`page_params` = '{$args['params']}',
					`page_dateupdate` = NOW(),
					`page_slug` = '{$args['slug']}',
					`page_fullslug` = '{$slug}',
					`page_visible` = {$args['visible']},
					`page_mediafields` = '{$args['paramsmedia']}' WHERE `page_id` = {$ID}";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Страница успешно обновлена!</div>';	
		
		if (!empty($_FILES['pagepicture']['name']) && $config["plugins"]->pages->pagepicture->active) {
			$path = !empty($dummy['pagepicture_path']) ? $dummy['pagepicture_path'] : "/files/pages/pagepicture/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			$response = uploadImage($_FILES['pagepicture'], $ID, $path, 0, [$config["settings"]->pages_pagepicture_imgsize->value[0], $config["settings"]->pages_pagepicture_imgsize->value[1]]);
			
			if ($response) {
				$response = clearObject($response);				
				mysqli_query($connect, "UPDATE `{$config["prefix"]}pages` SET `pagepicture` = '{$response}', `pagepicture_path` = '{$path}' WHERE `page_id` = {$ID}") or 
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Миниатюра успешно загружена!</div>';
			} else {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать миниатюру для страницы!</div>';
			}
		}	
		
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При обновлении страницы произошел сбой!</div>';
	} if (isset($ID) && !empty($ID) && $config["settings"]->redirect->value) redirect("?view=update_page&page_id=" . $ID); redirect("?view=pages");
}

function addTerm() {
 	global $connect, $config;
	$args = array(); $_SESSION['answer'] = ""; $slug = '';
	
    $args['title'] = clearObject($_POST['title']);
    $args['slug'] = clearObject($_POST['slug']);
    $args['keywords'] = clearObject($_POST['keywords']);
    $args['description'] = clearObject($_POST['description']);
    $args['text'] = clearObject($_POST['text'], true);
    $args['parent'] = abs((int)$_POST['parent']);
	$args['visible'] = abs((int)$_POST['visible']);
	
	//termparams plugin
	$args['params'] = array();
	if (!empty($_POST['params']) && is_array($_POST['params']))
		foreach($_POST['params'] as $k => $v) {
			if (empty($v)) continue;
			$args['params'][clearObject($v)] = (isset($_POST['values'][$k])) ? clearObject($_POST['values'][$k], true): '';
		}
		
	//termmediafields plugin
	$args['paramsmedia'] = array();
	if (!empty($_POST['paramsmedia']) && is_array($_POST['paramsmedia']))
		foreach($_POST['paramsmedia'] as $k => $v) {
			if (empty($v)) continue;
			$args['paramsmedia'][clearObject($v)] = (isset($_POST['valuesmedia'][$k])) ? clearObject($_POST['valuesmedia'][$k]): '';
		}
	
	if (!$args['title'] || !$args['slug']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У рубрики <b>минимум</b> должен быть заголовок и адрес!</div>';
		saveArgs($args);
		redirect("?view=add_term"); 
	}
	
	if (!preg_match("/^[a-z_0-9-]+$/s", $args['slug'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Адрес рубрики может состоять только из маленьких латинских букв, цифр, знаков подчеркивания и дефиса!</div>';
		saveArgs($args);
		redirect("?view=add_term"); 
	}

	if ($args['parent'] > 0) {
		/** генерация адреса для рубрики **/
		$query = "SELECT * FROM `{$config["prefix"]}terms` WHERE `term_id` = {$args['parent']}";
		$request = mysqli_query($connect, $query) or 
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		
		$slug = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0]['term_fullslug'] : '';
		/** генерация адреса для рубрики **/
	}
	
	$slug = !empty($slug) ? $slug . '/' . $args['slug'] : $args['slug'];
	
	/** проверка адреса рубрики на уникальность (на своем уровне) **/
	$query = "SELECT `term_id` FROM `{$config["prefix"]}terms` WHERE `term_fullslug` = '{$slug}'";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	$row = mysqli_fetch_all($request, MYSQLI_ASSOC);
	if (!empty($row[0]["term_id"])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У рубрики <b>должен быть уникальный</b> адрес! Введенный Вами адрес уже используется на этом уровне!</div>';
		saveArgs($args);
		redirect("?view=add_term");
	}
	/** проверка адреса рубрики на уникальность (на своем уровне) **/	
	
	$args['params']	= serialize($args['params']); //массив с произвольными полями вернется в случае чего, так что не спешим его преобразовывать в строку
	$args['paramsmedia'] = serialize($args['paramsmedia']);
    
	$query = "INSERT INTO `{$config["prefix"]}terms` (`term_title`, `term_keywords`, `term_description`, `term_parent`, `term_text`, `term_params`, `term_datecreate`, `term_dateupdate`, `term_slug`, `term_fullslug`, `term_visible`, `term_mediafields`) 
					VALUES ('{$args['title']}', '{$args['keywords']}', '{$args['description']}', {$args['parent']}, '{$args['text']}', '{$args['params']}', NOW(), NOW(), '{$args['slug']}', '{$slug}', {$args['visible']}, '{$args['paramsmedia']}')";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Рубрика успешно опубликована!</div>';
		
		$ID = mysqli_insert_id($connect);	
		
		if (!empty($_FILES['termpicture']['name']) && $config["plugins"]->terms->termpicture->active) {
			$path = "/files/terms/termpicture/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			$response = uploadImage($_FILES['termpicture'], $ID, $path, 0, [$config["settings"]->terms_termpicture_imgsize->value[0], $config["settings"]->terms_termpicture_imgsize->value[1]]);
			
			if ($response) {
				$response = clearObject($response);				
				mysqli_query($connect, "UPDATE `{$config["prefix"]}terms` SET `termpicture` = '{$response}', `termpicture_path` = '{$path}' WHERE `term_id` = {$ID}") or 
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Миниатюра успешно загружена!</div>';
			} else {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать миниатюру для рубрики!</div>';
			}
		}
		
		if (!empty($_FILES['termgallery']['name'][0]) && $config["plugins"]->terms->termgallery->active) {
			$response = []; $response['termgallery'] = ''; $image = [];
			$path = "/files/terms/termgallery/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			for($i = 0; $i < count($_FILES['termgallery']['name']); $i++) {
				//create img from gallery
				$image['name'] = !empty($_FILES['termgallery']['name'][$i]) ? $_FILES['termgallery']['name'][$i] : '';
				$image['type'] = !empty($_FILES['termgallery']['type'][$i]) ? $_FILES['termgallery']['type'][$i] : '';
				$image['tmp_name'] = !empty($_FILES['termgallery']['tmp_name'][$i]) ? $_FILES['termgallery']['tmp_name'][$i] : '';
				$image['error'] = isset($_FILES['termgallery']['error'][$i]) ? $_FILES['termgallery']['error'][$i] : '';
				$image['size'] = !empty($_FILES['termgallery']['size'][$i]) ? $_FILES['termgallery']['size'][$i] : '';
				
				if (empty($image['name'])) continue;
				$response[$i] = uploadImage($image, $ID, $path, $i, [$config["settings"]->terms_termgallery_imgsize->value[0], $config["settings"]->terms_termgallery_imgsize->value[1]]);
				
				if ($response[$i]) {
					$response['termgallery'] .= clearObject($response[$i]) . "|";
					$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Картинка галереи <b>' . $_FILES['termgallery']['name'][$i] . '</b> успешно загружена!</div>';
				} else {
					$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать картинку галереи <b>' . $_FILES['termgallery']['name'][$i] . '</b> для рубрики!</div>';
				}
			}
			
			if (!empty($response['termgallery'])) {
				$response['termgallery'] = substr($response['termgallery'], 0, -1);
				mysqli_query($connect, "UPDATE `{$config["prefix"]}terms` SET `termgallery` = '{$response['termgallery']}', `termgallery_path` = '{$path}' WHERE `term_id` = {$ID}") or 
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
			}
		}
		
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При публикации рубрики произошел сбой!</div>';
	} if (isset($ID) && !empty($ID) && $config["settings"]->redirect->value) redirect("?view=update_term&term_id=" . $ID); redirect("?view=terms");
}

function updateTerm($ID) {
 	global $connect, $config;
	$args = array(); $_SESSION['answer'] = ""; $slug = '';
	
    $args['title'] = clearObject($_POST['title']);
    $args['slug'] = clearObject($_POST['slug']);
    $args['keywords'] = clearObject($_POST['keywords']);
    $args['description'] = clearObject($_POST['description']);
    $args['text'] = clearObject($_POST['text'], true);
    $args['parent'] = abs((int)$_POST['parent']);
	$args['visible'] = abs((int)$_POST['visible']);
	
	//termparams plugin
	$args['params'] = array();
	if (!empty($_POST['params']) && is_array($_POST['params']))
		foreach($_POST['params'] as $k => $v) {
			if (empty($v)) continue;
			$args['params'][clearObject($v)] = (isset($_POST['values'][$k])) ? clearObject($_POST['values'][$k], true): '';
		}
		
	//termmediafields plugin
	$args['paramsmedia'] = array();
	if (!empty($_POST['paramsmedia']) && is_array($_POST['paramsmedia']))
		foreach($_POST['paramsmedia'] as $k => $v) {
			if (empty($v)) continue;
			$args['paramsmedia'][clearObject($v)] = (isset($_POST['valuesmedia'][$k])) ? clearObject($_POST['valuesmedia'][$k]): '';
		}
	
	if (!$args['title'] || !$args['slug']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У рубрики <b>минимум</b> должен быть заголовок и адрес!</div>';
		saveArgs($args);
		redirect("?view=update_term&term_id=" . $ID); 
	}
	
	if ($ID == $args['parent']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Рубрика <b>не может быть</b> своим родителем!</div>';
		saveArgs($args);
		redirect("?view=update_term&term_id=" . $ID); 
	}
	
	$objects = sortObjectsTree(getObjectsTree('terms', 'term', true), 'term');
	$objectParent = explode('|', checkObjectsTreeParent($objects, $ID, 'term'));

	if ($args['parent'] > 0 && in_array($args['parent'], $objectParent)) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Рубрика <b>не может быть</b> потомком своего потомка!</div>';
		saveArgs($args);
		redirect("?view=update_term&term_id=" . $ID);  
	}
	
	if (!preg_match("/^[a-z_0-9-]+$/s", $args['slug'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Адрес рубрики может состоять только из маленьких латинских букв, цифр, знаков подчеркивания и дефиса!</div>';
		saveArgs($args);
		redirect("?view=update_term&term_id=" . $ID); 
	}

	if ($args['parent'] > 0) {
		/** генерация адреса для рубрики **/
		$query = "SELECT * FROM `{$config["prefix"]}terms` WHERE `term_id` = {$args['parent']}";
		$request = mysqli_query($connect, $query) or 
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		
		$dummy = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : '';
		$slug = !empty($dummy['term_fullslug']) ? $dummy['term_fullslug'] : '';
		/** генерация адреса для рубрики **/
	}

	$slug = !empty($slug) ? $slug . '/' . $args['slug'] : $args['slug'];
	
	/** проверка адреса рубрики на уникальность (на своем уровне) **/
	$query = "SELECT `term_id` FROM `{$config["prefix"]}terms` WHERE `term_fullslug` = '{$slug}' AND `term_id` != {$ID}";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	$row = mysqli_fetch_all($request, MYSQLI_ASSOC);
	if (!empty($row[0]["term_id"])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У рубрики <b>должен быть уникальный</b> адрес! Введенный Вами адрес уже используется на этом уровне!</div>';
		saveArgs($args);
		redirect("?view=update_term&term_id=" . $ID);
	}
	/** проверка адреса рубрики на уникальность (на своем уровне) **/	
	
	$args['params']	= serialize($args['params']); //массив с произвольными полями вернется в случае чего, так что не спешим его преобразовывать в строку
	$args['paramsmedia'] = serialize($args['paramsmedia']);
	
	$query = "UPDATE `{$config["prefix"]}terms` SET 
					`term_title` = '{$args['title']}',
					`term_keywords` = '{$args['keywords']}',
					`term_description` = '{$args['description']}',
					`term_parent` = {$args['parent']},
					`term_text` = '{$args['text']}',
					`term_params` = '{$args['params']}',
					`term_dateupdate` = NOW(),
					`term_slug` = '{$args['slug']}',
					`term_fullslug` = '{$slug}',
					`term_visible` = {$args['visible']},
					`term_mediafields` = '{$args['paramsmedia']}' WHERE `term_id` = {$ID}";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Рубрика успешно обновлена!</div>';	
		
		if (!empty($_FILES['termpicture']['name']) && $config["plugins"]->terms->termpicture->active) {
			$path = !empty($dummy['termpicture_path']) ? $dummy['termpicture_path'] : "/files/terms/termpicture/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			$response = uploadImage($_FILES['termpicture'], $ID, $path, 0, [$config["settings"]->terms_termpicture_imgsize->value[0], $config["settings"]->terms_termpicture_imgsize->value[1]]);
			
			if ($response) {
				$response = clearObject($response);				
				mysqli_query($connect, "UPDATE `{$config["prefix"]}terms` SET `termpicture` = '{$response}', `termpicture_path` = '{$path}' WHERE `term_id` = {$ID}") or 
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Миниатюра успешно загружена!</div>';
			} else {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать миниатюру для рубрики!</div>';
			}
		}	
		
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При обновлении рубрики произошел сбой!</div>';
	} if (isset($ID) && !empty($ID) && $config["settings"]->redirect->value) redirect("?view=update_term&term_id=" . $ID); redirect("?view=terms");
}

function removeTreeObject($ID, $table, $fields, $message, $path=[], $relationship=false) {
	global $connect, $config; $items = [];
	$_SESSION['answer'] = "";
	
	#$fields[0]; //object_id 
	#$fields[1]; //object_parent
	
	$query = "SELECT * FROM `{$config["prefix"]}{$table}` WHERE `{$fields[0]}` = {$ID}";
    $request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	$objects = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC) : [];
	
	if (empty($objects) || !is_array($objects)) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Пы пытаетесь удалить несуществующую ' . $message[0] . '!</div>';
		redirect("?view={$table}");
	}
	
	$objectParent = isset($objects[0][$fields[1]]) ? $objects[0][$fields[1]] : 0;
	
	if (!empty($path) && is_array($path)) {
		foreach($path as $key => $value) {
			$items[] = !empty($objects[0][$value]) ? $objects[0][$value] : '';
		}
	}

	// Обновляем данные для вложенных объектов первого уровня объекта $ID (назначем новое значение ID родительского объекта)
	$query = "UPDATE `{$config["prefix"]}{$table}` SET `{$fields[1]}` = {$objectParent} WHERE `{$fields[1]}` = {$ID}";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	// Удаляем объект с $ID
	$query = "DELETE FROM `{$config["prefix"]}{$table}` WHERE `{$fields[0]}` = {$ID}";
    $request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	if (mysqli_affected_rows($connect) > 0) {	
		if ($relationship) {
			// Удаляем все связи с объектами
			$query = "DELETE FROM `{$config["prefix"]}{$table}_relationship` WHERE `{$fields[0]}` = {$ID}";
			$request = mysqli_query($connect, $query) or 
				die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		}
		
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> ' . $message[0] . ' успешно удалена!</div>';
		
		if (!empty($items) && is_array($items)) {
			foreach($items as $item) {
				if (!empty($item) && file_exists(DR .$item)) {
					removeDirectory(DR .$item);
				}
			}
			$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Дополнительные файлы успешно удалены!</div>';
		}
		
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При удалении ' . $message[1] . ' произошел сбой!</div>';
	} if ($table == 'cats') redirect("?view=categories"); else redirect("?view={$table}");
}

function removeDirectory($dir) {
	if ($objs = glob($dir."/*")) {
		foreach($objs as $obj) {
			is_dir($obj) ? removeDirectory($obj) : unlink($obj);
		}
	} rmdir($dir);
}


function uploadImage($image, $ID, $path, $iterator, $size) {
	$imgExt = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $image['name']));
	$imgName = "{$iterator}_{$ID}.{$imgExt}";
	
	$types = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png");
	$error = "";
	
	if (!in_array($image['type'], $types)) $error .= "<li>Допустимые расширения - .gif, .jpg, .png!</li>";
	if ($image['size'] > SIZE) $error .= "<li>Максимальный вес файла - 1 Мб!</li>";
	if (empty($size[0]) || empty($size[1])) $error .= "<li>Неверные размеры изображения!</li>";
	if ($image['error']) $error .= "<li>Ошибка при загрузке файла!</li>";	
	
	if (!empty($error)) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка при загрузке <b>' . $imgName . '</b> картинки!</strong> <ul>' . $error . '</ul></div>';
		return false;
	}
	//print_array($image);
	$dirname = DR . $path; //echo DR; echo "<br>"; die($_SERVER['DOCUMENT_ROOT']);
	
	if (move_uploaded_file($image['tmp_name'], DR . "/files/tmp/{$imgName}")) {
		if (!file_exists($dirname)) {
			mkdir($dirname . "thumb/", 0755, true);
		} require_once ('../library/ThumbLib/ThumbLib.php');
					
		PhpThumbFactory::create(DR . "/files/tmp/{$imgName}")
							->save($dirname . $imgName, $imgExt)
							->adaptiveResize($size[0], $size[1])
							->save($dirname . "thumb/" . $imgName, $imgExt);
		@unlink(DR . "/files/tmp/{$imgName}");
		return $imgName;
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Не удалось переместить загруженное изображение. Проверьте права на папку в каталоге <b>' . $dirname . '</b></div>';
	} return false;
}

function getMenu($callname) {
	global $connect, $config;
	$callname = clearObject($callname);
	$query = "SELECT * FROM `{$config["prefix"]}menus` menu LEFT JOIN `{$config["prefix"]}menus_objects` object ON menu.`menu_id` = object.`object_mid` WHERE menu.`menu_name` = '{$callname}' ORDER BY object.`object_position`";
	$request = mysqli_query($connect, $query) or
        die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	if (mysqli_num_rows($request) > 0) {
        $items = mysqli_fetch_all($request, MYSQLI_ASSOC);
		foreach($items as $object) {
			$object['object_mediafields'] = unserialize($object['object_mediafields']);
			if (!empty($object['object_mediafields'])) {
				foreach($object['object_mediafields'] as $key => $value) {
					$object['object_mediafields'][$key] = $value;
				}
			}
			$objects[$object['object_parent']][] = $object;
		}
		return $objects;
	} else {
		return [];
	}
}

function getMenuByID($ID) {
	global $connect, $config;
	$ID = abs((int)$ID);
	$query = "SELECT * FROM `{$config["prefix"]}menus` menu LEFT JOIN `{$config["prefix"]}menus_objects` object ON menu.`menu_id` = object.`object_mid` WHERE menu.`menu_id` = '{$ID}' ORDER BY object.`object_position`";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	if (mysqli_num_rows($request) > 0) {
		$items = mysqli_fetch_all($request, MYSQLI_ASSOC);
		foreach($items as $object) {
			$object['object_mediafields'] = unserialize($object['object_mediafields']);
			if (!empty($object['object_mediafields'])) {
				foreach($object['object_mediafields'] as $key => $value) {
					$object['object_mediafields'][$key] = $value;
				}
			}
			$objects[$object['object_parent']][] = $object;
		}
		return $objects;
	} else {
		return [];
	}
}

function getMenuCount($ID) {
	global $connect, $config;
	$ID = abs((int)$ID);
	$query = "SELECT menu.*, object.`object_oid` as menu_items FROM `{$config["prefix"]}menus` menu LEFT JOIN `{$config["prefix"]}menus_objects` object ON menu.`menu_id` = object.`object_mid` WHERE menu.`menu_id` = '{$ID}' ORDER BY object.`object_oid` DESC";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];
}

function getDateForSort($prefix, $dateType) {
	global $connect, $config;
	switch($dateType) {
		case('datepublic'):break;
		case('dateupdate'):break;
		default: $dateType = 'datecreate';
	}
	$query = "SELECT DISTINCT DATE_FORMAT(`{$prefix}_{$dateType}`, '%Y-%m') as items FROM `{$config["prefix"]}{$prefix}s`";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC) : [];
}

function buildDateForSort($array, $prefix, $date) {
	$html = ''; if (empty($array[0])) return $html;
	foreach($array as $item) {
		$item = explode('-', $item['items']);
		$html .= '<option value="date:!' . $item[0] . '-' . $item[1] . ':!' . $prefix . '_' . $date .'">' . getMonthName($item[1]) . ' ' . $item[0] .'</option>';
	} return $html;
}

function getMonthName($month) {
	switch($month) {
		case('01'):return 'Январь';break;
		case('02'):return 'Февраль';break;
		case('03'):return 'Март';break;
		case('04'):return 'Апрель';break;
		case('05'):return 'Май';break;
		case('06'):return 'Июнь';break;
		case('07'):return 'Июль';break;
		case('08'):return 'Август';break;
		case('09'):return 'Сентябрь';break;
		case('10'):return 'Октябрь';break;
		case('11'):return 'Ноябрь';break;
		case('12'):return 'Декабрь';break;
		default: return 'Месяц';
	}
}

function getObjectsSort($prefix) {
	global $connect, $config;
	$query = "SELECT * FROM `{$config["prefix"]}{$prefix}s` ORDER BY `{$prefix}_id` ASC";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC) : [];
}

function buildAdminMenu($objects, $parentID=0) {
	global $config;
	if (empty($objects[$parentID])) {return;} $tree = '';
		foreach($objects[$parentID] as $object) {
			switch($object['object_type']) {
				case('url'):$objectTitle = 'Ссылка'; break;
				case('page'):$objectTitle = 'Страница'; break;
				case('term'):$objectTitle = 'Рубрика'; break;
				case('post'):$objectTitle = 'Запись'; break;
				case('product'):$objectTitle = 'Товар'; break;
				case('cat'):$objectTitle = 'Категория'; break;
				default: $objectTitle = 'unknown';
			}
			if ($config["plugins"]->menus->menumediafields->active) {
				//$object['object_mediafields'] = unserialize($object['object_mediafields']);
				$dummy = ''; $dummyID = mt_rand(3495,14423);
				foreach($object['object_mediafields'] as $key => $item) {
					$dummy .= '<div>
									<span class="remove">Х</span>
									<input class="form-control" type="text" name="paramsmedia[]" style="display:inline-block;width:25%;" value="' . $key . '" />
										&nbsp;:&nbsp;
									<input id="fieldID' . $dummyID . '" class="form-control fieldID" type="text" name="valuesmedia[]" value="' . $item . '" />
									<span class="input-group-btn" style="display: inline;margin-left: 0px;margin-top: 0px;position: absolute;">
										<button href="/library/filemanager/dialog.php?akey=' . UPLOAD_KEY .'&field_id=fieldID' . $dummyID . '&relative_url=1" style="padding: 6px 0px 6px 17px;" class="btn btn-default iframe-btn" type="button">
											<i class="fa fa-fw fa-camera" style="position: relative;top: -3px;left: -2px;color: grey;"></i>
											<i class="fa fa-fw fa-music" style="position: relative;left: -13px;top: 2px;color: grey;"></i>
										</button>
									</span>
								</div>';
				}
			}
			$tree .= '
			<li class="mjs-nestedSortable-leaf" id="menuItem_' . $object['object_oid'] . '">
			<div class="menuDiv">
				<span class="disclose ui-icon ui-icon-minusthick"><span></span></span>
				<span data-id="' . $object['object_oid'] . '" class="expandEditor ui-icon ui-icon-triangle-1-n"><span></span></span>
				<span>
					<span data-id="' . $object['object_oid'] . '" class="itemTitle" style="font-size:10px;color:#e71616;">[' . $objectTitle . ']</span>
					<span data-id="' . $object['object_oid'] . '" class="itemTitle" style="font-size:20px;">&nbsp;' . htmlDecode($object['object_title']) . '</span>
					<span data-id="' . $object['object_oid'] . '" class="deleteMenu ui-icon ui-icon-closethick" style="margin-top: 5px;"><span></span></span>
				</span>
				<div id="menuEdit' . $object['object_oid'] . '" class="menuEdit hidden1">
					<form id="formId' . $object['object_oid'] . '">
						<div class="form-group">
							<label style="min-width: 49%;">Текст:
								<input class="form-control" name="text" value="' . $object['object_title'] . '">
							</label>&nbsp;
							<label style="min-width: 49%;">Атрибут alt:
								<input class="form-control" name="alt" value="' . $object['object_alt'] . '">
							</label>
						</div>
						<div class="form-group"' . (($object['object_type'] != 'url') ? ' style="display:none;"' : '') . '>
							<label style="width: 99%;" class="has-success">URL:
								<input class="form-control urlClass" name="url" value="' . $object['object_url'] . '">
							</label>
						</div>
						<div class="form-group">
							<label style="width: 99%;">Описание: (<span style="font-size:10px;color:#e71616;">Внимание! Разрещено использовать HTML!</span>)
								<textarea class="form-control textareaMenu" name="description">' . $object['object_description'] . '</textarea>
							</label>
						</div>
						<div class="form-group">
							<label style="width: 99%;">Открывать в новом окне?&nbsp;
								<input type="checkbox" name="blank"' . (($object['object_blank'] == 1) ? ' checked="checked"' : '') . '>
							</label>
						</div>
						' . (($config["plugins"]->menus->menumediafields->active) ? '
						<div style="border: 1px dashed rgb(217, 83, 79)!important;padding: 8px;">
							<span style="font-weight: 700;">Медиа поля:</span>
							<div id="paramsmedia' . $object['object_oid'] . '">' . $dummy . '</div>
							<div data-max="8" data-id="' . $object['object_oid'] . '" data-fieldid="' . $object['object_oid'] . '" style="display:none;"></div>
							<input type="button" value="Добавить" class="btn btn-sm btn-success addParam" />
								&nbsp;|&nbsp;
							<input disabled="disabled" type="button" value="Удалить" class="btn btn-sm btn-danger removeParam" />
						</div>
						' : '') . '
						<input type="hidden" name="type" value="' . $object['object_type'] . '">
						<input type="hidden" name="tid" value="' . $object['object_tid'] . '">
						<input type="hidden" name="object_id" value="' . $object['object_oid'] . '">
					</form>
				</div>
			</div>
			' . (!empty($objects[$object['object_parent']]) ? '<ol>' . buildAdminMenu($objects, $object['object_oid']) . '</ol>' : '') . '
			</li>';
		}
	return $tree;
}

function activeMenu($link, $args=[]) {
	if (!empty($args) && in_array($link, $args)) return 'active';
	$uri = explode('?', $_SERVER["REQUEST_URI"])[0];
	$uri = (substr($uri, -1) == '/') ? substr($uri, 0, -1) : $uri;
	$link = substr($link, -1) == '/' ? substr($link, 0, -1) : $link;
	if ($link == $uri) return 'active';
	return false;
}

function addDelivery() {
	global $connect, $config;
	$args = array(); $_SESSION['answer'] = "";

	$args['title'] = clearObject($_POST['title']);
	$args['name'] = clearObject($_POST['name']);
	$args['description'] = clearObject($_POST['description']);

	if (!$args['title'] || !$args['name']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У способа доставки <b>минимум</b> должено быть название и вызов!</div>';
		saveArgs($args);
		redirect("?view=add_delivery");
	}

	if (!preg_match("/^[a-z_0-9-]+$/s", $args['name'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Название способа доставки может состоять только из маленьких латинских букв, цифр, знаков подчеркивания и дефиса!</div>';
		saveArgs($args);
		redirect("?view=add_delivery");
	}

	/** проверка вызова способа доставки на уникальность **/
	$query = "SELECT `delivery_id` FROM `{$config["prefix"]}delivery` WHERE `delivery_name` = '{$args['name']}'";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	$row = mysqli_fetch_all($request, MYSQLI_ASSOC);
	if (!empty($row[0]["delivery_id"])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У Названия способа доставки <b>должен быть уникальный</b> вызов! Введенный Вами вызов уже используется!</div>';
		saveArgs($args);
		redirect("?view=add_delivery");
	}
	/** проверка вызова способа доставки на уникальность **/

	$query = "INSERT INTO `{$config["prefix"]}delivery` (`delivery_title`, `delivery_name`, `delivery_description`, `delivery_datecreate`, `delivery_dateupdate`) 
					VALUES ('{$args['title']}', '{$args['name']}', '{$args['description']}', NOW(), NOW())";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Новый способ доставки успешно добавлен!</div>';
		$ID = mysqli_insert_id($connect);
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При добавлении нового способа доставки произошел сбой!</div>';
	} if (isset($ID) && !empty($ID) && $config["settings"]->redirect->value) redirect("?view=update_delivery&delivery_id=" . $ID); redirect("?view=delivery");
}

function updateDelivery($ID) {
	global $connect, $config;
	$args = array(); $_SESSION['answer'] = "";

	$args['title'] = clearObject($_POST['title']);
	$args['name'] = clearObject($_POST['name']);
	$args['description'] = clearObject($_POST['description']);

	if (!$args['title'] || !$args['name']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У способа доставки <b>минимум</b> должено быть название и вызов!</div>';
		saveArgs($args);
		redirect("?view=update_delivery&delivery_id=" . $ID);
	}

	if (!preg_match("/^[a-z_0-9-]+$/s", $args['name'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Название способа доставки может состоять только из маленьких латинских букв, цифр, знаков подчеркивания и дефиса!</div>';
		saveArgs($args);
		redirect("?view=update_delivery&delivery_id=" . $ID);
	}

	/** проверка вызова способа доставки на уникальность **/
	$query = "SELECT `delivery_id` FROM `{$config["prefix"]}delivery` WHERE `delivery_name` = '{$args['name']}' AND `delivery_id` != {$ID}";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	$row = mysqli_fetch_all($request, MYSQLI_ASSOC);
	if (!empty($row[0]["delivery_id"])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У Названия способа доставки <b>должен быть уникальный</b> вызов! Введенный Вами вызов уже используется!</div>';
		saveArgs($args);
		redirect("?view=update_delivery&delivery_id=" . $ID);
	}
	/** проверка вызова способа доставки на уникальность **/

	$query = "UPDATE `{$config["prefix"]}delivery` 
				SET 
					`delivery_title` = '{$args['title']}',
					`delivery_name` = '{$args['name']}',
					`delivery_description` = '{$args['description']}',
					`delivery_dateupdate` = NOW()
				WHERE `delivery_id` = {$ID}";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Способ доставки успешно обновлен!</div>';
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При обновлении способа доставки произошел сбой!</div>';
	} if (isset($ID) && !empty($ID) && $config["settings"]->redirect->value) redirect("?view=update_delivery&delivery_id=" . $ID); redirect("?view=delivery");
}

function addPost() {
 	global $connect, $config;
	$args = array(); $_SESSION['answer'] = "";
	
    $args['title'] = clearObject($_POST['title']);
    $args['name'] = clearObject($_POST['name']);
    $args['slug'] = clearObject($_POST['slug']);
    $args['keywords'] = clearObject($_POST['keywords']);
    $args['description'] = clearObject($_POST['description']);
    $args['quote'] = !empty($_POST['quote']) ? clearObject($_POST['quote'], true) : '';
    $args['text'] = clearObject($_POST['text'], true);
    //$args['parent'] = abs((int)$_POST['parent']);
	$args['visible'] = abs((int)$_POST['visible']);
	$args['special'] = abs((int)$_POST['special']);
	
	//postparams plugin
	$args['params'] = array();
	if (!empty($_POST['params']) && is_array($_POST['params']))
		foreach($_POST['params'] as $k => $v) {
			if (empty($v)) continue;
			$args['params'][clearObject($v)] = (isset($_POST['values'][$k])) ? clearObject($_POST['values'][$k], true): '';
		}
		
	//postmediafields plugin
	$args['paramsmedia'] = array();
	if (!empty($_POST['paramsmedia']) && is_array($_POST['paramsmedia']))
		foreach($_POST['paramsmedia'] as $k => $v) {
			if (empty($v)) continue;
			$args['paramsmedia'][clearObject($v)] = (isset($_POST['valuesmedia'][$k])) ? clearObject($_POST['valuesmedia'][$k]): '';
		}

	//terms module
	$args['terms'] = array();
	if (!empty($_POST['terms']) && is_array($_POST['terms']))
		foreach($_POST['terms'] as $term) {
			if (empty($term)) continue;
			$term = abs((int)$term);
			if ($term > 0) $args['terms'][] = $term;
		}
	
	if (!$args['title'] || !$args['slug']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У записи <b>минимум</b> должен быть заголовок и адрес!</div>';
		saveArgs($args);
		redirect("?view=add_post"); 
	}
	
	if (!preg_match("/^[a-z_0-9-]+$/s", $args['slug'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Адрес записи может состоять только из маленьких латинских букв, цифр, знаков подчеркивания и дефиса!</div>';
		saveArgs($args);
		redirect("?view=add_post"); 
	}
	
	/** проверка адреса записи на уникальность **/
	$query = "SELECT `post_id` FROM `{$config["prefix"]}posts` WHERE `post_slug` = '{$args['slug']}'";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	$row = mysqli_fetch_all($request, MYSQLI_ASSOC);
	if (!empty($row[0]["post_id"])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У записи <b>должен быть уникальный</b> адрес! Введенный Вами адрес уже используется!<br><strong>Напоминаем Вам что адрес генерируется автоматически от заголовка записи!</strong><br>Возможные решения:<ul><li>Попробуйте ввести адрес вручную соблюдая правила ввода.</li></ul>Если ошибка все же повторяется, то советуем Вам обратиться за помощью к системному администратору.</div>';
		saveArgs($args);
		redirect("?view=add_post");
	}
	/** проверка адреса записи на уникальность **/
	
	if (!empty($args['terms']) && is_array($args['terms'])) {
		$query = "SELECT * FROM {$config["prefix"]}terms";
		$request = mysqli_query($connect, $query);
		$cats = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC) : [];

		$ct = array();
		foreach($cats as $cat) {
			$ct[] = $cat['term_id'];
		}
		
		foreach($args['terms'] as $tc) {
			if (!in_array($tc, $ct)) {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Вы пытаетесь создать связь записи с несуществующей рубрикой!</div>';
				saveArgs($args);
				redirect("?view=add_post"); 
			}
		}
	}	

	$args['params']	= serialize($args['params']); //массив с произвольными полями вернется в случае чего, так что не спешим его преобразовывать в строку
	$args['paramsmedia'] = serialize($args['paramsmedia']);
    $authorId = !empty($_SESSION['auth']['user_id']) ? abs((int)$_SESSION['auth']['user_id']) : 0;
	$query = "INSERT INTO `{$config["prefix"]}posts` (`post_title`, `post_name`, `post_special`, `post_quote`, `post_keywords`, `post_author`, `post_description`, `post_text`, `post_params`, `post_datecreate`, `post_dateupdate`, `post_slug`, `post_visible`, `post_mediafields`) 
					VALUES ('{$args['title']}', '{$args['name']}', '{$args['special']}', '{$args['quote']}', '{$args['keywords']}', {$authorId}, '{$args['description']}', '{$args['text']}', '{$args['params']}', NOW(), NOW(), '{$args['slug']}', {$args['visible']}, '{$args['paramsmedia']}')";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Запись успешно опубликована!</div>';
		
		$ID = mysqli_insert_id($connect);	
		
		if (!empty($_FILES['postpicture']['name']) && $config["plugins"]->posts->postpicture->active) {
			$path = "/files/posts/postpicture/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			$response = uploadImage($_FILES['postpicture'], $ID, $path, 0, [$config["settings"]->posts_postpicture_imgsize->value[0], $config["settings"]->posts_postpicture_imgsize->value[1]]);
			
			if ($response) {
				$response = clearObject($response);				
				mysqli_query($connect, "UPDATE `{$config["prefix"]}posts` SET `postpicture` = '{$response}', `postpicture_path` = '{$path}' WHERE `post_id` = {$ID}") or 
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Миниатюра успешно загружена!</div>';
			} else {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать миниатюру для записи!</div>';
			}
		}
		
		if (!empty($_FILES['postgallery']['name'][0]) && $config["plugins"]->posts->postgallery->active) {
			$response = []; $response['postgallery'] = ''; $image = [];
			$path = "/files/posts/postgallery/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			for($i = 0; $i < count($_FILES['postgallery']['name']); $i++) {
				//create img from gallery
				$image['name'] = !empty($_FILES['postgallery']['name'][$i]) ? $_FILES['postgallery']['name'][$i] : '';
				$image['type'] = !empty($_FILES['postgallery']['type'][$i]) ? $_FILES['postgallery']['type'][$i] : '';
				$image['tmp_name'] = !empty($_FILES['postgallery']['tmp_name'][$i]) ? $_FILES['postgallery']['tmp_name'][$i] : '';
				$image['error'] = isset($_FILES['postgallery']['error'][$i]) ? $_FILES['postgallery']['error'][$i] : '';
				$image['size'] = !empty($_FILES['postgallery']['size'][$i]) ? $_FILES['postgallery']['size'][$i] : '';
				
				if (empty($image['name'])) continue;
				$response[$i] = uploadImage($image, $ID, $path, $i, [$config["settings"]->posts_postgallery_imgsize->value[0], $config["settings"]->posts_postgallery_imgsize->value[1]]);
				
				if ($response[$i]) {
					$response['postgallery'] .= clearObject($response[$i]) . "|";
					$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Картинка галереи <b>' . $_FILES['postgallery']['name'][$i] . '</b> успешно загружена!</div>';
				} else {
					$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать картинку галереи <b>' . $_FILES['postgallery']['name'][$i] . '</b> для записи!</div>';
				}
			}
			
			if (!empty($response['postgallery'])) {
				$response['postgallery'] = substr($response['postgallery'], 0, -1);
				mysqli_query($connect, "UPDATE `{$config["prefix"]}posts` SET `postgallery` = '{$response['postgallery']}', `postgallery_path` = '{$path}' WHERE `post_id` = {$ID}") or 
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
			}
		}
		
		if (!empty($args['terms']) && is_array($args['terms'])) {
			$query = "INSERT IGNORE INTO `{$config["prefix"]}posts_relationships` (`term_id`, `post_id`) VALUES ";
			$values = '';
			foreach($args['terms'] as $term) {
				$values .= "({$term}, {$ID}),";
			}
			
			$values = substr($values, 0, -1);
			$query .= $values;

			$request = mysqli_query($connect, $query) or 
				die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
			
			if (mysqli_affected_rows($connect) > 0) {
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Связи с записями успешно созданы!</div>';
			} else {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При создании связей с рубриками произошла ошибка!<br>Если запись не появился в Выбранной Вами рубрике то обратитесь за помощью к администратору!</div>';
			}
		}
		
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При публикации записи произошел сбой!</div>';
	} if (isset($ID) && !empty($ID) && $config["settings"]->redirect->value) redirect("?view=update_post&post_id=" . $ID); redirect("?view=posts");
}

function updatePost($post_id) {
 	global $connect, $config;
	$args = array(); $_SESSION['answer'] = "";
	
    $args['title'] = clearObject($_POST['title']);
	$args['name'] = clearObject($_POST['name']);
    $args['slug'] = clearObject($_POST['slug']);
    $args['keywords'] = clearObject($_POST['keywords']);
    $args['description'] = clearObject($_POST['description']);
    $args['quote'] = !empty($_POST['quote']) ? clearObject($_POST['quote'], true) : '';
    $args['text'] = clearObject($_POST['text'], true);
    //$args['parent'] = abs((int)$_POST['parent']);
	$args['visible'] = abs((int)$_POST['visible']);
	$args['special'] = abs((int)$_POST['special']);
	
	//postparams plugin
	$args['params'] = array();
	if (!empty($_POST['params']) && is_array($_POST['params']))
		foreach($_POST['params'] as $k => $v) {
			if (empty($v)) continue;
			$args['params'][clearObject($v)] = (isset($_POST['values'][$k])) ? clearObject($_POST['values'][$k], true): '';
		}
		
	//postmediafields plugin
	$args['paramsmedia'] = array();
	if (!empty($_POST['paramsmedia']) && is_array($_POST['paramsmedia']))
		foreach($_POST['paramsmedia'] as $k => $v) {
			if (empty($v)) continue;
			$args['paramsmedia'][clearObject($v)] = (isset($_POST['valuesmedia'][$k])) ? clearObject($_POST['valuesmedia'][$k]): '';
		}

	//terms module
	$args['terms'] = array();
	if (!empty($_POST['terms']) && is_array($_POST['terms']))
		foreach($_POST['terms'] as $term) {
			if (empty($term)) continue;
			$term = abs((int)$term);
			if ($term > 0) $args['terms'][] = $term;
		}
	
	if (!$args['title'] || !$args['slug']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У записи <b>минимум</b> должен быть заголовок и адрес!</div>';
		saveArgs($args);
		redirect("?view=update_post&post_id={$post_id}"); 
	}
	
	if (!preg_match("/^[a-z_0-9-]+$/s", $args['slug'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Адрес записи может состоять только из маленьких латинских букв, цифр, знаков подчеркивания и дефиса!</div>';
		saveArgs($args);
		redirect("?view=update_post&post_id={$post_id}"); 
	}

	/** проверка адреса записи на уникальность **/
	$query = "SELECT `post_id` FROM `{$config["prefix"]}posts` WHERE `post_slug` = '{$args['slug']}' AND `post_id` != {$post_id}";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	$row = mysqli_fetch_all($request, MYSQLI_ASSOC);
	if (!empty($row[0]["post_id"])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У записи <b>должен быть уникальный</b> адрес! Введенный Вами адрес уже используется!<br><strong>Напоминаем Вам что адрес генерируется автоматически от заголовка записи!</strong><br>Возможные решения:<ul><li>Попробуйте ввести адрес вручную соблюдая правила ввода.</li></ul>Если ошибка все же повторяется, то советуем Вам обратиться за помощью к системному администратору.</div>';
		saveArgs($args);
		redirect("?view=update_post&post_id={$post_id}");
	}
	/** проверка адреса записи на уникальность **/
	
	if (!empty($args['terms']) && is_array($args['terms'])) {
		$query = "SELECT * FROM {$config["prefix"]}terms";
		$request = mysqli_query($connect, $query);
		$cats = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC) : [];

		$ct = array();
		foreach($cats as $cat) {
			$ct[] = $cat['term_id'];
		}
		
		foreach($args['terms'] as $tc) {
			if (!in_array($tc, $ct)) {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Вы пытаетесь создать связь записи с несуществующей рубрикой!</div>';
				saveArgs($args);
				redirect("?view=update_post&post_id={$post_id}"); 
			}
		}
	}	

	$args['params']	= serialize($args['params']); //массив с произвольными полями вернется в случае чего, так что не спешим его преобразовывать в строку
	$args['paramsmedia'] = serialize($args['paramsmedia']);
    $authorId = !empty($_SESSION['auth']['user_id']) ? abs((int)$_SESSION['auth']['user_id']) : 0;
	
	$query = "UPDATE `{$config["prefix"]}posts` 
				SET 
					`post_title` = '{$args['title']}',
					`post_name` = '{$args['name']}',
					`post_special` = '{$args['special']}',
					`post_quote` = '{$args['quote']}',
					`post_keywords` = '{$args['keywords']}',
					`post_author` = '{$authorId}',
					`post_description` = '{$args['description']}',
					`post_text` = '{$args['text']}',
					`post_params` = '{$args['params']}',
					`post_dateupdate` = NOW(),
					`post_slug` = '{$args['slug']}',
					`post_visible` = {$args['visible']},
					`post_mediafields` = '{$args['paramsmedia']}'
				WHERE `post_id` = {$post_id}";
	
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Запись успешно обновлена!</div>';
		
		$ID = $post_id;	
		
		if (!empty($_FILES['postpicture']['name']) && $config["plugins"]->posts->postpicture->active) {
			$path = "/files/posts/postpicture/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			$response = uploadImage($_FILES['postpicture'], $ID, $path, 0, [$config["settings"]->posts_postpicture_imgsize->value[0], $config["settings"]->posts_postpicture_imgsize->value[1]]);
			
			if ($response) {
				$response = clearObject($response);				
				mysqli_query($connect, "UPDATE `{$config["prefix"]}posts` SET `postpicture` = '{$response}', `postpicture_path` = '{$path}' WHERE `post_id` = {$ID}") or 
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Миниатюра успешно загружена!</div>';
			} else {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать миниатюру для записи!</div>';
			}
		}

		$request = mysqli_query($connect, "DELETE FROM `{$config["prefix"]}posts_relationships` WHERE `post_id` = {$ID}") or
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

		if (!empty($args['terms']) && is_array($args['terms'])) {
			$query = "INSERT IGNORE INTO `{$config["prefix"]}posts_relationships` (`term_id`, `post_id`) VALUES ";
			$values = '';
			foreach($args['terms'] as $term) {
				$values .= "({$term}, {$ID}),";
			}
			
			$values = substr($values, 0, -1);
			$query .= $values;

			$request = mysqli_query($connect, $query) or 
				die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

			if (mysqli_affected_rows($connect) > 0) {
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Связи с записями успешно созданы!</div>';
			} else {
				//$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При создании связей с рубриками произошла ошибка!<br>Если запись не появился в Выбранной Вами рубрике то обратитесь за помощью к администратору!</div>';
			}
		}
		
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При публикации записи произошел сбой!</div>';
	} if (isset($post_id) && !empty($post_id) && $config["settings"]->redirect->value) redirect("?view=update_post&post_id=" . $post_id); redirect("?view=posts");
}

function changeObjectsVision($posts, $param, $prefix) {
	global $connect, $config; $_SESSION['answer'] = ""; $values = ""; $param = abs((int)$param);

	foreach($posts as $post) {$values .= abs((int)$post) . ", ";} if (!empty($values)) $values = substr($values, 0, -2);
	$query = "UPDATE `{$config["prefix"]}{$prefix}s` SET `{$prefix}_visible` = {$param} WHERE `{$prefix}_id` IN ({$values})";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		if ($param) {
			$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Объекты успешно опубликованны!</div>';
		} else {
			$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Объекты успешно скрыты!</div>';
		}
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При выполеннии действий произошел сбой!</div>';
	}
}

function removeObjectsWithRelationships($posts, $prefix) {
	global $connect, $config; $_SESSION['answer'] = ""; $values = "";
	foreach($posts as $post) {$values .= abs((int)$post) . ", ";} if (!empty($values)) $values = substr($values, 0, -2);
	$query = "SELECT * FROM `{$config["prefix"]}{$prefix}s` WHERE `{$prefix}_id` IN ({$values})";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	$objects = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC) : [];

	$query = "DELETE FROM `{$config["prefix"]}{$prefix}s` WHERE `{$prefix}_id` IN ({$values})";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Объекты успешно удалены!</div>';

		// Удаляем все связи с объектами
		$query = "DELETE FROM `{$config["prefix"]}{$prefix}s_relationships` WHERE `{$prefix}_id` IN ({$values})";
		$request = mysqli_query($connect, $query) or
			die("You have an error in function " . __FUNCTION__ . " on line " . __LINE__ . ".<br> " . mysqli_errno($connect) . ": " . mysqli_error($connect));

		if (mysqli_affected_rows($connect) > 0) {
			$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Связи с объектами успешно удалены!</div>';
		}

		if (!empty($objects) && is_array($objects)) {
			foreach($objects as $item) {
				if (!empty($item['postpicture_path']) && !empty($item['postpicture_path'])) {
					@removeDirectory(DR . $item['postpicture_path']);
				}
				if (!empty($item['postgallery_path']) && !empty($item['postgallery'])) {
					@removeDirectory(DR . $item['postgallery_path']);
				}
			}
			$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Дополнительные файлы успешно удалены!</div>';
		}
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При удалении обьектов произошел сбой!</div>';
	} redirect("?view={$prefix}s");
}

function removeFeedback($id) {
	global $connect, $config; $_SESSION['answer'] = "";

	$query = "DELETE FROM `{$config["prefix"]}callback` WHERE `call_id` = {$id}";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Заявка успешно удалена!</div>';
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При удалении заявки произошел сбой!</div>';
	}
}

function mb_ucfirst($txt) {
	return mb_strtoupper(mb_substr($txt, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($txt, 1, mb_strlen($txt), 'UTF-8');
}

function removeObjectById($object_id, $prefix, $message) {
	global $connect, $config; $_SESSION['answer'] = "";
	if ($prefix == 'delivery' || $prefix == 'callback') $s = ''; else $s = 's';
	$query = "SELECT * FROM `{$config["prefix"]}{$prefix}{$s}` WHERE `{$prefix}_id` = {$object_id}";
    $request = mysqli_query($connect, $query) or
        die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	$object = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : [];
	
	if (empty($object) || !is_array($object)) {
		if ($prefix == 'product') {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Вы пытаетесь удалить несуществующий товар!</div>';
		} elseif($prefix == 'slider') {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Вы пытаетесь удалить несуществующий слайдер!</div>';
		}  elseif($prefix == 'order') {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Вы пытаетесь удалить несуществующий заказ!</div>';
		} elseif($prefix == 'callback') {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Вы пытаетесь удалить несуществующую заявку!</div>';
		}else {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Вы пытаетесь удалить несуществующую ' . $message[0] . '!</div>';
		}
		redirect("?view={$prefix}s");
	}
	
	$items[] = !empty($object[$prefix . 'picture_path']) ? $object[$prefix . 'picture_path'] : '';
	$items[] = !empty($object[$prefix . 'gallery_path']) ? $object[$prefix . 'gallery_path'] : '';
	$items[] = !empty($object[$prefix . '_path']) ? $object[$prefix . '_path'] : '';

	$query = "DELETE FROM `{$config["prefix"]}{$prefix}{$s}` WHERE `{$prefix}_id` = {$object_id}";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		if ($prefix == 'product') {
			$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Товар успешно удален!</div>';
		} elseif($prefix == 'slider') {
			$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Слайдер успешно удален!</div>';
		} elseif ($prefix == 'order') {
			$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Заказ успешно удален!</div>';
		} elseif ($prefix == 'callback') {
			$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Заявка успешно удалена!</div>';
		} else {
			$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> ' . mb_ucfirst($message[0]) . ' успешно удалена!</div>';
		}

		if($prefix != 'slider' && $prefix != 'delivery' && $prefix != 'order' && $prefix != 'callback') {
			// Удаляем все связи с объектами
			$query = "DELETE FROM `{$config["prefix"]}{$prefix}s_relationships` WHERE `{$prefix}_id` = {$object_id}";
			$request = mysqli_query($connect, $query) or
				die("You have an error in function " . __FUNCTION__ . " on line " . __LINE__ . ".<br> " . mysqli_errno($connect) . ": " . mysqli_error($connect));
			if (mysqli_affected_rows($connect) > 0) {
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Связи ' . $message[1] . ' успешно удалены!</div>';
			}
		}

		if (!empty($items) && is_array($items)) {
			foreach($items as $item) {
				if (empty($item)) continue;
				if (!empty($item) && file_exists(DR . $item)) {
					@removeDirectory(DR . $item);
				}
			}
			$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Дополнительные файлы успешно удалены!</div>';
		}
		
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При удалении ' . $message[1] . ' произошел сбой!</div>';
	} redirect("?view={$prefix}{$s}");
}

function proofOrder($orderId) {
	global $connect, $config; $_SESSION['answer'] = "";

	$query = "UPDATE `{$config["prefix"]}orders` SET `order_proof` = 1 WHERE `order_id` = {$orderId}";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Заказ упешно подтвержден!</div>';
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Не удалось подтвердить заказ! Возможно такого заказа несуществет или он уже был подтвержден ранее!</div>';
	}
}

function proofFeedback($orderId) {
	global $connect, $config; $_SESSION['answer'] = "";

	$query = "UPDATE `{$config["prefix"]}callback` SET `call_proof` = 1 WHERE `call_id` = {$orderId}";
	$request = mysqli_query($connect, $query) or
	die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Заявка упешно подтверждена!</div>';
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Не удалось подтвердить заявку! Возможно такой заявки несуществет или она уже был подтверждена ранее!</div>';
	}
}

function getMenus($args) {
	global $connect, $config;
	
	$query = "SELECT * FROM `{$config["prefix"]}{$args['table']}`{$config['where']}";
	$request = mysqli_query($connect, $query) or
        die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	return (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC) : [];
}

function getCurrentLink($args=[], $string=true) {
	$current = explode("?", $_SERVER["REQUEST_URI"]);
	if ($args[0] == 'all') return $current[0];
	if (!empty($_GET) && is_array($_GET)) {
		$dummy = '?';
		foreach($_GET as $itemId => $item) {
			if (in_array($itemId, $args)) continue;
			$dummy .= $itemId . '=' . $item . '&';
		}
		$dummy = substr($dummy, 0, -1);
		$current[0] .= !empty($dummy) ? $dummy . '&' : (($string)?'?':'');
	}
	return $current[0];
}

function addtocart($product_id, $qty = 1) {
	if (isset($_SESSION['shopbag'][$product_id])) {
		// если в массиве shopbag уже есть добавляемый товар
		$_SESSION['shopbag'][$product_id]['qty'] += $qty;
		return $_SESSION['shopbag'];
	} else {
		// если товар кладется в корзину впервые
		$_SESSION['shopbag'][$product_id]['qty'] = $qty;
		return $_SESSION['shopbag'];
	}
}

function total_sum($products) {
	global $connect, $config; $total_sum = 0;
	$productsId = implode(',', array_keys($products));
	$_SESSION['total_sum_withDiscount'] = $total_sum;
	$_SESSION['total_sum_discount'] = $total_sum;
	//$_SESSION['shopbag'] = [];

	$query = "SELECT * FROM `{$config["prefix"]}products` WHERE `product_id` IN ({$productsId})";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	while ($row = mysqli_fetch_assoc($request)) {
		$_SESSION['shopbag'][$row['product_id']]['product_title'] = $row['product_title'];
		$_SESSION['shopbag'][$row['product_id']]['product_article'] = $row['product_article'];
		$_SESSION['shopbag'][$row['product_id']]['product_price'] = $row['product_price'];
		$_SESSION['shopbag'][$row['product_id']]['product_discount'] = $row['product_discount'];
		$_SESSION['shopbag'][$row['product_id']]['product_priceWithDiscount'] = ($row['product_discount']>0)?($row['product_price']-(($row['product_price']*$row['product_discount'])/100)):$row['product_price'];
		$_SESSION['shopbag'][$row['product_id']]['product_discountPrice'] = ($row['product_discount']>0)?(($row['product_price']*$row['product_discount'])/100):0;
		//$_SESSION['shopbag'][$row['product_id']]['productpicture'] = (!empty($row['productpicture']) && !empty($row['productpicture_path'])) ? $row['productpicture_path'] . $row['productpicture'] : '';
		$_SESSION['shopbag'][$row['product_id']]['product_slug'] = $row['product_slug'];
		$_SESSION['shopbag'][$row['product_id']]['productpicture'] = $row['productpicture'];
		$_SESSION['shopbag'][$row['product_id']]['productpicture_path'] = $row['productpicture_path'];


		$_SESSION['total_sum_withDiscount'] += $_SESSION['shopbag'][$row['product_id']]['qty'] * $_SESSION['shopbag'][$row['product_id']]['product_priceWithDiscount'];
		$_SESSION['total_sum_discount'] += $_SESSION['shopbag'][$row['product_id']]['qty'] * $_SESSION['shopbag'][$row['product_id']]['product_discountPrice'];

		$total_sum += $_SESSION['shopbag'][$row['product_id']]['qty'] * $row['product_price'];
	}
	return $total_sum;
}

function total_quantity() {
	$_SESSION['total_quantity'] = 0;
	foreach ($_SESSION['shopbag'] as $key => $value) {
		if (isset($value['product_price'])) {
			// если получена цена товара из БД - суммируем кол-во
			$_SESSION['total_quantity'] += $value['qty'];
		} else {
			// иначе - удаляем такой ID из сессиии (корзины)
			unset($_SESSION['shopbag'][$key]);
		}
	}
}
function shopbagClear() {
	if (!empty($_SESSION['shopbag'])) unset($_SESSION['shopbag']);
	if (!empty($_SESSION['total_sum'])) unset($_SESSION['total_sum']);
	if (!empty($_SESSION['total_quantity'])) unset($_SESSION['total_quantity']);
	if (!empty($_SESSION['total_sum_withDiscount'])) unset($_SESSION['total_sum_withDiscount']);
	if (!empty($_SESSION['total_sum_discount'])) unset($_SESSION['total_sum_discount']);
	$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Корзина успешно очищена!</div>';
	redirect('/shopbag/');
}

function shopbagRemove() {
	$product_id = !empty($_GET['product_id']) ? abs((int)$_GET['product_id']) : 0;
	if (!empty($_SESSION['shopbag'][$product_id])) {
		unset($_SESSION['shopbag'][$product_id]);
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Товар успешно удален!</div>';
	}
	if (empty($_SESSION['shopbag'])) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Корзина пуста!</strong> Вы отчистили корзину!</div>';
	}
	redirect('/shopbag/');
}

function shopbagCounted() {
	if (!empty($_POST['product']) && is_array($_POST['product'])) {
	    //print_array($_POST,false);print_array($_SESSION);
		foreach($_POST['product'] as $itemId => $item) {
			if (!empty($_SESSION['shopbag'][$itemId])) {
				unset($_SESSION['shopbag'][$itemId]);
				$_SESSION['shopbag'][$itemId]['qty'] = abs((int)$item);
			}
		}
		$_SESSION['total_sum'] = total_sum($_SESSION['shopbag']); // сумма заказа
		total_quantity(); // кол-во товара в корзине + защита от ввода несуществующего ID товара
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Корзина успешно пересчитана!</div>';
	} redirect('/shopbag/');
}

function shopbag() {
	if(isset($_GET['json'])) {
		$product_id = !empty($_GET['product_id']) ? abs((int)$_GET['product_id']) : 0;
		$qty = !empty($_GET['qty']) ? abs((int)$_GET['qty']) : 1;
		header('Content-Type: application/json');

		if (!$product_id || !$qty) {
			die(json_encode(['response'=>'error', 'result'=>'Неверные параметры, пожалуйста обновите страницу или повторите Вашу попытку позже!']));
		}

		addtocart($product_id, $qty);

		$_SESSION['total_sum'] = total_sum($_SESSION['shopbag']); // сумма заказа
		total_quantity(); // кол-во товара в корзине + защита от ввода несуществующего ID товара

		if (!empty($_SESSION['total_quantity'])) {
			die(json_encode(['response'=>'success', 'result'=>'full', 'shopbag'=>['qty'=>count($_SESSION['shopbag']),'total_sum'=>$_SESSION['total_sum'],'total_quantity'=>$_SESSION['total_quantity'], 'total_sum_withDiscount'=>$_SESSION['total_sum_withDiscount'], 'total_sum_discount'=>$_SESSION['total_sum_discount']]]));
		} else {
			die(json_encode(['response'=>'success', 'result'=>'empty', 'shopbag'=>'empty']));
		}
	} else {
		$product_id = !empty($_GET['product_id']) ? abs((int)$_GET['product_id']) : 0;
		$qty = !empty($_GET['qty']) ? abs((int)$_GET['qty']) : 1;
		if (!$product_id || !$qty) {
			if (!empty($_SERVER['HTTP_REFERER'])) {redirect($_SERVER['HTTP_REFERER']);} else {redirect();}
		}

		addtocart($product_id, $qty);

		$_SESSION['total_sum'] = total_sum($_SESSION['shopbag']); // сумма заказа
		total_quantity(); // кол-во товара в корзине + защита от ввода несуществующего ID товара
		if (!empty($_SERVER['HTTP_REFERER'])) {redirect($_SERVER['HTTP_REFERER']);} else {redirect();}
	}
}

function shopbagOrder() {
	global $connect, $sm_mail, $config;
	$name = !empty($_POST['name']) ? clearObject($_POST['name']) : '';
	$address = !empty($_POST['address']) ? clearObject($_POST['address']) : '';
	$phone = !empty($_POST['phone']) ? clearObject($_POST['phone']) : '';
	$email = !empty($_POST['email']) ? clearObject($_POST['email']) : '';
	$message = !empty($_POST['message']) ? clearObject($_POST['message']) : '';
	$userId = !empty($_SESSION['auth']['user_id']) ? $_SESSION['auth']['user_id'] : 0;
	$sum = !empty($_SESSION['total_sum_withDiscount']) ? abs((int)$_SESSION['total_sum_withDiscount']) : 0;
	$products = '';
	if (!empty($_SESSION['shopbag']) && is_array($_SESSION['shopbag'])) {
		foreach($_SESSION['shopbag'] as $itemId => $item) {
			$products .= abs((int)$itemId) . '|' . abs((int)$item['qty']) . ',';
		} $products = substr($products, 0, -1);
	}

	if (empty($name)|| empty($address) || empty($phone) || empty($email)) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Пожалуйста заполните все обязательные поля поля!</div>';
	}

	$query = "INSERT INTO `{$config["prefix"]}orders` (`order_sum`, `user_id`, `order_name`, `order_address`, `order_phone`, `order_email`, `order_message`, `order_date`, `order_products`) 
					VALUES
			  ({$sum}, {$userId}, '{$name}', '{$address}', '{$phone}', '{$email}', '{$message}', NOW(), '{$products}')";
	$request = mysqli_query($connect, $query) or
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$id = mysqli_insert_id($connect);
		$sm_mail['link'] = 'http://' . $_SERVER['HTTP_HOST'] . '/sm-admin/?view=view_order&order_id=' . $id;
		$sm_mail['from'] = null;
		$sm_mail['to_name'] = explode('@', $config["settings"]->email->value)[0];
		$sm_mail['to_email'] = $config["settings"]->email->value;
		$sm_mail['subject'] = 'Новый заказ на сайте!';
		$sm_mail['body'] = '
							На Ваш сайт поступил новый заказ: 
							<table>
   								<tbody>
   									<tr>
   										<td><strong>Телефон:</strong> ' . $phone . '</td>
   										<td><strong>Ф.И.О:</strong> ' . $name . '</td>
   										<td><strong>Почта:</strong> ' . $email . '</td>
   									</tr>
   									' . (!empty($message) ? '<tr><td>' . $message . '</td></tr>' : '') . '
   								</tbody>
   							</table>
		';
		sm_mail($sm_mail);
		//sendEmail('Новый заказ на сайте!','На Ваш сайт поступил новый заказ. Имя: ' . $name .', Телефон: ' . $phone, false, false, true);
		//die(json_encode(['response'=>'success', 'result'=>'Спасибо за проявленный интерес! В скором времени с Вами свяжется наш менеджер!']));
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Ваш заказ успешно оформлен! В ближайшее время с вами свяжется наш менеджер!</div>';
		shopbagClear();
	} else {
		//die(json_encode(['response'=>'error', 'result'=>'Оупс! Не удалось подать заявку ;(<br>Пожалуйста позвоните по номеру: '.$config["settings"]->phone->value]));
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Оупс! Не удалось обработать заказ ;( Пожалуйста позвоните по номеру: ' . $config["settings"]->phone->value . '</div>';
	} redirect('/shopbag/');
}

function callback($json=true) { //print_array($_POST);
	global $connect, $sm_mail, $config;
	if ($json) header('Content-Type: application/json');
	$n1 = !empty($_POST['n1']) ? clearObject($_POST['n1']) : '';
	$n2 = !empty($_POST['n2']) ? clearObject($_POST['n2']) : '';
	$n3 = !empty($_POST['n3']) ? clearObject($_POST['n3']) : '';
	$phone = !empty($_POST['phone']) ? clearObject($_POST['phone']) : '';
	$email = !empty($_POST['email']) ? clearObject($_POST['email']) : '';
	$message = !empty($_POST['message']) ? clearObject($_POST['message']) : '';
	// $name = $n1 . ' ' . $n2 . ' ' . $n3; $name = trim($name);
	$name = !empty($_POST['name']) ? clearObject($_POST['name']) : '';
	
	if (empty($name) || empty($phone)) {
		if ($json) die(json_encode(['response'=>'error', 'result'=>'Пожалуйста заполните все поля!']));
		else {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Заполните все обязательные поля!</div>';
			redirect();
		}
	}

	$query = "INSERT INTO `{$config["prefix"]}callback` (`call_name`, `call_phone`, `call_email`, `call_message`, `call_date`) VALUES ('{$name}', '{$phone}', '{$email}', '{$message}', NOW())";
	$request = mysqli_query($connect, $query) or
		die(json_encode(['response'=>'error', 'result'=>'Оупс! На строке ' . __LINE__ . ' что то пошло не так ;(']));

	if (mysqli_affected_rows($connect) > 0) {
		$id = mysqli_insert_id($connect);
		$sm_mail['link'] = 'http://' . $_SERVER['HTTP_HOST'] . '/sm-admin/?view=feedback&id=' . $id;
		$sm_mail['from'] = null;
		$sm_mail['to_name'] = explode('@', $config["settings"]->email->value)[0];
		$sm_mail['to_email'] = $config["settings"]->email->value;
		$sm_mail['subject'] = 'Новая заявка на сайте!';
		$sm_mail['body'] = '
							На Ваш сайт поступило новое обращение: 
							<table>
   								<tbody>
   									<tr>
										' . (!empty($phone) ? '<td><strong>Телефон:</strong> ' . $phone . '</td>' : '') . '
										' . (!empty($name) ? '<td><strong>Ф.И.О:</strong> ' . $name . '</td>' : '') . '
										' . (!empty($email) ? '<td><strong>Почта:</strong> ' . $email . '</td>' : '') . '
   									</tr>
   									' . (!empty($message) ? '<tr><td>' . $message . '</td></tr>' : '') . '
   								</tbody>
   							</table>
		';
		sm_mail($sm_mail);
		//sendEmail('Новая заявка на сайте!','На Ваш сайт поступило новое обращение, Ф.И.О: ' . $name .', Текст обращения: ' . $message, false, false, true);
		if ($json) {
			die(json_encode(['response'=>'success', 'result'=>'Спасибо за проявленный интерес! В скором времени с Вами свяжется наш менеджер!']));
		} else {
			$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Спасибо за Ваше обращение!</strong> В скором времени Вы получите на него ответ!</div>';
			redirect('/page/kontakty/');
		}
	} else {
		if ($json) {
			die(json_encode(['response'=>'error', 'result'=>'Оупс! Не удалось подать заявку ;(<br>Пожалуйста позвоните по номеру: '.$config["settings"]->phone->value]));
		} else {
			$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Не удалось отправить обращение!</div>';
			redirect('/page/kontakty/');
		}
	}
}

function addMenu() {
 	global $connect, $config;

	header('Content-Type: application/json');

	if (!empty($_GET["menu_id"])) {
		if (!removeMenu(abs((int)$_GET["menu_id"]), false)) {
			die(json_encode(['response'=>'error', 'result'=>'<div class="alert alert-danger"><strong>Системная ошибка!</strong> При удалении <b>старого</b> меню произошел сбой!</div>']));
		}
	}

	$title = !empty($_POST['title']) ? clearObject($_POST['title']) : '';
	$callname = !empty($_POST['name']) ? clearObject($_POST['name']) : '';
	$objects = !empty($_POST['objects']) ? $_POST['objects'] : '';
	
	if (empty($title) || empty($callname)) {
		die(json_encode(['response'=>'error', 'result'=>'<div class="alert alert-danger"><strong>Ошибка!</strong> Пожалуйста заполните обязательные поля <b>Название</b> и <b>callname</b>!</div>']));
	}
	
	if (!preg_match("/^[a-z_-]+$/s", $callname)) {
		die(json_encode(['response'=>'error', 'result'=>'<div class="alert alert-danger"><strong>Ошибка!</strong> Свойство <b>callname</b> может состоять только из маленьких латинских букв, знака подчеркивания и дефиса!</div>'])); 
	}
	
	if (empty($objects) || !is_array($objects)) {
		die(json_encode(['response'=>'error', 'result'=>'<div class="alert alert-danger"><strong>Ошибка!</strong> Пожалуйста добавьте хотя бы один пункт в меню!</div>']));
	}
	
	/** проверка callname на уникальность **/
	$query = "SELECT `menu_id` FROM `{$config["prefix"]}menus` WHERE `menu_name` = '{$callname}'";
	$request = mysqli_query($connect, $query) or 
		die(json_encode(['response'=>'error', 'result'=>'<div class="alert alert-danger"><strong>Оупс!</strong> На строке ' . __LINE__ . ' что то пошло не так ;(</div>']));
		//die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	$row = mysqli_fetch_all($request, MYSQLI_ASSOC);
	if (!empty($row[0]["menu_id"])) {
		die(json_encode(['response'=>'error', 'result'=>'<div class="alert alert-danger"><strong>Ошибка!</strong> Выбранный Вами <b>callname</b> уже используется пожалуйста придумайте другой!</div>']));
	}
	/** проверка callname на уникальность **/
	
	$query = "INSERT INTO `{$config["prefix"]}menus` (`menu_title`, `menu_name`, `menu_datecreate`, `menu_dateupdate`) 
					VALUES ('{$title}', '{$callname}', NOW(), NOW())";
	$request = mysqli_query($connect, $query) or 
		die(json_encode(['response'=>'error', 'result'=>'<div class="alert alert-danger"><strong>Оупс!</strong> На строке ' . __LINE__ . ' что то пошло не так ;(</div>']));
		//die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] = '<div class="alert alert-success"><strong>Действие выполнено!</strong> Меню успешно создано!</div>';
		$mid = mysqli_insert_id($connect);
		$message = '';
		$query = "INSERT INTO `{$config["prefix"]}menus_objects` (`object_mid`, `object_position`, `object_oid`, `object_parent`, `object_type`, `object_tid`, `object_title`, `object_url`, `object_alt`, `object_blank`, `object_description`, `object_mediafields`)  VALUES"; 
		
		foreach($objects as $ID => $object) {
			$object['id'] = !empty($object['id']) ? abs((int)$object['id']) : 0;
			$object['parent_id'] = !empty($object['parent_id']) ? abs((int)$object['parent_id']) : 0;
			$object['text'] = !empty($object['text']) ? clearObject($object['text']) : '';
			$object['alt'] = !empty($object['alt']) ? clearObject($object['alt']) : '';
			$object['url'] = !empty($object['url']) ? clearObject($object['url']) : '';
			$object['blank'] = !empty($object['blank']) ? abs((int)$object['blank']) : 0;
			$object['type'] = !empty($object['type']) ? clearObject($object['type']) : '';
			$object['tid'] = !empty($object['tid']) ? abs((int)$object['tid']) : 0;
			$object['description'] = !empty($object['description']) ? clearObject($object['description'], true) : '';	
			$params = [];
			
			if (!empty($object['params']) && is_array($object['params'])) {
				//$params = serialize($object['params']);
				foreach($object['params'] as $k => $v) {
					if (empty($k) || empty($v)) continue;
					$params[clearObject($k)] = clearObject($v);
					//$message .= "[{$k} => {$v}], ";
				}
			}
			//s:75:"a:3:{s:4:"dgdf";s:5:"vcbnc";s:4:"asdf";s:4:"zxcv";s:4:"sdfg";s:6:"ewrqwe";}";
			//s:75:"a:3:{s:4:"dgdf";s:5:"vcbnc";s:4:"asdf";s:4:"zxcv";s:4:"sdfg";s:6:"ewrqwe";}";
			$params = !empty($params) ? serialize($params) : serialize([]);
			//die(json_encode(['response'=>'error', 'result'=>$params]));
			$query .= " ('{$mid}', " . ($ID + 1) . ", {$object['id']}, {$object['parent_id']}, '{$object['type']}', '{$object['tid']}', '{$object['text']}', '{$object['url']}', '{$object['alt']}', {$object['blank']}, '{$object['description']}', '{$params}'),";
		}
		$query = substr($query, 0, -1); $query .= ';';
		$request = mysqli_query($connect, $query) or 
			die(json_encode(['response'=>'error', 'result'=>'<div class="alert alert-danger"><strong>Оупс!</strong> На строке ' . __LINE__ . ' что то пошло не так ;(</div>']));
			//die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		if (mysqli_affected_rows($connect) > 0) {
			$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Объекты в меню успешно добавлены!</div>';
			die(json_encode(['response'=>'success', 'result' => "{$mid}"]));
		} else {
			die(json_encode(['response'=>'error', 'result'=>'<div class="alert alert-danger"><strong>Системная ошибка!</strong> При добавлении объектов в меню произошел сбой!</div>']));
		}	
	} else {
		die(json_encode(['response'=>'error', 'result'=>'<div class="alert alert-danger"><strong>Системная ошибка!</strong> При создании меню произошел сбой!</div>']));
	}

}

function getImg($object, $prefix, $thumb=false) {
	global $config; $thumb = ($thumb) ? 'thumb/' : ''; $size = $prefix . "s_{$prefix}picture_imgsize";
	$width = !empty($config['settings']->$size->value[0]) ? $config['settings']->$size->value[0] : 260;
	$height = !empty($config['settings']->$size->value[1]) ? $config['settings']->$size->value[1] : 260;
	return (!empty($object[$prefix . 'picture_path']) && !empty($object[$prefix . 'picture'])) ? '<img src="' . $object[$prefix . 'picture_path'] . $thumb . $object[$prefix . 'picture'] . '" width="' . $width . '" height="' . $height . '" alt="' . $object[$prefix . '_title'] . '">' : '';
}

function getProductName($object, $prefix, $article=false) {
	if (empty($object) || !is_array($object)) return '';
	return !empty($object[$prefix . '_title'])?(($article)?'['.$object[$prefix . '_article'].'] ':'').$object[$prefix . '_title']:$object[$prefix . '_article'];
}

function removeMenu($menu_id, $redirect=true) {
	global $connect, $config; $_SESSION['answer'] = "";
	
	$query = "DELETE FROM `{$config["prefix"]}menus` WHERE `menu_id` = {$menu_id}";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		if ($redirect) $_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Меню успешно удалено!</div>';
		//if (!$redirect) $_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> <b>Старое</b> меню успешно удалено!</div>';
		// Удаляем все связи с объектами
		$query = "DELETE FROM `{$config["prefix"]}menus_objects` WHERE `object_mid` = {$menu_id}";
		$request = mysqli_query($connect, $query) or 
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		if (mysqli_affected_rows($connect) > 0) {
			if ($redirect) $_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Связи меню успешно удалены!</div>';
			//if (!$redirect) $_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Связи <b>старого</b> меню успешно удалены!</div>';
		}
		
	} else {
		if ($redirect) $_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При удалении меню произошел сбой!</div>';
		if (!$redirect) return false;
	} if ($redirect) redirect("?view=menus"); else return true;
}

function addCat() {
 	global $connect, $config;
	$args = array(); $_SESSION['answer'] = ""; $slug = '';
	
    $args['title'] = clearObject($_POST['title']);
    $args['slug'] = clearObject($_POST['slug']);
    $args['keywords'] = clearObject($_POST['keywords']);
    $args['description'] = clearObject($_POST['description']);
    $args['text'] = clearObject($_POST['text'], true);
    $args['parent'] = abs((int)$_POST['parent']);
	$args['visible'] = abs((int)$_POST['visible']);
	
	//termparams plugin
	$args['params'] = array();
	if (!empty($_POST['params']) && is_array($_POST['params']))
		foreach($_POST['params'] as $k => $v) {
			if (empty($v)) continue;
			$args['params'][clearObject($v)] = (isset($_POST['values'][$k])) ? clearObject($_POST['values'][$k], true): '';
		}
		
	//termmediafields plugin
	$args['paramsmedia'] = array();
	if (!empty($_POST['paramsmedia']) && is_array($_POST['paramsmedia']))
		foreach($_POST['paramsmedia'] as $k => $v) {
			if (empty($v)) continue;
			$args['paramsmedia'][clearObject($v)] = (isset($_POST['valuesmedia'][$k])) ? clearObject($_POST['valuesmedia'][$k]): '';
		}
	
	if (!$args['title'] || !$args['slug']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У категории <b>минимум</b> должен быть заголовок и адрес!</div>';
		saveArgs($args);
		redirect("?view=add_cat"); 
	}
	
	if (!preg_match("/^[a-z_0-9-]+$/s", $args['slug'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Адрес категории может состоять только из маленьких латинских букв, цифр, знаков подчеркивания и дефиса!</div>';
		saveArgs($args);
		redirect("?view=add_cat"); 
	}

	if ($args['parent'] > 0) {
		/** генерация адреса для категории **/
		$query = "SELECT * FROM `{$config["prefix"]}cats` WHERE `cat_id` = {$args['parent']}";
		$request = mysqli_query($connect, $query) or 
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		
		$slug = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0]['cat_fullslug'] : '';
		/** генерация адреса для категории **/
	}
	
	$slug = !empty($slug) ? $slug . '/' . $args['slug'] : $args['slug'];
	
	/** проверка адреса рубрики на уникальность (на своем уровне) **/
	$query = "SELECT `cat_id` FROM `{$config["prefix"]}cats` WHERE `cat_fullslug` = '{$slug}'";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	$row = mysqli_fetch_all($request, MYSQLI_ASSOC);
	if (!empty($row[0]["cat_id"])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У категории <b>должен быть уникальный</b> адрес! Введенный Вами адрес уже используется на этом уровне!</div>';
		saveArgs($args);
		redirect("?view=add_cat");
	}
	/** проверка адреса рубрики на уникальность (на своем уровне) **/	
	
	$args['params']	= serialize($args['params']); //массив с произвольными полями вернется в случае чего, так что не спешим его преобразовывать в строку
	$args['paramsmedia'] = serialize($args['paramsmedia']);
    
	$query = "INSERT INTO `{$config["prefix"]}cats` (`cat_title`, `cat_keywords`, `cat_description`, `cat_parent`, `cat_text`, `cat_params`, `cat_datecreate`, `cat_dateupdate`, `cat_slug`, `cat_fullslug`, `cat_visible`, `cat_mediafields`) 
					VALUES ('{$args['title']}', '{$args['keywords']}', '{$args['description']}', {$args['parent']}, '{$args['text']}', '{$args['params']}', NOW(), NOW(), '{$args['slug']}', '{$slug}', {$args['visible']}, '{$args['paramsmedia']}')";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Категория успешно опубликована!</div>';
		
		$ID = mysqli_insert_id($connect);	
		
		if (!empty($_FILES['catpicture']['name']) && $config["plugins"]->cats->catpicture->active) {
			$path = "/files/cats/catpicture/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			$response = uploadImage($_FILES['catpicture'], $ID, $path, 0, [$config["settings"]->cats_catpicture_imgsize->value[0], $config["settings"]->cats_catpicture_imgsize->value[1]]);
			
			if ($response) {
				$response = clearObject($response);				
				mysqli_query($connect, "UPDATE `{$config["prefix"]}cats` SET `catpicture` = '{$response}', `catpicture_path` = '{$path}' WHERE `cat_id` = {$ID}") or 
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Миниатюра успешно загружена!</div>';
			} else {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать миниатюру для категории!</div>';
			}
		}
		
		if (!empty($_FILES['catgallery']['name'][0]) && $config["plugins"]->cats->catgallery->active) {
			$response = []; $response['catgallery'] = ''; $image = [];
			$path = "/files/cats/catgallery/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			for($i = 0; $i < count($_FILES['catgallery']['name']); $i++) {
				//create img from gallery
				$image['name'] = !empty($_FILES['catgallery']['name'][$i]) ? $_FILES['catgallery']['name'][$i] : '';
				$image['type'] = !empty($_FILES['catgallery']['type'][$i]) ? $_FILES['catgallery']['type'][$i] : '';
				$image['tmp_name'] = !empty($_FILES['catgallery']['tmp_name'][$i]) ? $_FILES['catgallery']['tmp_name'][$i] : '';
				$image['error'] = isset($_FILES['catgallery']['error'][$i]) ? $_FILES['catgallery']['error'][$i] : '';
				$image['size'] = !empty($_FILES['catgallery']['size'][$i]) ? $_FILES['catgallery']['size'][$i] : '';
				
				if (empty($image['name'])) continue;
				$response[$i] = uploadImage($image, $ID, $path, $i, [$config["settings"]->cats_catgallery_imgsize->value[0], $config["settings"]->cats_catgallery_imgsize->value[1]]);
				
				if ($response[$i]) {
					$response['catgallery'] .= clearObject($response[$i]) . "|";
					$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Картинка галереи <b>' . $_FILES['catgallery']['name'][$i] . '</b> успешно загружена!</div>';
				} else {
					$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать картинку галереи <b>' . $_FILES['catgallery']['name'][$i] . '</b> для категории!</div>';
				}
			}
			
			if (!empty($response['catgallery'])) {
				$response['catgallery'] = substr($response['catgallery'], 0, -1);
				mysqli_query($connect, "UPDATE `{$config["prefix"]}cats` SET `catgallery` = '{$response['catgallery']}', `catgallery_path` = '{$path}' WHERE `cat_id` = {$ID}") or 
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
			}
		}
		
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При публикации категории произошел сбой!</div>';
	} if (isset($ID) && !empty($ID) && $config["settings"]->redirect->value) redirect("?view=update_cat&cat_id=" . $ID); redirect("?view=categories");
}

function updateCat($ID) {
 	global $connect, $config;
	$args = array(); $_SESSION['answer'] = ""; $slug = '';
	
    $args['title'] = clearObject($_POST['title']);
    $args['slug'] = clearObject($_POST['slug']);
    $args['keywords'] = clearObject($_POST['keywords']);
    $args['description'] = clearObject($_POST['description']);
    $args['text'] = clearObject($_POST['text'], true);
    $args['parent'] = abs((int)$_POST['parent']);
	$args['visible'] = abs((int)$_POST['visible']);
	
	//termparams plugin
	$args['params'] = array();
	if (!empty($_POST['params']) && is_array($_POST['params']))
		foreach($_POST['params'] as $k => $v) {
			if (empty($v)) continue;
			$args['params'][clearObject($v)] = (isset($_POST['values'][$k])) ? clearObject($_POST['values'][$k], true): '';
		}
		
	//termmediafields plugin
	$args['paramsmedia'] = array();
	if (!empty($_POST['paramsmedia']) && is_array($_POST['paramsmedia']))
		foreach($_POST['paramsmedia'] as $k => $v) {
			if (empty($v)) continue;
			$args['paramsmedia'][clearObject($v)] = (isset($_POST['valuesmedia'][$k])) ? clearObject($_POST['valuesmedia'][$k]): '';
		}
	
	if (!$args['title'] || !$args['slug']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У категории <b>минимум</b> должен быть заголовок и адрес!</div>';
		saveArgs($args);
		redirect("?view=update_cat&cat_id=" . $ID); 
	}
	
	if ($ID == $args['parent']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Категория <b>не может быть</b> своим родителем!</div>';
		saveArgs($args);
		redirect("?view=update_cat&cat_id=" . $ID); 
	}
	
	$objects = sortObjectsTree(getObjectsTree('cats', 'cat', true), 'cat');
	$objectParent = explode('|', checkObjectsTreeParent($objects, $ID, 'cat'));

	if ($args['parent'] > 0 && in_array($args['parent'], $objectParent)) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Категория <b>не может быть</b> потомком своего потомка!</div>';
		saveArgs($args);
		redirect("?view=update_cat&cat_id=" . $ID);  
	}
	
	if (!preg_match("/^[a-z_0-9-]+$/s", $args['slug'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Адрес категории может состоять только из маленьких латинских букв, цифр, знаков подчеркивания и дефиса!</div>';
		saveArgs($args);
		redirect("?view=update_cat&cat_id=" . $ID); 
	}

	if ($args['parent'] > 0) {
		/** генерация адреса для категории **/
		$query = "SELECT * FROM `{$config["prefix"]}cats` WHERE `cat_id` = {$args['parent']}";
		$request = mysqli_query($connect, $query) or 
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		
		$dummy = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC)[0] : '';
		$slug = !empty($dummy['cat_fullslug']) ? $dummy['cat_fullslug'] : '';
		/** генерация адреса для категории **/
	}

	$slug = !empty($slug) ? $slug . '/' . $args['slug'] : $args['slug'];
	
	/** проверка адреса категории на уникальность (на своем уровне) **/
	$query = "SELECT `cat_id` FROM `{$config["prefix"]}cats` WHERE `cat_fullslug` = '{$slug}' AND `cat_id` != {$ID}";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	$row = mysqli_fetch_all($request, MYSQLI_ASSOC);
	if (!empty($row[0]["cat_id"])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У категории <b>должен быть уникальный</b> адрес! Введенный Вами адрес уже используется на этом уровне!</div>';
		saveArgs($args);
		redirect("?view=update_cat&cat_id=" . $ID);
	}
	/** проверка адреса категории на уникальность (на своем уровне) **/	
	
	$args['params']	= serialize($args['params']); //массив с произвольными полями вернется в случае чего, так что не спешим его преобразовывать в строку
	$args['paramsmedia'] = serialize($args['paramsmedia']);
	
	$query = "UPDATE `{$config["prefix"]}cats` SET 
					`cat_title` = '{$args['title']}',
					`cat_keywords` = '{$args['keywords']}',
					`cat_description` = '{$args['description']}',
					`cat_parent` = {$args['parent']},
					`cat_text` = '{$args['text']}',
					`cat_params` = '{$args['params']}',
					`cat_dateupdate` = NOW(),
					`cat_slug` = '{$args['slug']}',
					`cat_fullslug` = '{$slug}',
					`cat_visible` = {$args['visible']},
					`cat_mediafields` = '{$args['paramsmedia']}' WHERE `cat_id` = {$ID}";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Категория успешно обновлена!</div>';	
		
		if (!empty($_FILES['catpicture']['name']) && $config["plugins"]->cats->catpicture->active) {
			$path = !empty($dummy['catpicture_path']) ? $dummy['catpicture_path'] : "/files/cats/catpicture/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			$response = uploadImage($_FILES['catpicture'], $ID, $path, 0, [$config["settings"]->cats_catpicture_imgsize->value[0], $config["settings"]->cats_catpicture_imgsize->value[1]]);
			
			if ($response) {
				$response = clearObject($response);				
				mysqli_query($connect, "UPDATE `{$config["prefix"]}cats` SET `catpicture` = '{$response}', `catpicture_path` = '{$path}' WHERE `cat_id` = {$ID}") or 
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Миниатюра успешно загружена!</div>';
			} else {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать миниатюру для категории!</div>';
			}
		}	
		
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При обновлении категории произошел сбой!</div>';
	} if (isset($ID) && !empty($ID) && $config["settings"]->redirect->value) redirect("?view=update_cat&cat_id=" . $ID); redirect("?view=categories");
}

function getPriceDiscount($price, $discount) {
	if ($price == 0 || $discount == 0) return $price;
	return ($price - (($price*$discount)/100));
}

function addProduct() {
 	global $connect, $config;
	$args = array(); $_SESSION['answer'] = "";
	
    $args['title'] = clearObject($_POST['title']);
    $args['article'] = clearObject($_POST['article']);
    $args['slug'] = clearObject($_POST['slug']);
    $args['keywords'] = clearObject($_POST['keywords']);
    $args['description'] = clearObject($_POST['description']);
    $args['quote'] = !empty($_POST['quote']) ? clearObject($_POST['quote'], true) : '';
    $args['text'] = clearObject($_POST['text'], true);
    //$args['parent'] = abs((int)$_POST['parent']);
	$args['visible'] = abs((int)$_POST['visible']);
	$args['special'] = abs((int)$_POST['special']);
	$args['price'] = abs((int)$_POST['price']);
	$args['discount'] = abs((int)$_POST['discount']);
	$args['discount'] = ($args['discount'] > 99) ? 99 : $args['discount'];
	$priceWithDiscount = getPriceDiscount($args['price'], $args['discount']);
	//product_pricewithdiscount

	//postparams plugin
	$args['params'] = array();
	if (!empty($_POST['params']) && is_array($_POST['params']))
		foreach($_POST['params'] as $k => $v) {
			if (empty($v)) continue;
			$args['params'][clearObject($v)] = (isset($_POST['values'][$k])) ? clearObject($_POST['values'][$k], true): '';
		}
		
	//postmediafields plugin
	$args['paramsmedia'] = array();
	if (!empty($_POST['paramsmedia']) && is_array($_POST['paramsmedia']))
		foreach($_POST['paramsmedia'] as $k => $v) {
			if (empty($v)) continue;
			$args['paramsmedia'][clearObject($v)] = (isset($_POST['valuesmedia'][$k])) ? clearObject($_POST['valuesmedia'][$k]): '';
		}

	//cats module
	$args['cats'] = array();
	if (!empty($_POST['cats']) && is_array($_POST['cats']))
		foreach($_POST['cats'] as $cat) {
			if (empty($cat)) continue;
			$cat = abs((int)$cat);
			if ($cat > 0) $args['cats'][] = $cat;
		}
		
	//simular plugin
	$args['simular'] = array();
	if (!empty($_POST['simular']) && is_array($_POST['simular']))
		foreach($_POST['simular'] as $product) {
			if (empty($product)) continue;
			$product = abs((int)$product);
			if ($product > 0) $args['simular'][] = $product;
		}
	
	if (!$args['article'] || !$args['slug']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У товара <b>минимум</b> должен быть артикул и адрес!</div>';
		saveArgs($args);
		redirect("?view=add_product"); 
	}
	
	if (!preg_match("/^[a-z_0-9-]+$/s", $args['slug'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Адрес товара может состоять только из маленьких латинских букв, цифр, знаков подчеркивания и дефиса!</div>';
		saveArgs($args);
		redirect("?view=add_product"); 
	}
	
	/** проверка адреса товара на уникальность **/
	$query = "SELECT `product_id` FROM `{$config["prefix"]}products` WHERE `product_slug` = '{$args['slug']}'";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	$row = mysqli_fetch_all($request, MYSQLI_ASSOC);
	if (!empty($row[0]["product_id"])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У товара <b>должен быть уникальный</b> адрес! Введенный Вами адрес уже используется!<br><strong>Напоминаем Вам что адрес генерируется автоматически от артикула товара!</strong><br>Возможные решения:<ul><li>Попробуйте ввести адрес вручную соблюдая правила ввода.</li></ul>Если ошибка все же повторяется, то советуем Вам обратиться за помощью к системному администратору.</div>';
		saveArgs($args);
		redirect("?view=add_product");
	}
	/** проверка адреса товара на уникальность **/
	
	if (!empty($args['cats']) && is_array($args['cats'])) {
		$query = "SELECT * FROM {$config["prefix"]}cats";
		$request = mysqli_query($connect, $query);
		$cats = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC) : [];

		$ct = array();
		foreach($cats as $cat) {
			$ct[] = $cat['cat_id'];
		}
		
		foreach($args['cats'] as $tc) {
			if (!in_array($tc, $ct)) {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Вы пытаетесь создать связь товара с несуществующей категорией!</div>';
				saveArgs($args);
				redirect("?view=add_product"); 
			}
		}
	}	

	$args['params']	= serialize($args['params']); //массив с произвольными полями вернется в случае чего, так что не спешим его преобразовывать в строку
	$args['paramsmedia'] = serialize($args['paramsmedia']);
	$args['simular'] = serialize($args['simular']);
	
    $authorId = !empty($_SESSION['auth']['user_id']) ? abs((int)$_SESSION['auth']['user_id']) : 0;
	$query = "INSERT INTO `{$config["prefix"]}products` (`product_pricewithdiscount`, `product_article`, `product_price`, `product_discount`, `product_simular`, `product_title`, `product_special`, `product_quote`, `product_keywords`, `product_author`, `product_description`, `product_text`, `product_params`, `product_datecreate`, `product_dateupdate`, `product_slug`, `product_visible`, `product_mediafields`) 
					VALUES ('{$priceWithDiscount}', '{$args['article']}', {$args['price']}, {$args['discount']}, '{$args['simular']}', '{$args['title']}', '{$args['special']}', '{$args['quote']}', '{$args['keywords']}', {$authorId}, '{$args['description']}', '{$args['text']}', '{$args['params']}', NOW(), NOW(), '{$args['slug']}', {$args['visible']}, '{$args['paramsmedia']}')";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Товар успешно опубликован!</div>';
		
		$ID = mysqli_insert_id($connect);	
		
		if (!empty($_FILES['productpicture']['name']) && $config["plugins"]->products->productpicture->active) {
			$path = "/files/products/productpicture/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			$response = uploadImage($_FILES['productpicture'], $ID, $path, 0, [$config["settings"]->products_productpicture_imgsize->value[0], $config["settings"]->products_productpicture_imgsize->value[1]]);
			
			if ($response) {
				$response = clearObject($response);				
				mysqli_query($connect, "UPDATE `{$config["prefix"]}products` SET `productpicture` = '{$response}', `productpicture_path` = '{$path}' WHERE `product_id` = {$ID}") or 
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Миниатюра успешно загружена!</div>';
			} else {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать миниатюру для товара!</div>';
			}
		}
		
		if (!empty($_FILES['productgallery']['name'][0]) && $config["plugins"]->products->productgallery->active) {
			$response = []; $response['productgallery'] = ''; $image = [];
			$path = "/files/products/productgallery/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			for($i = 0; $i < count($_FILES['productgallery']['name']); $i++) {
				//create img from gallery
				$image['name'] = !empty($_FILES['productgallery']['name'][$i]) ? $_FILES['productgallery']['name'][$i] : '';
				$image['type'] = !empty($_FILES['productgallery']['type'][$i]) ? $_FILES['productgallery']['type'][$i] : '';
				$image['tmp_name'] = !empty($_FILES['productgallery']['tmp_name'][$i]) ? $_FILES['productgallery']['tmp_name'][$i] : '';
				$image['error'] = isset($_FILES['productgallery']['error'][$i]) ? $_FILES['productgallery']['error'][$i] : '';
				$image['size'] = !empty($_FILES['productgallery']['size'][$i]) ? $_FILES['productgallery']['size'][$i] : '';
				
				if (empty($image['name'])) continue;
				$response[$i] = uploadImage($image, $ID, $path, $i, [$config["settings"]->products_productgallery_imgsize->value[0], $config["settings"]->products_productgallery_imgsize->value[1]]);
				
				if ($response[$i]) {
					$response['productgallery'] .= clearObject($response[$i]) . "|";
					$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Картинка галереи <b>' . $_FILES['productgallery']['name'][$i] . '</b> успешно загружена!</div>';
				} else {
					$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать картинку галереи <b>' . $_FILES['productgallery']['name'][$i] . '</b> для товара!</div>';
				}
			}
			
			if (!empty($response['productgallery'])) {
				$response['productgallery'] = substr($response['productgallery'], 0, -1);
				mysqli_query($connect, "UPDATE `{$config["prefix"]}products` SET `productgallery` = '{$response['productgallery']}', `productgallery_path` = '{$path}' WHERE `product_id` = {$ID}") or 
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
			}
		}
		
		if (!empty($args['cats']) && is_array($args['cats'])) {
			$query = "INSERT IGNORE INTO `{$config["prefix"]}products_relationships` (`cat_id`, `product_id`) VALUES ";
			$values = '';
			foreach($args['cats'] as $cat) {
				$values .= "({$cat}, {$ID}),";
			}
			
			$values = substr($values, 0, -1);
			$query .= $values;

			$request = mysqli_query($connect, $query) or 
				die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
			
			if (mysqli_affected_rows($connect) > 0) {
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Связи с товарами успешно созданы!</div>';
			} else {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При создании связей с категориями произошла ошибка!<br>Если товар не появился в Выбранной Вами категории то обратитесь за помощью к администратору!</div>';
			}
		}
		
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При публикации товара произошел сбой!</div>';
	} if (isset($ID) && !empty($ID) && $config["settings"]->redirect->value) redirect("?view=update_product&product_id=" . $ID); redirect("?view=products");
}

function updateProduct($product_id) {
 	global $connect, $config;
	$args = array(); $_SESSION['answer'] = "";
	
    $args['article'] = clearObject($_POST['article']);
    $args['title'] = clearObject($_POST['title']);
    $args['slug'] = clearObject($_POST['slug']);
    $args['keywords'] = clearObject($_POST['keywords']);
    $args['description'] = clearObject($_POST['description']);
    $args['quote'] = !empty($_POST['quote']) ? clearObject($_POST['quote'], true) : '';
    $args['text'] = clearObject($_POST['text'], true);
    //$args['parent'] = abs((int)$_POST['parent']);
	$args['visible'] = abs((int)$_POST['visible']);
	$args['special'] = abs((int)$_POST['special']);
	$args['price'] = abs((int)$_POST['price']);
	$args['discount'] = abs((int)$_POST['discount']);
	$args['discount'] = ($args['discount'] > 99) ? 99 : $args['discount'];
	$priceWithDiscount = getPriceDiscount($args['price'], $args['discount']);
	//product_pricewithdiscount

	//postparams plugin
	$args['params'] = array();
	if (!empty($_POST['params']) && is_array($_POST['params']))
		foreach($_POST['params'] as $k => $v) {
			if (empty($v)) continue;
			$args['params'][clearObject($v)] = (isset($_POST['values'][$k])) ? clearObject($_POST['values'][$k], true): '';
		}
		
	//postmediafields plugin
	$args['paramsmedia'] = array();
	if (!empty($_POST['paramsmedia']) && is_array($_POST['paramsmedia']))
		foreach($_POST['paramsmedia'] as $k => $v) {
			if (empty($v)) continue;
			$args['paramsmedia'][clearObject($v)] = (isset($_POST['valuesmedia'][$k])) ? clearObject($_POST['valuesmedia'][$k]): '';
		}

	//cats module
	$args['cats'] = array();
	if (!empty($_POST['cats']) && is_array($_POST['cats']))
		foreach($_POST['cats'] as $cat) {
			if (empty($cat)) continue;
			$cat = abs((int)$cat);
			if ($cat > 0) $args['cats'][] = $cat;
		}
		
	//simular plugin
	$args['simular'] = array();
	if (!empty($_POST['simular']) && is_array($_POST['simular']))
		foreach($_POST['simular'] as $product) {
			if (empty($product)) continue;
			$product = abs((int)$product);
			if ($product > 0) $args['simular'][] = $product;
		}
	
	if (!$args['article'] || !$args['slug']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У товара <b>минимум</b> должен быть артикул и адрес!</div>';
		saveArgs($args);
		redirect("?view=update_product&product_id={$product_id}"); 
	}
	
	if (!preg_match("/^[a-z_0-9-]+$/s", $args['slug'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Адрес товара может состоять только из маленьких латинских букв, цифр, знаков подчеркивания и дефиса!</div>';
		saveArgs($args);
		redirect("?view=update_product&product_id={$product_id}"); 
	}
	
	/** проверка адреса товара на уникальность **/
	$query = "SELECT `product_id` FROM `{$config["prefix"]}products` WHERE `product_slug` = '{$args['slug']}' AND `product_id` != {$product_id}";
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
	
	$row = mysqli_fetch_all($request, MYSQLI_ASSOC);
	if (!empty($row[0]["product_id"])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У товара <b>должен быть уникальный</b> адрес! Введенный Вами адрес уже используется!<br><strong>Напоминаем Вам что адрес генерируется автоматически от артикула товара!</strong><br>Возможные решения:<ul><li>Попробуйте ввести адрес вручную соблюдая правила ввода.</li></ul>Если ошибка все же повторяется, то советуем Вам обратиться за помощью к системному администратору.</div>';
		saveArgs($args);
		redirect("?view=update_product&product_id={$product_id}");
	}
	/** проверка адреса товара на уникальность **/
	
	if (!empty($args['cats']) && is_array($args['cats'])) {
		$query = "SELECT * FROM {$config["prefix"]}cats";
		$request = mysqli_query($connect, $query);
		$cats = (mysqli_num_rows($request) > 0) ? mysqli_fetch_all($request, MYSQLI_ASSOC) : [];

		$ct = array();
		foreach($cats as $cat) {
			$ct[] = $cat['cat_id'];
		}
		
		foreach($args['cats'] as $tc) {
			if (!in_array($tc, $ct)) {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Вы пытаетесь создать связь записи с несуществующей категорией!</div>';
				saveArgs($args);
				redirect("?view=update_product&product_id={$product_id}"); 
			}
		}
	}	

	$args['params']	= serialize($args['params']); //массив с произвольными полями вернется в случае чего, так что не спешим его преобразовывать в строку
	$args['paramsmedia'] = serialize($args['paramsmedia']);
	$args['simular'] = serialize($args['simular']);
    $authorId = !empty($_SESSION['auth']['user_id']) ? abs((int)$_SESSION['auth']['user_id']) : 0;
	
	$query = "UPDATE `{$config["prefix"]}products` 
				SET 
					`product_pricewithdiscount` = '{$priceWithDiscount}',
					`product_article` = '{$args['article']}',
					`product_price` = {$args['price']},
					`product_discount` = {$args['discount']},
					`product_simular` = '{$args['simular']}',
					`product_title` = '{$args['title']}',
					`product_special` = '{$args['special']}',
					`product_quote` = '{$args['quote']}',
					`product_keywords` = '{$args['keywords']}',
					`product_author` = '{$authorId}',
					`product_description` = '{$args['description']}',
					`product_text` = '{$args['text']}',
					`product_params` = '{$args['params']}',
					`product_dateupdate` = NOW(),
					`product_slug` = '{$args['slug']}',
					`product_visible` = {$args['visible']},
					`product_mediafields` = '{$args['paramsmedia']}'
				WHERE `product_id` = {$product_id}";
	
	$request = mysqli_query($connect, $query) or 
		die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Товар успешно обновлен!</div>';
		
		$ID = $product_id;	
		
		if (!empty($_FILES['productpicture']['name']) && $config["plugins"]->products->productpicture->active) {
			$path = "/files/products/productpicture/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			$response = uploadImage($_FILES['productpicture'], $ID, $path, 0, [$config["settings"]->products_productpicture_imgsize->value[0], $config["settings"]->products_productpicture_imgsize->value[1]]);
			
			if ($response) {
				$response = clearObject($response);				
				mysqli_query($connect, "UPDATE `{$config["prefix"]}products` SET `productpicture` = '{$response}', `productpicture_path` = '{$path}' WHERE `product_id` = {$ID}") or 
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Миниатюра успешно загружена!</div>';
			} else {
				$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать миниатюру для товара!</div>';
			}
		}
		
		$request = mysqli_query($connect, "DELETE FROM `{$config["prefix"]}products_relationships` WHERE `product_id` = {$ID}") or
			die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
		
		if (!empty($args['cats']) && is_array($args['cats'])) {
			$query = "INSERT IGNORE INTO `{$config["prefix"]}products_relationships` (`cat_id`, `product_id`) VALUES ";
			$values = '';
			foreach($args['cats'] as $cat) {
				$values .= "({$cat}, {$ID}),";
			}
			
			$values = substr($values, 0, -1);
			$query .= $values;

			$request = mysqli_query($connect, $query) or 
				die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
			
			if (mysqli_affected_rows($connect) > 0) {
				$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Связи с товарами успешно созданы!</div>';
			} else {
				//$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При создании связей с рубриками произошла ошибка!<br>Если запись не появился в Выбранной Вами рубрике то обратитесь за помощью к администратору!</div>';
			}
		}
		
	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При публикации товара произошел сбой!</div>';
	} if (isset($ID) && !empty($ID) && $config["settings"]->redirect->value) redirect("?view=update_product&product_id=" . $ID); redirect("?view=products");
}

function getPostsInTerm($json=false) {
	global $connect, $config; $html = '';
	$term = $_POST['term'];
	$page = abs((int)$_POST['page']);
	$perpage = abs((int)$_POST['perpage']);
	if ($json) header('Content-Type: application/json');
	
	$_GET['page'] = $page;
	$_GET['perpage'] = $perpage;
	$_GET['ajax'] = true;
	if ($term != 'all') {
		$_GET['field'] = 'term_fullslug';
		$_GET['value'] = $term;
	} 
	$posts = getObjects([
		'table'=>'posts',
		'function'=>'getObjectsWithRelationships',
		'order_by'=>['post_id'],
		'field'=>['term_fullslug'],
		'prefix'=>'post',
		'relationship'=>'terms',
		'relationship_prefix'=>'term'
	]);
	
	if (!empty($posts) && $json) {
		foreach($posts as $item) {
			$html .= '<div class="ajaxFade' . $page . '" style="display:none;">
						<a class="serv_img" href="/post/' . $item['post_slug'] . '/">' . getImg($item, 'post', true) . '</a>
						<h3><a href="/post/' . $item['post_slug'] . '/">' . $item['post_title'] . '</a></h3>
						<div class="min_text">
							' . htmlspecialchars_decode($item['post_quote']) . '
						</div><!--min_text-->
						<a class="read_more" href="/post/' . $item['post_slug'] . '/">Читать далее <i class="ico_next"></i></a>
					  </div>';
		} $posts = $html;
	}
	
	return (!empty($posts)) ? ($json ? die(json_encode(['result' => 'success', 'html' => $posts])) :  $posts) : ($json ? die(json_encode(['result' => 'success', 'html' => 'notfound'])) : []);
}

function addSlider() {
	global $connect, $config;
	$args = array(); $_SESSION['answer'] = "";

	$args['name'] = clearObject($_POST['name']);
	$args['callname'] = clearObject($_POST['callname']);
	$args['visible'] = abs((int)$_POST['visible']);

	//pageparams
	$args['params'] = array();
	if (!empty($_POST['params']) && is_array($_POST['params']))
		foreach($_POST['params'] as $k => $v) {
			if (empty($v)) continue;
			$args['params'][clearObject($v)] = (isset($_POST['values'][$k])) ? clearObject($_POST['values'][$k], true): '';
		}

	//sliders
	$args['sliders'] = array();
	if (!empty($_POST['title']) && is_array($_POST['title']))
		foreach($_POST['title'] as $item => $v) {
			$args['sliders'][$item]['title'] = isset($_POST['title'][$item]) ? clearObject($_POST['title'][$item], true) : '';
			$args['sliders'][$item]['link'] = isset($_POST['link'][$item]) ? clearObject($_POST['link'][$item]) : '';
			$args['sliders'][$item]['text'] = isset($_POST['text'][$item]) ? clearObject($_POST['text'][$item], true) : '';
			$args['sliders'][$item]['video'] = isset($_POST['video'][$item]) ? abs((int)$_POST['video'][$item]) : 0;
			$args['sliders'][$item]['blank'] = isset($_POST['blank'][$item]) ? abs((int)$_POST['blank'][$item]) : 0;
			$args['sliders'][$item]['videourl'] = isset($_POST['videourl'][$item]) ? clearObject($_POST['videourl'][$item], true) : '';
			$args['sliders'][$item]['slider'] = '';
		}

	if (!$args['name'] || !$args['callname']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У слайдера <b>минимум</b> должено быть название и callname!</div>';
		//saveArgs($args);
		redirect("?view=add_slider");
	}

	if (!preg_match("/^[a-z_-]+$/s", $args['callname'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Свойство <b>callname</b> может состоять только из маленьких латинских букв, знака подчеркивания и дефиса!</div>';
		//saveArgs($args);
		redirect("?view=add_slider");
	}

	/** проверка callname слайдера на уникальность **/
	$query = "SELECT `slider_id` FROM `{$config["prefix"]}sliders` WHERE `slider_callname` = '{$args['callname']}'";
	$request = mysqli_query($connect, $query) or
	die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	$row = mysqli_fetch_all($request, MYSQLI_ASSOC);
	if (!empty($row[0]["slider_id"])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У слайдера <b>должен быть уникальный</b> callname! Введенный Вами callname уже используется!</div>';
		//saveArgs($args);
		redirect("?view=add_slider");
	}
	/** проверка callname слайдера на уникальность **/

	$args['params']	= serialize($args['params']); //массив с произвольными полями вернется в случае чего, так что не спешим его преобразовывать в строку
	$args['sliders'] = serialize($args['sliders']);

	$query = "INSERT INTO `{$config["prefix"]}sliders` (`slider_name`, `slider_callname`, `slider_visible`, `slider_sliders`, `slider_params`, `slider_datecreate`, `slider_dateupdate`) 
					VALUES ('{$args['name']}', '{$args['callname']}', {$args['visible']}, '{$args['sliders']}', '{$args['params']}', NOW(), NOW())";
	$request = mysqli_query($connect, $query) or
	die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Слайдер успешно добавлен!</div>';

		$ID = mysqli_insert_id($connect);

		if (!empty($_FILES['slider']['name'])) {
			$response = []; $response['slider'] = ''; $image = []; $args['sliders'] = unserialize($args['sliders']);
			$path = "/files/sliders/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			for($i = 0; $i < count($_FILES['slider']['name']); $i++) {
				//create img from slider
				$image['name'] = !empty($_FILES['slider']['name'][$i]) ? $_FILES['slider']['name'][$i] : '';
				$image['type'] = !empty($_FILES['slider']['type'][$i]) ? $_FILES['slider']['type'][$i] : '';
				$image['tmp_name'] = !empty($_FILES['slider']['tmp_name'][$i]) ? $_FILES['slider']['tmp_name'][$i] : '';
				$image['error'] = isset($_FILES['slider']['error'][$i]) ? $_FILES['slider']['error'][$i] : '';
				$image['size'] = !empty($_FILES['slider']['size'][$i]) ? $_FILES['slider']['size'][$i] : '';

				if (empty($image['name'])) continue;
				$response[$i] = uploadImage($image, $ID, $path, $i, [$config["settings"]->sliders_imgsize->value[0], $config["settings"]->sliders_imgsize->value[1]]);

				if ($response[$i]) {
					$response['slider'] .= clearObject($response[$i]) . "|";
					if (isset($args['sliders'][$i]['slider'])) $args['sliders'][$i]['slider'] = clearObject($response[$i]);
					$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Слайд <b>' . $_FILES['slider']['name'][$i] . '</b> успешно загружен!</div>';
				} else {
					$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать слайд <b>' . $_FILES['slider']['name'][$i] . '</b>!</div>';
				}
			}

			if (!empty($response['slider'])) {
				$args['sliders'] = serialize($args['sliders']);
				mysqli_query($connect, "UPDATE `{$config["prefix"]}sliders` SET `slider_sliders` = '{$args['sliders']}', `slider_path` = '{$path}' WHERE `slider_id` = {$ID}") or
				die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
			}
		}

	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При добавлении слайдера произошел сбой!</div>';
	} if (isset($ID) && !empty($ID) && $config["settings"]->redirect->value) redirect("?view=update_slider&slider_id=" . $ID); redirect("?view=sliders");
}

function updateSlider($ID) {
	global $connect, $config;
	$args = array(); $_SESSION['answer'] = "";

	$args['name'] = clearObject($_POST['name']);
	$args['callname'] = clearObject($_POST['callname']);
	$args['visible'] = abs((int)$_POST['visible']);

	//pageparams
	$args['params'] = array();
	if (!empty($_POST['params']) && is_array($_POST['params']))
		foreach($_POST['params'] as $k => $v) {
			if (empty($v)) continue;
			$args['params'][clearObject($v)] = (isset($_POST['values'][$k])) ? clearObject($_POST['values'][$k], true): '';
		}

	//sliders
	$args['sliders'] = array();
	if (!empty($_POST['title']) && is_array($_POST['title']))
		foreach($_POST['title'] as $item => $v) {
			$args['sliders'][$item]['title'] = isset($_POST['title'][$item]) ? clearObject($_POST['title'][$item], true) : '';
			$args['sliders'][$item]['link'] = isset($_POST['link'][$item]) ? clearObject($_POST['link'][$item]) : '';
			$args['sliders'][$item]['text'] = isset($_POST['text'][$item]) ? clearObject($_POST['text'][$item], true) : '';
			$args['sliders'][$item]['video'] = isset($_POST['video'][$item]) ? abs((int)$_POST['video'][$item]) : 0;
			$args['sliders'][$item]['blank'] = isset($_POST['blank'][$item]) ? abs((int)$_POST['blank'][$item]) : 0;
			$args['sliders'][$item]['videourl'] = isset($_POST['videourl'][$item]) ? clearObject($_POST['videourl'][$item], true) : '';
			$args['sliders'][$item]['slider'] = (isset($_POST['cache'][$item]) && !empty($_POST['cache'][$item])) ? clearObject($_POST['cache'][$item]) : '';
		}

	if (!$args['name'] || !$args['callname']) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У слайдера <b>минимум</b> должено быть название и callname!</div>';
		//saveArgs($args);
		redirect("?view=update_slider&slider_id=" . $ID);
	}

	if (!preg_match("/^[a-z_-]+$/s", $args['callname'])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> Свойство <b>callname</b> может состоять только из маленьких латинских букв, знака подчеркивания и дефиса!</div>';
		//saveArgs($args);
		redirect("?view=update_slider&slider_id=" . $ID);
	}

	/** проверка callname слайдера на уникальность **/
	$query = "SELECT * FROM `{$config["prefix"]}sliders` WHERE `slider_callname` = '{$args['callname']}' AND `slider_id` != {$ID}";
	$request = mysqli_query($connect, $query) or
	die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	$row = mysqli_fetch_all($request, MYSQLI_ASSOC);
	if (!empty($row[0]["slider_id"])) {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Ошибка!</strong> У слайдера <b>должен быть уникальный</b> callname! Введенный Вами callname уже используется!</div>';
		//saveArgs($args);
		redirect("?view=update_slider&slider_id=" . $ID);
	}
	/** проверка callname слайдера на уникальность **/

	$args['params']	= serialize($args['params']); //массив с произвольными полями вернется в случае чего, так что не спешим его преобразовывать в строку
	$args['sliders'] = serialize($args['sliders']);

	$query = "UPDATE `{$config["prefix"]}sliders` SET 
				`slider_name` = '{$args['name']}',
				`slider_callname` = '{$args['callname']}',
				`slider_visible` = {$args['visible']},
				`slider_sliders` = '{$args['sliders']}',
				`slider_params` = '{$args['params']}',
				`slider_dateupdate` = NOW()
			WHERE `slider_id` = {$ID}";
	$request = mysqli_query($connect, $query) or
	die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));

	if (mysqli_affected_rows($connect) > 0) {
		$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Слайдер успешно обновлен!</div>';

		//$ID = mysqli_insert_id($connect);

		if (!empty($_FILES['slider']['name'])) {
			$response = []; $response['slider'] = ''; $image = []; $args['sliders'] = unserialize($args['sliders']);
			$path = !empty($row[0]["slider_path"]) ? $row[0]["slider_path"] : "/files/sliders/" . date("Y") . "/" . date("m") . "/" . date("W") . "/" . date("N") . "/" . $ID . "/";
			for($i = 0; $i < count($_FILES['slider']['name']); $i++) {
				//create img from slider
				$image['name'] = !empty($_FILES['slider']['name'][$i]) ? $_FILES['slider']['name'][$i] : '';
				$image['type'] = !empty($_FILES['slider']['type'][$i]) ? $_FILES['slider']['type'][$i] : '';
				$image['tmp_name'] = !empty($_FILES['slider']['tmp_name'][$i]) ? $_FILES['slider']['tmp_name'][$i] : '';
				$image['error'] = isset($_FILES['slider']['error'][$i]) ? $_FILES['slider']['error'][$i] : '';
				$image['size'] = !empty($_FILES['slider']['size'][$i]) ? $_FILES['slider']['size'][$i] : '';

				if (empty($image['name'])) continue;
				$response[$i] = uploadImage($image, $ID, $path, $i, [$config["settings"]->sliders_imgsize->value[0], $config["settings"]->sliders_imgsize->value[1]]);

				if ($response[$i]) {
					$response['slider'] .= clearObject($response[$i]) . "|";
					if (isset($args['sliders'][$i]['slider'])) $args['sliders'][$i]['slider'] = clearObject($response[$i]);
					$_SESSION['answer'] .= '<div class="alert alert-success"><strong>Действие выполнено!</strong> Слайд <b>' . $_FILES['slider']['name'][$i] . '</b> успешно загружен!</div>';
				} else {
					$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Не удалось обработать слайд <b>' . $_FILES['slider']['name'][$i] . '</b>!</div>';
				}
			}

			if (!empty($response['slider'])) {
				$args['sliders'] = serialize($args['sliders']);
				mysqli_query($connect, "UPDATE `{$config["prefix"]}sliders` SET `slider_sliders` = '{$args['sliders']}', `slider_path` = '{$path}' WHERE `slider_id` = {$ID}") or
					die("You have an error in function ".__FUNCTION__." on line ".__LINE__.".<br> ".mysqli_errno($connect).": ".mysqli_error($connect));
			}
		}

	} else {
		$_SESSION['answer'] .= '<div class="alert alert-danger"><strong>Системная ошибка!</strong> При обновлении слайдера произошел сбой!</div>';
	} if (isset($ID) && !empty($ID) && $config["settings"]->redirect->value) redirect("?view=update_slider&slider_id=" . $ID); redirect("?view=sliders");
}

function get_email($subject, $body, $link=false) {
	global $config;
	if (file_exists(DR . "/library/email-tmpl/email-adminMessage.php")) {
		ob_start();
			$host = 'http://' . $_SERVER['HTTP_HOST'] . '/'; $title = $config['settings']->title->value;
			require_once(DR . "/library/email-tmpl/email-adminMessage.php");
		return ob_get_clean();
	} else {
		die("You have an error in function ".__FUNCTION__. " email tmpl doesn't exists");
	}
}

/*$args = [
	'smtp' => [
		'smtp_host' => null, #'ssl://smtp.yandex.ru'
		'smtp_port' => null, #465
		'smtp_username' => null, #'ex3xeng@yandex.ru'
		'smtp_password' => null
	],
	'from' => null, #default
	'from_name' => 'Название сайта',
	'from_email' => 'noreply@' . $_SERVER['HTTP_HOST'],
	'to_name' => 'ex3xeng',
	'to_email' => 'ex3xeng@gmail.com',
	'subject' => 'Тема письма',
	'link' => null, #back link in pa
	'body' => 'Это тестовое сообщение для проверки на отправку писем с сайта!',
	'isHTML' => true
];*/

function sm_mail($args) {
	$mail = new PHPMailer();

	//$mail->Subject = preg_replace("/&#?[a-z0-9]+;/i", "", $args['subject']);
	$mail->Subject = $args['subject'];
	if ($args['isHTML']) {
		$mail->isHTML(true);
		$mail->Body = get_email($args['subject'], $args['body'], $args['link']);
	} else {
		$mail->Body = $args['body'];
	}

	if (!empty($args['smtp']) && !empty($args['smtp']['smtp_host'])) {
		$mail->Host = $args['smtp']['smtp_host'];
		$mail->Port = $args['smtp']['smtp_port'];
		$mail->SMTPAuth = true;
		$mail->Username = $args['smtp']['smtp_username'];
		$mail->Password = $args['smtp']['smtp_password'];
		$mail->Mailer = "smtp";
	}
	if (!empty($args['from'])) {
		$mail->From = $args['from_email'];
		$mail->FromName = htmlDecode($args['from_name']);
		$mail->Sender = $args['from_email'];
	}

	$mail->Priority = 3;
	$mail->AddAddress($args['to_email'], $args['to_name']);

	if($mail->Send()) {
		$mail->ClearAddresses();
		$mail->ClearAttachments();
		return true;
	} else {
		return false;
	}
}