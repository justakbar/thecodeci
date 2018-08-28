<div class="col-md-3 metki">
<?php
	
	$array = $this->right_model->get_right_side();

	echo '
	<div class = "card">
		<div class = "card-header">
			Метки
		</div>';
	$i = 0;
	if (!empty($array)) {
		foreach ($array as $key => $value) {
			if(++$i == 11) break;
?>
	<div class = "padding">
		<a class = "badge badge-light" href = "<?php echo base_url(); ?>question/tag/<?php echo urlencode($key); ?>"><?php echo $key; ?></a> 
		<span> x <?php echo $value; ?></span>
	</div>
	<?php 
		}
	} echo '</div>';
	?>
</div>