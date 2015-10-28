<?php

require_once __DIR__ . '/../core/Core.php';

class Domain extends Core {

  public function checkAvailability($domainName, $tlds, $suggestAlternatives = FALSE) {
    $avail = array(
      'domain-name' => $domainName,
      'tlds' => $tlds,
      'suggest-alternative' => $suggestAlternatives,
    );
    $apiOut = $this->callApi('domains', 'available', $avail);
    return $apiOut;
  }

  public function checkAvailabilityIdn($domainName, $tld, $idnLanguageCode) {
    $punyDomain = array();
    if (is_array($domainName)) {
      foreach ($domainName as $domain) {
        // Convert domain to puny code so that it can be
        // handled in ASCII itself
        $punyDomain[] = idn_to_ascii($domain);
      }
    }
    else {
      $punyDomain[] = idn_to_ascii($domainName);
    }
    $avail = array(
      'domain-name' => $punyDomain,
      'tlds' => $tld,
      'idn-languagecode' => $idnLanguageCode,
    );
    $apiOut = $this->callApi('domains', 'idn-available', $avail);
    return $apiOut;
  }

  public function checkAvailabilityPremium($keyWord, $tlds, $options) {
    // TODO: Rewrite using new API call
    $options['key-word'] = $keyWord;
    $options['tlds'] = $tlds;
    $apiOut = $this->callApi('domains', 'available', $options, 'premium');
    return $apiOut;
  }

  public function domainSuggestions($keyWord, $tld = NULL, $exactMatch = FALSE) {
    // TODO: Rewrite using new API call
    $options['key-word'] = $keyWord;
    $options['tld-only'] = $tld;
    $options['exact-match'] = $exactMatch;
    $apiOut = $this->callApi('domains', 'suggest-names', $options, 'v5');
    return $apiOut;
  }

  public function register($domainName, $options) {
    $options['domain'] = $domainName;
    $apiOut = $this->callApi('domains', 'register', $options);
  }

  public function transfer($domain, $options) {
    $options['domain'] = $domain;
    $apiOut = $this->callApi('domains', 'transfer', $options);
  }

  public function submitAuthCode($orderId, $authCode) {
    $options = array(
      'order-id' => $orderId,
      'auth-code' => $authCode,
    );
    $apiOut = $this->callApi('domains', 'submit-auth-code', $options, 'transfer');
  }

  public function validateTransfer($domain) {
    $options = array(
      'domain-name' => $domain,
    );
    $apiOut = $this->callApi('domains', 'validate-transfer', $options);
  }

  public function renew($orderid, $options) {
    $options['order-id'] = $domain;
    $apiOut = $this->callApi('domains', 'renew', $options);
  }

  public function searchDomain($options, $page = 1, $count = 10) {
    $options['no-of-records'] = $count;
    $options['page-no'] = $page;
    $apiOut = $this->callApi('domains', 'search', $options);
  }

  public function getDefaultNameServer($customerId) {
    $options = array(
      'customer-id' => $customerId,
    );
    $apiOut = $this->callApi('domains', 'customer-default-ns', $options);
  }

  public function getOrderId($domain) {
    $options = array(
      'domain' => $domain,
    );
    $apiOut = $this->callApi('domains', 'orderid', $options);
  }

  public function getDomainDetailsByOrderId($orderId, $options) {
    // Since a parameter name is options, we are using variable as apiOptions
    $apiOptions = array(
      'order-id' => $orderId,
    );
    if (is_string($options)) {
      $apiOptions['options'] = $options;
    }
    else {
      $apiOptions['options'] = $apiOptions['options'];
    }
    $apiOut = $this->callApi('domains', 'details', $apioptions);
  }

  public function getDomainDetailsByDomain($domain, $options) {
    // Since a parameter name is options, we are using variable as apiOptions
    $apiOptions = array(
      'domain-name' => $orderId,
    );
    if (is_string($options)) {
      $apiOptions['options'] = $options;
    }
    else {
      $apiOptions['options'] = $apiOptions['options'];
    }
    $apiOut = $this->callApi('domains', 'details-by-name', $apioptions);
  }

  public function setNameServer($orderId, $ns) {
    $options = array(
      'order-id' => $orderId,
      'ns' => $ns,
    );
    $apiOut = $this->callApi('domains', 'modify-ns', $options);
  }

  public function setChildNameServer($orderId, $cns, $ips) {
    $options = array(
      'order-id' => $orderId,
      'cns' => $cns,
      'ip' => $ips,
    );
    $apiOut = $this->callApi('domains', 'add-cns', $options);
  }

  public function modifyChildNameServerHost($orderId, $oldCns, $newCns) {
    $options = array(
      'order-id' => $orderId,
      'old-cns' => $oldCns,
      'new-cns' => $newCns,
    );
    $apiOut = $this->callApi('domains', 'modify-cns-name', $options);
  }

  public function modifyChildNameServerIp($orderId, $cns, $oldIp, $newIp) {
    $options = array(
      'order-id' => $orderId,
      'cns' => $cns,
      'old-ip' => $oldIp,
      'new-ip' => $newIp,
    );
    $apiOut = $this->callApi('domains', 'modify-cns-ip', $options);
  }

  public function deleteChildNameServer($orderId, $cns, $ip) {
    $options = array(
      'order-id' => $orderId,
      'cns' => $cns,
      'ip' => $ip,
    );
    $apiOut = $this->callApi('domains', 'delete-cns-ip', $options);
  }

  public function modifyDomainContacts($orderId, $contactIds) {
    $options['order-id'] = $orderId;
    $apiOut = $this->callApi('domains', 'modify-contact', $options);
  }

  public function addPrivacyProtection($orderId, $invoiceOption) {
    $options = array(
      'order-id' => $orderId,
      'invoice-option' => $invoiceOption,
    );
    $apiOut = $this->callApi('domains', 'purchase-privacy', $options);
  }

  public function modifyPrivacyProtection($orderId, $protectPrivacy, $reason) {
    $options = array(
      'order-id' => $orderId,
      'protect-privacy' => $protectPrivacy,
      'reason' => $reason,
    );
    $apiOut = $this->callApi('domains', 'modify-privacy-protection', $options);
  }

  public function modifyAuthCode($orderId, $authCode) {
    $options = array(
      'order-id' => $orderId,
      'auth-code' => $authCode,
    );
    $apiOut = $this->callApi('domains', 'modify-auth-code', $options);
  }

  public function modifyTheftProtection($orderId, $status) {
    // Involves 2 API calls
    if (TRUE == $status) {
      $options = array(
        'order-id' => $orderId,
      );
      $apiOut = $this->callApi('domains', 'enable-theft-protection', $options);
    }
    else {
      $options = array(
        'order-id' => $orderId,
      );
      $apiOut = $this->callApi('domains', 'disable-theft-protection', $options);
    }
  }

  public function suspendDomain($orderId, $reason) {
    $options = array(
      'order-id' => $orderId,
      'reason' => $reason,
    );
    $apiOut = $this->callApi('orders', 'suspend', $options);
  }

  public function unsuspendDomain($orderId) {
    $options = array(
      'order-id' => $orderId,
    );
    $apiOut = $this->callApi('orders', 'unsuspend', $options);
  }

  public function deleteDomain($orderId) {
    $options = array(
      'order-id' => $orderId,
    );
    $apiOut = $this->callApi('domains', 'delete', $options);
  }

  public function restoreDomain($orderId, $invoiceOption) {
    $options = array(
      'order-id' => $orderId,
      'invoice-option' => $invoiceOption
    );
    $apiOut = $this->callApi('domains', 'restore', $options);
  }

}
