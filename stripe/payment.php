<?php
  // $path = 'http://localhost/feedsauce/wp-admin/admin-ajax.php';
  $path = 'http://velesh.ru/demo/feed2/wp-admin/admin-ajax.php';

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => $path,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"pbc\"\r\n\r\n1133\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"action\"\r\n\r\nget_stripe_keys\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
    CURLOPT_HTTPHEADER => array(
      "cache-control: no-cache",
      "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    // echo $response;
  }

  // exit();

  require_once('../stripe-php-master/init.php');

  // This is your real test secret API key. my
  \Stripe\Stripe::setApiKey(str_replace('"','',$response));

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