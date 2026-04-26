document.addEventListener('DOMContentLoaded', function () {
  var body = document.body;
  var toggle = document.querySelector('.wash-toggle');

  function applyState(enabled) {
    body.dataset.washEnabled = enabled ? 'true' : 'false';
    body.classList.toggle('wash-enabled', enabled);
    localStorage.setItem('washEnabled', enabled ? 'true' : 'false');

    if (toggle) {
      toggle.textContent = enabled ? 'Animierter Hintergrund aus' : 'Animierter Hintergrund an';
    }

    if (enabled) {
      if (window.__initWash) {
        window.__initWash();
      }
      requestAnimationFrame(function () {
        window.dispatchEvent(new Event('resize'));
      });
    } else if (window.__stopWash) {
      window.__stopWash();
    }
  }

  var storedValue = localStorage.getItem('washEnabled');
  var initialEnabled = storedValue === null ? true : storedValue === 'true';

  applyState(initialEnabled);

  if (toggle) {
    toggle.addEventListener('click', function () {
      applyState(body.dataset.washEnabled !== 'true');
    });
  }
});
