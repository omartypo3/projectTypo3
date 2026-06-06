(function() {
	function updatePaginationRange() {
		var urlParams = new URLSearchParams(window.location.search);
		var pageParam = urlParams.get('tx_solr[page]');
		var currentPageNum = pageParam ? parseInt(pageParam) : 1;
		
		// Traiter toutes les paginations sur la page
		var allPaginationContainers = document.querySelectorAll('.solr-pagination');
		if (allPaginationContainers.length === 0) {
			setTimeout(updatePaginationRange, 100);
			return;
		}
		
		allPaginationContainers.forEach(function(container) {
			var pagination = container.querySelector('.pagination');
			if (!pagination) return;
			updateSinglePagination(pagination, currentPageNum);
		});
	}
	
	function updateSinglePagination(pagination, currentPageNum) {
		pagination.classList.remove('pagination-loading');
		
		var allPageItems = Array.from(pagination.querySelectorAll('li'));
		var pageNumbers = [];
		
		// Récupérer tous les numéros de page
		allPageItems.forEach(function(li) {
			if (li.classList.contains('previous') || li.classList.contains('next')) {
				return;
			}
			// Utiliser data-page-number si disponible, sinon parser le texte
			var pageNum = li.getAttribute('data-page-number');
			if (pageNum) {
				pageNum = parseInt(pageNum);
			} else {
				var element = li.querySelector('a, span');
				if (element) {
					var pageText = element.textContent.trim().replace(/[^\d]/g, '');
					pageNum = parseInt(pageText);
				}
			}
			if (!isNaN(pageNum) && pageNum > 0) {
				var element = li.querySelector('a, span');
				pageNumbers.push({li: li, num: pageNum, element: element});
			}
		});
		
		if (pageNumbers.length === 0) {
			return;
		}
		
		// Trier par numéro de page
		pageNumbers.sort(function(a, b) { return a.num - b.num; });
		
		var totalPages = pageNumbers[pageNumbers.length - 1].num;
		var startPage, endPage;
		
		// Calculer la plage de pages à afficher
		var pagesBefore = 5;
		var pagesAfter = 4;
		
		// Toujours appliquer la même logique : 5 avant et 4 après à partir de la page 7
		if (currentPageNum < 7) {
			// Pour les pages 1-6, afficher 1-10
			startPage = 1;
			endPage = Math.min(10, totalPages);
		} else {
			// Pour les pages 7+, TOUJOURS afficher 5 avant et 4 après
			startPage = currentPageNum - pagesBefore;
			endPage = currentPageNum + pagesAfter;
			
			// Si on dépasse le total de pages, ajuster
			if (endPage > totalPages) {
				endPage = totalPages;
				// Essayer de maintenir 10 pages si possible
				var desiredStart = endPage - pagesBefore - pagesAfter;
				startPage = desiredStart >= 1 ? desiredStart : 1;
			}
			// S'assurer qu'on ne commence pas avant la page 1
			if (startPage < 1) {
				startPage = 1;
			}
		}
		
		// Cacher/afficher les pages selon la plage
		pageNumbers.forEach(function(page) {
			if (page.num >= startPage && page.num <= endPage) {
				page.li.style.display = '';
			} else {
				page.li.style.display = 'none';
			}
		});
		
		// Gérer les ellipses - trouver les éléments avec "...."
		var allDotsItems = Array.from(pagination.querySelectorAll('li'));
		var firstDot = null, lastDot = null;
		
		allDotsItems.forEach(function(li) {
			if (li.classList.contains('previous') || li.classList.contains('next')) {
				return;
			}
			var element = li.querySelector('a');
			if (element) {
				var text = element.textContent.trim();
				if (text === '....') {
					if (!firstDot && (!li.previousElementSibling || li.previousElementSibling.classList.contains('previous'))) {
						firstDot = li;
					}
					lastDot = li;
				}
			}
		});
		
		// Afficher/cacher la première ellipse
		var firstVisiblePage = pageNumbers.find(function(p) { return p.li.style.display !== 'none'; });
		if (firstVisiblePage && firstDot) {
			firstDot.style.display = firstVisiblePage.num > 1 ? '' : 'none';
		} else if (firstDot) {
			firstDot.style.display = 'none';
		}
		
		// Afficher/cacher la dernière ellipse
		var lastVisiblePage = null;
		for (var i = pageNumbers.length - 1; i >= 0; i--) {
			if (pageNumbers[i].li.style.display !== 'none') {
				lastVisiblePage = pageNumbers[i];
				break;
			}
		}
		if (lastVisiblePage && lastDot) {
			lastDot.style.display = lastVisiblePage.num < totalPages ? '' : 'none';
		} else if (lastDot) {
			lastDot.style.display = 'none';
		}
	}
	
	function updateActivePage() {
		var urlParams = new URLSearchParams(window.location.search);
		var pageParam = urlParams.get('tx_solr[page]');
		var currentPageNum = pageParam ? parseInt(pageParam) : 1;
		
		// Retirer toutes les classes active existantes
		var allPaginationItems = document.querySelectorAll('.solr-pagination .pagination li');
		allPaginationItems.forEach(function(li) {
			li.classList.remove('active');
			var span = li.querySelector('span');
			if (span && !span.textContent.match(/^[\s\\.]+$/)) {
				var pageText = span.textContent.trim();
				var pageNum = parseInt(pageText);
				if (!isNaN(pageNum)) {
					var link = document.createElement('a');
					link.href = '?tx_solr[page]=' + pageNum;
					link.className = 'solr-ajaxified';
					link.textContent = pageText;
					li.replaceChild(link, span);
				}
			}
		});
		
		// Ajouter la classe active à la page courante
		var paginationLinks = document.querySelectorAll('.solr-pagination .pagination li');
		paginationLinks.forEach(function(li) {
			var element = li.querySelector('a, span');
			if (element) {
				var pageText = element.textContent.trim().replace(/[^\d]/g, '');
				var pageNum = parseInt(pageText);
				if (!isNaN(pageNum) && pageNum === currentPageNum) {
					li.classList.add('active');
					if (element.tagName === 'A') {
						var span = document.createElement('span');
						span.textContent = pageNum;
						li.replaceChild(span, element);
					}
				}
			}
		});
	}
	
	function updatePagination() {
		updatePaginationRange();
		setTimeout(updateActivePage, 50);
	}
	
	function initPagination() {
		// Attendre que le DOM soit prêt
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', function() {
				setTimeout(updatePagination, 50);
			});
		} else {
			setTimeout(updatePagination, 50);
		}
		
		// Écouter les changements AJAX pour Solr
		if (typeof jQuery !== 'undefined') {
			jQuery(document).on('ajaxComplete', function() {
				setTimeout(updatePagination, 100);
			});
		}
		
		// Observer les changements dans le DOM
		var observer = new MutationObserver(function(mutations) {
			updatePagination();
		});
		
		setTimeout(function() {
			var targetNodes = document.querySelectorAll('.solr-pagination');
			targetNodes.forEach(function(targetNode) {
				observer.observe(targetNode, {
					childList: true,
					subtree: true
				});
			});
		}, 200);
	}
	
	initPagination();
})();
