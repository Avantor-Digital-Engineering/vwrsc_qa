	var sanitizeHTML = function (str) {
		var temp = document.createElement('div');
		temp.textContent = str;
		return temp.innerHTML;
	};
	/* Global variables */
	var icons = '';
	var checked_Elements = '';
	/* Global variables */

	/*configure dahboard click function start here*/
	function checkbox_test() {
		checked_Elements = document.iconform.elements.length;
		var currentuser = $('#currentuser').val();
		var defaults = new Array();
		var category = new Array();
		var subcategory = new Array();
		var dropbox = new Array();
		var baseurl = location.protocol + "//" + location.host + Drupal.settings.basePath;
		var themeurl = "sites/all/themes/vwr/images";
		var all = '';
		var icons = '';
		var dashboardcontents = ''
		var subicons = '';
		var iconscount = '';
		var i, j, k, l, categories, catpos, catregions, subcategories, subcatpos, subcatregions, catgroups, subcatgroups
		var m, n, o, p, dropboxes, dropboxpos, dropboxregions, dropboxgroups
		var catregionsidonly, subcatregionsidonly, dropboxregionidsonly
		var categorygroup = [];
		var subcategorygroup = [];
		var dropboxgroup = [];
		var catgroupregionidsonly = [];
		var subcatgroupregionidsonly = [];
		var dropboxboxgroupregionidsonly = [];
		for (i = 0, j = 0, k = 0, l = 0, m = 0; i < checked_Elements; i++) {
			var type = document.iconform.elements[i].type;
			var className = document.iconform.elements[i].className;
			var id = document.iconform.elements[i].id;
			if (type == "checkbox" && className == "default" && document.iconform.elements[i].checked) {
				defaults[j] = document.iconform.elements[i].value;
				icons += '&' + document.iconform.elements[i].value + '=' + document.iconform.elements[i].value;
				j++;
			}
			if (type == "checkbox" && className == "category" && document.iconform.elements[i].checked) {
				category[k] = document.iconform.elements[i].value;
				catpos = category[k].indexOf("regionid");
				categories = category[k].substr(0, (catpos - 1));
				catregions = category[k].substr((catpos), category[k].length);
				catregionsidonly = catregions.split("#");
				icons += '&icons' + k + '=' + categories;
				catgroups = categories.split("#");
				categorygroup.push(catgroups[1]);
				catgroupregionidsonly.push(catregionsidonly[1]);
				k++;
			}
			if (type == "checkbox" && className == "subcategory" && document.iconform.elements[i].checked) {
				subcategory[l] = document.iconform.elements[i].value;
				subcatpos = subcategory[l].indexOf("regionid");
				subcategories = subcategory[l].substr(0, (subcatpos - 1));
				subcatregions = subcategory[l].substr((subcatpos), subcategory[l].length);
				subcatregionsidonly = subcatregions.split("#");
				icons += '&icons' + l + '=' + subcategories;
				subcatgroups = subcategories.split("#");
				subcategorygroup.push(subcatgroups[1]);
				subcatgroupregionidsonly.push(subcatregionsidonly[1]);
				l++;
			}
			if (type == "checkbox" && className == "dropboxes" && document.iconform.elements[i].checked) {
				dropbox[m] = document.iconform.elements[i].value;
				dropboxpos = dropbox[m].indexOf("regionid");
				dropboxes = dropbox[m].substr(0, (dropboxpos - 1));
				dropboxregions = dropbox[m].substr((dropboxpos), dropbox[m].length);
				dropboxregionidsonly = dropboxregions.split("#");
				icons += '&icons' + m + '=' + dropboxes;
				dropboxgroups = dropboxes.split("#");
				dropboxgroup.push(dropboxgroups[1]);
				dropboxboxgroupregionidsonly.push(dropboxregionidsonly[1]);
				m++;
			}
		}
		iconscount = j + k + l + m;		
		var totalids = new Array();
		totalids = defaults.concat(category);
		totalids = totalids.concat(subcategory);
		totalids = totalids.concat(dropbox);

		if (icons != '') {
			var uid = $("#currentuser").val();
			$('#dashboard_loader').html('<img src="' + baseurl + themeurl + '/ajax-loader.gif" alt="Loading..." title="" border="0">').show();
			var dashboard_icons = "";
			for (i = 0; i < iconscount; i = i + 1) {
				dashboard_icons += "w_" + i + "@" + totalids[i] + ",";
			}

			$.ajax({
				type: "POST",
				url: baseurl + 'dashboard-save',
				data: 'user=' + uid + '&icons=' + dashboard_icons + '&total=' + iconscount + '&categorylist=' + categorygroup + '&subcategorylist=' + subcategorygroup + '&categoryregionlists=' + catgroupregionidsonly + '&subcategoryregionlists=' + subcatgroupregionidsonly + '&dropboxlist=' + dropboxgroup + '&dropboxregionlist=' + dropboxboxgroupregionidsonly,
				success: function (res) {
					if (res == "success") {
						document.location.href = baseurl;
					}
				}
			});
		} else {
			var selectedicons = 'notselected';
			$('#dashboard_loader').html('<img src="' + baseurl + themeurl + '/ajax-loader.gif" alt="Loading..." title="" border="0">').show();

			$.ajax({
				type: "POST",
				url: baseurl + 'icons-select',
				data: 'user=' + currentuser,
				success: function (res) {
					if (res == "success") {						
						document.location.href = baseurl;
					}
				}
			});

		}
	}
	/*configure dahboard click function end here*/

	/*Icons minimize and maximize acion start here*/
	function iconsHide(id) {
		var myWidget = '#widget_' + id;
		$('#widget_' + id).fadeOut('slow');
		$('.hide' + id).css('display', 'none');
		$('.expand' + id).css('display', 'block');
	}

	function iconsShow(id) {
		var myWidget = '#widget_' + id;
		$('#widget_' + id).fadeIn(1000);
		$('.expand' + id).css('display', 'none');
		$('.hide' + id).css('display', 'block');

	}
	/*Icons minimize and maximize acion end here*/
	/*icons delecte action start here*/
	function imageHide(list_id) {
		$('.content_ht_' + list_id).live('click', function () {
			$(this).closest('li').remove();
			dashboardDeleteIcon();
		});
		
	}

	function dashboardDeleteIcon() {
		var items = $("li[class^=content_ht]");
		var uid = $("#currentuser").val();
		var count = $("li[class^=content_ht]").length;
		var dashboard_icons = "";
		for (i = 0; i < items.length; i = i + 1) {
			dashboard_icons += "w_" + i + "@" + items[i].id + ",";
		}
		$.ajax({
			type: "POST",
			url: baseurl + 'dashboard-save',
			data: 'user=' + uid + '&icons=' + dashboard_icons + '&total=' + count,
			success: function (res) {
				if (res == "success") {
					
				}
			}
		});
		if (count == 0) {
			message_show();
		}
	}




	function dashboardSave() {
		var items = $("li[class^=content_ht]");
		var uid = $("#currentuser").val();
		var count = $("li[class^=content_ht]").length;
		var length = $(".currentregioncontent").length;
		var j = 0; var k = 0, l = 0, m = 0, n = 0, p = 0, q = 0, r = 0;
		var catpos, categories, catregions, subcategories;
		var category = new Array();

		var categorynaregions = new Array();
		var categorynar = new Array();

		var categoryeuregions = new Array();
		var categoryeur = new Array();

		var subcategorynaregions = new Array();
		var subcategorynar = new Array();

		var subcategoryeuregions = new Array();
		var subcategoryeur = new Array();

		var dropboxnaregions = new Array();
		var dropboxnar = new Array();

		var dropboxeuregions = new Array();
		var dropboxeur = new Array();


		var subcategory = new Array();
		var categorygroup = [];
		var subcategorygroup = [];
		var dropboxgroup = [];
		var catgroupregionidsonly = [];
		var subcatgroupregionidsonly = [];
		var dropboxgroupregionidsonly = [];









		$("div.Rec div.widget div.wid-act ul").find("a[data-region*='catnas']").each(function () {
			categorynaregions[l] = $(this).attr('id');
			categoriesnar = categorynaregions[l].split("_");
			catgroupregionidsonly.push(categoriesnar[3]);
			categorygroup.push(categoriesnar[2]);
			l++;
		});

		$("div.Rec div.widget div.wid-act ul").find("a[data-region*='europeancats']").each(function () {
			categoryeuregions[m] = $(this).attr('id');
			categorieseur = categoryeuregions[m].split("_");
			catgroupregionidsonly.push(categorieseur[3]);
			categorygroup.push(categorieseur[2]);
			m++;
		});

		$("div.Rec div.widget div.wid-act ul").find("a[data-region*='northamericansubcategories']").each(function () {
			subcategorynaregions[n] = $(this).attr('id');
			subcategoriesnar = subcategorynaregions[n].split("_");
			subcatgroupregionidsonly.push(subcategoriesnar[3]);
			subcategorygroup.push(subcategoriesnar[2]);
			n++;
		});

		$("div.Rec div.widget div.wid-act ul").find("a[data-region*='europeansubs']").each(function () {
			subcategoryeuregions[p] = $(this).attr('id');
			subcategorieseur = subcategoryeuregions[p].split("_");
			subcatgroupregionidsonly.push(subcategorieseur[3]);
			subcategorygroup.push(subcategorieseur[2]);
			p++;
		});

		$("div.Rec div.widget div.wid-act ul").find("a[data-region*='northamericandropboxes']").each(function () {
			dropboxnaregions[q] = $(this).attr('id');
			dropboxnar = dropboxnaregions[q].split("_");
			dropboxgroupregionidsonly.push(dropboxnar[3]);
			dropboxgroup.push(dropboxnar[2]);
			q++;
		});
		$("div.Rec div.widget div.wid-act ul").find("a[data-region*='europeandropboxes']").each(function () {
			dropboxeuregions[r] = $(this).attr('id');
			dropboxeur = dropboxeuregions[r].split("_");
			dropboxgroupregionidsonly.push(dropboxeur[3]);
			dropboxgroup.push(dropboxeur[2]);
			r++;
		});



		var dashboard_icons = "";
		for (i = 0; i < items.length; i = i + 1) {
			dashboard_icons += "w_" + i + "@" + items[i].id + ",";
		}
		$.ajax({
			type: "POST",
			url: baseurl + 'dashboard-save',
			data: 'user=' + uid + '&icons=' + dashboard_icons + '&total=' + count + '&categorylist=' + categorygroup + '&subcategorylist=' + subcategorygroup + '&categoryregionlists=' + catgroupregionidsonly + '&subcategoryregionlists=' + subcatgroupregionidsonly + "&dropboxlist=" + dropboxgroup + "&dropboxregionlist=" + dropboxgroupregionidsonly,
			success: function (res) {
				if (res == "success") {
					document.location.href = baseurl;
				}
			}
		});
		if (count == 0) {
			message_show();
		}
	}

	function message_show() {
		$('#dashboard_message').css('display', 'block');
	}

	/*icons delecte action end here*/
	/*dashboard popup loading start here*/
	function dashboardpopup(popupurl) {
		dashboardurl = location.protocol + "//" + location.host + Drupal.settings.basePath;
		$.ajax({
			type: "GET",
			url: dashboardurl + popupurl,
			success: function (res) {
				if (res != '') {
					$('#dashboard-modal-content1').modal();
					$('#simplemodal-container').addClass('dashboardpopup-container');
					$('#dashboard_container').html(
						$('<div/>', {
							html: sanitizeHTML(res)
						}).text()
					);
					

				}
			}
		});
	}
	function showcategorypage(catids, subcatids, section, regionids) {

		if (section == 'cat') {
			catids = catids.split("_");
			setCookie('currentregiontab', regionids);
			document.location.href = "category/" + catids[0];
		}
		if (section == 'subcat') {
			subcatids = subcatids.split("_");
			setCookie('currentregiontab', regionids);
			document.location.href = "category/" + catids + "/topic/" + subcatids[0];
		}

	}
	/*dashboard popup loading end  here*/