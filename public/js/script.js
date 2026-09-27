document.addEventListener('DOMContentLoaded', () => {
  const menuToggle = document.getElementById('menuToggle');
  const navLinks = document.getElementById('navLinks');
  const toggleIcon = document.getElementById('toggleIcon');

  // Toggle Navigation Menu on Mobile View
  menuToggle.addEventListener('click', () => {
    navLinks.classList.toggle('active');

    if (navLinks.classList.contains('active')) {
      toggleIcon.textContent = 'close';
    } else {
      toggleIcon.textContent = 'menu';
    }
  });

  // Close Mobile Menu when clicking outside
  document.addEventListener('click', (event) => {
    if (!menuToggle.contains(event.target) && !navLinks.contains(event.target)) {
      navLinks.classList.remove('active');
      toggleIcon.textContent = 'menu';
    }
  });
});