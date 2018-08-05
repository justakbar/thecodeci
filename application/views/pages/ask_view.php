<div class ="container">
  	<div class="row">
    	<div class="col-md-9">
      		<div class = "main">
      			<?php 
      				if (isset($success)) 
      					echo $success;
      			?>
        		<form action = "<?php echo base_url(); ?>ask" method="post">
	        		<p>
	        			<h4>Заголовок вопроса:</h4>
	        			<input type="text" name="zagqu" class = "form-control" placeholder="Заголовка вопрос" value="<?php echo set_value('zagqu'); ?>">	
	        		</p>
	        		<p>
	        			<h5>Чтобы писать код нажмите на - <code><?php echo htmlentities("</>") ?></code></h5>
	        		</p>
	        		<h3>Основной текст</h3>
	        		
	        		<section id="page-demo">
	                  	<textarea id="txt-content" name = "tekst" data-autosave="editor-content" required><?php echo set_value('tekst'); ?></textarea>
	                </section>

	                <p>
	                	<h4>Метки</h4>
	                	<input type="text" name="metki" placeholder="введите не менее 1 и не более 5" class = "form-control" value = "<?php echo set_value('metki'); ?>">
	                </p>

	                <input type="submit" name="send" value = "Задать" class = "btn btn-primary">

	        	</form>
      		</div>
    	</div>
    	<?php 
			$this->load->view('templates/right');
		?>
  	</div>
</div>