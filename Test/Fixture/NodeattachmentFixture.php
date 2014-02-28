<?php
/**
 * NodeattachmentFixture
 *
 */
class NodeattachmentFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'node_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'filename' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
		'remote_url' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
		'type' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
		'mime' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
		'tags' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 250, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
		'updated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_slovak_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'node_id' => 1,
			'user_id' => 1,
			'filename' => 'Lorem ipsum dolor sit amet',
			'remote_url' => 'Lorem ipsum dolor sit amet',
			'type' => 'Lorem ipsum dolor sit amet',
			'mime' => 'Lorem ipsum dolor sit amet',
			'title' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'tags' => 'Lorem ipsum dolor sit amet',
			'updated' => '2014-02-28 12:41:09',
			'created' => '2014-02-28 12:41:09'
		),
	);

}
