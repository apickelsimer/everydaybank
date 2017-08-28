(function($) {
    Drupal.behaviors.drupalexp_base = {
        attach: function(context, settings) {
            var lightbox2 = settings.lightbox2 || null;
            if(lightbox2 !== null){
                console.log('has lightbox2');
            };
        }
    };
})(jQuery);