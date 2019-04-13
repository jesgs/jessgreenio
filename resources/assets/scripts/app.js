/**
 * @todo Consolidate and refactor into separate components
 */
(function ($) {
    let APP = {};

    APP.Sticky = {
        init: function () {
            $('.js-sticky').each(function () {
                let $this = $(this);
                let headerBottom = $this.outerHeight();
                let startSticky = 0;

                if ($this.data('elementStart') !== undefined) {
                    let $startElement = ($this.data('elementStart') !== undefined)
                                        ? $($this.data('elementStart')) : null;
                    startSticky = ($startElement.length !== 0) ? $startElement.outerHeight() : 0;
                } else {
                    startSticky = ($this.data('stickyStart') !== undefined) ? $this.data('stickyStart') : 0;
                }

                $(window).on('scroll', function (e) {
                    let windowWidth = window.innerWidth;
                    let scrollTop = $(this).scrollTop();

                    if (windowWidth <= 992) {
                        return;
                    }

                    if (scrollTop > (headerBottom + startSticky)) {
                        $this.addClass('is-sticky');

                        if ($this.is('.is-sticky--off')) {
                            $this.removeClass('is-sticky--off');
                        }
                    } else {
                        if ($this.is('.is-sticky') && scrollTop === 0) {
                            $this.removeClass('is-sticky')
                                 .addClass('is-sticky--off');
                        }
                    }
                });
            });

            $.fn.isInViewport = function() {
                let elementTop = $(this).position().top;
                let elementBottom = elementTop + $(this).outerHeight();
                let viewportTop = $(window).scrollTop() + 180;
                // let viewportBottom = viewportTop + $(window).height();

                return elementBottom > viewportTop && elementTop < viewportTop;
            };

            $(window).on('resize scroll', function () {
                $('.js-scroll-spy').each(function () {
                    let element = $(this).attr('href');
                    let $element = $(element);
                    let windowWidth = window.innerWidth;

                    if ($element.isInViewport() && (windowWidth > 992)) {
                        if (!$(this).is('.i-spy')) {
                            // find other elements that have "i-spy"
                            $(this).parents('ul').find('a').removeClass('i-spy');
                            $(this).addClass('i-spy');
                        }
                    }
                });
            });


            $('.js-scroll-spy').on('click touchend', function (e) {
                let windowWidth = window.innerWidth;

                if (windowWidth > 992) {
                    e.preventDefault();
                    let $element = $($(this).attr('href'));
                    let offset = 160;

                    $('html,body').animate({
                        scrollTop : ($element.position().top - offset) + 'px' }, 1000, 'swing');
                }
            });
        }
    };

    $(function () {
        APP.Sticky.init();
    });
})(jQuery);
