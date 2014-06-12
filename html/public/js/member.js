function updateDatabaseFlag(item_name, callback) {
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

    var param = "toggle=".concat(item_name);
    xmlhttp.open("POST", "../../member.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(param);
}

function toggleItem() {
    var el = this;
    var itemName = this.innerHTML;

    updateDatabaseFlag(itemName, function(result) {
        if(window.getComputedStyle(el, null).getPropertyValue('background-color') === 'rgb(0, 128, 0)') {
            el.style.backgroundColor='rgb(128, 0, 0)';
        } else {
            el.style.backgroundColor='rgb(0, 128, 0)';
        }
    });
}

function toggleMenu() {
    var el = document.getElementById('nav_list');
    if(window.getComputedStyle(el, null).getPropertyValue('display') === 'none') {
        el.style.display='block';
    } else {
        el.style.display='none';
    }
}

function initRemoveItem() {
    getItemToRemove(this, function(itemName) {
        removeItem(itemName, function() {
            location.reload();
        });
    });
}

function getItemToRemove(element, callback) {
    var item_name = element.parentNode.parentNode.childNodes[0].innerHTML;
    callback(encodeURIComponent(item_name));
}

function removeItem(itemName, callback) {
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

    var param = "item_name=".concat(itemName);
    xmlhttp.open("POST", "../../member.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(param);
}

function loadList() {
    var list_name = this.innerHTML;
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

    var param = "load_list=".concat(list_name);
    xmlhttp.open("POST", "../../member.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(param);
}

function toggleAddList() {
    var el = document.getElementById('add_list_form');
    if(window.getComputedStyle(el, null).getPropertyValue('display') === 'none') {
        el.style.display='flex';
        this.innerHTML='-';
    } else {
        el.style.display='none';
        this.innerHTML='+';
    }
}

function addListeners(elements, funcName) {
    for(var i = 0; i < elements.length; i++) {
        elements[i].addEventListener('click', funcName, false);
    }
}

function init() {
    var elements = new Array();
    elements = document.getElementsByClassName('remove_item');
    addListeners(elements, initRemoveItem);

    var element = document.getElementById('hamburger');
    var elements = new Array();
    elements.push(element);
    addListeners(elements, toggleMenu);

    var elements = new Array();
    elements = document.getElementsByClassName('item_name');
    addListeners(elements, toggleItem);

    var elements = new Array();
    elements = document.getElementsByTagName('option');
    addListeners(elements, loadList);

    var elements = new Array();
    var element = document.getElementById('toggle_add_list');
    elements.push(element);
    addListeners(elements, toggleAddList);
}

window.onload = function() {
    init();
}