<?php
$servername = "eu-cdbr-azure-west-d.cloudapp.net";
$username = "b2d171ae38f795";
$password = "ad220908";
$dbname = "EparkDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET["id"];

$sql = "SELECT Resolution, Frequency, ImageName FROM carparks Where ID = $id";
$result = $conn->query($sql);
$rs = $result->fetch_array(MYSQLI_ASSOC);
$conn->close();

$Resolution = $rs["Resolution"];
$Frequency = $rs["Frequency"];
$ImageName = $rs["ImageName"];

exec("fswebcam -r $Resolution --no-banner Content/compare.jpg");
?>
<meta http-equiv="refresh" id="refresh">
<img id="carPark" crossOrigin="anonymous" hidden>
<img id="carPark2" crossOrigin="anonymous" hidden>
<canvas id="myCanvas" width="858px" height="480px"></canvas>
<canvas id="myCanvas2" width="858px" height="480px"></canvas>
<canvas id="myCanvas3" hidden></canvas>
<canvas id="myCanvas4" hidden></canvas>
<img id="im1" hidden/>
<img id="im2" hidden/>
<link href="Content/Site.css" rel="stylesheet"/>
<script src="Content/jquery-2.2.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    var id;
    var ImageName;
    var Frequency;
    var sp = {};
    $(document).ready(function () {
        id = "<?php echo $id; ?>";
        ImageName = "<?php echo $ImageName; ?>";
        Frequency = "<?php echo $Frequency; ?>";

        var meta = document.getElementById("refresh");
        meta.content = Frequency;

        var img = document.getElementById("carPark");
        img.src = ImageName;
        $("#myCanvas").css("background-image", "url(" + ImageName + ")");

        img = document.getElementById("carPark2");
        img.src = "Content/compare.jpg";
        $("#myCanvas2").css("background-image", "url(Content/compare.jpg)");

		GetSpacesUsingAjax();
        //setTimeout(GetSpacesUsingAjax, 1000);
    });

    function GetSpacesUsingAjax() {
        $.ajax({
            type: "POST",
            url: "GetSpace.php",
            dataType: "text",
            data: "id=" + id,
            success: function (response) {
                var obj = JSON.parse(response);
                sp = obj.space;
            }
        });
		Cut();
        //setTimeout(Cut, 1000);
    }

    function Cut() {
        $.each(sp, function (j) {

            var a = {x: sp[j].x1, y: sp[j].y1};
            var b = {x: sp[j].x2, y: sp[j].y2};
            var c = {x: sp[j].x3, y: sp[j].y3};
            var d = {x: sp[j].x4, y: sp[j].y4};

            var points = [];

            points.push(a);
            points.push(b);
            points.push(c);
            points.push(d);

            var img = document.getElementById("carPark");
            var c = document.getElementById("myCanvas3");
            c.height = img.height;
            c.width = img.width;
            var ctx = c.getContext("2d");

            ctx.beginPath();
            ctx.moveTo(points[0].x, points[0].y);

            for (var i = 1; i < points.length; i++) {
                //var p = points[i];
                ctx.lineTo(points[i].x, points[i].y);
            }
            ctx.closePath();

            ctx.clip();

            ctx.drawImage(img, 0, 0);
            var img1 = ctx.getImageData(0, 0, img.width, img.height);

            img = document.getElementById("carPark2");
            var c1 = document.getElementById("myCanvas4");
            c1.height = img.height;
            c1.width = img.width;
            ctx = c1.getContext("2d");

            ctx.beginPath();
            ctx.moveTo(points[0].x, points[0].y);

            for (var i = 1; i < points.length; i++) {
                //var p = points[i];
                ctx.lineTo(points[i].x, points[i].y);
            }
            ctx.closePath();

            ctx.clip();

            ctx.drawImage(img, 0, 0);
            var img2 = ctx.getImageData(0, 0, img.width, img.height);

            compare(img1, img2, sp[j], function (result) {
                console.log(result)
            });
        });

        updateSpaces();
    }

    function updateSpaces() {
        var jsonPoints = JSON.stringify(sp);

        $.ajax({
            type: "POST",
            url: "UpdateFull.php",
            dataType: "text",
            data: "JSONpoints=" + jsonPoints,
            success: function () {
                UpdateCarPark();
            }
        });


    }

    function UpdateCarPark() {
        $.ajax({
            type: "POST",
            url: "UpdateFreeSpaces.php",
            dataType: "text",
            data: "id=" + id
        });
    }

    function compare(img1, img2, sp, callback) {
        if (img1.width !== img2.width || img1.height != img2.height) {
            callback(NaN);
            return;
        }

        var diff = 0;

        for (var i = 0; i < img1.data.length / 4; i++) {
            diff += Math.abs(img1.data[4 * i] - img2.data[4 * i]) / 255;
            diff += Math.abs(img1.data[4 * i + 1] - img2.data[4 * i + 1]) / 255;
            diff += Math.abs(img1.data[4 * i + 2] - img2.data[4 * i + 2]) / 255;
        }

        var x = 100 * diff / (img1.width * img1.height * 3);
        callback(x);
        output(x, sp);
    }

    function output(res, sp) {
        if (res.toFixed(2) > 0.65){
        //if (res.toFixed(2) > 0.18) {
            sp.full = 1;
        } else {
            sp.full = 0;
        }
    }
</script>
