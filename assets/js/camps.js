document.addEventListener( 'DOMContentLoaded', function () {
    let track = document.querySelector( '.camps-track' );
    if ( ! track ) {
        return;
    }

    let cards = track.querySelectorAll( '.camps-card' );
    let dots  = document.querySelectorAll( '.camps-dot' );
    let prev  = document.querySelector( '.camps-prev' );
    let next  = document.querySelector( '.camps-next' );

    // Distance from one card to the next: card width plus the gap between them.
    function step() {
        return cards[0].offsetWidth + ( parseFloat( getComputedStyle( track ).columnGap ) || 0 );
    }

    // Which card is at the left edge, or the last card when the row is scrolled to the end.
    function currentIndex() {
        if ( track.scrollLeft + track.clientWidth >= track.scrollWidth - 2 ) {
            return cards.length - 1;
        }
        return Math.min( cards.length - 1, Math.round( track.scrollLeft / step() ) );
    }

    // Move aria-current to the dot for the given card.
    function setActive( index ) {
        dots.forEach( function ( dot, n ) {
            if ( n === index ) {
                dot.setAttribute( 'aria-current', 'true' );
            } else {
                dot.removeAttribute( 'aria-current' );
            }
        } );
    }

    track.addEventListener( 'scroll', function () {
        setActive( currentIndex() );
    }, { passive: true } );

    dots.forEach( function ( dot, i ) {
        dot.addEventListener( 'click', function () {
            track.scrollTo( { left: i * step(), behavior: 'smooth' } );
        } );
    } );

    if ( prev ) {
        prev.addEventListener( 'click', function () {
            track.scrollBy( { left: -step(), behavior: 'smooth' } );
        } );
    }

    if ( next ) {
        next.addEventListener( 'click', function () {
            track.scrollBy( { left: step(), behavior: 'smooth' } );
        } );
    }

    setActive( currentIndex() );
} );