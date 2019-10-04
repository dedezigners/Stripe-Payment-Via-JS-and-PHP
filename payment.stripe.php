<?php
setcookie("stripeToken", "", time() + (30), "/"); // 86400 = 1 day ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    Stripe.setPublishableKey('STRIPE_PUBLIC_KEY');
    Stripe.card.createToken({
        name: 'Atif Ibrahim',
        number: '4242 4242 4242 4242',
        cvc: '123',
        exp_month: '12',
        exp_year: '2020'
    }, stripeResponseHandler);

    function stripeResponseHandler(status, response) {
        var token = response['id'];
        document.cookie = "stripeToken =" + token;
    }
</script>

<?php
$token = $_COOKIE['stripeToken'];
require_once('vendor/autoload.php');

\Stripe\Stripe::setApiKey('STRIPE_SECRET_KEY');
$charge = \Stripe\Charge::create(['amount' => 10000, 'currency' => 'usd', 'source' => $token]);

if($charge->paid == true) {
    echo '<pre>';
    echo $charge;
    echo '</pre>';
} ?>

</body>
</html>