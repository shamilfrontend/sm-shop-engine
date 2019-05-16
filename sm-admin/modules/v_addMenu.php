<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Конструктор меню</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li><i class="fa fa-chain"></i><a href="?view=menus"> Меню</a></li>
					<li class="active"><i class="fa fa-chain-broken"></i> Конструктор меню</li>
				</ol><div id="ajax_res"><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?></div>
			</div>
		</div>
		<!-- /.row -->
		<div class="row">
			<style type="text/css">
				html {
					background-color: #fff;
				}
				#menus {
					-webkit-border-radius: 3px;
					-moz-border-radius: 3px;
					border-radius: 3px;
					color: #444;
					background-color: #fff;
					font-size: 13px;
					font-family: Freesans, sans-serif;
					padding: 0.2em 1em;
					max-width: 860px;
					box-shadow: 1px 1px 8px #444;
					-mox-box-shadow: 1px 1px 8px #444;
					-webkit-box-shadow: 1px -1px 8px #444;
				}
				a,a:visited {
					color: #4183C4;
					text-decoration: none;
				}
				
				a:hover {
					text-decoration: underline;
				}
				
				pre,code {
					font-size: 12px;
				}
				
				pre {
					width: 100%;
					overflow: auto;
				}
				
				small {
					font-size: 90%;
				}
				
				small code {
					font-size: 11px;
				}
				
				.placeholder {
					outline: 1px dashed #e71616;
				}
				
				.mjs-nestedSortable-error {
					background: #fbe3e4;
					border-color: transparent;
				}
				
				#tree {
					width: 550px;
					margin: 0;
				}
				
				ol {
					max-width: 650px;
					padding-left: 25px;
				}
				
				ol.sortable,ol.sortable ol {
					list-style-type: none;
				}
				
				.sortable li div {
					border: 1px solid #d4d4d4;
					-webkit-border-radius: 3px;
					-moz-border-radius: 3px;
					border-radius: 3px;
					cursor: move;
					border-color: #D4D4D4 #D4D4D4 #BCBCBC;
					margin: 0;
					padding: 3px;
				}
				
				li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
					border-color: #999;
				}
				
				.disclose, .expandEditor {
					cursor: pointer;
					width: 20px;
					display: none;
					vertical-align: middle;
				}
				
				.sortable li.mjs-nestedSortable-collapsed > ol {
					display: none;
				}
				
				.sortable li.mjs-nestedSortable-branch > div > .disclose {
					display: inline-block;
				}
				
				.sortable span.ui-icon {
					display: inline-block;
					margin: 0;
					padding: 0;
					vertical-align: middle!important;
				}
				
				.menuDiv {
					background: #EBEBEB;
					padding: 6px 6px!important;
					min-height: 40px!important;
					width:100%!important;
					padding-top: 8px !important;
				}

				.blocked-main {
					position: relative;
					max-width: 861px;
				}
				
				.menuEdit {
					background: #FFF;
					margin-top:10px!important;
				}
				
				.itemTitle {
					vertical-align: middle;
					cursor: pointer;
				}
				
				.deleteMenu {
					float: right;
					cursor: pointer;
				}
				
				h1 {
					font-size: 2em;
					margin-bottom: 0;
				}
				
				h2 {
					font-size: 1.2em;
					font-weight: 400;
					font-style: italic;
					margin-top: .2em;
					margin-bottom: 1.5em;
				}
				
				h3 {
					font-size: 1em;
					margin: 1em 0 .3em;
				}
				
				p,ol,ul,pre,form {
					margin-top: 0;
					margin-bottom: 1em;
				}
				
				dl {
					margin: 0;
				}
				
				dd {
					margin: 0;
					padding: 0 0 0 1.5em;
				}
				
				code {
					background: #e5e5e5;
				}
				
				input {
					vertical-align: text-bottom;
				}
				
				.notice {
					color: #c33;
				}
				.hidden1 {
					display: none;
				}
				.menuDiv:hover{
					border:1px dashed #000;
				}
				.ui-helper-reset {
					font-size: 88%!important;
				}
				#accordion h3 {
					font-size: 13px !important;
				}
				/***********************************/
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
						font-weight: 100;
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
					  color: #663d15;
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
				/***********************************/
				#blocked {		
					position: absolute;
					left: 0;
					top: 0;
					width: 100%;
					height: 100%;
					/*margin: 10px auto;*/
					background: rgba(222, 220, 215, 0.7);
					border-radius: 3px;
					/*display: table;*/
					text-align: center;
					z-index: 30;
				}
				#blocked i {
				    position: absolute;
				    left: 50%;
				    top: 50%;
				    margin-top: -110px;
				    margin-left: -141px;
				}
				.textareaMenu {
					min-width:99%;
					min-height:71px;
					max-width:591px;
					max-height:260px;
				}
				.menuEdit div {
					border:none!important;
				}
				.fieldID {
					display:inline-block;
					width:55%;
					border-top-right-radius: 0;
					border-bottom-right-radius: 0;
				}
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
				input {
					vertical-align: initial!important;
				}
				.has-error {
					color: #a94442;
				}
				.has-success {
					color: #3c763d;
				}
				.hiddenObject {
					color: #CECBCB!important;
				}
				.ui-autocomplete-loading {
					background: white url("/sm-admin/static/img/ui-anim_basic_16x16.gif") right center no-repeat;
				}
				.objectSearch {
					/*width: 200px;*/
					font-size: 1em;
				}

				.results {
					display: none;
					/*width: 204px;*/
					display: absolute;
					border: none;
				}

				.results .item {
					padding: 3px;
					font-family: Helvetica;
					border-bottom: 1px solid #c0c0c0;
				}

				.results .item:last-child {
					border-bottom: 0px;
				}

				.results .item:hover {
					background-color: #f2f2f2;
					cursor: pointer;
				}
				
				.simular div {
					line-height: 22px;
					overflow: hidden;
					text-overflow: ellipsis;
					height: 24px;
					margin-bottom: 5px;
				}
				.simular span {
					border: 1px solid;
					margin-left: 2px;
					display: inline-block;
					white-space: nowrap;
					padding-left: 10px;
					width: 99%;
					overflow: hidden;
					padding-right: 10px;
					text-overflow: ellipsis;
				}

				.simular span:hover {
					cursor: pointer;
					border: 1px dashed;
				}
				
				@media (width: 700px) {
				  body .input-group .objectSearch {
				   width: 70%!important;
				  }
				 }
				 @media (max-width: 1200px) {
				  body .input-group .objectSearch {
				   /*width: 65%;*/
				  }
				 }
			</style>
			<script>
				var currentMenuId = <?=$menu_item['menu_items']?>;
				function stepUp() {currentMenuId = currentMenuId + 1;}
				function stepDown() {return; currentMenuId = currentMenuId - 1; if (currentMenuId < 1) currentMenuId = 0;}
				function nextID() { return currentMenuId + 1;}
				
				$().ready(function(){
					
					$(window).resize(function() {
					  if ($("#resize").width() < 405) {
						  $("#select-resize").css('width', '35%');
						  $("#input-resize").css('width', '65%');
					  } else {
						  $("#select-resize").css('width', '20%');
						  $("#input-resize").css('width', '80%');
					  }
					});
					
					var ns = $('ol.sortable').nestedSortable({
						forcePlaceholderSize: true,
						handle: 'div',
						helper:	'clone',
						items: 'li',
						opacity: .6,
						placeholder: 'placeholder',
						revert: 250,
						tabSize: 25,
						tolerance: 'pointer',
						toleranceElement: '> div',
						maxLevels: 6,
						isTree: true,
						expandOnHover: 700,
						startCollapsed: false,
						change: function(){
							//console.log('Relocated item');
						},
						donotclear: true
					});
	
					//$('#serialize').click(function(){
					//	serialized = $('ol.sortable').nestedSortable('serialize');
					//	$('#serializeOutput').text(serialized+'\n\n');
					//})
			
					//$('#toHierarchy').click(function(e){
					//	hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
					//	hiered = dump(hiered);
					//	(typeof($('#toHierarchyOutput')[0].textContent) != 'undefined') ?
					//	$('#toHierarchyOutput')[0].textContent = hiered : $('#toHierarchyOutput')[0].innerText = hiered;
					//})
			
					//$('#toArray').click(function(e){
					//	arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
					//	arraied = dump(arraied);
					//	(typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
					//	$('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;
					//});
					
					$("#accordion").accordion({
						  collapsible: true,
						  heightStyle: "content"
					});
					$("#tabs-terms").tabs();
					$("#tabs-posts").tabs();
					$("#tabs-pages").tabs();
					$("#tabs-cats").tabs();
					$("#tabs-products").tabs();

					// $(window).resize(function() {
					//   $("#blocked").width($("#menus").width());
					//   $("#blocked").height($("#menus").height());
					// });
					
					// $(window).resize();
					//$("#blocked").fadeOut(1800);
					
					$("#doit").click(function(event) {
						event.preventDefault();
						var button = $(this);
						//$(window).resize();
						// $('#menus').fadeOut();
						var arr = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
						//arr = dump(arr);
						arr.splice(0, 1);
						var menuTitle = $("#menuTitle");
						var menuName = $("#menuName");
						
						if (arr.length < 1) {
							swal("Ошибка!", "Добавьте хотя бы один пункт меню!", "error");
							return true;
						}
						
						if (!menuTitle.val() || !menuName.val()) {
							//swal("Ошибка!", "Заполните все обязательные поля!", "error");
							swal({
								title: 'Ошибка!',
								text: 'Заполните все обязательные поля!',
								type: 'error'
							}, function() {
								if (!menuTitle.val()) menuTitle.parent().removeClass("has-success").addClass("has-error");
								if (!menuName.val()) menuName.parent().removeClass("has-success").addClass("has-error");
							});
							return false;
						}
						
						menuTitle.parent().removeClass("has-error").addClass("has-success");
						menuName.parent().removeClass("has-error").addClass("has-success");
						
						$("#blocked").fadeIn(400, function() {
							button.attr("disabled", "disabled");
							$('.btn').attr("disabled", "disabled");
						});
						
						//$(this).attr("disabled", "disabled");
						//alert(print_r(arr));
						//var arr1 = [];
						for(var item in arr) {
							//if (typeof(arr[item]['id']) != 'number') continue;
							//if (typeof(value) == 'object') 
							if (isEmpty(arr[item]['id'])) {
								//arr.splice(item, 1); //сдвигает массив и код дальше не идет
								continue;
							}
							
							//alert(arr[item]['id']);
							//alert(arr[item]['id']);
							if (isEmpty(arr[item]['parent_id'])) arr[item]['parent_id'] = 0;
							//arr[item] = $('#formId' + arr[item]['id']).serializeArray();
							
							//var screens = '';
							$('#formId' + arr[item]['id'] + ' input').each(function() {
								if (!isEmpty(this.name) && this.name != 'paramsmedia[]' && this.name != 'valuesmedia[]') arr[item][this.name] = this.value;
								if (this.type == 'checkbox') arr[item][this.name] = $(this).prop('checked') ? 1 : 0;
								//screens += '"' + this.name + '" : ' + this.value + '<br>';
							});
							arr[item]['description'] = $('#formId' + arr[item]['id'] + ' textarea').val();
							//$("#status").html(screens);
							//arr1.push('params');
							//arr1.item.push('params');
							arr[item]['params'] = new Object();
							//arr1 = [ [item] ]; 
							//arr1[item]['params'] = [];
							//alert(print_r(arr1));
							//arr1[item].push('params');
							$('#formId' + arr[item]['id'] + ' input[name="paramsmedia[]"]').each(function(index, element) {
								//alert($(this).val());
								//alert(index + ' -> ' + $(this).val() + ' : ' + $(this).next().val());
								if (isEmpty($(this).val()) || !$(this).val()) return;
								//arr[item]['params'][index] = 'undefined';
								//arr[item]['params'][index] = [];
								//arr[item]['params'][index][$(this).val()] = $(this).next().val();
								arr[item]['params'][$(this).val()] = $(this).next().val();
							});
							
							//if (arr[item]['parent_id'] > 0) {
								//arr[item]['parent_id'] = parseInt($("#menuItem_" + arr[item]['parent_id']).attr("data-parent"));
							//}
						}
						//alert(print_r(arr));return;
						/*
						var send_this = {
						  '123': { d1: 'aaa', d2: 'xxx' },
						  '234': { d1: 'bbb', d2: 'yyy' },
						  '345': { d1: 'ccc', d2: 'zzz' }
						};
						*/
						$.post("?view=<?=(isset($menu_item['menu_title']) && !empty($menu_item['menu_title'])?'update_menu&menu_id=' . $menu_item['menu_id']:'create_menu')?>&csrf_token=<?=$_SESSION['auth']['csrf_token']?>", {objects: arr, title: menuTitle.val(), name: menuName.val()})
							.done(function(response) { 
							//alert(print_r(response));
							//alert(response);
								
								if (response.response == 'success') {
									swal({
										title: 'Действие выполнено!',
										text: 'Меню ' + menuName.val() + ' успешно создано!',
										type: 'success'
									}, function() {
										<?php if ($config["settings"]->redirect->value): ?>
										window.location = "?view=update_menu&menu_id=" + response.result;
										<?php else: ?>
										window.location = "?view=menus";
										<?php endif; ?>
									});
								} else if (response.response == 'error') {
									if (response.result) {
										$("#ajax_res").fadeOut(400, function() {
											$(this).html(response.result).promise().done(function() {
												$(this).fadeIn(400, function() {
													$("#blocked").fadeOut(400, function() {
														button.removeAttr("disabled");
														$('.btn').removeAttr("disabled");
													});
												});
											});
										});
									} else {
										$("#blocked").fadeOut(400, function() {button.removeAttr("disabled");$('.btn').removeAttr("disabled");});
									}
								} else {
									swal("Системная ошибка!", "Что то пошло не так ;(", "error");
									$("#blocked").fadeOut(400, function() {
										button.removeAttr("disabled");
										$('.btn').removeAttr("disabled");
									});
								} arr = null;
								
								//alert(response['response']);
								//alert(response.response);
								//alert(print_r(arr));			
								
								//return;
								//for(var item in response) {
									//alert(response[item]['article']);
									//reusltObject.append('<div class="item" data-id="' + response[item]['product_id'] + '">' + response[item]['article'] + '</div>');
								//}

							}, 'json').fail(function(response) {
										alert(response);
										alert(print_r(response));
									  });
					});
					
					$(".addObject").click(function(event) {
						event.preventDefault();
						var object = $(this);
						var objectId = $(this).attr("data-id");
						var objectBody = '';
						var objectTitle = '';
						var objectTotal = $('#' + objectId + 'Object input[type=checkbox]:checked').length;
						
						switch(objectId) {
							case('page'):objectTitle = 'Страница'; break;
							case('term'):objectTitle = 'Рубрика'; break;
							case('post'):objectTitle = 'Запись'; break;
							case('product'):objectTitle = 'Товар'; break;
							case('cat'):objectTitle = 'Категория'; break;
						}
						
						object.attr("disabled", "disabled"); 
						object.parent().prepend('<i class="fa fa-refresh fa-spin fa-1x fa-fw" style="margin-right:4px;"></i>');
						
						if (objectTotal < 1) {
							swal({
								title: 'Ошибка!',
								text: 'Пожалуйста выберите хотя бы один пункт!',
								type: 'error'
							}, function() {
								object.prev().remove();
								object.removeAttr("disabled");
							});
						}
	
						$('#' + objectId + 'Object input[type=checkbox]').each(function() {
							if (parseInt($(this).attr('data-id')) < 1) return;
							if ($(this).prop('checked')) {
								var nextId = nextID();
								var tid = parseInt($(this).attr('data-id')); //alert(tid);return;
								objectBody = $('<li style="display: none;" class="mjs-nestedSortable-leaf" id="menuItem_' + nextId +'">')
									.append(
										'<div class="menuDiv">' +
											'<span class="disclose ui-icon ui-icon-minusthick"><span></span></span>' +
											'<span data-id="' + nextId +'" class="expandEditor ui-icon ui-icon-triangle-1-n"><span></span></span>' +
											'<span>' +
												'<span data-id="' + nextId +'" class="itemTitle" style="font-size:10px;color:#e71616;">[' + objectTitle + ']</span>' +
												'<span data-id="' + nextId +'" class="itemTitle" style="font-size:20px;">&nbsp;' + escapeHtml($(this).attr('data-title')) + '</span>' +
												'<span data-id="' + nextId +'" class="deleteMenu ui-icon ui-icon-closethick" style="margin-top: 5px;"><span></span></span>' +
											'</span>' +
											'<div id="menuEdit' + nextId +'" class="menuEdit hidden1">' +
												'<form id="formId' + nextId +'">' +
													'<div class="form-group">' +
														'<label style="min-width: 49%;">Текст:' +
															'<input class="form-control" name="text" value="' + $(this).attr('data-title') + '">' +
														'</label>&nbsp;' +
														'<label style="min-width: 49%;">Атрибут alt:' +
															'<input class="form-control" name="alt">' +
														'</label>' +
													'</div>' +
													'<div class="form-group" style="display:none;">' +
														'<label style="width: 99%;" class="has-success">URL:' +
															'<input class="form-control urlClass" name="url" value="' + $(this).attr('data-slug') + '">' +
														'</label>' +
													'</div>' +
													'<div class="form-group">' +
														'<label style="width: 99%;">Описание: (<span style="font-size:10px;color:#e71616;">Внимание! Разрещено использовать HTML!</span>)' +
															'<textarea class="form-control textareaMenu" name="description"></textarea>' +
														'</label>' +
													'</div>' +
													'<div class="form-group">' +
														'<label style="width: 99%;">Открывать в новом окне?&nbsp;' +
															'<input type="checkbox" name="blank">' +
														'</label>' +
													'</div>' +
													<?php if ($config["plugins"]->menus->menumediafields->active): ?>
													'<div style="border: 1px dashed rgb(217, 83, 79)!important;padding: 8px;">' +
														'<span style="font-weight: 700;">Медиа поля:</span>' +
														'<div id="paramsmedia' + nextId + '"></div>' +
														'<div data-max="8" data-id="0" data-fieldid="' + nextId + '" style="display:none;"></div>' +
														'<input type="button" value="Добавить" class="btn btn-sm btn-success addParam" />&nbsp;|&nbsp;<input disabled="disabled" type="button" value="Удалить" class="btn btn-sm btn-danger removeParam" />' +
													'</div>' +
													<?php endif; ?>
													'<input type="hidden" name="type" value="' + objectId + '">' +
													'<input type="hidden" name="tid" value="' + tid + '">' +
													//'<input type="hidden" name="object_id" value="' + oid + '">' +
												'</form>' +
											'</div>' +
										'</div>' 
									);
									//alert(objectBody);
									stepUp();
									
									ns.append($(objectBody)).promise().done(function() {
										$('#menuItem_' + nextId).fadeIn(700, function() {
											ns.nestedSortable('refresh');
											//console.log(ns.nestedSortable('toArray'));
											//linkTitle.val('');linkName.val('');   		
											
											$('.expandEditor').attr('title','Показать/Скрыть дополнительные параметры');
											$('.disclose').attr('title','Показать/Скрыть потомков');
											$('.deleteMenu').attr('title', 'Удалить объект с потомками');
											
											$('#' + objectId + 'Object input[type=checkbox]').prop('checked', false);
											
											object.prev().remove();
											object.removeAttr("disabled");
										});
									});
							}
							
						});
					});
					
					$("#addLink").click(function(event) {
						event.preventDefault();
						var object = $(this);
						var linkTitle = $("#linkTitle");
						var linkName = $("#linkName");
						object.attr("disabled", "disabled");
						object.parent().prepend('<i class="fa fa-refresh fa-spin fa-1x fa-fw" style="margin-right:4px;"></i>');
                        
                        setTimeout(function() {
                            if (linkTitle.val() != '' && linkName.val() != '') {
                                var nextId = nextID();
                                var html = $('<li style="display: none;" class="mjs-nestedSortable-leaf" id="menuItem_' + nextId +'">')
                                            .append(
												'<div class="menuDiv">' +
													'<span class="disclose ui-icon ui-icon-minusthick"><span></span></span>' +
													'<span data-id="' + nextId +'" class="expandEditor ui-icon ui-icon-triangle-1-n"><span></span></span>' +
													'<span>' +
														'<span data-id="' + nextId +'" class="itemTitle" style="font-size:10px;color:#e71616;">[Ссылка]</span>' +
														'<span data-id="' + nextId +'" class="itemTitle" style="font-size:20px;">&nbsp;' + escapeHtml(linkTitle.val()) + '</span>' +
														'<span data-id="' + nextId +'" class="deleteMenu ui-icon ui-icon-closethick" style="margin-top: 5px;"><span></span></span>' +
													'</span>' +
													'<div id="menuEdit' + nextId +'" class="menuEdit hidden1">' +
														'<form id="formId' + nextId +'">' +
															'<div class="form-group">' +
																'<label style="min-width: 49%;">Текст ссылки:' +
																	'<input class="form-control" name="text" value="' + escapeHtml(linkTitle.val()) + '">' +
																'</label>&nbsp;' +
																'<label style="min-width: 49%;">Атрибут alt:' +
																	'<input class="form-control" name="alt">' +
																'</label>' +
															'</div>' +
															'<div class="form-group" >' +
																'<label style="width: 99%;" class="has-success">URL ссылки:' +
																	'<input class="form-control urlClass" name="url" value="' + linkName.val() + '">' +
																'</label>' +
															'</div>' +
															'<div class="form-group">' +
																'<label style="width: 99%;">Описание: (<span style="font-size:10px;color:#e71616;">Внимание! Разрещено использовать HTML!</span>)' +
																	'<textarea class="form-control textareaMenu" name="description"></textarea>' +
																'</label>' +
															'</div>' +
															'<div class="form-group">' +
																'<label style="width: 99%;">Открывать в новом окне?&nbsp;' +
																	'<input type="checkbox" name="blank">' +
																'</label>' +
															'</div>' +
															<?php if ($config["plugins"]->menus->menumediafields->active): ?>
															'<div style="border: 1px dashed rgb(217, 83, 79)!important;padding: 8px;">' +
																'<span style="font-weight: 700;">Медиа поля:</span>' +
																'<div id="paramsmedia' + nextId + '"></div>' +
																'<div data-max="8" data-id="0" data-fieldid="' + nextId + '" style="display:none;"></div>' +
																'<input type="button" value="Добавить" class="btn btn-sm btn-success addParam" />&nbsp;|&nbsp;<input disabled="disabled" type="button" value="Удалить" class="btn btn-sm btn-danger removeParam" />' +
															'</div>' +
															<?php endif; ?>
															'<input type="hidden" name="type" value="url">' +
														'</form>' +
													'</div>' +
												'</div>'
											);
                                ns.append($(html)).promise().done(function() {
									$('#menuItem_' + nextId).fadeIn(450, function() {
										ns.nestedSortable('refresh');
										//console.log(ns.nestedSortable('toArray'));
										linkTitle.val('');linkName.val('');   
										stepUp();
										
										$('.expandEditor').attr('title','Показать/Скрыть дополнительные параметры');
										$('.disclose').attr('title','Показать/Скрыть потомков');
										$('.deleteMenu').attr('title', 'Удалить объект с потомками');
										
										object.prev().remove();
										object.removeAttr("disabled");
									});
								});
                            } else {
                                //alert('Заполните все обязательные поля!');
								//swal("Ошибка!", "Заполните все обязательные поля!", "error");
								swal({
									title: 'Ошибка!',
									text: 'Заполните все обязательные поля!',
									type: 'error'
								}, function() {
									object.prev().remove();
									object.removeAttr("disabled");
								});
                            }
							
							object.parent().prev().removeClass("has-error").removeClass("has-success");

                        }, 300);
                        
					});

					$(".addSearch").hide().attr("disabled", "disabled");
					$(".addSearch").click(function(event) {
						event.preventDefault();
						var object = $(this);
						var objectTitle = '';
						var objectBody = '';
						object.attr("disabled", "disabled");
						object.parent().prepend('<i class="fa fa-refresh fa-spin fa-1x fa-fw" style="margin-right:4px;"></i>');
						//return;
						if (object.parent().parent().prev().children("div").length > 0) {
							object.parent().parent().prev().children("div").each(function(key, item) {
								if (parseInt($(item).attr("data-id")) < 1 ) return;

								switch($(item).attr("data-type")) {
									case('page'):objectTitle = 'Страница'; break;
									case('term'):objectTitle = 'Рубрика'; break;
									case('post'):objectTitle = 'Запись'; break;
									case('product'):objectTitle = 'Товар'; break;
									case('cat'):objectTitle = 'Категория'; break;
								}

								var nextId = nextID();
								var tid = parseInt($(item).attr("data-id")); //alert(tid);return;
								objectBody = $('<li style="display: none;" class="mjs-nestedSortable-leaf" id="menuItem_' + nextId +'">')
									.append(
										'<div class="menuDiv">' +
										'<span class="disclose ui-icon ui-icon-minusthick"><span></span></span>' +
										'<span data-id="' + nextId +'" class="expandEditor ui-icon ui-icon-triangle-1-n"><span></span></span>' +
										'<span>' +
										'<span data-id="' + nextId +'" class="itemTitle" style="font-size:10px;color:#e71616;">[' + objectTitle + ']</span>' +
										'<span data-id="' + nextId +'" class="itemTitle" style="font-size:20px;">&nbsp;' + escapeHtml($(item).attr('data-title')) + '</span>' +
										'<span data-id="' + nextId +'" class="deleteMenu ui-icon ui-icon-closethick" style="margin-top: 5px;"><span></span></span>' +
										'</span>' +
										'<div id="menuEdit' + nextId +'" class="menuEdit hidden1">' +
										'<form id="formId' + nextId +'">' +
										'<div class="form-group">' +
										'<label style="min-width: 49%;">Текст:' +
										'<input class="form-control" name="text" value="' + escapeHtml($(item).attr('data-title')) + '">' +
										'</label>&nbsp;' +
										'<label style="min-width: 49%;">Атрибут alt:' +
										'<input class="form-control" name="alt">' +
										'</label>' +
										'</div>' +
										'<div class="form-group" style="display:none;">' +
										'<label style="width: 99%;" class="has-success">URL:' +
										'<input class="form-control urlClass" name="url" value="' + $(item).attr('data-slug') + '">' +
										'</label>' +
										'</div>' +
										'<div class="form-group">' +
										'<label style="width: 99%;">Описание: (<span style="font-size:10px;color:#e71616;">Внимание! Разрещено использовать HTML!</span>)' +
										'<textarea class="form-control textareaMenu" name="description"></textarea>' +
										'</label>' +
										'</div>' +
										'<div class="form-group">' +
										'<label style="width: 99%;">Открывать в новом окне?&nbsp;' +
										'<input type="checkbox" name="blank">' +
										'</label>' +
										'</div>' +
										<?php if ($config["plugins"]->menus->menumediafields->active): ?>
										'<div style="border: 1px dashed rgb(217, 83, 79)!important;padding: 8px;">' +
										'<span style="font-weight: 700;">Медиа поля:</span>' +
										'<div id="paramsmedia' + nextId + '"></div>' +
										'<div data-max="8" data-id="0" data-fieldid="' + nextId + '" style="display:none;"></div>' +
										'<input type="button" value="Добавить" class="btn btn-sm btn-success addParam" />&nbsp;|&nbsp;<input disabled="disabled" type="button" value="Удалить" class="btn btn-sm btn-danger removeParam" />' +
										'</div>' +
										<?php endif; ?>
										'<input type="hidden" name="type" value="' + $(item).attr("data-type") + '">' +
										'<input type="hidden" name="tid" value="' + tid + '">' +
										//'<input type="hidden" name="object_id" value="' + oid + '">' +
										'</form>' +
										'</div>' +
										'</div>'
									);
								//alert(objectBody);
								stepUp();

								ns.append($(objectBody)).promise().done(function() {
									$('#menuItem_' + nextId).fadeIn(700, function() {
										ns.nestedSortable('refresh');
										//console.log(ns.nestedSortable('toArray'));
										//linkTitle.val('');linkName.val('');

										$('.expandEditor').attr('title','Показать/Скрыть дополнительные параметры');
										$('.disclose').attr('title','Показать/Скрыть потомков');
										$('.deleteMenu').attr('title', 'Удалить объект с потомками');

										//$('#' + objectId + 'Object input[type=checkbox]').prop('checked', false);
										object.parent().parent().prev().fadeOut(400, function(){
											$(this).html('').fadeIn(400);
											object.prev().remove();
											object.fadeOut(200);
										});

									});
								});
							});
						} else {
							object.fadeOut(400, function() {
								object.attr("disabled", "disabled");
							});
						}
					});
						
					$('.iframe-btn').fancybox({
						'width'	: 900,
						'minHeight'	: 600,
						'type'	: 'iframe',
						'autoScale'   : false
					});	
					
					$("#menuTitle").keyup(function() {
						if ($(this).val()) $(this).parent().removeClass("has-error");
					});

				});
				
				$(document).ready(function() {
					var MIN_LENGTH = 2;
					$(".objectSearch").keyup(function() {
						var objectId = $(this);
						var reusltObject = $(this).parent().next().children(":first-child");
						var objectRequest = objectId.val();
						var objectAction = 'menu';
						var objectPerpage = parseInt(objectId.prev().find('option:selected').text());
						reusltObject.css("border", "none");
						var mode = objectId.attr('data-id');
						var objectResults = objectId.parent().next().next();
						var simulars = [];
						
						if (objectRequest.length >= MIN_LENGTH) {
							objectResults.find('input[name="simular[]"]').each(function(key, value) {
								simulars.push($(value).val())
							}); 
							$.post("?view=auto_complete", {request: objectRequest, action: objectAction, perpage: objectPerpage, mode: mode, simulars: simulars})
							.done(function(response) { 
								reusltObject.html(''); 
								if (response.request == "success") {
									$(response.result).each(function(key, value) {
										$(value).each(function(keyid, valueid) {
											if (mode == 'product')
												reusltObject.append('<div class="item" data-id="' + valueid[mode + '_id'] + '" data-slug="' + valueid[mode + '_slug'] + '">['+ valueid[mode + '_article'] + '] ' + valueid[mode + '_title'] + '</div>');
											else
												reusltObject.append('<div class="item" data-id="' + valueid[mode + '_id'] + '" data-slug="' + valueid[mode + '_slug'] + '">' + valueid[mode + '_title'] + '</div>');
										});
									});
									
									$('.item').click(function() { //&nbsp;
										var fullurl;
										switch(mode) {
											case('post'): fullurl = '/post/' + $(this).attr('data-slug') + '/'; break;
											case('page'): fullurl = '/page/' + $(this).attr('data-slug') + '/'; break;
											case('term'): fullurl = '/term/' + $(this).attr('data-slug') + '/'; break;
											case('cat'): fullurl = '/category/' + $(this).attr('data-slug') + '/'; break;
											case('product'): fullurl = '/product/' + $(this).attr('data-slug') + '/'; break;
											default: fullurl = '/' + $(this).attr('data-slug') + '/';
										}
										objectResults.append('<div data-type="' + mode + '" data-id="' + $(this).attr('data-id') + '" data-slug="' + fullurl + '" data-title="' + escapeHtml($(this).html()) + '"><span class="remove_item"><i class="fa fa-trash"></i> ' + $(this).html() + '</span><input type="hidden" name="simular[]" value="' + $(this).attr('data-id') + '"></div>');
										$(this).remove();
										if (reusltObject.children("div.item").length < 1) {
											reusltObject.css("border", "none");
										}
										if (objectResults.children("div").length > 0) {
											objectResults.next().children("div").children("button.addSearch").fadeIn(300).removeAttr("disabled");
										}
									});
									
								}
								
								if (response.request == "notfound") {
									reusltObject.append('<div class="item">Ничего не найденно!</div>');
								}
								
								if (reusltObject.children("div.item").length > 0) {
									reusltObject.css("border", "1px solid #c0c0c0");
								} else {
									reusltObject.css("border", "none");
								}

							}, 'json')
							.fail(function() {
								swal("Ошибка!", "Что то пошло не так ;(", "error");
							});
						} else {
							reusltObject.html('');
						}
					});

					$(".objectSearch").blur(function() {
						$(this).parent().next().children(":first-child").fadeOut(600);
					})
					.focus(function() {		
						$(this).parent().next().children(":first-child").fadeIn(300);
					});
					
					$(".searchButton").click(function(event) {
						event.preventDefault();
						$(this).parent().prev().focus();
					});

				});
				
				$(document).delegate('.remove_item', 'click', function(event) {
					event.preventDefault();
					$(this).parent().fadeOut(600, function() {
						var obj = $(this);
						var btn = obj.parent().next().children(":first-child").children("button.addSearch");					
						if (obj.parent().children().length < 2) {btn.attr('disabled', 'disabled'); btn.fadeOut(400);}
						obj.remove();
					});
				});
				
				var urlFormat = 'Неверный формат URL адреса!<br>Валидный формат:<ul><li>http://yandex.ru/</li><li>/category/example/</li><li>/page/example.html</li><li>/page/example.html#some_tag</li></ul>';
				
				$(document).delegate('.urlClass', "keyup", function() {
					checkInput($(this), '^[\/a-z.-_:#!]+$', '#doit', urlFormat);
				});
				
				$(document).delegate('#linkName', "keyup", function() {
					checkInput($(this), '^[\/a-z.-_:#!]+$', '#addLink', urlFormat);
				});
				
				$(document).delegate('#menuName', "keyup", function() {
					checkInput($(this), '^[a-z_-]+$', '#doit', 
						'Неверный формат поля <b>callname</b> разрешаются только маленькие латинские буквы знак подчеркивания и дефиса!'
					);
				});
				
				$(document).delegate('.addParam', 'click', function(event) {
					event.preventDefault();
					var objectParam = $(this);
					var maxParams = objectParam.prev().attr('data-max');
					var idParam = parseInt(objectParam.prev().attr('data-id')) + 1;
					var idField = parseInt(objectParam.prev().attr('data-fieldid'));
					var totalParams = objectParam.prev().prev().children().length;
					
					if (totalParams < maxParams) {
						objectParam.prev().prev().append(
							'<div>' +
								'<span class="remove">Х</span>' +
								'<input class="form-control" type="text" name="paramsmedia[]" style="display:inline-block;width:25%;" placeholder="название" />' +
									'&nbsp;:&nbsp;' +
								'<input id="fieldID' + idField + '' + idParam + '" class="form-control fieldID" type="text" name="valuesmedia[]" placeholder="значение" />' +
								'<span class="input-group-btn" style="display: inline;margin-left: 0px;margin-top: 0px;position: absolute;">' +
									'<button href="/library/filemanager/dialog.php?akey=<?=UPLOAD_KEY?>&field_id=fieldID' + idField + '' + idParam + '&relative_url=1" style="padding: 6px 0px 6px 17px;" class="btn btn-default iframe-btn" type="button">' +
										'<i class="fa fa-fw fa-camera" style="position: relative;top: -3px;left: -2px;color: grey;"></i>' +
										'<i class="fa fa-fw fa-music" style="position: relative;left: -13px;top: 2px;color: grey;"></i>' +
									'</button>' +
								'</span>' +
							'</div>');
						if (maxParams == totalParams + 1) {objectParam.attr("disabled", "disabled");}
						objectParam.prev().attr('data-id', idParam);
						objectParam.next().removeAttr("disabled");
					}
				});
				
				$(document).delegate('.removeParam', 'click', function(event) {
					event.preventDefault();
					$('.remove:last').click();
				});
				
				$(document).delegate('.disclose', 'click', function() {
					$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
					$(this).toggleClass('ui-icon-plusthick').toggleClass('ui-icon-minusthick');
				});
				
				$(document).delegate('.expandEditor, .itemTitle', 'click', function() {
					var id = $(this).attr('data-id');
					$('#menuEdit'+id).toggle();
					$(this).toggleClass('ui-icon-triangle-1-n').toggleClass('ui-icon-triangle-1-s');
				});
				
				$(document).delegate('.remove', 'click', function() {			
					var objectParent = $(this).parent();
					objectParent.fadeOut(300, function() {
						if (objectParent.parent().children().length < 2) {objectParent.parent().next().next().next().attr("disabled", "disabled");}
						objectParent.remove();
					});									
				});
				
				$(document).delegate('.deleteMenu', 'click', function() {			
					var objectMenu = $(this);
					var objectMenuId = $(this).attr('data-id');
					swal({
						  title: "Вы действительно хотите удалить пункт меню?",
						  text: "Внимание! Вместе с этим пунктом так же будут удалены его потомки если они есть!",
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
								//$('#menuItem_' + objectMenu.attr('data-id')).remove();
								//swal("Действие выполнено!", "Пункт меню успешно удален!", "success");
								$("#doit").attr("disabled", "disabled");
								stepDown();								
								swal({
									title: 'Действие выполнено!',
									text: 'Пункт меню успешно удален!',
									type: 'success'
								}, function() {
									$('#menuItem_' + objectMenuId + ' .menuDiv').animate({"background-color":"#f2dede","border-color":"#ebccd1"}, 600, 
										function() {
											//menuDiv
											$('#menuItem_' + objectMenuId).fadeOut(300, function() {
												$(this).remove();
												$("#doit").removeAttr("disabled");
											});
										});
								});
						  } else {
								swal("Отмена!", "Предыдущее действие было отменено!", "error");
						  }
						});								
				});
				
				function checkInput(object, pattern, button, content) {
					var value = object.val();
					var pattern = new RegExp(pattern);
					
					if (value != "" && !value.match(pattern)) {
						$(button).attr("disabled", "disabled");
						object.attr("data-container", "body");
						object.attr("data-toggle", "popover");
						object.attr("data-placement", "top");
						object.attr("data-trigger", "focus");
						object.attr("data-html", "true");
						object.attr("data-content", content);
						
						object.parent().removeClass("has-success").addClass("has-error");
						$("[data-toggle=popover]").popover();
						object.popover('show');
						return false;
					} else {
						$(button).removeAttr("disabled");
						object.parent().removeClass("has-error").addClass("has-success");
						object.popover('hide');
						object.attr("data-container");
						object.attr("data-toggle");
						object.attr("data-placement");
						object.attr("data-trigger");
						object.attr("data-html");
						object.attr("data-content");
					}
					
					if (value == "") object.parent().removeClass("has-error").removeClass("has-success");

				}
				
				function escapeHtml(text) {
				  var map = {
					'&': '&amp;',
					'<': '&lt;',
					'>': '&gt;',
					'"': '&quot;',
					"'": '&#039;'
				  };

				  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
				}
				
				function isEmpty(str) {
					return (!str || 0 === str.length);
				}
				
				function dump(arr,level) {
					var dumped_text = "";
					if(!level) level = 0;
			
					//The padding given at the beginning of the line.
					var level_padding = "";
					for(var j=0;j<level+1;j++) level_padding += "    ";
			
					if(typeof(arr) == 'object') { //Array/Hashes/Objects
						for(var item in arr) {
							var value = arr[item];
			
							if(typeof(value) == 'object') { //If it is an array,
								dumped_text += level_padding + "'" + item + "' ...\n";
								dumped_text += dump(value,level+1);
							} else {
								dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
							}
						}
					} else { //Strings/Chars/Numbers etc.
						dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
					}
					return dumped_text;
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
			</script>
			
			<div id="resize" class="col-lg-4 col-md-5">
					
				<div class="form-group">
					<label style="width:100%">Название<span style="color:red;font-size:18px;">*</span>:
						<input id="menuTitle" class="form-control" name="title" value="<?=(isset($menu_item['menu_title']) && !empty($menu_item['menu_title'])?$menu_item['menu_title']:'')?>">
					</label>
					
					<label style="width:100%">callname<span style="color:red;font-size:18px;">*</span>:
						<input id="menuName" class="form-control" name="name" value="<?=(isset($menu_item['menu_name']) && !empty($menu_item['menu_name'])?$menu_item['menu_name']:'')?>">
					</label>
					
					<div style="float:right;"><button id="doit" class="btn btn-<?=(isset($menu_item['menu_name']) && !empty($menu_item['menu_name'])?'primary':'success')?>"><?=(isset($menu_item['menu_name']) && !empty($menu_item['menu_name'])?'Обновить меню':'Добавить меню')?></button></div>
				</div>
				
				<div id="accordion" style="margin-top: 40px;">
					<?php if ($config["modules"]->terms->active): ?>
						<h3>Рубрики</h3>
						<div>
							<div id="tabs-terms">
								<ul>
									<li><a href="#tabs-1">Все</a></li>
									<li><a href="#tabs-2">Поиск</a></li>
								</ul>
								<div id="tabs-1">
									<div class="module-box" id="termObject">
										<?php if (!empty($terms_objects) && is_array($terms_objects)): ?>
											<!-- createObjectsTree($objects, 'page', 'table') -->
											<?=createCheckboxObjectsTree($terms_objects, 'term')?>
											<div style="width:100%;height:28px;margin-top:10px;">
												<div style="float:right;">
													<button data-id="term" class="btn btn-sm btn-success addObject">Добавить в меню</button>
												</div>
											</div>
										<?php endif; ?>
									</div>
								</div>
								<div id="tabs-2">
									<div class="form-group input-group" style="margin-bottom:0;">
										<select id="select-resize" class="form-control" style="height:29px;padding:2px;width:20%">
											<option>10</option>
											<option>20</option>
											<option>30</option>
											<option>40</option>
											<option>50</option>
											<option>60</option>
											<option>70</option>
											<option>80</option>
											<option>90</option>
											<option>100</option>
										</select>
										<input id="input-resize" data-id="term" type="text" class="form-control objectSearch" style="height:29px;width:80%;" placeholder="Поиск по заголовку" list="datalist">
										<span class="input-group-btn"><button class="btn btn-default searchButton" type="button"><i class="fa fa-search" style="font-size: 15px;"></i></button></span>
									</div>
									<div class="module-box" style="margin-bottom:10px;">
										<div class="results"></div>
									</div>
									<div class="simular" style="margin-bottom:10px;"></div>
									<div style="width:100%;height:28px;margin-top:10px;">
										<div style="float:right;">
											<button data-id="term" class="btn btn-sm btn-success addSearch">Добавить в меню</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($config["modules"]->posts->active): ?>
						<h3>Записи</h3>
						<div>
							<div id="tabs-posts">
								<ul>
									<li><a href="#tabs-1">Поиск</a></li>
								</ul>
								<div id="tabs-1">
									<div class="form-group input-group" style="margin-bottom:0;">
										<select id="select-resize" class="form-control" style="height:29px;padding:2px;width:20%">
											<option>10</option>
											<option>20</option>
											<option>30</option>
											<option>40</option>
											<option>50</option>
											<option>60</option>
											<option>70</option>
											<option>80</option>
											<option>90</option>
											<option>100</option>
										</select>
										<input id="input-resize" data-id="post" type="text" class="form-control objectSearch" style="height:29px;width:80%;" placeholder="Поиск по заголовку" list="datalist">
										<span class="input-group-btn"><button class="btn btn-default searchButton" type="button"><i class="fa fa-search" style="font-size: 15px;"></i></button></span>
									</div>
									<div class="module-box" style="margin-bottom:10px;">
										<div class="results"></div>
									</div>
									<div class="simular" style="margin-bottom:10px;"></div>
									<div style="width:100%;height:28px;margin-top:10px;">
										<div style="float:right;">
											<button data-id="post" class="btn btn-sm btn-success addSearch">Добавить в меню</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($config["modules"]->pages->active): ?>
					<h3>Страницы</h3>
					<div>
						<div id="tabs-pages">
							<ul>
								<li><a href="#tabs-1">Все</a></li>
								<li><a href="#tabs-2">Поиск</a></li>
							</ul>
							<div id="tabs-1">
								<div class="module-box" id="pageObject">
								<?php if (!empty($pages_objects) && is_array($pages_objects)): ?>
									<!-- createObjectsTree($objects, 'page', 'table') -->
									<?=createCheckboxObjectsTree($pages_objects, 'page')?>
									<div style="width:100%;height:28px;margin-top:10px;">
										<div style="float:right;">
											<button data-id="page" class="btn btn-sm btn-success addObject">Добавить в меню</button>
										</div>
									</div>
								<?php endif; ?>
								</div>
							</div>
							<div id="tabs-2">
								<div class="form-group input-group" style="margin-bottom:0;">
									<select id="select-resize" class="form-control" style="height:29px;padding:2px;width:20%">
										<option>10</option>
										<option>20</option>
										<option>30</option>
										<option>40</option>
										<option>50</option>
										<option>60</option>
										<option>70</option>
										<option>80</option>
										<option>90</option>
										<option>100</option>
									</select>
									<input id="input-resize" data-id="page" type="text" class="form-control objectSearch" style="height:29px;width:80%;" placeholder="Поиск по заголовку" list="datalist">
									<span class="input-group-btn"><button class="btn btn-default searchButton" type="button"><i class="fa fa-search" style="font-size: 15px;"></i></button></span>
								</div>
								<div class="module-box" style="margin-bottom:10px;">
									<div class="results"></div>
								</div>
								<div class="simular" style="margin-bottom:10px;"></div>
								<div style="width:100%;height:28px;margin-top:10px;">
									<div style="float:right;">
										<button data-id="page" class="btn btn-sm btn-success addSearch">Добавить в меню</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>
					<?php if ($config["modules"]->cats->active): ?>
						<h3>Категории</h3>
						<div>
							<div id="tabs-cats">
								<ul>
									<li><a href="#tabs-1">Все</a></li>
									<li><a href="#tabs-2">Поиск</a></li>
								</ul>
								<div id="tabs-1">
									<div class="module-box" id="catObject">
										<?php if (!empty($terms_objects) && is_array($terms_objects)): ?>
											<!-- createObjectsTree($objects, 'page', 'table') -->
											<?=createCheckboxObjectsTree($cats_objects, 'cat')?>
											<div style="width:100%;height:28px;margin-top:10px;">
												<div style="float:right;">
													<button data-id="cat" class="btn btn-sm btn-success addObject">Добавить в меню</button>
												</div>
											</div>
										<?php endif; ?>
									</div>
								</div>
								<div id="tabs-2">
									<div class="form-group input-group" style="margin-bottom:0;">
										<select id="select-resize" class="form-control" style="height:29px;padding:2px;width:20%">
											<option>10</option>
											<option>20</option>
											<option>30</option>
											<option>40</option>
											<option>50</option>
											<option>60</option>
											<option>70</option>
											<option>80</option>
											<option>90</option>
											<option>100</option>
										</select>
										<input id="input-resize" data-id="cat" type="text" class="form-control objectSearch" style="height:29px;width:80%;" placeholder="Поиск по заголовку" list="datalist">
										<span class="input-group-btn"><button class="btn btn-default searchButton" type="button"><i class="fa fa-search" style="font-size: 15px;"></i></button></span>
									</div>
									<div class="module-box" style="margin-bottom:10px;">
										<div class="results"></div>
									</div>
									<div class="simular" style="margin-bottom:10px;"></div>
									<div style="width:100%;height:28px;margin-top:10px;">
										<div style="float:right;">
											<button data-id="cat" class="btn btn-sm btn-success addSearch">Добавить в меню</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<?php if ($config["modules"]->products->active): ?>
						<h3>Товары</h3>
						<div>
							<div id="tabs-products">
								<ul>
									<li><a href="#tabs-1">Поиск</a></li>
								</ul>
								<div id="tabs-1">
									<div class="form-group input-group" style="margin-bottom:0;">
										<select id="select-resize" class="form-control" style="height:29px;padding:2px;width:20%">
											<option>10</option>
											<option>20</option>
											<option>30</option>
											<option>40</option>
											<option>50</option>
											<option>60</option>
											<option>70</option>
											<option>80</option>
											<option>90</option>
											<option>100</option>
										</select>
										<input id="input-resize" data-id="product" type="text" class="form-control objectSearch" style="height:29px;width:80%;" placeholder="Поиск по заголовку" list="datalist">
										<span class="input-group-btn"><button class="btn btn-default searchButton" type="button"><i class="fa fa-search" style="font-size: 15px;"></i></button></span>
									</div>
									<div class="module-box" style="margin-bottom:10px;">
										<div class="results"></div>
									</div>
									<div class="simular" style="margin-bottom:10px;"></div>
									<div style="width:100%;height:28px;margin-top:10px;">
										<div style="float:right;">
											<button data-id="product" class="btn btn-sm btn-success addSearch">Добавить в меню</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
					<h3>Произвольные ссылки</h3>
					<div>
						<div class="form-group" style="margin-bottom:0;">
							<label style="width:100%">Текст ссылки<span style="color:red;font-size:10px;">*</span>:
								<input id="linkTitle" class="form-control" name="title" style="height: 27px;">
							</label>
							
							<label style="width:100%">URL ссылки<span style="color:red;font-size:10px;">*</span>:
								<input id="linkName" class="form-control urlClass" name="name" style="height: 27px;">
							</label>
							
							<div style="float:right;"><button id="addLink" class="btn btn-sm btn-success">Добавить в меню</button></div>
						</div>
					</div>
				</div>
					
			</div>
			
			<div class="col-lg-8 col-md-7">
				<div class="blocked-main">
					<div id="blocked" style="display:none;"><div style="display: table-cell;vertical-align: middle;"><i class="fa fa-refresh fa-spin fa-5x fa-fw" style="font-size: 200px;"></i><span class="sr-only">Загрузка...</span></div></div>
					<div id="menus">
						<h3 style="font-size:24px;">Структура меню</h3>
						<p>Расположите элементы в желаемом порядке путём перетаскивания.<br>
							Можно также щёлкнуть на стрелку слева от элемента, чтобы открыть дополнительные настройки.</p>
						<ol class="sortable"><?=(!empty(isset($menu_objects))?buildAdminMenu($menu_objects):'')?></ol>
					</div>
				</div>
			</div>
		</div>
		<!-- /.row -->
	</div>
</div>