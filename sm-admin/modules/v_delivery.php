<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Способы доставки</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li class="active"><i class="fa fa-truck"></i> Способы доставки</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<script type="text/javascript">
			function confirmUser($id) {
				$(document).ready(function() {
					swal({
							title: "Вы действительно хотите удалить способ доставки?",
							text: "Внимание! Вы можете нарушить целостность заказов!",
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
									text: 'Способ доставки успешно удален!',
									type: 'success'
								}, function() {window.location = "?view=remove_delivery&csrf_token=<?=$_SESSION['auth']['csrf_token']?>&delivery_id=" + $id;});
							} else {
								swal("Отмена!", "Предыдущее действие было отменено!", "error");
							}
						});
				});
			}
		</script>
		<div class="row">
			<div class="col-lg-12">
				<h2>Способы доставки в ит-магазине</h2>
				<a href="?view=add_delivery" class="btn btn-sm btn-primary">Добавить новый способ доставки</a><br><br>
				<?php if (is_array($objects) && !empty($objects)): ?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Название</th>
								<th>name</th>
								<th>Дата создания</th>
								<th>Действие</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($objects as $object): ?>
							<tr>
								<td><?=$object["delivery_id"]?></td>
								<td><?=$object["delivery_title"]?></td>
								<td><?=$object["delivery_name"]?></td>
								<td><?=date_format(date_create($object["delivery_datecreate"]), 'd.m.Y H:i')?></td>
								<td style="text-align:center;">
									<a href="?view=update_delivery&delivery_id=<?=$object["delivery_id"]?>" type="button" class="btn btn-sm btn-success">Изменить</a>
									<a href="#" onclick='confirmUser(<?=$object["delivery_id"]?>);return false;' type="button" class="btn btn-sm btn-danger">Удалить</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<?=pageNavi()?>
				<?php else: ?>
				<div class="alert alert-warning">
					<strong>Способов доставки не найдено!</strong> способов доставки пока нет, добавьте первый!
				</div>
				<?php endif; ?>
			</div>

		</div>
		<!-- /.row -->


	</div>
	<!-- /.container-fluid -->

</div>