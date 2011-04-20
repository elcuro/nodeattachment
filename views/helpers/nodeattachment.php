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
         * Attachment types
         *
         * @var array
         */
        public $attachment_types = array(
            'video',
            'audio',
            'application',
            'text',
            'image'
        );

        /**
         * After set node callback
         * Set all attachments by types
         *
         * @return void
         */
        public function afterSetNode() {

                foreach ($this->attachment_types as $type) {
                        $attachments[$type] = $this->extractMimeType($this->Layout->node, $type);
                }
                $this->Layout->node['Nodeattachments'] = $attachments;
        }

        /**
         * Get attachments
         *
         * @param string $type mime type
         * @return array
         */
        public function getMimeType($type = 'image') {

                return $this->Layout->node['Nodeattachments'][$type];
        }

        /**
         * Extract mime types
         *
         * @param array $node
         * @param string $type Mime Type to extract
         * @return array
         */
        public function extractMimeType($node, $type = 'image') {
                $nodeattachments = Set::extract('/Nodeattachment[mime_type=/' . $type . '(.*)/]', $node);
                return $nodeattachments;
        }
}
