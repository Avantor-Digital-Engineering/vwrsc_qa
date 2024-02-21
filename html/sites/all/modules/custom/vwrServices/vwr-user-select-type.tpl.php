	<div>
		<h3>Select user type</h3>
		<div class="poptxt">
			<input type="radio" name="regtn" id="supplier-regtn" value="supplier" Checked="Checked" /><label for="supplier-regtn" style="display:inline-block;line-height:20px;">Supplier</label><br /><br />
			<input type="radio" name="regtn" id="vwrinternal-regtn" value="vwrinternal" /><label for="vwrinternal-regtn" style="display:inline-block;line-height:20px;">VWR Internal</label><br /><br />
			<div class="popBut" style="width:300px;">
				<input type="button" class="button" value="Proceed" onclick="vwrregistration();" title="Proceed" alt="Proceed" />
				<input type="button" class="button simplemodal-close" value="Cancel" title="Cancel" alt="Cancel" />
			</div>
		</div>
	</div>
	<?php
	$google_analytics = variable_get('google_analytics_UA', '');
	?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $google_analytics; ?>']);
		_gaq.push(['_trackPageview', 'Registration select user type']);

		(function() {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();
	</script>