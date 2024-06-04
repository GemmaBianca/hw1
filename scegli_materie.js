document.getElementById("saveButton").addEventListener("click", saveSelectedSubjects);

function saveSelectedSubjects(event) {
    console.log("Salvataggio");
    const formData = new FormData();
    const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    checkboxes.forEach((checkbox) => {
        formData.append('materie[]', checkbox.value);
    });
    fetch("save_scelta.php", {method: 'post', body: formData}).then(dispatchResponse, dispatchError);
}

function dispatchResponse(response) {  
    console.log(response);
    return response.json().then(databaseResponse); 
}
  
function dispatchError(error) { 
    console.log("Errore");
}
  
function databaseResponse(json) {
    if (!json.ok) {
        dispatchError();
        return null;
    }
}
