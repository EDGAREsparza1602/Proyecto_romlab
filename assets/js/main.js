document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById('menu-toggle');
    const menu = document.querySelector('.menu');
    const overlay = document.getElementById('menu-overlay');

    toggle.addEventListener('click', () => {
        toggle.classList.toggle('open');
        menu.classList.toggle('active');
        overlay.classList.toggle('active');
        document.body.classList.toggle('menu-open');
    });

    overlay.addEventListener('click', () => {
        toggle.classList.remove('open');
        menu.classList.remove('active');
        overlay.classList.remove('active');
        document.body.classList.remove('menu-open');
    });
});

const timeline = document.getElementById("timeline");

timeline.addEventListener("mousemove", (e) => {
  const bounds = timeline.getBoundingClientRect();
  const mouseX = e.clientX - bounds.left; // Posición del mouse dentro del timeline
  const percent = mouseX / bounds.width; // Porcentaje desde el borde izquierdo
  const scrollAmount = timeline.scrollWidth - timeline.clientWidth;

  timeline.scrollLeft = scrollAmount * percent;
});
function smoothScroll() {
  // Mueve el scroll actual un poco hacia targetScrollLeft
  timeline.scrollLeft += (targetScrollLeft - timeline.scrollLeft) * 0.1; // 0.1 es la "suavidad"
  requestAnimationFrame(smoothScroll);
}

smoothScroll();