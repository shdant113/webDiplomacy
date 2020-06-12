// load bot section if webDip
window.onload = function() {
    if (document.getElementsByClassName("game-create-bothuman")[0]) {
        document.getElementsByClassName("game-create-bothuman")[0].style.display = "block";
    } else {
        document.getElementsByClassName("game-create-private")[0].style.display = "block";
    }
}

// when user leaves page, remove all relevant keys from storage. Do not remove dark mode or desktop mode keys
window.onbeforeunload = function() {
    localStorage.removeItem("passwordProtected");
    localStorage.removeItem("1v1");
    localStorage.removeItem("Unranked");
}

// show next form
function showNext(hide, show) {
    document.getElementsByClassName(hide)[0].style.display = "none";
    document.getElementsByClassName(show)[0].style.display = "block";
}

// go back to last form
function goBack(hide, show, removeKeys) {
    // remove any keys in array passed in
    for (let i = 0; i < removeKeys.length; i++) {
        localStorage.removeItem(removeKeys[i]);
    }
}

// reset form
function reset(current) {
    localStorage.removeItem("passwordProtected");
    localStorage.removeItem("1v1");
    localStorage.removeItem("Unranked");
    if (document.getElementsByClassName("game-create-bothuman")[0]) {
        document.getElementsByClassName("game-create-bothuman")[0].style.display = "block";
    } else {
        document.getElementsByClassName("game-create-private")[0].style.display = "block";
    }
    document.getElementsByClassName(current)[0].style.display = "none";
}

// set keys for reference
function setStorageKey(value) {
    if (value == "private") {
        localStorage.setItem("passwordProtected", "true");
    }
    if (value == "1v1") {
        localStorage.setItem("1v1", "true");
    }
    if (value == "unranked") {
        localStorage.setItem("Unranked", "true");
    }
}

// check if user is playing 1v1 variant
function check1v1() {
    if (document.getElementById("variant").value == 15 || document.getElementById("variant").value == 23) {
        // if 1v1, set key, skip scoring/bet and show phase length
        setStorageKey("1v1");
        showNext("game-create-variant", "game-create-phase-info");
    } else {
        showNext("game-create-variant", "game-create-scoring");
    }
}

// check if user is playing an unranked game
function checkScoring() {
    if (document.getElementById("scoring").value == "Unranked") {
        // if unranked, set key, skip bet
        setStorageKey("unranked");
        showNext('game-create-scoring', 'game-create-phase-info');
    } else {
        showNext('game-create-scoring', 'game-create-bet');
    }
}

// check if user wants a phase length switch in a live game or not
function checkPhaseSwitch() {
    if (document.getElementById("selectPhaseSwitchPeriod").value == -1) {
        showNext("game-create-phase-switch", "game-create-time-fill");
    } else {
        showNext("game-create-phase-switch", "game-create-next-phase");
    }
}

function checkPressType() {
    if (document.getElementById("pressType").value == "NoPress") {
        showNext("game-create-messaging", "game-create-draw-type");
    } else {
        showNext("game-create-messaging", "game-create-anon");
    }
}

// this will have to get fixed to match the wizard once it is live
function setBotFill() {
    var content = document.getElementById("botFill");
    var ePress = document.getElementById("pressType");
    var pressType = ePress.options[ePress.selectedIndex].value;
    var eVariant = document.getElementById("variant");
    var variant = eVariant.options[eVariant.selectedIndex].value;

    if (pressType == "NoPress" && variant == 1) {
        content.style.display = "block";
    } else {
        content.style.display = "none";
        document.getElementById("botBox").checked = false;
    }
}

function checkForSubmitIfPrivateGame() {
    showNext("game-create-draw-type", "game-create-rr-cds");
    // if private game
    if (localStorage.getItem("passwordProtected") == "true") {
        // show create game button
        showNext("", "game-create-submit");
    } else {
        // show submit to move to next section
        showNext("", "game-create-buttons");
    }
}