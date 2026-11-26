/**
 * Camp Registration: shows the success pop-up after a good submit.
 * Fluent Forms adds a success message to the form; we hide it and open the modal.
 */
document.addEventListener( 'DOMContentLoaded', function () {
	let modal = document.getElementById( 'camp-modal' );
	let form  = document.querySelector( '.camp-reg-fluent' );

	if ( ! modal || ! form ) {
		return;
	}

	let closeButton = modal.querySelector( '.camp-modal-close' );
	let loginButton = modal.querySelector( '.camp-modal-button' );
	let lastFocus   = null;

	function openModal() {
		lastFocus = document.activeElement;
		modal.hidden = false;
		document.body.classList.add( 'camp-modal-open' );
		loginButton.focus();
	}

	function closeModal() {
		modal.hidden = true;
		document.body.classList.remove( 'camp-modal-open' );
		if ( lastFocus ) {
			lastFocus.focus();
		}
	}

	closeButton.addEventListener( 'click', closeModal );

	// Clicking the dark area outside the box closes it.
	modal.addEventListener( 'click', function ( event ) {
		if ( event.target === modal ) {
			closeModal();
		}
	} );

	// Escape closes it.
	document.addEventListener( 'keydown', function ( event ) {
		if ( event.key === 'Escape' && ! modal.hidden ) {
			closeModal();
		}
	} );

		// Watch the whole page for Fluent's success message, hide it, and open the modal.
	let observer = new MutationObserver( function () {
		let message = document.querySelector( '.ff-message-success' );

		if ( message && ! message.hidden ) {
			message.hidden = true;
			openModal();
		}
	} );

	observer.observe( document.body, { childList: true, subtree: true } );
} );