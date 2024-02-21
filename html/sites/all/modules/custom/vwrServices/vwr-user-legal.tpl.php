<?php
	$query = db_query("SELECT legal_text,legal_link FROM {legal_details}");
	$number_of_rows = $query->rowCount();
	if ($number_of_rows != '') {
		foreach ($query as $record) {
			$legal_text = $record->legal_text;
			$legal_link = $record->legal_link;
		}
	?>
		<input type="hidden" id="legal-action" value="update" />
	<?php } else { ?>
		<input type="hidden" id="legal-action" value="insert" />
	<?php } ?>
	<div id="legal_notice_span" style="height:120px;">
		<div class="error" id="legal_error" style="width:250px; margin-top:0px;display:none"></div>
		<div class="reg_labl"><span>*</span>
			<label>Text :</label>
		</div>
		<input type="text" id="legal_text" value="<?php echo $legal_text; ?>" style="margin-bottom:10px;" /><br>
		<div style="clear:both"></div>
		<div class="reg_labl"><span>*</span>
			<label>Link :</label>
		</div>
		<input type="text" id="legal_link" value="<?php echo $legal_link; ?>" style="margin-bottom:10px;" />
		<div class="popBut" style="float: left;margin-left: 140px;padding: 10px 10px 10px 18px;">
			<input type="button" class="button" value="Submit" onclick="legalvalidate();" />
			<input type="button" class="button simplemodal-close" value="Cancel" />
		</div>
	</div>
	<div class="popBut" id="popLegalFinal" style="display:none">
		<div style="padding-left:80px; #padding-left:0px; padding-top:54px; color:#4B4A4A;font-weight:bold">Legal Notice details successfully updated.</div>
		<div style="clear:both;line-height:25px;"></div>
		<br /> <br />
		<div style="padding-left:180px;#padding-left:100px;"><input type="button" class="button" value="Close" onclick="cancelForm();" /></div>
	</div>
	<?php
	$google_analytics = variable_get('google_analytics_UA', '');
	?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
		_gaq.push(['_trackPageview', 'Legal Notice Link edit']);

		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	</script>