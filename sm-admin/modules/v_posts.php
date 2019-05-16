<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Записи</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li class="active"><i class="fa fa-pencil"></i> Записи</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<script type="text/javascript">
			function confirmUser($id) {
				$(document).ready(function() {
					swal({
					  title: "Вы действительно хотите удалить запись?",
					  text: "Внимание! Так же будут удалены все связи с рубриками если они есть!",
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
							swal({
								title: 'Действие выполнено!',
								text: 'Запись успешно удалена!',
								type: 'success'
							}, function() {window.location = "?view=remove_post&csrf_token=<?=$_SESSION['auth']['csrf_token']?>&post_id=" + $id;});
					  } else {
							swal("Отмена!", "Предыдущее действие было отменено!", "error");
					  }
					});
				});
			}
			$(document).ready(function() {
				$('#all_post').change(function() {
					var prop = false;
					if ($(this).is(':checked')) prop = true;
					$('input[name*=post]').each(function() {
						$(this).prop('checked', prop);
					});
				});
			});
		</script>
		<div class="row">
			<div class="col-lg-12">
				<h2>Записи в системе</h2>
				<div style="margin-bottom:4px;">
					<div style="margin-bottom:4px;">
						<a href="?view=add_post" class="btn btn-sm btn-primary">Добавить запись</a> 
						<a href="?view=posts" class="btn btn-sm btn-warning">Сбросить фильтры</a>
					</div>
					<form>
						<input type="hidden" name="view" value="posts">
						<input type="hidden" name="order_by" value="post_id">
						<input type="hidden" name="filer_date" value="true">
						<table>
							<tr>
								<td style="padding: 2px;">Дата создания:</td>
								<td style="padding: 2px;">
									<select name="date[]" class="form-control" style="display: inline;min-width: 140px;width: 0px;height: 31px;padding-top: 5px;">
										<option value="-1" selected="selected">Все даты</option>
										<?=$datecreate?>
									</select>
								</td>
								<td style="padding: 2px;">
									<select name="term[]" class="form-control" style="display: inline;height: 31px;padding-top: 5px;">
										<option value="-1" selected="selected">Все рубрики</option>
										<?php foreach($obj as $ob): ?>
											<option value="<?=$ob['term_id']?>"><?=$ob['term_title']?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td style="padding: 2px;"><input type="submit" class="btn btn-sm btn-success" value="Фильтр"></td>
							</tr>
							<tr>
								<td style="padding: 2px;">Дата публикации:</td>
								<td style="padding: 2px;">
									<select name="date[]" class="form-control" style="display: inline;min-width: 140px;width: 0px;height: 31px;padding-top: 5px;">
										<option value="-1" selected="selected">Все даты</option>
										<?=$datepublic?>
									</select>
								</td>
								<td style="padding: 2px;">
									<select name="term[]" class="form-control" style="display: inline;height: 31px;padding-top: 5px;">
										<option value="-1" selected="selected">Все рубрики</option>
										<?php foreach($obj as $ob): ?>
											<option value="<?=$ob['term_id']?>"><?=$ob['term_title']?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td style="padding: 2px;"><input type="submit" class="btn btn-sm btn-success" value="Фильтр"></td>
							</tr>
							<tr>
								<td style="padding: 2px;">Дата изменения:</td>
								<td style="padding: 2px;">
									<select name="date[]" class="form-control" style="display: inline;min-width: 140px;width: 0px;height: 31px;padding-top: 5px;">
										<option value="-1" selected="selected">Все даты</option>
										<?=$dateupdate?>
									</select>
								</td>
								<td style="padding: 2px;">
									<select name="term[]" class="form-control" style="display: inline;height: 31px;padding-top: 5px;">
										<option value="-1" selected="selected">Все рубрики</option>
										<?php foreach($obj as $ob): ?>
											<option value="<?=$ob['term_id']?>"><?=$ob['term_title']?></option>
										<?php endforeach; ?>
									</select>
								</td>
								<td style="padding: 2px;"><input type="submit" class="btn btn-sm btn-success" value="Фильтр"></td>
							</tr>
						</table>
					</form>
					<div>
						<div style="float:left;">
							<form method="post" style="display: inline;" id="data">
								<select name="action" class="form-control" style="display: inline;min-width: 140px;width: 0px;height: 31px;padding-top: 5px;">
									<option value="-1" selected="selected">Действия</option>
									<option value="trash">Удалить</option>
									<option value="public">Опубликовать</option>
									<option value="hide">Скрыть</option>
								</select>
								<input type="submit" class="btn btn-sm btn-success" value="Применить">&nbsp;|&nbsp;
							</form>
						</div>
						<form style="display: inline;">
							<input type="hidden" name="view" value="posts">
							<input type="hidden" name="filer_visible" value="true">
							<input type="hidden" name="order_by" value="post_id">
							<input type="hidden" name="field[]" value="post_visible">
							<input type="hidden" name="field[]" value="term_id">
							<div style="float:left; margin-right: 4px;">
								<select name="value[]" class="form-control" style="display: inline; height: 31px;padding-top: 5px;">
									<option value="0">Скрыто</option>
									<option value="1">Опубликовано</option>
								</select>
							</div>
							<div style="float:left; margin-right: 4px;">
								<select name="value[]" class="form-control" style="display: inline;height: 31px;padding-top: 5px;">
									<option value="-1" selected="selected">Все рубрики</option>
									<?php foreach($obj as $ob): ?>
										<option value="<?=$ob['term_id']?>"><?=$ob['term_title']?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<input type="submit" class="btn btn-sm btn-success" value="Показать">
						</form>
					</div>
				</div>
				<?php if (is_array($objects) && !empty($objects)): ?>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th><input type="checkbox" id="all_post"></th>
								<th>ID</th>
								<th>Заголовок</th>
								<th>Автор</th>
								<th>Рубрика</th>
								<th>Дата</th>
								<th>Действие</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($objects as $object): ?>
							<tr>
								<td><input form="data" type="checkbox" name="post[]" value="<?=$object["post_id"]?>"></td>
								<td><?=$object["post_id"]?></td>
								<td style="max-width:400px;"><a href="/post/<?=$object["post_slug"]?>/" target="_blank"><?=$object["post_title"]?></a></td>
								<td><?=getUserNameByAdmin(['user_id'=>$object["user_id"],'user_login'=>$object["user_login"],'user_name'=>$object["user_name"],'user_surname'=>$object["user_surname"],'user_middlename'=>$object["user_middlename"]])?></td>
								<td>
									<?php $object['objectNames'] = explode('|', $object['objectNames']); ?>
									<?php $object['objectIds'] = explode('|', $object['objectIds']); ?>
									<?php 
										if (!empty($object['objectNames'][0])) {
											foreach($object['objectNames'] as $key => $value) {
												echo '<a href="?view=posts&order_by=post_id&field=term_id&value=' . $object['objectIds'][$key] . '">' . $value . '</a>' . ((count($object['objectNames']) > $key + 1) ? ', ' : '');
											}
										} else {
											echo "&mdash;";
										}
									?>
								</td>
								<td>Публикация: <?=date_format(date_create($object["post_datecreate"]), 'd.m.Y H:i')?><br>Изменения: <?=date_format(date_create($object["post_dateupdate"]), 'd.m.Y H:i')?><br>Статус: <?=($object["post_visible"]==1?'<span style="color:green;">Опубликовано</span>':'<span style="color:red;">Скрыто</span>')?></td>
								<td style="text-align:center;vertical-align:middle;">
									<a href="?view=update_post&post_id=<?=$object["post_id"]?>" type="button" class="btn btn-sm btn-success">Изменить</a>
									<a href="#" onclick='confirmUser(<?=$object["post_id"]?>);return false;' type="button" class="btn btn-sm btn-danger">Удалить</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
					</form>
				<?=pageNavi()?>
				<?php else: ?>
				<div class="alert alert-warning">
					<strong>Записей не найдено!</strong> записей пока нет, добавьте первую!
				</div>
				<?php endif; ?>
			</div>

		</div>
		<!-- /.row -->


	</div>
	<!-- /.container-fluid -->

</div>