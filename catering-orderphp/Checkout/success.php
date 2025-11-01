<?php
require 'stripe-php-master/init.php';
\Stripe\Stripe::setApiKey('sk_test_51SM9Zg2MDXCwX5Wwwl0YQ2StH0nAiqV8nDysJ55Ffr9QRuvUIn9vaRv0hGkPmeseTWgfUJw3OQWUxdilyDTo8hsW00wpH1b3z7');

$link = mysqli_connect("localhost", "root", "", "cateringphp");
if(!$link){ die("DB connection failed: " . mysqli_connect_error()); }

if(isset($_GET['session_id'])){
    $session = \Stripe\Checkout\Session::retrieve($_GET['session_id']);
    $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);
    $order_id = $session->metadata->order_id;

    // ✅ Update payment status in database
    mysqli_query($link, "UPDATE sh_order SET payment_status='Paid' WHERE id=$order_id");

    // ✅ Show short success message before redirecting
    echo "<h2 style='text-align:center; color:green;'>✅ Payment Successful!</h2>";
    echo "<p style='text-align:center;'>Thank you, your order has been paid successfully.</p>";
    echo "<p style='text-align:center;'>Redirecting you back to the Order page...</p>";

    // ✅ Redirect to order.php after 3 seconds
    echo "<script>
        setTimeout(function(){
            window.location.href = 'order.php';
        }, 3000);
    </script>";
} else {
    echo "<h3>No payment session found.</h3>";
}
?>