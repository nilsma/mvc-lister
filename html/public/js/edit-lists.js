function getListName(element, callback) {
    var list_name = element.parentNode.parentNode.childNodes[0].innerHTML;
    callback(encodeURIComponent(list_name));
}

function removeList(list_name) {
    var result;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
            location.reload();
        }
    }

    var param = "remove_list=".concat(list_name);
    xmlhttp.open("POST", "../../edit-lists.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(param);
}

function initRemoveList() {
    var remove = confirm('Are you sure you want to delete this list?');

    if(remove) {
        getListName(this, function(list_name) {
            removeList(list_name);
        });
    }
}

function editList() {
    var list_title = this.parentNode.parentNode.childNodes[0].innerHTML;
    alert('editing list: ' + list_title);
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
    var elements = document.getElementsByClassName('remove_list');
    addListeners(elements, initRemoveList);

    var elements = new Array();
    var elements = document.getElementsByClassName('edit_list');
    addListeners(elements, editList);
}

window.onload = function() {
    init();
}