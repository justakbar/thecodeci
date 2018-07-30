
<div class ="container">
	<div class="row">
		<div class="col-md-9">
			<div class = "row border border-white padding rounded">
				<div class = "col-md-3">
					<img src="/resource/img/profile-pictures1.png" class="img-thumbnail">
					<br/>
					<a href = "/logout" class="btn btn-primary">Выход</a>
				</div>
				<?php 
					$value = $data;
					$value['phonenumber'] = (!empty($value['phonenumber'])) ? '+' . $value['phonenumber'] : $value['phonenumber'];
					$value['messenger_number'] = (!empty($value['messenger_number'])) ? '+' . $value['messenger_number'] : $value['messenger_number'];
				?>
				<div class = "col-md-9">
					<table>
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
							<td>Ответил(а) вопрос:</td>
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
			<div class = "row border border-white padding">
				<div class = "col-md-6">
					<form action = "<?php echo base_url() . 'profile' ?>" method="post" class = "passwordform">
						<p>
							<center>
								<strong>
									Изменить пароль
								</strong>
							</center>
						</p>
				<?php
					if (isset($update))
						echo $update;
				?>
						<p><input type="password" class = "form-control" name="lastpass" placeholder="Текщий пароль"></p>
						<p><input type="password" class = "form-control" name="newpass1" placeholder="Новый пароль"></p>
						<p><input type="password" class = "form-control" name="newpass2" placeholder="Повторите новый пароль"></p>
						<p><input name="update" class="btn btn-primary btn-sm" value="Изменить" type="submit"></p>
					</form>
				</div>
				<div class = "col-md-6">
					<form action="/profile" method="post">
						<p>
							<center>
								<strong>
									Контактные данные
								</strong>
							</center>
						</p>
					<?php
						if(isset($updatecontact)) {
							foreach ($updatecontact as $key) {
								echo $key;
							}
						}
						$selected1 = '';
						$selected2 = '';
						if ($value['messenger'] == 'WhatsApp')
							$selected1 = 'selected';
						else if ($value['messenger'] == 'Telegram')
							$selected2 = 'selected';
					?>
						<p><input type="text" class = "form-control" name="phonenumber" placeholder="Телефон" value = "<?php echo $value['phonenumber']; ?>"></p>
						<p><input type="email" class = "form-control" name="contactemail" placeholder="Эл. почта" value = "<?php echo $value['contactemail']; ?>"></p>
						<p>
							<div class = "row">
								<div class = "col-6">
									<select class = "custom-select custom-select-sm" name = "messenger">
										<option value = "" selected>Меседжеры</option>
										<option value = "WhatsApp"<?php echo $selected1; ?>>WhatsApp</option>
										<option value = "Telegram"<?php echo $selected2; ?>>Telegram</option>
									</select>
								</div>
								<div class = "col-6">
									<input type="text" class = "form-control" name="messengerdata" placeholder="+998931234567" value = "<?php echo $value['messenger_number']; ?>">
								</div>
							</div>
						</p>
						<p><input name="contact" class="btn btn-primary btn-sm" value="Сохранить" type="submit"></p>
					</form>
				</div>
			</div>



<!-- ========================================= Questions And Orders ======================================================== -->
	
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="home-tab" data-toggle="tab" href="#question" role="tab" aria-controls="home" aria-selected="true">Вопросы</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="profile-tab" data-toggle="tab" href="#order" role="tab" aria-controls="profile" aria-selected="false">Заказы</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="question" role="tabpanel" aria-labelledby="home-tab">
					<?php 
						$soraw = $question;
						if (!empty($soraw)) {
							foreach ($soraw as $value) {
					?>
					<div class = "row blockquote">
						<div class = "col-md-8">
							<a href = "<?php echo base_url(). 'question/num/' . $value['id']; ?>" class = "questionlink"><?php echo $value['zagqu']; ?></a>
							<div class = "row">
								<div class = "col-md-5">
									<p> 
										<small>Asked <a class = "a" href = "/user/<?php echo $value['login']; ?>"><?php echo $value['login']; ?> </a><?php echo $value['dates']; ?></small>
									</p>
								</div>
								<div class = "col-md-7">
									<?php echo $value['tags']; ?>
								</div>
							</div>
						</div>

						<div class = "col-md-2 border border-white">
							<center>
								<small><?php echo $value['views']; ?></small>
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
					} else echo 'Вопросов нет!';
					?>
				</div>
				<div class="tab-pane fade show" id="order" role="tabpanel" aria-labelledby="home-tab">
					<?php 
				if (!empty($order)) {
				foreach ($order as $val) {
					if ($val['visibility'] == '1') {
						$name = 'visibile_' . $val['id'];
						$buttonid = 'visibile';
						$icon = '<i id = "icon' . $val['id'] . '" class="fas fa-eye-slash"></i>';
					} else {
						$name = 'invisibile_' . $val['id'];
						$buttonid = 'invisibile';
						$icon = '<i id = "icon' . $val['id'] . '" class="fas fa-eye"></i>';
					}
			?>
			<div class="panel-group" id="accordion_<?php echo $val['id']; ?>" role="tablist" aria-multiselectable="true">
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingOne">
						<span class="panel-title">
							<div class = "alert alert-success">
								<i class="fas fa-sort-down"></i>
								<a role="button" class = "questionlink" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $val['id']; ?>" aria-expanded="true" aria-controls="collapseOne">
									<?php echo $val['zagqu']; ?>
								</a>
								<div class = "float-right">
									<button class = "btn btn-secondary" name = "<?php echo $name; ?>" id = "<?php echo $buttonid; ?>"><?php echo $icon; ?>
									</button>
									<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal<?php echo $val['id']; ?>">
										<i class="fas fa-trash-alt"></i>
									</button>
									<div class="modal fade" id="exampleModal<?php echo $val['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Вы действительно хотите удалить</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-footer">
													<button data-dismiss="modal" class = "btn btn-danger" name = "delete_<?php echo $val['id']; ?>" id = "delete">
														Да
													</button>
													<button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>	
						</span>
					</div>
					<div id="<?php echo $val['id']; ?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
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
											<?php echo $val['viewed'] . htmlspecialchars(" • "); ?>
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
		} else 'Заказы нет!'; ?>
				</div>
			</div>
		</div>
		<?php 
			$this->load->view('templates/right');
		?>
	</div>
</div>