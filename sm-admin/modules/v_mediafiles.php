<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Медиафайлы</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li class="active"><i class="fa fa-fw fa-camera" style="position: relative;top: -3px;left: -2px;color: grey;"></i><i class="fa fa-fw fa-music" style="position: relative;left: -13px;top: 2px;color: grey;"></i><span style="margin-left: -10px;">Медиафайлы<span></li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-12">
				<iframe style="width:100%;min-height:200px;height:600px;border: 1px solid rgb(245, 245, 245);" scrolling="no" src='/library/filemanager/dialog.php?akey=<?=UPLOAD_KEY?>'></iframe>
			</div>

		</div>
		<!-- /.row -->


	</div>
	<!-- /.container-fluid -->

</div>