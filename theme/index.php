<?php defined("_SMARTMEDIA") or die(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?=$description?>">
  <meta name="keywords" content="<?=$keywords?>">
  <meta name="yandex-verification" content="5e156b9155491a96" />

  <title><?=$title?></title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?=$config["theme"]?>static/css/style.css"/>

  <!--[if lt IE 10]>
  <style type="text/css">
      .products-box{
          text-align: center;
          font-size: 0;
      }
      .products-box-item{
          font-size: 16px;
          border: 1px solid #eeeeee;
          width: 18%!important;
          display: inline-block;
          margin: 0 1%;
      }
  </style>
  <![endif]-->

  <!--[if lt IE 9]>
  <style type="text/css">
      .old-browser-shadow, .old-browser{
          display: block;
      }
      .header .head-phone .head-phone__numb {
          font-size: 24px!important;
      }
  </style>
  <![endif]-->

</head>
<body>

<!-- Yandex.Metrika counter --> 
<script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter41336954 = new Ya.Metrika({ id:41336954, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/41336954" style="position:absolute; left:-9999px;" alt="" /></div></noscript> 
<!-- /Yandex.Metrika counter -->

<div class="wrapper">
  <div class="main">
    <div class="all">

      <div class="page-header">

        <div class="topbar">
          <div class="container">
            <div class="topbar-left">
              <ul class="topbar-left__list">
                <?php if (empty($_SESSION["auth"])): ?>
                  <li class="topbar-left__item">
                    <a href="#login" class="topbar-left__log fancybox">
                      <i class="fa fa-sign-in"></i>
                      Вход / Регистрация
                    </a>
                  </li>
                <?php endif; ?>
                <?php if (!empty($_SESSION["auth"])): ?>
                <li class="topbar-left__item topbar-left__item_prof">
                  <a class="topbar-left__profile" href="mailto:info@yariko.ru">
                    <i class="fa fa-user"></i>
                    Мой профиль
                    <i class="fa fa-caret-down"></i>
                  </a>
                  <ul class="usermenu-down">
                    <li class="usermenu-down__item">
                      <a href="/login.php?do=logout" class="usermenu-down__link">
                        <i class="fa fa-sign-out"></i>Выход
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="topbar-left__item"><a class="topbar-left__log ">&nbsp;</a>
                  <?php else: ?>
                </li>
                <li class="topbar-left__item topbar-left__item_prof"><a class="topbar-left__profile">&nbsp;</a>
                  <?php endif; ?>
                </li>
              </ul>
            </div>
            <div class="topbar-right">
              <div class="top-cart">
                <a href="/shopbag/" class="top-cart__link top-cart__link_buth">
                  <i class="fa fa-cart-plus"></i>
                  <span class="top-cart__link-in">В корзине: тортов</span>
                  <span class="top-cart__count"><?=getQty()?></span>
                  <span class="top-cart__link-in">на сумму</span>
                  <span class="top-cart__price"><?=getSum()?></span>
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="header">
          <div class="container">
            <div class="row">
              <div class="col-md-3 col-xs-12">
                <a href="/" class="logo">
                  <img src="<?=$config["theme"]?>static/img/logo.png" alt="">
                </a>
              </div>
              <div class="col-md-9 col-xs-12">
                <form class="form-search" action="/search/">
                  <input type="text" name="query" value="<?=(!empty($query)?htmlspecialchars(strip_tags(trim($query))):'')?>" class="form-search__text" title="Поиск товаров" placeholder="Поиск товаров...">
                  <button type="submit" class="form-search__btn">
                    <span class="fa fa-search"></span>
                  </button>
                </form>
                <div class="head-phone">
                  <p class="head-phone__numb" title="Звонок бесплатный" style="font-size: 24px;"><?=$config["settings"]->phone->value?></p>
                  <a href="#head-phone" class="fancybox head-phone__btn">Заказать звонок</a>
                </div>
              </div>
            </div>
            <div class="row">
              <?php if (!empty($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']); }?>
              <div class="col-md-3 col-sm-5 col-xs-12">
                <?php if (!empty($menu['main-sidebar'])): ?>
                  <div class="top-cats">
                    <h3 class="top-cats__title"><?=$menu['main-sidebar'][0][0]['menu_title']?></h3>
                    <ul class="dropcat dropcat_none">
                      <?php foreach($menu['main-sidebar'][0] as $item): ?>
                        <li class="dropcat__item">
                          <a href="<?=$item['object_url']?>" class="dropcat__link<?=(activeMenu($item['object_url'], $activeLink)?' dropcat__link_active':'')?>"<?=($item['object_blank'] == 1)?' target="_blank"':''?>>
                            <i class="fa fa-minus"></i>
                            <?=$item['object_title']?>
                          </a>
                          <?php if (!empty($menu['main-sidebar'][$item['object_oid']])): ?>
                            <ul class="dropcat_2">
                              <?php foreach($menu['main-sidebar'][$item['object_oid']] as $subItem): ?>
                                <li class="dropcat_2__item">
                                  <a href="<?=$subItem['object_url']?>" class="dropcat_2__link<?=(activeMenu($subItem['object_url'], $activeLink)?' dropcat__link_active':'')?>"<?=($item['object_blank'] == 1)?' target="_blank"':''?>>
                                    <i class="fa fa-minus"></i>
                                    <?=$subItem['object_title']?>
                                  </a>
                                </li>
                              <?php endforeach; ?>
                            </ul>
                          <?php endif; ?>
                        </li>
                      <?php endforeach;?>
                    </ul>
                  </div>
                <?php endif; ?>
              </div>
              <div class="col-md-9 col-sm-7 col-xs-12">
                <?php if (!empty($menu['main-header'])): ?>
                  <div class="top-menu-wr">
                    <a href="" class="top-menu_xs"><?=$menu['main-header'][0][0]['menu_title']?></a>
                    <ul class="top-menu">
                      <?php foreach($menu['main-header'][0] as $item): ?>
                        <li class="top-menu__item">
                          <a class="top-menu__link top-menu__link<?=(activeMenu($item['object_url'], $activeLink)?'_active':'')?>" href="<?=$item['object_url']?>"<?=($item['object_blank'] == 1)?' target="_blank"':''?>><?=$item['object_title']?></a>
                        </li>
                      <?php endforeach;?>
                    </ul>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="page-content">
        <?php include("v_{$tmpl}.php"); ?>
        <div class="content-bottom">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <h3>О магазине</h3>
                <p><?=$config["settings"]->about->value?></p>
                <h3>Присоединяйтесь к нам:</h3>
                <ul class="you-social">
                  <li><a href="<?=$config["settings"]->vk->value?>" class="vk"> <i class="fa fa-vk"></i></a></li>
                  <li><a href="<?=$config["settings"]->odnoklassniki->value?>" class="odnoklassniki"><i class="fa fa-odnoklassniki"></i></a></li>
                  <li><a href="<?=$config["settings"]->twitter->value?>" class="twitter"><i class="fa fa-twitter"></i></a></li>
                  <li><a href="<?=$config["settings"]->instagram->value?>" class="instagram"><i class="fa fa-instagram"></i></a></li>
                  <li><a href="<?=$config["settings"]->facebook->value?>" class="facebook"><i class="fa fa-facebook"></i></a></li>
                  <li><a href="<?=$config["settings"]->youtube->value?>" class="youtube"><i class="fa fa-youtube"></i></a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </div>

  <div class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-12">
          <p class="footer__copy"><?=$config["settings"]->footer->value?></p>
        </div>
        <div class="col-md-6 col-sm-12">
          <p class="footer__madesite">
            <a href="http://alisultanov.ru/" target="_blank">Разработка сайта Alisultanov.ru</a>
          </p>
        </div>
      </div>
    </div>
  </div>

</div>

<div class="hidden">
  <div id="login">
    <div class="login-tabs">
      <ul class="tabs">
        <li class="tab">Авторизация</li>
        <li class="tab">Регистрация</li>
      </ul>
      <div class="tab_content">
        <div class="tab_item">
          <form>
            <div id="authMessage" style="display:none; padding: 12px 26px;background-color: rgba(227, 177, 177, 0.82);color: rgb(251, 0, 0);border: 1px solid;margin-bottom: 10px;"></div>
            <input type="text" class="login-tabs__input" placeholder="Логин">
            <input type="password" class="login-tabs__input" placeholder="Пароль">
            <p>
              <label>
                <input type="checkbox">
                Запомнить
              </label>
              <button id="auth" class="login-tabs__btn">Войти</button>
            </p>
            <div class="login-tabs__ulogin" id="uLogin1" data-ulogin="display=small;theme=classic;fields=<?=$uLoginFields?>;providers=vkontakte,odnoklassniki,instagram,yandex,google,facebook;hidden=other;redirect_uri=http%3A%2F%2F<?=$_SERVER['HTTP_HOST']?>%2Flogin.php%3Fulogin%26redirect_uri%3Dhttp%3A%2F%2F<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>;mobilebuttons=0;"></div>
          </form>
        </div>
        <div class="tab_item">
          <form>
            <div id="regMessage"></div>
            <span style="font-size: 10px;color: rgb(195, 200, 21);border-bottom: 1px dashed;margin: 0px 13px;">* Желательно указать сразу</span>
            <input type="text" class="login-tabs__input" placeholder="email">
            <span style="font-size: 10px;color: rgb(200, 46, 21);border-bottom: 1px dashed;margin: 0px 13px;">* Указать обязательно</span>
            <input type="text" class="login-tabs__input" placeholder="Логин">
            <span style="font-size: 10px;color: rgb(195, 200, 21);border-bottom: 1px dashed;margin: 0px 13px;">* Желательно указать сразу</span>
            <input type="text" class="login-tabs__input" placeholder="Телефон">
            <span style="font-size: 10px;color: rgb(200, 46, 21);border-bottom: 1px dashed;margin: 0px 13px;">* Указать обязательно</span>
            <input type="password" class="login-tabs__input" placeholder="Пароль">
            <span style="font-size: 10px;color: rgb(200, 46, 21);border-bottom: 1px dashed;margin: 0px 13px;">* Указать обязательно</span>
            <input type="password" class="login-tabs__input" placeholder="Повторите пароль">
            <span style="font-size: 10px;color: rgb(195, 200, 21);border-bottom: 1px dashed;margin: 0px 13px;">* Желательно указать сразу</span>
            <input type="text" class="login-tabs__input" placeholder="Имя">
            <span style="font-size: 10px;color: rgb(195, 200, 21);border-bottom: 1px dashed;margin: 0px 13px;">* Желательно указать сразу</span>
            <input type="text" class="login-tabs__input" placeholder="Фамилия">
            <span style="font-size: 10px;color: rgb(195, 200, 21);border-bottom: 1px dashed;margin: 0px 13px;">* Желательно указать сразу</span>
            <input type="text" class="login-tabs__input" placeholder="Отчество">
            <span style="font-size: 10px;color: rgb(195, 200, 21);border-bottom: 1px dashed;margin: 0px 13px;">* Желательно указать сразу</span>
            <input type="text" class="login-tabs__input" placeholder="Адрес">
            <p>
              <button id="reg" class="login-tabs__btn login-tabs__btn_reg">Зарегистрироваться</button>
            </p>
            <div style="margin: 10px 70px;" id="uLogin2" data-ulogin="display=small;theme=classic;fields=<?=$uLoginFields?>;providers=vkontakte,odnoklassniki,instagram,yandex,google,facebook;hidden=other;redirect_uri=http%3A%2F%2F<?=$_SERVER['HTTP_HOST']?>%2Flogin.php%3Fulogin%26redirect_uri%3Dhttp%3A%2F%2F<?=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>;mobilebuttons=0;"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div id="head-phone">
    <h4>Заказать звонок</h4>

    <form>
      <div id="callback-msg"></div>
      <input type="text" placeholder="Ваше имя" required>
      <input type="tel" class="myphone" placeholder="Ваш номер" required>
      <button id="callback">Отправить</button>
    </form>
  </div>

</div>

<div class="old-browser">
  <p>Вы используете старый браузер скачайте один из современных</p>
  <a target="_blank" href="https://goo.gl/mwQLdI">
    <img src="<?=$config["theme"]?>static/img/google-chrome.png" alt="">
  </a>
  <a target="_blank" href="https://goo.gl/6B9iyK">
    <img src="<?=$config["theme"]?>static/img/yandex-browser.png" alt="">
  </a>
  <a target="_blank" href="http://goo.gl/Onf04H">
    <img src="<?=$config["theme"]?>static/img/opera.png" alt="">
  </a>
  <a target="_blank" href="https://goo.gl/Goji53">
    <img src="<?=$config["theme"]?>static/img/firefox.png" alt="">
  </a>
</div>
<div class="old-browser-shadow"></div>


<script src="<?=$config["theme"]?>static/js/jquery.min.js"></script>
<script src="<?=$config["theme"]?>static/libs/jqueryui/jquery-ui.min.js"></script>
<script src="<?=$config["theme"]?>static/libs/lightslider/js/lightslider.min.js"></script>
<script src="<?=$config["theme"]?>static/libs/fancybox/jquery.fancybox.js"></script>
<script src="<?=$config["theme"]?>static/libs/inputmasked/jquery.maskedinput.min.js"></script>
<script src="<?=$config["theme"]?>static/libs/formstyler/jquery.formstyler.min.js"></script>
<!--<script src="<?=$config["theme"]?>static/libs/elevatezoom/jquery.elevatezoom.js"></script>-->
<script src="<?=$config["theme"]?>static/js/main.js"></script>
<script src="//ulogin.ru/js/ulogin.js"></script>

</body>
</html>