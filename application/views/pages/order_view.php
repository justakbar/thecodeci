<div class ="container">
	<div class="row">
		<div class="col-md-9">
			<?php 
				if (is_array($data)) {
					$value = $data;
			?>

			<div class = "border border-white padding-order margin">
				<div class = "row">
					<div class = "col-md-12">
						<h4>
							<a class = "questionlink" href = "<?php echo base_url(); ?>ordvac/order/<?php echo $value['id']; ?>"><?php echo $value['zagqu']; ?></a>
						</h4> 
					</div>
				</div>
				<div class = "row">
					<div class = "col-md-6">
						<span class = "cost">
							<?php echo $value['cost'] ?> за проект 
						</span>
						<br/>
						<span class = "cost"> 
							<?php echo $value['viewed'] . htmlspecialchars(" • "); ?>
						</span>
						<span class = "cost">
							<?php echo $value['published']; ?>
						</span>
					</div>
				</div>
				<hr/>
				<div class = "row tekst">
					<div class = "col-md-12">
						<?php echo $value['text']; ?>
					</div>
				</div>
				<div class = "row">
					<div class = "col-md-12">
						<small>Заказчик: <a class = "questionlink" href = "<?php echo base_url(); ?>user/info/<?php echo $value['login']; ?>"><?php echo $value['full_name']; ?></a></small>
					</div>
				</div>
			</div>
		<?php } else echo $data; ?>
		</div>
	</div>
</div>