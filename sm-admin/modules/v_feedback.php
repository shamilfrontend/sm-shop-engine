<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Заявки</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li class="active"><i class="fa fa-life-ring"></i> Заявки</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->

		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-3 text-center">
						<div class="panel panel-default">
							<div class="panel-body">
								<b>Имя:</b> <?=$object["call_name"]?>
							</div>
						</div>
					</div>
					<div class="col-lg-3 text-center">
						<div class="panel panel-default">
							<div class="panel-body">
								<b>Телефон:</b> <?=$object["call_phone"]?>
							</div>
						</div>
					</div>
					<div class="col-lg-3 text-center">
						<div class="panel panel-default">
							<div class="panel-body">
								<b>Почта:</b> <?=$object["call_email"]?>
							</div>
						</div>
					</div>
					<div class="col-lg-3 text-center">
						<div class="panel panel-default">
							<div class="panel-body">
								<b>Дата:</b> <?=date_format(date_create($object["call_date"]), 'd.m.Y H:i')?>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12 text-center">
						<div class="panel panel-default">
							<div class="panel-body" style="text-align: left;">
								<?=$object["call_message"]?>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- /.row -->


	</div>
	<!-- /.container-fluid -->

</div>