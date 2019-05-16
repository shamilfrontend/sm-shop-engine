<?php defined("_SMARTMEDIA") or die(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<!-- sidebar -->
			<?php include_once 'v_sidebar.php' ?>
		</div>
		<div class="col-md-9">
			<div class="content">
				<div class="breadcrumbs">
					<ul class="breadcrumbs__list">
						<li class="breadcrumbs__item"><a href="/" class="breadcrumbs__link">Главная</a></li>
						<li class="breadcrumbs__item"><a href="/category/" class="breadcrumbs__link">Каталог</a></li>
						<?php if (!empty($breadCrumbs) && is_array($breadCrumbs)): ?>
							<?php foreach($breadCrumbs as $item): ?>
								<li class="breadcrumbs__item">
										<a href="/category/<?=$item['slug']?>/" class="breadcrumbs__link"><?=$item['title']?></a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
						<li class="breadcrumbs__item">
							<span class="breadcrumbs__nolink">[<?=$object['product_article']?>] <?=$object['product_title']?></span>
						</li>
					</ul>
				</div>
				<h3><?=getProductName($object, 'product', true)?></h3>
				
				<div class="catalog-product">
					<div class="row">
						<div class="col-md-5">
							<div class="product-img">
								<div class="product-img__img">
									<?php if (!empty($object['productpicture_path']) && !empty($object['productpicture'])): ?>
									<a href="<?=$object['productpicture_path'] . $object['productpicture']?>" class="fancybox" rel="group">
										<img class="product-mainimg" src="<?=$object['productpicture_path'] . 'thumb/'. $object['productpicture']?>" />
									</a>
									<?php endif; ?>
								</div>
								<ul class="product-gallery">
									<?php if (!empty($object['productgallery_path']) && !empty($object['productgallery'])): ?>
										<?php foreach($object['productgallery'] as $item): ?>
									<li class="product-gallery__item">
										<a href="#" class="product-gallery__link" data-img="<?=$object['productgallery_path'] . $item?>">
											<img src="<?=$object['productgallery_path'] . 'thumb/' . $item?>" />
										</a>
									</li>
										<?php endforeach; ?>
									<?php endif; ?>
								</ul>
							</div>
						</div>
						<div class="col-md-7">
							<div class="product__feature">
								<?php if (!empty($object['product_params'])): ?>
								<?php $object['product_params'] = unserialize($object['product_params']); ?>
								<h4>Основные характеристики111</h4>
								<ul>
									<?php foreach($object['product_params'] as $key => $item): ?>
										<?php if (substr($key, 0, 5) == 'param'): ?>
											<?php $item = explode('|', $item); if (empty($item[0]) || empty($item[1])) continue; ?>
											<li>
												<strong><?=$item[0]?></strong>
												<span><?=$item[1]?></span>
											</li>
										<?php endif;?>
									<?php endforeach;?>
								</ul>
								<?php endif; ?>
							</div>
							<div class="product__addcart">
								<p>Цена за кг
									<span>
										<?=($object['product_discount'] > 0)?'<s>'.$object['product_price'].'</s> -> ' . getPriceDiscount($object['product_price'], $object['product_discount']):$object['product_price']?>
									</span>
								</p>
								<?=($object['product_discount'] > 0)?'<p>Скидка: ' . $object['product_discount'] . ' <i class="fa fa-percent" aria-hidden="true"></i></p>':''?>
								<div class="counter">
									<p class="counter__text">Выберите вес торта</p>

									<div class="counter__btn-group">
										<button class="counter__minus">-</button>
										<input class="counter__count" type="text" placeholder="Количество" value="3" disabled="disabled" data-id="<?=$object['product_id']?>" data-price="<?=($object['product_discount'] > 0)?getPriceDiscount($object['product_price'], $object['product_discount']):$object['product_price']?>">
										<button class="counter__plus">+</button>
									</div>

									<p class="counter__text">Итого:
										<span class="total_sum" id="total_sum<?=$object['product_id']?>">
											<?=($object['product_discount'] > 0)?getPriceDiscount($object['product_price'], $object['product_discount'])*3:$object['product_price']*3?>
										</span>
									</p>

								</div>
								<a id="qty<?=$object['product_id']?>" href="#" class="shopping-cart" data-id="<?=$object['product_id']?>" data-qty="3">Добавить в корзину</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">

							<div class="product-bottom-tabs">
								<ul class="product-bottom-tabs__tabs">
									<li class="product-bottom-tabs__tab active">Описание</li>
									<!--li class="product-bottom-tabs__tab">Вкладка 2</li-->
									<!--li class="product-bottom-tabs__tab">Вкладка 3</li-->
								</ul>
								<div class="product-bottom-tabs__tab-content">
									<div class="product-bottom-tabs__tab-item">
										<?=htmlDecode($object['product_text'])?>
										
									</div>
									<!--div class="product-bottom-tabs__tab-item">Содержимое 2</div-->
									<!--div class="product-bottom-tabs__tab-item">Содержимое 3</div-->
								</div>
							</div>

						</div>
					</div>
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