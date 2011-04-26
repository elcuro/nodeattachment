<?php
/**
* Node attachment model
*
* @author Juraj Jancuska <jjancuska@gmail.com>
* @copyright (c) 2010 Juraj Jancuska
* @license MIT License - http://www.opensource.org/licenses/mit-license.php
*/
class Nodeattachment extends NodeattachmentAppModel {

        /**
        * Model name
        *
        * @var string
        */
	public $name = 'Nodeattachment';

        /**
         * uoload dir
         *
         * @var string
         */
        public $uploads_dir = 'uploads';

        /**
         * After find callback
         *
         * @param array $results
         * @param boolean $primary
         * @return array
         */
        public function afterFind($results, $primary) {

                foreach ($results as $key => $result) {
                        if (isset($result[$this->name])) {
                                $results[$key][$this->name] = $this->__thumb($result[$this->name]);
                        }
                }
                return $results;
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
         * After save callback
         *
         * @param array $var
         * @return array
         */
        public function afterSave($created = false) {

                $this->__createVideoThumb($created);
        }

        /**
         * Create and save thumbail for video,
         * if ffmpeg installed
         *
         * @param boolean $created
         * @return void
         */
        private function __createVideoThumb($created) {

                $ffmpeg_path = Configure::read('Nodeattachment.ffmpegDir');
                $thumb_path = APP . 'plugins' . DS . 'nodeattachment' . DS .
                      'webroot' . DS . 'img' . DS . Configure::read('Nodeattachment.thumbnailDir');
                $source_path = WWW_ROOT . $this->uploads_dir;

                $is_video = strpos($this->data['Nodeattachment']['mime_type'], 'video');
                $filename_expl = explode('.', $this->data['Nodeattachment']['slug']);

                if (($ffmpeg_path <> 'n/a') && $created && ($is_video === 0)) {
                        $in = $source_path . DS . $this->data['Nodeattachment']['slug'];
                        $out = $thumb_path . DS . $filename_expl[0] . '.' . Configure::read('Nodeattachment.thumbnailExt');
                        $cmd = $ffmpeg_path . 'ffmpeg -i'." $in -pix_fmt rgb24 -vframes 1 -s 600x400 $out 2>&1";
                        $fh = popen($cmd, "r" );
                        while( fgets( $fh ) ) { }
                        pclose( $fh );
                }
        }


}
?>