<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Страницы</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li class="active"><i class="fa fa-copy"></i> Страницы</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<script type="text/javascript">
			function confirmUser($id) {
				$(document).ready(function() {
					swal({
					  title: "Вы действительно хотите удалить страницу?",
					  text: "Внимание! Так же будут удалены все связи со страницами!",
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
								text: 'Страница успешно удалена!',
								type: 'success'
							}, function() {window.location = "?view=remove_page&csrf_token=<?=$_SESSION['auth']['csrf_token']?>&page_id=" + $id;});
					  } else {
							swal("Отмена!", "Предыдущее действие было отменено!", "error");
					  }
					});
				});
 			}
		</script>
		<div class="row">
			<div class="col-lg-12">
				<h2>Страницы в системе</h2>
				<a href="?view=add_page" class="btn btn-sm btn-primary">Добавить страницу</a><br><br>
				<?php if (is_array($objects) && !empty($objects)): ?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Заголовок</th>
								<th>Дата публикации</th>
								<th>Дата изменения</th>
								<th>Действие</th>
							</tr>
						</thead>
						<tbody>
							<?=createObjectsTree($objects, 'page', 'table')?>
						</tbody>
					</table>
				</div>
				<?=pageNavi()?>
				<?php else: ?>
				<div class="alert alert-warning">
					<strong>Страниц не найдено!</strong> страниц пока нет, добавьте первую!
				</div>
				<?php endif; ?>
			</div>

		</div>
		<!-- /.row -->


	</div>
	<!-- /.container-fluid -->

</div>