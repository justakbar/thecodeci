<div class="container">
	<div class="row">
		<div class="col-md-9">
        	<div class = "main">
				<div class = "row">
					<div class = "col-md-12">
						<h4>Разместить заказ</h4>
						<hr/>
						<div class="border border-white padding-order">
							<?php 
								if(is_array($error))
									foreach ($error as $key) {
										echo '<div class = "alert alert-danger">'.$key. '</div>';
									}
								else echo $error;
							?>
							<form action = "<?php echo base_url(); ?>order" method="post">
								<p>
			    					<h6>Название заказа *</h6>
			    					<input type="text" name="zagqu" class = "form-control" placeholder="Кратко и конкретно" value = "<?php echo set_value('zagqu'); ?>">
			    				</p>
			    				<p>
			    					<h6>Бюджет *</h6>
			    					<input type="text" class = "form-control costwidth" name="cost" placeholder="Цена" value = "<?php echo set_value('cost'); ?>">
			    					<select class="custom-select custom-select-sm valwidth" name = "valyuta">
										<option value="UZS">сум</option>
										<option value="RUB">рубль</option>
										<option value="USD">доллар</option>
									</select>
			    				</p>	
			    				<p>
			    					<small>
			    					Не указывайте контактные данные в описании заказа, для итого использовайте <a href = "/profile">профиль</a> 
			    					</small>
									<fieldset>
										<textarea id="noise" name="noise" class="widgEditor nothing"><?php echo set_value('noise'); ?></textarea>
									</fieldset>
								</p>
								<p>
									<h6>Сфера деятельности *</h6>
									<select class="custom-select custom-select-sm valwidth" name = "domain">
										<option value = "1">Разработка</option>
										<option value = "2">Тестирование</option>
										<option value = "3">Администрирование</option>
										<option value = "4">Разное</option>
									</select>
								</p>
								<input type="submit" name="send" class = "btn btn-success">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>