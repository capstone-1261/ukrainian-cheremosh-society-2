/**
 * Event countdown (single-events.php)
 *
 * Finds the countdown box, reads the start time from its data-start
 * attribute, and updates the days / hours / minutes / seconds every second.
 * Once the event has started it just shows zeros.
 */
(function () {
  var box = document.querySelector('.event-countdown');
  if (!box) {
    return; // Not an event page with a start date, so nothing to do.
  }

  // data-start is a date string like 2027-01-23T19:00:00-07:00
  var start = new Date(box.getAttribute('data-start')).getTime();
  if (isNaN(start)) {
    return;
  }

  // The four number elements, found by their data-unit attribute.
  var days = box.querySelector('[data-unit="days"]');
  var hours = box.querySelector('[data-unit="hours"]');
  var minutes = box.querySelector('[data-unit="minutes"]');
  var seconds = box.querySelector('[data-unit="seconds"]');

  function update() {
    var left = start - Date.now(); // Milliseconds until the event.
    if (left < 0) {
      left = 0; // Event has started.
    }

    var totalSeconds = Math.floor(left / 1000);

    days.textContent = Math.floor(totalSeconds / 86400);
    hours.textContent = Math.floor((totalSeconds % 86400) / 3600);
    minutes.textContent = Math.floor((totalSeconds % 3600) / 60);
    seconds.textContent = totalSeconds % 60;
  }

  update(); // Fill it in straight away.
  setInterval(update, 1000); // Then every second.
})();