<div class="map"><div id="map" <?php if ($class != "") { print $class; }?>></div></div>
<input type="hidden" id="map_link" name="map-link" value="<?php print $link; ?>"/><input type="hidden" id="map_title" name="map-title" value="<?php print $title; ?>"/><input type="hidden" id="map_image" name="map-image" value="<?php print $image; ?>"/><input type="hidden" id="map_address" name="map-address" value="<?php print $content; ?>"/>
<input type="hidden" id="map_phone" name="map-phone" value="<?php print $phone; ?>"/> 
<input type="hidden" id="map_zoom" name="map-zoom" value="<?php print $zoom; ?>"/>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
    jQuery(document).ready(function($){
        var address = $('input#map_address').val();
        var link = $('input#map_link').val();
        var image = $('input#map_image').val();
        var title = $('input#map_title').val();
        var phone = $('input#map_phone').val();
        var zoom = parseInt($('input#map_zoom').val());
        var color= Drupal.settings.drupalexp.base_color;
        var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'address': address}, function(results, status) {

            if (status == google.maps.GeocoderStatus.OK) {
            var latitude = results[0].geometry.location.lat();
                    var longitude = results[0].geometry.location.lng();
                    var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: zoom,
                            scrollwheel: false,
                            navigationControl: true,
                            mapTypeControl: false,
                            scaleControl: false,
                            draggable: true,
                            styles: [ { "stylers": [ { "hue": "" }, { "gamma": 1 } ] } ],
                            center: new google.maps.LatLng(latitude, longitude),
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                    });
                    //alert(latitude);
                    //alert(longitude);
                    var infowindow = new google.maps.InfoWindow();
                    var marker, i;
                    var locations = [
                      ['<div class="infobox"><img class="alignleft img-responsive" src="'+image+'" alt=""><h3 class="title"><a href="'+link+'">'+title+'</a></h3><br><span>'+address+'</span><br><p>'+phone+'</p></div>', latitude, longitude, 2]
                    ];
                    for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map
                    //icon: 'http://statics.drupalexp.com/jollyness/marker.png'
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
            });
</script>
