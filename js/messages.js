(function() {
  var container = document.querySelector('.container');
  var stackWrap = document.querySelector('.stack-wrap');
  var contacts = document.querySelector('.contacts');
  var messages = document.querySelector('.messages');
  var small, limiter;

  function relayout() {
    var width = window.innerWidth;
    console.log(width, small);
    if (!small && width < 600) {
      small = true;
      container.classList.add('small-screen');
      stackWrap.appendChild(contacts);
      stackWrap.appendChild(messages);
    } else if (small && width >= 600) {
      small = false;
      container.classList.remove('small-screen');
      container.insertBefore(contacts, stackWrap);
      container.insertBefore(messages, stackWrap);
    }
  }

  window.addEventListener('resize', function() {
    clearTimeout(limiter);
    limiter = setTimeout(relayout, 100);
  });

  relayout();
})();