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
var invite = false;

// boolean determining if game is live game
var live = false;

// boolean determining if invite code should be shown or hidden
var showCode = false;

// boolean determining if user can be redirected to review page when changing form values (editing form)
var review = false;

/* ****************** */

window.onload = function() {
    document.addEventListener('keydown', function(e) {
        if (e.keyCode == "13") {
            e.preventDefault();
        }
    });
    load();
}

/**
 * redirect to bot page
 * for IE8 and below users, I stole functionality from stackoverflow
 * I don't know if it works and I'm not testing it, sorry not sorry
 */
function redirectToBots() {
    var valid = checkIfValidEvent(window.event);
    if (valid) {
        var url       = "botgamecreate.php",
            ua        = navigator.userAgent.toLowerCase(),
            isIE      = ua.indexOf('msie') !== -1,
            version   = parseInt(ua.substr(4, 2), 10);
    
        // Internet Explorer 8 and lower, because that still exists
        if (isIE && version < 9) {
            var link = document.createElement('a');
            link.href = url;
            document.body.appendChild(link);
            link.click();
        }
        else { 
            window.location.href = url; 
        }
    }
}


/**
 * determing starting component of page, start at bots if bots exist
 */
function load() {
    if (document.getElementsByClassName("game-create-bothuman")[0]) {
        document.getElementsByClassName("game-create-bothuman")[0].style.display = "block";
        roadmap = ["game-create-bothuman"];
    } else {
        document.getElementsByClassName("game-create-private")[0].style.display = "block";
        roadmap = ["game-create-private"];
    }
}

/**
 * checks if given event is a click or enter key press
 * @param {Event} e
 * @return true if mouseclick or valid enter key event
 */ 
function checkIfValidEvent(e) {
    var valid = false;
    if (e instanceof MouseEvent) {
        valid = true;
    } else if (e instanceof KeyboardEvent) {
        if (e.keyCode == "13") {
            valid = true;
        }
    }

    return valid;
}

/** 
 * displays next component
 * if optional param is provided, completes associated logic/validation
 * @param {string} current - current component
 * @param {string} next - next component
 * @param {string} param - optional parameter for matching special cases
 * @param {*} input - additional information required for optional param logic/validation
 */
function showNext(current, next, param = "", input = "") {
    var valid = checkIfValidEvent(window.event);
    if (valid) {
        // if reset/back buttons are not yet shown, display them
        if (
            document.getElementsByClassName("game-create-back-reset-container")[0].style.display == "" || 
            document.getElementsByClassName("game-create-back-reset-container")[0].style.display == "none"
        ) {
            document.getElementsByClassName("game-create-back-reset-container")[0].style.display = "block";
        }

        // if invite only game, set global flag
        if (param == "invite") {
            invite = true;
        }

        // validate game title
        if (param == "title") {
            var validTitle = checkTitle();
            if (!validTitle) {
                return false;
            }
        }

        // check to see if user selected 1v1 variant, forward past scoring/points
        if (param == "variant") {
            if (document.getElementById("variant").value == 15 || document.getElementById("variant").value == 23) {
                next = "game-create-phase-length";
            }
        }

        // check to see if user selected unranked game, forward past points
        if (param == "scoring") {
            if (document.getElementById("scoring").value == "Unranked") {
                next = "game-create-phase-length";
            }
        }

        // check to see if user gave valid amount of points
        if (param == "points") {
            var validPoints = checkBet(input);
            if (!validPoints) {
                return false;
            }
        }

        // check to see if user selected a live game, set global flag
        if (param == "live") {
            live = true;
        }

        // check to see if user selected a phase switch
        if (param == "switch") {
            if (document.getElementById("selectPhaseSwitchPeriod").value != -1) {
                next = "game-create-next-phase";
            }
        }

        // check to see if game is gunboat
        if (param == "gunboat") {
            if (document.getElementById("pressType").value == "NoPress") {
                next = "game-create-draw-type";
            }
        }

        // check user's reliability
        if (param == "rr") {
            var validRr = validateReliability(input);
            if (!validRr) {
                return false;
            }
        }

        // check if game needs invite code, populate review form if public game
        if (param == "cds") {
            if (invite) {  
                if (document.getElementById("invite-error").style.display == "block") {
                    document.getElementById("invite-error").style.display = "none";
                }
                next = "game-create-invite";
            } else {
                reviewForm();
            }
        }

        // check invite code, populate review page if valid
        if (param == "code") {
            var validCode = checkInviteCode();
            if (!validCode) {
                return false; 
            } else {
                reviewForm();
            }
        }

        document.getElementsByClassName(current)[0].style.display = "none";
        document.getElementsByClassName(next)[0].style.display = "block";
        roadmap.push(next);
    }
}

