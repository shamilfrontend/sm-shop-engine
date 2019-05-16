<?php defined("_SMARTMEDIA") or die(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="content">
				<div class="breadcrumbs">
					<ul class="breadcrumbs__list">
						<li class="breadcrumbs__item">
							<a href="/" class="breadcrumbs__link">Главная</a>
						</li>
						<li class="breadcrumbs__item">
							<span class="breadcrumbs__nolink">Корзина</span>
						</li>
					</ul>
				</div>
				<h3 class="content__title">Корзина</h3>
				<?php if (!empty($_SESSION['answer'])) {echo $_SESSION['answer'];unset($_SESSION['answer']);} ?>
				<?php if (!empty($_SESSION['shopbag'])): ?>
				<form method="POST" action="/shopbag/?action=counted">
					<ul class="cart-list">
						<li class="cart-top">
							<div class="item numb_tovar"><p>№</p></div>
							<div class="item name_tovar"><p>Название товара</p></div>
							<div class="item count_tovar"><p>Вес (кг)</p></div>
							<div class="item one_tovar"><p>Цена за 1кг</p></div>
							<div class="item summ_tovar"><p>Сумма</p></div>
							<div class="item del_tovar"><p><i class="fa fa-trash"></i></p></div>
						</li>
						<?php $i=0; foreach($_SESSION['shopbag'] as $itemId => $item): $i++; ?>
						<li class="cart-item">
							<div class="item numb_tovar"><p><?=$i?></p></div>
							<div class="item img_tovar">
								<p><a href="/product/<?=$item['product_slug']?>/"><?=getImg($item, 'product', true)?></a></p>
							</div>
							<div class="item name_tovar">
								<p><a href="/product/<?=$item['product_slug']?>/"><?=getProductName($item, 'product', true)?></a></p>
							</div>
							<div class="item count_tovar">
								<div class="counter">
									<button class="counter__minus">-</button>
									<input class="counter__count" type="text" placeholder="Количество" value="<?=$item['qty']?>" disabled="disabled" data-id="<?=$i?>" data-price="<?=($item['product_discount'] > 0)?getPriceDiscount($item['product_price'], $item['product_discount']):$item['product_price']?>">
									<button class="counter__plus">+</button>
								</div>
								<input type="hidden" name="product[<?=$itemId?>]" value="<?=$item['qty']?>">
							</div>
							<div class="item one_tovar">
								<?php if ($item['product_discount'] > 0): ?><p><s><?=$item['product_price']?></s></p><?php else: ?><p><?=$item['product_price']?></p><?php endif; ?>
								<?php if ($item['product_discount'] > 0): ?><p><?=$item['product_priceWithDiscount']?></p><?php endif; ?>
								<?php if ($item['product_discount'] > 0): ?><p>Скидка: <?=$item['product_discount']?></p><?php endif; ?>
							</div>
							<div class="item summ_tovar">
								<p id="total_sum<?=$i?>"><?=($item['product_priceWithDiscount']*$item['qty'])?></p>
							</div>
							<div class="item del_tovar">
								<p>
									<a href="/shopbag/?action=remove&product_id=<?=$itemId?>">
										<i class="fa fa-trash"></i>
									</a>
								</p>
							</div>
						</li>
						<?php endforeach; ?>
						<li class="cart-item" id="counted" style="display: none;"><p class="alert alert-danger summa" style="padding: 5px 25px;"><strong>Внимание!</strong> В корзине произошли изменения, необходим пересчет!</p></li>
						<li class="cart-item"><p class="summa">Сумма без скидки <span><?=$_SESSION['total_sum']?></span></p></li>
						<li class="cart-item"><p class="summa">Сумма скидки <span><?=$_SESSION['total_sum_discount']?></span></p></li>
						<li class="cart-item"><p class="summa">Сумма с учетом скидки <span><?=$_SESSION['total_sum_withDiscount']?></span></p></li>
						<li class="cart-top">
							<div class="btn-group">
								<a href="/shopbag/?action=clear" class="cart-top__btn">Очистить корзину</a>
								<input type="submit" value="Пересчитать" class="cart-top__btn">
							</div>
						</li>
					</ul>
				</form>
				<div class="cart-order">
					<h3>Оформление заказа</h3>
					<div class="row">
						<div class="col-md-12">
							<div class="order-fast">
								<form method="POST" action="/shopbag/?action=order">
									<input type="text" name="name" placeholder="ФИО * " required value="<?=getUserName(!empty($_SESSION['auth'])?$_SESSION['auth']:'')?>">
									<input type="text" name="address" placeholder="Адрес доставки * " required value="<?=!empty($_SESSION['auth']['user_address'])?$_SESSION['auth']['user_address']:''?>">
									<input type="tel"  name="phone" class="myphone" placeholder="Ваш телефон *" value="<?=!empty($_SESSION['auth']['user_phone'])?$_SESSION['auth']['user_phone']:''?>">
									<input type="email" name="email" class="" placeholder="Ваш email" value="<?=!empty($_SESSION['auth']['user_email'])?$_SESSION['auth']['user_email']:''?>">
									<textarea placeholder="Примечание.." name="message"></textarea>
									<button type="submit">Оформить заказ</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<?php else: ?>
					<div>
						<h1>Корзина пуста ;(</h1>
						<p>В корзине пока нет товаров, но вы можете закинуть сюда парочку ;)</p>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>