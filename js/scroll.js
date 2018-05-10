function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}

function scroll() {
    document.body.removeAttribute('class');
    document.body.scrollTop  = getCookie('scrollPos');
    document.cookie = 'scrollPos=0';
}

if (getCookie('scrollPos') != '0'){
    var style = document.createElement('style');
    style.type = 'text/css';
    style.innerHTML = '.hide {display: none;}';
    document.getElementsByTagName('head')[0].appendChild(style);

    document.body.className = 'hide';

    document.body.onload = scroll;
}
