﻿<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8" />
    <link href="Content/bootstrap.min.css" rel="stylesheet" />
    <script src="Content/bootstrap.min.js"></script>
    <script src="Content/jquery-2.2.0.min.js"></script>
    <link href="Content/Site.css" rel="stylesheet" />
</head>
<body>
    <div class="jumbotron">
        <div class="row">
            <div class="col-md-3" id="div1">
                <img src="Content/Logo.png" width="200" />
            </div>
            <div class="col-md-9">
                <h1>ePark Setup</h1>

                <div id="location">
                    <h3>Select Car Park Location</h3>
                    <div id="map" style="height: 400px; width: 80%;"></div>
                    <script>
                        var defaultLatLng = { lat: 53.3441, lng: -6.2675 };
                        var map;
                        var marker;
                        var geocoder;
                        var County;
                        var CarParkName;
                        var Resolution;
                        var Frequency;

                        function initMap() {
                            map = new google.maps.Map(document.getElementById('map'), {
                                center: { lat: 53.3441, lng: -6.2675 },
                                zoom: 6,
                                streetViewControl: false,
                                zoomControl: true,
                                zoomControlOptions: {
                                    position: google.maps.ControlPosition.LEFT_BOTTOM
                                }
                            });

                            geocoder = new google.maps.Geocoder;

                            if (navigator.geolocation) {
                                navigator.geolocation.getCurrentPosition(function (position) {
                                    var pos = {
                                        lat: position.coords.latitude,
                                        lng: position.coords.longitude
                                    };
                                    AddMarker(pos);
                                    map.setCenter(pos);
                                }, function () {
                                    AddMarker(defaultLatLng);
                                });
                            } else {
                                AddMarker(defaultLatLng);
                            }

                            map.addListener('zoom_changed', function () {
                                map.panTo(marker.getPosition());
                            });
                        }

                        function AddMarker(latlng) {
                            marker = new google.maps.Marker({
                                position: latlng,
                                map: map,
                                draggable: true,
                                animation: google.maps.Animation.DROP
                            });
                        }

                        function GetAddress() {
                            geocodeLatLng();
                            $('#fin').slideDown();
                        }

                        function geocodeLatLng() {
                            var _lat = marker.getPosition().lat();
                            var _lng = marker.getPosition().lng();

                            var latlng = { lat: _lat, lng: _lng };

                            geocoder.geocode({ 'location': latlng }, function (results, status) {
                                if (status === google.maps.GeocoderStatus.OK) {
                                    if (results[1]) {
                                        var address = results[0].formatted_address;

                                        if (results[0].address_components[3].short_name == "IE" || results[0].address_components[4].short_name == "IE") {
                                            document.getElementById("address").value = results[1].formatted_address;
                                            County = results[0].address_components[2].long_name;
                                        }
                                        else {
                                            alert("Not Available In This Location")
                                        }

                                    } else {
                                        alert('No results found');
                                    }
                                } else {
                                    alert('Geocoder failed due to: ' + status);
                                }
                            });
                        }

                        function SaveLocation() {
                            CarParkName = $('#txtName').val();
                            if (CarParkName != null && CarParkName != "") {
                                $('#location').slideUp(1000, function () {
                                    $('#resolution').slideDown(1000);
                                });
                            }
                            else {
                                document.getElementById("pNoName").innerText = "*Name Required";
                            }
                        }
                        /*
                            <form method="post">
                                <input type="submit" name="formSubmit" value="Submit"/>
                            </form>

                            <?php
                             if($_POST['formSubmit'] == "Submit")
                                {
                                        $r = $_POST['r'];
                                        $varFrequency = $_POST['Frequency'];
                                        exec("fswebcam -r $r  --no-banner reference.jpg");
                                }
                            ?>
                        */
						
						/*$(document).ready(function(){
							var res = $('#SelResolution').val();
							
							$("#testRes").click(function() {
										$.ajax({
									type: "POST",
									url: "TakePic.php", //Your required php page
									data: "r="+ res, //pass your required data here
									success: function(response){
										$('#output').html(response);
									}
								});
							//return false;
							});
						});*/
						
                        function TestRes() {
							
							var res = $('#SelResolution').val();
							
							$.ajax({
									type: "POST",
									url: "TakePic.php", //Your required php page
									data: "r="+ res, //pass your required data here
									success: function(response){
										$('#output').html(response);
									}
								});
								
                            //Take Reference Picture
							//exec("fswebcam -r 1920x1080  --no-banner reference.jpg");
							 //$('#imgdiv').slideUp(1000, function(){
								//	Resolution = $('#SelResolution').val();
							
						//	var xmlhttp = new XMLHttpRequest();
							
								//xmlhttp.onreadystatechange = function() {
								//if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
									//document.getElementById("carparkimg").src = xmlhttp.responseText;
								//}
								
							//	xmlhttp.open("POST", "TakePic.php", true);
							//	xmlhttp.send();
								//alert("Taking Picture");
								//$('#carparkimg').src = "Content/carpark.jpg";
								//$('#imgdiv').slideDown(1000);
							 //});
								$('#imgdiv').slideDown(1000);			
                        }

                        function SaveResolution() {
                            Resolution = $('#SelResolution').val();
                            $('#resolution').slideUp(1000, function () {
                                $('#frequency').slideDown(1000);
                            });
                        }

                        function SaveFrequency() {
                            Frequency = $('#SelFrequency').val();
                            $('#frequency').slideUp(1000);
                        }
                    </script>
                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmSz0pkt2C8aCAY6CQAu1PY6PrSHWEOy8&&region=IE&callback=initMap" async defer></script>
                    <br />

                    <input type="button" id="getAddr" class="btn btn-success" value="Select Location" onclick="GetAddress()" />
                    <br />
                    <div id="fin" hidden="hidden">
                        <br />
                        Car Park Name:
                        <input type="text" id="txtName" class="form-control" required="required" />
                        <p id="pNoName" class="text-danger" style="font-size:15px;"></p>
                        Address:
                        <input id="address" type="text" class="form-control" disabled="disabled" />
                        <br />
                        <input type="button" id="saveLocation" class="btn btn-success" value="Save" onclick="SaveLocation()" />
                    </div>
                </div>

                <div id="resolution" hidden="hidden">                                                    
                    <h3>Resolution</h3>
                    <select id="SelResolution" class="form-control">
                        <option value="1920x1080">1920 x 1080 (1080p)</option>
                        <option value="1280x720">1280 x 720 (720p)</option>
                        <option value="858x480">858 x 480 (480p)</option>
                        <option value="480x360">480 x 360 (360p)</option>
                    </select>
                    <br />
                    <input type="button" value="Test Resolution" id="testRes" class="btn btn-success" onclick="TestRes()" /> <!--onclick="TestRes()"-->
					<div id="output"></div>
                    <br />
                    <br />
                    <div id="imgdiv" hidden="hidden">
                        <img id="carparkimg" src="Content/empty_carpark.jpg" width="80%" />
                        <br />
                        <br />
                        <input type="button" value="Save" class="btn btn-success" onclick="SaveResolution()" />
                    </div>
                </div>

                <div id="frequency" hidden="hidden">
                    <h3>Frequency</h3>
                    <select id="SelFrequency" class="form-control">
                        <option value="10">10 Seconds</option>
                        <option value="30">30 Seconds</option>
                        <option value="60">1 Minute</option>
                        <option value="120">2 Minutes</option>
                        <option value="300">5 Minutes</option>
                        <option value="600">10 Minutes</option>
                    </select>
                    <br />
                    <input type="button" value="Save" class="btn btn-success" onclick="SaveFrequency()" />
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<!--#DD8C13 orange
    #5D5D5D grey-->