// Usamos el ID del contenedor principal para el flip
const productDisplay = document.getElementById('productDisplay');
const miCard = document.getElementById('miCard'); // Sigue siendo útil para la elevación

const btnShowDetails = document.querySelector('.btn-show-details');
const btnShowCard = document.querySelector('.btn-show-card');

// Lógica de elevación de la tarjeta al pasar el ratón
// Esto ahora aplica a la única tarjeta, que es la misma para escritorio y móvil
if (miCard) {
    miCard.addEventListener('mouseenter', () => {
        // Solo aplica la elevación si no estamos en modo flip (móvil)
        // Opcional: Puedes decidir si quieres elevación en el flip card
        if (window.innerWidth > 768 || !productDisplay.classList.contains('flipped')) {
            miCard.classList.add('card-elevate');
        }
    });

    miCard.addEventListener('mouseleave', () => {
        miCard.classList.remove('card-elevate');
    });
}

// Lógica para el volteo de la tarjeta solo en móvil
function toggleFlipCard() {
    if (window.innerWidth <= 768) {
        productDisplay.classList.toggle('flipped'); // Ahora se voltea el contenedor principal
    }
}

if (btnShowDetails) {
    btnShowDetails.addEventListener('click', toggleFlipCard);
}

if (btnShowCard) {
    btnShowCard.addEventListener('click', toggleFlipCard);
}

// Asegurarse de que el estado de volteo se reinicie si se redimensiona a escritorio
window.addEventListener('resize', () => {
    if (window.innerWidth > 768 && productDisplay.classList.contains('flipped')) {
        productDisplay.classList.remove('flipped');
    }
});