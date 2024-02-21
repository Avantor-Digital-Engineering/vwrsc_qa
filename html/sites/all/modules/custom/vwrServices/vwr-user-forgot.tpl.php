	<div id="fotgot_password_span">
		<h3>Forgotten your password?</h3>
		<div class="poptxt" id="forget_password">
			<label>Enter email address :</label><input type="text" id="forget_email" />
			<span class="err_icons" id="forget_email_icon" style="display:none;float:right;"><img src="<?php echo base_path() . path_to_theme(); ?>/images/success_ico.png" width="32" height="32" alt="icon" /></span>
			<br />
		</div>
		<div class="forget_error" style="display:none"></div>
		<div class="popBut">
			<input type="button" class="button" value="Submit" onclick="forgetpassword();" />
			<input type="button" class="button simplemodal-close" value="Cancel" />
		</div>
	</div>
	<div style="display:none; color: #000000;padding:30px 0px 0px 50px" id="popFogotFinal">
		An Email has been sent to you with a link to reset password.<br><br>
		<div style='padding:5px 0px 0px 150px;float:left;margin-bottom:10px'>
			<input type='button' class='button simplemodal-close' value='OK'>
		</div>
	</div>

	<?php
	$google_analytics = variable_get('google_analytics_UA', '');
	?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
		_gaq.push(['_trackPageview', 'Forgot Password']);

		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	</script>