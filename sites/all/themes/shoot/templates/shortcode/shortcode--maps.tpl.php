<?php $map_id = drupal_html_id("map_id"); ?>
<div class="map"><div class="map_inner" id="<?php print $map_id; ?>" <?php if ($class != "") {
    print $class;
} ?>></div></div>

<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        var address = "<?php print $content; ?>";
        var type = "<?php print $type; ?>";
        var link = "<?php print $link; ?>";
        var image = "<?php print $image; ?>";
        var title = "<?php print $title; ?>";
        var phone = "<?php print $phone; ?>";
        var zoom = parseInt("<?php print $zoom; ?>");
        var color = "gray";//Drupal.settings.drupalexp.base_color;
        var geocoder = new google.maps.Geocoder();
        var style = 'standard';
        if (type == "gray") {
            style = "gray";
        }
        else if (type == "color") {
            style = "blue";//Drupal.settings.drupalexp.base_color;
        }
        //alert(type);
        var mapType = style;
        geocoder.geocode({'address': address}, function(results, status) {

            if (status == google.maps.GeocoderStatus.OK) {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();
                var map = new google.maps.Map(document.getElementById("<?php print $map_id; ?>"), {
                    zoom: zoom,
                    scrollwheel: false,
                    navigationControl: true,
                    mapTypeControl: false,
                    scaleControl: false,
                    draggable: true,
                    styles: MAPS_CONFIG[mapType], //[ { "stylers": [ { "hue": color }, { "gamma": 1 } ] } ],
                    center: new google.maps.LatLng(latitude, longitude),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                //alert(latitude);
                //alert(longitude);
                var infowindow = new google.maps.InfoWindow();
                var marker, i;
                var locations = [
                    ['<div class="infobox"><img class="alignleft img-responsive" src="' + image + '" alt=""><h3 class="title"><a href="' + link + '">' + title + '</a></h3><br><span>' + address + '</span><br><p>' + phone + '</p></div>', latitude, longitude, 2]
                ];
                for (i = 0; i < locations.length; i++) {
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map,
                        icon: 'http://statics.drupalexp.com/shoot/82x91/1.png'
                    });
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            infowindow.setContent(locations[i][0]);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                }
            }
        });
        // MAPS STYLE CONFIG
        MAPS_CONFIG = {
            standard: [],
            // GRAY STYLE
            gray: [
                // BASIC
                {
                    "stylers": [
                        {hue: "#B9B9B9"},
                        {saturation: -100}
                    ]
                },
                // Lanscape
                {
                    "featureType": "landscape",
                    "stylers": [
                        {
                            "color": "#E5E5E5"
                        }
                    ]
                },
                // Water
                {
                    "featureType": "water",
                    "stylers": [
                        {
                            "visibility": "on"
                        },
                        {
                            "color": "#DCDCDC"
                        }
                    ]
                },
                // Transit
                {
                    "featureType": "transit",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#B9B9B9"
                        }
                    ]
                },
                // Road hight way
                {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#E2E2E2"
                        }
                    ]
                },
                // Road hight way control access
                {
                    "featureType": "road.highway.controlled_access",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#ACACAC"
                        }
                    ]
                },
                // Road arterial
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        }
                    ]
                },
                // Road local
                {
                    "featureType": "road.local",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#F6F6F6"
                        }
                    ]
                },
                // Point global
                {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#DDDDDD"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#D3D3D3"
                        }
                    ]
                },
                {
                    "featureType": "poi.attraction",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#DBDBDB"
                        }
                    ]
                },
                {
                    "featureType": "poi.business",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#DBDBDB"
                        }
                    ]
                },
                {
                    "featureType": "poi.place_of_worship",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#DBDBDB"
                        }
                    ]
                },
            ],
            // Blue STYLE
            blue: [
                // BASIC
                {
                    "stylers": [
                        {hue: "#4C95B2"},
                        {saturation: -100}
                    ]
                },
                // Lanscape
                {
                    "featureType": "landscape",
                    "stylers": [
                        {
                            "color": "#DEE7EB"
                        }
                    ]
                },
                // Water
                {
                    "featureType": "water",
                    "stylers": [
                        {
                            "visibility": "on"
                        },
                        {
                            "color": "#BBE7F9"
                        }
                    ]
                },
                // Transit
                {
                    "featureType": "transit",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#86CEEB"
                        }
                    ]
                },
                // Road hight way
                {
                    "featureType": "road.highway",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#C2EDFF"
                        }
                    ]
                },
                // Road hight way control access
                {
                    "featureType": "road.highway.controlled_access",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#4DCDFF"
                        }
                    ]
                },
                // Road arterial
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        }
                    ]
                },
                // Road local
                {
                    "featureType": "road.local",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#F3F7F9"
                        }
                    ]
                },
                // Point global
                {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#C6E5F1"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#B7DDEC"
                        }
                    ]
                },
                {
                    "featureType": "poi.attraction",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#D5DDE0"
                        }
                    ]
                },
                {
                    "featureType": "poi.business",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#D5DDE0"
                        }
                    ]
                },
                {
                    "featureType": "poi.place_of_worship",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#D5DDE0"
                        }
                    ]
                },
            ]

        };
    });
</script>
