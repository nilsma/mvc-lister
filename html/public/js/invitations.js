function initCancelInvitation() {
    getCancelVars(this, function(username, list_title) {
        cancelInvitation(username, list_title, function() {
            location.reload();
        });
    });
}

function getCancelVars(element, callback) {
    var username = element.parentNode.parentNode.childNodes[1].childNodes[1].innerHTML;
    var list_title = element.parentNode.parentNode.childNodes[1].childNodes[3].innerHTML;
    callback(encodeURIComponent(username), encodeURIComponent(list_title));
}

function cancelInvitation(username, list_title, callback) {
    var result;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
            callback();
        }
    }

    var param1 = "cancel_name=".concat(username);
    var param2 = "&cancel_title=".concat(list_title);
    var params = param1.concat(param2);
    xmlhttp.open("POST", "../../invitations.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

function initAcceptInvitation() {
    getAcceptDeclineVars(this, function(inviter_name, list_title) {
        acceptInvitation(inviter_name, list_title, function() {
           location.reload();
        });
    });
}

function getAcceptDeclineVars(element, callback) {
    var inviter_name = element.parentNode.parentNode.childNodes[0].childNodes[0].innerHTML;
    var list_title = element.parentNode.parentNode.childNodes[0].childNodes[2].innerHTML;
    callback(encodeURIComponent(inviter_name), encodeURIComponent(list_title));
}

function acceptInvitation(inviter_name, list_title, callback) {
    var result;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
            callback();
        }
    }

    var param1 = "accept_name=".concat(inviter_name);
    var param2 = "&accept_title=".concat(list_title);
    var params = param1.concat(param2);
    xmlhttp.open("POST", "../../invitations.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

function initDeclineInvitation() {
    getAcceptDeclineVars(this, function(inviter_name, list_title) {
        declineInvitation(inviter_name, list_title, function() {
            location.reload();
        });
    });
}

function declineInvitation(inviter_name, list_title, callback) {
    var result;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
            callback();
        }
    }

    var param1 = "decline_name=".concat(inviter_name);
    var param2 = "&decline_title=".concat(list_title);
    var params = param1.concat(param2);
    xmlhttp.open("POST", "../../invitations.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
}

function initRemoveMembership() {
    getRemoveMembershipVars(this, function(list_owner, list_title) {
        removeMembership(list_owner, list_title, function() {
            location.reload();
        });
    });
}

function removeMembership(list_owner, list_title, callback) {
    var result;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
            callback();
        }
    }

    var param1 = "members_name=".concat(list_owner);
    var param2 = "&members_title=".concat(list_title);
    var params = param1.concat(param2);
    xmlhttp.open("POST", "../../invitations.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);

}

function getRemoveMembershipVars(element, callback) {
    var list_owner = element.parentNode.parentNode.childNodes[0].childNodes[1].innerHTML;
    var list_title = element.parentNode.parentNode.childNodes[0].childNodes[3].innerHTML;
    callback(encodeURIComponent(list_owner), encodeURIComponent(list_title));
}

function toggleMenu() {
    var el = document.getElementById('nav_list');
    if(window.getComputedStyle(el, null).getPropertyValue('display') === 'none') {
        el.style.display='block';
    } else {
        el.style.display='none';
    }
}

function addListeners(elements, funcName) {
    for(var i = 0; i < elements.length; i++) {
        elements[i].addEventListener('click', funcName, false);
    }
}

function init() {
    var element = document.getElementById('hamburger');
    var elements = new Array();
    elements.push(element);
    addListeners(elements, toggleMenu);

    var elements = new Array();
    var elements = document.getElementsByClassName('cancel_invitation');
    addListeners(elements, initCancelInvitation);

    var elements = new Array();
    var elements = document.getElementsByClassName('accept_invitation');
    addListeners(elements, initAcceptInvitation);

    var elements = new Array();
    var elements = document.getElementsByClassName('decline_invitation');
    addListeners(elements, initDeclineInvitation);

    var elements = new Array();
    var elements = document.getElementsByClassName('unsubscribe_list');
    addListeners(elements, initRemoveMembership)
}

window.onload = function() {
    init();
}