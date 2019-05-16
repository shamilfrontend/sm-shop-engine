<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Редактор категории</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li><i class="fa fa-shopping-basket"></i> Магазин</li>
					<li><i class="fa fa-cubes"></i><a href="?view=categories"> Категории</a></li>
					<li class="active"><i class="fa fa-cube"></i> Редактор категории</li>
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
		</script>
		<div class="row">
			<div class="col-lg-8">
				<form action="?view=update_cat&cat_id=<?=$object['cat_id']?>&csrf_token=<?=$_SESSION['auth']['csrf_token']?>" method="POST" role="form" enctype="multipart/form-data">
					
					<div class="form-group">
						<label for="title">Заголовок категории<span style="color:red;font-size:18px;">*</span>:</label>
						<input id="title" autocomplete="off" class="form-control" name="title" value="<?=$object['cat_title']?>">
					</div>
					
					<div class="form-group">
						<label for="slug">Адрес<span style="color:red;font-size:18px;">*</span>:</label>
						
						<div class="alert alert-warning" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="display:none;" data-active="false">
							<strong>Очень важно!!!</strong> Данное поле является адресом категории. http://example.ru/cat/<b>example</b>
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
						<input id="slug" class="form-control" name="slug" placeholder="example или my_example или my-example или myexample2" readonly="readonly" data-readonly="true" value="<?=$object['cat_slug']?>">
					</div>
					
					<div class="form-group">
						<label for="keywords">Ключевые слова:</label>
						
						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Данное поле является SEO инструментом, видно только поисковому роботу.</div>
						
						<input id="keywords" class="form-control" name="keywords" value="<?=$object['cat_keywords']?>">
					</div>
					
					<div class="form-group">
						<label for="description">Описание:</label>
						
						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Данное поле является SEO инструментом, видно только поисковому роботу.</div>
						
						<input id="description" class="form-control" name="description" value="<?=$object['cat_description']?>">
					</div>
					
					<div class="form-group">
						<label for="parent">Родительская:</label>
						<select name="parent" class="form-control">
							<option value="0"<?php if ($object['cat_parent'] == 0):?> selected<?php endif;?>>(нет родительской)</option>
							<?=createObjectsTree($objects, 'cat', 'option')?>
					   </select>
					</div>
					
					<div class="form-group">
						
						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Если вы скроете категорию то вместе с ней в потоке скроются её потомки.<br>Однако потомки будут доступны в конструкторе меню, а сама категория нет.</div>			
						
						<label for="visible">Скрыть категорию?</label> Да&nbsp;<input id="visible" type="radio" name="visible" value="0"<?=($object['cat_visible']==0?' checked="checked"':'')?>>&nbsp;&nbsp;Нет&nbsp;<input type="radio" name="visible" value="1"<?=($object['cat_visible']==1?' checked="checked"':'')?>>
					</div>
					
					<?php if ($config["plugins"]->cats->catpicture->active): ?>
					<div class="form-group" style="border: 1px dashed #d9534f;padding: 8px;">
						<label for="termpicture">Миниатюра категории:</label>
						
						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Размер миниютюр для категорий задается в настройках.<br>Текущий размер: <b><?=$config["settings"]->cats_catpicture_imgsize->value[0]?>x<?=$config["settings"]->cats_catpicture_imgsize->value[1]?></b></div>
						
						<?=$catpicture?>
					</div>
					<?php endif; ?>
					
					<?php if ($config["plugins"]->cats->catgallery->active): ?>
					<div class="form-group" style="border: 1px dashed #d9534f;padding: 8px;">
						<script>
							$(document).ready(function() {
								var catgalleryMax = 8; var catgalleryMin = 1;
								$("#removeGalleryField").attr("disabled", true);
								$("#addGalleyField").click(function() {
									var catgalleryTotal = $("input[name='catgallery[]']").length;
									if (catgalleryTotal < catgalleryMax) {
										$("#catgallery").append('<div><input type="file" name="catgallery[]" /></div>');
										if (catgalleryMax == catgalleryTotal + 1) {
											$("#addGalleyField").attr("disabled", true);
										}
										$("#removeGalleryField").removeAttr("disabled");
									}
								});
								$("#removeGalleryField").click(function() {
									var catgalleryTotal = $("input[name='catgallery[]']").length;
									if (catgalleryTotal > catgalleryMin) {
									   $("#catgallery div:last-child").remove();
									   if (catgalleryMin == catgalleryTotal - 1) {
											$("#removeGalleryField").attr("disabled", true);
									   }
									   $("#addGalleyField").removeAttr("disabled");
									}
								});
							});
						</script>
						<label for="catgallery">Галерея категории:</label>
						
						<div class="alert alert-info" style="padding: 2px 10px;margin-bottom: 5px;"><strong>Внимание!!!</strong> <a class="toggleClass" style="cursor:pointer;color:#a94442;">показать предупреждение. <i class="fa fa-sort-desc" style="vertical-align: text-top;"></i></a></div>
						<div class="alert alert-danger" style="padding: 2px 10px;margin-bottom: 5px; display:none;"><strong>Важно!!!</strong> Размер миниютюр галереи для категорий задается в настройках. <br>Текущий размер: <b><?=$config["settings"]->cats_catgallery_imgsize->value[0]?>x<?=$config["settings"]->cats_catgallery_imgsize->value[1]?></b><br>Максимальное кол-во картинок при добавлении категории 8, если нужно добавить ещё то редактируйте категорию после её добавления.</div>			

						<div>
							<?=$catgallery?>
						</div>
						<style>
							#btnUpload {
								margin-top:6px;
								margin-bottom:6px;
								border: 1px solid #000;
								padding:7px;
								width:120px;
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
						<div id="btnUpload" data-id="<?=$object['cat_id']?>" data-table="cats" data-img="catgallery" data-module="cats" data-prefix="cat">Загрузить файл</div>
						<div id="uploadedObjects"></div>
					</div>
					<?php endif; ?>
					
					<?php if ($config["plugins"]->cats->catparams->active): ?>
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
						<?php $catParams = !empty($object['cat_params']) ? unserialize($object['cat_params']) : (is_array(_arg('params')) ? _arg('params') : []); ?>
						<?php if (is_array($catParams)): ?>
							<?php foreach($catParams as $k => $v): ?>
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
					
					<?php if ($config["plugins"]->cats->catmediafields->active): ?>
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
						<?php $catMediafields = !empty($object['cat_mediafields']) ? unserialize($object['cat_mediafields']) : (is_array(_arg('paramsmedia')) ? _arg('paramsmedia') : []); ?>
						<?php if (is_array($catMediafields)): ?>
							<?php foreach($catMediafields as $k => $v): ?>
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
					
					<div class="form-group">
						<label>Текст категории:</label>
						<div style="margin-bottom:4px;"><button onclick="InsertMedia(); return false;" class="btn btn-default"><i class="fa fa-fw fa-camera" style="position: relative;top: -3px;left: -2px;color: grey;"></i><i class="fa fa-fw fa-music" style="position: relative;left: -13px;top: 2px;color: grey;"></i><span style="margin-left: -10px;">Добавить медиафайл<span></button></div>
						<textarea id="cat-text" class="form-control" name="text"><?=$object['cat_text']?></textarea>
						<script type="text/javascript">
							tinymce.init({
							  selector: '#cat-text',
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
							  relative_urls: false,
							  external_filemanager_path:"/library/filemanager/",
							  filemanager_title:"Медиафайлы",
							  filemanager_access_key:"<?=UPLOAD_KEY?>",
							  external_plugins: { "filemanager" : "/library/filemanager/plugin.min.js", "responsivefilemanager" : "/library/tinymce/plugins/responsivefilemanager/plugin.min.js"}
							});
										
						</script>
					</div>
					
					<button type="submit" class="btn btn-primary">Обновить категорию</button>

				</form><?=cArgs()?>

			</div>
		</div>
		<!-- /.row -->
	</div>
</div>