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