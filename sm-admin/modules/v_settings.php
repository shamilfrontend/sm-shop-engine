<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Настройки</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i>  <a href="?view=dashboard"> Панель</a></li>
					<li class="active"><i class="fa fa-gear"></i> Настройки</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-8">
				<style>
					.obj-label {width: 48%;text-align: left;}
					#objects {margin: 0px auto;text-align: center;}
					#objects label {font-size:14px;}
				</style>
				<script type="text/javascript">	
					$(document).ready(function() {
						$(".addSetting").click(function(event){
							event.preventDefault();
							$("#addSetting").html('<hr /><div style="border: 1px dashed #000; padding:15px;"><label>Выберите объект: </label> <select id="changeObject" name="object" class="form-control" style="display: inline;width: 30%;height: 27px;padding: 2px 9px;font-size: 12px;"><option value="object" disabled selected>select object</option><option value="text">text</option><option value="textarea">textarea</option><option value="select">select</option><option value="number">number</option><option value="checkbox">checkbox</option><option value="multiplyText">multiplyText</option></select><div id="params" style="margin-top:5px;margin-bottom:-38px;width:100%; "></div><div style="margin-top:42px;"><button type="submit" name="addSettings" class="btn btn-success addSet">Сохранить настройку</button> <button class="btn btn-danger remSet">Удалить настройку</button></div></div><hr />')
							.promise().done(function() {
								$(this).fadeIn(300, function(){
									//$("#changeObject").change();
								});
							});
						});
						
						$("#changeObject").change(function(){
							$(".addSet").fadeIn(100);
							$(".remSet").fadeIn(100);
						});
						
						var max = 12; var min = 1;
						$(".remPar").attr("disabled", "disabled");
						$("#addSetting").delegate('.addPar', 'click', function(event) {
							event.preventDefault();
							var total = $("#objects > div").length; 
							if(total < max){
								$("#objects").append('<div><div style="display:inline;"><label class="control-label" style="width:30%;">Имя объекта: <input class="form-control" type="text" name="key[]" placeholder="key"></label></div>&nbsp;<label style="width:69%;">Значение метки: <input class="form-control" type="text" name="value[]" placeholder="value"></label></div>');
								if(max == total + 1){
									$(".addPar").attr("disabled", "disabled");
								}
								$(".remPar").removeAttr("disabled");
							}
						});
						
						$("#addSetting").delegate('.remPar', 'click', function(event) {
							event.preventDefault();
							var total = $("#objects > div").length; 
							if (total > min) { 
								
								if ($("#default :selected").val() == $("#objects div:last").find("input[name='key[]']").val())
									$("#default :first").attr("selected", "selected");

							   $("#objects > div:last").remove();
							   $('#default option[value="' + $("#objects div:last").find("input[name='key[]']").val() + '"]').remove();
							   
							   if(min == total - 1){
									$(".remPar").attr("disabled", "disabled");
							   }
							   $(".addPar").removeAttr("disabled");
							}
						});

						$(".remParA").attr("disabled", "disabled");
						$("#addSetting").delegate('.addParA', 'click', function(event) {
							event.preventDefault();
							var total = $("#objectsA > label").length; 
							if (total < (max - 6)) {
								
								$("#objectsA").append('<label class="obj-label">Значение объекта: <input class="form-control" type="text" name="value[]" placeholder="value"></label> ');
								
								if ((total + 1) == 2) {
									var width = 48;
									var size = 14;
								} else if ((total + 1) == 3) {
									var width = 32;
									var size = 13;
								} else if ((total + 1) == 4) {
									var width = 24;
									var size = 12;
								} else if ((total + 1) == 5) {
									var width = 19;
									var size = 11;
								} else if ((total + 1) == 6) {
									var width = 16;
									var size = 10;
								}
								
								$('.obj-label').css('width', width + '%');
								$('.obj-label').css('font-size', size + 'px');
								
								if ((max - 6) == total + 1) {
									$(".addParA").attr("disabled", "disabled");
								}
								$(".remParA").removeAttr("disabled");
							}
						});
						
						$("#addSetting").delegate('.remParA', 'click', function(event) {
							event.preventDefault();
							var total = $("#objectsA > label").length; 
							if (total > (min + 1)) { 
							
							   $("#objectsA > label:last").remove();
							   
							   if ((total - 1) == 2) {
									var width = 48;
									var size = 14;
								} else if ((total - 1) == 3) {
									var width = 32;
									var size = 13;
								} else if ((total - 1) == 4) {
									var width = 24;
									var size = 12;
								} else if ((total - 1) == 5) {
									var width = 19;
									var size = 11;
								} else if ((total - 1) == 6) {
									var width = 16;
									var size = 10;
								}
								
								$('.obj-label').css('width', width + '%');
								$('.obj-label').css('font-size', size + 'px');
							   
							   if ((min + 1) == total - 1) {
									$(".remParA").attr("disabled", "disabled");
							   }
							   $(".addParA").removeAttr("disabled");
							}
						});
					
						$("#addSetting").delegate('#default', 'focus', function(event) {
							$("#default").html("").promise().done(function() {
								$("#default").append($('<option></option>').text('default value').attr("disabled", "disabled"));
								
								$("input[name='value[]']").each(function(index) { // index, item
									var key = $("input[name='key[]']:eq("+ (index) +")").val();
									var val = $( this ).val();

									if ((key != "" && key != "undefined") && (val != "" && val != "undefined")) {
										$("#default").append($('<option></option>').text(val).attr("value", key));
									} 
									
								});
							});
							
						});
						
						//http://www.webnotes.com.ua/index.php/archives/699
						//search in goole:  :first").attr("selected", "selected");
						
						$("#addSetting").delegate('#default', 'focusout', function(event) {
							if ($("#default option").length > 1) {
								if ($("#default :selected").val() == "" || $("#default :selected").val() == "undefined")
									$("#default :first").attr("selected", "selected");	
							} else {
								$("#default :first").attr("selected", "selected");
							}							
						});

					});
					
					$(document).delegate('input[name="name"]', "keyup", function() {
						var key = $(this).val();
						<?php $dummy = ""; if (!empty($objects) && is_object($objects)): ?>
							<?php $dummy = " ,"; ?>
							<?php foreach($objects as $object): ?>
								<?php $dummy .= '"'. $object->name . '", '; ?>
							<?php endforeach; ?>
							<?php $dummy = substr($dummy, 0, -2); ?>
						<?php endif; ?>
						var arr = ["name", "value", "type", "object", "label", "remove", "tags", "default", "key"<?=$dummy?>];
						if ($.inArray(key, arr) != -1) {
							//если есть запрещенные ключи
							$(".addSet").attr("disabled", "disabled");

							$(this).attr("data-container", "body");
							$(this).attr("data-toggle", "popover");
							$(this).attr("data-placement", "top");
							$(this).attr("data-trigger", "focus");
							$(this).attr("data-html", "true");
							$(this).attr("data-content", 'имя параметра <b>' + key + '</b> является уникальным и <u>уже используется</u>, используйте другое.');
							
							$(this).parent().parent().removeClass("has-success").addClass("has-error");
							$("[data-toggle=popover]").popover();
							$(this).popover('show');
						} else {
							//если нет запрещенных ключей
							$(".addSet").removeAttr("disabled");
							$(this).parent().parent().removeClass("has-error").addClass("has-success");
							$(this).popover('hide');
							$(this).attr("data-container");
							$(this).attr("data-toggle");
							$(this).attr("data-placement");
							$(this).attr("data-trigger");
							$(this).attr("data-html");
							$(this).attr("data-content");
						}
						
						if (key == "") $(this).parent().parent().removeClass("has-error").removeClass("has-success");

					});
					
					$(document).delegate('input[name="key[]"]', "keyup", function() {
						var key = $(this).val();
						var thisID = $(this);
						var arrayKeys = [];
						
						$("input[name='key[]']").each(function(index) {
							if ($("input[name='key[]']").index(thisID) != index)
								arrayKeys.push($(this).val());		
						});
						
						//$('input[name="name"]').val(arrayKeys);
						
						if (key != "" && !key.match(/^[_a-z0-9]+$/)) {
							$(".addSet").attr("disabled", "disabled");
							$(this).attr("data-container", "body");
							$(this).attr("data-toggle", "popover");
							$(this).attr("data-placement", "top");
							$(this).attr("data-trigger", "focus");
							$(this).attr("data-html", "true");
							$(this).attr("data-content", 'имя параметра <b>' + key + '</b> содержит <u>недопустимые символы</u>, разрешаются только латинские буквы нижнего регистра, цифры и знак подчеркивания.');
							
							$(this).parent().parent().removeClass("has-success").addClass("has-error");
							$("[data-toggle=popover]").popover();
							$(this).popover('show');
							return false;
						} else {
							$(".addSet").removeAttr("disabled");
							$(this).parent().parent().removeClass("has-error").addClass("has-success");
							$(this).popover('hide');
							$(this).attr("data-container");
							$(this).attr("data-toggle");
							$(this).attr("data-placement");
							$(this).attr("data-trigger");
							$(this).attr("data-html");
							$(this).attr("data-content");
						}
						
						if ($.inArray(key, arrayKeys) != -1) {
							//если есть запрещенные ключи
							$(".addSet").attr("disabled", "disabled");

							$(this).attr("data-container", "body");
							$(this).attr("data-toggle", "popover");
							$(this).attr("data-placement", "top");
							$(this).attr("data-trigger", "focus");
							$(this).attr("data-html", "true");
							$(this).attr("data-content", 'имя параметра <b>' + key + '</b> является уникальным и <u>уже используется</u>, используйте другое.');
							
							$(this).parent().parent().removeClass("has-success").addClass("has-error");
							$("[data-toggle=popover]").popover();
							$(this).popover('show');
						} else {
							//если нет запрещенных ключей
							$(".addSet").removeAttr("disabled");
							$(this).parent().parent().removeClass("has-error").addClass("has-success");
							$(this).popover('hide');
							$(this).attr("data-container");
							$(this).attr("data-toggle");
							$(this).attr("data-placement");
							$(this).attr("data-trigger");
							$(this).attr("data-html");
							$(this).attr("data-content");
						}
						
						if (key == "") $(this).parent().parent().removeClass("has-error").removeClass("has-success");
						
					});
					
					function hideParams() {
						$(document).ready(function() {	
							$("#params").fadeOut(300, function(){
								$(this).html("");
								$(".addSet").fadeOut(100);
								$(".remSet").fadeOut(100);
							});
						});
					}
					
					$(document).delegate("#changeObject", "change", function(event) {
						event.preventDefault();
						var value = $(this).val();
						if (value == "text") {
							$("#params").fadeOut(300, function() {
								$(this).html('<div style="display:inline;"><label class="control-label" style="width:30%;">Имя объекта: <input class="form-control" type="text" name="name" placeholder="name"></label></div> <label style="width:69%;">Значение метки: <input class="form-control" type="text" name="label" placeholder="label"></label><br><label style="width:100%;">Значение объекта: <input class="form-control" type="text" name="value" placeholder="value"></label><input type="hidden" name="type" value="string"><input type="hidden" name="remove" value="1"><input type="hidden" name="tags" value="0"><input type="hidden" name="default" value="0">')
								.promise().done(function() {
									$(this).fadeIn(300, function() {});
								});
							});
						}
						
						if (value == "textarea") {
							$("#params").fadeOut(300, function() {
								$(this).html('' +				
								'<div style="display:inline;"><label class="control-label" style="width:30%;">Имя объекта: <input class="form-control" type="text" name="name" placeholder="name"></label></div> ' +
								'<label style="width:69%;">Значение метки: <input class="form-control" type="text" name="label" placeholder="label"></label><br>' +
								'<label style="width:100%;">Разрешить HTML? ' +
									'<select name="tags" class="form-control" style="display: inline;width: 25%;height: 27px;padding: 2px 9px;font-size: 12px;">' +
										'<option value="1">Да</option>' +
										'<option value="0" selected>Нет</option>' +
									'</select>' +
								'</label>' +
								'<label style="width:100%;">Значение объекта: <textarea class="form-control" name="value"></textarea></label>' +
								'<input type="hidden" name="type" value="string">' +
								'<input type="hidden" name="remove" value="1">' +
								'<input type="hidden" name="default" value="0">')
								.promise().done(function() {
									$(this).fadeIn(300, function() {});
								});
							});
						}
						
						if (value == "select") {
							$("#params").fadeOut(300, function() {
								$(this).html('' +
									'<div style="display:inline;"><label class="control-label" style="width:30%;">Имя объекта: <input class="form-control" type="text" name="name" placeholder="name"></label></div> ' +
									'<label style="width:69%;">Значение метки: <input class="form-control" type="text" name="label" placeholder="label"></label><br>' +
									'<div style="padding:15px;margin:10px;border:1px dashed #c9302c;">' +
										'<div id="objects">' +
											'<div>' +
												'<div style="display:inline;"><label class="control-label" style="width:30%;">Имя параметра: <input class="form-control" type="text" name="key[]" placeholder="key"></label></div> ' +
												'<label style="width:69%;">Значение параметра: <input class="form-control" type="text" name="value[]" placeholder="value"></label>' +
											'</div>' +
										'</div>' +
										'<div>' +
											'<button class="btn btn-sm btn-success addPar">Добавить параметр</button> ' +
											'<button class="btn btn-sm btn-danger remPar">Удалить параметр</button>' +
										'</div>' +
									'</div>' +
									'<label style="width:25%;">Тип объекта:' +
										'<select name="type" class="form-control" style="height: 27px;padding: 2px 9px;font-size: 12px;">' +
											'<option value="string" selected>string</option>' +
											'<option value="integer">integer</option>' +
										'</select>' +
									'</label> ' +
									'<label for="clanRemove" style="width:74%;">Значение по умолчанию:' +
										'<select id="default" name="default" class="form-control" style="height: 27px;padding: 2px 9px;font-size: 12px;">' +
											'<option selected="selected" disabled="disabled">default value</option>' +
										'</select>' +
									'</label>' +								
									'<input id="clanRemove" type="hidden" name="remove" value="1">' +
									'<input type="hidden" name="tags" value="0">')
								.promise().done(function() {
									$(this).fadeIn(300, function() {
										$(".remPar").attr("disabled", "disabled");
									});
								});
							});
						}
						
						if (value == "number") {
							$("#params").fadeOut(300, function() {
								$(this).html('' +
									'<div style="display:inline;"><label class="control-label" style="width:30%;">Имя объекта: <input class="form-control" type="text" name="name" placeholder="name"></label></div> ' +
									'<label style="width:69%;">Значение метки: <input class="form-control" type="text" name="label" placeholder="label"></label><br>' +
									'<label style="width:100%;">Значение объекта: <input class="form-control" type="number" min="0" max="100" name="value" placeholder="10"></label>' +
									'<input type="hidden" name="type" value="integer">' +
									'<input type="hidden" name="remove" value="1">' +
									'<input type="hidden" name="tags" value="0">' +
									'<input type="hidden" name="default" value="0">')
								.promise().done(function() {
									$(this).fadeIn(300, function() {});
								});
							});
						}
						
						if (value == "checkbox") {
							$("#params").fadeOut(300, function() {
								$(this).html('' +
									'<div style="display:inline;"><label class="control-label" style="width:30%;">Имя объекта: <input class="form-control" type="text" name="name" placeholder="name"></label></div> ' +
									'<label style="width:69%;">Значение метки: <input class="form-control" type="text" name="label" placeholder="label"></label><br>' +
									'<label style="width:30%;">Значение объекта: ' +
										'<select name="value" class="form-control" style="height: 27px;padding: 2px 9px;font-size: 12px;">' +
											'<option value="1" selected>boolean(true)</option>' +
											'<option value="0">boolean(false)</option>' +
										'</select>' +
									'</label>' +
									'<input type="hidden" name="type" value="boolean">' +
									'<input type="hidden" name="remove" value="1">' +
									'<input type="hidden" name="tags" value="0">' +
									'<input type="hidden" name="default" value="0">')
								.promise().done(function() {
									$(this).fadeIn(300, function() {});
								});
							});
						}
						
						if (value == "multiplyText") {
							$("#params").fadeOut(300, function() {
								$(this).html('' +
									'<div style="display:inline;"><label class="control-label" style="width:30%;">Имя объекта: <input class="form-control" type="text" name="name" placeholder="name"></label></div> ' +
									'<label style="width:69%;">Значение метки: <input class="form-control" type="text" name="label" placeholder="label"></label><br>' +
									'<div style="border: 1px dashed #c9302c; padding:15px;">' +
										'<div id="objectsA">' +
											'<label class="obj-label">Значение объекта: <input class="form-control" type="text" name="value[]" placeholder="value"></label> ' +
											'<label class="obj-label">Значение объекта: <input class="form-control" type="text" name="value[]" placeholder="value"></label> ' +
										'</div>' +
										'<button class="btn btn-sm btn-success addParA">Добавить параметр</button> ' +
										'<button class="btn btn-sm btn-danger remParA">Удалить параметр</button> ' +
									'</div>' +
									'<input type="hidden" name="type" value="string">' +
									'<input type="hidden" name="remove" value="1">' +
									'<input type="hidden" name="tags" value="0">' +
									'<input type="hidden" name="default" value="0">')
								.promise().done(function() {
									$(this).fadeIn(300, function() {
										$(".remParA").attr("disabled", "disabled");
									});
								});
							});
						}	
						
					});
					
					$(document).delegate("button.remSet", "click", function(event) {
						event.preventDefault();
						//hideParams();
						$("#addSetting").fadeOut(300, function(){
							$(this).html("");
						});
					});
					
					function removeSetting(name) {
						var ask = confirm("Вы действительно хотите удалить настройку?!");
						if (ask) {window.location = "/sm-admin/?view=remove_setting&csrf_token=<?=$_SESSION['auth']['csrf_token']?>&name=" + name;}
					}
					
					/*
					$(document).delegate("button.remove", "click", function(event) {
						event.preventDefault();
						$(this).parent().fadeOut(300, function(){
							$(this).remove();
						});
					});
					*/
					
				</script>
				<form action="?view=settings&csrf_token=<?=$_SESSION['auth']['csrf_token']?>" method="POST" role="form">
					<?php if (!empty($objects) && is_object($objects)): ?>
						<?php foreach($objects as $object): ?>
						<div class="form-group">
							<?php if ($object->remove): ?><button onclick="removeSetting('<?=$object->name?>'); return false;" type="button" class="btn btn-xs btn-danger remove">&nbsp;&mdash;&nbsp;</button><?php endif; ?>
							<label for="<?=$object->name?>"><?=$object->label?></label>
							<?php if ($object->object == "text"): ?>
							<input id="<?=$object->name?>" type="text" class="form-control" name="<?=$object->name?>" value="<?=getObjectValue($object)?>">
							<?php elseif($object->object == "number"): ?>
							<input id="<?=$object->name?>" type="number" min="0" max="100" class="form-control" name="<?=$object->name?>" value="<?=getObjectValue($object)?>">
							<?php elseif($object->object == "checkbox"): ?>
							<input id="<?=$object->name?>" type="checkbox" name="<?=$object->name?>" value="<?=getObjectValue($object)?>" <?php if ($object->value) echo 'checked';?>>
							<?php elseif($object->object == "textarea"): ?>
							<textarea style="display:block;width:100%;height:101px;" id="<?=$object->name?>" name="<?=$object->name?>"><?=getObjectValue($object)?></textarea>
								<?php if ($object->tags): ?>
								<script type="text/javascript">
									tinymce.init({
									  selector: '#<?=$object->name?>',
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
								<?php endif; ?>
							<?php elseif($object->object == "select"): ?>
							<select id="<?=$object->name?>" name="<?=$object->name?>" class="form-control">
								<?php if (!empty($object->value) && is_array($object->value)): ?>
									<?php foreach($object->value as $item): ?>
								<option value="<?=$item->key?>" <?php if ($object->default == $item->key) echo "selected"; ?>><?=$item->value?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
							<?php elseif($object->object == "multiplyText"): ?>
								<?php if (!empty($object->value) && is_array($object->value)): $width = 0; ?>
									<?php $y = count($object->value); $i = 0; $width = ($width < 3) ? 12 : (($width < 5) ? 15 : floor(90 / $y)); ?>
								<div<?php if ($y > 4): ?> style="margin: 0px auto; text-align: center;"<?php endif; ?>>
									<?php foreach($object->value as $item): ?>
									<input style="display:inline;width:<?=$width?>%;" id="<?=$object->name?>" type="text" class="form-control" name="<?=$object->name?>[<?=$i?>]" value="<?=getObjectValue($object, $i)?>">
								<?php $i++; if ($i < $y): ?>x<?php endif; ?>
									<?php endforeach; ?>
									<?=!empty($object->default)?"<span>".$object->default."</span>":""?>
								</div>
								<?php endif; ?>
							<?php endif; ?>			
						</div>
						<?php endforeach; ?>
					<?php endif; ?>				
					<div id="addSetting" style="display:none;"></div>
					<button class="btn btn-warning addSetting">Добавить настройку</button>
					<button type="submit" name="updateSettings" class="btn btn-primary">Обновить настройки</button>
				</form>
			</div>
		</div>
		<!-- /.row -->
	</div>	
</div>