<div class ="container">
	<div class="row">
		<div class="col-md-9">
			<div class = "main">
			<?php 
				/*echo '<pre>';
				print_r($data);
				echo '</pre';*/
				if (is_array($data)) {
					foreach ($data as $value) {
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
					} echo $this->pagination->create_links();
				} else echo 'Ничего не найдено!';
			?>
			</div>
		</div>
	</div>
</div>