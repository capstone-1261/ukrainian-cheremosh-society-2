/**
 * Mobile menu
 *
 * Opens and closes the main menu on small screens.
 *
 * The button itself lives in header.php. This file only changes state —
 * all the showing and hiding is done in main.css, which reacts to:
 *   - aria-expanded="true" on the button
 *   - the .is-open class on the <nav>
 *   - the .menu-is-open class on <body> (stops the page scrolling behind the menu)
 *
 * Accessibility notes:
 * - aria-expanded is the real state. Screen readers announce it changing,
 *   so it isn't decoration — keeping it correct is the whole job.
 * - Escape closes the menu and puts focus back on the button, so keyboard
 *   users aren't stranded inside a closed menu.
 * - Tapping a link closes the menu, which is what people expect on a phone.
 * - If the window is widened to desktop while the menu is open, we reset it,
 *   otherwise the desktop menu can get stuck in a half-open state.
 */
document.addEventListener( 'DOMContentLoaded', () => {

	const toggle = document.querySelector( '.menu-toggle' );
	const nav    = document.querySelector( '.main-navigation' );

	// If either is missing (e.g. no menu assigned in Appearance > Menus),
	// stop here rather than throwing errors on every page.
	if ( ! toggle || ! nav ) {
		return;
	}

	// Matches the breakpoint in main.css. Keep the two in step if it changes.
	const isDesktop = window.matchMedia( '(min-width: 1024px)' );

	// Reads the current state straight off the button, so the button's
	// aria-expanded is the single source of truth rather than a variable
	// that could drift out of sync with it.
	const isOpen = () => toggle.getAttribute( 'aria-expanded' ) === 'true';

	// One function does all the state changes, so the three places that
	// close the menu can't accidentally do it differently.
	const setOpen = ( open ) => {
		toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
		nav.classList.toggle( 'is-open', open );
		document.body.classList.toggle( 'menu-is-open', open );
	};

	// The button itself.
	toggle.addEventListener( 'click', () => {
		setOpen( ! isOpen() );
	} );

	// Escape closes it and returns focus to the button.
	document.addEventListener( 'keydown', ( event ) => {
		if ( event.key === 'Escape' && isOpen() ) {
			setOpen( false );
			toggle.focus();
		}
	} );

	// Tapping any link inside the menu closes it.
	// closest() catches clicks on anything inside the link too.
	nav.addEventListener( 'click', ( event ) => {
		if ( event.target.closest( 'a' ) && isOpen() ) {
			setOpen( false );
		}
	} );

	// Widening to desktop resets everything.
	isDesktop.addEventListener( 'change', ( event ) => {
		if ( event.matches ) {
			setOpen( false );
		}
	} );
} );