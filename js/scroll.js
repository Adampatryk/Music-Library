function scroll() {
    document.body.removeAttribute('class');
    document.body.scrollTop  = document.cookie.split('=')[1];
    document.cookie = 'scrollPos=0';
}

if (document.cookie.split(['='])[1] != '0'){
    var style = document.createElement('style');
    style.type = 'text/css';
    style.innerHTML = '.hide {display: none;}';
    document.getElementsByTagName('head')[0].appendChild(style);

    document.body.className = 'hide';

    document.body.onload = scroll;
}
