// Opens and closes each FAQ row. Several rows can be open at once.
document.addEventListener( 'DOMContentLoaded', function () {
    document.querySelectorAll( '.camps-faq-question button' ).forEach( function ( button ) {
        button.addEventListener( 'click', function () {
            let item   = button.closest( '.camps-faq-item' );
            let panel  = document.getElementById( button.getAttribute( 'aria-controls' ) );
            let isOpen = button.getAttribute( 'aria-expanded' ) === 'true';

            button.setAttribute( 'aria-expanded', isOpen ? 'false' : 'true' );
            item.classList.toggle( 'is-open', ! isOpen );

            // inert hides the closed answer from keyboard and screen readers
            panel.inert = isOpen;
        } );
    } );
} );