<?php defined("_SMARTMEDIA") or die(); ?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$title?></title>

    <link href="static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="static/css/sb-admin.css" rel="stylesheet" type="text/css">
    <link href="static/css/plugins/morris.css" rel="stylesheet" type="text/css">
	<link href="static/css/jquery-ui.css" rel="stylesheet" type="text/css">
	<link href="static/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
	<link href="static/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<script src="static/js/jquery.js"></script>
	<script src="static/js/ajaxupload.js"></script>
	<script src="static/js/bootstrap.min.js"></script>
	<script src="static/js/jquery-ui.min.js"></script>
	<script src="static/js/jquery.mjs.nestedSortable.js"></script>
	<script src="static/sweetalert/sweetalert.min.js"></script>
	<script src="static/js/tinymce/tinymce.min.js"></script>
	
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<style>
		#mceu_13 span.mce-txt {width: 40px!important;}
		#mceu_14 span.mce-txt {width: 95px!important;}
		.form-control[readonly], fieldset[readonly] .form-control {cursor: not-allowed;}
		h2 {font-style: normal!important;}
        .btn-primary.btn-outline {
            color: #428bca;
        }
        .btn-outline {
            color: inherit;
            background-color: transparent;
            transition: all .5s;
        }
        .btn-outline:hover {
            color: #fff;
        }
	</style>
	
	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="/library/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox -->
	<link rel="stylesheet" href="/library/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
	<script type="text/javascript" src="/library/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>

	<!-- Optionally add helpers - button, thumbnail and/or media -->
	<link rel="stylesheet" href="/library/fancybox/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
	<script type="text/javascript" src="/library/fancybox/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
	<script type="text/javascript" src="/library/fancybox/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

	<link rel="stylesheet" href="/library/fancybox/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
	<script type="text/javascript" src="/library/fancybox/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

</head>

