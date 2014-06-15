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
}

window.onload = function() {
    init();
}