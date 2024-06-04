const form_book = document.getElementById('form_book');
form_book.addEventListener('submit', searchLibrary);

function searchLibrary(event){
  // Impedisci il submit del form
  event.preventDefault();
  // Leggi valore del campo di testo
  const author_input = document.querySelector('#author');
  const author_value = encodeURIComponent(author_input.value);
  console.log('Eseguo ricerca: ' + author_value);
  // Prepara la richiesta
  rest_url = 'http://openlibrary.org/search.json?author=' + author_value;
  console.log('URL: ' + rest_url);
  // Esegui fetch
  fetch(rest_url).then(onResponseLibrary).then(onJsonLibrary);
}

function onJsonLibrary(json) {
  console.log('JSON ricevuto');
  // Svuotiamo la libreria
  const library = document.querySelector('#library-view');
  library.innerHTML = '';
  // Leggi il numero di risultati
  let num_results = json.num_found;
  // Mostriamone al massimo 10
  if(num_results > 10)
    num_results = 10;
  // Processa ciascun risultato
  for(let i=0; i<num_results; i++){
    // Leggi il documento
    const doc = json.docs[i]
    // Leggiamo info
    const title = doc.title;
    // Controlliamo ISBN
    if(!doc.isbn){
      console.log('ISBN mancante, salto');
      continue;
    }
    const isbn = doc.isbn[0];
    // Costruiamo l'URL della copertina
    const cover_url = 'http://covers.openlibrary.org/b/isbn/' + isbn + '-M.jpg';
    // Creiamo il div che conterrÃ  immagine e didascalia
    const book = document.createElement('div');
    book.classList.add('book');
    // Creiamo l'immagine
    const img = document.createElement('img');
    img.src = cover_url;
    // Creiamo la didascalia
    const caption = document.createElement('span');
    caption.textContent = title;
    // Aggiungiamo immagine e didascalia al div
    book.appendChild(img);
    book.appendChild(caption);
    // Aggiungiamo il div alla libreria
    library.appendChild(book);
  }
}

function onResponseLibrary(response) {
  console.log('Risposta ricevuta');
    return response.json();
}

const form_album = document.getElementById('form_album');
form_album.addEventListener('submit', searchAlbum);

function onJson(json) {
  console.log('JSON ricevuto');
  console.log(json);
  // Svuotiamo la libreria
  const library = document.querySelector('#album-view');
  library.innerHTML = '';
  // Leggi il numero di risultati
  const results = json.albums.items;
  let num_results = results.length;
  // Mostriamone al massimo 10
  if(num_results > 10)
    num_results = 10;
  // Processa ciascun risultato
  for(let i=0; i<num_results; i++)
  {
    // Leggi il documento
    const album_data = results[i]
    // Leggiamo info
    const title = album_data.name;
    const selected_image = album_data.images[0].url;
    // Creiamo il div che conterrà immagine e didascalia
    const album = document.createElement('div');
    album.classList.add('album');
    // Creiamo l'immagine
    const img = document.createElement('img');
    img.src = selected_image;
    // Creiamo la didascalia
    const caption = document.createElement('span');
    caption.textContent = title;
    // Aggiungiamo immagine e didascalia al div
    album.appendChild(img);
    album.appendChild(caption);
    // Aggiungiamo il div alla libreria
    library.appendChild(album);
  }
}

function onResponse(response) {
  console.log('Risposta ricevuta');
  return response.json();
}

function searchAlbum(event){
  // Impedisci il submit del form
  event.preventDefault();
  // Leggi valore del campo di testo
  const album_input = document.querySelector('#album');
  const album_value = encodeURIComponent(album_input.value);
  console.log('Eseguo ricerca: ' + album_value);
  // Esegui la richiesta
  fetch("https://api.spotify.com/v1/search?type=album&q=" + album_value,
    {
      headers:
      {
        'Authorization': 'Bearer ' + token
      }
    }
  ).then(onResponse).then(onJson);
}

function onTokenJson(json)
{
  console.log(json)
  // Imposta il token global
  token = json.access_token;
}

function onTokenResponse(response)
{
  return response.json();
}

// OAuth credentials --- NON SICURO!
const client_id = 'd4c860fba30d49e5ad6cce24a046379b';
const client_secret = '5174c572bd624d8588ce342797b766a4';
// Dichiara variabile token [1]
let token;
// All'apertura della pagina, richiediamo il token
fetch("https://accounts.spotify.com/api/token",
    {
   method: "post",
   body: 'grant_type=client_credentials',
   headers:
   {
    'Content-Type': 'application/x-www-form-urlencoded',
    'Authorization': 'Basic ' + btoa(client_id + ':' + client_secret)
   }
  }
).then(onTokenResponse).then(onTokenJson);
