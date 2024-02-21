	var sanitizeHTML = function (str) {
		var temp = document.createElement('div');
		temp.textContent = str;
		return temp.innerHTML;
	}

	/* Doucment Search */
	function DocumentSearch(baseurl) {
		var keyword = $('#keyword').val();
		if (keyword == "") {
			alert("Please Enter Search Text");
			return false;
		} else {			
			$('#search-results').html('<div class="loader_image"><img src="' + baseurl + 'sites/all/themes/vwr/images/ajax-loader.gif"><br>Loading Search Results</div>');
			$.ajax({
				type: "POST",
				url: baseurl + "vwrServices/searchresults",
				data: 'search_keyword=' + keyword,
				success: function (res) {

					$('#search-results').html(						
						$('<div/>', {
							html: sanitizeHTML(res)							  
						}).text()
					)

					$('.tab_nav').css('visibility', 'hidden');
					$('#keyword').val('');
				}
			});
		}
	}
	function Advanced_DocumentSearch() {
		var keyword = $('#adv_keyword').val();
		var filter_option = $('#filter_option').val();
		var from_date = $('#from_date').val();
		var to_date = $('#to_date').val();
		if (keyword == "") {
			alert("Please Enter Keyword Text");
			return false;
		} else {
			$('#search-results').html('<div class="loader_image"><img src="' + baseurl + 'sites/all/themes/vwr/images/ajax-loader.gif"><br>Loading Search Results</div>');
			$.ajax({
				type: "POST",
				url: baseurl + "vwrServices/searchresults",
				data: 'search_keyword=' + keyword + '&filter_option=' + filter_option + '&from_date=' + from_date + '&to_date=' + to_date,
				success: function (res) {
					$('#search-results').html(						
						$('<div/>', {
							html: sanitizeHTML(res)							 
						}).text()
					)

				}
			});
		}
	}
	function AdvancdedSearchForm() {
		$.ajax({
			type: "POST",
			url: baseurl + "vwrServices/advancedsearch",
			data: '',
			success: function (res) {
				$('#search-results').html(					
					$('<div/>', {
						html: sanitizeHTML(res)						 
					}).text()
				)

			}
		});
	}
	function KeyPressFormSubmit(key_press, baseurl) {
		if (key_press.keyCode == 13) {
			DocumentSearch(baseurl);
		}
	}

	function FilterByRecords(keyword, records_per_page, sort_results) {
		$.ajax({
			type: "POST",
			url: baseurl + "vwrServices/searchresults",
			data: 'search_keyword=' + keyword + '&records_per_page=' + records_per_page + '&sort_results=' + sort_results,
			success: function (res) {
				$('#search-results').html(					
					$('<div/>', {
						html: sanitizeHTML(res)						
					}).text()
				)

			}
		});
	}
	function FilterBySorting(keyword, sort_results, records_per_page) {
		$.ajax({
			type: "POST",
			url: baseurl + "vwrServices/searchresults",
			data: 'search_keyword=' + keyword + '&sort_results=' + sort_results + '&records_per_page=' + records_per_page,
			success: function (res) {
				$('#search-results').html(					
					$('<div/>', {
						html: sanitizeHTML(res)						  
					}).text()
				)

			}
		});
	}
	function show_hide_datefiled(sort_type) {
		if (sort_type == 3) {
			$(".from_date_box").css("display", "none");
		} else {
			$(".from_date_box").css("display", "block");
		}
	}
	/* Doucment Search */