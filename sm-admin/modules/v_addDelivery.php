<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Добавить новый способ доставки</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li><i class="fa fa-truck"></i><a href="?view=delivery"> Способы доставки</a></li>
					<li class="active"><i class="fa fa-ambulance"></i> Добавить новый способ доставки</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<script>
			$(document).ready(function() {
				$(".toggleClass").click(function(event) {
					event.preventDefault();
					var object = $(this).parent().next();
					var display = object.attr("data-active");
					object.slideToggle("slow");
					
					if (display == "true") {
						$(this).html('показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i>');
						object.attr("data-active", "false");
					} else {
						$(this).html('скрыть предупреждение. &nbsp;&nbsp;&nbsp;<i class="fa fa-sort-asc" style="vertical-align: sub;"></i>');				
						object.attr("data-active", "true");
					}	
				});
				
			});

		</script>
		<div class="row">
			<form action="?view=add_delivery&csrf_token=<?=$_SESSION['auth']['csrf_token']?>" method="POST" role="form" enctype="multipart/form-data">
				<div class="col-lg-8">		
					<div class="form-group">
						<label for="title">Название способа<span style="color:red;font-size:18px;">*</span>:</label>
						<input id="title" class="form-control" name="title" value="<?=_arg('title')?>">
					</div>

					<div class="form-group">
						<label for="name">Вызов способа<span style="color:red;font-size:18px;">*</span>:</label>
						<input id="name" class="form-control" name="name" value="<?=_arg('name')?>">
					</div>

					<div class="form-group">
						<label for="description">Описание способа<span style="color:red;font-size:18px;">*</span>:</label>
						<textarea id="description" class="form-control" name="description"><?=_arg('description')?></textarea>
					</div>
					<button type="submit" class="btn btn-success">Добавить новый способ доставки</button>
				</div><!-- lg-8 -->
			</form><?=cArgs()?>
		</div>
		<!-- /.row -->
	</div>
</div>