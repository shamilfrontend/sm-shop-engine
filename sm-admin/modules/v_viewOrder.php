<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Просмотр заказа</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li><i class="fa fa-credit-card"></i><a href="?view=orders"> Заказы</a></li>
					<li class="active"><i class="fa fa-credit-card"></i> Просмотр заказа</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-8">
				<div class="form-group"><label>ID заказа:</label> <?=$object['order_id']?></div>
				<div class="form-group"><label>Статус заказа:</label> <?=(!$object["order_proof"])?'<span style="color:red;">Не подтвержден</span>':'<span style="color:green;">Подтвержден</span>'?></div>
				<div class="form-group"><label>Дата заявки:</label> <?=date_format(date_create($object["order_date"]), 'd.m.Y H:i')?></div>
				<div class="form-group"><label>ID пользователя:</label> <?=$object['user_id']?></div>
				<div class="form-group"><label>Ф.И.О заказчика:</label> <?=$object['order_name']?></div>
				<div class="form-group"><label>Номер заказчика:</label> <?=$object['order_phone']?></div>
				<div class="form-group"><label>Почта заказчика:</label> <?=$object['order_email']?></div>
				<div class="form-group"><label>Сообщение:</label> <?=$object['order_message']?></div>
				<hr><h3>Товары:</h3>
				<?php if (!empty($object['products']) && is_array($object['products'])): $sum = ''; $sumDisc = ''; ?>
					<?php foreach($object['products'] as $item): $sum += ($item['product_price'] * $item['qty']); $sumDisc += (getPriceDiscount($item['product_price'], $item['product_discount']) * $item['qty']); ?>
						<div style="padding:12px;border:2px dashed #000;margin-bottom: 10px;">
							<div class="form-group"><label>Артикул/Наименование:</label> [<?=$item['product_article']?>] <?=$item['product_title']?> | <a href="/product/<?=$item['product_slug']?>/" target="_blank">Просмотр</a></div>
							<div class="form-group"><label>Цена:</label> <?=$item['product_price']?></div>
							<div class="form-group"><label>Скидка:</label> <?=$item['product_discount']?></div>
							<div class="form-group"><label>Цена со скидкой:</label> <?=getPriceDiscount($item['product_price'], $item['product_discount'])?></div>
							<div class="form-group"><label>Кол-во позиций:</label> <?=$item['qty']?></div>
							<div class="form-group"><label>Итого:</label> <?=($item['qty'] * getPriceDiscount($item['product_price'], $item['product_discount']))?></div>
						</div>
					<?php endforeach; ?>

					<div class="form-group"><label>Итого:</label> <?=$sum?></div>
					<div class="form-group"><label>Итого со скидкой:</label> <?=$sumDisc?></div>
				<?php endif;?>

			</div><!-- lg-8 -->
			<?=cArgs()?>
		</div>
		<!-- /.row -->
	</div>
</div>