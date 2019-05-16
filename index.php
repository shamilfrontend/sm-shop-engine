<?php 

	define("_SMARTMEDIA", TRUE); 
	session_start(); 
	
	header('Content-Type: text/html; charset=utf-8');

	require ("config.php");
	require ("library/PHPMailer/PHPMailerAutoload.php");
	require ("library/library.php");
	
// print_array($_SESSION);

	$tmpl = '';
	$dummy = '';
	$sm_mail = [];
	$activeLink = [];
	
	display_errors(false);
	$dummy = get_route();
		$controller = $dummy['controller'];
		$action = $dummy['action'];
	
	$config["settings"] = getSettings();
	
	$sm_mail = [
		'smtp' => [
			'smtp_host' => null, #'ssl://smtp.yandex.ru'
			'smtp_port' => null, #465
			'smtp_username' => null, #'ex3xeng@yandex.ru'
			'smtp_password' => null
		],
		'from' => 'default',
		'from_name' => $config['settings']->title->value,
		'from_email' => 'noreply@' . $_SERVER['HTTP_HOST'],
		'to_name' => 'ex3xeng',
		'to_email' => 'ex3xeng@yandex.ru',
		'subject' => 'Тестовое письмо для проверки',
		'link' => null,
		'body' => 'Это тестовое сообщение для проверки на отправку писем с сайта!',
		'isHTML' => true
	];
	
	$config['pagenavi']['main-container'] = 'div';
	$config['pagenavi']['class-main-container'] = 'page_link';
	$config['pagenavi']['container'] = '';
	$config['pagenavi']['container-link'] = '';
	$config['pagenavi']['container-link-active'] = 'a';
	$config['pagenavi']['class-link-active'] = 'act_page';

	$controllers = ['callback', 'shopbag', 'search','index','page','term','post','category','product'];

	if (!in_array($controller, $controllers)) {
		header("HTTP/1.0 404 Not Found");
		$tmpl = '404'; $title = 'Ошибка 404! Страница не найдена!';
		$controller = $tmpl;
	}
	
	connect(HOST, USER, PASS, DB);
	
	$menu['main-sidebar'] = getMenu('menu-main-sidebar');
	$menu['main-header'] = getMenu('menu-main-header');

