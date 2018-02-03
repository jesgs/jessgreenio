(function(doc) {
    doc.addEventListener('DOMContentLoaded', function() {
        var menuControl = doc.getElementById('js-mobile-menu-control'),
            menu = doc.getElementById('js-mobile-menu');

        menuControl.addEventListener('click', function(e) {
            menu.classList.toggle('nav-header__nav-bar--open');
            if (menuControl.classList.contains('menu--open')) {
                menuControl.classList.remove('menu--open');
                menuControl.classList.add('menu--close');
            } else {
                menuControl.classList.add('menu--open');
                menuControl.classList.remove('menu--close');
            }
        })
    });
})(document);