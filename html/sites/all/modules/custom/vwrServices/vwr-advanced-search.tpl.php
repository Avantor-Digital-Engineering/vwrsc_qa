  <script language="javascript" type="text/javascript" src="<?php echo base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/js/datetimepicker.js"></script>
  <div class="advanced_search">
    <p class="result_head">Advanced Search</p><br /><br /><br />
    <div class="advanced_search_form">
      <div>
        <label style="display:inline-block;">Keyword:</label>&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="adv_keyword" id="adv_keyword" class="search_keyword" />
      </div><br /><br />
      <div>
        <label>Limit Results By:</label><br />
        <div class="limit_option">
          <select name="filter_option" id="filter_option" onchange="show_hide_datefiled(this.value);">
            <option selected="selected" value="">None</option>
            <option value="1">Upload Date</option>
            <option value="2">Valid From</option>
            <option value="3">Valid Till</option>
            <option value="4">Valid Between</option>
          </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        <div class="from_date_box"><input type="text" name="from_date" id="from_date" class="date_picker" readonly="readonly" />&nbsp; <a href="javascript:NewCal('from_date','ddmmyyyy')" class="date_space"><img src="<?php echo base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
          &nbsp;&nbsp;&nbsp;To&nbsp;&nbsp;</div>
        <div class="to_date_box"><input type="text" name="to_date" id="to_date" class="date_picker" readonly="readonly" />&nbsp;<a href="javascript:NewCal('to_date','ddmmyyyy')" class="date_space"><img src="<?php echo base_path() . drupal_get_path('module', 'vwr_dropbox'); ?>/images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a></div>
      </div>
      <p><br /><br /><input type="submit" class="search_button" value="Search" onclick="Advanced_DocumentSearch();" /></p>
    </div>
  </div>