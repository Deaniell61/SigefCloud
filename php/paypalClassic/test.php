<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">
    <div class="row product">
        <div class="col-md-4">
            <h3>Toy Story Woody T-Shirt</h3>
            <p>
                <a id="t1" href="http://166.78.8.98/cgi-bin/aries.cgi?sandbox=1&direct=1&returnurl=http://166.78.8.98/cgi-bin/return.htm&cancelurl=http://166.78.8.98/cgi-bin/cancel.htm">
                </a>
            </p>
        </div>
    </div>
    <div class="row product">
        <div class="col-md-4">
            <h3>Toy Story Rex T-Shirt</h3>
            <p>
            <form id="t2" method="POST" action="http://166.78.8.98/cgi-bin/aries.cgi?sandbox=1&direct=1&returnurl=http://166.78.8.98/cgi-bin/return.htm&cancelurl=http://166.78.8.98/cgi-bin/cancel.htm">
            </form>
            </p>
        </div>
    </div>
</div>
<script>
    window.paypalCheckoutReady = function() {
        paypal.checkout.setup("6XF3MPZBZV6HU", {
            locale: 'en_US',
            environment: 'sandbox',
            container: ['t1', 't2']
        });
    }
</script>
<script async src="//www.paypalobjects.com/api/checkout.js"></script>
</body>