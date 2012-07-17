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

                // convert video
                $is_video = strpos($this->data['Nodeattachment']['mime_type'], 'video');
                if ($is_video === 0) {
                        $this->__createVideoThumb($created);
                        $this->__createFlv($created);
                }

                // set Exif
                $mime_type = $this->data['Nodeattachment']['mime_type'];
                if (($mime_type == 'image/jpeg' || $mime_type == 'image/tiff')) {

                }
        }

        /**
         * After delete callback
         *
         * @return void
         */
        public function afterDelete() {

               $this->unlinkFiles();
        }
        
        /**
         * Delete physically all files from disk for nodeattachment
         *
         * @return void
         */
        private function __unlinkFiles() {
                
                $conf = Configure::read('Nodeattachment');
                $filename_expl = explode('.', $this->data['Nodeattachment']['slug']);
                
                $files_to_delete = array(
                        WWW_ROOT . $this->uploads_dir . DS . $this->data['Nodeattachment']['slug'], // uploaded file
                        $conf['flvDir'] . DS . $filename_expl[0] . '.flv', // flv variant
                        $conf['thumbDir'] . DS . $filename_expl[0] . '.' . $conf['thumbExt'], // video thumb
                );                   
                foreach($files_to_delete as $file) {
                        if (file_exists($file)) {
                                unlink($file);
                        }
                }                
        }

        /**
         * Create flv
         *
         * @param boolean $created
         * @return void
         */
        private function __createFlv($created) {

                $conf = Configure::read('Nodeattachment');
                $source_path = WWW_ROOT . $this->uploads_dir;
                $filename_expl = explode('.', $this->data['Nodeattachment']['slug']);

                if (($conf['ffmpegDir'] <> 'n/a') && $created) {
                        $in = $source_path . DS . $this->data['Nodeattachment']['slug'];
                        $out = $conf['flvDir'] . DS . $filename_expl[0] . '.flv';
                        $cmd = $conf['ffmpegDir'] . "ffmpeg -v 0 -i $in -ar 11025 -qscale 16 $out";
                        //$cmd = $ffmpeg_path ."ffmpeg -i $in -ab 56 -ar 44100 -b 200 -r 15 -s 320x240 -f flv $out 2>&1 &";
                        $this->__execFFmpeg($cmd);
                }
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
                $filename_expl = explode('.', $this->data['Nodeattachment']['slug']);

                if (($conf['ffmpegDir'] <> 'n/a') && $created) {
                        //create thumb
                        $in = $source_path . DS . $this->data['Nodeattachment']['slug'];
                        $out = $conf['thumbDir'] . DS . $filename_expl[0] . '%d.' . $conf['thumbExt'];
                        $cmd = $conf['ffmpegDir'] . "ffmpeg -i $in -pix_fmt rgb24 -vframes 1 -s 600x400 $out";
                        $this->__execFFmpeg($cmd, false);

                        // fix for linux based servers, which accept only outfilename%d.jpg in ffmpeg convert function
                        $old_out = $conf['thumbDir'] . DS . $filename_expl[0] . '1.' . $conf['thumbExt'];
                        $new_out = $conf['thumbDir'] . DS . $filename_expl[0] . '.' . $conf['thumbExt'];
                        rename($old_out, $new_out);
                }
        }

        /**
         * Exec ffmpeg command
         *
         * @param string ffmpeg command
         * @return void
         */
        private function __execFFmpeg($cmd, $exec = true) {

                $conf_exec = Configure::read('Nodeattachment.ffmpegExec');
                
                if (($conf_exec == 1) && ($exec == true)) {
                        $cmd .= ' > /dev/null 2>&1 &';
                        exec($cmd);
                } else {
                        $fh = popen($cmd.'  2>&1', "r" );
                        while( fgets( $fh ) ) { }
                        pclose( $fh );
                }
        }

        /**
         * Get EXIF of file
         *
         * @param string $filename
         * @return array
         */
        public function getExif($filename = null) {

                if (is_null($filename)) {
                        return false;
                }

                App::import('Vendor', 'Nodeattachment.exif-reader.php');
                $er = new phpExifReader($filename);
                $er->processFile();

                return $er->getImageInfo();
        }


}
?>