/**
 * Hero video controls 
 * 
 * Adds a Pause/Play button to any Cover block that uses a background video.
 * Required for accessibility: WCAG 2.2.2 (Pause, Stop, Hide) says moving content that starts by itself and lasts more than 5 seconds must be pauseable.
 * 
 * Also respects the visitor's "reduce motion" setting: if it is on, the video does not play automatically ( the visitor can still press Play).
 * 
 * Works on any page, so if the client switches the hero photo to a video in the editor, the button appears automatically.
 * No button is added for photos.
 */
document.addEventListener('DOMContentLoaded', () => {
    // Every background video WordPress outputs inside a Cover block.
    const videos = document.querySelectorAll( '.wp-block-cover__video-background' );

    // true if visitor has asked their device to reduce motion.
    const reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

    videos.forEach( ( video) => {
        // Create a real <button> so it works with keyboard and screen readers.
        const button = document.createElement( 'button' );
        button.type = 'button';
        button.className = 'hero-video-toggle'; // Styled later in CSS.

        // Update the button text to match what the video is doing.
        const updateLabel = () => {
            button.textContent = video.paused ? 'Play video' : 'Pause video';
        };

        // Reduce motion: stop autoplay before it starts.
        if ( reduceMotion ) {
            video.removeAttribute( 'autoplay' );
            video.pause();
        }

        // Toggle play/pause on click.
        // (Enter and space work automatically on a <button>.)
        button.addEventListener( 'click', () => {
            if ( video.paused ) {
                video.play();
            } else {
                video.pause();
            }
        } );

        // Keep the label correct however the video starts or stops.
        video.addEventListener( 'play', updateLabel );
        video.addEventListener( 'pause', updateLabel );

        // Starting label: if autoplay is still on, the video is about to play.
        button.textContent = reduceMotion ? 'Play video' : 'Pause video';

        // Put the button inside the hero (positioned with CSS later).
        video.closest( '.wp-block-cover' ).appendChild( button );
    } );
} );