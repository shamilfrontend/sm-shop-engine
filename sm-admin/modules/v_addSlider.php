<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Добавить слайдер</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li><i class="fa fa-picture-o"></i><a href="?view=sliders"> Слайдеры</a></li>
					<li class="active"><i class="fa fa-file-image-o"></i> Добавить слайдер</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<style type="text/css">
			.alert a {text-decoration: none;}
			.remove {
				padding: 6px 11px;
				margin-right: 5px;
				border: 1px solid #000;
			}
			.remove:hover {
				background: #D9534F;
				color: #fff;
				border: 1px solid #ac2925;
				cursor: pointer;
			}
		</style>
		<script>
			function InsertMedia() {
				//window.onload = function() {
					document.getElementById("mceu_18").click();
				//};
			}
			
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
				
				$(document).delegate('.remove', 'click', function() {			
					var typeID = $(this).parent().parent().attr('id');
					$(this).parent().remove();
					if (typeID == "paramsmedia") {
						if ($("#paramsmedia > div").length < 1) $("#removeParamMedia").attr("disabled", true);
					}
					
					if (typeID == "params") {
						if ($("#params > div").length < 1) $("#removeParam").attr("disabled", true);
					}
					
				});
				
			});
		</script>
		<div class="row">
			<div class="col-lg-8">
				<form action="?view=add_slider&csrf_token=<?=$_SESSION['auth']['csrf_token']?>" method="POST" role="form" enctype="multipart/form-data">
					
					<div class="form-group">
						<label for="name">Название слайдера<span style="color:red;font-size:18px;">*</span>:</label>
						<input id="name" class="form-control" name="name" value="<?=_arg('name')?>">
					</div>

					<div class="form-group">
						<label for="callname">callname<span style="color:red;font-size:18px;">*</span>:</label>
						<input id="callname" class="form-control" name="callname" value="<?=_arg('callname')?>">
					</div>

					<div class="form-group">
						<label for="visible">Скрыть слайдер?</label> Да&nbsp;<input id="visible" type="radio" name="visible" value="0"<?=(_arg('visible')===0?' checked="checked"':'')?>>&nbsp;&nbsp;Нет&nbsp;<input type="radio" name="visible" value="1"<?=(_arg('visible')?' checked="checked"':'')?><?=(_arg('visible')===false?' checked="checked"':'')?>>
					</div>

					<div class="form-group" style="border: 1px dashed #d9534f;padding: 8px;">
						<script>
							$(document).ready(function() {
								var pagegalleryMax = 8; var pagegalleryMin = 1; var video = 0;
								$("#removeGalleryField").attr("disabled", true);
								$("#addGalleyField").click(function() {
									var pagegalleryTotal = $("#slidergallery > div").length;
									if (pagegalleryTotal < pagegalleryMax) {
										video = video + 1;
										$("#slidergallery").append(
											'<div style="border: 1px dashed #000000;padding: 8px;margin-top: 5px;">' +
											'<label style="width:100%">Заголовок слайда' +
												'<input type="text" name="title[]" class="form-control">' +
													'</label>' +
													'<label style="width:100%">Ссылка заголовка' +
												'<input type="text" name="link[]" class="form-control">' +
													'</label>' +
													'<label style="width:100%">Открывать ссылку в новом окне?' +
														'Да&nbsp;<input type="radio" name="blank[' + video + ']" value="1">' +
													'&nbsp;&nbsp;' +
														'Нет&nbsp;<input type="radio" name="blank[' + video + ']" value="0" checked="checked">' +
													'</label>' +
													'<label style="width:100%">Текст' +
													'<input type="text" name="text[]" class="form-control">' +
													'</label>' +
													'<label style="width:100%">Видео слайд?' +
												'Да&nbsp;<input type="radio" name="video[' + video + ']" value="1">' +
													'&nbsp;&nbsp;' +
												'Нет&nbsp;<input type="radio" name="video[' + video + ']" value="0" checked="checked">' +
													'</label>' +
													'<label style="width:100%">Cлайд' +
													'<input type="file" name="slider[]" />' +
													'<div style="display:none;"><span style="color: #999;">https://www.youtube.com/watch?v=</span><input style="max-width: 200px; display: inline;" type="text" name="videourl[]" class="form-control" placeholder="60wV6_GCfZU"></div>' +
											'</label>' +
												'</div>'
										);
										if (pagegalleryMax == pagegalleryTotal + 1) {
											$("#addGalleyField").attr("disabled", true);
										}
										$("#removeGalleryField").removeAttr("disabled");
									}
								});
								$("#removeGalleryField").click(function() {
									var pagegalleryTotal = $("#slidergallery > div").length;
									if (pagegalleryTotal > pagegalleryMin) {
									   $("#slidergallery div:last-child").remove();
									   if (pagegalleryMin == pagegalleryTotal - 1) {
											$("#removeGalleryField").attr("disabled", true);
										   	video = video - 1;
									   }
									   $("#addGalleyField").removeAttr("disabled");
									}
								});
							});

							$(document).delegate("input[name*='video']", 'click', function() {
								if ($(this).val() == 1) {
									$(this).parent().next().children(":first-child").fadeOut(400, function(){
										$(this).next().fadeIn(400);
									});
								} else {
									$(this).parent().next().children(":last-child").fadeOut(400, function(){
										$(this).prev().fadeIn(400);
									});
								}
							});
						</script>
						<label for="slidergallery">Слайды:</label>
						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Размер миниютюр слайдов задается в настройках. Текущий размер: <b><?=$config["settings"]->sliders_imgsize->value[0]?>x<?=$config["settings"]->sliders_imgsize->value[1]?></b><br>Значения полей <b>заголовка</b> и <b>текста</b> допускают использование html, javascript тегов.<br>Максимальное кол-во слайдов при добавлении 8, если нужно добавить ещё то редактируйте слайд после его добавления.</div>
						<div id="slidergallery">
							<div style="border: 1px dashed #000000;padding: 8px;">
								<label style="width:100%">Заголовок слайда
									<input type="text" name="title[]" class="form-control">
								</label>
								<label style="width:100%">Ссылка заголовка
									<input type="text" name="link[]" class="form-control">
								</label>
								<label style="width:100%">Открывать ссылку в новом окне?
									Да&nbsp;<input type="radio" name="blank[0]" value="1">
									&nbsp;&nbsp;
									Нет&nbsp;<input type="radio" name="blank[0]" value="0" checked="checked">
								</label>
								<label style="width:100%">Текст
									<input type="text" name="text[]" class="form-control">
								</label>
								<label style="width:100%">Видео слайд?
									Да&nbsp;<input type="radio" name="video[0]" value="1">
								&nbsp;&nbsp;
									Нет&nbsp;<input type="radio" name="video[0]" value="0" checked="checked">
								</label>
								<label style="width:100%">Cлайд
									<input type="file" name="slider[]" />
									<div style="display:none;"><span style="color: #999;">https://www.youtube.com/watch?v=</span><input style="max-width: 200px; display: inline;" type="text" name="videourl[]" class="form-control" placeholder="60wV6_GCfZU"></div>
								</label>
							</div>
						</div>

						<div style="margin-top:5px;">
							<input type="button" class="btn btn-info" id="addGalleyField" value="Добавить слайд" />
							<input type="button" class="btn btn-danger" id="removeGalleryField" value="Удалить слайд" />
						</div>
					</div>

					<div class="form-group" style="border: 1px dashed #d9534f;padding: 8px;">
						<label>Произвольные поля:</label>
						
						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Значения произвольных полей допускают использование html, javascript тегов. <br>Максимальное кол-во произвольных полей 16 думаю больше и не понадобиться.</div>

						<script>
							jQuery(document).ready(function() {
								var paramsMax = 16; var paramsMin = 0;
								var paramsTotal = $("#params > .addParam").length;
								if (paramsTotal < 1) $("#removeParam").attr("disabled", true);
								//Произвольные поля
								jQuery('#addParam').click(function(){
									var paramsTotal = $("#params > .addParam").length;
									if (paramsTotal < paramsMax) {
										jQuery('#params').append('<div class="addParam" style="margin-bottom:8px;"><span class="remove">Х</span><input class="form-control" type="text" name="params[]" style="display:inline-block;width:35%;" placeholder="название" />&nbsp;:&nbsp;<input class="form-control" type="text" name="values[]" style="display:inline-block;width:50%;" placeholder="значение" /></div>');
										if (paramsMax == paramsTotal + 1) {
											$("#addParam").attr("disabled", true);
										}
										$("#removeParam").removeAttr("disabled");
									}
								});
								
								jQuery('#removeParam').click(function() {
									var paramsTotal = $("#params > .addParam").length;
									if (paramsTotal > paramsMin) {
									   jQuery('.addParam:last').remove();
									   if (paramsMin == paramsTotal - 1) {
											$("#removeParam").attr("disabled", true);
									   }
									   $("#addParam").removeAttr("disabled");
									}
								});	
								
							});
						</script>
						<div id="params">
						<?php if (is_array(_arg('params'))): ?>
							<?php foreach(_arg('params') as $k => $v): ?>
							<div class="addParam" style="margin-bottom:8px;">
								<span class="remove">Х</span>
								<input class="form-control" type="text" name="params[]" style="display:inline-block;width:35%;" placeholder="название" value="<?=$k?>" />&nbsp;:&nbsp;<input class="form-control" type="text" name="values[]" style="display:inline-block;width:50%;" placeholder="значение" value="<?=htmlspecialchars(getValue($v))?>"/>
							</div>
							<?php endforeach; ?>
						<?php endif; ?>
						</div>
						<input id="addParam" type="button" value="Добавить" class="btn btn-info" />&nbsp;|&nbsp;<input id="removeParam" type="button" value="Удалить" class="btn btn-danger" />
					</div>
					
					<button type="submit" class="btn btn-success">Добавить слайдер</button>

				</form><?=cArgs()?>

			</div>
		</div>
		<!-- /.row -->
	</div>
</div>