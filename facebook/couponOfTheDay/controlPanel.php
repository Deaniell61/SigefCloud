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
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
<!--    <link rel="stylesheet"-->
<!--          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"-->
<!--          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"-->
<!--          crossorigin="anonymous">-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

    <link rel="stylesheet"
          href="bootstrap.min.css">

    <title>coupon of the day - control panel</title>
</head>
<body>
<div class="row my-5">
    <div class="col-10 offset-1">
        <h1 class="display-4">coupon of the day - control panel</h1>
    </div>
</div>
<div class="row">
    <div id="successAlert" class="col-10 offset-1">

    </div>
</div>
<div class="row">
    <div class="col-10 offset-1">
        <form action="storeCoupon.php"
              method="post">
            <div class="form-group">
                <label for="sku">sku</label>
                <input type="text"
                       class="form-control"
                       id="sku"
                       name="sku"
                       value="<?php echo $sku ?>">
            </div>
            <div class="form-group">
                <label for="date">date</label>
                <input type="datetime-local"
                       class="form-control"
                       id="date"
                       name="date"
                       value="<?php echo $date ?>">
            </div>
            <button type="button"
                    class="btn btn-primary"
                    id="submit">submit
            </button>
        </form>
    </div>
</div>
</body>
</html>

<script>
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
                $('#successAlert').html('' +
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">\n' +
                    '    <strong>coupon saved!</strong> new coupon saved to database\n' +
                    '    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                    '        <span aria-hidden="true">&times;</span>\n' +
                    '    </button>\n' +
                    '</div>' +
                    '');
            },
            error: function (response) {
                console.log("error " + response);
            }
        });
    })
</script>