switch($controller) {
	case('callback'):
		if (is_post()) {
			callback();
		} else {
			header("HTTP/1.0 403 Forbidden");
			$tmpl = '403'; $title = 'Ошибка 403! Доступ запрещен!';
		}
	break;

	case('shopbag'):
		if (!empty($_GET['action'])) {
			if ($_GET['action'] == 'clear') {
				shopbagClear();
			}
			if ($_GET['action'] == 'counted') {
				if (is_post()) {
					shopbagCounted();
				}
			}
			if ($_GET['action'] == 'order') {
				if (is_post()) {
					shopbagOrder();
				}
			}
			if ($_GET['action'] == 'append' && !empty($_GET['product_id'])) {
				shopbag();
			}
			if ($_GET['action'] == 'remove' && !empty($_GET['product_id'])) {
				shopbagRemove();
			}
		}
		$title = $config["settings"]->title->value . '&nbsp;&raquo;&nbsp;Корзина';
		$keywords = $config["settings"]->keywords->value;
		$description = $config["settings"]->description->value;
		$tmpl = $controller;
	break;

	case('auto_complete'):
		$action = (is_post && !empty($_POST['action'])) ? $_POST['action'] : 'default';
		$action = 'default'; // 403
		switch ($action) {
			case('terms'):
				getPostsInTerm(true);
			break;
			
			default:
				header("HTTP/1.0 403 Forbidden");
				$tmpl = '403'; $title = 'Ошибка 403! Доступ запрещен!';
		}
	break; 
	
	case('search'):
		$query = !empty($_GET['query']) ? urldecode($_GET['query']) : '';
		if (empty($query) || mb_strlen($query) < 3) {
			header("HTTP/1.0 404 Not Found");
			$tmpl = '404'; $title = 'Ошибка 404! Страница не найдена!';
		} else {
			$_GET['field'] = 'product_title,product_article';
			$_GET['value'] = $query;
			$_GET['op'] = 'or';
			$_GET['perpage'] = !empty($_GET['perpage']) ? $_GET['perpage'] : $config["settings"]->perpage->value;
			$objects = getObjects([
				'table'=>'products',
				'function'=>'getObjectsWithRelationships',
				'order_by'=>['product_id','product_pricewithdiscount','product_title','product_article'],
				'field'=>['product_title','product_article'],
				'prefix'=>'product',
				'relationship'=>'cats',
				'relationship_prefix'=>'cat'
			]);
			$tmpl = $controller;
			$title = $config["settings"]->title->value . '&nbsp;&raquo;&nbsp;' . 'Результаты поиска по запросу: ' . $query;
		}
	break;
	
	case('index'):
		$title = $config["settings"]->title->value . '&nbsp;&raquo;&nbsp;Главная';
		$keywords = $config["settings"]->keywords->value;
		$description = $config["settings"]->description->value;
		$tmpl = $controller;
		$slider = getSliderByName("homeslider");
		
		$_GET['field'] = "product_visible"; $_GET['value'] = '1';
		$_GET['perpage'] = $config["settings"]->top->value;
		$objects_top = getObjects([
			'table'=>'products',
			'function'=>'getObjectsWithRelationships',
			'order_by'=>['product_sales'],
			'field'=>['product_visible','product_sales'],
			'prefix'=>'product',
			'relationship'=>'cats',
			'relationship_prefix'=>'cat'
		]);
		$_GET['perpage'] = $config["settings"]->new->value;
		$objects_new = getObjects([
			'table'=>'products',
			'function'=>'getObjectsWithRelationships',
			'order_by'=>['product_id'],
			'field'=>['product_visible'],
			'prefix'=>'product',
			'relationship'=>'cats',
			'relationship_prefix'=>'cat'
		]);
	break;
	
	case('page'):
		if (!empty($action)) {
			$object = getPageBySlug($action);
			if (!empty($object)) {
				if (!empty($object['pagegallery_path']) && !empty($object['pagegallery'])) {
					$object['pagegallery'] = explode('|', $object['pagegallery']);
				}
				$title = !empty($object['post_title']) ? $config["settings"]->title->value . '&nbsp;&raquo;&nbsp;'. $object['post_title'] : $config["settings"]->title->value;
				$keywords = !empty($object['post_keywords']) ? $object['post_keywords'] : '';
				$description = !empty($object['post_description']) ? $object['post_description'] : '';
				$tmpl = $controller;
				$breadCrumbs = getBreadCrumbs('page', $object);
				$_GET['field'] = "product_visible"; $_GET['value'] = '1';
				$_GET['perpage'] = $config["settings"]->new->value;
				$objects_new = getObjects([
					'table'=>'products',
					'function'=>'getObjectsWithRelationships',
					'order_by'=>['product_id'],
					'field'=>['product_visible'],
					'prefix'=>'product',
					'relationship'=>'cats',
					'relationship_prefix'=>'cat'
				]);
			}		
		}
		
		if (empty($object)) {
			header("HTTP/1.0 404 Not Found");
			$tmpl = '404'; $title = 'Ошибка 404! Страница не найдена!';
		}
	break;
	
	case('term'):	
		if (!empty($action)) {
			$object = getTermBySlug($action);
			
			if (empty($object) || !is_array($object)) {
				header("HTTP/1.0 404 Not Found");
				$tmpl = '404'; $title = 'Ошибка 404! Страница не найдена!';
			} 
		}
		if ($tmpl != '404') {
			$object = !empty($object) ? $object : '';
			
			$_GET['field'] = "product_visible"; $_GET['value'] = '1';
			$_GET['perpage'] = !empty($_GET['perpage']) ? $_GET['perpage'] : $config["settings"]->top->value;
			$objects_top = getObjects([
				'table'=>'products',
				'function'=>'getObjectsWithRelationships',
				'order_by'=>['product_sales'],
				'field'=>['product_visible','product_sales'],
				'prefix'=>'product',
				'relationship'=>'cats',
				'relationship_prefix'=>'cat'
			]);

			$_GET['field'] = "term_fullslug,post_visible"; $_GET['value'] = $action . ',1';
			$_GET['perpage'] = !empty($_GET['perpage']) ? $_GET['perpage'] : $config["settings"]->perpage->value;
			$objects = getObjects([
				'table'=>'posts',
				'function'=>'getObjectsWithRelationships',
				'order_by'=>['post_id'],
				'field'=>['term_fullslug','post_visible'],
				'prefix'=>'post',
				'relationship'=>'terms',
				'relationship_prefix'=>'term'
			]);
			
			
			$title = !empty($object['term_title']) ? $config["settings"]->title->value . '&nbsp;&raquo;&nbsp;'. $object['term_title'] : $config["settings"]->title->value;
			$keywords = !empty($object['term_keywords']) ? $object['term_keywords'] : '';
			$description = !empty($object['term_description']) ? $object['term_description'] : '';
			$tmpl = $controller;
			$breadCrumbs = getBreadCrumbs('term', $object);
			$activeLink = getLinks($breadCrumbs);
			$activeLink[] = '/term/';

			$config['pagenavi']['main-container'] = 'ul';
			$config['pagenavi']['class-main-container'] = 'content-pager__list';
			$config['pagenavi']['container'] = '';
			$config['pagenavi']['container-link'] = 'li';
			$config['pagenavi']['container-link-active'] = 'span';
			$config['pagenavi']['class-link-active'] = '';

			$terms = sortObjectsTree(getObjectsTree('terms', 'term', true), 'term');
		}
	break;
	
	case('post'):
		if (!empty($action)) {
			$_GET['field'] = "post_slug"; $_GET['value'] = $action;
			$object = getObjects([
				'table'=>'posts',
				'function'=>'getObjectsWithRelationships',
				'order_by'=>['post_id'],
				'field'=>['post_slug'],
				'prefix'=>'post',
				'relationship'=>'terms',
				'relationship_prefix'=>'term'
			]); $object = !empty($object[0]) ? $object[0] : '';
			
			if (!empty($object)) {
				
				$_GET['field'] = "product_visible"; $_GET['value'] = '1';
				$_GET['perpage'] = !empty($_GET['perpage']) ? $_GET['perpage'] : $config["settings"]->top->value;
				$objects_top = getObjects([
					'table'=>'products',
					'function'=>'getObjectsWithRelationships',
					'order_by'=>['product_sales'],
					'field'=>['product_visible','product_sales'],
					'prefix'=>'product',
					'relationship'=>'cats',
					'relationship_prefix'=>'cat'
				]);
			
				if (!empty($object['postgallery_path']) && !empty($object['postgallery'])) {
					$object['postgallery'] = explode('|', $object['postgallery']);
				}
				if (!empty($object['objectNames']) && !empty($object['objectUrls'])) {
					$object['objectNames'] = explode('|', $object['objectNames']);
					$object['objectUrls'] = explode('|', $object['objectUrls']);
				}
				$title = !empty($object['post_name']) ? $config["settings"]->title->value . '&nbsp;&raquo;&nbsp;'. $object['post_name'] : (!empty($object['post_title'])?$config["settings"]->title->value . '&nbsp;&raquo;&nbsp;'. $object['post_title']:$config["settings"]->title->value);
				$keywords = !empty($object['post_keywords']) ? $object['post_keywords'] : '';
				$description = !empty($object['post_description']) ? $object['post_description'] : '';
				$tmpl = $controller;
				$breadCrumbs = !empty($object['objectUrls'][0]) ? getBreadCrumbs('term', ['term_fullslug'=>$object['objectUrls'][0], 'term_title'=>$object['objectNames'][0]]) : [];
				$activeLink = getLinks($breadCrumbs, '');
				$activeLink[] = '/term/';
				$terms = sortObjectsTree(getObjectsTree('terms', 'term', true), 'term');
			}
		}
		
		if (empty($object)) {
			header("HTTP/1.0 404 Not Found");
			$tmpl = '404'; $title = 'Ошибка 404! Страница не найдена!';
		}
	break;

	case('category'):
		if (!empty($action)) {
			$object = getCatBySlug($action);

			if (empty($object) || !is_array($object)) {
				header("HTTP/1.0 404 Not Found");
				$tmpl = '404'; $title = 'Ошибка 404! Страница не найдена!';
			}
		}
		if ($tmpl != '404') {

			$_GET['field'] = "product_visible"; $_GET['value'] = '1';
			$_GET['perpage'] = !empty($_GET['perpage']) ? $_GET['perpage'] : $config["settings"]->top->value;
			$objects_top = getObjects([
				'table'=>'products',
				'function'=>'getObjectsWithRelationships',
				'order_by'=>['product_sales'],
				'field'=>['product_visible','product_sales'],
				'prefix'=>'product',
				'relationship'=>'cats',
				'relationship_prefix'=>'cat'
			]);

			$_GET['field'] = "product_visible" . (!empty($action)?',cat_fullslug':'');
			$_GET['value'] = '1' . (!empty($action)?','.$action:'');
			$_GET['perpage'] = !empty($_GET['perpage']) ? $_GET['perpage'] : $config["settings"]->perpage->value;
			$objects = getObjects([
				'table'=>'products',
				'function'=>'getObjectsWithRelationships',
				'order_by'=>['product_id','product_pricewithdiscount','product_title'],
				'field'=>['product_visible','cat_fullslug'],
				'prefix'=>'product',
				'relationship'=>'cats',
				'relationship_prefix'=>'cat'
			]);
			
			$title = !empty($object['cat_title']) ? $config["settings"]->title->value . '&nbsp;&raquo;&nbsp;'. $object['cat_title'] : $config["settings"]->title->value;
			$keywords = !empty($object['cat_keywords']) ? $object['cat_keywords'] : '';
			$description = !empty($object['cat_description']) ? $object['cat_description'] : '';
			$tmpl = $controller;
			$breadCrumbs = getBreadCrumbs('cat', $object);
			$activeLink = getLinks($breadCrumbs, '');
			$activeLink[] = '/category/';

			$config['pagenavi']['main-container'] = 'ul';
			$config['pagenavi']['class-main-container'] = 'cat-pager__list';
			$config['pagenavi']['container'] = '';
			$config['pagenavi']['container-link'] = 'li';
			$config['pagenavi']['container-link-active'] = 'li';
			$config['pagenavi']['class-link-active'] = '';
			$config['pagenavi']['before-link-active'] = '<span>';
			$config['pagenavi']['after-link-active'] = '</span>';
		}
	break;

	case('product'):
		if (!empty($action)) {
			$_GET['field'] = "product_slug,product_visible";
			$_GET['value'] = $action .',1';
			$object = getObjects([
				'table'=>'products',
				'function'=>'getObjectsWithRelationships',
				'order_by'=>['product_id'],
				'field'=>['product_slug','product_visible'],
				'prefix'=>'product',
				'relationship'=>'cats',
				'relationship_prefix'=>'cat'
			]); $object = !empty($object[0]) ? $object[0] : '';
			
			if (!empty($object)) {
				if (!empty($object['productgallery_path']) && !empty($object['productgallery'])) {
					$object['productgallery'] = explode('|', $object['productgallery']);
				}
				if (!empty($object['objectNames']) && !empty($object['objectUrls'])) {
					$object['objectNames'] = explode('|', $object['objectNames']);
					$object['objectUrls'] = explode('|', $object['objectUrls']);
				}
				$title = !empty($object['product_title']) ? $config["settings"]->title->value . '&nbsp;&raquo;&nbsp;'. $object['product_title'] : '';
				$keywords = !empty($object['product_keywords']) ? $object['product_keywords'] : '';
				$description = !empty($object['product_description']) ? $object['product_description'] : '';
				$tmpl = $controller;
				$breadCrumbs = !empty($object['objectUrls'][0]) ? getBreadCrumbs('cat', ['cat_fullslug'=>$object['objectUrls'][0], 'cat_title'=>$object['objectNames'][0]]) : [];
				$activeLink = getLinks($breadCrumbs, 'category', true);
				$activeLink[] = '/category/';

				$_GET['field'] = "product_visible";
				$_GET['value'] = '1';
				$_GET['perpage'] = $config["settings"]->top->value;
				$objects_top = getObjects([
					'table'=>'products',
					'function'=>'getObjectsWithRelationships',
					'order_by'=>['product_sales'],
					'field'=>['product_visible','product_sales'],
					'prefix'=>'product',
					'relationship'=>'cats',
					'relationship_prefix'=>'cat'
				]);
			}
		}
		
		if (empty($object)) {
			header("HTTP/1.0 404 Not Found");
			$tmpl = '404'; $title = 'Ошибка 404! Страница не найдена!';
		}
	break;
	
	default:
		header("HTTP/1.0 404 Not Found");
		$tmpl = '404'; $title = 'Ошибка 404! Страница не найдена!';
}
close_connect($connect);
require ("theme/index.php");

//http://www.sesmikcms.ru/pages/read/ischerpyvajuschaja-instrukcija-po-php-mailer/
//https://toster.ru/q/22311
//http://bytehand.com:3800/send?id=25722&key=YOR_KEY&to=+79898800702&from=nagibator&text=registration_complate