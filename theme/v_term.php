<?php defined("_SMARTMEDIA") or die(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<div class="sidebar">
				<div class="sidebar-menu">
					<h3 class="sidebar__title">Категории блога</h3>
					<ul class="sidebar-menu__list">
						<?php if (!empty($terms[0]) && is_array($terms[0])): ?>
							<?php foreach($terms[0] as $item): ?>
								<li class="sidebar-menu__item">
									<a href="/term/<?=$item['term_fullslug']?>/" class="sidebar-menu__link<?=(activeMenu($item['term_fullslug'], $activeLink)?' sidebar-menu__link_active':'')?>"><?=$item['term_title']?></a>
								</li>
							<?php endforeach;?>
						<?php endif; ?>
					</ul>
				</div>
				<?php include_once 'v_sidebar.php' ?>
			</div>
		</div>
		<div class="col-md-9">
			<div class="content">
				<div class="breadcrumbs">
					<ul class="breadcrumbs__list">
						<li class="breadcrumbs__item"><a href="/" class="breadcrumbs__link">Главная</a></li>
						<?php if (!empty($breadCrumbs) && is_array($breadCrumbs)): ?>
							<li class="breadcrumbs__item"><a href="/term/" class="breadcrumbs__link">Блог</a></li>
							<?php foreach($breadCrumbs as $item): ?>
								<li class="breadcrumbs__item">
									<?php if (!empty($item['active'])): ?>
										<span class="breadcrumbs__nolink"><?=$item['title']?></span>
									<?php else: ?>
										<a href="/term/<?=$item['slug']?>/" class="breadcrumbs__link"><?=$item['title']?></a>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						<?php else: ?>
							<li class="breadcrumbs__item">
								<span class="breadcrumbs__nolink">Блог</span>
							</li>
						<?php endif; ?>
					</ul>
				</div>
				<h3 class="content__title"><?=!empty($object['term_title'])?$object['term_title']:''?></h3>

				<ul class="blog-list">
					<?php if (!empty($objects) && is_array($objects)): ?>
						<?php foreach($objects as $item): ?>
							<li class="blog-item">
								<div class="blog-item__img">
									<a href="/post/<?=$item['post_slug']?>/">
										<?php if (!empty($item['postpicture'])) echo getImg($item, 'post', true); ?>
									</a>
								</div>
								<h4 class="blog-item__title">
									<a href="/post/<?=$item['post_slug']?>/"><?=getProductName($item, 'post')?></a>
								</h4>
								<div class="blog-item__text"><?=htmlDecode($item['post_quote'])?></div>
								<a href="/post/<?=$item['post_slug']?>/" class="blog-item__more">Читать далее</a>
							</li>
						<?php endforeach; ?>
					<?php else :?>
						<div>
							<h1>Рубрика пуста ;(</h1>
							<p>В этой рубрике пока нет записей, но Вы возвращайтесь ещё! Совсем скоро этот раздел пополнится новыми записями!</p>
						</div>
					<?php endif; ?>
				</ul>

				<div class="content-pager">
					<ul class="content-pager__list">
						<?=pageNavi()?>
					</ul>
				</div>

			</div>
		</div>
	</div>
</div>

<div class="product-block">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if (!empty($objects_top) && is_array($objects_top)): ?>
					<h2 class="product-block__title">Лидеры Продаж</h2>
					<ul class="products-box products-box_new">
						<?php foreach($objects_top as $item): ?>
							<li class="products-box-item">
								<div class="products-box-item__znak">
									<div class="products-box-item__lider">Лидер</div>
								</div>
								<div class="products-box-item__img">
									<?=getImg($item, 'product', true)?>
								</div>
								<h3 class="products-box-item__title">
									<a href="/product/<?=$item['product_slug']?>/"><?=getProductName($item, 'product')?></a>
								</h3>
								<div class="products-box-item__price">
									<p class="oneprice">Цена за кг - <span><?=getPriceDiscount($item['product_price'], $item['product_discount'])?></span></p>
									<?php $item['product_params'] = unserialize($item['product_params']); ?>
									<?php if (!empty($item['product_params']['line'])): ?><p class="lineprice">Линия - <span><?=getPriceDiscount(abs((int)$item['product_params']['line']), $item['product_discount'])?></span></p><?php endif; ?>
									<?php if (!empty($item['product_params']['box'])): ?><p class="boxprice">Коробка - <span><?=getPriceDiscount(abs((int)$item['product_params']['box']), $item['product_discount'])?></span></p><?php endif; ?>
									<?php if ($item['product_discount'] > 0): ?><p class="discount">Скидка - <?=$item['product_discount']?> <i class="fa fa-percent" aria-hidden="true"></i></p><?php endif; ?>
								</div>
								<div class="products-box-item__btns">
									<a href="#" class="shopping-cart" data-id="<?=$item['product_id']?>">Добавить в корзину</a>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>