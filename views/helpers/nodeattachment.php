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
            'Html',
            'Layout',
            'Image2'
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
         * Nodeattachment
         *
         * @var array
         */
        public $nodeattachment = array();

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
         * Node thumb
         *
         * @param string $field Filed of attachment to return
         * @return string Url of the thumb image
         */
        public function nodeThumb($width, $height, $method = 'resizeRatio', $options = array()) {

                $attachment = Set::extract('/Nodeattachment/.[1]', $this->Layout->node);
                $this->setNodeattachment($attachment[0]);
                if (!empty($this->nodeattachment)) {
                        $data = $this->nodeattachment['Nodeattachment'];
                        return $this->Image2->resize($data['thumb_path'], $width, $height, $method, $options, FALSE, $data['server_thumb_path']);
                }
                return false;
        }

        /**
         * Set nodeattachment
         *
         * @param array $var
         * @return void
         */
        public function setNodeattachment($nodeattachment) {

                $model = 'Nodeattachment';
                if (isset($nodeattachment['id'])) {
                        $data = $nodeattachment;
                }
                if (isset($nodeattachment[$model]['id'])) {
                        $data = $nodeattachment[$model];
                }
                $this->nodeattachment[$model] = $this->__thumb($data);
        }

        /**
         * Function description
         *
         * @param array $var
         * @return array
         */
        private function __thumb($data) {

                $file_type = explode('/', $data['mime_type']);
                $file_name = explode('.', $data['slug']);

                // image
                if ($file_type[0] == 'image') {
                        $data['thumb_path'] = $data['path'];
                        $data['server_thumb_path'] = ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.$data['path'];
                        return $data;
                }

                // thumb name with orignial filename
                $thumb_path = APP . 'plugins' . DS . 'nodeattachment' . DS .
                      'webroot' . DS . 'img' . DS . Configure::read('Nodeattachment.thumbnailDir');
                $thumb_filename = $file_name[0] . '.' . Configure::read('Nodeattachment.thumbnailExt');
                if (file_exists($thumb_path . DS . $thumb_filename)) {
                        $data['thumb_path'] = '/nodeattachment/img/'.Configure::read('Nodeattachment.thumbnailDir').'/'.
                                $thumb_filename;
                        $data['server_thumb_path'] = $thumb_path . DS . $thumb_filename;
                        return $data;
                }

                // thumb name with type filename
                $thumb_path = APP . 'plugins' . DS . 'nodeattachment' . DS .
                      'webroot' . DS . 'img';
                $thumb_filename = 'thumb_' . $file_type[0] . '.' . Configure::read('Nodeattachment.thumbnailExt');
                if (file_exists($thumb_path . DS . $thumb_filename)) {
                        $data['thumb_path'] = '/nodeattachment/img/' . $thumb_filename;
                        $data['server_thumb_path'] = $thumb_path . DS . $thumb_filename;
                        return $data;
                } else {
                        $data['thumb_path'] = '/nodeattachment/img/thumb_default.' .
                                Configure::read('Nodeattachment.thumbnailExt');
                        $data['server_thumb_path'] = $thumb_path . DS .
                                'thumb_default.' . Configure::read('Nodeattachment.thumbnailExt');
                        return $data;
                }

        }

        /**
         * Get field from nodeattachment data
         *
         * @param string $field
         * @return void
         */
        public function field($field_name = 'id') {

                $model = 'Nodeattachment';
                if (isset($this->nodeattachment[$model][$field_name])) {
                        return $this->nodeattachment[$model][$field_name];
                } else {
                        return false;
                }
        }

        /**
         * Set nodeattachment field
         *
         * @param string $field_name
         * @param void $value
         * @return boolean
         */
        public function setField($field_name, $value) {

                $model = 'Nodeattachment';
                $this->nodeattachment[$model][$field_name] = $value;
        }

        /**
         * Extract mime types from
         *
         * @param string $type Mime type
         * @return array
         */
        public function filterMime($type = 'image') {

                return $this->extractMimeType($this->Layout->node, $type);
        }

        /**
         * DEPRECATED!!!  use filterMime instead
         * Get attachments
         *
         * @param string $type mime type
         * @return array
         */
        public function getAttachments($type = 'image') {

                return $this->Layout->node['Nodeattachments'][$type];
        }

        /**
         * Extract mime types
         *
         * @param array $node
         * @param string $type Mime Type to extract
         * @return array
         */
        private function extractMimeType($node, $type = 'image') {
                $nodeattachments = Set::extract('/Nodeattachment[mime_type=/' . $type . '(.*)/]', $node);
                return $nodeattachments;
        }
}
