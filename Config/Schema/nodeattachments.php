<?php

class NodeattachmentsSchema extends CakeSchema {

        /**
         * Schema name
         *
         * @var string
         */
        public $name = 'Nodeattachments';

        /**
         * CakePHP schema
         *
         * @var array
         */
        public $nodeattachments = array(
            'id' => array('type' => 'integer', 'null' => false, 'lenght' => 8, 'key' => 'primary'),
            'node_id' => array('type' => 'integer', 'null' => false, 'lenght' => 8),
            'slug' => array('type' => 'string', 'null' => false, 'lenth' => 250),
            'path' => array('type' => 'string', 'null' => false, 'default' => NULL),
            'mime_type' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
            'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
            'title' => array('type' => 'string', 'null' => false, 'lenth' => 200),
            'description' => array('type' => 'text', 'null' => true),
            'licence' => array('type' => 'string', 'null' => true, 'lenth' => 200),
            'author' => array('type' => 'string', 'null' => true, 'lenth' => 200),
            'author_url' => array('type' => 'string', 'null' => true, 'lenth' => 200),
            'priority' => array('type' => 'integer', 'lenght' => 3, 'null' => true, 'default' => 1),
            'status' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
            'updated' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
	    'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
            'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
        );

        /**
         * Before callback
         *
         * @param array $event
         * @return void
         */
        public function before($event = array()) {

        }

        /**
         * After callback
         *
         * @param array $event
         * @return void
         */
        public function after($event = array()) {

        }

}

?>