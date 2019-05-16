<?php defined("_SMARTMEDIA") or die(); ?>
<div class="content-top">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
			    <?php include_once 'v_sidebar.php' ?>
			</div>
			<div class="col-md-9">
			    
				<?php if (!empty($slider) && is_array($slider)): $slider['slider_sliders'] = unserialize($slider['slider_sliders']); ?>
				<div class="slider-akcii">
					<ul class="slider-akcii__list">
						<?php foreach($slider['slider_sliders'] as $item):  ?>
						<li class="slider-akcii__item">
							<a href="<?=$item['link']?>"><img src="<?=$slider['slider_path'] . $item['slider']?>" class="slider-akcii__img" alt=""></a>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>
				
			</div>
		</div>
	</div>
</div>

<div class="product-block">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if (!empty($objects_top) && is_array($objects_top)): ?>
				<h2 class="product-block__title">Популярные тортики</h2>
				<ul class="products-box products-box_new">
					<?php foreach($objects_top as $item): ?>
					<li class="products-box-item">
						<div class="products-box-item__znak">
							<div class="products-box-item__lider">Лидер</div>
						</div>
						<div class="products-box-item__img">
							<a href="/product/<?=$item['product_slug']?>/">
							    <?=getImg($item, 'product', true)?>
							</a>
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
							<a href="#" class="shopping-cart" data-id="<?=$item['product_id']?>" data-qty="3">Добавить в корзину</a>
						</div>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<div class="product-block">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if (!empty($objects_new) && is_array($objects_new)): ?>
					<h2 class="product-block__title">Новые тортики</h2>
					<ul class="products-box products-box_new">
						<?php foreach($objects_new as $item): ?>
							<li class="products-box-item">
								<div class="products-box-item__znak">
									<div class="products-box-item__new">Новый</div>
								</div>
								<div class="products-box-item__img">
									<a href="/product/<?=$item['product_slug']?>/">
									    <?=getImg($item, 'product', true)?>
									</a>
								</div>
								<h3 class="products-box-item__title">
									<a href="/product/<?=$item['product_slug']?>/">
									    <?=getProductName($item, 'product')?>
									</a>
								</h3>
								<div class="products-box-item__price">
									<p class="oneprice">Цена за кг - <span><?=getPriceDiscount($item['product_price'], $item['product_discount'])?></span></p>
									<?php $item['product_params'] = unserialize($item['product_params']); ?>
									<?php if (!empty($item['product_params']['line'])): ?><p class="lineprice">Линия - <span><?=getPriceDiscount(abs((int)$item['product_params']['line']), $item['product_discount'])?></span></p><?php endif; ?>
									<?php if (!empty($item['product_params']['box'])): ?><p class="boxprice">Коробка - <span><?=getPriceDiscount(abs((int)$item['product_params']['box']), $item['product_discount'])?></span></p><?php endif; ?>
									<?php if ($item['product_discount'] > 0): ?><p class="discount">Скидка - <?=$item['product_discount']?> <i class="fa fa-percent" aria-hidden="true"></i></p><?php endif; ?>
								</div>
								<div class="products-box-item__btns">
									<a href="#" class="shopping-cart" data-id="<?=$item['product_id']?>" data-qty="3">Добавить в корзину</a>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>