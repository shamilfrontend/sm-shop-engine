<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Заказы</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li class="active"><i class="fa fa-credit-card"></i> Заказы</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<script type="text/javascript">
			function confirmUser($id) {
				$(document).ready(function() {
					swal({
							title: "Вы действительно хотите удалить заказ?",
							text: "Внимание! Так же будут удалены все связи с заказами если они есть!",
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
									text: 'Заказ успешно удален!',
									type: 'success'
								}, function() {window.location = "?view=remove_order&csrf_token=<?=$_SESSION['auth']['csrf_token']?>&order_id=" + $id;});
							} else {
								swal("Отмена!", "Предыдущее действие было отменено!", "error");
							}
						});
				});
			}
		</script>
		<div class="row">
			<div class="col-lg-12">
				<h2>Заказы в ит-магазине</h2>
				<?php if (is_array($objects) && !empty($objects)): ?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Ф.И.О</th>
								<th>Номер</th>
								<th>Сумма</th>
								<th>Статус</th>
								<th>Дата заявки</th>
								<th>Действие</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($objects as $object): ?>
							<tr>
								<td><?=$object["order_id"]?></td>
								<td><?=$object["order_name"]?></td>
								<td><?=$object["order_phone"]?></td>
								<td><?=$object["order_sum"]?></td>
								<td><?=(!$object["order_proof"])?'<span style="color:red;">Не подтвержден</span>':'<span style="color:green;">Подтвержден</span>'?></td>
								<td><?=date_format(date_create($object["order_date"]), 'd.m.Y H:i')?></td>
								<td style="text-align:center;">
									<a href="?view=view_order&order_id=<?=$object["order_id"]?>" type="button" class="btn btn-sm btn-success">Просмотреть</a>
									<?php if (!$object["order_proof"]): ?><a href="?view=proof_order&csrf_token=<?=$_SESSION['auth']['csrf_token']?>&order_id=<?=$object["order_id"]?>" type="button" class="btn btn-sm btn-primary">Подтвердить</a><?php endif; ?>
									<a href="#" onclick='confirmUser(<?=$object["order_id"]?>);return false;' type="button" class="btn btn-sm btn-danger">Удалить</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<?=pageNavi()?>
				<?php else: ?>
				<div class="alert alert-warning">
					<strong>Заказов не найдено!</strong> подождите немного, возможно скоро сдесь появится Ваш первый заказ!
				</div>
				<?php endif; ?>
			</div>

		</div>
		<!-- /.row -->


	</div>
	<!-- /.container-fluid -->

</div>