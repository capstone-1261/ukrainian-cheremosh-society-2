/**
 * Single product photo gallery
 *
 * Clicking a small photo under the big one swaps the big photo.
 * Markup: template-parts/product-single.php
 */
(function () {
  // The gallery box. If this page has no gallery, stop here.
  var gallery = document.querySelector('[data-product-gallery]');
  if (!gallery) {
    return;
  }

  var main = gallery.querySelector('[data-product-main]'); // The big photo.
  var thumbs = gallery.querySelectorAll('.product-thumb'); // The small photos (buttons).

  // A product with only one photo has no small photos, so nothing to do.
  if (!main || !thumbs.length) {
    return;
  }

  for (var i = 0; i < thumbs.length; i++) {
    thumbs[i].addEventListener('click', function () {
      // WooCommerce gives the big photo a srcset (several sizes). Remove it,
      // otherwise the browser keeps showing the old photo.
      main.removeAttribute('srcset');
      main.removeAttribute('sizes');

      main.src = this.getAttribute('data-full');
      main.alt = this.getAttribute('data-alt') || '';
    });
  }
})();