<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Редактор пользователя</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li><i class="fa fa-group"></i><a href="?view=users"> Пользователи</a></li>
					<li class="active"><i class="fa fa-male"></i> Редактор пользователя</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-8">
				<form action="?view=update_user&user_id=<?=$object['user_id']?>&csrf_token=<?=$_SESSION['auth']['csrf_token']?>" method="POST" role="form">
					
					<div class="form-group">
						<label>Логин<span style="color:red;font-size:18px;">*</span>: </label>
						<input class="form-control" name="login" value="<?=$object['user_login']?>">
					</div>
					
					<div class="form-group">
						<label>Пароль<span style="color:red;font-size:18px;">*</span>:</label>
						<input class="form-control" name="password">
					</div>
					
					<div class="form-group">
						<label>Повторите пароль<span style="color:red;font-size:18px;">*</span>:</label>
						<input class="form-control" name="password2">
					</div>
					
					<div class="form-group">
						<label>Роль:</label>
						<select name="status" class="form-control">
							<option value="2"<?php if ($object['user_status'] == 1):?> selected<?php endif;?>>Демо пользователь</option>
							<option value="3"<?php if ($object['user_status'] == 2):?> selected<?php endif;?>>Пользователь</option>
							<option value="5"<?php if ($object['user_status'] == 4):?> selected<?php endif;?>>Менеджер</option>
							<option value="4"<?php if ($object['user_status'] == 3):?> selected<?php endif;?>>Администратор</option>
					   </select>
					</div>
					
					<div class="form-group">
						<label>Почта<span style="color:red;font-size:18px;">*</span>:</label>
						<input class="form-control" name="email" value="<?=$object['user_email']?>">
					</div>
					
					<div class="form-group">
						<label>Телефон:</label>
						<input class="form-control" name="phone" value="<?=$object['user_phone']?>">
					</div>
					
					<div class="form-group">
						<label>Имя:</label>
						<input class="form-control" name="name" value="<?=$object['user_name']?>">
					</div>
					
					<div class="form-group">
						<label>Фамилия:</label>
						<input class="form-control" name="surname" value="<?=$object['user_surname']?>">
					</div>
					
					<div class="form-group">
						<label>Отчество:</label>
						<input class="form-control" name="middle" value="<?=$object['user_middlename']?>">
					</div>	
					
					<div class="form-group">
						<label>О себе:</label>
						<textarea class="form-control" name="about"><?=$object['user_about']?></textarea>
					</div>
					
					<div class="form-group">
						<label>Адрес:</label>
						<textarea class="form-control" name="address"><?=$object['user_address']?></textarea>
					</div>
					
					<button type="submit" class="btn btn-primary">Обновить пользователя</button>

				</form>

			</div>
		</div>
		<!-- /.row -->
	</div>
</div>