<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
    <div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">
					Панель <small>Администратора</small>
				</h1>
				<ol class="breadcrumb">
					<li class="active">
						<i class="fa fa-dashboard"></i> Панель
					</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);} ?>
			</div>
		</div>
		<!-- /.row -->
		<script type="text/javascript">
			function confirmUser($id, $text, $prefix) {
				$(document).ready(function() {
					swal({
							title: "Вы действительно хотите удалить "+$text+"?",
							text: "Внимание! Так же будут удалены все связи если они есть!",
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
									text: $text + ' успешно удален!',
									type: 'success'
								}, function() {window.location = "?view=remove_"+$prefix+"&csrf_token=<?=$_SESSION['auth']['csrf_token']?>&"+$prefix+"_id=" + $id;});
							} else {
								swal("Отмена!", "Предыдущее действие было отменено!", "error");
							}
						});
				});
			}
		</script>
		<div class="row">
			<div class="col-lg-12">
				<div class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="fa fa-info-circle"></i> <strong>Добро пожаловать! <?=$_SESSION['auth']['user_login']?></strong>. Текущая версия панели администратора <a class="alert-link"><?=VERSION?></a>!
				</div>
				<?php if ($_SESSION['auth']['user_status'] == 1): ?>
				<div class="alert alert-warning alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="fa fa-info-circle"></i> <strong>Внимание!</strong> Большая часть функций системы для Вас ограниченны!
				</div>
				<?php endif; ?>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<h2>Обратная связь</h2>
				<?php if (is_array($objects_cal) && !empty($objects_cal)): ?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Имя</th>
								<th>Телефон</th>
								<th>Статус</th>
								<th>Дата</th>
								<th>Действие</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($objects_cal as $item): ?>
							<tr>
								<td><?=$item["call_name"]?></td>
								<td><?=$item["call_phone"]?></td>
								<td><?=(!$item["call_proof"])?'<span style="color:red;">Не подтвержден</span>':'<span style="color:green;">Подтвержден</span>'?></td>
								<td> <?=date_format(date_create($item["call_date"]), 'd.m.Y H:i')?></td>
								<td style="text-align:center;">
									<a href="?view=feedback&id=<?=$item["call_id"]?>" type="button" class="btn btn-sm btn-success">Подробнее</a>
									<?php if (!$item["call_proof"]): ?><a href="?view=proof_feedback&csrf_token=<?=$_SESSION['auth']['csrf_token']?>&feedback_id=<?=$item["call_id"]?>" type="button" class="btn btn-sm btn-primary">Подтвердить</a><?php endif; ?>
									<a href="#" onclick='confirmUser(<?=$item["call_id"]?>,"заявку", "feedback");return false;' type="button" class="btn btn-sm btn-danger">Удалить</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<?=pageNavi()?>
				<?php else: ?>
				<div class="alert alert-warning alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="fa fa-info-circle"></i> <strong>Нет новых заявок</strong>
				</div>
				<?php endif; ?>

				<?php if ($config["modules"]->orders->active): ?>
				<h2>Новые заказы</h2>
				<?php if (is_array($objects_ord) && !empty($objects_ord)): ?>
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
							<?php foreach($objects_ord as $object): ?>
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
										<a href="#" onclick='confirmUser(<?=$object["order_id"]?>,"заказ", "order");return false;' type="button" class="btn btn-sm btn-danger">Удалить</a>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>

				<?php else: ?>
					<div class="alert alert-warning alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<i class="fa fa-info-circle"></i> <strong>Нет новых заказов</strong>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			</div>
		</div>
		<!-- /.row -->

	</div>
	<!-- /.container-fluid -->

</div>