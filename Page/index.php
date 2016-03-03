<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8" />
    <link href="Content/bootstrap.min.css" rel="stylesheet" />
    <script src="Content/bootstrap.min.js"></script>
    <script src="Content/jquery-2.2.0.min.js"></script>
    <link href="Content/Site.css" rel="stylesheet" />
	<link rel="icon" href="Content/logo.png" sizes="16x16 32x32" type="image/png">
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
						var num = 0;
						// $( document ).ready(function() {
							// initMap()
						// });
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
										
										var x = results[0].address_components.length
										
										var y = results[0].address_components[x-2].long_name;
										
										var z = results[0].address_components[x-1].short_name;
										console.log(y)
										if(z == "IE")
										{
											document.getElementById("address").value = results[1].formatted_address;
											County = y.toString();
											$('#saveLocation').attr("disabled", false);
										}
                                        else {
                                            alert("Not Available In This Location");
											$('#saveLocation').attr("disabled", true);
                                        }

                                    } else {
                                        alert('No results found');
										$('#saveLocation').attr("disabled", true);
                                    }
                                } else {
                                    alert('Geocoder failed due to: ' + status);
									$('#saveLocation').attr("disabled", true);
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
						
                        function TestRes() {
							num++;
							var res = $('#SelResolution').val();
							$('#imgdiv').slideUp(1000, function(){
								$.ajax({
									type: "POST",
									url: "TakePic.php", //Your required php page
									//data: "r="+ res, 
									data: {r: res, n: num},//pass your required data here
									success: function(response){
										$('#output').html(response);
									}
								});
							});	
							setTimeout(ReplacePic, 4000);
                        }
						
						function ReplacePic(){
							var d = document.getElementById("imgdiv");
							
							var i1 = document.getElementById("CarParkImg");
							
							var i = document.createElement("img");
							i.id = "CarParkImg";
							i.src = "Content/carpark"+num+".jpg"
							d.replaceChild(i, i1);
							
							$('#imgdiv').slideDown(4000);	
							
						}
						
                        function SaveResolution() {
                            Resolution = $('#SelResolution').val();
                            $('#resolution').slideUp(1000, function () {
                                $('#frequency').slideDown(1000);
                            });
                        }

                        function SaveFrequency() {
                            Frequency = $('#SelFrequency').val();
                            $('#frequency').slideUp(1000, function () {
                                $('#Finish').slideDown(1000);
                            });
                        }
						
						function SaveChanges(){
							$.ajax({
									type: "POST",
									url: "SaveChanges.php",
									data: {CarParkName: CarParkName, CarParkAddress: County, Resolution: Resolution, Frequency: Frequency, ImageName: "123" },
									success: function(response){
										$('#output1').html(response);
									}
								});
						}
                    </script>
					<!--<script src="https://maps.googleapis.com/maps/api/js"></script> -->
                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDfhqrp6LNGphqO1xUNQJkLuFd0IPgmb8&&region=IE&callback=initMap" async defer></script>
                    <br />

                    <input type="button" id="getAddr" class="btn btn-success" value="Select Location" onclick="GetAddress()" />
                    <br />
                    <div id="fin" hidden="hidden">
                        <br />
                        Car Park Name:
                        <input type="text" id="txtName" class="form-control" required="required" />
                        <p id="pNoName" class="text-danger" style="font-size:15px;"></p>
                        Address:
                        <input id="address" type="text" class="form-control" disabled="disabled" required="required" />
                        <br />
                        <input type="button" id="saveLocation" class="btn btn-success" value="Save" disabled="true" onclick="SaveLocation()" />
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
                        <img id="CarParkImg" width="80%" />
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
				
				<div id="Finish" hidden="hidden">
				<h3>Finish</h3>
				<input type="button" value="Finish" class="btn btn-success" onclick="SaveChanges()" />
				<div id="output1"></div>
				</div>
            </div>
        </div>
    </div>
</body>
</html>
<!--#DD8C13 orange
    #5D5D5D grey-->