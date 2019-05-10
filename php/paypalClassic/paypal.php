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
                <a id="t1" href="https://api.sandbox.paypal.com/nvp&METHOD=SetExpressCheckout">
                </a>
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