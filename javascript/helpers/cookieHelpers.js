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

/* 
 * Javascript cookie helpers to communicate client side information to the server
*/

function setCookie(name, value = "", days = null) {
    var expires = "";

    if (days) {
        var date = new Date();
        date.setTime(Date.now() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }

    document.cookie = name + "=" + value + expires + "; path=/";
}

function unsetCookie(name) {
    var expires = "";
    var date = new Date();
    date.setTime(Date.now()+(-1 * 24 * 60 * 60 * 1000));
    expires = "; expires=" + date.toGMTString();

    document.cookie = name + "=" + expires + "; path=/";
}

function getCookie(name) {
    var cookieName = name + "=";
    var cookie = document.cookie
        .split('; ')
        .find(row => row.startsWith(cookieName))

    if (cookie) {
        cookie = cookie.split('=')[1];
    }

    return cookie ? cookie : null;
}
