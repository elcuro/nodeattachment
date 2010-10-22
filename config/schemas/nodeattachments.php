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
            'node_id' => array('type' => 'integer', 'null' => true, 'lenght' => 8),
            'parent_node_id' => array('type' => 'integer', 'null' => true, 'lenght' => 8),
            'parent_id' => array('type' => 'integer', 'null' => true, 'lenght' => 8, 'default' => null),
            'lft' => array('type' => 'integer', 'null' => true, 'length' => 8, 'default' => null),
            'rght' => array('type' => 'integer', 'null' => true, 'length' => 8, 'default' => null),
            'tableParameters' => array('charset' => 'utf8', 'engine' => 'MyISAM')
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