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

    var param = "toggle_item=".concat(item_name);
    xmlhttp.open("POST", "../../member.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(param);
}

function toggleItem() {
    var el = this;
    var item_name = this.innerHTML;

    updateDatabaseFlag(item_name, function(result) {
        if(window.getComputedStyle(el, null).getPropertyValue('background-color') === 'rgb(8, 173, 68)') {
            el.style.backgroundColor='rgb(185, 38, 53)';
            el.style.textDecoration='line-through';
        } else {
            el.style.backgroundColor='rgb(8, 173, 68)';
            el.style.textDecoration='none';
        }
    });
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
    var json = this.getAttribute('value');
    var json = json.replace(/'/g, '"');
    var obj = JSON.parse(json);
    var list_owner = obj.user;
    var list_title = obj.title;
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

    var param1 = "load_list=".concat(list_title);
    var param2 = "&list_owner=".concat(list_owner);
    var params = param1.concat(param2);
    xmlhttp.open("POST", "../../member.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
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

function confirmLogout() {
    var logout = confirm('Are you sure you want to logout?');
    if(logout) {
        window.location = 'logout.php';
    }

    return false;
}

function getUpdatedHTML(callback) {
    var result;
    var updates = 1;

    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            result = xmlhttp.responseText;
            var parsed = JSON.parse(result);
            callback(parsed);
        }
    }

    var param = "check_updates=".concat(updates);
    xmlhttp.open("POST", "../../member.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(param);
}

function updateItems(callback) {
    getUpdatedHTML(function(updatedHTML) {
        var element = document.getElementById('items_container');
        element.innerHTML = updatedHTML;
        callback();
    });
}

setInterval(
    function() {
        updateItems(function() {
            init();
        });
    }, 3000
);

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