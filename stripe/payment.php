<?php
   require_once('../stripe-php-master/init.php');

  // This is your real test secret API key. my
  \Stripe\Stripe::setApiKey('sk_test_2Q1phaHMv5bGzvaoWtbATPLW00WuDgpeZW');

  // test Omar
  // \Stripe\Stripe::setApiKey('sk_test_oYUyeUvjEgJJ3JoK3CDgbqaE');

   //live key omar
  // \Stripe\Stripe::setApiKey('sk_live_rcxNWHpVZWhhBRRpmtDrbKZw');

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
    // http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
  }