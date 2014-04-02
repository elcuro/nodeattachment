<?php
class First extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'nodeattachments' => array(
					'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
					'node_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
					'filename' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
					'remote_url' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
					'type' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
					'mime' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 50, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
					'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
					'description' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
					'tags' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 250, 'collate' => 'utf8_slovak_ci', 'charset' => 'utf8'),
					'priority' => array('type' => 'integer', 'null' => false, 'default' => '1'),
					'updated' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_slovak_ci', 'engine' => 'InnoDB'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'nodeattachments'
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		return true;
	}
}
