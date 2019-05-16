<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Модули</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li><i class="fa fa-cogs"></i> Система</li>
					<li class="active"><i class="fa fa-wrench"></i> Модули</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-12">
				<h2>Системные модули</h2>
				<?php if (is_object($objects) && !empty($objects)): ?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Название</th>
								<th>Описание</th>
								<th>Действие</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($objects as $ID => $object): ?>
							<tr>
								<td><?=$ID?></td>
								<td><?=$object->name?></td>
								<td><?=$object->description?></td>
								<td style="text-align:center;">
									<?php if ($object->active == 0): ?>
									<a href="?view=modules&csrf_token=<?=$_SESSION['auth']['csrf_token']?>&action=activate&module=<?=$ID?>" type="button" class="btn btn-sm btn-success">Активировать</a>
									<?php else: ?>
									<a href="?view=modules&csrf_token=<?=$_SESSION['auth']['csrf_token']?>&action=shutoff&module=<?=$ID?>" type="button" class="btn btn-sm btn-danger">Отключить</a>
									<?php endif; ?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<?php else: ?>
				<div class="alert alert-warning">
					<strong>Модулей не найдено!</strong>
				</div>
				<?php endif; ?>
			</div>

		</div>
		<!-- /.row -->


	</div>
	<!-- /.container-fluid -->

</div>