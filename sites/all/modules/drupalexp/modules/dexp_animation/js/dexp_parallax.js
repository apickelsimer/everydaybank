(function ($) {
    Drupal.behaviors.dexp_parallax = {
        attach: function (context, settings) {
            if ($('.dexp-parallax').length > 0 && $(window).width() > 767) {
                console.log('Parallax');
                $('body').stellar({
                    horizontalScrolling: false,
                    verticalOffset: 0,
                    horizontalOffset: 0,
                    responsive: true,
                    scrollProperty: 'scroll',
                    parallaxElements: false
                });
            }
        }
    };
})(jQuery);