<div id="workflow_mail">
	<div id="wf_mail_cnt" style="line-height:6px;">
		<p><b>Type:</b> <?php print $maildata->type; ?></p>
		<p><b>Submission ID:</b> ID<?php print $maildata->submission_id; ?></p>
		<?php
			if ($maildata->submission_supplierorg != "VWR") { ?>				
				<p><b>Supplier:</b> <?php print $maildata->submission_supplierorg;?></p>
			<?php }	?>	
				<p><b>Name:</b> <?php print $maildata->submissionownername;?></p>
				<p><b>Email:</b> <?php print $maildata->submissionownermail;?></p>			
		
		<p><b>Message:</b> <?php print $maildata->comments; ?></p>
		<p>
		<?php 
			if(!empty($maildata->$infected_file_list)) {
				foreach($maildata->$infected_file_list as $key => $value) {
					echo "\n Infected File : " . $key . " Status : " . $value;
				}
			}
		?>
		</p><br />
	</div>
</div>
<!-- Disclaimer -->
<div style="font-size:12px;color:#4B4A4A;">
	<p>****************************************************************************************</p>
	<p>
		 For your convenience you may reply directly to this email and your comments will post to
	   Supplier Central and directly notify the team associated with this submission.
	</p>
	<p>
		 Please note, the system will not include any additional email addresses that you copy in your reply to this thread.
 		 If you need to attach files, please utilize the available link and submit your files through Supplier Central.
 	</p>	  
</div>