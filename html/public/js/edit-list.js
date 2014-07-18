function removeMember(member_name) {
    var result;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
            window.location.reload();
        }
    }

    var param = "remove_member=".concat(member_name);
    xmlhttp.open("POST", "../../edit-list.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(param);
}

function initRemoveMember() {
    var member = this.parentNode.parentNode.childNodes[1].innerHTML;
    removeMember(member);
}

function closeMenuHandler(e) {
    var el = document.getElementById('nav_list');
    var clicked = e.target.id;
    if(clicked !== 'hamburger') {
        el.style.display='none';
        document.removeEventListener('click', closeMenuHandler);
    }
}

function toggleMenu() {
    var el = document.getElementById('nav_list');
    if(window.getComputedStyle(el, null).getPropertyValue('display') === 'none') {
        el.style.display='block';
        document.addEventListener('click', closeMenuHandler);

    } else {
        el.style.display='none';
    }
}

function addListeners(elements, funcName) {
    for(var i = 0; i < elements.length; i++) {
        elements[i].addEventListener('click', funcName, false);
    }
}

function confirmLogout() {
    var logout = confirm('Are you sure you want to logout?');
    if(logout) {
        window.location = 'logout.php';
    }

    return false;
}

function init() {
    var element = document.getElementById('hamburger');
    var elements = new Array();
    elements.push(element);
    addListeners(elements, toggleMenu);

    var elements = new Array();
    var elements = document.getElementsByClassName('remove_member');
    addListeners(elements, initRemoveMember);
}

window.onload = function() {
    init();
}
