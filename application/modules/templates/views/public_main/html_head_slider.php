<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- MAP module -->





<style type="text/css">

  /* Set a size for our map container, the Google Map will take up 100% of this container */

  #map {

  width: 100%;

  }

	.town-list {
		display: none;
	}


</style>



<!--

You need to include this script tag on any page that has a Google Map.



The following script tag will work when opening this example locally on your computer.

But if you use this on a localhost server or a live website you will need to include an API key.

Sign up for one here (it's free for small usage):

    https://developers.google.com/maps/documentation/javascript/tutorial#api_key



After you sign up, use the following script tag with YOUR_GOOGLE_API_KEY replaced with your actual key.

    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_API_KEY"></script>

-->

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAt059eRF2ThiE1WmyavE2x2mUOIUAW8xc&libraries=places"></script>



<script type="text/javascript">

// add listeners

google.maps.event.addDomListener(window, 'load', init);



window['addMapPoints'] = function addMapPoints($data, isZoomed) {

    var retryPlacingMarkersUntilMapisLoaded = setInterval(placeMarker, 500);


    function placeMarker() {

        // break out of loop

        if ('zoom' in window['map']) {

            clearInterval(retryPlacingMarkersUntilMapisLoaded);


            // wipe out markers if they exist (on data refresh)

            if (window['markers'].length) {

                for (var i = window['markers'].length; i--;) {

                    window['markers'][i].setMap(null);

                }

                window['bounds'] = new google.maps.LatLngBounds();

                window['markers'] = [];

            }

            var redIcon = {
              url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png"
            }

            var blueIcon = {
              url: "https://maps.google.com/mapfiles/ms/icons/blue-dot.png"
            }

            var greenIcon = {
              url: "https://maps.google.com/mapfiles/ms/icons/green-dot.png"
            }

            var iconArr = [redIcon, blueIcon, greenIcon];

            // Add Google Markers

            for (var i = 0; i < $data.length; i++) {
                if (location[0] != null || $data[i].location[1] != null && $data[i].location[1] != 0) {

                    var marker = new google.maps.Marker({

                        position: new google.maps.LatLng($data[i].location[0], $data[i].location[1]),

                        title: $data[i].name,

                        id: $data[i].id,

                        town: $data[i].townarea,

                        animation: google.maps.Animation.DROP,

                        map: map,

                        icon: (iconArr[$data[i].propType]) ?(iconArr[$data[i].propType]).url : iconArr[0].url,
                        type: $data[i].type,

                        clickable: true,

                        iterator: i + "map",

                        photo: $data[i].photo,

                        index: i

                    });


                    google.maps.event.addListener(marker, 'click', function(e) {

                        var infoWindowContent = "<img onerror=\"this.src='<?= base_url() ?>public/images/links-loading.jpg'\"src=\"" + this.photo + " \" width=\"200px\" /><br>";

                        infoWindowContent += "<span><strong>" + this.title + "</strong></span><br>";

                        infoWindowContent += "<a href=\"/view-property?type=" + this.type + "&amp;id=" + this.id +"\" class=\"btn btn-primary\">Details <svg class=\"svg-inline--fa fa-info-circle fa-w-16\" aria-hidden=\"true\" data-prefix=\"fas\" data-icon=\"info-circle\" role=\"img\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 512 512\" data-fa-i2svg=\" \"><path fill=\"currentColor\" d=\"M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 110c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z\"></path></svg><!-- <i class=\"fas fa-info-circle\"></i> --></a>";

                        window['iw'].setContent(infoWindowContent);

                        window['iw'].open(map, this);

                    });


                    // push onto global markers

                    window['markers'].push(marker);

                    //extend the bounds to include each marker's position

                    bounds.extend(marker.position);

                    // add to map

                    marker.setMap(map);



                }

            };

            if (!isZoomed) {

                map.setCenter(new google.maps.LatLng(40.8932469, -74.0116536));

            }

            else {
                map.fitBounds(bounds);
            }

            return;

        }

    }

}



function init() {



    // Basic options for a simple Google Map

    // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions

    var mapOptions = {

        // How zoomed in you want the map to start at (always required)

        zoom: 13,

        zoomControl: true,

        mapTypeControl: true,

        scaleControl: true,

        streetViewControl: true,

        rotateControl: true,

        fullscreenControl: true,



        // The latitude and longitude to center the map (always required)

        center: new google.maps.LatLng(40.9816175, -74.148343), // New York



        // How you would like to style the map.

        // This is where you would paste any style found on Snazzy Maps.

        styles: [{

            "featureType": "administrative",

            "elementType": "labels.text.fill",

            "stylers": [{

                "color": "#444444"

            }]

        }, {

            "featureType": "landscape",

            "elementType": "all",

            "stylers": [{

                "color": "#f2f2f2"

            }]

        }, {

            "featureType": "poi",

            "elementType": "all",

            "stylers": [{

                "visibility": "off"

            }]

        }, {

            "featureType": "road",

            "elementType": "all",

            "stylers": [{

                "saturation": -100

            }, {

                "lightness": 45

            }]

        }, {

            "featureType": "road.highway",

            "elementType": "all",

            "stylers": [{

                "visibility": "simplified"

            }]

        }, {

            "featureType": "road.arterial",

            "elementType": "labels.icon",

            "stylers": [{

                "visibility": "off"

            }]

        }, {

            "featureType": "transit",

            "elementType": "all",

            "stylers": [{

                "visibility": "off"

            }]

        }, {

            "featureType": "water",

            "elementType": "all",

            "stylers": [{

                "color": "#46bcec"

            }, {

                "visibility": "on"

            }]

        }]

    };



    // Get the HTML DOM element that will contain your map

    // We are using a div with id="map" seen below in the

    var mapElement = document.getElementById('map');



    // Create the Google Map using our element and options defined above

    window['map'] = new google.maps.Map(mapElement, mapOptions);

    window['markers'] = [];

    window['bounds'] = new google.maps.LatLngBounds();

    // global infowindow

    window['iw'] = new google.maps.InfoWindow({

        maxWidth: 350

    });



}

                </script>



<!-- The element that will contain our Google Map. This is used in both the Javascript and CSS above. -->

<div id="map">



</div>


<select ng-model="selectedTown" class="town-list" ng-change="hc.mapFilter(selectedTown)" ng-init="selectedTown = 'All Towns'">
        <option ng-repeat="town in hc.rv" ng-value="'{{town}}'">{{town}}</option>
</select>



<div class="clearfix mobile-town-select">
    <select ng-model="selectedTown" ng-change="hc.mapFilter(selectedTown)">
        <option ng-repeat="town in hc.rv" ng-value="'{{town}}'">{{town}}</option>
    </select>
</div>



<!-- MAP module -->