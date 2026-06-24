/**
 * Open Awards — Advanced Search modal controller (vanilla JS, no jQuery).
 *
 * Responsibilities:
 *   - Toggle the search modal open/closed from the header icon.
 *   - Fire a debounced AJAX request to the secure `oa_live_search` endpoint
 *     as the user types, and render live results.
 *   - On submit / Enter, redirect to the native search.php results page
 *     (?s=...) so there is always a robust, shareable, paginated fallback.
 *
 * All endpoint/nonce/config data arrives via the localized `OA_SEARCH` object
 * (see oa_search_enqueue_assets() in includes/search.php).
 */
(function () {
	'use strict';

	// Bail early if the localized config is missing.
	if (typeof OA_SEARCH === 'undefined') {
		return;
	}

	var modal, input, resultsBox, form;
	var lastController = null; // AbortController for the in-flight request.
	var lastTrigger = null;    // Element to refocus when the modal closes.

	/**
	 * Debounce: delay calling `fn` until `wait` ms have passed since the last
	 * call. Protects the server from a request on every keystroke.
	 *
	 * @param {Function} fn   The function to debounce.
	 * @param {number}   wait Delay in milliseconds.
	 * @returns {Function}
	 */
	function debounce(fn, wait) {
		var timer;
		return function () {
			var context = this;
			var args = arguments;
			clearTimeout(timer);
			timer = setTimeout(function () {
				fn.apply(context, args);
			}, wait);
		};
	}

	/**
	 * Open the modal and focus the input.
	 *
	 * @param {Event} [e]
	 */
	function openModal(e) {
		if (e) {
			e.preventDefault();
			lastTrigger = e.currentTarget;
		}
		modal.classList.add('is-open');
		modal.setAttribute('aria-hidden', 'false');
		document.body.classList.add('oa-search-open');
		// Defer focus until the open transition has started.
		window.setTimeout(function () {
			input.focus();
		}, 50);
		document.addEventListener('keydown', onKeydown);
	}

	/**
	 * Close the modal, abort any pending request and restore focus.
	 */
	function closeModal() {
		modal.classList.remove('is-open');
		modal.setAttribute('aria-hidden', 'true');
		document.body.classList.remove('oa-search-open');
		document.removeEventListener('keydown', onKeydown);
		if (lastController) {
			lastController.abort();
			lastController = null;
		}
		if (lastTrigger) {
			lastTrigger.focus();
		}
	}

	/**
	 * Close the modal on Escape.
	 *
	 * @param {KeyboardEvent} e
	 */
	function onKeydown(e) {
		if (e.key === 'Escape') {
			closeModal();
		}
	}

	/**
	 * Render a simple status message (searching / no results / prompt).
	 *
	 * @param {string} message
	 * @param {string} modifier Extra CSS modifier class suffix.
	 */
	function renderStatus(message, modifier) {
		resultsBox.innerHTML =
			'<p class="oa-search-results__status oa-search-results__status--' +
			(modifier || 'info') +
			'">' +
			message +
			'</p>';
	}

	/**
	 * Redirect to the native search results page carrying the query.
	 *
	 * @param {string} term
	 */
	function gotoResultsPage(term) {
		if (!term) {
			return;
		}
		var url =
			OA_SEARCH.resultsUrl +
			(OA_SEARCH.resultsUrl.indexOf('?') === -1 ? '?' : '&') +
			's=' +
			encodeURIComponent(term);
		window.location.href = url;
	}

	/**
	 * Perform the live AJAX search and render the results into the modal.
	 *
	 * @param {string} term Current search term.
	 */
	function liveSearch(term) {
		term = term.trim();

		if (term.length < OA_SEARCH.minChars) {
			renderStatus(OA_SEARCH.i18n.typeMore, 'info');
			input.setAttribute('aria-expanded', 'false');
			return;
		}

		renderStatus(OA_SEARCH.i18n.searching, 'loading');

		// Abort any previous request so out-of-order responses can't clobber
		// the latest results.
		if (lastController) {
			lastController.abort();
		}
		lastController = new AbortController();

		var body = new URLSearchParams();
		body.append('action', OA_SEARCH.action);
		body.append('nonce', OA_SEARCH.nonce);
		body.append('s', term);

		fetch(OA_SEARCH.ajaxUrl, {
			method: 'POST',
			credentials: 'same-origin',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: body.toString(),
			signal: lastController.signal,
		})
			.then(function (response) {
				return response.json();
			})
			.then(function (json) {
				if (!json || !json.success) {
					renderStatus(OA_SEARCH.i18n.noResults, 'empty');
					return;
				}

				var data = json.data;

				if (!data.count) {
					renderStatus(OA_SEARCH.i18n.noResults, 'empty');
					input.setAttribute('aria-expanded', 'false');
					return;
				}

				var html = data.html;

				// Append a "view all" footer linking to the full results page.
				html +=
					'<a class="oa-search-results__viewall" href="' +
					data.viewAllUrl +
					'">' +
					OA_SEARCH.i18n.viewAll +
					' (' +
					data.count +
					')</a>';

				resultsBox.innerHTML = html;
				input.setAttribute('aria-expanded', 'true');
			})
			.catch(function (error) {
				// Ignore deliberate aborts; surface anything else gracefully.
				if (error && error.name === 'AbortError') {
					return;
				}
				renderStatus(OA_SEARCH.i18n.noResults, 'empty');
			});
	}

	/**
	 * Wire up all event listeners once the DOM is ready.
	 */
	function init() {
		modal = document.getElementById('oaSearchModal');
		if (!modal) {
			return;
		}
		input = document.getElementById('oaSearchInput');
		resultsBox = document.getElementById('oaSearchResults');
		form = modal.querySelector('.oa-search-modal__form');

		// Open triggers (header icon, or anything with the data attribute).
		document.querySelectorAll('[data-oa-search-open]').forEach(function (el) {
			el.addEventListener('click', openModal);
		});

		// Close triggers (backdrop + close button).
		modal.querySelectorAll('[data-oa-search-close]').forEach(function (el) {
			el.addEventListener('click', closeModal);
		});

		// Debounced live search on input.
		var debounced = debounce(function () {
			liveSearch(input.value);
		}, OA_SEARCH.debounce);
		input.addEventListener('input', debounced);

		// Submit / Enter -> native results page.
		form.addEventListener('submit', function (e) {
			e.preventDefault();
			gotoResultsPage(input.value.trim());
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