<body> 

    <div id="wrapper">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="z-index: 1;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Мобильное меню</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Genesis Platform "<?=MODEL?> v<?=VERSION?>"</a>
            </div>

            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Администратор <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php if ($config["modules"]->users->active): ?><li><a href="?view=update_user&user_id=<?=$_SESSION['auth']['user_id']?>"><i class="fa fa-fw fa-user"></i> Профиль</a></li><?php endif; ?>
                        <li><a href="?view=settings"><i class="fa fa-fw fa-gear"></i> Настройки</a></li>
                        <li class="divider"></li>
                        <li><a href="/login.php?do=logout"><i class="fa fa-fw fa-power-off"></i> Выход</a></li>
                    </ul>
                </li>
            </ul>
			
			<style>
				.navbar-nav li.active li.active {
					color: #fff;
					background-color: #080808;
				}
                .newNot {
                    padding: 7px 12px;
                    background-color: brown;
                    color: #fff;
                    border-radius: 18px;
                }
			</style>
			
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li><a href="/" target="_blank"><i class="fa fa-fw fa-home"></i> На сайт</a></li>
					<li <?=activeUrl("dashboard")?>><a href="?view=dashboard"><i class="fa fa-fw fa-dashboard"></i> Панель<?=($notOrd > 0 || $notCal > 0)?' <span class="newNot">'.($notOrd+$notCal).'</span>':''?></a></li>

                    <?php if ($config["modules"]->terms->active || $config["modules"]->posts->active): ?>
                        <?php $s_blog = 'terms,add_term,update_term,posts,add_post,update_post'?>
                        <li <?=activeUrl($s_blog)?>>
                            <a href="javascript:;" data-toggle="collapse" data-target="#blog" class="collapsed" aria-expanded="<?=activeUrl($s_blog)?'true':'false'?>"><i class="fa fa-fw fa fa-book"></i> Блог <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="blog" class="collapse<?=activeUrl($s_blog)?' in':''?>" aria-expanded="<?=activeUrl($s_blog)?'true':'false'?>" style="<?=activeUrl($s_blog)?'':'height: 0px;'?>">
                                <?php if ($config["modules"]->terms->active): ?> <li <?=activeUrl("terms,add_term,update_term")?>><a href="?view=terms"><i class="fa fa-fw fa-folder-open"></i> Рубрики</a></li><?php endif; ?>
                                <?php if ($config["modules"]->posts->active): ?> <li <?=activeUrl("posts,add_post,update_post")?>><a href="?view=posts"><i class="fa fa-fw fa-pencil"></i> Записи</a></li><?php endif; ?>
                            </ul>
                        </li>
                    <?php endif; ?>

					<?php if ($config["modules"]->pages->active): ?> <li <?=activeUrl("pages,add_page,update_page")?>><a href="?view=pages"><i class="fa fa-fw fa-copy"></i> Страницы</a></li><?php endif; ?>
					<?php if ($config["modules"]->sliders->active): ?> <li <?=activeUrl("sliders,add_slider,update_slider")?>><a href="?view=sliders"><i class="fa fa-fw fa-picture-o"></i> Слайдеры</a></li><?php endif; ?>
					<?php if ($config["modules"]->menus->active && $_SESSION["auth"]["user_status"] != 4): ?> <li <?=activeUrl("menus,add_menu,update_menu")?>><a href="?view=menus"><i class="fa fa-fw fa-chain"></i> Меню</a></li><?php endif; ?>
                    <?php if ($config["modules"]->mediafiles->active && $_SESSION["auth"]["user_status"] != 4): ?> <li <?=activeUrl("mediafiles")?>><a href="?view=mediafiles"><i class="fa fa-fw fa-camera" style="position: relative;top: -3px;left: -2px;color: grey;"></i><i class="fa fa-fw fa-music" style="position: relative;left: -13px;top: 2px;color: grey;"></i><span style="margin-left: -10px;">Медиафайлы<span></a></li><?php endif; ?>
					
					<?php if ($config["modules"]->cats->active || $config["modules"]->products->active || $config["modules"]->filters->active || $config["modules"]->delivery->active || $config["modules"]->orders->active): ?>
					<?php $s_shop = 'categories,products,add_product,update_product,filters,delivery,orders'?>
					<li <?=activeUrl($s_shop)?>>
                       <a href="javascript:;" data-toggle="collapse" data-target="#shop" class="collapsed" aria-expanded="<?=activeUrl($s_shop)?'true':'false'?>"><i class="fa fa-fw fa-shopping-basket"></i> Магазин<?=($notOrd > 0)?' <span class="newNot">'.$notOrd.'</span>':''?> <i class="fa fa-fw fa-caret-down"></i></a>
                       <ul id="shop" class="collapse<?=activeUrl($s_shop)?' in':''?>" aria-expanded="<?=activeUrl($s_shop)?'true':'false'?>" style="<?=activeUrl($s_shop)?'':'height: 0px;'?>">
                            <?php if ($config["modules"]->cats->active): ?><li <?=activeUrl("categories")?>><a href="?view=categories"><i class="fa fa-fw fa-cubes"></i> Категории</a></li><?php endif; ?>
                            <?php if ($config["modules"]->products->active): ?><li <?=activeUrl("products,add_product,update_product")?>><a href="?view=products"><i class="fa fa-fw fa-shopping-cart"></i> Товары</a></li><?php endif; ?>
                            <?php if ($config["modules"]->filters->active && $_SESSION["auth"]["user_status"] != 4): ?><li <?=activeUrl("filters")?>><a href="?view=filters"><i class="fa fa-fw fa-filter"></i> Фильтры</a></li><?php endif; ?>
                            <?php if ($config["modules"]->delivery->active && $_SESSION["auth"]["user_status"] != 4): ?><li <?=activeUrl("delivery")?>><a href="?view=delivery"><i class="fa fa-fw fa-truck"></i> Доставка</a></li><?php endif; ?>
                            <?php if ($config["modules"]->orders->active): ?><li <?=activeUrl("orders")?>><a href="?view=orders"><i class="fa fa-fw fa-credit-card"></i> Заказы<?=($notOrd > 0)?' <span class="newNot">'.$notOrd.'</span>':''?></a></li><?php endif; ?>
                        </ul>
                    </li>
					<?php endif; ?>
					
					<!-- http://t4t5.github.io/sweetalert/ -->
					<!-- fa-paint-brush -->
					<!-- fa-newspaper-o -->
					<!-- fa-language -->
					<!-- fa-comments -->
					<!-- fa-bullhorn -->
					<!-- fa-book -->
					<!-- fa-tags -->
					<?php if ($_SESSION["auth"]["user_status"] != 4): ?>
					<?php $s_system = 'modules,plugins'?>
					<li <?=activeUrl($s_system)?>>
                       <a href="javascript:;" data-toggle="collapse" data-target="#system" class="collapsed" aria-expanded="<?=activeUrl($s_system)?'true':'false'?>"><i class="fa fa-fw fa-cogs"></i> Система <i class="fa fa-fw fa-caret-down"></i></a>
                       <ul id="system" class="collapse<?=activeUrl($s_system)?' in':''?>" aria-expanded="<?=activeUrl($s_system)?'true':'false'?>" style="<?=activeUrl($s_system)?'':'height: 0px;'?>">
                            <li <?=activeUrl("modules")?>><a href="?view=modules"><i class="fa fa-fw fa-wrench"></i> Модули</a></li>
                            <?php if ($config["modules"]->plugins->active): ?><li <?=activeUrl("plugins")?>><a href="?view=plugins"><i class="fa fa-fw fa-plug"></i> Плагины</a></li><?php endif; ?>
                        </ul>
                    </li>
					<?php endif; ?>
                    <?php if ($config["modules"]->users->active && $_SESSION["auth"]["user_status"] != 4): ?><li <?=activeUrl("users")?>><a href="?view=users"><i class="fa fa-fw fa-group"></i> Пользователи</a></li><?php endif; ?>
					<?php if ($config["modules"]->settings->active): ?><li <?=activeUrl("settings")?>><a href="?view=settings"><i class="fa fa-fw fa-gear"></i> Настройки</a></li><?php endif; ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>