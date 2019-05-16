<?php define("_SMARTMEDIA", TRUE); session_start();
header('Content-Type: text/html; charset=utf-8');

	#ini_set('error_reporting', E_ALL);
	#ini_set('display_errors', 1);
	#ini_set('display_startup_errors', 1);
	
	ini_set('error_reporting', 0);
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	#http://cloudinary.com
	
require ("../config.php");
require ("../library/PHPMailer/PHPMailerAutoload.php");
require ("../library/library.php");

if (empty($_SESSION['auth'])) {

	if (!empty($_COOKIE['login']) && !empty($_COOKIE['password'])) {
		connect(HOST, USER, PASS, DB);
			$user = auth($_COOKIE['login'], $_COOKIE['password']);
		if (!empty($user['user_id'])) {
			$_SESSION['auth'] = $user;
			$_SESSION['auth']['csrf_token'] = get_csrf_token();
		}
	}

	if (empty($_SESSION['auth'])) {
		if (!empty($_GET['view'])) $_SESSION['HTTP_REFERER'] = $_SERVER['REQUEST_URI'];
		redirect("/login.php");
	}

}
if ($_SESSION['auth']['user_status'] != 1 && $_SESSION['auth']['user_status'] != 3 && $_SESSION['auth']['user_status'] != 4) {
	redirect("/");
}

$_GET["view"] = !empty($_GET["view"]) ? $_GET["view"] : 'dashboard';
$getView = isset($_GET["view"]) ? $_GET["view"] : "dashboard";
    
	connect(HOST, USER, PASS, DB);
	$config["settings"] = getSettings();
	$config["modules"] = getModules();
	$config["plugins"] = getPlugins();
	$config['from_name'] = $config['settings']->title->value;

	$config['pagenavi']['main-container'] = 'div';
	$config['pagenavi']['class-main-container'] = 'admin-navi';
	$config['pagenavi']['container'] = '';
	$config['pagenavi']['container-link'] = '';
	$config['pagenavi']['class-link'] = 'btn btn-sm btn-primary';
	$config['pagenavi']['container-link-active'] = 'a';
	$config['pagenavi']['class-link-active'] = 'btn btn-sm btn-info';
	$config['pagenavi']['config'] = 'admin';
	$notOrd = getOrdersNot();
	$notCal = getCallbackNot();

