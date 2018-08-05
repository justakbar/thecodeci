<div class ="container">
	<div class="row">
		<div class="col-md-9">
			<div class = "main">
				<div class="alert alert-success" role="alert">
					<div class = "row">
						<div class = "col-md-8">
							У вас есть идея или проект и вам нужны программисты, тогда вам сюда
						</div>
						<div class = "col-md-4">
							<a class = "btn btn-primary" href="<?php echo base_url(); ?>order"> Разместить заказ</a>
						</div>
					</div>
				</div>
				<h4>Заказы</h4>
	<?php 
		if (is_array($data)) {
			foreach ($data as $key) {
	?>
	<div class = "border border-white padding-order">
		<div class = "row">
			<div class = "col-md-9">
				<h4>
					<a class = "questionlink" href = "<?php echo base_url(); ?>ordvac/order/<?php echo $key['id'] ?>"><?php echo $key['zagqu']; ?></a>
				</h4> 
			</div>
			<div class = "col-md-3">
				<center><span class = "cost"><?php echo $key['cost']; ?> </span></center>
			</div>
		</div>
		<div class = "row">
			<div class = "col-md-6">
				<h6 class = "cost"> 
					<?php echo $key['views'] . htmlspecialchars(" • ") . $key['published']; ?>
				</h6>
			</div>
		</div>
	</div>
	<hr/>
<?php } echo $this->pagination->create_links(); 
} else echo $data;?>
			</div>
		</div>
		<?php 
			$this->load->view('templates/right');
		?>
	</div>
</div>