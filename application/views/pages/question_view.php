<div class="container">
	<div class="row">
		<div class="col-md-9">
        	<div class = "main">
        		<h4>Все вопросы</h4>
        		<small><?php echo $allQuestions; ?> questions</small>
        		<hr>
<?php foreach ($question as $value) { ?>
<div class = "row blockquote">
	<div class = "col-md-9">
	   	<a href = "/question/num/<?php echo $value['id']; ?>" class = "questionlink"><?php echo $value['zagqu']; ?></a>
	    <div class = "row">
	      	<div class = "col-md-5">
	        	<p> 
                	<small>Asked <a class = "a" href = "/user/info/<?php echo $value['login']; ?>"><?php echo $value['login']; ?> </a><?php echo $value['dates']; ?></small>
                </p>
	       	</div>
	       	<div class = "col-md-7">
	        	<?php echo $value['tags']; ?>
	       	</div>
	    </div>
	</div>
	<div class = "col-md-1 border border-white">
	  	<center><small><?php echo $value['votes']; ?></small>
	    	<h6><small>votes</small></h6>
	  	</center>
	</div>
	<div class = "col-md-1 border border-white">
	 	<center><small><?php echo $value['views']; ?></small>
	    	<h6><small>views</small></h6>
	  	</center>
	</div>

	<div class = "col-md-1 border border-white">
	  	<center><small><?php echo $value['answers']; ?></small>
	    	<h6><small>answers</small></h6>
	  	</center>
	</div>
</div>
<hr/>
<?php }
	echo '<div class = "pagination">'.$pagination.'</div>';
?>
			</div>
		</div>
		<?php 
			$this->load->view('templates/right');
		?>
	</div>
</div>