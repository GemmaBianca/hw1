function replaceDivs() {
    // Seleziona tutti i div con la classe 'replaceable'
    const divsToReplace = document.querySelectorAll('.replaceable');
    
    // Seleziona il container principale
    const container = document.querySelector('.container');
    
    // Rimuovi tutti i div con la classe 'replaceable'
    divsToReplace.forEach(div => div.remove());
    
    // Aggiungi nuovi div con altro testo
    const newDivsContent = [
        'Nuovo testo 1',
        'Nuovo testo 2',
        'Nuovo testo 3'
    ];

    newDivsContent.forEach(text => {
        const newDiv = document.createElement('div');
        newDiv.className = 'new-div';
        newDiv.textContent = text;
        container.appendChild(newDiv);
    });
}
