<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Пользователи</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li class="active"><i class="fa fa-group"></i> Пользователи</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<script type="text/javascript">
			function confirmUser($id) {
				var ask = confirm("Вы действительно хотите удалить пользователя?!");
				if (ask) {window.location = "?view=remove_user&csrf_token=<?=$_SESSION['auth']['csrf_token']?>&user_id=" + $id + "";}
			}
		</script>
		<div class="row">
			<div class="col-lg-12">
				<h2>Пользователи в системе</h2>
				<a href="?view=add_user" class="btn btn-sm btn-primary">Добавить пользователя</a><br><br>
				<?php if (is_array($objects) && !empty($objects)): ?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Никнейм</th>
								<th>Почта</th>
								<th>Роль</th>
								<th>Дата регистрации</th>
								<th>Действие</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($objects as $object): ?>
							<tr>
								<td><?=$object["user_id"]?></td>
								<td><?=$object["user_login"]?></td>
								<td><?=$object["user_email"]?></td>
								<td><?=($object["user_status"]==2?'<span style="color:green;">Пользователь</span>':($object["user_status"]==3?'<span style="color:red;">Администратор</span>':(($object["user_status"]==1)?'<span style="color:rgb(224, 148, 35);">Демо пользователь</span>':'<span style="color:rgb(35, 91, 224);">Менеджер</span>')))?></td>
								<td><?=date_format(date_create($object["user_date"]), 'd.m.Y H:i')?></td>
								<td style="text-align:center;">
									<a href="/sm-admin/?view=update_user&user_id=<?=$object["user_id"]?>" type="button" class="btn btn-sm btn-success">Изменить</a>
									<a href="#" onclick='confirmUser(<?=$object["user_id"]?>);return false;' type="button" class="btn btn-sm btn-danger">Удалить</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<?=pageNavi()?>
				<?php else: ?>
				<div class="alert alert-warning">
					<strong>Пользователей не найдено!</strong> пользователей пока нет, добавьте первого!
				</div>
				<?php endif; ?>
			</div>

		</div>
		<!-- /.row -->


	</div>
	<!-- /.container-fluid -->

</div>