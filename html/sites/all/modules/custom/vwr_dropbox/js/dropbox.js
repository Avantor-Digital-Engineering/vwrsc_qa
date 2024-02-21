    var sanitizeHTML = function (str) {
        var temp = document.createElement('div');
        temp.textContent = str;
        return temp.innerHTML;
    };
    var queue = [];
    $(document).ready(function () {
        $('#start_date').datepicker({
            dateFormat: 'mm/dd/yy'
        });
        var start_d = $.trim($("#edit_start_date").val());
        $("#start_date").datepicker("option", "minDate", new Date());
        $('#start_date').val(start_d);        

        $('#end_date').datepicker({
            dateFormat: 'mm/dd/yy'
        });
        var end_d = $.trim($("#edit_end_date").val());
        $("#end_date").datepicker("option", "minDate", new Date());
        $('#end_date').val(end_d);
        
        var file_type_id = $.trim($("#file_type").val());
        if (file_type_id.toUpperCase() == 'PA') {
            changeTo(true);
        } else {
            changeTo(false);
        }

        callDeleteFileCategory();
        $('#drp_file_category').keyup(function (e) {
            $('#dropbox_error').html('').hide();
            if (Number(e.keyCode) == '13') {
                var file_cat = $.trim($(this).val());
                var file_cat_arr = file_cat.split('-');
                if (file_cat_arr.length > 2) {
                    return false;
                }
                if ($.trim(file_cat_arr[0]) != '' && $.trim(file_cat_arr[1]) != '') {
                    var drp_prefix = $.trim(file_cat_arr[1]).replace(" ", "").toUpperCase();
                    if (drp_prefix.length > $.trim(file_cat_arr[0]).length) {
                        $('#dropbox_error').html('Prefix should be shorter than prefix name').show();
                        return false;
                    }
                    file_cat = $.trim(file_cat_arr[0]) + ' - ' + drp_prefix;
                    var continue_filetype = true;
                    $("#drp-file-cat-holder .drp-file-cat-place .drp-file-cat").each(function (i) {
                        var result = $.trim($(this).html()).split(" - ", 2);
                        if (result.length > 0) {
                            if ($.trim(file_cat_arr[0]).toUpperCase() == $.trim(result[0]).toUpperCase()) {
                                $('#dropbox_error').html('Prefix name should be unique').show();
                                continue_filetype = false;
                                return false;
                            } else if (drp_prefix == $.trim(result[1])) {
                                $('#dropbox_error').html('Prefix should be unique').show();
                                continue_filetype = false;
                                return false;
                            }
                        }
                    });
                    if (continue_filetype) {
                        var themepath = $.trim($("#vwr_theme_path").val());

                        var container = document.createElement("div");
                        container.setAttribute("class", "drp-file-cat-place");
                        var span1 = document.createElement("span");
                        span1.setAttribute("class", "drp-file-cat");
                        span1.innerText = file_cat;
                        container.appendChild(span1);

                        var span2 = document.createElement("span");
                        span2.setAttribute("class", "drp-file-cat-del");
                        span1.after(span2);

                        var img = document.createElement('img');
                        img.src = themepath + 'images/ico_8.png';
                        img.width = 18;
                        img.height = 19;
                        img.alt = 'delete';

                        var a = document.createElement('a');
                        a.setAttribute('href', 'javascript:void(0);');
                        span2.appendChild(a);
                        a.appendChild(img);

                        $("#drp-file-cat-holder").append(container);
                        callDeleteFileCategory();
                        $(this).val('');
                    }
                } else {
                    $('#dropbox_error').html('Please provide Prefix name - Prefix').show();
                }
            }
            return false;
        });
    });

    function callDeleteFileCategory() {
        $('.drp-file-cat-del').click(function (e) {
            var ele_obj = this;
            $("#dialog").html('Are You sure you want to remove this File Category?');
            $('#dialog').dialog({
                modal: true,
                autoOpen: true,
                minHeight: 35,
                width: 350,
                buttons: {
                    "Confirm": function () {
                        $(ele_obj).parent('div').empty().remove();
                        $(this).dialog("close");
                    },
                    "Cancel": function () {
                        $(this).dialog("close");
                    }
                }
            });
        });
    }

    /*********** Search by date *********/
    function FilterBySorting_dropbox(keyword) {
        document.dropboxlist.submit();
    }

    function FilterBySorting_category(keyword) {
        document.dropboxlist.submit();
    }

    function FilterBySorting_category1(keyword) {
        if (keyword != 0) {
            $('ul.search_cate li').each(function (index) {
                $(this).hide();
            });
            $('ul.search_cate li span.cate_list_' + keyword).each(function (index) {
                $(this).parent().parent().show();
            });
        } else {
            $('ul.search_cate li').each(function (index) {
                $(this).show();
            });
        }
    }

    function FilterBySorting_dropbox1(keyword) {
        var mylist = $('ul.search_cate');
        var listitems = mylist.children('li').get();
        listitems.sort(function (a, b) {
            var flag_start_1 = $(a).attr('id').split("_");
            var flag_start_2 = $(b).attr('id').split("_");
            if (keyword == 1) {
                flag_start_final_1 = flag_start_1[0];
                flag_start_final_2 = flag_start_2[0];
            } else if (keyword == 2) {
                flag_start_final_1 = flag_start_1[1];
                flag_start_final_2 = flag_start_2[1];
            } else {
                flag_start_final_1 = flag_start_1[2];
                flag_start_final_2 = flag_start_2[2];
            }
            var compA = flag_start_final_1;
            var compB = flag_start_final_2;
            return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
        });
        $.each(listitems, function (idx, itm) {
            mylist.append(itm);
        });
    }

    /*********** Search by date *********/


    function downloadUploadfiles(id, level) {
        var action = $.trim($("#current_url").val());
        document.location.href = baseurl + 'vwr_dropbox/filedownloads/' + id;
    }


    /************** Dropbox instruction edit *******/

    function view_dropbox_edit(ins) {

        if (ins == 1) {

            $("#dropbox_inst").val($("#inst_text").html());
            document.getElementById('instruction').style.display = 'none';
            document.getElementById('edit_icon').style.display = 'none';
            document.getElementById('dropinst_whole_span').style.display = 'block';

        } else {
            $("#dropbox_name").val($("#reset_drop").html());
            document.getElementById('reset_drop').style.display = 'none';
            document.getElementById('id_img').style.display = 'none';
            document.getElementById('dropbox_whole_span').style.display = 'block';
        }

    }

    function dropbox_text_save(ins) {
        var ajax_variable = '';
        if (ins == 0) {
            var text_val = $('#dropbox_name').val();
            ajax_variable = 'drop_box_text=' + $('#dropbox_name').val() + "&ins=0";
        } else {
            ajax_variable = 'drop_box_instruction=' + $('#dropbox_inst').val() + "&ins=1";
        }
        if ($('#dropbox_name').val().length > 20) {
            alert("Dropbox Name cannot be more than 20 Characters");
            return false;
        }
        if ($('#dropbox_inst').val().length > 210) {
            alert("Dropbox Instruction cannot be more than 200 Characters");
            return false;
        }
        if ((ins == 0 && $('#dropbox_name').val()) || (ins == 1 && $('#dropbox_inst').val())) {
            $.ajax({
                type: "POST",
                url: baseurl + 'vwr_dropbox/dropbox_text_save',
                data: ajax_variable,
                success: function (res) {
                    var parsedJSON = JSON.parse($.trim(res));
                    if (ins == 0) {
                        document.getElementById('dropbox_whole_span').style.display = 'none';
                        document.getElementById('reset_drop').style.display = 'block';
                        $('#reset_drop').text(parsedJSON.msg);
                        document.getElementById('id_img').style.display = 'block';
                    } else {
                        document.getElementById('dropinst_whole_span').style.display = 'none';
                        document.getElementById('instruction').style.display = 'block';
                        let inst_element = $('#edit_inst').html();
                        let status_span = $('<span />');
                        let inner_span = $('<span />');
                        inner_span.attr('id', 'edit_inst');
                        inner_span.html($('<div/>', { html: sanitizeHTML(inst_element) }).text());
                        status_span.attr('id', 'edit_icon');
                        status_span.html(inner_span);
                        status_span.prepend($('<div/>', { html: sanitizeHTML(parsedJSON.msg) }).text());
                        $('#instruction').html(status_span);
                        $("#inst_text").text(parsedJSON.msg);
                        $("#edit_icon").css("display", "");
                    }

                }

            });
        } else {
            if (ins == 0) {
                document.getElementById('dropbox_whole_span').style.display = 'none';
                document.getElementById('reset_drop').style.display = 'block';
                document.getElementById('id_img').style.display = 'block';
            } else {
                alert("Please enter instruction");
                return false;
            }

        }
    }




    /* Select Vas/Organization Users for Dropbox */
    function Dropbox_Modalbox(baseurl, modalbox_type, selected_values) {

        if (modalbox_type == "add_users") {
            /* For Vas Tier Supplier Org Mapping Popup only */
            $('#basic-modal-category').modal();
            $('#simplemodal-container').addClass('dropbox-container');
            $('#basic-modal-category').modal();
            $('#cat_topic_container').html('<div align="center" style="text-align:center; margin:10px;"><img src="' + baseurl + 'sites/all/themes/vwr/images/loading.gif" width="50" height="50" alt="Loading..." /></div>');
        }
        $.ajax({
            type: "POST",
            url: baseurl + 'vwr_dropbox/dropbox_modalbox',
            data: 'modalbox_type=' + modalbox_type + '&selected_values=' + selected_values,
            dataType: "html",
            success: function (res) {
                if (res != '') {
                    $('#cat_topic_container').html(
                        $('<div/>', {
                            html: sanitizeHTML(res)
                        }).text()
                    );
                    if (modalbox_type != "add_users") {
                        $('#basic-modal-category').modal();
                        $('#simplemodal-container').addClass('dropbox-container');
                        $('#basic-modal-category').modal();
                    }
                    if (modalbox_type == "add_users") {
                        sortSelect(document.add_users.supplier_org_list2);
                    }
                    if (modalbox_type == "add_pages") {
                        attachEvents();
                    }
                }
            }
        });
    }


    function Dropbox_Modalbox_view(modalbox_type, baseurl, dboxid) {

        $.ajax({
            type: "POST",
            url: baseurl + 'category/fileupload',
            data: 'modalbox_type=' + modalbox_type + "&dboxid=" + dboxid,

            success: function (res) {
                if (res != '') {
                    $('#cat_topic_container').html(
                        $('<div/>', {
                            html: sanitizeHTML(res)
                        }).text()
                    );
                    $('#basic-modal-category').modal();
                    $('#simplemodal-container').addClass('add-cat-container-dropbox');
                    addTinyEditord();
                }
            }

        });
    }

    function Delete_Dropbox(baseurl, delete_dropbox) {
        $("#dialog").html('Are you sure you want to delete this DropBox?');
        $('#dialog').dialog({
            modal: true,
            autoOpen: true,
            minHeight: 35,
            width: 350,
            buttons: {
                "Ok": function () {
                    $.ajax({
                        type: "POST",
                        url: baseurl + 'vwr_dropbox/viewdropbox',
                        data: 'delete_dropbox=' + delete_dropbox,
                        success: function (data) {
                            window.location = baseurl + "vwr_dropbox/viewdropbox/delete_success";
                        }
                    });
                    $(this).dialog("close");
                },
                "Cancel": function () {
                    $(this).dialog("close");
                }
            }
        });
    }



    function Delete_Dropbox_Files(baseurl, delete_dropbox, dboxid) {
        $("#dialog").html('Are you sure you want to delete this Submission?');
        $('#dialog').dialog({
            modal: true,
            autoOpen: true,
            minHeight: 35,
            width: 380,
            resizable: false,
            buttons: {
                "Ok": function () {
                    $.ajax({
                        type: "POST",
                        url: baseurl + 'vwr_dropbox/viewdropboxfiles/' + delete_dropbox,
                        data: 'delete_dropbox=' + delete_dropbox,
                        success: function (data) {
                            if (data == 'success') {
                                window.location = baseurl + "ticketmanager/ticketsoverview";
                            }
                        }
                    });
                    $(this).dialog("close");
                },
                "Cancel": function () {
                    $(this).dialog("close");
                }
            }
        });

    }

    //Sort Dropbox Files View
    function Sort_Files_View(base_url, id, sort_value, sort_type, query_str) {
        if (sort_type == "upload_date") {
            document.location.href = baseurl + '/vwr_dropbox/viewdropboxfiles/' + id + '/?sort_date=' + sort_value + query_str;
        } else if (sort_type == "supplier_org") {
            document.location.href = baseurl + '/vwr_dropbox/viewdropboxfiles/' + id + '/?sort_supplier=' + sort_value + query_str;
        }
    }


    function downloadUploadDocuments_dropbox(id) {
        var action = $.trim($("#current_url").val());
        document.location.href = baseurl + 'category/filedownload/' + fid + '?redirect=' + action + id;
    }

    /* Send Vas/supplier org map to dropbox form */
    function Save_AddUsers(vas_selected_values, supplier_selected_values) {
        var vas_values;
        var vas_names = "";
        var supplier_values;
        var supplier_names = "";
        if (!hasOptions(vas_selected_values) && !hasOptions(supplier_selected_values)) {
            return;
        }
        for (var i = 0; i < vas_selected_values.options.length; i++) {
            var split_vas_value = vas_selected_values.options[i].value.split("_");
            if (vas_values != undefined) {
                vas_values = vas_values + "," + split_vas_value[0];
                vas_names = vas_names + ", " + vas_selected_values.options[i].text;
            } else {
                vas_values = split_vas_value[0];
                vas_names = vas_selected_values.options[i].text;
            }
        }
        for (var j = 0; j < supplier_selected_values.options.length; j++) {
            if (supplier_values != undefined) {
                supplier_values = supplier_values + "," + supplier_selected_values.options[j].value;
                supplier_names = supplier_names + ", " + supplier_selected_values.options[j].text;
            } else {
                supplier_values = supplier_selected_values.options[j].value;
                supplier_names = supplier_selected_values.options[j].text;
            }
        }

        if (vas_values == undefined) {
            vas_values = "";
        }
        document.parentForm.dropbox_vas_id.value = vas_values;
        if (supplier_values == undefined) {
            supplier_values = "";
        }
        document.parentForm.dropbox_supplier_id.value = supplier_values;

        document.parentForm.supplierorg.value = supplier_names;
        $(".simplemodal-close").click();
    }

    /* Send Dropbox Owners to dropbox form */
    function Save_Add_NAOwners(users_selected_values) {
        var users_values;
        var users_names = "";
        if (!hasOptions(users_selected_values)) {
            return;
        }
        for (var j = 0; j < users_selected_values.options.length; j++) {
            if (users_values != undefined) {
                users_values = users_values + "," + users_selected_values.options[j].value;
                users_names = users_names + ", " + users_selected_values.options[j].text;
            } else {
                users_values = users_selected_values.options[j].value;
                users_names = users_selected_values.options[j].text;
            }
        }
        if (users_values == undefined) {
            users_values = "";
        }
        document.parentForm.owners_id_NA.value = users_values;
        document.parentForm.owners_list_NA.value = users_names;
        $(".simplemodal-close").click();
    }

    function Save_Add_EUOwners(users_selected_values) {
        var users_values;
        var users_names = "";
        if (!hasOptions(users_selected_values)) {
            return;
        }
        for (var j = 0; j < users_selected_values.options.length; j++) {
            if (users_values != undefined) {
                users_values = users_values + "," + users_selected_values.options[j].value;
                users_names = users_names + ", " + users_selected_values.options[j].text;
            } else {
                users_values = users_selected_values.options[j].value;
                users_names = users_selected_values.options[j].text;
            }
        }
        if (users_values == undefined) {
            users_values = "";
        }
        document.parentForm.owners_id_EU.value = users_values;
        document.parentForm.owners_list_EU.value = users_names;
        $(".simplemodal-close").click();
    }

    function show_hide_link() {
        if ($('#check_vas_supplier').attr('checked')) {
            $(".vas_supplier_link").css("display", "none");
            $(".vas_supplier_text").css("display", "block");
            $("#supplierorg").attr("disabled", "disabled");
        } else {
            $(".vas_supplier_text").css("display", "none");
            $(".vas_supplier_link").css("display", "block");
            $("#supplierorg").removeAttr("disabled");
        }

    }

    function tinyMCE_Editor(themetype, formElement) {
        if (themetype && window.tinyMCE && formElement) {
            tinyMCE.init({ // General options, theme: advanced, simple                
                mode: "exact",
                elements: formElement,
                theme: themetype,
                invalid_elements: 'script',
                plugins: "autolink,lists,style",
                theme_advanced_buttons1: "newdocument,|,bold,italic,underline,|,formatselect,fontselect,fontsizeselect",
                theme_advanced_buttons2: "bullist,numlist,|,link,unlink,anchor,|,forecolor,backcolor,|,undo,redo",
                theme_advanced_buttons3: null,
                theme_advanced_toolbar_location: "top",
                theme_advanced_toolbar_align: "left",
                theme_advanced_statusbar_location: null,
                theme_advanced_resizing: true
            });
        }
    }

    function Validate_Dropbox() {
        /* Dropbox validation starts */
        var dropbox_name = $.trim($('#name').val());
        var dropbox_desc = $.trim($('#desc').val());
        var dropbox_page = $.trim($('#page').val());

        var dropbox_supplierorg = $.trim($('#supplierorg').val());
        var pagesvalue = $("#map_values").val();
        var euregion = pagesvalue.indexOf("regionid_2");
        var naregion = pagesvalue.indexOf("regionid_1");
        if (euregion != -1) {
            var EUdropbox_owners_list = $.trim($('#owners_list_EU').val());
            var EUdropbox_owners_email = $.trim($('#owners_email_EU').val());
        }
        if (naregion != -1) {
            var NAdropbox_owners_list = $.trim($('#owners_list_NA').val());
            var NAdropbox_owners_email = $.trim($('#owners_email_NA').val());
        }

        var dropbox_wf_email = $.trim($('#wf_mail').val());
        var dropbox_start_date = $.trim($('#start_date').val());
        var dropbox_end_date = $.trim($('#end_date').val());
        var dropbox_edit_start_date = $.trim($('#edit_start_date').val());
        var file_category = '';
        $("#drp-file-cat-holder .drp-file-cat-place .drp-file-cat").each(function (i) {
            file_category += $.trim($(this).html()) + ",";
        });
        var emailmatch = /^[a-zA-Z0-9-_;,.@ ]+$/;
        errorArray = [];

        if (dropbox_name == "") {
            errorArray.push("Title cannot be empty");
        } else if (dropbox_name.length > 100) {
            errorArray.push("Title should not exceed 100 characters");
        }
        if (dropbox_desc == "") {
            errorArray.push("Instruction cannot be empty");
        } else if (dropbox_desc.length > 250) {
            errorArray.push("Instruction should not exceed 250 characters");
        }
        if (dropbox_page == "") {
            errorArray.push("Page Association cannot be empty");
        }
        if (dropbox_supplierorg == "" && !$('#check_vas_supplier').attr('checked')) {
            errorArray.push("Flag/Supplier Org cannot be empty");
        }

        if (naregion != -1) {

            if (NAdropbox_owners_list == "" && NAdropbox_owners_email == "" && !$("#workflow_tool").attr("checked")) {
                errorArray.push("Dropbox owners for NA cannot be empty");
            }
            if (NAdropbox_owners_email != "") {
                var split_email = NAdropbox_owners_email.split(";");
                if (split_email[1] != undefined) {
                    for (var i = 0; i < split_email.length; i++) {
                        if (split_email[i] != "" && !validateEmail(split_email[i])) {
                            var email_error = true;
                        }
                    }
                    if (email_error == true) {
                        errorArray.push("Please Enter Valid Email Address for Dropbox Owners for NA");
                    }
                } else if (!validateEmail(NAdropbox_owners_email)) {
                    errorArray.push("Please Enter Valid Email Address for Dropbox Owners for NA");
                }
            }


        }

        if (euregion != -1) {
            if (EUdropbox_owners_list == "" && EUdropbox_owners_email == "" && !$("#workflow_tool").attr("checked")) {
                errorArray.push("Dropbox owners for EU cannot be empty");
            }
            if (EUdropbox_owners_email != "") {
                var split_email = EUdropbox_owners_email.split(";");
                if (split_email[1] != undefined) {
                    for (var i = 0; i < split_email.length; i++) {
                        if (split_email[i] != "" && !validateEmail(split_email[i])) {
                            var email_error = true;
                        }
                    }
                    if (email_error == true) {
                        errorArray.push("Please Enter Valid Email Address for Dropbox Owners for EU");
                    }
                } else if (!validateEmail(EUdropbox_owners_email)) {
                    errorArray.push("Please Enter Valid Email Address for Dropbox Owners for EU");
                }
            }
        }

        var statusVal = $("#submissions_status").val();
        var status_email = $.trim($("#submission_status_email").val());
        if (statusVal && !validateEmail(status_email)) {
            errorArray.push("Please Enter Valid Email Address for Status change email notification");
        }

        if (dropbox_start_date == "") {
            errorArray.push("Start Date cannot be empty");
        } else if (!isValidDate(dropbox_start_date)) {
            errorArray.push("Start Date Should be mm/dd/yyyy Format<br/>");
        } else if (!checkCurrentDate(dropbox_start_date) && dropbox_edit_start_date == "") {
            errorArray.push("Start Date can not be less than Current date<br/>");
        } else if (dropbox_edit_start_date != dropbox_start_date && !checkCurrentDate(dropbox_start_date)) {
            errorArray.push("Start Date can not be less than Current date<br/>");
        }

        if (dropbox_end_date == "") {
            errorArray.push("End Date cannot be empty");
        } else if (!isValidDate(dropbox_end_date)) {
            errorArray.push("End Date Should be mm/dd/yyyy Format<br/>");
        } else if (!checkCurrentDate(dropbox_end_date)) {
            errorArray.push("End Date can not be less than Current date<br/>");
        } else if (Date.parse(new Date(dropbox_end_date)) < Date.parse(new Date(dropbox_start_date))) {
            errorArray.push("End Date cannot be Less than Start Date");
        }

        if (dropbox_wf_email != "" && $("#workflow_tool").attr("checked")) {
            var split_mail = dropbox_wf_email.split(",");
            if (split_mail[1] != undefined) {
                for (var i = 0; i < split_mail.length; i++) {
                    if (split_mail[i] != "" && !validateEmail(split_mail[i])) {
                        var email_error = true;
                    }
                }
                if (email_error == true) {
                    errorArray.push("Please Enter Valid Email Address for Workflow Tool");
                }
            } else if (!validateEmail(dropbox_wf_email)) {
                errorArray.push("Please Enter Valid Email Address for Workflow Tool");
            }
        }

        if (file_category == "") {
            errorArray.push("Please enter file categories");
        }
        if ($("#workflow_tool").attr('checked')) {
            if (dropbox_wf_email == "") {
                errorArray.push("Workflow email cannot be empty");
            }
        }

        var internalvalues = '';
        var array_len = errorArray.length;
        var showError = 0;

        if (array_len > 0) {
            internalvalues = "Please enter the required fields highlighted below:";
            internalvalues += '<li>&nbsp;</li>';
            for (var i = 0; i < array_len; i++) {
                if (errorArray[i]) {
                    internalvalues += '<li>' + errorArray[i] + '</li>';
                    showError = 1;
                }
            }
            if (showError == 1)
                $('#dropbox_error').html('<ul>' + internalvalues + '</ul>').show();
            else
                $('#dropbox_error').css('display', 'none');
        } else {
            $('#dropbox_error').css('display', 'none');
        }

        if (showError == 1) {
            return false;
        } else {
            return true;
        }
    }

    function show_emailbox() {
        if ($("#workflow_tool").attr('checked')) {
            $("#wf_email").css('display', 'block');
            $("div.dbox_owners span").html("&nbsp;&nbsp;");
        } else {
            $("#wf_email").css('display', 'none');
            $("div.dbox_owners span").html('*');
        }
    }


    /* Move List box Option from Left-Right OR Right-Left Box Code - Start*/
    // -------------------------------------------------------------------
    // moveSelectedOptions(select_object,select_object[,autosort(true/false)[,regex]])
    //  This function moves options between select boxes. Works best with
    //  multi-select boxes to create the common Windows control effect.
    //  Passes all selected values from the first object to the second
    //  object and re-sorts each box.
    //  If a third argument of 'false' is passed, then the lists are not
    //  sorted after the move.
    //  If a fourth string argument is passed, this will function as a
    //  Regular Expression to match against the TEXT or the options. If 
    //  the text of an option matches the pattern, it will NOT be moved.
    //  It will be treated as an unmoveable option.
    //  You can also put this into the <SELECT> object as follows:
    //    onDblClick="moveSelectedOptions(this,this.form.target)
    //  This way, when the user double-clicks on a value in one box, it
    //  will be transferred to the other (in browsers that support the 
    //  onDblClick() event handler).
    // -------------------------------------------------------------------
    function moveSelectedOptions(from, to) {
        // Unselect matching options, if required
        if (arguments.length > 3) {
            var regex = arguments[3];
            if (regex != "") {
                unSelectMatchingOptions(from, regex);
            }
        }
        // Move them over
        if (!hasOptions(from)) {
            return;
        }
        for (var i = 0; i < from.options.length; i++) {
            var o = from.options[i];
            if (o.selected) {
                if (!hasOptions(to)) {
                    var index = 0;
                } else {
                    var index = to.options.length;
                }
                to.options[index] = new Option(o.text, o.value, false, false);
            }
        }
        // Delete them from original
        for (var i = (from.options.length - 1); i >= 0; i--) {
            var o = from.options[i];
            if (o.selected) {
                from.options[i] = null;
            }
        }
        if ((arguments.length < 3) || (arguments[2] == true)) {
            sortSelect(from);
            sortSelect(to);
        }
        from.selectedIndex = -1;
        to.selectedIndex = -1;
    }

    function moveSelectedOptions_Original(from, to) {
        // Unselect matching options, if required
        if (arguments.length > 3) {
            var regex = arguments[3];
            if (regex != "") {
                unSelectMatchingOptions(from, regex);
            }
        }
        // Move them over
        var get_supplier_id;
        if (!hasOptions(from)) {
            return;
        }
        for (var i = 0; i < from.options.length; i++) {
            var o = from.options[i];
            if (o.selected) {
                if (!hasOptions(to)) {
                    var index = 0;
                } else {
                    var index = to.options.length;
                }
                to.options[index] = new Option(o.text, o.value, false, false);
            }
        }
        // Delete them from original
        for (var i = (from.options.length - 1); i >= 0; i--) {
            var o = from.options[i];
            if (o.selected) {
                from.options[i] = null;
            }
        }
        if ((arguments.length < 3) || (arguments[2] == true)) {
            sortSelect(from);
            sortSelect(to);
        }
        from.selectedIndex = -1;
        to.selectedIndex = -1;
    }

    
    function Move_Options_Values(from, to) {
        if (from == 'vas_list1') {
            $('#vas_list1 option').appendTo('#vas_list2');
            $('#supplier_org_list1 option').appendTo('#supplier_org_list2');            
        }
        if (from == 'vas_list2') {
            $('#vas_list2 option').appendTo('#vas_list1');
            $('#supplier_org_list2 option').appendTo('#supplier_org_list1');            
        }
        if (from == 'supplier_org_list1') {
            $('#supplier_org_list1 option').appendTo('#supplier_org_list2');
        }
        if (from == 'supplier_org_list2') {
            $('#supplier_org_list2 option').appendTo('#supplier_org_list1');
            $('#vas_list2 option').appendTo('#vas_list1');            
        }
    }

    function moveSelectedOptions_Related(from, to, move_type, baseurl) {
        // Unselect matching options, if required
        // Move them over
        var gbl_moved_values = new Array();
        var gbl_left_supplier_org_values = '';
        var moved_values = new Array();
        if (!hasOptions(from)) {
            return;
        }
        for (var i = 0; i < from.options.length; i++) {
            var o = from.options[i];
            if (o.selected) {
                if (!hasOptions(to)) {
                    var index = 0;
                } else {
                    var index = to.options.length;
                }
                to.options[index] = new Option(o.text, o.value, false, false);
                moved_values[i] = o.value;
            }
        }

        $('#vas_list1 :selected').each(function (i, selected) {
            gbl_moved_values[i] = $(selected).val();
        });

        $('#vas_list2 :selected').each(function (i, selected) {
            gbl_moved_values[i] = $(selected).val();
        });

        $("#supplier_org_list1 option").each(function () {
            gbl_left_supplier_org_values = $(this).val() + '_' + gbl_left_supplier_org_values;
        });

        // Delete them from original
        for (var i = (from.options.length - 1); i >= 0; i--) {
            var o = from.options[i];
            if (o.selected) {
                from.options[i] = null;
            }
        }
        
        from.selectedIndex = -1;
        to.selectedIndex = -1;

        if (move_type == "move_vas_auto_left") {
            //#### Vas Tier Left Move By Automattically based on Supplier Org - Start ####/
            /* 	Move related Vas Tier Left side(unselected) based on Supplier Org moved from right(Selected) to Left(Unselected)
                Example: If all 10 the supplier org(out of 10) moved to left side(unselected) the related Vas Tier need to be Left side (Unselected)
                Or otherwise related vas tier should not moved to left side	*/
            if ($('#supplier_org_list2 option').length == 0) {
                setTimeout("$('#vas_list2 option').appendTo('#vas_list1')", 10);
            } else {
                for (var s = 0; s < moved_values.length; s++) {
                    if (moved_values[s] != undefined) {
                        var get_vas_list = document.add_users.vas_list2;
                        for (var v = 0; v < get_vas_list.length; v++) {
                            var check_supplier_id = get_vas_list[v].value.split("_");
                            if (check_supplier_id[1] != "") {
                                for (var su = 1; su < check_supplier_id.length; su++) {
                                    if (check_supplier_id[su] != "" && check_supplier_id[su] == moved_values[s] && check_unselected_value(check_supplier_id) != true) {
                                        //$('#vas_list2 option[value="'+get_vas_list[v].value+'"]').attr("selected", "selected");
                                        $('#vas_list2 option[value=' + sanitizeHTML(get_vas_list[v].value) + ']').appendTo('#vas_list1');
                                    }
                                }
                            }
                        }
                    }
                }
            }
            //moveSelectedOptions_Auto(document.add_users.vas_list2, document.add_users.vas_list1);
            sortSelect(document.add_users.supplier_org_list1); // Sort Selected supplier org on left side.
            sortSelect(document.add_users.vas_list1); // Sort Vas List on left side.
            //#### Vas Tier Left Move By Automattically based on Supplier Org - End ####/
        } else if (move_type == "move_supplier_auto_left") {
            /* Move related supplier orgs to left side based on Vas Tier Moved from Right to Left - Start */
            if ($('#vas_list2 option').length == 0) {
                 //newflow
                Reload_Supplier_Options_Ajax_new(baseurl, gbl_moved_values, gbl_left_supplier_org_values, 'leftflow');
            } else if (moved_values.length > 0) {
                //Reload_Supplier_Options_Ajax(baseurl,'');
                Reload_Supplier_Options_Ajax_new(baseurl, gbl_moved_values, gbl_left_supplier_org_values, 'leftflow');
                sortSelect(document.add_users.vas_list1); // Sort Vas List on left side.
                
            }
            sortSelect(document.add_users.supplier_org_list1); // Sort supplier org on left side.		
            /* Move related supplier orgs to left side based on Vas Tier Moved from Right to Left - End */
        } else if (move_type == "move_supplier_auto_right") {
            /* Move related supplier org to right side(selected side) based on Vas Tier ID - Start */
            if ($('#vas_list1 option').length == 0) {
                //newflow1
                Reload_Supplier_Options_Ajax_new(baseurl, gbl_moved_values, gbl_left_supplier_org_values, 'rightflow');
            } else if ($('#vas_list2 option').length > 0) {
                var selected_supplier_values = "";
                $("#supplier_org_list2 option").each(function () { //Send Selected Supplier Option to right side						 
                    selected_supplier_values = $(this).val() + '_' + selected_supplier_values;
                });
                //alert(selected_supplier_values);
                //Reload_Supplier_Options_Ajax(baseurl,selected_supplier_values);
                Reload_Supplier_Options_Ajax_new(baseurl, gbl_moved_values, gbl_left_supplier_org_values, 'rightflow');
                
            }
            
            sortSelect(document.add_users.supplier_org_list2); // Sort Selected supplier org on right side.		

            /* Move related supplier org to right side(selected side) based on Vas Tier ID - End */
        }

    }

    function Reload_Supplier_Options_Ajax_new(baseurl, selected_supplier_values, gbl_left_supplier_org_values, flow) {
        var supplier_org_box2 = '';
        $("#supplier_org_list2 option").each(function () {
            supplier_org_box2 = $(this).val() + '_' + supplier_org_box2;
        });

        var sorg_right_unselect = '';
        if (flow == 'leftflow') {
            $("#vas_list2 option").each(function () {
                sorg_right_unselect = $(this).val() + '_' + sorg_right_unselect;
            });
        }
        $('#temp_val').html($('<div/>', { html: sanitizeHTML($('.select_supplier .move_buttons').html()) }).text());
        $('#supplier_org_list1').attr('disabled', 'disabled');
        $('#supplier_org_list2').attr('disabled', 'disabled');
        $('.select_supplier .move_buttons').html('<br><br><br><br><img src="' + baseurl + 'sites/all/themes/vwr/images/ajax-loader.gif">');

        $.ajax({
            type: "POST",
            url: baseurl + 'vwr_dropbox/dropbox_addusers_reload',
            data: 'flow=' + flow + '&supplier_values=' + selected_supplier_values + '&supplier_org_box2=' + supplier_org_box2 + '&gbl_left_supplier_org_values=' + gbl_left_supplier_org_values + '&sorg_right_unselect=' + sorg_right_unselect,
            success: function (res) {
                if (res != '') {
                    var split_result = res.split("_right_");
                    $('.select_supplier .left_list').html(
                        $('<div/>', {
                            html: sanitizeHTML(split_result[0])
                        }).text()
                    );
                    $('.select_supplier .right_list').html(
                        $('<div/>', {
                            html: sanitizeHTML(split_result[1])
                        }).text()
                    );
                    $('#supplier_org_list1').attr('enabled', 'enabled');
                    $('#supplier_org_list2').attr('enabled', 'enabled');
                    $('.select_supplier .move_buttons').html($('<div/>', { html: sanitizeHTML($('#temp_val').html()) }).text());
                }
            }
        });
    }

    function check_unselected_value(supplier_id) {
        var selected_supplier = document.add_users.supplier_org_list2;
        for (var a = 0; a < selected_supplier.length; a++) {
            if (jQuery.inArray(selected_supplier[a].value, supplier_id) != -1) {
                return true;
            }
        }
    }

    function moveSelectedOptions_Auto(from, to) {
        // Unselect matching options, if required
        if (arguments.length > 3) {
            var regex = arguments[3];
            if (regex != "") {
                unSelectMatchingOptions(from, regex);
            }
        }

        // Move them over
        if (!hasOptions(from)) {
            return;
        }
        for (var i = 0; i < from.options.length; i++) {
            var o = from.options[i];
            if (o.selected) {
                if (!hasOptions(to)) {
                    var index = 0;
                } else {
                    var index = to.options.length;
                }
                to.options[index] = new Option(o.text, o.value, false, false);
            }
        }
        // Delete them from original
        for (var i = (from.options.length - 1); i >= 0; i--) {
            var o = from.options[i];
            if (o.selected) {
                from.options[i] = null;
            }
        }
        
        from.selectedIndex = -1;
        to.selectedIndex = -1;
    }

    // -------------------------------------------------------------------
    // moveAllOptions(select_object,select_object[,autosort(true/false)[,regex]])
    //  Move all options from one select box to another.
    // -------------------------------------------------------------------
    function moveAllOptions(from, to) {
        selectAllOptions(from);
        if (arguments.length == 2) {
            moveSelectedOptions(from, to);
        } else if (arguments.length == 3) {
            moveSelectedOptions(from, to, arguments[2]);
        } else if (arguments.length == 4) {
            moveSelectedOptions(from, to, arguments[2], arguments[3]);
        }
    }
    // -------------------------------------------------------------------
    // selectAllOptions(select_object)
    //  This function takes a select box and selects all options (in a 
    //  multiple select object). This is used when passing values between
    //  two select boxes. Select all options in the right box before 
    //  submitting the form so the values will be sent to the server.
    // -------------------------------------------------------------------
    function selectAllOptions(obj) {
        if (!hasOptions(obj)) {
            return;
        }
        for (var i = 0; i < obj.options.length; i++) {
            obj.options[i].selected = true;
        }
    }
    // -------------------------------------------------------------------
    // hasOptions(obj)
    //  Utility function to determine if a select object has an options array
    // -------------------------------------------------------------------
    function hasOptions(obj) {
        if (obj != null && obj.options != null) {
            return true;
        }
        return false;
    }
    // -------------------------------------------------------------------
    // unSelectMatchingOptions(select_object,regex)
    //  This function Unselects all options that match the regular expression
    //  passed in. 
    // -------------------------------------------------------------------
    function unSelectMatchingOptions(obj, regex) {
        selectUnselectMatchingOptions(obj, regex, "unselect", false);
    }
    // -------------------------------------------------------------------
    // selectUnselectMatchingOptions(select_object,regex,select/unselect,true/false)
    //  This is a general function used by the select functions below, to
    //  avoid code duplication
    // -------------------------------------------------------------------
    function selectUnselectMatchingOptions(obj, regex, which, only) {
        if (window.RegExp) {
            if (which == "select") {
                var selected1 = true;
                var selected2 = false;
            } else if (which == "unselect") {
                var selected1 = false;
                var selected2 = true;
            } else {
                return;
            }
            var re = new RegExp(regex);
            if (!hasOptions(obj)) {
                return;
            }
            for (var i = 0; i < obj.options.length; i++) {
                if (re.test(obj.options[i].text)) {
                    obj.options[i].selected = selected1;
                } else {
                    if (only == true) {
                        obj.options[i].selected = selected2;
                    }
                }
            }
        }
    }
    // -------------------------------------------------------------------
    // sortSelect(select_object)
    //   Pass this function a SELECT object and the options will be sorted
    //   by their text (display) values
    // -------------------------------------------------------------------
    function sortSelect(obj) {
        var o = new Array();
        if (!hasOptions(obj)) {
            return;
        }
        for (var i = 0; i < obj.options.length; i++) { //alert(obj.options[i].id);
            o[o.length] = new Option(obj.options[i].text, obj.options[i].value, obj.options[i].defaultSelected, obj.options[i].selected);
        }
        if (o.length == 0) {
            return;
        }
        o = o.sort(
            function (a, b) {
                if ((a.text + "") < (b.text + "")) {
                    return -1;
                }
                if ((a.text + "") > (b.text + "")) {
                    return 1;
                }
                return 0;
            }
        );

        for (var i = 0; i < o.length; i++) { // alert(o[i].id);
            obj.options[i] = new Option(o[i].text, o[i].value, o[i].defaultSelected, o[i].selected);
        }
    }
    /* Move List box Option from Left-Right OR Right-Left Box Code - End*/

    /* Code by Arun: Dropbox Phase 2 */

    function openDropboxAddComments(id, workflow) {
        $.ajax({
            type: "POST",
            url: baseurl + 'dropbox/submission/' + id + '/addcomment/1',
            data: "id=" + id + '&workflow=' + workflow,
            success: function (res) {
                if (res != '') {
                    $('#cat_topic_container').html(
                        $('<div/>', {
                            html: sanitizeHTML(res)
                        }).text()
                    );
                    $('#basic-modal-category').modal();
                    
                }
            }
        });
    }

    function initiateMultiScanComment(id) {
        var file_type = $.trim($('#file_type').val());
        errorArray = [];
        var invalid_file_length = $(".flash_uploaded_file").find("span.red").length;
        if(!isNaN(invalid_file_length) && invalid_file_length > 0) {
            errorArray.push("Please upload valid file(s)");
        }
        if(queue.length > 50){
            queue = [];
            $(".file-input").val("");
            errorArray.push('The maximum Number of files (50) has been exceeded.Please try to submit less files or submit a compressed folder.');
            document.getElementById("files_list").innerHTML = "";
            var file_number_exeeds = 1;
        }
    
        var internalvalues = '';
        var array_len = errorArray.length;
        var showError = 0;
        
        if(array_len > 0) {
            if(file_number_exeeds === 1){
                internalvalues = "";
            }else{
                internalvalues = "Please enter the required fields highlighted below:";
            }
            internalvalues += '<li>&nbsp;</li>';
            for(var i = 0; i < array_len; i++) {
                if(errorArray[i]) {
                    internalvalues += '<li>'+errorArray[i]+'</li>';
                    showError = 1;
                }
            }
            if(showError == 1)
                $('#status_msg').addClass("error").removeClass("success").html('<ul>' + internalvalues + '</ul>').show();
            else 
                $("#status_msg").addClass("error").removeClass("success").hide();
        } else {
            $("#status_msg").addClass("error").removeClass("success").hide();
        }
    
        if(showError==1) {
            $("#status_msg").addClass("error").removeClass("success");
            return false;
        } else{
            //process upload to s3bucket
            // $('#savefileuploadloading').show();// show the loader
            // $('#savefileupload').hide();// hide submit button
    
            if($('#files_list input').length > 0 || $('#files_list img').length > 0) {
                let baseurl_http = baseurl; //baseurl.replace('https://','http://');
                let process_path =  baseurl_http + 'dropbox/submission/' + id + '/addcomment/upload/' + file_type;
                let form_id = 'comments_form';
                let form_name = 'multifileupload_comments';
                let loader_div = 'addfunctionloading';
                let submit_div = 'addfunction';
                processCommentUpload(process_path, form_id, form_name, loader_div, submit_div);
            }
    
        }
    
    }
    
    function processCommentUpload(process_path, form_id, form_name, loader_div, submit_div) {
        var fd = $('#'+form_id)[0];
        var fds = new FormData(fd);
        
        for (i = 0; i < queue.length; i++) {
            var fna = queue[i].pre + '-' + queue[i].name;
            fds.append('files[]', queue[i], fna);
        }

        for(var key in fds.keys()){
              fds.delete(form_name + '[]');
        }
        var xhr = new XMLHttpRequest;
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                $('#'+loader_div).hide();// hide the loader
                $('#subBut').attr('disabled', false);// enable submit button
                var obj = JSON.parse(this.responseText)
                let fids = "";
                let fnames = "";
                for (var i = 0; i < obj.length; i++) {
                    var result = obj[i]
                    const message = result.message
                    const file_name = result.file_name
                    if(file_name != '') {
                        //successfully uploaded to s3bucket
                        $("#status_msg").html("Files are successfully uploaded to s3 bucket for scanning").show(); //scan completed and ready to upload
                        $('#'+submit_div).show();
                        fid = $("#file_id").val()
                        fname = $("#uploaded_file_name").val()
                        fids = (fid != "" ? fid + ',' + message : message)
                        fnames = (fname != "" ? fname + ',' + file_name: file_name)
                        
                        $("#file_id").val(fids);
                        $("#status_msg").removeClass("error").addClass("success");
                        $("#uploaded_file_name").val(fnames);
                    } else {
                        $("#status_msg").addClass("error").removeClass("success").html('<ul><li>'+message+'</li></ul>').show();
						$('#'+submit_div).show();
                    }
                    
                }
            }
            
        };
        $('#'+loader_div).show(); //show the loader and hide submit
        $('#'+submit_div).hide();
        xhr.open('POST', process_path, true);
        xhr.send(fds);
    
    }
    var upload_src = '';
    var gbl_comments_id = '';

