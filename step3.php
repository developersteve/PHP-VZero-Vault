<?php

require 'config.php';
require 'Braintree.php';

Braintree_Configuration::environment('sandbox');
Braintree_Configuration::merchantId(merchantId);
Braintree_Configuration::publicKey(publicKey);
Braintree_Configuration::privateKey(privateKey);

// print_r($_POST);

if (isset($_POST['token']) && isset($_POST['custid']) && isset($_POST['amount'])) {

	//transact against the token
	$result = Braintree_Transaction::sale(array(
		'amount' => $_POST['amount'],
		'customerId' => $_POST['custid'],
		'paymentMethodToken' => $_POST['token'],
	));

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
        <p>The Vault token is <?php echo $_POST['token'];?></p>
        <p>Transaction Complete, transaction id <?php echo $result->transaction->_attributes['id'];?></p>
      </div>

      <div class="col-md-offset-1 col-md-5 col-xs-12 col-sm-6">
        <pre>
          <?php print_r($result);?>
        </pre>
      </div>

    </div>

  </body>
</html>
