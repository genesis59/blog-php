let idTarget;
let screenSizeLarge;
let screenSizeMedium;
let password;
let confirmPassword;
let buttonRegister;
let errorMessage;
let formRegister;
const errorMessagePassword = "Les mots de passe renseignés sont différents."

function init() {
    initVariables();
    adjustFooter(idTarget, screenSizeLarge, screenSizeMedium);
    buttonRegister?.addEventListener("click",confirm);
}

function initVariables() {
    idTarget = 'footer';
    screenSizeLarge = 992;
    screenSizeMedium = 768;
    password = document.getElementById("password");
    confirmPassword = document.getElementById("confirm_password");
    buttonRegister = document.getElementById("button_form_register");

}
function adjustFooter(idTarget, screenSizeLarge, screenSizeMedium) {
    let target = document.getElementById(idTarget)
    if (document.body.clientWidth >= screenSizeLarge) {
        target.style.height = "170px";
    } else if (document.body.clientWidth >= screenSizeMedium && document.body.clientWidth < screenSizeLarge) {
        target.style.height = "170px";
    } else {
        target.style.height = "220px";
    }
}

window.onload = init;