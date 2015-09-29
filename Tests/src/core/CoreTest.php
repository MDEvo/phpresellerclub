<?php

// TODO: use autoloader
require_once __DIR__ . '/../../../src/index.php';

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-09-28 at 22:25:43.
 */
class CoreTest extends PHPUnit_Framework_TestCase {

  /**
   * @var Core
   */
  protected $object;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp() {
    $this->object = new Core;
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown() {
    
  }

  /**
   * @dataProvider providerTestCreateUrlParametersValidValues
   * @covers Core::createUrlParameters
   */
  public function testCreateUrlParametersValidValues($urlArray, $urlString) {
    $this->assertEquals(
        $urlString, $this->object->createUrlParameters($urlArray)
    );
  }

  public function providerTestCreateUrlParametersValidValues() {
    return array(
      array(// Empty array produce empty result
        array(),
        ''
      ),
      array(// Simple parameters
        array(
          'auth-userid' => 'xxxx',
          'api-key' => 'yyyy',
          'domain-name' => 'domain1',
          'tlds' => 'com',
        ),
        'auth-userid=xxxx&api-key=yyyy&domain-name=domain1&tlds=com'
      ),
      array(// Recursive parameters
        array(
          'auth-userid' => 'xxxx',
          'api-key' => 'yyyy',
          'domain-name' => array('domain1', 'domain2'),
          'tlds' => array('com', 'net'),
        ),
        'auth-userid=xxxx&api-key=yyyy&domain-name=domain1&domain-name=domain2&tlds=com&tlds=net'
      ),
    );
  }

  /**
   * @expectedException Exception
   * @covers Core::createUrlParameters
   */
  public function testCreateUrlParametersInvalidValues() {
    $invalidArray = array('someval' => NULL); // NULL is invalid
    $this->object->createUrlParameters($invalidArray);
  }

  /**
   * @dataProvider providerTestCreateUrlValidValues
   * @covers Core::createUrl
   */
  public function testCreateUrlValidValues($urlArray, $urlString) {
    $this->assertEquals(
        $urlString, $this->object->createUrl($urlArray)
    );
  }

  public function providerTestCreateUrlValidValues() {
    return array(
      array(// Empty content is also valid
        array(
          'head' => array(
            'protocol'=> 'https',
            'domain' => 'test.httpapi.com',
            'section' => 'domains',
            'api-name' => 'available',
            'format' => 'json',
          ),
          'content' => array(),
        ),
        'https://test.httpapi.com/api/domains/available.json?',
      ),
      array(// Simple parameters
        array(
          'head' => array(
            'protocol'=> 'https',
            'domain' => 'test.httpapi.com',
            'section' => 'domains',
            'api-name' => 'available',
            'format' => 'json',
          ),
          'content' => array(
            'auth-userid' => 'xxxx',
            'api-key' => 'yyyy',
            'domain-name' => 'domain1',
            'tlds' => 'com',
          ),
        ),
        'https://test.httpapi.com/api/domains/available.json?auth-userid=xxxx'
        . '&api-key=yyyy&domain-name=domain1&tlds=com',
      ),
      array(// Recursive parameters
        array(
          'head' => array(
            'protocol'=> 'https',
            'domain' => 'test.httpapi.com',
            'section' => 'domains',
            'api-name' => 'available',
            'format' => 'json'
          ),
          'content' => array(
            'auth-userid' => 'xxxx',
            'api-key' => 'yyyy',
            'domain-name' => array('domain1', 'domain2'),
            'tlds' => array('com', 'net'),
          ),
        ),
        'https://test.httpapi.com/api/domains/available.json?auth-userid=xxxx'
        . '&api-key=yyyy&domain-name=domain1&domain-name=domain2&tlds=com&tlds=net',
      ),
    );
  }

  /**
   * @covers Core::callApi
   */
  // Commented out as have to find a way to execute tests when API is not available.
//  public function testCallApiReturnsValidData() {
//    $section = 'domains';
//    $apiName = 'available';
//    $urlArray = array(
//      'domain-name' => 'anishsheela',
//      'tlds' => 'com',
//    );
//    $result = $this->object->callApi($section, $apiName, $urlArray);
//    $this->assertNotEmpty($result);
//  }
}