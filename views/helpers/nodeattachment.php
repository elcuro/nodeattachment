<?php
/**
* Nodeattachment helper
*
* @author Juraj Jancuska <jjancuska@gmail.com>
* @copyright (c) 2010 Juraj Jancuska
* @license MIT License - http://www.opensource.org/licenses/mit-license.php
*/
class NodeattachmentHelper extends AppHelper {
        
        /**
         * Used helpers
         *
         * @var array
         */
        public $helpers = array(
            'Layout'
        );

        /**
         * View nodeattachment
         *
         * @param array $nodeattachment
         * @param array $options
         * @return string
         */
        public function view($nodeattachment, $options = array()) {

                $_options = array(
                    'emptyImage' => true,
                    'width' => 100,
                    'heigt' => 100,
                    'link' => false,
                    'tagAttributes' => array()
                );
        }

        /**
         * View fallback
         *
         * @param string $type Mime type
         * @return string
         */
        private function __viewFallback($type) {


        }
}
