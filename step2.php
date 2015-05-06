<?php

require 'config.php';
require 'Braintree.php';

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId(merchantId);
Braintree_Configuration::publicKey(publicKey);
Braintree_Configuration::privateKey(privateKey);

if (isset($_POST['payment_method_nonce']) && isset($_POST['custid'])) {
	//this stores the payment method against the user in the vault
	$result = Braintree_PaymentMethod::create(array(
		'customerId' => $_POST['custid'],
		'paymentMethodNonce' => $_POST['payment_method_nonce'],
	));

	//then stores the token
	$token = $result->paymentMethod->_attributes['token'];

} else {
	//if no 2 post values then hrmm something is broken
	$token = "Error no Token";
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>A Braintree Dropin Payments Example</title>
    <script src="https://js.braintreegateway.com/v2/braintree.js"></script>
    <link rel='stylesheet' href='/components/bootstrap/dist/css/bootstrap.min.css'>
    <link rel='stylesheet' href='/components/bootstrap/dist/css/custom.css'>
  </head>
  <body>
    <div class='container'>

      <div class="col-md-offset-1 col-md-5 col-xs-12 col-sm-6">
        <p>A test user has been created on the Braintree with customer id <?php echo $_POST['custid'];?></p>
        <p>The Vault token is <?php echo $token;?></p>
      </div>

      <form class='col-md-5 col-xs-12 col-sm-6' action='step3.php' method='post'>

        <div class="row">
          <div class="input-group input-group-lg">
            <input type="text" class="form-control" id="amount" name="amount" aria-describedby="sizing-addon1">
            <span class="input-group-addon" id="sizing-addon1">Amount</span>
          </div>
        </div>

        <div class="row">
          <div id='checkout'>

          </div>
        </div>

        <div class="row">
          <div class="input-group col-md-6">
            <input type='hidden' value='<?php echo $_POST['custid'];?>' name='custid'>
            <input type='hidden' value='<?php echo $token;?>' name='token'>
            <input type='submit' value='Transact against token' class='btn btn-danger btn-lg'>
          </div>
        </div>

      </form>
    </div>

  </body>
</html>
