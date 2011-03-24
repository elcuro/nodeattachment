<?php

/**
 * Description of nodeattachments_controller
 *
 * @author Duro
 */
class NodeattachmentController extends NodeattachmentAppController {
        /**
         * Controller Name
         *
         * @var string
         */
        public $name ='Nodeattachment';

        /**
         * Used models
         *
         * @var array
         */
        public $uses = array(
            'Setting',
            'Node',
            'Nodeattachment.Nodeattachment'
        );

        /**
         * Used helpers
         *
         * @var array
         */
        public $helpers = array(
            'Text',
            'Image',
            'Filemanager',
            'Nodeattachment.Javascript',
            'Nodeattachment.Ajax'
        );

        /**
         * uoload dir
         *
         * @var string
         */
        public $uploads_dir = 'uploads';

        /**
        * Before filter callback,
        * disable CSFR security check to avoid security error
        *
        * @return void
        */
        
        function beforeFilter() {
                parent::beforeFilter();
                $this->Security->validatePost = false;
        }

        /**
        * Node attachment index
        *
        * @param  integer $id Node id
        * @return void
        */
        public function admin_index($id) {

                $this->set('title_for_layout', __('Attachments for node', true));

        }

        /**
        * Node attachment index
        *
        * @param  integer $id Node id
        * @return void
        */
        public function admin_nodeIndex($node_id = null) {

                $this->set('title_for_layout', __('Attachments for node', true));

                if (!$node_id) {

                }

                $this->Nodeattachment->recursive = 0;
                $attachments = $this->Nodeattachment->find('all', array(
                    'conditions' => array('node_id' => $node_id),
                    'order' => array('priority ASC')
                ));
                $this->set(compact('attachments'));
                $this->disableCache();
        }

        /**
         * Upload attachment
         *
         * @return void
         */
        public function admin_add() {

                $this->set('title_for_layout', __('Add attachment', true));

                $uploads_path = WWW_ROOT . $this->uploads_dir . DS;

                App::import('Vendor', 'Nodeattachment.file-uploader.php');
                $allowed_extensions = array();
                $size_limit = 2 * 1024 * 1024;
                $uploader = new qqFileUploader($allowed_extensions, $size_limit);
                $result = $uploader->handleUpload($uploads_path);
                $file_name = $uploader->getFilename();

                if (isset($this->params['url']['node_id']) && ($file_name != false)) {
                        $data = array(
                            'node_id' => $this->params['url']['node_id'],
                            'slug' => $file_name['filename'] . '.' . $file_name['ext'],
                            'path' => '/' . $this->uploads_dir . '/' . $file_name['filename'] . '.' . $file_name['ext'],
                            'title' => $file_name['filename'],
                            'status' => 1,
                            'mime_type' =>
                                $this->__getMime($uploads_path . DS . $file_name['filename'] . '.' . $file_name['ext'])

                        );
                        if (!$this->Nodeattachment->save($data)) {
                                $result = array('error' => __('The Attachment could not be saved. Please, try again.', true));
                        }
                }

                Configure::write('debug', 0);
                $this->disableCache();
                $this->render(false);
                echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);

        }

        /**
         * Edit attachment
         *
         * @param integer $id  Attachment id
         * @return void
         */
        public function admin_edit($id) {
                $this->set('title_for_layout', __('Edit attachment', true));
                if (!empty($this->data)) {
                        $this->Nodeattachment->save($this->data);
                        $this->redirect(array('action' => 'nodeIndex', $this->data['Nodeattachment']['node_id']));
                }
                $this->data = $this->Nodeattachment->read(null, $id);
        }

        /**
         * Delete attachment
         *
         * @param integer $id Attachment id
         * @return void
         */
        public function admin_delete($id = null) {
                if (!$id) {
                        // wrond id, redirect
                }
                $attachment = $this->Nodeattachment->read(null, $id);
                if (!$this->Nodeattachment->delete($id)) {
                        // delete error redirect
                }
                unlink(WWW_ROOT . $this->uploads_dir . DS . $attachment['Nodeattachment']['slug']);
                $this->redirect(array('action' => 'nodeIndex', $attachment['Nodeattachment']['node_id']));
        }

        /**
         * Ajax Sort call
         *
         * @return array
         */
        public function admin_sort() {

                Configure::write('debug', 0);
                $this->disableCache();

                $ids = $this->params['form']['nodeattachments'];
                foreach ($ids as $position => $id) {
                        $this->Nodeattachment->id = $id;
                        $position = $position + 3;
                        $this->Nodeattachment->saveField('priority', $position);
                }
                $this->render(false);
        }

        /**
         * Get mimetype of file
         *
         * @param string $file Filename with full path
         * @return string
         */
        private function __getMime($filename) {
                $mime_types = array(
                    'txt' => 'text/plain',
                    'htm' => 'text/html',
                    'html' => 'text/html',
                    'php' => 'text/html',
                    'css' => 'text/css',
                    'js' => 'application/javascript',
                    'json' => 'application/json',
                    'xml' => 'application/xml',
                    'swf' => 'application/x-shockwave-flash',
                    'flv' => 'video/x-flv',
                    // images
                    'png' => 'image/png',
                    'jpe' => 'image/jpeg',
                    'jpeg' => 'image/jpeg',
                    'jpg' => 'image/jpeg',
                    'gif' => 'image/gif',
                    'bmp' => 'image/bmp',
                    'ico' => 'image/vnd.microsoft.icon',
                    'tiff' => 'image/tiff',
                    'tif' => 'image/tiff',
                    'svg' => 'image/svg+xml',
                    'svgz' => 'image/svg+xml',
                    // archives
                    'zip' => 'application/zip',
                    'rar' => 'application/x-rar-compressed',
                    'exe' => 'application/x-msdownload',
                    'msi' => 'application/x-msdownload',
                    'cab' => 'application/vnd.ms-cab-compressed',
                    // audio/video
                    'mp3' => 'audio/mpeg',
                    'qt' => 'video/quicktime',
                    'mov' => 'video/quicktime',
                    // adobe
                    'pdf' => 'application/pdf',
                    'psd' => 'image/vnd.adobe.photoshop',
                    'ai' => 'application/postscript',
                    'eps' => 'application/postscript',
                    'ps' => 'application/postscript',
                    // ms office
                    'doc' => 'application/msword',
                    'rtf' => 'application/rtf',
                    'xls' => 'application/vnd.ms-excel',
                    'ppt' => 'application/vnd.ms-powerpoint',
                    // open office
                    'odt' => 'application/vnd.oasis.opendocument.text',
                    'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
                );

                $ext = strtolower(array_pop(explode('.', $filename)));
                if (array_key_exists($ext, $mime_types)) {
                        return $mime_types[$ext];
                } elseif (function_exists('finfo_open')) {
                        $finfo = finfo_open(FILEINFO_MIME);
                        $mimetype = finfo_file($finfo, $filename);
                        finfo_close($finfo);
                        return $mimetype;
                } else {
                        return 'application/octet-stream';
                }
        }


}
?>
