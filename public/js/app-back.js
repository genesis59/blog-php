// modal page comments
const modalContainer = document.querySelector(".modal-container");
const modalTriggers = document.querySelectorAll(".modal-trigger");
const modalTitleText = document?.getElementById("modal-title-text");
const modalQuestionText = document?.getElementById("modal-question-text");
const buttonSubmit = document?.getElementById("button-submit");
const inputHiddenTypeAction = document?.getElementById("typeAction");

modalTriggers.forEach(trigger => trigger.addEventListener("click",toggleModal));
buttonSubmit?.addEventListener("click",launchForm)

function toggleModal(e){
    e.preventDefault();
    if(e.target.name === "accept"){
        modalTitleText.innerText = "Validation";
        modalQuestionText.innerText = "Voulez-vous vraiment accepter ce commentaire?";
    }
    if(e.target.name === "delete"){
        modalTitleText.innerText = "Suppression";
        modalQuestionText.innerText = "Voulez-vous vraiment supprimer ce commentaire?";
    }
    if(e.target.name === "deleteUser"){
        modalTitleText.innerText = "Suppression";
        modalQuestionText.innerText = "Voulez-vous vraiment supprimer cet utilisateur?";
    }
    if(e.target.name === "deleteArticle"){
        modalTitleText.innerText = "Suppression";
        modalQuestionText.innerText = "Voulez-vous vraiment supprimer cet article?";
    }
    buttonSubmit.name = "id";
    buttonSubmit.value = e.target.value;
    inputHiddenTypeAction.value = e.target.name;
    modalContainer.classList.toggle("active")
}

function launchForm(){
    document.forms["formModal"].submit()
}

function submitFormChangeRole(id){
    document.forms["form-change-role" + id].submit()
}