switch ($getView) {
	
	case ("settings"):
		if (!$config["modules"]->settings->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: settings</b></div>';
			redirect("?view=dashboard");
		}
		if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); updateSettings();}
		$objects = $config["settings"];
		$tmpl = $getView;
		$title = "Панель администратора - Настройки";
	break;
	
	case ("remove_setting"):
		if (!$config["modules"]->settings->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: settings</b></div>';
			redirect("?view=dashboard");
		}
		#DEMO
		if (is_demo()) demoRedirect();
		if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert();

		if (!empty($_GET['name'])) {
			removeSetting($_GET['name']);
		} else { 
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Неверные параметры для удаления!</div>';
			redirect("?view=settings");
		}
	break;
	
	case ("users"): 
		if (!$config["modules"]->users->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: users</b></div>';
			redirect("?view=dashboard");
		}
		
			// &order_by=user_id&field=user_email&value=ex3xeng ->                    WHERE `user_email` = 'ex3xeng' ORDER BY `user_id` DESC LIMIT 0, 10
			// &order_by=user_id&field=user_email,user_login&value=ex3xeng[&op=or] -> WHERE `user_email` = 'ex3xeng' and `user_login` = 'ex3xeng' ORDER BY `user_id` DESC LIMIT 0, 10
			// &order_by=user_id&field=user_email,user_login&value=ex3xeng,email ->   WHERE `user_email` = 'ex3xeng' and `user_login` = 'email' ORDER BY `user_id` DESC LIMIT 0, 10
			// &order_by=user_id&field=user_email&value=ex3xeng,email&op=or ->        WHERE `user_email` = 'ex3xeng' or `user_email` = 'email' ORDER BY `user_id` DESC LIMIT 0, 10
			// &order_by=user_id&field=user_email&value=ex3xeng,email&many ->         WHERE `user_email` IN ('ex3xeng', 'email') ORDER BY `user_id` DESC LIMIT 0, 10

		$objects = getObjects(['table'=>'users','function'=>'getUsers','order_by'=>['user_id'],'field'=>['user_email']]);
		$tmpl = $getView;
		$title = "Панель администратора - Пользователи";
	break;
	
	case ("add_user"):
		if (!$config["modules"]->users->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: users</b></div>';
			redirect("?view=dashboard");
		}
		if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); addUser();}
		$tmpl = "addUser";
		$title = "Панель администратора - Добавить пользователя";
	break;
	
	case ("update_user"):	
		if (!$config["modules"]->users->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: users</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET['user_id'])) {
			if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); updateUser(abs((int)$_GET['user_id']));}
			$object = getUser(abs((int)$_GET['user_id']));
		} else { 
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Неверные параметры для редактирования!</div>';
			redirect("?view=users");
		}
		if (empty($object)) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Ошибка!</strong> Пользователь не существует!</div>';
			redirect("?view=users");
		}
		$tmpl = "editUser";
		$title = "Панель администратора - Редактор пользователя";
	break;
	
	case ("remove_user"): 
		if (!$config["modules"]->users->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: users</b></div>';
			redirect("?view=dashboard");
		}
		#DEMO
		if (is_demo()) demoRedirect();
		if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert();
		
		if (!empty($_GET['user_id'])) {
			removeUser(abs((int)$_GET["user_id"]));
		} else { 
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Неверные параметры для редактирования!</div>';
			redirect("?view=users");			
		}	
	break;
	
	case ("modules"):
		if (!empty($_GET['action']) && !empty($_GET['module'])) {
			#DEMO
			if (is_demo()) demoRedirect();
			if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert();
			updateModules();
		}
		$objects = $config["modules"];
		$tmpl = "modules";
		$title = "Панель администратора - Системные модули";
	break;
	
	case ("plugins"):
		if (!$config["modules"]->plugins->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: plugins</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET['action']) && !empty($_GET['module']) && !empty($_GET['plugin'])) {
			#DEMO
			if (is_demo()) demoRedirect();
			if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert();
			updatePlugins();
		}
		$objects = $config["plugins"];
		$tmpl = "plugins";
		$title = "Панель администратора - Плагины";
	break;
	
	case ("mediafiles"):
		//добавление новой внеплановой default настройки
		/* print_array($config['settings']); //file_put_contents($config["settings_path"], $json, LOCK_EX);
		$new = [];
		foreach ($config['settings'] as $key => $item) {
			 if ($key == 'about_spa') {
				 $new['redirect'] = array ("name" => "redirect", "value" => 0, "type" => "boolean", "object" => "checkbox", "label" => "Открывать созданный объект после его добавления?", "remove" => 0, "tags" => 0, "default" => 0);
				 $new['checkdata'] = array ("name" => "checkdata", "value" => 0, "type" => "boolean", "object" => "checkbox", "label" => "Проверять заголовки и названия с ранее добавленными?", "remove" => 0, "tags" => 0, "default" => 0);
			 }
			 $new[$key] = $item;
		 }file_put_contents($config["settings_path"], json_encode($new), LOCK_EX);print_array($new);
		*/
		$objects = [];
		$tmpl = "mediafiles";
		$title = "Панель администратора - Медиафайлы";
	break;
	//$json?
	case ("upload_image"):
		if (is_post()) {if (is_demo()) demoRedirect(); uploadAjaxGalleryImage();}
		redirect("?view=dashboard");
	break;
	
	case ("remove_image"):
		if (is_post()) {if (is_demo()) demoRedirect(); removeImage();}
		redirect("?view=dashboard");
	break;

	case ("remove_sliderimg"):
		if (is_post()) {if (is_demo()) demoRedirect(); removeSlider();}
		redirect("?view=dashboard");
	break;
	
	case ("pages"):
		if (!$config["modules"]->pages->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: pages</b></div>';
			redirect("?view=dashboard");
		}
		$objects = sortObjectsTree(getObjectsTree('pages', 'page', true), 'page');
		$tmpl = "pages";
		$title = "Панель администратора - Страницы";
	break;
	
	case ("add_page"): //https://flops.ru/?refid=11858
		if (!$config["modules"]->pages->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: pages</b></div>';
			redirect("?view=dashboard");
		}
		if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); addPage();}
		$objects = sortObjectsTree(getObjectsTree('pages', 'page', true), 'page');
		$tmpl = "addPage";	
		$title = "Панель администратора - Добавить cтраницу";		
	break;
	
	case ("update_page"):
		if (!$config["modules"]->pages->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: pages</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET['page_id'])) {
			if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); updatePage(abs((int)$_GET['page_id']));}
			$object = getPageById(abs((int)$_GET['page_id']));
			$objects = sortObjectsTree(getObjectsTree('pages', 'page', true), 'page');
			
			if (empty($object)) {
				$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Ошибка!</strong> Запрашиваемая Вами страница не найдена!</div>';
				redirect("?view=pages");
			}

			if ($config["plugins"]->pages->pagepicture->active) {
				if (!empty($object['pagepicture']) && $object['pagepicture_path']) {
					//$pagepicture = '<span class="tooltip-demo"><img data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" rel="0" width="' . $config["settings"]->pages_pagepicture_imgsize->value[0] . '" height="' . $config["settings"]->pages_pagepicture_imgsize->value[1] . '" src="' . $object['pagepicture_path'] . 'thumb/' . $object['pagepicture'] . '" alt="' . $object['pagepicture'] . '"></span>';
					$pagepicture = '<span class="tooltip-demo"><img rel="0" data-id="' . $object['page_id'] . '" data-table="pages" data-prefix="page" data-img="pagepicture" data-path="pagepicture_path" data-remove="' . $object['pagepicture'] . '" data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" width="140" height="140" src="' . $object['pagepicture_path'] . 'thumb/' . $object['pagepicture'] . '"></span>';
				} else {
					$pagepicture = '<input id="pagepicture" type="file" name="pagepicture">';
				}
			}
			if ($config["plugins"]->pages->pagegallery->active) {
				$pagegallery = "";
				if (!empty($object['pagegallery']) && $object['pagegallery_path']) {
					$images = explode("|", $object['pagegallery']);
					foreach($images as $img) {
						$pagegallery .= '<span class="tooltip-demo"><img rel="1" data-id="' . $object['page_id'] . '" data-table="pages" data-prefix="page" data-img="pagegallery" data-path="pagegallery_path" data-remove="' . $img . '" data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" width="140" height="140" src="' . $object['pagegallery_path'] . 'thumb/' . $img . '"></span>';
					}
				}
			}	
		} else { 
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Неверные параметры для редактирования!</div>';
			redirect("?view=pages");
		}
		if (empty($object)) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Ошибка!</strong> Запрашиваемой Вами страницы не существует!</div>';
			redirect("?view=pages");
		}
		$tmpl = "editPage";
		$title = "Панель администратора - Редактор страницы";
	break;
	
	case ("remove_page"): 
		if (!$config["modules"]->pages->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: pages</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET["page_id"])) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); removeTreeObject(abs((int)$_GET["page_id"]), 'pages', ['page_id', 'page_parent'], ['страница', 'Страницы'], ['pagepicture_path', 'pagegallery_path']);}
		redirect("index.php?view=pages");
	break;
		
	case ("terms"):
		if (!$config["modules"]->terms->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: terms</b></div>';
			redirect("?view=dashboard");
		}
		$objects = sortObjectsTree(getObjectsTree('terms', 'term', true), 'term');
		$tmpl = "terms";
		$title = "Панель администратора - Рубрики";
	break;
	
	case ("add_term"):
		if (!$config["modules"]->terms->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: terms</b></div>';
			redirect("?view=dashboard");
		}
		if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); addTerm();}
		$objects = sortObjectsTree(getObjectsTree('terms', 'term', true), 'term');
		$tmpl = "addTerm";
		$title = "Панель администратора - Добавить рубрику";		
	break;
	
	case ("update_term"):
		if (!$config["modules"]->terms->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: terms</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET['term_id'])) {
			if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); updateTerm(abs((int)$_GET['term_id']));}
			$object = getTermById(abs((int)$_GET['term_id']));
			$objects = sortObjectsTree(getObjectsTree('terms', 'term', true), 'term');
			
			if (empty($object)) {
				$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Ошибка!</strong> Запрашиваемая Вами рубрика не найдена!</div>';
				redirect("?view=terms");
			}

			if ($config["plugins"]->terms->termpicture->active) {
				if (!empty($object['termpicture']) && $object['termpicture_path']) {
					//$pagepicture = '<span class="tooltip-demo"><img data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" rel="0" width="' . $config["settings"]->pages_pagepicture_imgsize->value[0] . '" height="' . $config["settings"]->pages_pagepicture_imgsize->value[1] . '" src="' . $object['pagepicture_path'] . 'thumb/' . $object['pagepicture'] . '" alt="' . $object['pagepicture'] . '"></span>';
					$termpicture = '<span class="tooltip-demo"><img rel="0" data-id="' . $object['term_id'] . '" data-table="terms" data-prefix="term" data-img="termpicture" data-path="termpicture_path" data-remove="' . $object['termpicture'] . '" data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" width="140" height="140" src="' . $object['termpicture_path'] . 'thumb/' . $object['termpicture'] . '"></span>';
				} else {
					$termpicture = '<input id="termpicture" type="file" name="termpicture">';
				}
			}
			if ($config["plugins"]->terms->termgallery->active) {
				$termgallery = "";
				if (!empty($object['termgallery']) && $object['termgallery_path']) {
					$images = explode("|", $object['termgallery']);
					foreach($images as $img) {
						$termgallery .= '<span class="tooltip-demo"><img rel="1" data-id="' . $object['term_id'] . '" data-table="terms" data-prefix="term" data-img="termgallery" data-path="termgallery_path" data-remove="' . $img . '" data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" width="140" height="140" src="' . $object['termgallery_path'] . 'thumb/' . $img . '"></span>';
					}
				}
			}	
		} else { 
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Неверные параметры для редактирования!</div>';
			redirect("?view=terms");
		}
		if (empty($object)) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Ошибка!</strong> Запрашиваемой Вами рубрики не существует!</div>';
			redirect("?view=terms");
		}
		$tmpl = "editTerm";
		$title = "Панель администратора - Редактор рубрики";
	break;
	
	case ("remove_term"): 
		if (!$config["modules"]->terms->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: terms</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET["term_id"])) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); removeTreeObject(abs((int)$_GET["term_id"]), 'terms', ['term_id', 'term_parent'], ['рубрика', 'Рубрики'], ['termpicture_path', 'termgallery_path']);}
		redirect("index.php?view=terms");
	break;
	
	case ("posts"):
		if (!$config["modules"]->posts->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: posts</b></div>';
			redirect("?view=dashboard");
		} //print_array($_GET, false); //echo $_GET['value'];
		//SELECT * FROM `project_posts` WHERE MONTH(`post_datecreate`) = 6 AND YEAR(`post_datecreate`) = 2016
		//SELECT DISTINCT DATE_FORMAT(`post_datecreate`, '%Y-%m') as post_datecreate FROM `project_posts`

		if (!empty($_GET['filer_date']) && $_GET['filer_date'] == 'true') {
			if (is_array($_GET['date'])) {
				$link = '?view=posts&order_by=post_id';
				foreach ($_GET['date'] as $kw => $dt) {
					if ($dt != -1) {
						if (!empty($_GET['term'][$kw]) && $_GET['term'][$kw] != '-1') {
							$link .= '&field=date,term_id&value=' . $dt . ',' . $_GET['term'][$kw];
						} else {
							$link .= '&field=date&value=' . $dt;
						}
					}
				}
				redirect($link);
			}
		}

		if (!empty($_GET['filer_visible']) && $_GET['filer_visible'] == 'true') {
			if (is_array($_GET['field'])) {
				$link = '?view=posts&order_by=post_id&field=post_visible';
				if (!empty($_GET['value'][1]) && $_GET['value'][1] != -1) {
					$link .= ',term_id&value=' . $_GET['value'][0] . ',' . $_GET['value'][1];
				} else {
					$link .= '&value=' . $_GET['value'][0];
				}
				redirect($link);
			}
		}

		$datecreate = buildDateForSort(getDateForSort('post', 'datecreate'), 'post', 'datecreate');
		$dateupdate = buildDateForSort(getDateForSort('post', 'dateupdate'), 'post', 'dateupdate');
		$datepublic = buildDateForSort(getDateForSort('post', 'datepublic'), 'post', 'datepublic');

		$obj = getObjectsSort('term');
		
		if (is_post()) {
			if (!empty($_POST['action'])) {
				if (empty($_POST['post'])) {
					$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Выберите хотя бы один объект!</div>';
					redirect("?view=posts");
				}
				switch($_POST['action']) {
					case('trash'): removeObjectsWithRelationships($_POST['post'], 'post'); break;
					case('public'): changeObjectsVision($_POST['post'], true, 'post'); break;
					case('hide'): changeObjectsVision($_POST['post'], false, 'post'); break;
					default:
						$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Выберите хотя бы одно действие!</div>';
						redirect("?view=posts");
				}
			}
		}
		
		/*
			SELECT 
				COUNT(DISTINCT post.`post_id`) as count
			FROM `project_posts` post 
				LEFT JOIN `project_posts_relationships` relationship ON relationship.`post_id` = post.`post_id` 
				LEFT JOIN `project_terms` term ON relationship.`term_id` = term.`term_id` 
			WHERE term.`term_fullslug` = 'rubrika_3/rubrika_4'
		
			SELECT 
				DISTINCT post.*, 
				group_concat(term.`term_title` SEPARATOR '|') as objectNames, 
				group_concat(term.`term_id` SEPARATOR '|') as objectIds 
			FROM `project_posts` post 
				LEFT JOIN `project_posts_relationships` relationship ON relationship.`post_id` = post.`post_id` 
				LEFT JOIN `project_terms` term ON relationship.`term_id` = term.`term_id` 
			WHERE term.`term_fullslug` = 'rubrika_3/rubrika_4'
			GROUP BY 1 DESC LIMIT 0, 50
		*/
			// &order_by=post_id&field=post_title&value=title1 ->                       WHERE `user_email` = 'ex3xeng' ORDER BY `user_id` DESC LIMIT 0, 10
			// &order_by=post_id&field=post_title,post_text&value=sometext[&op=or] ->   WHERE `user_email` = 'ex3xeng' and `user_login` = 'ex3xeng' ORDER BY `user_id` DESC LIMIT 0, 10
			// &order_by=post_id&field=post_title,post_text&value=title1,sometext ->    WHERE `user_email` = 'ex3xeng' and `user_login` = 'email' ORDER BY `user_id` DESC LIMIT 0, 10
			// &order_by=post_id&field=post_title&value=title1,sometext&op=or ->        WHERE `user_email` = 'ex3xeng' or `user_email` = 'email' ORDER BY `user_id` DESC LIMIT 0, 10
			// &order_by=post_id&field=post_title&value=title1,sometext&many ->         WHERE `user_email` IN ('ex3xeng', 'email') ORDER BY `user_id` DESC LIMIT 0, 10
			
			//&order_by=post_id&field=term_fullslug&value=rubrika_3/rubrika_4
			
		$objects = getObjects([
			'table'=>'posts',
			'function'=>'getObjectsWithRelationships',
			'order_by'=>[
						'post_id'
						],
			'field'=>[
						'date',
						'post_title',
						'term_id',
						'term_slug',
						'term_fullslug',
						'post_text',
						'post_author',
						'post_visible',
						'post_datecreate',
						'post_datepublic',
						'post_dateupdate'
					],
			'prefix'=>'post',
			'relationship'=>'terms',
			'relationship_prefix'=>'term'
		]);
		$tmpl = "posts";
		$title = "Панель администратора - Записи";
	break;

	case ("add_post"):
		if (!$config["modules"]->posts->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: posts</b></div>';
			redirect("?view=dashboard");
		}
		if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); addPost();}
		$objects = ($config["modules"]->terms->active) ? sortObjectsTree(getObjectsTree('terms', 'term', true), 'term') : [];
		$tmpl = "addPost";
		$title = "Панель администратора - Добавить запись";		
	break;
	
	case ("update_post"):
		if (!$config["modules"]->posts->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: posts</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET['post_id'])) {
			if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); updatePost(abs((int)$_GET['post_id']));}
			//$object = getObjectById(abs((int)$_GET['post_id']), 'post');
			$objects = ($config["modules"]->terms->active) ? sortObjectsTree(getObjectsTree('terms', 'term', true), 'term') : [];
			
			$_GET['order_by'] = "post_id";
			$_GET['field'] = "post_id";
			$_GET['value'] = abs((int)$_GET['post_id']);

			$object = getObjects([
				'table'=>'posts',
				'function'=>'getObjectsWithRelationships',
				'order_by'=>[
							'post_id'
							],
				'field'=>[
							'post_id'
						],
				'prefix'=>'post',
				'relationship'=>'terms',
				'relationship_prefix'=>'term'
			]);

			$object = !empty($object[0]) ? $object[0] : '';
			if (empty($object)) {
				$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Ошибка!</strong> Запрашиваемая Вами запись не найдена!</div>';
				redirect("?view=posts");
			}
			$object['objectIds'] = !empty($object['objectIds']) ? explode("|", $object['objectIds']) : [];
			if ($config["plugins"]->posts->postpicture->active) {
				if (!empty($object['postpicture']) && $object['postpicture_path']) {
					//$postpicture = '<span class="tooltip-demo"><img data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" rel="0" width="' . $config["settings"]->pages_pagepicture_imgsize->value[0] . '" height="' . $config["settings"]->pages_pagepicture_imgsize->value[1] . '" src="' . $object['pagepicture_path'] . 'thumb/' . $object['pagepicture'] . '" alt="' . $object['pagepicture'] . '"></span>';
					$postpicture = '<span class="tooltip-demo"><img rel="0" data-id="' . $object['post_id'] . '" data-table="posts" data-prefix="post" data-img="postpicture" data-path="postpicture_path" data-remove="' . $object['postpicture'] . '" data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" width="140" height="140" src="' . $object['postpicture_path'] . 'thumb/' . $object['postpicture'] . '"></span>';
				} else {
					$postpicture = '<input id="postpicture" type="file" name="postpicture">';
				}
			}
			if ($config["plugins"]->posts->postgallery->active) {
				$postgallery = "";
				if (!empty($object['postgallery']) && $object['postgallery_path']) {
					$images = explode("|", $object['postgallery']);
					foreach($images as $img) {
						$postgallery .= '<span class="tooltip-demo"><img rel="1" data-id="' . $object['post_id'] . '" data-table="posts" data-prefix="post" data-img="postgallery" data-path="postgallery_path" data-remove="' . $img . '" data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" width="140" height="140" src="' . $object['postgallery_path'] . 'thumb/' . $img . '"></span>';
					}
				}
			}	
		} else { 
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Неверные параметры для редактирования!</div>';
			redirect("?view=posts");
		}
		$tmpl = "editPost";
		$title = "Панель администратора - Редактор записи";
	break;
	
	case ("remove_post"): 
		if (!$config["modules"]->posts->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: posts</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET["post_id"])) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); removeObjectById(abs((int)$_GET["post_id"]), 'post', ['запись', 'записи']);}
		redirect("index.php?view=posts");
	break;
	
	case("auto_complete"):
		if (is_post()) { 
			if ($_POST['action'] == 'simular_product') { 
				getSimularProductByArticle($_POST['keyword'], true);
			}
			if ($_POST['action'] == 'menu' && $_POST['mode'] == 'page') { 
				getObjecPageForMenu($_POST['request'], $_POST['perpage'], true);
			}
			if ($_POST['action'] == 'menu' && $_POST['mode'] == 'term') {
				getObjecTermForMenu($_POST['request'], $_POST['perpage'], true);
			}
			if ($_POST['action'] == 'menu' && $_POST['mode'] == 'post') {
				getObjecPostForMenu($_POST['request'], $_POST['perpage'], true);
			}
			if ($_POST['action'] == 'menu' && $_POST['mode'] == 'cat') {
				getObjecCatForMenu($_POST['request'], $_POST['perpage'], true);
			}
			if ($_POST['action'] == 'menu' && $_POST['mode'] == 'product') {
				getObjecProductForMenu($_POST['request'], $_POST['perpage'], true);
			}
		}
		//header('Content-Type: application/json');
		//die(json_encode([1=>['product_id'=>'1', 'article'=>'success1'],2=>['product_id'=>'2', 'article'=>'success2'],3=>['product_id'=>'3', 'article'=>'success3']]));
	break;

	case("checkdata"):
		if (is_post()) {checkSimularData();}
	break;
	
	case ("menus"):
		if (!$config["modules"]->menus->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: menus</b></div>';
			redirect("?view=dashboard");
		}
		$objects = getObjects(['table'=>'menus','function'=>'getMenus','order_by'=>['menu_id'],'field'=>['menu_name']]);
		$tmpl = "menus";
		$title = "Панель администратора - Меню";
	break;
	
	case ("create_menu"):
		if (!$config["modules"]->menus->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: menus</b></div>';
			redirect("?view=dashboard");
		}
		if (is_post()) {if (is_demo()) demoRedirect(true); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(true); addMenu();}
		
		$terms_objects = ($config["modules"]->terms->active) ? sortObjectsTree(getObjectsTree('terms', 'term', true), 'term') : [];
		$pages_objects = ($config["modules"]->pages->active) ? sortObjectsTree(getObjectsTree('pages', 'page', true), 'page') : [];
		$cats_objects = ($config["modules"]->cats->active) ? sortObjectsTree(getObjectsTree('cats', 'cat', true), 'cat') : [];

		$menu_objects = [];
		$menu_item = [];
		$menu_item['menu_id'] = '';
		$menu_item['menu_title'] = '';
		$menu_item['menu_name'] = '';
		$menu_item['menu_items'] = 0;
		//print_array($menu_item);
		$tmpl = "addMenu";
		$title = "Панель администратора - Конструктор меню";
		//http://www.jqueryscript.net/other/jQuery-Plugin-To-Sort-Nested-Lists-Using-Drag-Drop-nestedSortable.html
	break;

	case ("update_menu"): //print_array(unserialize('a:1:{s:3:"img";s:23:"/files/uploads/menu.jpg";}'));
		if (!$config["modules"]->menus->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: menus</b></div>';
			redirect("?view=dashboard");
		}
		if (is_post()) {if (is_demo()) demoRedirect(true); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(true); addMenu();}
		if (!empty($_GET['menu_id'])) {
			$menu_objects = getMenuByID($_GET['menu_id']);
			$menu_item = getMenuCount($_GET['menu_id']);
		}
		if (empty($menu_objects)) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Ошибка!</strong> Запрашиваемое Вами меню не найдено!</div>';
			redirect("?view=menus");
		}
		$terms_objects = ($config["modules"]->terms->active) ? sortObjectsTree(getObjectsTree('terms', 'term', true), 'term') : [];
		$pages_objects = ($config["modules"]->pages->active) ? sortObjectsTree(getObjectsTree('pages', 'page', true), 'page') : [];
		$cats_objects = ($config["modules"]->cats->active) ? sortObjectsTree(getObjectsTree('cats', 'cat', true), 'cat') : [];

		$tmpl = "addMenu";
		$title = "Панель администратора - Конструктор меню";
		/*
			тоже самое добавление только перед этим удалить старое меню, как то так =)
		*/ //print_array($menu_objects, false); print_array($menu_item);
		break;
	
	case ("remove_menu"): 
		if (!$config["modules"]->menus->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: menus</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET["menu_id"])) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); removeMenu(abs((int)$_GET["menu_id"]));}
		redirect("index.php?view=menus");
	break;
	
	case ("categories"):
		if (!$config["modules"]->cats->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: cats</b></div>';
			redirect("?view=dashboard");
		}
		$objects = sortObjectsTree(getObjectsTree('cats', 'cat', true), 'cat');
		$tmpl = "cats";
		$title = "Панель администратора - Категории";
	break;
	
	case ("add_cat"):
		if (!$config["modules"]->cats->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: cats</b></div>';
			redirect("?view=dashboard");
		}
		if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); addCat();}
		$objects = sortObjectsTree(getObjectsTree('cats', 'cat', true), 'cat');
		$tmpl = "addCat";
		$title = "Панель администратора - Добавить категорию";		
	break;
	
	case ("update_cat"):
		if (!$config["modules"]->cats->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: cats</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET['cat_id'])) {
			if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); updateCat(abs((int)$_GET['cat_id']));}
			$object = getCatById(abs((int)$_GET['cat_id']));
			$objects = sortObjectsTree(getObjectsTree('cats', 'cat', true), 'cat');
			
			if (empty($object)) {
				$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Ошибка!</strong> Запрашиваемая Вами категория не найдена!</div>';
				redirect("?view=cats");
			}

			if ($config["plugins"]->cats->catpicture->active) {
				if (!empty($object['catpicture']) && $object['catpicture_path']) {
					//$pagepicture = '<span class="tooltip-demo"><img data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" rel="0" width="' . $config["settings"]->pages_pagepicture_imgsize->value[0] . '" height="' . $config["settings"]->pages_pagepicture_imgsize->value[1] . '" src="' . $object['pagepicture_path'] . 'thumb/' . $object['pagepicture'] . '" alt="' . $object['pagepicture'] . '"></span>';
					$catpicture = '<span class="tooltip-demo"><img rel="0" data-id="' . $object['cat_id'] . '" data-table="cats" data-prefix="cat" data-img="catpicture" data-path="catpicture_path" data-remove="' . $object['catpicture'] . '" data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" width="140" height="140" src="' . $object['catpicture_path'] . 'thumb/' . $object['catpicture'] . '"></span>';
				} else {
					$catpicture = '<input id="catpicture" type="file" name="catpicture">';
				}
			}
			if ($config["plugins"]->cats->catgallery->active) {
				$catgallery = "";
				if (!empty($object['catgallery']) && $object['catgallery_path']) {
					$images = explode("|", $object['catgallery']);
					foreach($images as $img) {
						$catgallery .= '<span class="tooltip-demo"><img rel="1" data-id="' . $object['cat_id'] . '" data-table="cats" data-prefix="cat" data-img="catgallery" data-path="catgallery_path" data-remove="' . $img . '" data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" width="140" height="140" src="' . $object['catgallery_path'] . 'thumb/' . $img . '"></span>';
					}
				}
			}	
		} else { 
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Неверные параметры для редактирования!</div>';
			redirect("?view=cats");
		}
		if (empty($object)) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Ошибка!</strong> Запрашиваемой Вами категории не существует!</div>';
			redirect("?view=cats");
		}
		$tmpl = "editCat";
		$title = "Панель администратора - Редактор категории";
	break;
	
	case ("remove_cat"): 
		if (!$config["modules"]->cats->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: cats</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET["cat_id"])) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); removeTreeObject(abs((int)$_GET["cat_id"]), 'cats', ['cat_id', 'cat_parent'], ['категория', 'Категории'], ['catpicture_path', 'catgallery_path']);}
		redirect("index.php?view=cats");
	break;
	
	case ("products"):
		if (!$config["modules"]->products->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: products</b></div>';
			redirect("?view=dashboard");
		}
		
			// &order_by=product_id&field=post_title&value=title1 ->                       WHERE `user_email` = 'ex3xeng' ORDER BY `user_id` DESC LIMIT 0, 10
			// &order_by=product_id&field=post_title,post_text&value=sometext[&op=or] ->   WHERE `user_email` = 'ex3xeng' and `user_login` = 'ex3xeng' ORDER BY `user_id` DESC LIMIT 0, 10
			// &order_by=product_id&field=post_title,post_text&value=title1,sometext ->    WHERE `user_email` = 'ex3xeng' and `user_login` = 'email' ORDER BY `user_id` DESC LIMIT 0, 10
			// &order_by=product_id&field=post_title&value=title1,sometext&op=or ->        WHERE `user_email` = 'ex3xeng' or `user_email` = 'email' ORDER BY `user_id` DESC LIMIT 0, 10
			// &order_by=product_id&field=post_title&value=title1,sometext&many ->         WHERE `user_email` IN ('ex3xeng', 'email') ORDER BY `user_id` DESC LIMIT 0, 10
			//&order_by=product_id&field=term_fullslug&value=rubrika_3/rubrika_4
			
		$objects = getObjects([
			'table'=>'products',
			'function'=>'getObjectsWithRelationships',
			'order_by'=>[
						'product_id'
						],
			'field'=>[
						'product_title',
						'cat_id',
						'cat_slug',
						'cat_fullslug',
						'product_text',
						'product_author'
					],
			'prefix'=>'product',
			'relationship'=>'cats',
			'relationship_prefix'=>'cat'
		]);
		$tmpl = "products";
		$title = "Панель администратора - Товары";
	break;

	case ("add_product"):
		if (!$config["modules"]->products->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: products</b></div>';
			redirect("?view=dashboard");
		}
		if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); addProduct();}
		$objects = ($config["modules"]->cats->active) ? sortObjectsTree(getObjectsTree('cats', 'cat', true), 'cat') : [];
		$tmpl = "addProduct";
		$title = "Панель администратора - Добавить товар";		
	break;
	
	case ("update_product"):
		if (!$config["modules"]->products->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: products</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET['product_id'])) {
			if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); updateProduct(abs((int)$_GET['product_id']));}
			//$object = getObjectById(abs((int)$_GET['post_id']), 'post');
			$objects = ($config["modules"]->cats->active) ? sortObjectsTree(getObjectsTree('cats', 'cat', true), 'cat') : [];
			
			$_GET['order_by'] = "product_id";
			$_GET['field'] = "product_id";
			$_GET['value'] = abs((int)$_GET['product_id']);

			$object = getObjects([
				'table'=>'products',
				'function'=>'getObjectsWithRelationships',
				'order_by'=>[
							'product_id'
							],
				'field'=>[
							'product_id'
						],
				'prefix'=>'product',
				'relationship'=>'cats',
				'relationship_prefix'=>'cat'
			]);

			$object = !empty($object[0]) ? $object[0] : '';
			if (empty($object)) {
				$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Ошибка!</strong> Запрашиваемый Вами товар не найден!</div>';
				redirect("?view=products");
			}
			$object['objectIds'] = !empty($object['objectIds']) ? explode("|", $object['objectIds']) : [];
			if ($config["plugins"]->products->productpicture->active) {
				if (!empty($object['productpicture']) && $object['productpicture_path']) {
					//$pagepicture = '<span class="tooltip-demo"><img data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" rel="0" width="' . $config["settings"]->pages_pagepicture_imgsize->value[0] . '" height="' . $config["settings"]->pages_pagepicture_imgsize->value[1] . '" src="' . $object['pagepicture_path'] . 'thumb/' . $object['pagepicture'] . '" alt="' . $object['pagepicture'] . '"></span>';
					$productpicture = '<span class="tooltip-demo"><img rel="0" data-id="' . $object['product_id'] . '" data-table="products" data-prefix="product" data-img="productpicture" data-path="productpicture_path" data-remove="' . $object['productpicture'] . '" data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" width="140" height="140" src="' . $object['productpicture_path'] . 'thumb/' . $object['productpicture'] . '"></span>';
				} else {
					$productpicture = '<input id="productpicture" type="file" name="productpicture">';
				}
			}
			if ($config["plugins"]->products->productgallery->active) {
				$productgallery = "";
				if (!empty($object['productgallery']) && $object['productgallery_path']) {
					$images = explode("|", $object['productgallery']);
					foreach($images as $img) {
						$productgallery .= '<span class="tooltip-demo"><img rel="1" data-id="' . $object['product_id'] . '" data-table="products" data-prefix="product" data-img="productgallery" data-path="productgallery_path" data-remove="' . $img . '" data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" width="140" height="140" src="' . $object['productgallery_path'] . 'thumb/' . $img . '"></span>';
					}
				}
			}
			$object['product_simular'] = !empty($object['product_simular']) ? getSimulars(unserialize($object['product_simular']), 'product') : [];
		} else { 
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Неверные параметры для редактирования!</div>';
			redirect("?view=products");
		}
		$tmpl = "editProduct";
		$title = "Панель администратора - Редактор товара";
	break;
	
	case ("remove_product"): 
		if (!$config["modules"]->products->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: products</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET["product_id"])) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); removeObjectById(abs((int)$_GET["product_id"]), 'product', ['товар', 'товара']);}
		redirect("index.php?view=products");
	break;
	
	case ("sliders"):
		if (!$config["modules"]->sliders->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: sliders</b></div>';
			redirect("?view=dashboard");
		}
		
		$objects = getObjects(['table'=>'sliders','function'=>'getUsers','order_by'=>['slider_id'],'field'=>['slider_callname']]);
		$tmpl = $getView;
		$title = "Панель администратора - Слайдеры";
	break;
	
	case ("add_slider"):
		if (!$config["modules"]->sliders->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: sliders</b></div>';
			redirect("?view=dashboard");
		}
		if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); addSlider();}

		$tmpl = "addSlider";	
		$title = "Панель администратора - Добавить слайдер";		
	break;

	case ("update_slider"): //print_array($_FILES,false); print_array($_POST);
		if (!$config["modules"]->sliders->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: sliders</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET['slider_id'])) {
			if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); updateSlider(abs((int)$_GET['slider_id']));}
			$object = getSliderById(abs((int)$_GET['slider_id']));

			if (empty($object)) {
				$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Ошибка!</strong> Запрашиваемый Вами слайдер не найден!</div>';
				redirect("?view=sliders");
			}
			$object['slider_sliders'] = !empty($object['slider_sliders']) ? unserialize($object['slider_sliders']) : [];
		} else { 
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Неверные параметры для редактирования!</div>';
			redirect("?view=sliders");
		}
		$tmpl = "editSlider";
		$title = "Панель администратора - Редактор слайдера";
	break;

	case ("remove_slider"):
		if (!$config["modules"]->sliders->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: sliders</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET["slider_id"])) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); removeObjectById(abs((int)$_GET["slider_id"]), 'slider', ['слайдер', 'слайдера']);}
		redirect("index.php?view=sliders");
	break;

	case ("delivery"):
		if (!$config["modules"]->delivery->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: delivery</b></div>';
			redirect("?view=dashboard");
		}

		$objects = getObjects(['table'=>'delivery','function'=>'getUsers','order_by'=>['delivery_id'],'field'=>['delivery_name']]);
		$tmpl = $getView;
		$title = "Панель администратора - Способы доставки";
	break;

	case ("add_delivery"):
		if (!$config["modules"]->delivery->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: delivery</b></div>';
			redirect("?view=dashboard");
		}
		if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); addDelivery();}

		$tmpl = "addDelivery";
		$title = "Панель администратора - Добавить новый способ доставки";
	break;

	case ("update_delivery"):
		if (!$config["modules"]->delivery->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: delivery</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET['delivery_id'])) {
			if (is_post()) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); updateDelivery(abs((int)$_GET['delivery_id']));}
			$object = getDeliveryById(abs((int)$_GET['delivery_id']));

			if (empty($object)) {
				$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Ошибка!</strong> Запрашиваемый Вами способ доставки не найден!</div>';
				redirect("?view=delivery");
			}
		} else {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Неверные параметры для редактирования!</div>';
			redirect("?view=delivery");
		}
		$tmpl = "editDelivery";
		$title = "Панель администратора - Редактор способа доставки";
	break;

	case ("remove_delivery"):
		if (!$config["modules"]->delivery->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: delivery</b></div>';
			redirect("?view=dashboard");
		}
		if (!empty($_GET["delivery_id"])) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); removeObjectById(abs((int)$_GET["delivery_id"]), 'delivery', ['способ доставки', 'способа доставки']);}
		redirect("index.php?view=delivery");
	break;

	case ("orders"):
		if (!$config["modules"]->orders->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: orders</b></div>';
			redirect("?view=dashboard");
		}

		$objects = getObjects(['table'=>'orders','function'=>'getOrders','order_by'=>['order_id'],'field'=>['order_id']]);
		$tmpl = $getView;
		$title = "Панель администратора - Заказы";
	break;

	case ("remove_order"):
		if (!$config["modules"]->orders->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: orders</b></div>';
			redirect("?view=dashboard");
		}

		if (!empty($_GET["order_id"])) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); removeObjectById(abs((int)$_GET["order_id"]), 'order', ['заказ', 'заказа']);}
		redirect("index.php?view=orders");
	break;

	case ("proof_order"):
		if (!$config["modules"]->orders->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: orders</b></div>';
			redirect("?view=dashboard");
		}

		if (!empty($_GET["order_id"])) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); proofOrder(abs((int)$_GET["order_id"]));}
		redirect("index.php?view=orders");
	break;

	case ("view_order"):
		if (!$config["modules"]->orders->active) {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Запрашиваемый Вами модуль отключен!<br>Вы можете попробовать активировать его: <b>Система -> Модули -> #ID: orders</b></div>';
			redirect("?view=dashboard");
		}

		if (!empty($_GET['order_id'])) {
			$object = getOrderById(abs((int)$_GET['order_id']));

			if (empty($object)) {
				$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Ошибка!</strong> Запрашиваемый Вами заказ не найден!</div>';
				redirect("?view=orders");
			}
		} else {
			$_SESSION['answer'] = '<div class="alert alert-danger"><strong>Системная ошибка!</strong> Неверные параметры!</div>';
			redirect("?view=orders");
		}
		$tmpl = "viewOrder";
		$title = "Панель администратора - Просмотр заказа";
		//print_array($object);
	break;

	case ("feedback"):
		if (!empty($_GET["id"])) {
			$object = getFeedById(abs((int)$_GET['id']));
			$tmpl = $getView;
			$title = "Панель администратора - Заявки";
			if (empty($object)) redirect("index.php?view=dashboard");
		} else redirect("index.php?view=dashboard");
	break;

	case ("remove_feedback"):
		if (!empty($_GET["feedback_id"])) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); removeFeedback(abs((int)$_GET["feedback_id"]));}
		redirect("index.php?view=dashboard");
	break;

	case ("proof_feedback"):
		if (!empty($_GET["feedback_id"])) {if (is_demo()) demoRedirect(); if (!check_csrf_token($_GET['csrf_token'])) get_csrf_alert(); proofFeedback(abs((int)$_GET["feedback_id"]));}
		redirect("index.php?view=dashboard");
	break;
	
	default:
		$tmpl = "dashboard";
		$title = "Панель администратора";
		$feedback = [];
		//$objects_cal = getObjects(['table'=>'callback','function'=>'getUsers','order_by'=>['call_id'],'field'=>['call_id']]);
		$_GET['field'] = 'order_proof'; $_GET['value'] = '0';
		$objects_ord = getObjects(['table'=>'orders','function'=>'getOrders','order_by'=>['order_id'],'field'=>['order_proof']]);
		$objects_cal = getObjects(['table'=>'callback','function'=>'getUsers','order_by'=>['call_id'],'field'=>['call_id']]);
}	close_connect($connect);

require "modules/inc/v_header.php";
    include("modules/v_{$tmpl}.php");
require "modules/inc/v_footer.php";
//http://sparqproductions.com/images/kcfinder/files/Font%20Awesome%20Cheatsheet.pdf
//http://cloudinary.com