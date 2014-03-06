<?php
App::uses('Nodeattachment', 'Nodeattachment.Model');

/**
 * Nodeattachment Test Case
 *
 */
class NodeattachmentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.nodeattachment.nodeattachment',
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Nodeattachment = ClassRegistry::init('Nodeattachment.Nodeattachment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Nodeattachment);

		parent::tearDown();
	}

}
