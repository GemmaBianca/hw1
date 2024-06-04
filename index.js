let currentIndex = 0;
const images = ["photo/inaugurazione.jpeg", "photo/giuseppe-cacciola.jpeg", "photo/masterclass-wnzel-fuchs.jpeg"];

function showImage(index) {
    const imageContainer = document.getElementById("scorrimento");
    const imageElement = document.createElement("img");
    imageElement.src = images[index];
    imageElement.alt = "Image " + (index + 1);
    imageContainer.innerHTML = '';
    imageContainer.appendChild(imageElement);
}

function nextImage() {
    currentIndex = (currentIndex + 1) % images.length;
    showImage(currentIndex);
}

function previousImage() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    showImage(currentIndex);
}

showImage(currentIndex);
const previousButton = document.getElementById("previous-btn");
const nextButton = document.getElementById("next-btn");

previousButton.addEventListener("click", previousImage);
nextButton.addEventListener("click", nextImage);

document.addEventListener("DOMContentLoaded", function() {
    const linksMostraNascondi = document.querySelectorAll(".mostra-nascondi");

    linksMostraNascondi.forEach(function(link) {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            this.style.display = "none";
            const titoloNascosto = document.createElement('h4');
            const testoNascosto = document.createElement('div');
            titoloNascosto.textContent = "15 Febbraio 2024";
            testoNascosto.textContent = "Decreto di accreditamento dei percorsi di formazione iniziale dei docenti";
            titoloNascosto.classList.add('titolo-nascosto');
            testoNascosto.classList.add('testo-nascosto');
            this.parentNode.appendChild(titoloNascosto); 
            this.parentNode.appendChild(testoNascosto);
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const readButton = document.querySelector('.read');
    
    readButton.addEventListener('click', function() {
      const isRead = readButton.getAttribute('data-read');
      
      if (isRead === 'false') {
        readButton.textContent = 'Letto';
        readButton.setAttribute('data-read', 'true');
      } else {
        readButton.textContent = 'Leggi';
        readButton.setAttribute('data-read', 'false');
      }
    });
});

function GoogleMap() {
  var pos = {lat: 37.5091, lng: 15.0804};
  var map = new google.maps.Map(document.getElementById('map'), {
    center: pos,
    zoom: 14
  })
  var marker = new google.maps.Marker({
      position: conservatorioBellini,
      map: map,
      title: 'Conservatorio Bellini di Catania'
  });
}
