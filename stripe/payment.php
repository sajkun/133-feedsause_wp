<?php
   require_once('../stripe-php-master/init.php');

  // This is your real test secret API key.
  \Stripe\Stripe::setApiKey('sk_test_2Q1phaHMv5bGzvaoWtbATPLW00WuDgpeZW');

  header('Content-Type: application/json');

  try {

    $paymentIntent = \Stripe\PaymentIntent::create([
      'amount' => $_POST['price'],
      'currency' => $_POST['currency'],
    ]);

    $output = [
      'clientSecret' => $paymentIntent->client_secret,
    ];

    echo json_encode($output);
  } catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
  }