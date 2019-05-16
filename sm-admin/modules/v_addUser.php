<?php defined("_SMARTMEDIA") or die(); ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Добавить пользователя</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i><a href="?view=dashboard"> Панель</a></li>
					<li><i class="fa fa-group"></i><a href="?view=users"> Пользователи</a></li>
					<li class="active"><i class="fa fa-male"></i> Добавить пользователя</li>
				</ol><?php if (isset($_SESSION['answer'])) {echo $_SESSION['answer']; unset($_SESSION['answer']);}  ?>
			</div>
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-8">
				<form action="?view=add_user&csrf_token=<?=$_SESSION['auth']['csrf_token']?>" method="POST" role="form">
					
					<div class="form-group">
						<label>Логин<span style="color:red;font-size:18px;">*</span>:</label>
						<input class="form-control" name="login" value="<?=_arg('login')?>">
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
							<option value="2"<?php if (_arg('status') == 2):?> selected<?php endif;?>>Демо пользователь</option>
							<option value="3"<?php if (_arg('status') == 3):?> selected<?php endif;?>>Пользователь</option>
							<option value="5"<?php if (_arg('status') == 5):?> selected<?php endif;?>>Менеджер</option>
							<option value="4"<?php if (_arg('status') == 4):?> selected<?php endif;?>>Администратор</option>
					   </select>
					</div>
					
					<div class="form-group">
						<label>Почта<span style="color:red;font-size:18px;">*</span>:</label>
						<input class="form-control" name="email" value="<?=_arg('email')?>">
					</div>
					
					<div class="form-group">
						<label>Телефон:</label>
						<input class="form-control" name="phone" value="<?=_arg('phone')?>">
					</div>
					
					<div class="form-group">
						<label>Имя:</label>
						<input class="form-control" name="name" value="<?=_arg('name')?>">
					</div>
					
					<div class="form-group">
						<label>Фамилия:</label>
						<input class="form-control" name="surname" value="<?=_arg('surname')?>">
					</div>
					
					<div class="form-group">
						<label>Отчество:</label>
						<input class="form-control" name="middle" value="<?=_arg('middle')?>">
					</div>	
					
					<div class="form-group">
						<label>О себе:</label>
						<textarea class="form-control" name="about"><?=_arg('about')?></textarea>
					</div>
					
					<div class="form-group">
						<label>Адрес:</label>
						<textarea class="form-control" name="address"><?=_arg('address')?></textarea>
					</div>
					
					<button type="submit" class="btn btn-success">Добавить пользователя</button>

				</form><?=cArgs()?>

			</div>
		</div>
		<!-- /.row -->
	</div>
</div>