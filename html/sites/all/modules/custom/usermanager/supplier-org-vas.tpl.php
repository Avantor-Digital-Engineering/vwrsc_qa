<div class="table_container">
    <form name="users-overview" id="users-overview" action="" method="POST">
        <input type="hidden" name="selcted_users" id="selcted_users" value="" />
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="table_head table_row">
				<td>Supplier OrgID</td>
                <td>Vendor Number</td>
                <td>Vendor Desc</td>
                <td>Flag ID</td>
                <td>Flag Name</td>
            </tr>
            <tbody id="supplier_org_users">
                <?php
				foreach ($supplier_org_vas_details as $result_vas) {
                    $c = 0; ?>
                    <tr class="table_row">
						<td><?php echo htmlspecialchars($result_vas['supplier_org_id']); ?></td>
                        <td><?php echo htmlspecialchars($result_vas['vendor_no']); ?></td>
                        <td><?php echo htmlspecialchars($result_vas['vendor_desc']); ?></td>
                        <td><?php echo htmlspecialchars($result_vas['vendor_cd']); ?></td>
                        <td><?php echo htmlspecialchars($result_vas['vas_tier']); ?></td>
                    </tr>
                <?php $c++;
                } ?>
                <?php if ($c == "") { ?>
                    <tr class="table_row">
                        <td class="no_records" colspan="4">No Vas Tiers Found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>
</div>

    <?php $current_record_count = (($page_no + 1) * $number_per_page); ?>
    <?php echo ($current_record_count < $total_rec) ? $current_record_count : $total_rec; ?>
    <?php echo $total_rec; ?>
    <?php echo theme('pager'); ?>