/**
 * Dance with Us: program carousel.
 *
 * The cards sit in a row that scrolls sideways (CSS does the scrolling and
 * the snapping). This script only adds the controls:
 *   - arrow buttons that scroll one card at a time
 *   - one dot per card, the current one is a wider pill (click to jump)
 *   - arrows switch off at the ends of the row
 * Swiping on a phone and the arrow keys on the keyboard also work.
 */
( function () {
	var track = document.querySelector( '.dance-programs-track' );
	if ( ! track ) {
		return; // Not the Dance with Us page, or no programs: nothing to do.
	}

	var cards = Array.prototype.slice.call( track.children );
	var dotsBox = document.querySelector( '.dance-programs-dots' );
	var arrows = document.querySelectorAll( '.dance-programs-arrow' );
	var dots = [];

	// Lets keyboard users focus the row and use the left and right arrow keys.
	track.setAttribute( 'tabindex', '0' );
	track.setAttribute( 'aria-label', 'Programs' );

	// How far one step is: a card plus the gap between cards.
	function stepSize() {
		var gap = parseFloat( getComputedStyle( track ).columnGap ) || 0;
		return cards[ 0 ].getBoundingClientRect().width + gap;
	}

	// Which card is closest to the left edge right now.
	function currentIndex() {
		return Math.min( cards.length - 1, Math.max( 0, Math.round( track.scrollLeft / stepSize() ) ) );
	}

	// Build one dot (a button) per card.
	cards.forEach( function ( card, i ) {
		var dot = document.createElement( 'button' );
		dot.type = 'button';
		dot.className = 'dance-programs-dot';
		dot.setAttribute( 'aria-label', 'Show program ' + ( i + 1 ) + ' of ' + cards.length );
		dot.addEventListener( 'click', function () {
			track.scrollTo( { left: i * stepSize(), behavior: 'smooth' } );
		} );
		dotsBox.appendChild( dot );
		dots.push( dot );
	} );

	// Highlight the current dot and switch off an arrow that can't go any further.
	function update() {
		var index = currentIndex();
		var atEnd = track.scrollLeft + track.clientWidth >= track.scrollWidth - 2;

		dots.forEach( function ( dot, i ) {
			if ( i === index ) {
				dot.setAttribute( 'aria-current', 'true' ); // Shown by shape (wider pill), not colour.
			} else {
				dot.removeAttribute( 'aria-current' );
			}
		} );

		arrows[ 0 ].disabled = track.scrollLeft <= 2; // Previous: at the start.
		arrows[ 1 ].disabled = atEnd; // Next: at the end.
	}

	// Arrow buttons scroll one card.
	Array.prototype.forEach.call( arrows, function ( arrow ) {
		arrow.addEventListener( 'click', function () {
			var direction = parseInt( arrow.getAttribute( 'data-direction' ), 10 );
			track.scrollBy( { left: direction * stepSize(), behavior: 'smooth' } );
		} );
	} );

	// Left and right arrow keys while the row is focused.
	track.addEventListener( 'keydown', function ( event ) {
		if ( event.key === 'ArrowRight' ) {
			track.scrollBy( { left: stepSize(), behavior: 'smooth' } );
		} else if ( event.key === 'ArrowLeft' ) {
			track.scrollBy( { left: -stepSize(), behavior: 'smooth' } );
		}
	} );

	track.addEventListener( 'scroll', update );
	window.addEventListener( 'resize', update );
	update();
} )();