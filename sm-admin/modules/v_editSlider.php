<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Редактор слайдера</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li><i class="fa fa-picture-o"></i><a href="?view=sliders"> Слайдеры</a></li>
					<li class="active"><i class="fa fa-file-image-o"></i> Редактор слайдера</li>
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
			.removeImg {
				border: 1px solid #ac2925;
				margin: 2px;
			}
			.removeImg:hover {
				border: 1px dashed #ac2925;
				cursor: pointer;
			}
		</style>
		<script>
			function InsertMedia() {
				//window.onload = function() {
					document.getElementById("mceu_18").click();
				//};
			}

			function print_r(arr, level) {
				var print_red_text = "";
				if(!level) level = 0;
				var level_padding = "";
				for(var j=0; j<level+1; j++) level_padding += "    ";
				if(typeof(arr) == 'object') {
					for(var item in arr) {
						var value = arr[item];
						if(typeof(value) == 'object') {
							print_red_text += level_padding + "'" + item + "' :\n";
							print_red_text += print_r(value,level+1);
						}
						else
							print_red_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
					}
				}

				else  print_red_text = "===>"+arr+"<===("+typeof(arr)+")";
				return print_red_text;
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

				$(document).delegate('.removeImg', 'click', function(event) {
					event.preventDefault();
					var object = $(this);
					swal({
							title: "Внимание!",
							text: "Вы действительно хотите удалить миниатюру?!",
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
								var dataId = object.attr("data-id");
								var dataRemove = object.attr("data-remove");
								
								$.ajax({
									url: "?view=remove_sliderimg&csrf_token=<?=$_SESSION['auth']['csrf_token']?>",
									type: "POST",
									data: { object_id: dataId, object_remove: dataRemove},
									success: function(response) {
										//response = JSON.parse(response);

										if (response.answer == "success") {
											swal({
												title: 'Действие выполнено!',
												text: 'Слайдер успешно удален!',
												type: 'success'
											}, function() {
												var showObject = object.prev();
												object.fadeOut(400, function() {
													object.remove();
													showObject.fadeIn(400);
													showObject.removeAttr("disabled");
													showObject.parent().parent().next().val('');
												});
											});
										} else {
											//alert(response.answer);
											swal("Отмена!", response.answer, "error");
										}
									}, error: function(response) {
										alert(print_r(response));
										swal("Error!", "Uh-oh, something went wrong!", "error");
									}
								}, 'json');
							} else {
								swal("Отмена!", "Предыдущее действие было отменено!", "error");
							}
						});

				});
				
			});
		</script>
		<div class="row">
			<div class="col-lg-8">
				<form action="?view=update_slider&slider_id=<?=$object['slider_id']?>&csrf_token=<?=$_SESSION['auth']['csrf_token']?>" method="POST" role="form" enctype="multipart/form-data">
					
					<div class="form-group">
						<label for="name">Название слайдера<span style="color:red;font-size:18px;">*</span>:</label>
						<input id="name" class="form-control" name="name" value="<?=$object['slider_name']?>">
					</div>

					<div class="form-group">
						<label for="callname">callname<span style="color:red;font-size:18px;">*</span>:</label>
						<input id="callname" class="form-control" name="callname" value="<?=$object['slider_callname']?>">
					</div>

					<div class="form-group">
						<label for="visible">Скрыть слайдер?</label> Да&nbsp;<input id="visible" type="radio" name="visible" value="0"<?=($object['slider_visible']==0?' checked="checked"':'')?>>&nbsp;&nbsp;Нет&nbsp;<input type="radio" name="visible" value="1"<?=($object['slider_visible']==1?' checked="checked"':'')?>>
					</div>

					<div class="form-group" style="border: 1px dashed #d9534f;padding: 8px;">
						<script>
							$(document).ready(function() {
								var pagegalleryMax = 8; var pagegalleryMin = 1; var video = <?=((count($object['slider_sliders']) == 0) ? 0 : count($object['slider_sliders']) - 1)?>;
								if ($("#slidergallery > div").length < 1) $("#removeGalleryField").attr("disabled", true);
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
											'</label>' + '<input type="hidden" name="cache[]" value="">' +
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
									$(this).parent().next().children(":first-child").fadeOut(400, function() {
										$(this).next().fadeIn(400);
									});
								} else {
									$(this).parent().next().children(":last-child").fadeOut(400, function() {
										$(this).prev().fadeIn(400);
									});
								}
							});
						</script>
						<label for="slidergallery">Слайды:</label>
						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Размер миниютюр слайдов задается в настройках. Текущий размер: <b><?=$config["settings"]->sliders_imgsize->value[0]?>x<?=$config["settings"]->sliders_imgsize->value[1]?></b><br>Значения полей <b>заголовка</b> и <b>текста</b> допускают использование html, javascript тегов.<br>Максимальное кол-во слайдов при добавлении 8, если нужно добавить ещё то редактируйте слайд после его добавления.</div>
						<div id="slidergallery">
							<?php if (!empty($object['slider_sliders']) && is_array($object['slider_sliders'])): $i=0; ?>
								<?php foreach($object['slider_sliders'] as $item): ?>
									<div style="border: 1px dashed #000000;padding: 8px;margin-top: 5px;">
										<label style="width:100%">Заголовок слайда
											<input type="text" name="title[]" class="form-control" value="<?=$item['title']?>">
										</label>
										<label style="width:100%">Ссылка заголовка
											<input type="text" name="link[]" class="form-control" value="<?=$item['link']?>">
										</label>
										<label style="width:100%">Открывать ссылку в новом окне?
											Да&nbsp;<input type="radio" name="blank[<?=$i?>]" value="1"<?php if ($item['blank'] == 1): ?> checked="checked"<?php endif; ?>>
											&nbsp;&nbsp;
											Нет&nbsp;<input type="radio" name="blank[<?=$i?>]" value="0"<?php if ($item['blank'] == 0): ?> checked="checked"<?php endif; ?>>
										</label>
										<label style="width:100%">Текст
											<input type="text" name="text[]" class="form-control" value="<?=$item['text']?>">
										</label>
										<label style="width:100%">Видео слайд?
											Да&nbsp;<input type="radio" name="video[<?=$i?>]" value="1"<?php if ($item['video'] == 1): ?> checked="checked"<?php endif; ?>>
											&nbsp;&nbsp;
											Нет&nbsp;<input type="radio" name="video[<?=$i?>]" value="0"<?php if ($item['video'] == 0): ?> checked="checked"<?php endif; ?>>
										</label>
										<label style="width:100%">Cлайд
											<?php if (!empty($object['slider_sliders']) && !empty($item['slider'])): ?>
												<span class="tooltip-demo" style="display: block;"><input style="display:none;" type="file" name="slider[]" /><img rel="0" data-id="<?=$object['slider_id']?>" data-remove="<?=$item['slider']?>" data-original-title="Для того что бы удалить миниатюру кликните по ней" data-toggle="tooltip" data-placement="top" class="removeImg" width="140" height="140" src="<?=$object['slider_path']?>thumb/<?=$item['slider']?>"></span>
											<?php else: ?>
												<input<?php if ($item['video'] == 1): ?> style="display:none;"<?php endif; ?> type="file" name="slider[]" />
											<?php endif; ?>
												<div<?php if ($item['video'] == 0): ?> style="display:none;"<?php endif; ?>><span style="color: #999;">https://www.youtube.com/watch?v=</span><input style="max-width: 200px; display: inline;" type="text" name="videourl[]" class="form-control" placeholder="60wV6_GCfZU" value="<?=$item['videourl']?>"></div>
										</label>
										<input type="hidden" name="cache[]" value="<?=$item['slider']?>">
									</div>
								<?php $i++; endforeach; ?>
							<?php else: ?>
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
							<?php endif; ?>
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
						<?php $sliderParams = !empty($object['slider_params']) ? unserialize($object['slider_params']) : (is_array(_arg('params')) ? _arg('params') : []); ?>
						<?php if (is_array($sliderParams)): ?>
							<?php foreach($sliderParams as $k => $v): ?>
								<div class="addParam" style="margin-bottom:8px;">
									<span class="remove">Х</span>
									<input class="form-control" type="text" name="params[]" style="display:inline-block;width:35%;" placeholder="название" value="<?=$k?>" />&nbsp;:&nbsp;<input class="form-control" type="text" name="values[]" style="display:inline-block;width:50%;" placeholder="значение" value="<?=htmlspecialchars(getValue($v))?>"/>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
						</div>
						<input id="addParam" type="button" value="Добавить" class="btn btn-info" />&nbsp;|&nbsp;<input id="removeParam" type="button" value="Удалить" class="btn btn-danger" />
					</div>
					
					<button type="submit" class="btn btn-primary">Обновить слайдер</button>

				</form><?=cArgs()?>

			</div>
		</div>
		<!-- /.row -->
	</div>
</div>