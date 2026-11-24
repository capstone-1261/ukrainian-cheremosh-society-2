/**
 * Homepage shop slider
 *
 * Makes the arrows and dots under the product row work.
 * The row itself is plain CSS scrolling (see .home-shop-track in main.css);
 * this script only adds the buttons on top of it.
 */
(function () {
  // The slider box from front-page.php. If this page has no slider, stop here.
  var slider = document.querySelector('[data-shop-slider]');
  if (!slider) {
    return;
  }

  var track = slider.querySelector('[data-shop-track]'); // The scrolling row of cards.
  var dotsBox = slider.querySelector('[data-shop-dots]'); // Where the dots go.
  var prev = slider.querySelector('[data-shop-prev]'); // Left arrow.
  var next = slider.querySelector('[data-shop-next]'); // Right arrow.
  var controls = slider.querySelector('.home-shop-controls'); // Dots and arrows together.
  var items = track.children; // The product cards.

  // People who asked their device for less motion get an instant jump instead of a glide.
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var behavior = reduceMotion ? 'auto' : 'smooth';

  // How far one card is from the next (card width plus the gap between them).
  function stepSize() {
    if (items.length < 2) {
      return track.clientWidth;
    }
    return items[1].offsetLeft - items[0].offsetLeft;
  }

  // Which card is at the left edge right now (0 = first).
  function currentIndex() {
    return Math.round(track.scrollLeft / stepSize());
  }

  // Make one dot per product.
  var dots = [];
  for (var i = 0; i < items.length; i++) {
    var dot = document.createElement('button');
    dot.type = 'button';
    dot.className = 'home-shop-dot';
    dot.setAttribute('aria-label', 'Show product ' + (i + 1) + ' of ' + items.length);
    // Clicking a dot scrolls to that card. The extra function keeps each dot's own number.
    dot.addEventListener('click', (function (index) {
      return function () {
        track.scrollTo({ left: index * stepSize(), behavior: behavior });
      };
    })(i));
    dotsBox.appendChild(dot);
    dots.push(dot);
  }

  // Highlight the right dot and grey out an arrow that has nowhere to go.
  function update() {
    var atStart = track.scrollLeft <= 1;
    var atEnd = track.scrollLeft + track.clientWidth >= track.scrollWidth - 1;

    // At the very end of the row, light up the last dot (the row can't scroll any further).
    var index = atEnd ? items.length - 1 : Math.min(currentIndex(), items.length - 1);

    for (var d = 0; d < dots.length; d++) {
      if (d === index) {
        dots[d].setAttribute('aria-current', 'true');
      } else {
        dots[d].removeAttribute('aria-current');
      }
    }

    prev.disabled = atStart;
    next.disabled = atEnd;

    // If every card already fits on screen, there is nothing to slide: hide the controls.
    controls.hidden = track.scrollWidth <= track.clientWidth + 1;
  }

  // Arrows move one card at a time.
  prev.addEventListener('click', function () {
    track.scrollBy({ left: -stepSize(), behavior: behavior });
  });
  next.addEventListener('click', function () {
    track.scrollBy({ left: stepSize(), behavior: behavior });
  });

  // Keep the dots and arrows in step when the row scrolls (arrows, swipe, mouse wheel)
  // or when the window changes size.
  track.addEventListener('scroll', update, { passive: true });
  window.addEventListener('resize', update);

  update();
})();