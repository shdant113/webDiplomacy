/*
    Copyright (C) 2004-2010 Kestas J. Kuliukas

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
// See doc/javascript.txt for information on JavaScript in webDiplomacy

/*********
 * Simple detection for mobile phone, tablet, or touch screens
 * utilizing local storage
 ********/
function execute() {
    var phone = checkIfPhoneScreen();
    var tablet = false;
    var touch = false;

    if (!phone) {
        tablet = checkIfTabletScreen();

        if (!tablet) {
            touch = checkIfTouchScreen();
        }
    }
    
    if (!phone && !tablet && !touch) {
        localStorage.setItem("screen", "desktop");
    }
}

execute();

/**
 * Check if user's screen is touch compatible utilizing navigator interface
 * or utilizing media query list calls or UA sniffing as a fallback 
 */
function checkIfTouchScreen() {
    var touchScreen = false;

    // Detect touch points on screen
    if ("maxTouchPoints" in navigator) {
        if (navigator.maxTouchPoints > 0) {
            touchScreen = true;
        }
    } else if ("msMaxTouchPoints" in navigator) {
        if (navigator.msMaxTouchPoints > 0) {
            touchScreen = true;
        }

    // Fallbacks if touch point detection unavailable
    } else {
        // Use media query list to detect user's pointer accuracy
        var mQ = window.matchMedia && matchMedia("(pointer:coarse)");
        if (mQ && mQ.media === "(pointer:coarse)") {
            touchScreen = !!mQ.matches;

        // Use useragent sniffing as a final fallback
        } else {
            var UA = navigator.userAgent;
            touchScreen = (
                /\b(BlackBerry|webOS|iPhone|IEMobile)\b/i.test(UA) ||
                /\b(Android|Windows Phone|iPad|iPod)\b/i.test(UA)
            );
        }
    }

    if (touchScreen) {
        localStorage.setItem("screen", "touch");
        return true;
    }

    return false;
}

/**
 * Check if user's screen is a phone screen by detecting screen size
 */
function checkIfPhoneScreen() {
    if (window.innerWidth < 800) {
        localStorage.setItem("screen", "phone");
        return true;
    }

    return false;
}

/**
 * Check if user's screen is a tablet screen by detecting screen size
 */
function checkIfTabletScreen() {
    if (window.innerWidth > 800 && window.innerWidth < 1100) {
        localStorage.setItem("screen", "tablet");
        return true;
    }

    return false;
}
