let idTarget;
let screenSizeLarge;
let screenSizeMedium;

function init() {
    initVariables();
    adjustFooter(idTarget, screenSizeLarge, screenSizeMedium);
}
function initVariables() {
    idTarget = 'footer';
    screenSizeLarge = 992;
    screenSizeMedium = 768;

}
function adjustFooter(idTarget, screenSizeLarge, screenSizeMedium) {
    let target = document.getElementById(idTarget)
    if (document.body.clientWidth >= screenSizeLarge) {
        target.style.height = "140px";
    } else if (document.body.clientWidth >= screenSizeMedium && document.body.clientWidth < screenSizeLarge) {
        target.style.height = "170px";
    } else {
        target.style.height = "220px";
    }
}
window.onload = init;