    (function ($) {
        Drupal.behaviors.shoot = {
            attach: function (context, settings) {
            	if($('.dtooltip').length > 0){
                $('.tooltip').removeClass('in');
                $('.dtooltip').tooltip('destroy').tooltip({
                    container: 'body'
                });
                }
            }
        };
    })(jQuery);
    (function ($) {
        $(document).ready(function () {
            $(".commerce-add-to-cart .form-submit").click(function(){
							 $(this).submit();
						});
            /* Counter */
            $(".stat-count").each(function () {
                $(this).data('count', parseInt($(this).html(), 10));
                $(this).html('0');
                count($(this));
            });
            $('.region-navigation').click(function (e) {
                if ($(e.target).hasClass('region-navigation')) {
                    $('body').removeClass('menu-open');
                }
            });
            $('.search-form-block-wrapper').hide(0);
            $('.search-toggle').click(function () {
                $('.search-form-block-wrapper').fadeIn("slow", function () {
                    $(this).find('input[type=text]').focus();
                });
                return false;
            });
            $('.search-close').click(function () {
                $('.search-form-block-wrapper').fadeOut("slow");
                return false;
            });
            OE.chart.caller();
        });

        function count($this) {
            var current = parseInt($this.html(), 10);
            current = current + /* Where 50 is increment */
                $this.html(++current);
            if (current > $this.data('count')) {
                $this.html($this.data('count'));
            } else {
                setTimeout(function () {
                    count($this)
                }, 50);
            }
        }

        function showfancybox($element) {
            $($element).fancybox({
                arrows: true,
                padding: 0,
                closeBtn: true,
                openEffect: 'fade',
                closeEffect: 'fade',
                prevEffect: 'fade',
                nextEffect: 'fade',
                helpers: {
                    media: {},
                    overlay: {
                        locked: false
                    },
                    buttons: false,
                    thumbs: {
                        width: 50,
                        height: 50
                    },
                    title: {
                        type: 'inside'
                    }
                },
                beforeLoad: function () {
                    var el, id = $(this.element).data('title-id');
                    if (id) {
                        el = $('#' + id);
                        if (el.length) {
                            this.title = el.html();
                        }
                    }
                }
            });
        }
    })(jQuery);
    (function (window, $) {
        var $doc = $(document);
        // Common functions
        var OE = {
            searchBox: function () {
                $doc.on('click', '[data-toggle-active]', function () {
                    var $this = $(this),
                        selector = $this.attr('data-toggle-active'),
                        $selector = $(selector);
                    $selector.toggleClass('active');
                    var focus = $this.attr('data-focus');
                    if (focus) {
                        $(focus).focus();
                    }
                });
            },
            siteLoading: function () {
                var $loading = $('.loading-overlay');
                $('main').imagesLoaded(function () {
                    $loading.removeClass('active');
                });
            },
            mobileMenu: function () {
                $doc.on('click', '.navbtn', function () {
                    $('.oe-mobile-menu').slideToggle(300);
                });
                $('.oe-mobile-menu .menu-item-has-child').on('click', '> a', function (e) {
                    e.preventDefault();
                    var $this = $(this);
                    $this.parent().toggleClass('active');
                    $this.next('.submenu').slideToggle(300);
                });
            }
        };
        // Make it global
        window.OE = OE;
    })(window, jQuery);
    (function ($, OE, document) {
        var $doc = $(document);
        // Common functions
        OE.chart = {
            caller: function () {
                $('.dexp-circle-chart').each(function () {
                    var $this = $(this),
                        $tracker = $this.find('.dexp-color-track'),
                        trackColor = $tracker.css('borderColor'),
                        barColor = $tracker.css('color'),
                        width = $this.width();
                    $this.easyPieChart({
                        barColor: barColor,
                        trackColor: trackColor,
                        scaleColor: false,
                        lineWidth: 5,
                        lineCap: 'square',
                        size: width,
                        animate: {
                            duration: 2000,
                            enabled: true
                        },
                        rotate: 180,
                        easing: 'easeOutElastic',
                        onStep: function (from, to, percent) {
                            this.el.children[0].innerHTML = Math.round(percent) + '%';
                        }
                    });
                });
            }
        };
    })(jQuery, window.OE, window.document);