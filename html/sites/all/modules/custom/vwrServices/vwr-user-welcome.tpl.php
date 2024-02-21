	<style type="text/css">
		div.simplemodal-container {
			top: 30px !important;
			height: 500px !important;
			width: 525px !important;
		}
	</style>
	<?php
	$query = db_query("SELECT welcome_title,welcome_text,welcome_image FROM {welcomepage_details}");
	$number_of_rows = $query->rowCount();
	if ($number_of_rows != '') {
		foreach ($query as $record) {
			$welcome_title = $record->welcome_title;
			$welcome_text = $record->welcome_text;
			$welcome_image = $record->welcome_image;
		}
	?>
		<input type="hidden" id="welcome-action" value="update" />
	<?php
	} else {
	?>
		<input type="hidden" id="welcome-action" value="insert" />
	<?php
	}
	?>
	<div id="welcomeform" style="height:325px;">
		<div class="error" id="welcome_error" style="margin-top:0px;display:none;width:357px;clear:both"></div>
		<div id="status_msg" style="margin-top:0px;width:357px;clear:both"></div>
		<form name="form1" id="welcome_form" enctype="multipart/form-data">
			<div class="reg_labl" style="height:20px; width:50px;"><span>*</span>
				<label>Title:</label>
			</div>
			<input type="text" id="welcome_title" value="<?php echo $welcome_title; ?>" size="55" maxlength="65" style="margin-bottom:18px" /><br>
			<div class="reg_labl" style="height:20px"><span>*</span>
				<label>Text :</label>
			</div>
			<div style="clear:both"></div>
			<div style="padding-left:40px; margin-left:10px;">
				<textarea cols="20" rows="10" id="welcome-text" name="welcome-text" style="clear:both; float:left;">
				<?php echo $welcome_text; ?></textarea>
			</div>
			<div style="clear:both; margin-bottom:10px;"></div>
			<div class="reg_labl" style="height:20px;"><span>*</span>
				<label>Upload image :</label>
			</div>
			<input type="file" id="welcome_img" name="welcome_img" onchange="initiateScan()"/>
			<?php
			$img_validate = 1;
			if ($welcome_image) {
				$img_validate = 0;
			}
			?>
			<div style="clear:both">&nbsp;</div>
			<div class="popBut" style="height:20px;padding-left:180px; #padding-left:0px;">
				<input type="hidden" id="file_id" name="file_id" value="" />
				<input type="hidden" id="uploaded_file_name" name="uploaded_file_name" value="" />
				<input type="button" class="button" value="Save" onclick="welcomevalidate('<?php echo $img_validate; ?>');" />
				<input type="button" class="button simplemodal-close" value="Cancel" />
			</div>
		</form>
	</div>
	<div class="popBut" id="popButFinal" style="display:none">
		<div style="width:300px; padding:54px 0px 0px 90px;#padding:54px 0px 0px 0px;color:#4B4A4A;font-weight:bold;">Welcome page details successfully updated.</div>
		<div style="clear:both;line-height:25px;"></div>
		<br /> <br />
		<div style="padding-left:200px;#padding-left:100px;"><input type="button" class="button simplemodal-close" value="Close" /></div>
	</div>
	<?php
	$google_analytics = variable_get('google_analytics_UA', '');
	?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
		_gaq.push(['_trackPageview', 'Welcome Page content edit']);

		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	</script>