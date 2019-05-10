<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/php/coneccion.php";

$couponQuery = "
    SELECT
        *
    FROM
        fb_cotd_config
    ORDER BY 
        id DESC LIMIT 1;
";

$couponResult = mysqli_query(conexion("Demo"), $couponQuery);

if ($couponResult->num_rows == 1) {
    $couponRow = mysqli_fetch_array($couponResult);
    $sku = $couponRow["sku"];
    $date = date("Y-m-d\TH:i:s", strtotime($couponRow['date']));

    $productQuery = "
        SELECT 
            *
        FROM
            cat_prod
        WHERE
            mastersku = '$sku';
    ";

    $productResult = mysqli_query(conexion("Guatemala"), $productQuery);

    $productRow = mysqli_fetch_array($productResult);

    $productImage = "https://sigefcloud.com/imagenes/media/guatedirect_llc" . $productRow["IMAURLBASE"];
    $productName = $productRow["PRODNAME"];
    $productDescription = $productRow["DESCPROD"];
} else {

}

$link = "http://www.guatedirect.com/b-b-picamas-green-hot-sauce-3-52-oz-salsa-verde-picante.html";
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

    <title>coupon of the day</title>
</head>
<body>
<div class="row">
    <div class="col-8 offset-2 text-center">
        <h2><p id="countdown">0d 0h 0m 0s</p></h2>
    </div>
</div>
<div class="row">
    <div class="col-4 offset-4">
        <a href="<?php echo $link ?>" target="_blank">
            <img src="<?php echo $productImage ?>" class="rounded img-thumbnail">
        </a>
    </div>
</div>
<div class="row my-3">
    <div class="col-8 offset-2">
        <input disabled id="redeem" type="button" class="btn btn-primary btn-block btn-lg" value="redeem">
    </div>
</div>
<div class="row">
    <div class="col-8 offset-2">
        <h3><?php echo $productName ?></h3>
    </div>
</div>
<div class="row">
    <div class="col-8 offset-2">
        <?php echo $productDescription ?>
    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function () {

        var isLoggedIn = false;

        window.fbAsyncInit = function () {
            FB.init({
                appId: '221474828590394',
                cookie: true,
                xfbml: true,
                version: 'v2.12'
            });

            FB.getLoginStatus(function (response) {
                statusChangeCallback(response);
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        $("#submit").click(function () {
            var sku = $("#sku").val();
            var date = $("#date").val();
            console.log(sku + " - " + date);
            $.ajax({
                url: "storeCoupon.php",
                type: "POST",
                data: {
                    sku: sku,
                    date: date,
                },
                success: function (response) {
                    console.log("success " + response);
                },
                error: function (response) {
                    console.log("error " + response);
                }
            });
        })

        /**/

        var countDownDate = new Date('<?php echo $date ?>').getTime();

        // Update the count down every 1 second
        var x = setInterval(function () {

            var now = new Date().getTime();
            var distance = countDownDate - now;

            if (distance > 0) {
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                document.getElementById("countdown").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
                document.getElementById("redeem").disabled = false;
            } else {
                clearInterval(x);
                document.getElementById("countdown").innerHTML = "EXPIRED";
                document.getElementById("redeem").disabled = true;
                document.getElementById("redeem").className = "btn btn-secondary btn-block btn-lg";
            }

        }, 1000);

        $("#redeem").click(function () {
            if(isLoggedIn){
                postCoupon();
            }
            else{
                FB.login(function (response) {
                    if (response.authResponse) {
                        postCoupon();
                    }
                }, {scope: 'email,user_likes,publish_actions'});
            }
        });

        function statusChangeCallback(response) {
            if (response.status === 'connected') {
                isLoggedIn = true;
            }
        }
    });

    function postCoupon() {
        FB.api('/me/feed', 'POST', {
            'message': "I got a free coupon from world direct to buy this item! Get yours before they run out!",
            'picture': "<?php echo $productImage ?>",
            'link': "<?php echo $link ?>",
            'name': 'Worldirect FREE Coupon!',
        }, function (response) {
            console.log(response);
        });
    }
</script>