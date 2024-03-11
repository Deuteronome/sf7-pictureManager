let stickers = document.querySelectorAll('.image-sticker');
let body = document.querySelector('body');

function deleteImage(imageUrl, imageName) {
   
    let deleteMessage = document.createElement('div');
    deleteMessage.classList.add("alert", "alert-danger", "alert-custom", "text-center");
    deleteMessage.innerHTML = `Voulez-vous supprimer l'image "${imageName}"`;

    let delButton = document.createElement('a');
    delButton.href = imageUrl;
    delButton.classList.add('btn', 'btn-danger', 'ms-5');
    delButton.innerHTML = "Supprimer";

    let cancelButton = document.createElement('button');
    cancelButton.classList.add('btn', 'btn-secondary', 'ms-2');
    cancelButton.innerHTML = "Annuler";
    cancelButton.addEventListener('click', ()=>{body.removeChild(deleteMessage)});

    deleteMessage.appendChild(delButton);
    deleteMessage.appendChild(cancelButton);

    body.appendChild(deleteMessage);

}

function copyUrl(imageUrl, imageName){
    
    

    navigator.clipboard.writeText(imageUrl);

    let copyMessage = document.createElement('div');
    copyMessage.classList.add("alert", "alert-success", "alert-custom", "text-center");
    copyMessage.innerHTML = `lien de l'image "${imageName}" copié`;

    let cancelButton = document.createElement('button');
    cancelButton.classList.add('btn', 'btn-secondary', 'ms-5');
    cancelButton.innerHTML = "Fermer";
    cancelButton.addEventListener('click', ()=>{body.removeChild(copyMessage)});

    copyMessage.appendChild(cancelButton);
    body.appendChild(copyMessage);
}

function showPicture(imageUrl, e) {
    
    e.preventDefault();

    let pictureContainer = document.createElement('div');
    pictureContainer.classList.add('picture-container', 'p-0', 'p-lg-5');

    let closeButton = document.createElement('button');
    closeButton.classList.add('close-button', 'btn', 'btn-secondary');
    closeButton.innerHTML = 'Fermer';
    closeButton.addEventListener('click', ()=>{body.removeChild(pictureContainer)});

    let pictureRow = document.createElement('div');
    pictureRow.classList.add('w-100', 'text-center');

    let picture = document.createElement('img');
    picture.setAttribute('src', imageUrl);
    picture.classList.add('img-fluid');

    pictureRow.appendChild(picture);
    pictureContainer.appendChild(pictureRow);
    pictureContainer.appendChild(closeButton);
    body.appendChild(pictureContainer);
}

stickers.forEach((el) => {
    
    el.childNodes[7].childNodes[5].addEventListener('click', deleteImage.bind(null, el.childNodes[3].value, el.childNodes[1].innerHTML));
    el.childNodes[7].childNodes[3].addEventListener('click', copyUrl.bind(null, el.childNodes[7].childNodes[1].href, el.childNodes[1].innerHTML));
    el.childNodes[7].childNodes[1].addEventListener('click', showPicture.bind(null, el.childNodes[7].childNodes[1].href));
})



//console.log(stickers[0].childNodes[1]);