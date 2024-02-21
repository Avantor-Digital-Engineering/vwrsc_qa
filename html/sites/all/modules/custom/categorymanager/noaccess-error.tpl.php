<?php
?>
<div class="right_cont">
	<div class="inbread">
		<a href="<?php echo base_path(); ?>">VWR Home</a>
	</div>
	<div class="cat_cont">
		<br /> &nbsp; &nbsp; Sorry! Page is not available to display for you, please click <a href="<?php echo base_path(); ?>">Home</a> and proceed. <br /><br />
		<?php print (isset($_SESSION['error_content']) && trim($_SESSION['error_content'])) ? $_SESSION['error_content'] : ''; ?>
		<br />
	</div>
</div>