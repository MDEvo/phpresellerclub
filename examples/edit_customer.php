<?php

require '../src/index.php';

$customer = new \Resellerclub\Customer;

$customerDetails = array(
  'username' => 'random@example.com',
  'passwd' => 'Rand124',
  'name' => 'John Doe',
  'company' => 'N/A',
  'address-line-1' => 'Test Address Line',
  'city' => 'Thiruvananthapuram',
  'state' => 'Kerala',
  'country' => 'IN',
  'zipcode' => '695009',
  'phone-cc' => '91',
  'phone' => '9876543210',
  'lang-pref' => 'en',
);

$customerId = '13620823';

$apiOut = $customer->editCustomer($customerId, $customerDetails);

if(TRUE === $apiOut) {
  echo "Success";
} else {
  echo "Failed";
}

