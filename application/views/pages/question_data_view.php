<div class="container">
	<div class="row">
		<div class="col-md-9">
        	<div class = "main">
<?php
	$value = $data;
	if (is_array($value)) {
?>
<div class = "row">
	<div class = "col-md-9">
		<h3><?php echo $value['zagqu'] ?></h3>
	</div>
	<div class = "col-md-3">
		<h6>
			<small>viewed: <?php echo $value['views']; ?></small><br/>
			<small> Asked: <?php echo $value['dates']; ?></small><br/>
			<small> User: <a class = "questionlink" href = "<?php echo base_url(); ?>user/info/<?php echo $value['login']; ?>"><?php echo $value['login']; ?></a></small>
		</h6> 
	</div>
</div>
<hr/>
<small>All votes <?php echo $value['allvotes'];?></small>
<div class = "row">
	<div class = "col-1">
		<center>
			<button class = "btn btn-light" id = "voteup" title = "This question is useful" <?php echo $value['voteDis'][0];?>><i class = "fas fa-chevron-up"></i></button>
			<h4 id = "rating"><?php echo $value['votes']; ?></h4>
			<button class = "btn btn-light" id = "votedown" title = "This question is not useful" <?php echo $value['voteDis'][1];?>><i class = "fas fa-chevron-down"></i></button>
		</center>
	</div>
	<div class = "col-11">
		<h4>Question</h4>
		<div class = "ques">
			<?php echo $value['question']; ?>
		</div>
		<div class = "row">
			<div class = "col-md-12" align = "right">
				Метки: <?php echo $value['tags']; ?>
			</div>
		</div>
	</div>
</div>
<hr>
<div class = "row">
	<div class = "col-md-12">
		<h5><?php echo $value['answers']; ?></h5>
	</div>
</div>
<hr/>
<?php 
	if (!empty($answer)) {
		foreach ($answer as $key => $val) {
?>
	<div class = "row blockquote">
		<!-- <div class = "col-1 border-right">
			<center>
				<button class = "btn btn-light" id = "voteup" title = "This question is useful" <?php echo $value['voteDis'][0];?>><i class = "fas fa-chevron-up"></i></button>
				<h4 id = "rating"><?php echo $value['votes']; ?></h4>
				<button class = "btn btn-light" id = "votedown" title = "This question is not useful" <?php echo $value['voteDis'][1];?>><i class = "fas fa-chevron-down"></i></button>
			</center>
		</div> -->
		<div class = "col-md-12">
			<?php echo $val['answer']; ?>
			<div class = "row">
				<div class = "col-md-4">
				</div>
				<div class = "col-md-6">
				</div>
				<div class = "col-2">
					<small>
						Ответил(а)
						<a class = "questionlink" href = "<?php echo base_url(); ?>user/info/<?php echo $val['login']; ?>"><?php echo $val['login']; ?></a>
						<?php echo '<br/>'.$val['dates']; ?>
					</small>
				</div>
			</div>
		</div>
	</div>
	<hr/>
<?php
		}
	}
?>
<h3>Ответить</h3>
<form action="<?php echo base_url() . 'question/num/' . $value['id']; ?>" method="post">
    <section id="page-demo">
        <textarea id="txt-content" name="answertext" data-autosave="editor-content" required></textarea>
    </section>
    <input type="submit" name="send" value="Отправить" class="btn btn-secondary margin">
</form>
<?php } else echo $value;?>
			</div>
		</div>
		<?php 
			$this->load->view('templates/right');
		?>
	</div>
</div>