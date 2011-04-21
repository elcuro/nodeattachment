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

                if (!empty($ffmpeg_path) && $created && ($is_video === 0)) {
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