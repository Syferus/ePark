/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
var app = {
    // Application Constructor
    initialize: function() {
        this.bindEvents();
    },
    // Bind Event Listeners
    //
    // Bind any events that are required on startup. Common events are:
    // 'load', 'deviceready', 'offline', and 'online'.
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, false);
    },
    // deviceready Event Handler
    //
    // The scope of 'this' is the event. In order to call the 'receivedEvent'
    // function, we must explicitly call 'app.receivedEvent(...);'
    onDeviceReady: function() {
        navigator.geolocation.getCurrentPosition(app.onSuccess, app.onError);

    },

    // Current location was found
    // Show the map
    onSuccess: function(position) {
        var longitude = position.coords.longitude;
        var latitude = position.coords.latitude;
        var latLong = new google.maps.LatLng(latitude, longitude);

        var mapOptions = {
            center: latLong,
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map,
            currentPosition,
            directionsDisplay,
            directionsService;

        map = new google.maps.Map(document.getElementById("geolocation"), mapOptions);

        directionsDisplay.setMap(map);

        var currentPositionMarker = new google.maps.Marker({
            position: currentPosition,
            map: map,
            title: "Current position"
        });

        var infowindow = new google.maps.InfoWindow();
        google.maps.event.addListener(currentPositionMarker, 'click', function () {
            infowindow.setContent("Current position: latitude: " + lat + " longitude: " + lon);
            infowindow.open(map, currentPositionMarker);
        });
    },

    onError: function(error) {
        alert('code: ' + error.code + '\n' + 'message:' + error.message + '\n');
    }
};
