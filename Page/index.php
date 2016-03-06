<!DOCTYPE html>
<html>
<head>
    <title>ePark Setup</title>
    <meta charset="utf-8" />
    <link href="Content/bootstrap.min.css" rel="stylesheet" />
	<script src="https://code.createjs.com/easeljs-0.8.2.min.js"></script>
    <script src="Content/bootstrap.min.js"></script>
    <script src="Content/jquery-2.2.0.min.js"></script>
    <link href="Content/Site.css" rel="stylesheet" />
	<link href="Content/toastr.min.css" rel="stylesheet"/>
	<script src="Content/toastr.min.js"></script>
	<link rel="icon" href="Content/logo.png" size="16x16" type="image/png">
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
						var GPS;
						var ImageName;
						var NewID;

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
							County = null;
                            var _lat = marker.getPosition().lat();
                            var _lng = marker.getPosition().lng();

                            var latlng = { lat: _lat, lng: _lng };
							GPS = JSON.stringify(latlng);
							
                            geocoder.geocode({ 'location': latlng }, function (results, status) {
                                if (status === google.maps.GeocoderStatus.OK) {
                                    if (results[1]) {
                                        var address = results[0].formatted_address;
										
										var x = results[0].address_components.length
										
										var y = results[0].address_components[x-2].long_name;
										
										var z = results[0].address_components[x-1].short_name;
										//console.log(y)
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
							//geocodeLatLng();
							
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
							Command: toastr["info"]("Taking Picture, Please Wait")

							toastr.options = {
								"closeButton": false,
								"debug": false,
								"newestOnTop": false,
								"progressBar": false,
								"positionClass": "toast-top-right",
								"preventDuplicates": false,
								"onclick": null,
								"showDuration": "300",
								"hideDuration": "1000",
								"timeOut": "5000",
								"extendedTimeOut": "1000",
								"showEasing": "swing",
								"hideEasing": "linear",
								"showMethod": "fadeIn",
								"hideMethod": "fadeOut"
							}
							
							var res = $('#SelResolution').val();
							$('#imgdiv').slideUp(1000, function(){
								$.ajax({
									type: "POST",
									url: "TakePic.php",
									data: {r: res, n: num},
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
							ImageName = "Content/carpark"+num+".jpg";
                            $('#resolution').slideUp(1000, function () {
                                $('#frequency').slideDown(1000);
                            });
                        }

                        function SaveFrequency() {
                            Frequency = $('#SelFrequency').val();
							SaveChanges();
                            $('#frequency').slideUp(1000, function () {
								StartCutting();									
                            });
                        }
						
						function SaveChanges(){
							$.ajax({
									type: "POST",
									url: "SaveChanges.php",
									data: {Name: CarParkName, GPS: GPS, Location: County, Resolution: Resolution, Frequency: Frequency, ImageName: ImageName },
									dataType: "text",
									success: function(response){
										NewID = response;			
									}
								});
						}
						
						var Img;
						var allPoints = [];
						var nodes;
						var underPoint;
						var counter1;
						var connectors;
						var stage;
						var data;
						var canvas;
						var points = [];
						var counter = 0;
						var model = {};
						var clicked = false;
						
						function StartCutting(){
							Img = document.createElement("img");
							Img.src = ImageName;
							$("#canvas").css("background-image", "url(" + ImageName + ")");

							resetDraw();
							stage.update();
							$('#Cutting').slideDown(1000)
						}
						
						function Node(x, y) {
						var circle = new createjs.Shape();
						circle.x = x;
						circle.y = y;
						circle.cursor = "move";
						circle._fill = "#ffa500";

						var dragging = false;

						function drawSprite() {
							circle.graphics.clear().beginFill(circle._fill).drawCircle(0, 0, 2);
						}

						drawSprite();

						circle.on("pressup", function(evt) {
							if (dragging) {
								circle._fill = "#ffa500";
								drawSprite();
								circle.stage.update();
							}
							dragging = false;
						});

						circle.on("mousedown", function(evt) {
							circle._fill = "#f00";
							circle._dragOffset = circle.globalToLocal(evt.stageX, evt.stageY);
							drawSprite();
							dragging = true;
						});

						circle.on("pressmove", function(evt) {
							evt.currentTarget.x = evt.stageX - circle._dragOffset.x;
							evt.currentTarget.y = evt.stageY - evt.currentTarget._dragOffset.y;
							circle.stage.update();
						});

						return circle;
					}
			   
						function resetDraw(parameters) {
							stage = new createjs.Stage("canvas");
							counter1 = 0;

							connectors = new createjs.Shape();
							nodes = new createjs.Container();
							stage.addChild(connectors, nodes);

							stage.on("stagemousedown", function(evt) {
								underPoint = stage.getObjectUnderPoint(evt.stageX, evt.stageY);
								if (!underPoint && counter1 < 4) {
									nodes.addChild(Node(evt.stageX, evt.stageY));
									stage.update();
									counter1++
									return true;
								} else {
									//init();
									return false;
								}
						});

						stage.on("tickstart", function(evt) {
							var g = connectors.graphics;
							g.clear();
							g.setStrokeStyle(1);
							g.beginStroke("#ffa500");
							$.each(nodes.children, function(i, node) {
								if (i == 0) {
									g.moveTo(node.x, node.y);
								} else {
									g.lineTo(node.x, node.y);
								}
							});
							g.endStroke();
						});
					}

						function Cancel() {
							resetDraw();
							stage.update();
							Command: toastr["warning"]("Space not saved")

							toastr.options = {
								"closeButton": false,
								"debug": false,
								"newestOnTop": false,
								"progressBar": false,
								"positionClass": "toast-top-right",
								"preventDuplicates": false,
								"onclick": null,
								"showDuration": "300",
								"hideDuration": "1000",
								"timeOut": "5000",
								"extendedTimeOut": "1000",
								"showEasing": "swing",
								"hideEasing": "linear",
								"showMethod": "fadeIn",
								"hideMethod": "fadeOut"
							}
							
						}

						function init() {
							canvas = document.getElementById("canvas");
							//$("#canvas1").css("background-image", "url(empty_carpark.jpg)");

							var ctx = canvas.getContext("2d");
							//ctx.clearRect(0, 0, canvas.width, canvas.height);

							points[0] = new Array(nodes.children[0].x, nodes.children[0].y);
							points[1] = new Array(nodes.children[1].x, nodes.children[1].y);
							points[2] = new Array(nodes.children[2].x, nodes.children[2].y);
							points[3] = new Array(nodes.children[3].x, nodes.children[3].y);

							drawLines();
							
							clicked = true;
						}

						function drawLines() {
							var ctx = canvas.getContext("2d");

							ctx.beginPath();
							ctx.moveTo(points[0][0], points[0][1]);
							ctx.lineTo(points[1][0], points[1][1]);
							ctx.lineTo(points[2][0], points[2][1]);
							ctx.lineTo(points[3][0], points[3][1]);
							ctx.lineTo(points[0][0], points[0][1]);
							ctx.stroke();
							other();
						}

						function other() {
							var distA = lineDistance(points[0][0], points[0][1], points[1][0], points[1][1])
							var distB = lineDistance(points[1][0], points[1][1], points[2][0], points[2][1])
							var distC = lineDistance(points[2][0], points[2][1], points[3][0], points[3][1])
							var distD = lineDistance(points[3][0], points[3][1], points[0][0], points[0][1])

							var context = canvas.getContext("2d");

							context.moveTo(points[0][0], points[0][1])

							var times = 15;

							var AngleA = Math.atan2(points[1][1] - points[0][1], points[1][0] - points[0][0]);
							var Per_Frame_DistanceA = distA / times;
							var SinA = Math.sin(AngleA) * Per_Frame_DistanceA; //add to y
							var CosA = Math.cos(AngleA) * Per_Frame_DistanceA; //add to x


							var AngleB = Math.atan2(points[2][1] - points[1][1], points[2][0] - points[1][0]);
							var Per_Frame_DistanceB = distB / times;
							var SinB = Math.sin(AngleB) * Per_Frame_DistanceB; //add to y
							var CosB = Math.cos(AngleB) * Per_Frame_DistanceB; //add to x


							var AngleC = Math.atan2(points[3][1] - points[2][1], points[3][0] - points[2][0]);
							var Per_Frame_DistanceC = distC / times;
							var SinC = Math.sin(AngleC) * Per_Frame_DistanceC; //add to y
							var CosC = Math.cos(AngleC) * Per_Frame_DistanceC; //add to x


							var AngleD = Math.atan2(points[3][1] - points[0][1], points[3][0] - points[0][0]) //(points[0][1] - points[3][1], points[0][0] - points[3][0]);
							var Per_Frame_DistanceD = distD / times;
							var SinD = Math.sin(AngleD) * Per_Frame_DistanceD; //add to y
							var CosD = Math.cos(AngleD) * Per_Frame_DistanceD; //add to x

							var AX = points[0][0]
							var AX1 = points[0][0]
							var BX = points[1][0]
							var CX = points[2][0]
							var DX = points[3][0]

							var AY = points[0][1]
							var AY1 = points[0][1]
							var BY = points[1][1]
							var CY = points[2][1]
							var DY = points[3][1]


							for (var i = 0; i < times; i++) {
								context.moveTo(AX += CosA, AY += SinA);
								context.lineTo(DX -= CosC, DY -= SinC);
							}
							context.stroke();
							for (var j = 0; j < times; j++) {
								context.moveTo(BX += CosB, BY += SinB);
								context.lineTo(AX1 += CosD, AY1 += SinD);
							}
							context.stroke();
						}

						function lineDistance(x1, y1, x2, y2) {
							var xs = 0;
							var ys = 0;

							xs = x2 - x1;
							xs = xs * xs;

							ys = y2 - y1;
							ys = ys * ys;

							return Math.sqrt(xs + ys);

						}
					
						function Cut() {
							
							if(clicked == false)
							{
								init();
								//alert("Not Clicked")
							}
							
							var a = { x1: points[0][0], y1: points[0][1] };
							var b = { x2: points[1][0], y2: points[1][1] };
							var c = { x3: points[2][0], y3: points[2][1] };
							var d = { x4: points[3][0], y4: points[3][1] };
							points = [];

							points.push(a);
							points.push(b);
							points.push(c);
							points.push(d);

							model.x1 = a.x1;
							model.y1 = a.y1;
							model.x2 = b.x2;
							model.y2 = b.y2;
							model.x3 = c.x3;
							model.y3 = c.y3;
							model.x4 = d.x4;
							model.y4 = d.y4;
							resetDraw();

							allPoints.push(JSON.parse(JSON.stringify(model)));
							Command: toastr["success"]("Space Saved")

							toastr.options = {
								"closeButton": false,
								"debug": false,
								"newestOnTop": false,
								"progressBar": false,
								"positionClass": "toast-top-right",
								"preventDuplicates": false,
								"onclick": null,
								"showDuration": "300",
								"hideDuration": "1000",
								"timeOut": "5000",
								"extendedTimeOut": "1000",
								"showEasing": "swing",
								"hideEasing": "linear",
								"showMethod": "fadeIn",
								"hideMethod": "fadeOut"
							}
							clicked = false;
						}

						function success() {
							var jsonPoints = JSON.stringify(allPoints);
		
							$.ajax({
									type: "POST",
									url: "SavePoint.php",
									data: {CarPark: NewID, JSONpoints: jsonPoints},
									success: function(response){
										$('#output').html(response);
									}
								});
								
							$('#Cutting').slideUp(1000, function(){
								$('#Finish').slideDown(1000, function(){
									Finish();
								});
							});
						}

						function Finish(){
							$.ajax({
									type: "POST",
									url: "Finish.php",
									dataType: "text",
									data: {CarPark: NewID},
									success: function(response){
										alert(response);
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
                        <input type="button" id="saveLocation" class="btn btn-success" value="Save" disabled onclick="SaveLocation()" />
                    </div>
                </div>

                <div id="resolution" hidden="hidden">                                                    
                    <h3>Resolution</h3>
                    <select id="SelResolution" class="form-control">
                        <option value="1920x1080" disabled>1920 x 1080 (1080p)</option>
                        <option value="1280x720" disabled>1280 x 720 (720p)</option>
                        <option value="858x480">858 x 480 (480p)</option>
                        <option value="480x360" disabled>480 x 360 (360p)</option>
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
				
				<div id="Cutting" hidden="hidden">
					<h3>Spaces</h3>
					<div class="container">
						<canvas id="canvas" width="858px" height="480px" style="border: groove"></canvas>
					</div>
					<button class="btn btn-primary" onclick="init()">Show Grid</button><br/><br/>
					<button class="btn btn-success" onclick="Cut()">Save</button>
					<button class="btn btn-danger" onclick="Cancel()">Cancel</button><br/><br/>
					<input type="button" value="Finish" class="btn btn-success" onclick="success()" />
				</div>
				
				<div id="Finish" hidden="hidden">
					<h3>Setup Complete</h3>
				</div>
				
            </div>
        </div>
    </div>
</body>
</html>
<!--#DD8C13 orange
    #5D5D5D grey-->