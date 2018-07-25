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
<div class = "row">
	<div class = "col-md-12">
		<h4>Question</h4>
		<div class = "ques">
			<?php echo html_entity_decode($value['question']); ?>
		</div>
		<div class = "row">
			<div class = "col-md-12" align = "right">
				Метки: <?php echo $value['tags']; ?>
			</div>
		</div>
	</div>
</div>
<div class = "row">
	<div class = "col-md-12">
		<h5><?php echo $value['answers']; ?> Answers</h5>
	</div>
</div>
<hr/>
<?php 
	if (!empty($answer)) {
		foreach ($answer as $key => $val) {
?>
	<div class = "row blockquote">
		<div class = "col-md-2 border-right">
			<span style = "font-size: 11pt;">Ответил(а)</span>
			<small>
				<a class = "questionlink" href = "<?php echo base_url(); ?>user/info/<?php echo $val['login']; ?>"><?php echo $val['login']; ?></a>
			</small>
			<br/>
			<small> <?php echo $val['dates']; ?></small>
		</div>
		<div class = "col-md-10">
			<?php echo $val['answer']; ?>
		</div>
	</div>
	<hr/>
<?php
		}
	}
?>
<h3>Ответить</h3>
<form action="<?php echo base_url() . 'question/num/' .$value['id']; ?>" method="post">
    <section id="page-demo">
        <textarea id="txt-content" name="answertext" data-autosave="editor-content" required></textarea>
    </section>
    <input type="submit" name="send" value="Отправить" class="btn btn-secondary margin">
</form>
<?php } else echo $value;?>
			</div>
		</div>
	</div>
</div>