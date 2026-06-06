define(['jquery', 'TYPO3/CMS/Recordlist/LinkBrowser'], function($, LinkBrowser) {
	var GmapLink = {};

	GmapLink.linkIt = function(event) {
		event.preventDefault();

		var identifier = $(this).data('identifier');
		var href = $(this).attr('href');
		var link = href+identifier;
		LinkBrowser.setAdditionalLinkAttribute('data-htmlarea-external', '1');
		LinkBrowser.finalizeFunction(link);
	};

	GmapLink.initialize = function() {
		$('a.GmapLink').on('click', GmapLink.linkIt);
	};

	$(GmapLink.initialize);

	return GmapLink;
});