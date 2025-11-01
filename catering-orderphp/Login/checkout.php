<?php
require_once 'stripe-php-master/init.php'; // Stripe SDK
\Stripe\Stripe::setApiKey('sk_test_51SM9Zg2MDXCwX5Wwwl0YQ2StH0nAiqV8nDysJ55Ffr9QRuvUIn9vaRv0hGkPmeseTWgfUJw3OQWUxdilyDTo8hsW00wpH1b3z7'); // your Stripe secret key

$link = mysqli_connect("localhost", "root", "", "cateringphp");
if(!$link){ die("DB connection failed: " . mysqli_connect_error()); }

if(!isset($_GET['order_id'])){
    die("Missing order ID.");
}

$order_id = intval($_GET['order_id']);
$result = mysqli_query($link, "SELECT sh_budget, sh_fullname FROM sh_order WHERE id = $order_id");
$order = mysqli_fetch_assoc($result);

if(!$order){
    die("Order not found.");
}

$amount = floatval($order['sh_budget']) * 100; // convert RM to sen
$customerName = htmlspecialchars($order['sh_fullname']);
$YOUR_DOMAIN = 'http://localhost/catering-orderphp'; // replace with your project URL

try {
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card', 'fpx'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'myr',
                'product_data' => [
                    'name' => "Catering Order by {$customerName}",
                ],
                'unit_amount' => $amount,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'metadata' => ['order_id' => $order_id],
        'success_url' => $YOUR_DOMAIN . '/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => $YOUR_DOMAIN . '/cancel.php',
    ]);

    header("Location: " . $checkout_session->url);
    exit;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
