<?php if (!is_vwr_user_role()) {
		$displaying = 'none';
		$tabdisplay = "block";
		$modal_height = '400px';
	} else {
		$displaying = 'block';
		$tabdisplay = "none";
		$modal_height = '350px';
	} ?>
	<style type="text/css">
		div.simplemodal-container {
			height: <?php echo $modal_height; ?> !important;
		}
	</style>

	<div id="change_password">

		<div id="suppiler_settings" style="display:block">
			<div class="reg_labl" id="region_selection" style="width:165px; line-height:16px;"><label>Email Preferences</label></div>
			<div style="clear:both"></div>
		</div>

		<div class="error status_msg" id="status_msg">&nbsp;</div>
		<div style="width: 335px;display:none; margin-top:0px;" id="region_status" class="success">Email Preferences Saved</div>
		<div class="error" id="myaccount_error" style="width:335px; margin-top:0px;display:none;"></div>
		<div class="poptxt1">

			<br />
			<div class="region_check" style="height:180px;display:block;">
				<div class="reg_labl" style="width:165px;line-height:16px;">
					<label style="margin-left:37px;width:165px;"><b>NA News:&nbsp;&nbsp;<span style="color:red;">*</span></b>
					</label>
				</div>
				<div style="width:125px; vertical-align:top; float:left;">
					<input type="radio" name="na_news" value="1">Yes
					<input type="radio" name="na_news" value="0">NO
				</div>
				<div style="clear:both"></div><br />

				<div class="reg_labl" style="line-height:16px;width:165px;">
					<label style="margin-left:36px;width:auto;"><b>NA Supply:&nbsp;&nbsp;<span style="color:red;">*</span></b></label>
				</div>
				<div style="width:125px; vertical-align:top; float:left;">
					<input type="radio" name="na_supply" value="1">Yes
					<input type="radio" name="na_supply" value="0">NO
				</div>
				<div style="clear:both"></div><br />


				<div class="reg_labl" style="line-height:16px;width:165px;">
					<label style="margin-left:36px;width:auto;"><b>EU News:&nbsp;&nbsp;<span style="color:red;">*</span></b></label>
				</div>
				<div style="width:125px; vertical-align:top; float:left;">
					<input type="radio" name="eu_news" value="1">Yes
					<input type="radio" name="eu_news" value="0">NO
				</div>
				<div style="clear:both"></div><br />

				<div class="setting-confirm-btn">
					<input type="button" onclick="emailpreferencessettings()" value="Save" class="button">
					<input type="button" onclick="" value="Cancel" class="button simplemodal-close"><span style="display:none;margin-left:5px" id="dashboard_loader"><a title="Close" class="modalCloseImg simplemodal-close"></a></span>
				</div>
			</div>



		</div>
	</div>
	<div id="changePasswordFinal" style="display:none">
		<div style="width:350px;padding-left:40px; #padding-left:0px; padding-top:54px;color:#4B4A4A;font-weight:bold;">Your password has been successfully changed.</div>
		<div style="clear:both;line-height:25px;"></div>
		<br /> <br />
		<div style="padding-left:180px;#padding-left:100px;"><input type="button" class="button simplemodal-close" value="Close" /></div>
	</div>
	<?php
	$google_analytics = variable_get('google_analytics_UA', '');
	?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
		_gaq.push(['_trackPageview', 'Change Password']);

		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	</script>