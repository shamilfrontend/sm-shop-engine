<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Слайдеры</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li class="active"><i class="fa fa-picture-o"></i> Слайдеры</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<script type="text/javascript">
			function confirmUser($id) {
				$(document).ready(function() {
					swal({
							title: "Вы действительно хотите удалить слайдер?",
							text: "Внимание! Так же будут удалены все связи со слайдерами если они есть!",
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
									text: 'Слайдер успешно удален!',
									type: 'success'
								}, function() {window.location = "?view=remove_slider&csrf_token=<?=$_SESSION['auth']['csrf_token']?>&slider_id=" + $id;});
							} else {
								swal("Отмена!", "Предыдущее действие было отменено!", "error");
							}
						});
				});
			}
		</script>
		<div class="row">
			<div class="col-lg-12">
				<h2>Слайдеры в системе</h2>
				<a href="?view=add_slider" class="btn btn-sm btn-primary">Добавить слайдер</a><br><br>
				<?php if (is_array($objects) && !empty($objects)): ?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Название</th>
								<th>callname</th>
								<th>Дата создания</th>
								<th>Действие</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($objects as $object): ?>
							<tr>
								<td><?=$object["slider_id"]?></td>
								<td><?=$object["slider_name"]?></td>
								<td><?=$object["slider_callname"]?></td>
								<td><?=date_format(date_create($object["slider_datecreate"]), 'd.m.Y H:i')?></td>
								<td style="text-align:center;">
									<a href="?view=update_slider&slider_id=<?=$object["slider_id"]?>" type="button" class="btn btn-sm btn-success">Изменить</a>
									<a href="#" onclick='confirmUser(<?=$object["slider_id"]?>);return false;' type="button" class="btn btn-sm btn-danger">Удалить</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<?=pageNavi()?>
				<?php else: ?>
				<div class="alert alert-warning">
					<strong>Слайдеров не найдено!</strong> слайдеров пока нет, добавьте первый!
				</div>
				<?php endif; ?>
			</div>

		</div>
		<!-- /.row -->


	</div>
	<!-- /.container-fluid -->

</div>