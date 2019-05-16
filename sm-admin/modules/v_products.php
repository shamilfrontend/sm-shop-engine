<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Товары</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li><i class="fa fa-shopping-basket"></i> Магазин</li>
					<li class="active"><i class="fa fa-shopping-cart"></i> Товары</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<script type="text/javascript">
			function confirmUser($id) {
				$(document).ready(function() {
					swal({
					  title: "Вы действительно хотите удалить товар?",
					  text: "Внимание! Так же будут удалены все связи с товарами если они есть!",
					  type: "warning",
					  showCancelButton: true,
					  confirmButtonColor: "#DD6B55",
					  confirmButtonText: "Да, удалить!",
					  cancelButtonText: "Нет, оставить как есть!",
					  closeOnConfirm: false,
					  closeOnCancel: false
					},
					function(isConfirm) {
					  if (isConfirm) {						
							swal({
								title: 'Действие выполнено!',
								text: 'Товар успешно удален!',
								type: 'success'
							}, function() {window.location = "?view=remove_product&csrf_token=<?=$_SESSION['auth']['csrf_token']?>&product_id=" + $id;});
					  } else {
							swal("Отмена!", "Предыдущее действие было отменено!", "error");
					  }
					});
				});
			}
		</script>
		<div class="row">
			<div class="col-lg-12">
				<h2>Товары в магазине</h2>
				<div style="margin-bottom:4px;">
					<div style="margin-bottom:4px;">
						<a href="?view=add_product" class="btn btn-sm btn-primary">Добавить товар</a> 
						<a href="?view=products" class="btn btn-sm btn-default">Сбросить фильтры</a>
					</div>
					<!--form style="display:inline;">
						<select name="action" class="form-control" style="display: inline;min-width: 140px;width: 0px;height: 31px;padding-top: 5px;">
							<option value="-1" selected="selected">Действия</option>
							<option value="trash">Удалить</option>
							<option value="trash">Опубликовать</option>
							<option value="trash">Скрыть</option>
						</select>
						<a href="?view=add_post" class="btn btn-sm btn-default">Применить</a> | 
					</form>
					<form style="display:inline;">
						<select name="action" class="form-control" style="display: inline;min-width: 140px;width: 0px;height: 31px;padding-top: 5px;">
							<option value="-1" selected="selected">Все даты</option>
							<option value="trash">Удалить</option>
							<option value="trash">Опубликовать</option>
							<option value="trash">Скрыть</option>
						</select>
						<select name="action" class="form-control" style="display: inline;min-width: 140px;width: 0px;height: 31px;padding-top: 5px;">
							<option value="-1" selected="selected">Все рубрики</option>
							<option value="trash">Удалить</option>
							<option value="trash">Опубликовать</option>
							<option value="trash">Скрыть</option>
						</select>
						<a href="?view=add_post" class="btn btn-sm btn-default">Фильтр</a>
					</form-->
				</div>
				<?php if (is_array($objects) && !empty($objects)): ?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Наименование</th>
								<th>Артикул</th>
								<th>Автор</th>
								<th>Категория</th>
								<th>Цена</th>
								<th>Дата</th>
								<th>Действие</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($objects as $object): ?>
							<tr>
								<td><?=$object["product_id"]?></td>
								<td><?=$object["product_title"]?></td>
								<td><a href="/product/<?=$object["product_slug"]?>/" target="_blank"><?=$object["product_article"]?></a></td>
								<td><?=getUserNameByAdmin(['user_id'=>$object["user_id"],'user_login'=>$object["user_login"],'user_name'=>$object["user_name"],'user_surname'=>$object["user_surname"],'user_middlename'=>$object["user_middlename"]])?></td>
								<td>
									<?php $object['objectNames'] = explode('|', $object['objectNames']); ?>
									<?php $object['objectIds'] = explode('|', $object['objectIds']); ?>
									<?php 
										if (!empty($object['objectNames'][0])) {
											foreach($object['objectNames'] as $key => $value) {
												echo '<a href="?view=products&order_by=product_id&field=cat_id&value=' . $object['objectIds'][$key] . '">' . $value . '</a>' . ((count($object['objectNames']) > $key + 1) ? ', ' : '');
											}
										} else {
											echo "&mdash;";
										}
									?>
								</td>
								<td>Цена: <?=$object["product_price"]?><br>Скидка: <?=$object["product_discount"]?><br>Стоимость: <?=getPriceDiscount($object["product_price"], $object["product_discount"])?></td>
								<td>Публикация: <?=date_format(date_create($object["product_datecreate"]), 'd.m.Y H:i')?><br>Изменения: <?=date_format(date_create($object["product_dateupdate"]), 'd.m.Y H:i')?><br>Статус: <?=($object["product_visible"]==1?'<span style="color:green;">Опубликовано</span>':'<span style="color:red;">Скрыто</span>')?></td>
								<td style="text-align:center;vertical-align:middle;">
									<a href="?view=update_product&product_id=<?=$object["product_id"]?>" type="button" class="btn btn-sm btn-success">Изменить</a>
									<a href="#" onclick='confirmUser(<?=$object["product_id"]?>);return false;' type="button" class="btn btn-sm btn-danger">Удалить</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<?=pageNavi()?>
				<?php else: ?>
				<div class="alert alert-warning">
					<strong>Товаров не найдено!</strong> товаров пока нет, добавьте первый!
				</div>
				<?php endif; ?>
			</div>

		</div>
		<!-- /.row -->


	</div>
	<!-- /.container-fluid -->

</div>