/**
 * resets form to initial values
 */
function reset() {
    var valid = checkIfValidEvent(window.event);
    if (valid) {
        var current = roadmap[roadmap.length - 1];
    
        document.getElementsByClassName("human-form")[0].reset();
        document.getElementsByClassName(current)[0].style.display = "none";
        document.getElementsByClassName("game-create-back-reset-container")[0].style.display = "none";
    
        roadmap = [""];
        invite = false;
        live = false;
        showCode = false;
        review = false;
    
        load();
    }
}

/**
 * returns user back to previous component
 */
function goBack() {
    var valid = checkIfValidEvent(window.event);
    if (valid) {
        var current = roadmap[roadmap.length - 1];
        var previous = roadmap[roadmap.length - 2];
    
        if (current == "game-create-private" && invite) {
            invite = false;
        }
    
        if (review) {
            review = false;
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
}

/**
 * validates game is given a name 
 * @returns {boolean} - true if valid
 */
function checkTitle() {
    var valid = false;

    if (document.getElementById("title-box").value == "") {
        document.getElementById("title-error").style.display = "block";
    } else {
        if (document.getElementById("title-error").style.display == "block") {
            document.getElementById("title-error").style.display = "none";
        }
        valid = true;
    }

    return valid;
}

/**
 * checks if user submitted a valid number of points
 * @param {string} points 
 * @returns {boolean} - true if valid
 */
function checkBet(points) {
    var valid = false;
    var bet = document.getElementById("bet").value;

    if (bet == "" || isNaN(bet) || bet < 5 || bet > points) {
        document.getElementById("bet-error").style.display = "block";
    } else {
        if (document.getElementById("bet-error").style.display == "block") {
            document.getElementById("bet-error").style.display = "none";
        }
        valid = true;
    }

    return valid;
}

/**
 * checks if user's reliability is valid/high enough to create game with specified input
 * @param {string} rating 
 * @returns {boolean} - true if valid
 */
function validateReliability(rating) {
    var valid = false;
    var r = document.getElementById("minRating").value;

    if (r == "" || isNaN(r) || r < 0 || r > rating) {
        document.getElementById("rr-error").style.display = "block";
    } else {
        if (document.getElementById("rr-error").style.display == "block") {
            document.getElementById("rr-error").style.display = "none";
        }
        valid = true;
    }

    return valid;
}

/**
 * checks that invite code is not empty and matches confirmation
 * @returns {boolean} - true if valid
 */
function checkInviteCode() {
    var valid = true;
    var str = document.getElementById("invite-input").value;
    var confStr = document.getElementById("invite-conf-input").value;

    if (str.split(' ').join('') == "" || confStr.split(' ').join('') == "") {
        if (document.getElementById("invite-error-match").style.display == "block") {
            document.getElementById("invite-error-match").style.display = "none";
        }
        document.getElementById("invite-error").style.display = "block";
        valid = false;
    }

    if (str !== confStr) {
        if (document.getElementById("invite-error").style.display == "block") {
            document.getElementById("invite-error").style.display = "none";
        }
        document.getElementById("invite-error-match").style.display = "block";
        valid = false;
    }

    return valid;
}

// determine whether code should be shown or not
function toggleShowCode() {
    if (!showCode) {
        showCode = true;
        document.getElementById("game-create-review-pw-button").innerHTML = "[hide invite code]";
    } else {
        showCode = false;
        document.getElementById("game-create-review-pw-button").innerHTML = "[show invite code]";
    }
    var inviteCode = showCode ? document.getElementById("invite-input").value : "";
    document.getElementById("game-create-review-pw").innerHTML = inviteCode;
}

// // this will have to get fixed to match the wizard once it is live
// function setBotFill() {
//     var content = document.getElementById("botFill");
//     var ePress = document.getElementById("pressType");
//     var pressType = ePress.options[ePress.selectedIndex].value;
//     var eVariant = document.getElementById("variant");
//     var variant = eVariant.options[eVariant.selectedIndex].value;

//     if (pressType == "NoPress" && variant == 1) {
//         content.style.display = "block";
//     } else {
//         content.style.display = "none";
//         document.getElementById("botBox").checked = false;
//     }
// }

/**
 * populates review page with given inputs
 */
function reviewForm() {
    var name = document.getElementById("title-box").value;
    var map = document.getElementById("variant").options[document.getElementById("variant").selectedIndex].text;
    var scoring = document.getElementById("scoring").options[document.getElementById("scoring").selectedIndex].text;
    var bet = document.getElementById("bet").value;
    var phaseLength = live ? 
        document.getElementById("selectPhaseMinutesLive").options[document.getElementById("selectPhaseMinutesLive").selectedIndex].text 
        : document.getElementById("selectPhaseMinutesNotLive").options[document.getElementById("selectPhaseMinutesNotLive").selectedIndex].text;
    var phaseSwitch = document.getElementById("selectPhaseSwitchPeriod").options[document.getElementById("selectPhaseSwitchPeriod").selectedIndex].text;
    var switchMinutes = document.getElementById("selectNextPhaseMinutes").options[document.getElementById("selectNextPhaseMinutes").selectedIndex].text;
    var fill = document.getElementById("wait").options[document.getElementById("wait").selectedIndex].text;
    var press = document.getElementById("pressType").options[document.getElementById("pressType").selectedIndex].text;
    var anon = document.getElementById("game-create-anon").options[document.getElementById("game-create-anon").selectedIndex].text;
    var draw = document.getElementById("game-create-draw").options[document.getElementById("game-create-draw").selectedIndex].text;
    var rr = document.getElementById("minRating").value;
    var cd = document.getElementById("NMR").options[document.getElementById("NMR").selectedIndex].text;
    var inviteCode = showCode ? document.getElementById("invite-input").value : "";

    document.getElementById("game-create-review-name").innerHTML = name;
    document.getElementById("game-create-review-map").innerHTML = map;
    document.getElementById("game-create-review-scoring").innerHTML = scoring;
    document.getElementById("game-create-review-bet").innerHTML = bet;
    document.getElementById("game-create-review-live").innerHTML = live ? "Live" : "Non-Live";
    document.getElementById("game-create-review-phase-length").innerHTML = phaseLength;
    document.getElementById("game-create-review-phase-switch").innerHTML = phaseSwitch;
    document.getElementById("game-create-review-phase-switch-length").innerHTML = switchMinutes;
    document.getElementById("game-create-review-fill").innerHTML = fill;
    document.getElementById("game-create-review-press").innerHTML = press;
    document.getElementById("game-create-review-anon").innerHTML = anon;
    document.getElementById("game-create-review-draw").innerHTML = draw;
    document.getElementById("game-create-review-rr").innerHTML = rr;
    document.getElementById("game-create-review-cds").innerHTML = cd;
    document.getElementById("game-create-review-pw").innerHTML = inviteCode;

    if (live) {
        document.getElementById("game-create-review-live-switch").style.display = "block";
    }

    if (invite) {
        document.getElementById("game-create-review-invite").style.display = "flex";
    }
}

// allow user to edit their form values from the review page w/out having to fill out entire form again
function editForm(component) {
    var valid = checkIfValidEvent(window.event);
    review = true;

    if (valid) {
        switch(component) {
            case "title":
                showNext("game-create-review", "game-create-name");
                break;
    
            case "variant":
                showNext("game-create-review", "game-create-variant");
                break;
    
            case "scoring":
                showNext("game-create-review", "game-create-scoring");
                break;
    
            case "bet":
                showNext("game-create-review", "game-create-bet");
                break;
    
            case "live":
                showNext('game-create-review', 'game-create-phase-length');
                break;
    
            case "phase":
                showNext('game-create-review', 'game-create-phase-length');
                break;
    
            case "switch":
                showNext('game-create-review', 'game-create-phase-switch');
                break
    
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
                if (invite) {
                    checkCivilDisorder();
                } else {
                    showNext("game-create-cds", "game-create-review");
                }
                break;
        }
    }
}

// allow user to edit their form values from the review page
function editWithOptions(component) {
    switch (component) {
        case "phase":
            if (live) {
                showNext("game-create-review", "")
            }
    }

}
