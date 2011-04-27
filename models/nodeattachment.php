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

                $conf = Configure::read('Nodeattachment');
                $source_path = WWW_ROOT . $this->uploads_dir;

                $is_video = strpos($this->data['Nodeattachment']['mime_type'], 'video');
                $filename_expl = explode('.', $this->data['Nodeattachment']['slug']);

                if (($conf['ffmpegDir'] <> 'n/a') && $created && ($is_video === 0)) {
                        //create thumb
                        $in = $source_path . DS . $this->data['Nodeattachment']['slug'];
                        $out = $conf['thumbDir'] . $filename_expl[0] . '%d.' . $conf['thumbExt'];
                        $cmd = $ffmpeg_path . "ffmpeg -i $in -pix_fmt rgb24 -vframes 1 -s 600x400 $out 2>&1";
                        $this->__execFFmpeg($cmd);
                        // fix for linux based servers, which accept only out%d.jpg in ffmpeg convert function
                        $old_out = $conf['thumbDir'] . DS . $filename_expl[0] . '1.' . $conf['thumbExt'];
                        $new_out = $conf['thumbDir'] . DS . $filename_expl[0] . '.' . $conf['thumbExt'];
                        rename($old_out, $new_out);

                        // create flv
                        if ($filename_expl[1] <> 'flv') {
                                $out = $conf['flvDir'] . DS . $filename_expl[0] . '.flv';
                                $cmd = $conf['ffmpegDir'] . "ffmpeg -v 0 -i $in -ar 11025 $out > tmp.log 2>&1 &";
                                //$cmd = $ffmpeg_path ."ffmpeg -i $in -ab 56 -ar 44100 -b 200 -r 15 -s 320x240 -f flv $out 2>&1 &";
                                $this->__execFFmpeg($cmd);
                        }
                }
        }

        /**
         * Exec ffmpeg command
         *
         * @param string ffmpeg command
         * @return void
         */
        private function __execFFmpeg($cmd = null) {

                /*if (!is_null($cmd)) {
                        $fh = popen($cmd, "r" );
                        while( fgets( $fh ) ) { }
                        pclose( $fh );
                }*/
                if (!is_null($cmd)) {
                        exec($cmd);
                }
        }


}
?>