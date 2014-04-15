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
		ob_flush();
	}

/**
 * Test get mime of file
 *
 * @return void
 **/
	public function testGetMimeImage() {

		$path = App::pluginPath('Nodeattachment'). 'Test' . DS . 'uploads' . DS . 'image.jpg';
		$res = $this->Nodeattachment->getMime($path);
		$this->assertEquals('image/jpeg', $res);
	}

	public function testGetMimeApplication() {

		$path = App::pluginPath('Nodeattachment'). 'Test' . DS . 'uploads' . DS . 'pdfapp.pdf';
		$res = $this->Nodeattachment->getMime($path);
		$this->assertEquals('application/pdf', $res);
	}


}
