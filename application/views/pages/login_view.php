<div class ="container">
	<div class="row">
		<div class = "col-md-6 offset-md-3">
			<div class="card text-center mx-auto">
				<div class="card-header">
					<center><strong>Вход</strong></center>
				</div>
				<div class = "card-body">
					<form action = "<?php echo base_url() ?>login" method="post">

						<p><input type="text" class="form-control loginplace" name = "username" placeholder="Имя пользователя" value = "<?php echo set_value('username'); ?>"></p>
						<p><input type="password" class="form-control loginplace" name = "password" placeholder="Пароль"></p>
						<div class = "float-left">
							<button type="sumbit" name="send" class = "btn btn-primary btn-sm">Вход</button>
							<a href = "/registration" class = "btn btn-success btn-sm">Регистрация</a>
						</div>
					</form>
				</div>
			</div>
			<div class = "margin">
			<?php 

				if (isset($verify)) {
					echo $verify;
				}
				if (isset($success)) 
					echo $success;
				echo form_error('username') . form_error('password');
			?>
			</div>
		</div>
	</div>
</div>