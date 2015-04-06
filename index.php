<?php
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Maps AJAX + mySQL/PHP Example</title>
    <script src="http://maps.google.com/maps/api/js?sensor=false"
            type="text/javascript"></script>
    <script type="text/javascript">
        //<![CDATA[

        var customIcons = {
            Рестаран: {
                icon: 'icons/res.png',
                shadow: 'http://localhost'
            },
            bar: {
                icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
                shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
            },
            Остановка: {
                icon : 'icons/bus_stop.png',
                shadow: "http://localhost"
            },
            Университет:{
                icon: 'icons/uni.png',
                shadow: "http://localhost"
            },
            Институт:{
                icon: 'icons/ins.png',
                shadow: "http://localhost"
            },
            Гостиница: {
                icon: 'icons/hotel.png',
                shadow: "http:// localhost"
            },
            Остановка_такси:{
                icon:'icons/taxi_stund.png',
                shadow: "http:/localhost"
        },
            Театр: {
                icon: 'icons/theatre.png',
                shadow: "http:/localhost"
            },
            Парк: {
                icon: 'icons/park.png',
                shadow: "http:/localhost"
            },
            Банкомат: {
                icon: 'icons/bank.png',
                shadow: "http:/localhost"
            }

        };

        function load(lat, lng, zoom) {
            var map = new google.maps.Map(document.getElementById("map"), {
                center: new google.maps.LatLng(lat, lng),
                zoom: zoom,
                mapTypeId: 'roadmap'
            });
            var infoWindow = new google.maps.InfoWindow;

            // Change this depending on the name of your PHP file
            downloadUrl("phpsqlajax_genxml3.php", function (data) {
                var xml = data.responseXML;
                var markers = xml.documentElement.getElementsByTagName("marker");
                for (var i = 0; i < markers.length; i++) {
                    var name = markers[i].getAttribute("name");
                    var address = markers[i].getAttribute("address");
                    var type = markers[i].getAttribute("type");
                    var point = new google.maps.LatLng(
                            parseFloat(markers[i].getAttribute("lat")),
                            parseFloat(markers[i].getAttribute("lng")));
                    console.log(name);
                    var html = "<b>" + name + "</b> <br/>" + address;
                    var icon = customIcons[type] || {};
                    var marker = new google.maps.Marker({
                        map: map,
                        position: point,
                        icon: icon.icon,
                        shadow: icon.shadow
                    });
                    bindInfoWindow(marker, map, infoWindow, html);
                }
            });
        }

        function bindInfoWindow(marker, map, infoWindow, html) {
            google.maps.event.addListener(marker, 'click', function () {
                infoWindow.setContent(html);
                infoWindow.open(map, marker);
            });
        }

        function downloadUrl(url, callback) {
            var request = window.ActiveXObject ?
                    new ActiveXObject('Microsoft.XMLHTTP') :
                    new XMLHttpRequest;

            request.onreadystatechange = function () {
                if (request.readyState == 4) {
                    request.onreadystatechange = doNothing;
                    callback(request, request.status);
                }
            };

            request.open('GET', url, true);
            request.send(null);
        }

        function doNothing() {
        }

        //]]>
    </script>
    <style>
        #map {
            float: right;
            width: 80%;
            height: 700px
        }
        #list {
            float: left;
            width: 20%;
        }
    </style>
</head>

<body onload="load(40.285072, 69.628000, 16)">
<div id="list">
<?php
require_once("getPlacesList.php");
//if(isset($_GET['lat']) && isset($_GET['lng'])){
//    $lat = $_GET['lat'];
//    $lng = $_GET['lng'];
//}
?>
</div>
<div id="map"></div>
</body>
</html>
