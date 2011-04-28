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

                $this->uploads_path = WWW_ROOT . $this->uploads_dir;
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
                
                $allowed_extensions = explode(',', Configure::read('Nodeattachment.allowedFileTypes'));
                $size_limit = Configure::read('Nodeattachment.maxFileSize') * 1024 * 1024;

                App::import('Vendor', 'Nodeattachment.file-uploader.php');
                $uploader = new qqFileUploader($allowed_extensions, $size_limit);
                $result = $uploader->handleUpload($this->uploads_path . DS);
                $uploader_file_name = $uploader->getFilename();

                if (isset($this->params['url']['node_id']) && ($uploader_file_name != false)) {

                        $filename['name'] = Inflector::slug($uploader_file_name['filename']);
                        $filename['ext'] = $uploader_file_name['ext'];
                        $filename = $this->__uniqeSlugableFilename($filename);

                        $old_path = $this->uploads_path . DS .
                                $uploader_file_name['filename'] . '.' . $filename['ext'];
                        $new_path = $this->uploads_path . DS .
                                $filename['name'] . '.' . $filename['ext'];
                        rename($old_path, $new_path);

                        $data = array(
                            'node_id' => $this->params['url']['node_id'],
                            'slug' => $filename['name'] . '.' . $filename['ext'],
                            'path' => '/' . $this->uploads_dir . '/' . $filename['name'] . '.' . $filename['ext'],
                            'title' => $filename['name'],
                            'status' => 1,
                            'mime_type' =>
                                $this->__getMime($this->uploads_path . DS . $filename['name'] . '.' . $filename['ext'])

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
         * Attach storage file
         *
         * @param string $file_path
         * @return void
         */
        public function admin_addStorageFile() {

                App::import('Core', 'File');
                $this->layout = 'ajax';
                $notice = array();

                $storage_dir = Configure::read('Nodeattachment.storageUploadDir');
                $storage_path =  ROOT.DS.APP_DIR.DS.WEBROOT_DIR.DS.$this->uploads_dir.DS.$storage_dir;

                if (empty ($storage_dir) || empty($this->params['named']['node_id'])) {
                        $this->cakeError('error404');
                }

                $node_id = $this->params['named']['node_id'];

                if (!empty($this->params['named']['file'])) {

                        $File = new File($storage_path . DS . $this->params['named']['file']);

                        // don't overwrite previous files that were uploaded and slug filename
                        $filename['name'] = Inflector::slug($File->name());
                        $filename['ext'] = $File->ext();
                        $filename = $this->__uniqeSlugableFilename($filename);

                        $file_name = $filename['name'] . '.' . $filename['ext'];

                        // copy file and save nodeattachment
                        if ($File->copy($this->uploads_path . DS . $file_name, true)) {
                                $data = array(
                                    'node_id' => $node_id,
                                    'slug' => $file_name,
                                    'path' => '/' . $this->uploads_dir . '/' . $file_name,
                                    'title' => $filename['name'],
                                    'status' => 1,
                                    'mime_type' =>
                                        $this->__getMime($this->uploads_path . DS . $file_name)
                                );
                                if ($this->Nodeattachment->save($data)) {
                                        //unlink($storage_path . DS . $this->params['named']['file']);
                                        $notice = array(
                                            'text' => __('File attached', true),
                                            'class' => 'success');
                                } else {
                                        $notice = array(
                                            'text' => __('Error during nodeattachment saving', true),
                                            'class' => 'error');
                                }
                        }
                }

                // list files
                $Folder = new Folder($storage_path);
                $content = $Folder->read();
                $this->set(compact('content', 'node_id', 'notice'));
        }

        /**
         * Unique filename for upload
         *
         * @param array $filename
         * @return array
         */
       private function __uniqeSlugableFilename($filename = array()) {

                while (file_exists($this->uploads_path . DS . $filename['name'] . '.' . $filename['ext'])) {
                        $filename['name'] .= rand(10, 99);
                }
                return $filename;
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
                    'wmv' => 'video/x-ms-wmv',
                    'wma' =>'audio/x-ms-wma',
                    'avi' => 'video/x-msvideo',
                    'flv' => 'video/x-flv',
                    'wav' => 'audio/wav',
                    'mid' => 'audio/mid',
                    'mp4' => 'video/mp4',


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
