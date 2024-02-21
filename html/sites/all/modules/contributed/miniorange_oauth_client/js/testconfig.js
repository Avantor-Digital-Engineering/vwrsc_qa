function testConfig(testUrl) {
	var myWindow = window.open(testUrl, "TEST OAuth Client", "scrollbars=1 width=800, height=600");
}

(function($)
{
    Drupal.behaviors.moTour = {
        attach: function (context, settings) {
            moTour = settings.moTour;
            tryHere(settings.moTour);
        }
    };
})(jQuery);


function tryHere(moTour) {
    console.log("doc loaded");
    jQuery("#edit-miniorange-saml-idp-support-side-button").click(function (e) {
        e.preventDefault();
        if (jQuery("#mosaml-feedback-form").css("right") != "0px") {
            console.log("show");
            jQuery("#mosaml-feedback-overlay").show();
            jQuery("#mosaml-feedback-form").animate({
                "right": "0px"
            });
        }
        else {
            jQuery("#mosaml-feedback-overlay").hide();
            jQuery("#mosaml-feedback-form").animate({
                "right": "-391px"
            });
        }
    });
}