<?php defined("_SMARTMEDIA") or die(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<?php include_once 'v_sidebar.php' ?>
		</div>
		<div class="col-md-9">
			<div class="content">
				<div class="breadcrumbs">
					<ul class="breadcrumbs__list">
						<li class="breadcrumbs__item"><a href="/" class="breadcrumbs__link">Главная</a></li>
						<?php if (!empty($breadCrumbs) && is_array($breadCrumbs)): ?>
							<li class="breadcrumbs__item"><a href="/category/" class="breadcrumbs__link">Каталог</a></li>
							<?php foreach($breadCrumbs as $item): ?>
								<li class="breadcrumbs__item">
									<?php if (!empty($item['active'])): ?>
										<span class="breadcrumbs__nolink"><?=$item['title']?></span>
									<?php else: ?>
										<a href="/category/<?=$item['slug']?>/" class="breadcrumbs__link"><?=$item['title']?></a>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						<?php else: ?>
						<li class="breadcrumbs__item">
							<span class="breadcrumbs__nolink">Каталог</span>
						</li>
						<?php endif; ?>
					</ul>
				</div>
				<h3 class="content__title"><?=$object['cat_title']?></h3>

				<div class="row">
                    <div class="col-md-12">
                        <div class="cat-sort">
                            <ul class="cat-sort__list">
                                <li><span>Сортировать по:</span></li>
                                <li><a href="<?=getCurrentLink(['all'])?>?order_by=product_pricewithdiscount&side=<?=(isset($_GET['order_by']) && $_GET['order_by'] == 'product_pricewithdiscount' && isset($_GET['side']) && $_GET['side'] == 'asc')?'desc':'asc'?>"<?php if (isset($_GET['order_by']) && $_GET['order_by'] == 'product_pricewithdiscount'):?> class="active"<?php endif;?>>Цене <i class="fa fa-chevron-<?=(isset($_GET['order_by']) && $_GET['order_by'] == 'product_pricewithdiscount' && isset($_GET['side']) && $_GET['side'] == 'asc')?'down':'up'?>"></i></a></li>
                                <li><a href="<?=getCurrentLink(['all'])?>?order_by=product_title&side=<?=(isset($_GET['order_by']) && $_GET['order_by'] == 'product_title' && isset($_GET['side']) && $_GET['side'] == 'asc')?'desc':'asc'?>"<?php if (isset($_GET['order_by']) && $_GET['order_by'] == 'product_title'):?> class="active"<?php endif;?>>Названию <i class="fa fa-chevron-<?=(isset($_GET['order_by']) && $_GET['order_by'] == 'product_title' && isset($_GET['side']) && $_GET['side'] == 'asc')?'down':'up'?>"></i></a></li>
                                <li><a href="<?=getCurrentLink(['all'])?>" class="reset"><i class="fa fa-undo"></i>Сбросить</a></li>
                            </ul>
                            <!--ul class="cat-sort__view">
                                <li>
                                    <a href="" class="active">
                                        <i class="fa fa-th"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <i class="fa fa-th-list"></i>
                                    </a>
                                </li>
                            </ul-->
                        </div>
                    </div>
                </div>

				<div class="row">
					<div class="col-md-12">
						<div class="cat-pager" style="height: 38px;">
                            <form action="#" method="post" class="">
                                <span class="cat-pager__showprod">Товары <?=($config['perpage'] >= $config['count_rows']) ? $config['count_rows'] : $config['perpage']?> из <?=$config['count_rows']?></span>
								<?=pageNavi()?>
                                <div class="showby">
                                    <span class="showby-poc">Показывать по:</span>
                                    <div class="showby-form">
                                        <select onchange="top.location=this.value">
                                            <option value="<?=getCurrentLink(['page','perpage','field','value'])?>perpage=12"<?=(!empty($_GET['perpage']) && $_GET['perpage'] == 12)?' selected="selected"':''?>>12</option>
                                            <option value="<?=getCurrentLink(['page','perpage','field','value'])?>perpage=24"<?=(!empty($_GET['perpage']) && $_GET['perpage'] == 24)?' selected="selected"':''?>>24</option>
                                            <option value="<?=getCurrentLink(['page','perpage','field','value'])?>perpage=36"<?=(!empty($_GET['perpage']) && $_GET['perpage'] == 36)?' selected="selected"':''?>>36</option>
                                            <option value="<?=getCurrentLink(['page','perpage','field','value'])?>perpage=48"<?=(!empty($_GET['perpage']) && $_GET['perpage'] == 48)?' selected="selected"':''?>>48</option>
                                            <option value="<?=getCurrentLink(['page','perpage','field','value'])?>perpage=60"<?=(!empty($_GET['perpage']) && $_GET['perpage'] == 60)?' selected="selected"':''?>>60</option>
                                            <option value="<?=getCurrentLink(['page','perpage','field','value'])?>perpage=100"<?=(!empty($_GET['perpage']) && $_GET['perpage'] == 100)?' selected="selected"':''?>>100</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
					</div>
				</div>
				
				<div class="row">
					<div class="cat-products">
						<?php if (!empty($objects) && is_array($objects)): ?>
							<?php foreach($objects as $item): ?>
								<div class="col-md-4 col-sm-6">
									<div class="cat-product-item">
										<!--div class="cat-product-item__znak">
											<div class="cat-product-item__new">New</div>
											<div class="cat-product-item__lider">Sale</div>
										</div-->
										<div class="cat-product-item__img">
											<a href="/product/<?=$item['product_slug']?>/"><?=getImg($item, 'product', true)?></a>
										</div>
										<h3 class="cat-product-item__title">
											<a href="/product/<?=$item['product_slug']?>/"><?=getProductName($item, 'product')?></a>
										</h3>
										<div class="cat-product-item__price">
											<p class="oneprice">Цена за кг - <span><?=getPriceDiscount($item['product_price'], $item['product_discount'])?></span></p>
											<?php $item['product_params'] = unserialize($item['product_params']); ?>
											<?php if (!empty($item['product_params']['line'])): ?><p class="lineprice">Линия - <span><?=getPriceDiscount(abs((int)$item['product_params']['line']), $item['product_discount'])?></span></p><?php endif; ?>
											<?php if (!empty($item['product_params']['box'])): ?><p class="boxprice">Коробка - <span><?=getPriceDiscount(abs((int)$item['product_params']['box']), $item['product_discount'])?></span></p><?php endif; ?>
											<?php if ($item['product_discount'] > 0): ?><p class="discount">Скидка - <?=$item['product_discount']?> <i class="fa fa-percent" aria-hidden="true"></i></p><?php endif; ?>
										</div>
										<div class="cat-product-item__btns">
											<a href="#" class="shopping-cart" data-id="<?=$item['product_id']?>" data-qty="3">Добавить в корзину</a>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						<?php else :?>
							<div class='col-md-12'>
								<h1>Категория пуста ;(</h1>
								<p>В этой категории пока нет товаров, но Вы возвращайтесь ещё! Совсем скоро этот раздел пополнится новыми товарами!</p>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="row">
                    <div class="col-md-12">
                        <div class="cat-pager" style="height: 38px;">
                            <form action="#" method="post" class="">
                                <span class="cat-pager__showprod">Товары <?=($config['perpage'] >= $config['count_rows']) ? $config['count_rows'] : $config['perpage']?> из <?=$config['count_rows']?></span>
								<?=pageNavi()?>
                                <div class="showby">
                                    <span class="showby-poc">Показывать по:</span>
                                    <div class="showby-form">
										<select onchange="top.location=this.value">
											<option value="<?=getCurrentLink(['page','perpage','field','value'])?>perpage=12"<?=(!empty($_GET['perpage']) && $_GET['perpage'] == 12)?' selected="selected"':''?>>12</option>
											<option value="<?=getCurrentLink(['page','perpage','field','value'])?>perpage=24"<?=(!empty($_GET['perpage']) && $_GET['perpage'] == 24)?' selected="selected"':''?>>24</option>
											<option value="<?=getCurrentLink(['page','perpage','field','value'])?>perpage=36"<?=(!empty($_GET['perpage']) && $_GET['perpage'] == 36)?' selected="selected"':''?>>36</option>
											<option value="<?=getCurrentLink(['page','perpage','field','value'])?>perpage=48"<?=(!empty($_GET['perpage']) && $_GET['perpage'] == 48)?' selected="selected"':''?>>48</option>
											<option value="<?=getCurrentLink(['page','perpage','field','value'])?>perpage=60"<?=(!empty($_GET['perpage']) && $_GET['perpage'] == 60)?' selected="selected"':''?>>60</option>
											<option value="<?=getCurrentLink(['page','perpage','field','value'])?>perpage=100"<?=(!empty($_GET['perpage']) && $_GET['perpage'] == 100)?' selected="selected"':''?>>100</option>
										</select>
                                    </div>
                                </div>
                            </form>
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