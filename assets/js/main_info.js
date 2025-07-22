// Usamos el ID del contenedor principal para el flip
const productDisplay = document.getElementById('productDisplay');
const miCard = document.getElementById('miCard'); // Sigue siendo �til para la elevaci�n

const btnShowDetails = document.querySelector('.btn-show-details');
const btnShowCard = document.querySelector('.btn-show-card');

// L�gica de elevaci�n de la tarjeta al pasar el rat�n
// Esto ahora aplica a la �nica tarjeta, que es la misma para escritorio y m�vil
if (miCard) {
    miCard.addEventListener('mouseenter', () => {
        // Solo aplica la elevaci�n si no estamos en modo flip (m�vil)
        // Opcional: Puedes decidir si quieres elevaci�n en el flip card
        if (window.innerWidth > 768 || !productDisplay.classList.contains('flipped')) {
            miCard.classList.add('card-elevate');
        }
    });

    miCard.addEventListener('mouseleave', () => {
        miCard.classList.remove('card-elevate');
    });
}

// L�gica para el volteo de la tarjeta solo en m�vil
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