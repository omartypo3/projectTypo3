$ (document).ready (function () {
	var referrer = document.referrer,
		pixelAgreementState = $.cookie ("tx_fbpxcwdp");

	// cookies not created, then open popup
	if (!pixelAgreementState) {
		console.log(referrer);
		if (referrer.indexOf ('facebook.com/') > 1) {

			setTimeout (function () {
				$ ("#facebook-pixel-request").fancybox ({
					maxWidth   : 800,
					maxHeight  : 600,
					closeClick : false,
					helpers    : {overlay : {closeClick : false}},
					onClosed   : $.fancybox.close ()
				}).trigger ('click');
			}, 300);

			$ (document).on ('click', '#facebook-pixel-request-content a:not(".Informationen")', function ( e ) {
				e.preventDefault ();
				var enablePixel = $ (this).data ('avonis-enable-pixel');
				//if user accept then cookie created and we add the pixel code
				if (enablePixel) {
					$.cookie ("tx_fbpxcwdp", enablePixel, {path: '/'});
					FacebookPixelCode ();
				}
				$.fancybox.close ();

			})
		}
	} else {
		//if have cookie created  the pixel code will be added
		FacebookPixelCode ();
	}

});

function FacebookPixelCode () {
	var pixelId = $ ('#facebook-pixel-request-content').data ("pixel");
	$ ('body').prepend ('<!-- Facebook Pixel Code -->' +
		'<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};' +
		'if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version=2.0; n.queue=[];t=b.createElement(e);t.async=!0; t.src=v;s=b.getElementsByTagName(e)[0]; s.parentNode.insertBefore(t,s)}(window,document,"script", "https://connect.facebook.net/en_US/fbevents.js");' +
		'fbq("init",' + pixelId + ');' +
		'fbq("track", "PageView");' +
		'fbq("track", "Search");' +
		'fbq("track", "PageView");' +
		'<\/script>' +
		'<noscript>' +
		'<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=' + pixelId + '&ev=PageView"/>' +
		'</noscript><!-- End Facebook Pixel Code -->'
	);

}
