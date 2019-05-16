<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Редактор записи</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li><i class="fa fa-pencil"></i><a href="?view=posts"> Записи</a></li>
					<li class="active"><i class="fa fa-pencil-square-o"></i> Редактор записи</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<style>
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
			function autoslug(r){r=r.toLowerCase();for(var e=new Array(["а","a"],["б","b"],["в","v"],["г","g"],["д","d"],["е","e"],["ё","yo"],["ж","zh"],["з","z"],["и","i"],["й","y"],["к","k"],["л","l"],["м","m"],["н","n"],["о","o"],["п","p"],["р","r"],["с","s"],["т","t"],["у","u"],["ф","f"],["х","h"],["ц","c"],["ч","ch"],["ш","sh"],["щ","shch"],["ъ",""],["ы","y"],["ь",""],["э","e"],["ю","yu"],["я","ya"],["А","A"],["Б","B"],["В","V"],["Г","G"],["Д","D"],["Е","E"],["Ё","YO"],["Ж","ZH"],["З","Z"],["И","I"],["Й","Y"],["К","K"],["Л","L"],["М","M"],["Н","N"],["О","O"],["П","P"],["Р","R"],["С","S"],["Т","T"],["У","U"],["Ф","F"],["Х","H"],["Ц","C"],["Ч","CH"],["Ш","SH"],["Щ","SHCH"],["Ъ",""],["Ы","Y"],["Ь",""],["Э","E"],["Ю","YU"],["Я","YA"],["a","a"],["b","b"],["c","c"],["d","d"],["e","e"],["f","f"],["g","g"],["h","h"],["i","i"],["j","j"],["k","k"],["l","l"],["m","m"],["n","n"],["o","o"],["p","p"],["q","q"],["r","r"],["s","s"],["t","t"],["u","u"],["v","v"],["w","w"],["x","x"],["y","y"],["z","z"],["A","A"],["B","B"],["C","C"],["D","D"],["E","E"],["F","F"],["G","G"],["H","H"],["I","I"],["J","J"],["K","K"],["L","L"],["M","M"],["N","N"],["O","O"],["P","P"],["Q","Q"],["R","R"],["S","S"],["T","T"],["U","U"],["V","V"],["W","W"],["X","X"],["Y","Y"],["Z","Z"],[" ","_"],["0","0"],["1","1"],["2","2"],["3","3"],["4","4"],["5","5"],["6","6"],["7","7"],["8","8"],["9","9"],["-","-"],["_","_"]),h=new String,a=0;a<r.length;a++){ch=r.charAt(a);for(var n="",c=0;c<e.length;c++)ch==e[c][0]&&(n=e[c][1]);h+=n}return h.replace(/[_]{2,}/gim,"_").replace(/\n/gim,"")}					
				
			window.onload = function() {
				var title = document.getElementById("title"); //from				
				var slug = document.getElementById("slug"); //to

				title.onkeyup = function(event) {if (event.ctrlKey || event.altKey || event.metaKey) return; slug.value = autoslug(title.value);}
				
				
			};
			
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
				
				$('#autoslug').change(function() {
					var readonly = $("#slug").attr("data-readonly");
					
					if (readonly == "true") {
						$("#slug").attr("data-readonly", "false");
						$("#slug").removeAttr('readonly');
						if ($(this).prev().attr("data-active") == "false") {
							$(this).prev().prev().children().next().click();
						}
					} else {
						$("#slug").attr("data-readonly", "true");
						$("#slug").attr('readonly', 'readonly');
						if ($(this).prev().attr("data-active") == "true") {
							$(this).prev().prev().children().next().click();
						}
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
				
				$(document).delegate('.removeImg', 'click', function() {	
					var ask = confirm("Вы действительно хотите удалить миниатюру?!");
					if (ask) {
						
						var object = $(this);
						var dataId = object.attr("data-id"); 
						var dataTable = object.attr("data-table"); 
						var dataPrefix = object.attr("data-prefix"); 
						var dataImg = object.attr("data-img"); 
						var dataPath = object.attr("data-path"); 
						var dataRemove = object.attr("data-remove"); 
						
						var rel = object.attr("rel"); 

						$.ajax({
							url: "?view=remove_image",
							type: "POST",
							data: { object_id: dataId, 
									object_table: dataTable, 
									object_prefix: dataPrefix, 
									object_img: dataImg, 
									object_path: dataPath, 
									object_remove: dataRemove
								  },
							success: function(response) {
								response = JSON.parse(response);
								
								if (response.answer == "success") {
									if (rel == 0) {
										object.fadeOut(500, function() {
											//object.remove();
											object.parent().removeClass("tooltip-demo").html('<input id="' + dataImg + '" type="file" name="' + dataImg +'">')
												.promise().done(function(){
												object.fadeIn(500);
											});
										});
									} else {
										object.parent().fadeOut(500, function(){
											object.parent().remove();
										});
									}
								} else {
									alert(response.answer);
								}
							}, error: function() {
								alert("Uh-oh, something went wrong!");
							}
						});

					}
					
				});
				
				// загрузка картинок
				var objectUpload = $("#btnUpload"); // кнопка загрузки + интервал ожидания
				var objectId = objectUpload.attr("data-id"); // ID объекта
				var objectTable = objectUpload.attr("data-table");
				var objectPrefix = objectUpload.attr("data-prefix");
				var objectImg = objectUpload.attr("data-img"); //field in db
				var objectModule = objectUpload.attr("data-module");
				var objectSizeSetting = objectUpload.attr("data-size");
				var objectPath; // путь к папке превью
				//uploadedObjects
				//<i class="fa fa-refresh fa-spin fa-fw"></i> Загрузить файл
				new AjaxUpload(objectUpload, {
					action: '?view=upload_image',
					name: 'userfile',
					data: {
							object_id: objectId,
							object_table: objectTable,
							object_prefix: objectPrefix,
							object_img: objectImg,
							object_module: objectModule
						  },
					onSubmit: function(file, ext) {
						if (!(ext && /^(jpg|png|jpeg|gif)$/i.test(ext))) {
							alert('Запрещенный тип файла!');
							// cancel upload
							return false;
						}
						objectUpload.html('<i class="fa fa-refresh fa-spin fa-fw"></i> Загружаем');
						this.disable();
					},
					onComplete: function(file, response) {
						objectUpload.html("Загрузить еще?");
						this.enable();
						var response = JSON.parse(response);
						if(response.answer == "OK") {
							$("#uploadedObjects").append('<img style="display:none;" width="140" height="140" src="' + response.result + '" />');
							setTimeout(function() {
								$("#uploadedObjects > img:last").fadeIn(300);
							}, 100);
						} else {
							alert(response.answer);
						}
					}
				});
				
			});
			$(document).ready(function(){
				// tooltip demo
				$('.tooltip-demo').tooltip({
					selector: "[data-toggle=tooltip]",
					container: "body"
				})

				// popover demo
				$("[data-toggle=popover]")
					.popover()
			});
		</script>
		<div class="row">
			<div class="col-lg-8">
				<form action="?view=update_post&post_id=<?=$object['post_id']?>&csrf_token=<?=$_SESSION['auth']['csrf_token']?>" method="POST" role="form" enctype="multipart/form-data">

					<div class="form-group">
						<a href="?view=add_post" class="btn btn-outline btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i>
							Добавить новую запись</a>
					</div>

					<div class="form-group">
						<a href="/post/<?=$object['post_slug']?>/" target="_blank">Посмотреть запись: <i class="fa fa-external-link" aria-hidden="true"></i>
							 <?=$object['post_title']?></a>
					</div>

					<div class="form-group">
						<label for="title">Заголовок записи<span style="color:red;font-size:18px;">*</span>:</label>
						<input id="title" autocomplete="off" class="form-control" name="title" value="<?=$object['post_title']?>">
					</div>
					
					<div class="form-group">
						<label for="slug">Адрес<span style="color:red;font-size:18px;">*</span>:</label>
						
						<div class="alert alert-warning" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="display:none;" data-active="false">
							<strong>Очень важно!!!</strong> Данное поле является адресом записи. http://example.ru/post/<b>example</b>
							<br>Заполнять строго согласно инструкции иначе ничего работать не будет, а так же есть возможность нарушить целостность БД.<br>
							<u><b>В данное поле разрешается записывать только:</b></u>
							<ul>
								<li>Латинские буквы нижнего регистра</li>
								<li>Цифры</li>
								<li>Знаки тире и подчеркивания</li>
							</ul>
							<u><b>Данное поле является уникальным среди своего уровня и не должно повторяться!</b></u>
						</div>
						
						<input id="autoslug" type="checkbox">&nbsp;<label for="autoslug">Ручное заполнение</label>
						<input id="slug" class="form-control" name="slug" placeholder="example или my_example или my-example или myexample2" readonly="readonly" data-readonly="true" value="<?=$object['post_slug']?>">
					</div>

					<div class="form-group">
						<label for="name">Название записи:</label>

						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Данное поле является SEO инструментом, отображается в названии вкладки <title>Название</title>. Если данное поле пустое то по умолчанию используется заголовок записи.</div>

						<input id="name" class="form-control" name="name" value="<?=$object['post_name']?>">
					</div>
					
					<div class="form-group">
						<label for="keywords">Ключевые слова:</label>
						
						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Данное поле является SEO инструментом, видно только поисковому роботу.</div>
						
						<input id="keywords" class="form-control" name="keywords" value="<?=$object['post_keywords']?>">
					</div>
					
					<div class="form-group">
						<label for="description">Описание:</label>
						
						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Данное поле является SEO инструментом, видно только поисковому роботу.</div>

						<input id="description" class="form-control" name="description" value="<?=$object['post_description']?>">
					</div>
					
					<!--div class="form-group">
						<label for="parent">Родительская:</label>
						<select name="parent" class="form-control">
							<option value="0"<?php if ($object['page_parent'] == 0):?> selected<?php endif;?>>(нет родительской)</option>
							<?=createObjectsTree($objects, 'page', 'option')?>
					   </select>
					</div-->
					
					<div class="form-group">
						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Если вы скроете запись то она будет недоступна для чтения в конструкторе меню, а так же в родительских рубриках.</div>			
						<label for="visible">Скрыть страницу?</label> Да&nbsp;<input id="visible" type="radio" name="visible" value="0"<?=($object['post_visible']==0?' checked="checked"':'')?>>&nbsp;&nbsp;Нет&nbsp;<input type="radio" name="visible" value="1"<?=($object['post_visible']==1?' checked="checked"':'')?>>
					</div>
					
					<div class="form-group">
						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Данный параметр можно использовать на усмотрение проектировщика, выводить запись в специальном блоке и т.д</div>				
						<label for="special">Спецразмещение?</label> Да&nbsp;<input id="special" type="radio" name="special" value="1"<?=($object['post_special']==1?' checked="checked"':'')?>>&nbsp;&nbsp;Нет&nbsp;<input type="radio" name="special" value="0"<?=($object['post_special']==0?' checked="checked"':'')?>>
					</div>
					
					<?php if ($config["plugins"]->posts->postpicture->active): ?>
					<div class="form-group" style="border: 1px dashed #d9534f;padding: 8px;">
						<label for="pagepicture">Миниатюра записи:</label>
						
						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Размер миниютюр для записей задается в настройках.<br>Текущий размер: <b><?=$config["settings"]->posts_postpicture_imgsize->value[0]?>x<?=$config["settings"]->posts_postpicture_imgsize->value[1]?></b></div>
						
						<?=$postpicture?>
					</div>
					<?php endif; ?>
					
					<?php if ($config["plugins"]->posts->postgallery->active): ?>
					<div class="form-group" style="border: 1px dashed #d9534f;padding: 8px;">
						<script>
							$(document).ready(function() {
								var postgalleryMax = 8; var postgalleryMin = 1;
								$("#removeGalleryField").attr("disabled", true);
								$("#addGalleyField").click(function() {
									var postgalleryTotal = $("input[name='postgallery[]']").length;
									if (postgalleryTotal < postgalleryMax) {
										$("#postgallery").append('<div><input type="file" name="postgallery[]" /></div>');
										if (postgalleryMax == postgalleryTotal + 1) {
											$("#addGalleyField").attr("disabled", true);
										}
										$("#removeGalleryField").removeAttr("disabled");
									}
								});
								$("#removeGalleryField").click(function() {
									var postgalleryTotal = $("input[name='postgallery[]']").length;
									if (postgalleryTotal > postgalleryMin) {
									   $("#postgallery div:last-child").remove();
									   if (postgalleryMin == postgalleryTotal - 1) {
											$("#removeGalleryField").attr("disabled", true);
									   }
									   $("#addGalleyField").removeAttr("disabled");
									}
								});
							});
						</script>
						<label for="postgallery">Галерея записи:</label>
						
						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Размер миниютюр галереи для записи задается в настройках. <br>Текущий размер: <b><?=$config["settings"]->posts_postgallery_imgsize->value[0]?>x<?=$config["settings"]->posts_postgallery_imgsize->value[1]?></b><br>Максимальное кол-во картинок при добавлении записи 8, если нужно добавить ещё то редактируйте запись после её добавления.</div>			

						<div>
							<?=$postgallery?>
						</div>
						<style>
							#btnUpload {
								margin-top:6px;
								margin-bottom:6px;
								border: 1px solid #000;
								padding:7px;
								width:140px;
								text-align:center;
							}
							#btnUpload:hover {
								border: 1px dashed #000;
								cursor:pointer;
								/*font-weight:bold;*/
								/*font-size: 13.4px;*/
							}
							#uploadedObjects img {
								margin: 2px;
								border: 1px dashed #d43f3a;
							}
						</style>
						<div id="btnUpload" data-id="<?=$object['post_id']?>" data-table="posts" data-img="postgallery" data-module="posts" data-prefix="post">Загрузить файл</div>
						<div id="uploadedObjects"></div>
					</div>
					<?php endif; ?>
					
					<?php if ($config["plugins"]->posts->postparams->active): ?>
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
						<?php $postParams = !empty($object['post_params']) ? unserialize($object['post_params']) : (is_array(_arg('params')) ? _arg('params') : []); ?>
						<?php if (is_array($postParams)): ?>
							<?php foreach($postParams as $k => $v): ?>
							<div class="addParam" style="margin-bottom:8px;">
								<span class="remove">Х</span>
								<input class="form-control" type="text" name="params[]" style="display:inline-block;width:35%;" placeholder="название" value="<?=$k?>" />&nbsp;:&nbsp;<input class="form-control" type="text" name="values[]" style="display:inline-block;width:50%;" placeholder="значение" value="<?=htmlspecialchars(getValue($v))?>"/>
							</div>
							<?php endforeach; ?>
						<?php endif; ?>
						</div>
						<input id="addParam" type="button" value="Добавить" class="btn btn-info" />&nbsp;|&nbsp;<input id="removeParam" type="button" value="Удалить" class="btn btn-danger" />
					</div>
					<?php endif; ?>
					
					<?php if ($config["plugins"]->posts->postmediafields->active): ?>
					<div class="form-group" style="border: 1px dashed #d9534f;padding: 8px;">
						<label>Медиа поля:</label>
						
						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Максимальное кол-во медиа полей 16 думаю больше и не понадобиться.</div>
					
						<script>
							jQuery(document).ready(function() {
								var paramsMediaMax = 16; var paramsMediaMin = 0; var FieldID = 0;
								var paramsMediaTotal = $("#paramsmedia > .addParamMedia").length;
								if (paramsMediaTotal < 1) $("#removeParamMedia").attr("disabled", true);
								//Произвольные поля
								jQuery('#addParamMedia').click(function(){ FieldID++;
									var paramsMediaTotal = $("#paramsmedia > .addParamMedia").length;
									if (paramsMediaTotal < paramsMediaMax) {
										jQuery('#paramsmedia').append('<div class="addParamMedia" style="margin-bottom:8px;"><span class="remove">Х</span><input class="form-control" type="text" name="paramsmedia[]" style="display:inline-block;width:25%;" placeholder="название" />&nbsp;:&nbsp;<input id="fieldID' + FieldID + '" class="form-control" type="text" name="valuesmedia[]" style="display:inline-block;width:58%;border-top-right-radius: 0;border-bottom-right-radius: 0;" placeholder="значение" /><span class="input-group-btn" style="display: inline;margin-left: 0px;margin-top: 0px;position: absolute;"><button href="/library/filemanager/dialog.php?akey=<?=UPLOAD_KEY?>&field_id=fieldID' + FieldID + '&relative_url=1" style="padding: 6px 0px 6px 17px;" class="btn btn-default iframe-btn" type="button"><i class="fa fa-fw fa-camera" style="position: relative;top: -3px;left: -2px;color: grey;"></i><i class="fa fa-fw fa-music" style="position: relative;left: -13px;top: 2px;color: grey;"></i></button></span></div>');
										if (paramsMediaMax == paramsMediaTotal + 1) {
											$("#addParamMedia").attr("disabled", true);
										}
										$("#removeParamMedia").removeAttr("disabled");
									}
								});
								
								jQuery('#removeParamMedia').click(function() {
									var paramsMediaTotal = $("#paramsmedia > .addParamMedia").length;
									if (paramsMediaTotal > paramsMediaMin) {
									   jQuery('.addParamMedia:last').remove();
									   if (paramsMediaMin == paramsMediaTotal - 1) {
											$("#removeParamMedia").attr("disabled", true);
									   }
									   $("#addParamMedia").removeAttr("disabled");
									}
								});
								
								 $('.iframe-btn').fancybox({
									  'width'	: 900,
									  'minHeight'	: 600,
									  'type'	: 'iframe',
									  'autoScale'   : false
								  });		
							});
						</script>
						<div id="paramsmedia">
						<?php $postMediafields = !empty($object['post_mediafields']) ? unserialize($object['post_mediafields']) : (is_array(_arg('paramsmedia')) ? _arg('paramsmedia') : []); ?>
						<?php if (is_array($postMediafields)): ?>
							<?php foreach($postMediafields as $k => $v): ?>
							<div class="addParamMedia" style="margin-bottom:8px;">
								<span class="remove">Х</span>
								<input class="form-control" type="text" name="paramsmedia[]" style="display:inline-block;width:25%;" placeholder="название" value="<?=$k?>" />&nbsp;:&nbsp;<input class="form-control" type="text" name="valuesmedia[]" style="display:inline-block;width:58%;border-top-right-radius: 0;border-bottom-right-radius: 0;" placeholder="значение" value="<?=htmlspecialchars(getValue($v))?>"/>
								<span class="input-group-btn" style="display: inline;margin-left: 0px;margin-top: 0px;position: absolute;"><button style="padding: 6px 0px 6px 17px;" class="btn btn-default" type="button"><i class="fa fa-fw fa-camera" style="position: relative;top: -3px;left: -2px;color: grey;"></i><i class="fa fa-fw fa-music" style="position: relative;left: -13px;top: 2px;color: grey;"></i></button></span>
							</div>
							<?php endforeach; ?>
						<?php endif; ?>	
						</div>
						<input id="addParamMedia" type="button" value="Добавить" class="btn btn-info" />&nbsp;|&nbsp;<input id="removeParamMedia" type="button" value="Удалить" class="btn btn-danger" />
					</div>
					<?php endif; ?>
					
					<?php if ($config["plugins"]->posts->postquote->active): ?>
					<div class="form-group">
						<label>Краткая запись:</label>
						<textarea id="quote-text" class="form-control" name="quote"><?=$object['post_quote']?></textarea>
						<script type="text/javascript">
							tinymce.init({
							  selector: '#quote-text',
							  height: 100,
							  image_advtab: true,
							  toolbar_items_size: 'small',
							  plugins: [
								'advlist autolink lists link image charmap print preview anchor codesample',
								'searchreplace visualblocks code fullscreen directionality imagetools',
								'insertdatetime media textcolor colorpicker table contextmenu paste code pagebreak visualblocks visualchars textpattern'
							  ],
							  toolbar1: 'insertfile undo redo | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink anchor | fontselect fontsizeselect',
							  toolbar2: 'table media image responsivefilemanager | pagebreak preview code codesample | bold italic underline strikethrough forecolor backcolor | ltr rtl | visualchars visualblocks',
							  content_css: [
								'//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
								'//www.tinymce.com/css/codepen.min.css'
							  ],
							  language_url: '/library/tinymce_russian.js',
							  imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
							  extended_valid_elements:'script[language|type|src]',
							  relative_urls: false,
							  external_filemanager_path:"/library/filemanager/",
							  filemanager_title:"Медиафайлы",
							  filemanager_access_key:"<?=UPLOAD_KEY?>",
							  external_plugins: { "filemanager" : "/library/filemanager/plugin.min.js", "responsivefilemanager" : "/library/tinymce/plugins/responsivefilemanager/plugin.min.js"}
							});
										
						</script>
					</div>
					<?php endif; ?>
					
					<div class="form-group">
						<label>Полная запись:</label>
						<div style="margin-bottom:4px;"><button onclick="InsertMedia(); return false;" class="btn btn-default"><i class="fa fa-fw fa-camera" style="position: relative;top: -3px;left: -2px;color: grey;"></i><i class="fa fa-fw fa-music" style="position: relative;left: -13px;top: 2px;color: grey;"></i><span style="margin-left: -10px;">Добавить медиафайл<span></button></div>
						<textarea id="page-text" class="form-control" name="text"><?=$object['post_text']?></textarea>
						<script type="text/javascript">
							tinymce.init({
							  selector: '#page-text',
							  height: 200,
							  image_advtab: true,
							  toolbar_items_size: 'small',
							  plugins: [
								'advlist autolink lists link image charmap print preview anchor codesample',
								'searchreplace visualblocks code fullscreen directionality imagetools',
								'insertdatetime media textcolor colorpicker table contextmenu paste code pagebreak visualblocks visualchars textpattern'
							  ],
							  toolbar1: 'insertfile undo redo | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink anchor | fontselect fontsizeselect',
							  toolbar2: 'table media image responsivefilemanager | pagebreak preview code codesample | bold italic underline strikethrough forecolor backcolor | ltr rtl | visualchars visualblocks',
							  content_css: [
								'//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
								'//www.tinymce.com/css/codepen.min.css'
							  ],
							  language_url: '/library/tinymce_russian.js',
							  imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
							  extended_valid_elements:'script[language|type|src]',
							  relative_urls: false,
							  external_filemanager_path:"/library/filemanager/",
							  filemanager_title:"Медиафайлы",
							  filemanager_access_key:"<?=UPLOAD_KEY?>",
							  external_plugins: { "filemanager" : "/library/filemanager/plugin.min.js", "responsivefilemanager" : "/library/tinymce/plugins/responsivefilemanager/plugin.min.js"}
							});
										
						</script>
					</div>
					
					<!--button type="submit" class="btn btn-primary">Обновить запись</button-->		

			</div>
			
			<style>
					/*shamil*/
					.side-module{
						padding: 10px;
						background-color: #F5F5F5;
						border-radius: 10px;
						border: 1px solid;
					}
					.side-module__title{
						font-size: 18px;
						margin: 0;
						margin-bottom: 15px;
					}
					.module-box{}
					.module-box ul{
						list-style-type: none;
						margin: 0;
						padding: 0;
					}
						.module-box ul li {
							line-height: 16px;
							margin-top: 5px;
							margin-bottom: 5px;
						}
					.module-box label {
						cursor: pointer;
						font-weight: 200;
					}

					.module-box input[type="checkbox"] {
					  display: none;
					}

					.module-box input[type="checkbox"] + label {
					  position: relative;

					  display: inline-block;
					  padding-left: 24px;

					  cursor: pointer;
					  vertical-align: top;
					}

					.module-box input[type="checkbox"] + label:hover {
					  color: #794432;
					}

					.module-box input[type="checkbox"] + label::before {
					  content: "\f096";
					  font-family: FontAwesome, sans-serif;
					  font-size: 18px;

					  position: absolute;
					  top: 2px;
					  left: 0;

					  width: 22px;
					  height: 22px;
					  /*border: 2px solid #000;*/
					}

					.module-box input[type="checkbox"]:checked + label::before {
					  /*background: url("../img/sprite.png") no-repeat;
					  background-position: -1px -1px;*/
					  content: "\f046";
					}

					/*cat*/
					.table-responsive ul {
						background-color: #fff;
						padding: 10px;
						list-style-type: none;
						display: table;
						width: 100%;
					}
					.table-responsive ul li {
						/**/
					}
					.table-responsive ul li .cat-td {
						display: inline-block;
						vertical-align: middle;
						line-height: 34px;
						padding: 10px;
						border: 1px solid #eee;
					}
					.cat-td--id {
						width: 3%;
						text-align: center;
					}
					.cat-td--cat {
						width: 30%;
						padding-left: 10px;
					}
					.cat-td--datemake {
						width: 20%;
					}
					.cat-td--dateedit {
						width: 20%;
					}
					.cat-td--btns {
						width: 15%;
					}

					#sortableListsPlaceholder {
						width: 100%;
					}
					/*cat end*/

				/*shamil end*/
				
				#keyword {
					/*width: 200px;*/
					font-size: 1em;
				}

				#results {
					display: none;
					/*width: 204px;*/
					display: absolute;
					border: none;
				}

				#results .item {
					padding: 3px;
					font-family: Helvetica;
					border-bottom: 1px solid #c0c0c0;
				}

				#results .item:last-child {
					border-bottom: 0px;
				}

				#results .item:hover {
					background-color: #f2f2f2;
					cursor: pointer;
				}
				
				#simular div {
					display: inline;
					line-height: 35px;
				}
				
				#simular span {
					padding: 5px;
					border: 1px solid;
					margin-left: 2px;
				}
				
				#simular span:hover {
					cursor: pointer;
					border: 1px dashed;
				}
			</style>
			<?php if ($config["modules"]->terms->active): ?>
			<div class="col-lg-4" style="margin-bottom:10px;">
				<div class="side-module">
					<h3 class="side-module__title">Рубрики:</h3>
					<div class="module-box">
						<?=createCheckboxObjectsTree($objects, 'term', 0, 0, $object['objectIds'])?>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<div class="col-lg-12">
				<button type="submit" class="btn btn-primary">Обновить запись</button>
			</div>
			</form><?=cArgs()?>
		</div>
		<!-- /.row -->
	</div>
</div>