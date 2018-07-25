<div class ="container">
  <div class="row">
    <div class = "col-md-6 offset-md-3">
      	<div class="card text-center mx-auto">
        	<div class="card-header">
        		<center><strong>Регистрация</strong></center>
        	</div>
        	<div class = "card-body">
  		    	<form action = "/registration" method="post" class = "form-group">
      				<p><input type="text" class="form-control loginplace" name = "first_name" placeholder="Имя" value = "<?php echo set_value('first_name'); ?>"></p>
      				<p><input type="text" class="form-control loginplace" name = "last_name" placeholder="Фамилья" value = "<?php echo set_value('last_name'); ?>"></p>
  		    		<p><input type="email" class="form-control loginplace" name = "email" placeholder="Эл. почта" value = "<?php echo set_value('email'); ?>"></p>
  		    		<p><input type="text" class="form-control loginplace" name = "username" placeholder="Логин" value = "<?php echo set_value('username'); ?>"></p>
  		    		<p><input type="password" class="form-control loginplace" name = "password1" placeholder="Пароль"></p>
  		    		<p><input type="password" class="form-control loginplace" name = "password2" placeholder="Повторите пароль"></p>
  	    			<div class = "float-left">
                <button type = "submit" class = "btn btn-success btn-sm" name = "send">Регистрация</button>
    	    			<a href = "/login" name="send" class = "btn btn-primary btn-sm">Вход</a>
              </div>
  		    	</form>
    	    </div>
  	    </div>
        <?php
          if(!empty($msg)) {
        ?>
        <div class = "margin">
  	      <div class="alert alert-danger" role="alert">
  	        <?php 
  	          foreach ($msg as $errors) {
  	            echo $errors;
  	          }
  	        ?>
  	      </div>
        </div>
        <?php } ?>
    </div>
  </div>
</div>