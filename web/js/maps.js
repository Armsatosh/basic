// Google maps
var mapContainer = document.getElementById('map');

if(mapContainer !== null){
    
    var bankMarkers = [];
    var mapLanguage = "hy"; // Get this with PHP
    var imageBank = '/img/design-elements/maps/32x32/marker_bank.png';
    var imageUco = '/img/design-elements/maps/32x32/marker_uco.png';
    var imageAtm = '/img/design-elements/maps/32x32/marker_atm.png';
        
    var map;
    function initMap(lat,lng) {

        var map_lat=40.177636;
        var map_lng=44.512481

        if (typeof(lat) !== 'undefined' && typeof(lng) !== 'undefined') {
             map_lat=lat;
             map_lng=lng

            map = new google.maps.Map(mapContainer, {
                center: {lat: map_lat, lng: map_lng},
                zoom: 14,
                disableDefaultUI: false,
                styles: [
                    {
                        "featureType": "poi.business",
                        "elementType": "labels.icon",
                        "stylers": [
                            {"visibility": "off"}
                        ]
                    },
                    {
                        "featureType": "poi.business",
                        "elementType": "labels.text",
                        "stylers": [
                            {"visibility": "off"}
                        ]
                    }
                ]
            });
        }else{
            map = new google.maps.Map(mapContainer, {
                center: {lat: 40.177636, lng: 44.512481},
                zoom: 14,
                disableDefaultUI: false,
                styles: [
                    {
                        "featureType": "poi.business",
                        "elementType": "labels.icon",
                        "stylers": [
                            {"visibility": "off"}
                        ]
                    },
                    {
                        "featureType": "poi.business",
                        "elementType": "labels.text",
                        "stylers": [
                            {"visibility": "off"}
                        ]
                    }
                ]
            });
            var script = document.createElement('script');

            if(mapDataUrl !== undefined && mapDataUrl !== null) {
                script.src = mapDataUrl;
            } else {
                script.src = '/maps/0/all.json';
            }
            //console.log(script)

            document.getElementsByTagName('head')[0].appendChild(script);
        }





    }
    
    window.eqfeed_callback = function(results) {

        for (var i = 0; i < results.features.length; i++) {

            var contentString = "";

            var coords = results.features[i].geometry.coordinates;
            var entityType = results.features[i].properties.entityType; // 0 Bank; 1 ATM
            var entityMarker = results.features[i].properties.entityMarker;
            var entityTitle = results.features[i].properties.entityTitle[mapLanguage];
            var entityAddress = results.features[i].properties.entityAddress[mapLanguage];
            var entityPhoneNumbers = results.features[i].properties.entityPhoneNumbers;
            
//            if(entityType){
//                var mapIcon = imageAtm;
//            } else {
//                if(entityMarker !== ""){
//                    var mapIcon = entityMarker;
//                } else {
//                    var mapIcon = imageBank;
//                }
//            }
//            var mapIcon = (entityType) ? imageAtm : imageBank;

            switch(entityType) {
                case 0:
                    if(entityMarker !== ""){
                        var mapIcon = entityMarker;
                    } else {
                        var mapIcon = imageBank;
                    }
//                    mapIcon = imageBank;
                    break;
                case 1:
                    if(entityMarker !== ""){
                        var mapIcon = entityMarker;
                    } else {
                        var mapIcon = imageAtm;
                    }
//                    mapIcon = imageAtm;
                    break;
                case 2:
                    if(entityMarker !== ""){
                        var mapIcon = entityMarker;
                    } else {
                        var mapIcon = imageUco;
                    }
//                    mapIcon = imageUco;
                    break;
            }

            var latLng = new google.maps.LatLng(coords.lat,coords.long);

            contentString = "<b>"+entityTitle+"</b><hr>"+entityAddress+"<br>";

            if(entityType == 0 || entityType == 2){

//                for(var j = 0; j < entityPhoneNumbers.length; j++){
                    contentString += "<br>"+entityPhoneNumbers;
//                }

            }
            
            bankMarker = new google.maps.Marker({
                position: latLng,
                map: map,
                animation: google.maps.Animation.DROP,
                icon: mapIcon,
                title: entityTitle
            });
            bankMarkers.push(bankMarker);
            
            
            var infoWindow = new google.maps.InfoWindow();
            google.maps.event.addListener(bankMarker, 'click', (function (bankMarker, contentString, infoWindow) {
                return function () {
                    infoWindow.setContent(contentString);
                    infoWindow.open(map, bankMarker);
                };
            })(bankMarker, contentString, infoWindow));

        }

    }
    
    function clearOverlays() {
        for (var i = 0; i < bankMarkers.length; i++) {
            bankMarkers[i].setMap(null);
        }
        bankMarkers.length = 0;
    }
    
    function reinitMap(mapDataUrl,lat,lng){

        if (typeof(lat) !== 'undefined' && typeof(lng) !== 'undefined') {
            initMap(lat,lng)
        }else{
            initMap(40.177636,44.512481)
        }


        clearOverlays();
        var script = document.createElement('script');
        
        if(mapDataUrl !== undefined && mapDataUrl !== null) {
            script.src = mapDataUrl;
        } else {
            script.src = '/maps/0/all.json';
        }

        document.getElementsByTagName('head')[0].appendChild(script);


        $('html, body').animate({
            scrollTop: $('#map').offset().top-50
        }, 500);
        
    }



}