(function() {
	'use strict';
	
	function getQueryFromUrl() {
		var urlParams = new URLSearchParams(window.location.search);
		return urlParams.get('tx_solr[q]') || urlParams.get('q') || null;
	}
	
	function updateSearchQuery() {
		var searchQuerySpan = document.getElementById('tx-solr-search-query');
		if (!searchQuerySpan) {
			return false;
		}
		
		if (searchQuerySpan.textContent && searchQuerySpan.textContent.trim()) {
			return true;
		}
		
		var queryValue = null;
		
		var searchInput = document.getElementById('searchform_results');
		if (searchInput && searchInput.value) {
			queryValue = searchInput.value;
		}
		
		if (!queryValue) {
			queryValue = getQueryFromUrl();
			if (queryValue) {
				queryValue = decodeURIComponent(queryValue);
			}
		}
		
		if (!queryValue && searchInput && searchInput.getAttribute('data-search-query')) {
			queryValue = searchInput.getAttribute('data-search-query');
		}
		
		if (queryValue) {
			searchQuerySpan.textContent = queryValue;
			return true;
		}
		
		return false;
	}
	
	if (updateSearchQuery()) {
		return; // Success, we're done
	}
	
	if (document.readyState === 'loading') {
		var attempts = 0;
		var maxAttempts = 20; 
		
		var intervalId = setInterval(function() {
			attempts++;
			if (updateSearchQuery() || attempts >= maxAttempts) {
				clearInterval(intervalId);
			}
		}, 5);
		
		document.addEventListener('DOMContentLoaded', function() {
			clearInterval(intervalId);
			updateSearchQuery();
		});
	} else {
		setTimeout(updateSearchQuery, 10);
	}
})();

