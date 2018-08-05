<div class ="container">
		<div class="row">
			<div class="col-md-9">
				<?php 
					$value = $data;
					if ($value != false) {
						$value['phonenumber'] = (!empty($value['phonenumber'])) ? '+' . $value['phonenumber'] : $value['phonenumber'];
						$value['messenger_number'] = (!empty($value['messenger_number'])) ? '+' . $value['messenger_number'] : $value['messenger_number'];
				?>
				<div class = "row row border border-white padding rounded">
					<div class = "col-md-3">
						<img src="/resource/img/profile-pictures1.png" class="img-thumbnail">
					</div>
					<div class = "col-md-9">
						<table width="50%" height = "150px">
							<caption><strong>Информация</strong></caption>

							<tr>
								<td width="200">Имя:</td>
								<td><?php echo $value['first_name']; ?></td>
							</tr>
							<tr> 
								<td>Фамилья:</td>
								<td><?php echo $value['last_name']; ?></td>
							</tr>
							<tr>
								<td>Логин:</td>
								<td><?php echo $value['login']; ?></td>
							</tr>
							<tr>
								<td>Задал(а) вопрос:</td>
								<td><?php echo $value['ask']; ?></td>
							</tr>
							<tr>
								<td>Ответил(а):</td>
								<td><?php echo $value['answer']; ?></td>
							</tr>
						</table>
						<table>
							<caption><strong>Контактные данные</strong></caption>
							<tr>
								<td width="200">Телефон:</td>
								<td><?php echo $value['phonenumber']; ?></td>
							</tr>
							<tr>
								<td>Мессенджер (<?php echo $value['messenger']; ?>) :</td>
								<td><?php echo $value['messenger_number']; ?></td>
							</tr>
							<tr>
								<td>Эл. почта:</td>
								<td><?php echo $value['contactemail']; ?></td>
							</tr>
						</table>
					</div>
				</div>
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Вопросы</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Заказы</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
					<?php 

						if ($question != false) {
						foreach ($question as $value) {
					?>
					<div class = "row blockquote">
						<div class = "col-md-8">
						   	<a href = "<?php echo base_url(); ?>question/num/<?php echo $value['id']; ?>" class = "questionlink"><?php echo $value['zagqu']; ?></a>
						    <div class = "row">
						      	<div class = "col-md-5">
						        	<p> 
					                	<small>Asked <a class = "a" href = "<?php echo base_url(); ?>user/info/<?php echo $value['login']; ?>"><?php echo $value['login']; ?> </a><?php echo $value['dates']; ?></small>
					                </p>
						       	</div>
						       	<div class = "col-md-7">
						        	<?php echo $value['tags']; ?>
						       	</div>
						    </div>
						</div>

						<div class = "col-md-2 border border-white">
						 	<center><small><?php echo $value['views']; ?></small>
						    	<h6><small>просмотров</small></h6>
						  	</center>
						</div>

						<div class = "col-md-2 border border-white">
						  	<center><small><?php echo $value['answers']; ?></small>
						    	<h6><small>Ответов</small></h6>
						  	</center>
						</div>
					</div>
				<?php
					}
				} else echo 'Вопросы нет!';
				?>
				</div>
				<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
				<?php 
					$num = 0;
					if ($order != false) {
						foreach ($order as $val) {
							$num++;
							?>
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<div class = "alert alert-success">
											<i class="fas fa-sort-down"></i>
											<a class = "questionlink" role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $num; ?>" aria-expanded="true" aria-controls="collapseOne">
												<?php echo $val['zagqu']; ?>
											</a>
										</div>
									</div>
									<div id="<?php echo $num; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
										<div class="panel-body">
											<div class = "border border-white padding-order margin">
												<div class = "row">
													<div class = "col-md-12">
														<h4>
															<a class = "questionlink" href = "<?php echo base_url(); ?>ordvac/order/<?php echo $val['id']; ?>"><?php echo $val['zagqu']; ?></a>
														</h4> 
													</div>
												</div>
												<div class = "row">
													<div class = "col-md-6">
														<span class = "cost">
															<?php echo $val['cost'] ?> за проект 
														</span>
														<br/>
														<span class = "cost"> 
															<?php echo $val['views'] . htmlspecialchars(" • "); ?>
														</span>
														<span class = "cost">
															<?php echo $val['published']; ?>
														</span>
													</div>
												</div>
												<hr/>
												<div class = "row tekst">
													<div class = "col-md-12">
														<?php echo $val['tekst']; ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php }
						} else echo 'Заказы нет!';?>
				</div>
			</div>
			<?php
				} else echo '<div class = "alert alert-danger">User not found!</div>';
			?>
		</div>
		<?php 
			$this->load->view('templates/right');
		?>
	</div>
</div>