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
            'id' => array('type' => 'integer', 'null' => false, 'lenght' => 11, 'key' => 'primary'),
            'parent_id' => array('type' => 'integer', 'null' => false, 'lenght' => 11),
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