/**
 * Open WordPress SEO JavaScript functionality
 */
jQuery(document).ready(function($) {
    var $titleInput = $('#open_wp_seo_title'),
		$descriptionArea = $('#open_wp_seo_description');
		
	$titleInput.keyup(function () {
		$('.open-wp-seo-preview-title').text($titleInput.val());
	});
	
	$descriptionArea.keyup(function () {
		$('.open-wp-seo-preview-description').text($descriptionArea.val());
	});
	
	if (window.location.href.indexOf('tab=automatic-titles') !== -1) {
		$('.nav-tab').removeClass('nav-tab-active');
		$('.automatic-titles-tab-button').addClass('nav-tab-active');
		$('.open-wp-seo-settings-tab').hide();
		$('#automatic-titles').show();
	}
	else if (window.location.href.indexOf('tab=sitemap') !== -1) {
		$('.nav-tab').removeClass('nav-tab-active');
		$('.sitemaps-tab-button').addClass('nav-tab-active');
		$('.open-wp-seo-settings-tab').hide();
		$('#sitemaps').show();
	}
	else if (window.location.href.indexOf('tab=advanced') !== -1) {
		$('.nav-tab').removeClass('nav-tab-active');
		$('.advanced-tab-button').addClass('nav-tab-active');
		$('.open-wp-seo-settings-tab').hide();
		$('#advanced').show();
	}
	else {
		$('.nav-tab').removeClass('nav-tab-active');
		$('.main-settings-tab-button').addClass('nav-tab-active');
		$('.open-wp-seo-settings-tab').hide();
		$('#main-settings').show();		
	}
	
	$('.open-wp-seo-settings-wrap').show();

	$("#btn_testing").click(function(){
		// clear content;
		$("#txt_suggest").text("");
		
		let value = $("#ipt_keyword").val();
		let region = $("#ipt_region").val();

		// fetch data API
		const xhttp = new XMLHttpRequest();
		xhttp.onload = function() {
			let res = JSON.parse(this.responseText);
			let res_styled = "";

			// set badges
			$.each(res[1], function(i, j) {
				let backup = $("#txt_suggest").text();
				res_styled += backup + "<span style='background-color: #3B9AE1;"+
											  "color: white;"+
											  "display: inline-block;"+
											  "padding: 4px 8px;"+
											  "margin: 3px;"+
											  "text-align: center;"+
											  "border-radius: 5px;'>" + j + "</span>";
			});

			$("#txt_suggest").html(res_styled);
		}
		xhttp.open("GET", "https://suggestqueries.google.com/complete/search?client=chrome&hl=en&q="+ value +"&gl=" + region);
		xhttp.send();
	 });
});