function check_comment_selectedStatus(sel){
	var existStatus = $('#comment_currentStatus').val();
	var changingStatus = sel.value//$('#comment_status').find()
	if( existStatus === changingStatus){
	   alert('Already in '+existStatus+', please select other option');
	}
}
    function postTicketComment(id) {
        var comment = $.trim($('#dbox_comments').val());
		
		if($('#comment_status').length > 0 ) {
			var status = $.trim($('#comment_status').val());
		}else{
			var status = '';
		}
		if($('#file_type').length > 0){
			 var file_type = $.trim($('#file_type').val());
		}
        var token = $.trim($('#csrf_token').val());
        var error = '';
        if (comment == '') {
            error += "Please provide your comments<br/>";
        }
        if (token == '') {
            error += "Security alert: Unable to process your request.<br/>";
        }
        if (queue.length > 50) {
            queue = [];
            $(".file-input").val("");
            document.getElementById("files_list").innerHTML = "";
            error += "The maximum Number of files (50) has been exceeded.Please try to submit less files or submit a compressed folder.";
        }
        var invalid_file_length = $(".flash_uploaded_file").find("span.red").length;
        if (!isNaN(invalid_file_length) && invalid_file_length > 0) {
            error += "Please upload valid file(s) <br />";
        }
        if (error != '') {
            $('#status_msg').addClass("error").removeClass("success").html(error).show();
            return false;
        } else {
            var file_id = $.trim($("#file_id").val());
		    var file_name = $.trim($("#uploaded_file_name").val());
            let loader_div = 'addfunctionloading';
            let submit_div = 'addfunction';

            $('#'+loader_div).show(); //show the loader
			$('#'+submit_div).hide();

            $('#status_msg').addClass("success").removeClass("error").html(error).hide();
            $.ajax({
                type: "POST",
                url: baseurl + 'dropbox/submission/' + id + '/addcomment/save',
                data: "id=" + id + '&comment=' + encodeURIComponent(comment) + '&status=' + status + '&token=' + token+"&file_id="+encodeURIComponent(file_id)+'&file_name='+encodeURIComponent(file_name),
                success: function (res) {
                    let parsedJSON = JSON.parse($.trim(res));
                    $('#'+loader_div).hide();
					$('#'+submit_div).show();
                    if (parsedJSON.msg != '' && !isNaN(parsedJSON.msg)) {
                        if ($('#files_list input').length > 0 || $('#files_list img').length > 0) {
                            upload_src = 'comments';
                            gbl_comments_id = parsedJSON.msg;
                            uploadCompleted();
                        } else {
                            callEmailTrigger(parsedJSON.msg);
                            $('div#simplemodal-container').addClass('addcomment-container');
                            $('#cat_topic_container').html($('<div/>', { html: sanitizeHTML($('#successCommentadd').html()) }).text());
                            $('#simplemodal-container a.modalCloseImg').hide();
                        }
                    }else{
                        $("#status_msg").addClass("error").removeClass("success").html("Sorry! Error while adding comments").show();
                        return false;
                    }
                }
            });
        }
    }

    function callEmailTrigger(commentid) {
        var commentid = commentid;
        $.ajax({
            type: "POST",
            url: baseurl + 'vwr_dropbox/mailtrigger/' + commentid,
            data: "",
            success: function (res) { }
        });
    }

    function downloadAttchedFiles(comm_id, type, sub_id) {
        document.location.href = baseurl + 'dropbox/submission/' + sub_id + '/addcomment/download/' + comm_id + '?redirect=' + sub_id;
    }

    function downloadSubmissionfiles(fid, type, sub_id) {
        document.location.href = baseurl + 'dropbox/submission/' + sub_id + '/addcomment/fdownload/' + fid + '?redirect=' + sub_id;
    }

    function downloadAllSubfiles(fid, type, sub_id) {
        document.location.href = baseurl + 'dropbox/submission/' + sub_id + '/addcomment/fdownload/' + fid + '?redirect=' + sub_id;
    }

    function deleteAttachments(id, type, sub_id) {
        if (id && type == 'filedocs') {
            $("#dialog").html("Are you sure you want to delete this document?");
            $('#dialog').dialog({
                modal: true,
                autoOpen: true,
                minHeight: 45,
                width: 400,
                resizable: false,
                buttons: {
                    "OK": function () {
                        $.ajax({
                            type: "POST",
                            url: baseurl + 'dropbox/submission/' + sub_id + '/addcomment/fdelete',
                            data: "id=" + id + '&sub_id=' + sub_id,
                            success: function (res) {
                                if (res == 'success') {
                                    document.location.href = baseurl + 'vwr_dropbox/viewsubmission/' + sub_id;
                                }
                            }
                        });
                        $(this).dialog("close");
                    },
                    "Cancel": function () {
                        $(this).dialog("close");
                    }
                }
            });
        }

    }

    function deleteSubmissionEle(id, type, sub_id) {
        if (id && type == 'comment') {
            $("#dialog").html("Are you sure you want to delete this comment?");
            $('#dialog').dialog({
                modal: true,
                autoOpen: true,
                minHeight: 45,
                width: 400,
                resizable: false,
                buttons: {
                    "OK": function () {
                        $.ajax({
                            type: "POST",
                            url: baseurl + 'dropbox/submission/' + sub_id + '/addcomment/cdelete',
                            data: "id=" + id + '&sub_id=' + sub_id,
                            success: function (res) {
                                if (res != '') {
                                    document.location.href = baseurl + 'vwr_dropbox/viewsubmission/' + res;
                                }
                            }
                        });
                        $(this).dialog("close");
                    },
                    "Cancel": function () {
                        $(this).dialog("close");
                    }
                }
            });
        }

    }

    function addEditorOnly() {
        if (window.tinyMCE) {
            tinyMCE.init({ // General options, theme: advanced, simple
                mode: "exact",
                elements: 'message_desc',
                theme: 'advanced',
                invalid_elements: 'script',
                plugins: "autolink,lists,style",
                theme_advanced_buttons1: "newdocument,|,bold,italic,underline,|,formatselect,fontselect,fontsizeselect",
                theme_advanced_buttons2: "bullist,numlist,|,link,unlink,anchor,|,forecolor,backcolor",
                theme_advanced_buttons3: null,
                theme_advanced_toolbar_location: "top",
                theme_advanced_toolbar_align: "left",
                theme_advanced_statusbar_location: null,
                theme_advanced_resizing: true
            });
        }
    }

    function editSubmissionInfo(id, type, sub_id) {
        if (id && type == 'filedocs') {
            $.ajax({
                type: "POST",
                url: baseurl + 'category/fileupload/submissions',
                data: "id=" + id + '&sub_id=' + sub_id,
                success: function (res) {
                    if (res != '') {
                        $('#cat_topic_container').html(
                            $('<div/>', {
                                html: sanitizeHTML(res)
                            }).text()
                        );
                        $('#basic-modal-category').modal();
                        addEditorOnly();
                    }
                }
            });
        } else if (id && sub_id && type == 'filedocsave') {
            var title = $.trim($("#title").val());
            var message_desc = $.trim($("#message_desc").val());
            if (window.tinyMCE) {
                message_desc = tinyMCE.get('message_desc').getContent();
            }
           // var msg_valid = $.trim(removeHTMLTags(message_desc));
			var msg_valid = $.trim(message_desc);
            var error = '';
            if (title == "") {
                error += 'Title can not be empty<br />';
            } else if (!isNaN(Number(title))) {
                error += 'Title must contain alphabets<br/>';
            } else if (title.length > 60) {
                error += 'Title can not be more than 60 characters<br/>';
            }
            if (msg_valid == "") {
                error += 'Message can not be empty<br/>';
            } else if (msg_valid.length > 1000) {
                error += 'Message can not exceed 1000 characters<br/>';
            }
            if (error != '') {
                $("#status_msg").html(error).show();
                return false;
            } else {
                $("#status_msg").html(error).hide();
            }
            $.ajax({
                type: "POST",
                url: baseurl + 'category/fileupload/submissions/update',
                data: "id=" + id + '&sub_id=' + sub_id + '&title=' + encodeURIComponent(title) + '&message_desc=' + encodeURIComponent(message_desc),
                success: function (res) {
                    if (res == 'success') {
                        $("#status_msg").removeClass('error').addClass('success').html('Submission details updated successfully').show();
                        document.location.href = baseurl + 'vwr_dropbox/viewsubmission/' + sub_id;
                    }
                }
            });
        }
    }


    /* Submission Tickets: End */


    function updateFileBrowser(file_type_id) {
        if (file_type_id != 0) {
            document.getElementById('browseButton').style.display = '';
            if (file_type_id.toUpperCase() == 'PA') {
                changeTo(true);
            } else {
                changeTo(false);
            }
            $("#option-selectfiletype").remove();
        } else {
            document.getElementById('browseButton').style.display = 'none';
        }
    }

    function changeTo(singlefile) {
        if (singlefile) {
            $("#multifileupload_comments").attr("multiple", false); // singlefile - edit
        } else {
            $("#multifileupload_comments").attr("multiple", true); // multifiles - create
        }
    }

    function filesValidation() {
        var filesize = 0;
        if (queue.length > 0) {
            for (i = 0; i < queue.length; i++) {
                filesize = filesize + queue[i].size;
            }
        }
        if (filesize > 500000000) {//1000000000 for 1GB
            alert('Please upload files below 500MB');
            queue = [];
            return false;
        } else {
            return true;
        }
    }

    function changefileType(obj) {
        $(obj).hide();
        $(".filesize-limit").hide();
		var subId = $("#fileChangeId").val();
        $("#browseButton").append("<input type='file' class='file-input' id='multifileupload_comments' name='multifileupload_comments[]' multiple onchange='fileSelect(event);changefileType(this);initiateMultiScanComment("+subId+")'><font class='filesize-limit' style='color:#000000;float:right;'>Max_size 500MB/Max_count 50</font></input>");
    }
	var duplicateFilesCheck = [];
	var changeCnt = '';
    function fileSelect(e) {
        document.getElementById("files_list").innerHTML = "";
        var pref = document.getElementById('file_type').value;
        var htmlIns = "";
        var fi = e.target.files;
		if (filesValidation()) {
			if(changeCnt !== ''){
				for (i = 0; i < fi.length; i++) {
					if (duplicateFilesCheck.indexOf(fi[i].name) === -1) {
						duplicateFilesCheck.push(fi[i].name);
						var fname = fi[i].name;
						fi[i]['pre'] = pref;
						queue.push(fi[i]);
						
						//console.log(queue[i].name);
					} else{
						alert(fi[i].name+ ' alrady uploaded');
					}
				}
				changeCnt = 2;			
			}else  {  //if(typeof changeCnt === 'undefined')
				for (i = 0; i < fi.length; i++) {
					var fname = fi[i].name;
					fi[i]['pre'] = pref;
					queue.push(fi[i]);
					duplicateFilesCheck.push(fi[i].name);
					
				}
				changeCnt = 1;
			}
			//return false;
			$.each(queue, function (i, value) {
				var filename = value['pre'] + '-' + value['name'];
				var fileshortname = (filename.length > 60) ? filename.substr(0, 60) + '..' : filename;
				htmlIns += '<div id="flash_selfile_' + i + '" class="flash_uploaded_file"><span title="' + filename + '">' + fileshortname + '</span><img src="' + baseurl + 'sites/all/themes/vwr/images/ico_8.png" width="18" height="18" alt="delete" onclick="removeFile(' + i + ');" /></div>';
				/* if (fname.split('.').pop() == fname || fname.split('.').pop() == '*') {
					htmlIns += '<div id="flash_selfile_' + i + '" class="flash_uploaded_file"><span title="' + filename + '" class="red" style="color:#FF0000;">' + fileshortname + '</span><img src="' + baseurl + 'sites/all/themes/vwr/images/ico_8.png" width="18" height="18" alt="delete" onclick="removeFile(' + i + ');" /></div>';
				}
				else {
					htmlIns += '<div id="flash_selfile_' + i + '" class="flash_uploaded_file"><span title="' + filename + '">' + fileshortname + '</span><img src="' + baseurl + 'sites/all/themes/vwr/images/ico_8.png" width="18" height="18" alt="delete" onclick="removeFile(' + i + ');" /></div>';
				} */
			});
		}
        document.getElementById("files_list").innerHTML = htmlIns;
    }

    function removeFile(pos) {
        $("#flash_selfile_" + pos).html('').hide();
        queue.splice(pos, 1);
    }

    function removeAllFiles() {
        if (queue.length > 0) {
            queue = [];
        }
        document.getElementById("files_list").innerHTML = "";
		if($('#file_id').val().length > 0){
			var fids = $('#file_id').val(); 
			$.ajax({
				type: "POST",
				url: baseurl + 'dropbox/removeFiles?fid='+fids,
				success: function (res) {
					console.log(res);
				}
			});
		}
    }

    function doUpload(url, res) {
        var fd = $('#comments_form')[0];
        var fds = new FormData(fd);
        fds.append(
            'rid',
            $('<div/>', {
                html: sanitizeHTML(res)
            }).text()
        );
        for (i = 0; i < queue.length; i++) {
            var fna = queue[i].pre + '-' + queue[i].name;
            fds.append('files[]', queue[i], fna);
        }
        for (var key in fds.keys()) {
            fds.delete('multifileupload_comments[]');
        }
        var xhr = new XMLHttpRequest;
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var obj = JSON.parse(this.responseText)
                for (var i = 0; i < obj.length; i++) {
                    var result = obj[i]
                    const msg = result.message.split('~~')
                    const message = msg[0]
                    const file_name = result.file_name
                    if (file_name == '') {
                        $('.error').html('<ul><li>' + message + '</li></ul>').show()
                        return false
                    }
                }
                upload_src = 'comments';
                gbl_comments_id = res;
                setTimeout(uploadCompleted, 2000);
            }
        };
        xhr.open('POST', url, true);
        xhr.send(fds);
    }

    function uploadCompleted() {
        if (upload_src == "comments") {
            queue = [];
            callEmailTrigger(gbl_comments_id);
            $('div#simplemodal-container').addClass('addcomment-container');
            $('#cat_topic_container').html($('<div/>', { html: sanitizeHTML($('#successCommentadd').html()) }).text());
            $('#simplemodal-container a.modalCloseImg').hide();
        }
    }

    /* Enhancements for Dropbox : Support */
    function statusChangeItems(thisObj) {
        var statusval = $(thisObj).val();
        if (statusval) {
            $("#submission_status_email").show();
            $("#status_notify_label.reg_labl").children("span").text("*");
        } else {
            $("#submission_status_email").hide();
            $("#status_notify_label.reg_labl").children("span").html("&nbsp;&nbsp;");
        }
    }