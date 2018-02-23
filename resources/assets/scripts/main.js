(function() {
    document.addEventListener('DOMContentLoaded', function() {
        let menuControl = document.getElementById('js-mobile-menu-control'),
            menu = document.getElementById('js-mobile-menu');

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
})();