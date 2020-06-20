/*
    Copyright (C) 2004-2020 Kestas J. Kuliukas

	This file is part of webDiplomacy.

    webDiplomacy is free software: you can redistribute it and/or modify
    it under the terms of the GNU Affero General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    webDiplomacy is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU Affero General Public License
    along with webDiplomacy.  If not, see <http://www.gnu.org/licenses/>.
 */

/* *********************
    Global variables are accessible for reference throughout game creation wizard
********************* */

// array of all components visited in order shown
var roadmap = [""];

// boolean determining if invite code input is required for private games
var private = false;

/* ****************** */

window.onload = function() {
    load();
} 

// load bot section if exists
function load() {
    if (document.getElementsByClassName("game-create-bothuman")[0]) {
        document.getElementsByClassName("game-create-bothuman")[0].style.display = "block";
        roadmap = ["game-create-bothuman"];
    } else {
        document.getElementsByClassName("game-create-private")[0].style.display = "block";
        roadmap = ["game-create-private"];
    }
}

// show next form, show reset/back buttons if not already shown
function showNext(hide, show) {
    if (
        document.getElementsByClassName("game-create-back-reset-container")[0].style.display == "" || 
        document.getElementsByClassName("game-create-back-reset-container")[0].style.display == "none"
    ) {
        document.getElementsByClassName("game-create-back-reset-container")[0].style.display = "block";
    }

    document.getElementsByClassName(hide)[0].style.display = "none";
    document.getElementsByClassName(show)[0].style.display = "block";
    
    roadmap.push(show);
}

// allow user to use enter button to proceed
function checkEvent(component = "", input = "") {
    var e = window.event;
    if (e.keyCode == "13") {
        switch(component) {
            case "title":
                e.preventDefault();
                checkTitle();
                break;

            case "variant":
                e.preventDefault();
                check1v1();
                break;

            case "scoring":
                e.preventDefault();
                checkScoring();
                break;

            case "bet":
                e.preventDefault();
                checkBet(input);
                break;

            case "livePhaseMinutes":
                e.preventDefault();
                showNext("game-create-live-open", "game-create-phase-switch");
                break;

            case "livePhaseSwitchMinutes":
                e.preventDefault();
                checkPhaseSwitch();
                break;

            case "nextPhaseMinutes":
                e.preventDefault();
                showNext("game-create-next-phase", "game-create-time-fill");
                break;

            case "notLivePhaseMinutes":
                e.preventDefault();
                showNext("game-create-live-closed", "game-create-time-fill");
                break;

            case "timeFill":
                e.preventDefault();
                showNext("game-create-time-fill", "game-create-messaging");
                break;

            case "press":
                e.preventDefault();
                checkPressType();
                break;

            case "anon":
                e.preventDefault();
                showNext("game-create-anon", "game-create-draw-type");
                break;

            case "draw":
                e.preventDefault();
                showNext("game-create-draw-type", "game-create-rr");
                break;

            case "rr":
                e.preventDefault();
                validateReliability(input);
                break;

            case "cd":
                e.preventDefault();
                if (private) {
                    showNext("game-create-cds", "game-create-invite");
                } else {
                    document.getElementById("cd-create-button").focus();
                }
                break;

            case "back":
                e.preventDefault();
                goBack();
                break;

            case "reset":
                e.preventDefault();
                reset();
                break;
        }
    }
}

// reset form, return to defaults
function reset() {
    var current = roadmap[roadmap.length - 1];

    document.getElementsByClassName("human-form")[0].reset();
    document.getElementsByClassName(current)[0].style.display = "none";
    document.getElementsByClassName("game-create-back-reset-container")[0].style.display = "none";

    roadmap = [""];
    private = false;

    load();
}

// go back to last screen
function goBack() {
    var current = roadmap[roadmap.length - 1];
    var previous = roadmap[roadmap.length - 2];

    if (current == "game-create-private" && private) {
        private = false;
    }

    if (
        (document.getElementsByClassName("game-create-bothuman")[0] && previous == "game-create-bothuman") ||
        (!document.getElementsByClassName("game-create-bothuman")[0] && previous == "game-create-private")
    ) {
        document.getElementsByClassName("game-create-back-reset-container")[0].style.display = "none";
    }

    document.getElementsByClassName(current)[0].style.display = "none";
    document.getElementsByClassName(previous)[0].style.display = "block";

    roadmap.pop();
}

// check if user is playing a private game
function isPrivate(p) {
    if (p) {
        private = true;
    }
    showNext("game-create-private", "game-create-name");
}

// check if a title was given
function checkTitle() {
    if (document.getElementById("title-box").value == "") {
        document.getElementById("title-error").style.display = "block";
    } else {
        if (document.getElementById("title-error").style.display == "block") {
            document.getElementById("title-error").style.display = "none";
        }
        showNext("game-create-name", "game-create-variant");
    }
}

// check if user is playing 1v1 variant
function check1v1() {
    if (document.getElementById("variant").value == 15 || document.getElementById("variant").value == 23) {
        // if 1v1, game is unranked w/ 5 point bet, show phase length
        showNext("game-create-variant", "game-create-phase-info");
    } else {
        showNext("game-create-variant", "game-create-scoring");
    }
}

// check if user is playing an unranked game
function checkScoring() {
    if (document.getElementById("scoring").value == "Unranked") {
        // if unranked, bet is 5 points by default, show phase length
        showNext("game-create-scoring", "game-create-phase-info");
    } else {
        showNext("game-create-scoring", "game-create-bet");
    }
}

// check if user submitted a valid number of points
function checkBet(points) {
    if (
        document.getElementById("bet").value == "" || 
        isNaN(document.getElementById("bet").value) ||
        document.getElementById("bet").value < 5 ||
        document.getElementById("bet").value > points
    ) {
        document.getElementById("bet-error").style.display = "block";
    } else {
        if (document.getElementById("bet-error").style.display == "block") {
            document.getElementById("bet-error").style.display = "none";
        }
        showNext("game-create-bet", "game-create-phase-length");
    }
}

// check if user wants a phase length switch in a live game or not
function checkPhaseSwitch() {
    if (document.getElementById("selectPhaseSwitchPeriod").value == -1) {
        // if no phase switch, move to time to fill game
        showNext("game-create-phase-switch", "game-create-time-fill");
    } else {
        showNext("game-create-phase-switch", "game-create-next-phase");
    }
}

// check if game is gunboat
function checkPressType() {
    if (document.getElementById("pressType").value == "NoPress") {
        // if gunboat, game is anonymous by default
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

// check user's rr, when validated load cd page w/ game create if public game
function validateReliability(rating) {
    if (
        document.getElementById("minRating").value == "" || 
        isNaN(document.getElementById("bet").value) ||
        document.getElementById("bet").value < 0 ||
        document.getElementById("minRating").value > rating
    ) {
        document.getElementById("rr-error").style.display = "block";
    } else {
        if (document.getElementById("rr-error").style.display == "block") {
            document.getElementById("rr-error").style.display = "none";
        }
        if (!private) {
            document.getElementsByClassName("game-create-submit")[0].style.display = "block";
            document.getElementById("cd-button").style.display = "none";
        } else {
            document.getElementById("cd-create").style.display = "none";
            document.getElementById("cd-button").style.display = "block";
        }
        showNext("game-create-rr", "game-create-cds");
    }
}
