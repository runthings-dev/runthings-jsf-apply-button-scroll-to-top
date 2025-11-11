(function() {
	console.log('[JsfApplyButtonScrollToTop] Script loaded');

	// Find all apply buttons
	var buttons = document.querySelectorAll('.apply-filters__button');
	console.log('[JsfApplyButtonScrollToTop] Found ' + buttons.length + ' apply buttons');

	buttons.forEach(function(btn) {
		console.log('[JsfApplyButtonScrollToTop] Adding click handler to button');
		btn.addEventListener('click', function() {
			console.log('[JsfApplyButtonScrollToTop] Apply button clicked, scrolling to top');
			window.scrollTo({
				top: 0,
				behavior: 'smooth'
			});
		});
	});
})();

