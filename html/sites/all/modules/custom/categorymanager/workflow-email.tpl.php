<?php
	global $base_url;

	$from = $submissions['supplier_name'];
	$email = $submissions['email'];
	$supplier = trim($submissions['supplier_org']);
	$vendor = trim($submissions['vendor_num']);
	$dropbox_name = $dropbox->title;
	$submission_id = $submissions['submission_id'];
	$title = $submissions['subject_line'];
	$message = strip_tags($submissions['user_message']);
	?>
	<div id="workflow_mail">
		<div id="wf_mail_cnt" style="line-height: 2px;">
			<div style="margin-bottom: 15px;"><b>Type:</b> New Submission</div>
			<div style="margin-bottom: 15px;"><b>From:</b> <?php print $from; ?></div>
			<div style="margin-bottom: 15px;"><b>Email:</b> <?php print $email; ?></div>
			<div style="margin-bottom: 15px;"><b>Supplier:</b> <?php print $supplier ? $supplier : 'N/A'; ?></div>
			<div style="margin-bottom: 15px;"><b>Vendor:</b> <?php print $vendor ? $vendor : 'N/A'; ?></div>
			<div style="margin-bottom: 15px;"><b>Dropbox:</b> <?php print $dropbox_name; ?></div>
			<div style="margin-bottom: 15px;"><b>Submission ID:</b> ID<?php print $submission_id; ?></div>
			<div style="margin-bottom: 15px;"><b>Title:</b> <?php print $title; ?></div>
			<div style="margin-bottom: 15px;"><b>Message:</b> <?php print $message; ?></div>
			<div style="margin-bottom: 15px;">
				<b>View comments thread / attach document:</b>
				<?php print l($base_url . '/vwr_dropbox/viewsubmission/' . base64_encode($submission_id), $base_url . '/vwr_dropbox/viewsubmission/' . base64_encode($submission_id)); ?>
			</div>
			<div style="margin-bottom: 15px;">
				<?php
				if (!empty($infected_file_list)) {
					foreach ($infected_file_list as $key => $value) {
						print "\n Infected File : " . $key . " Status : " . $value;
					}
				}
				?>
			</div>
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
	<br><br><br>