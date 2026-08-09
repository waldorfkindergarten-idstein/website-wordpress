/**
 * Waldorf Pfirsichblüte — progressive enhancements.
 *
 * Everything here is optional polish: the page is fully readable and navigable
 * without it. No dependencies, no jQuery.
 */

( function () {
	'use strict';

	var reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/* ---------------------------------------------------------------
	 * Sticky header shrinks once the page scrolls
	 * ------------------------------------------------------------ */
	var header = document.querySelector( '.pb-header' );

	/* ---------------------------------------------------------------
	 * Back-to-top button
	 * ------------------------------------------------------------ */
	var toTop = document.querySelector( '.pb-totop' );

	if ( header || toTop ) {
		var ticking = false;

		var onScroll = function () {
			if ( ticking ) {
				return;
			}
			ticking = true;

			window.requestAnimationFrame( function () {
				var y = window.scrollY;

				if ( header ) {
					header.classList.toggle( 'is-scrolled', y > 20 );
				}

				if ( toTop ) {
					toTop.classList.toggle( 'is-visible', y > 700 );
				}

				ticking = false;
			} );
		};

		window.addEventListener( 'scroll', onScroll, { passive: true } );
		onScroll();
	}

	if ( toTop ) {
		toTop.addEventListener( 'click', function () {
			window.scrollTo( {
				top: 0,
				behavior: reduceMotion ? 'auto' : 'smooth'
			} );
		} );
	}

	/* ---------------------------------------------------------------
	 * Reveal sections as they enter the viewport
	 * ------------------------------------------------------------ */
	var revealables = document.querySelectorAll( '.pb-reveal' );

	if ( ! revealables.length ) {
		return;
	}

	if ( reduceMotion || ! ( 'IntersectionObserver' in window ) ) {
		revealables.forEach( function ( el ) {
			el.classList.add( 'is-in' );
		} );
		return;
	}

	var observer = new IntersectionObserver(
		function ( entries ) {
			entries.forEach( function ( entry ) {
				if ( ! entry.isIntersecting ) {
					return;
				}
				entry.target.classList.add( 'is-in' );
				observer.unobserve( entry.target );
			} );
		},
		{ rootMargin: '0px 0px -10% 0px', threshold: 0.08 }
	);

	revealables.forEach( function ( el ) {
		observer.observe( el );
	} );
}() );
