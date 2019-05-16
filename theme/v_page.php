<?php defined("_SMARTMEDIA") or die(); ?>
<div class="content-top">
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
							<?php if (!empty($breadCrumbs) && is_array($breadCrumbs)): ?>
								<?php foreach($breadCrumbs as $item): ?>
							<li class="breadcrumbs__item">
								<?php if (!empty($item['active'])): ?>
								<span class="breadcrumbs__nolink"><?=$item['title']?></span>
								<?php else: ?>
								<a href="/page/<?=$item['slug']?>/" class="breadcrumbs__link"><?=$item['title']?></a>
								<?php endif; ?>
							</li>
								<?php endforeach; ?>
							<?php endif; ?>
						</ul>
					</div>

					<h3 class="content__title"><?=$object['page_title']?></h3>
					<?=htmlDecode($object['page_text'])?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="product-block">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if (!empty($objects_new) && is_array($objects_new)): ?>
					<h2 class="product-block__title">Новые поступления</h2>
					<ul class="products-box products-box_new">
						<?php foreach($objects_new as $item): ?>
							<li class="products-box-item">
								<div class="products-box-item__znak">
									<div class="products-box-item__new">Новый</div>
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