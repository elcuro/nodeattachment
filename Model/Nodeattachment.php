<?php
App::uses('NodeattachmentAppModel', 'Nodeattachment.Model');

/**
 * Nodeattachment Model
 *
 * @property Node $Node
 * @property User $User
 */
class Nodeattachment extends NodeattachmentAppModel {

/**
 * Before save callback
 *
 * @param array $options
 * @return void
 **/
	public function beforeSave($options = array()) {

		if (isset($this->data['Nodeattachment']['filename']) &&
			!isset($this->data['Nodeattachment']['mime'])) {
			
            $file = Configure::read('Nodeattachment.uploadServerPath') .
				$this->data['Nodeattachment']['filename'];
			$this->data['Nodeattachment']['mime'] = $this->getMime($file);

			if (!isset($this->data['Nodeattachment']['type'])) {
				$mimeA = explode('/', $this->data['Nodeattachment']['mime']);
				$this->data['Nodeattachment']['type'] = $mimeA[0];
			}
		}
	}

/**
 * Before delete callback
 *
 * @param boolean $cascade
 * @return void
 **/
	public function beforeDelete($cascasde = true) {

        $data = $this->read('Nodeattachment.filename', $this->id);
        if (!empty($data['Nodeattachment']['filename'])) {
        	$this->unlinkFile($this->data['Nodeattachment']['filename']);
        }
        return true;
	}	

/**
 * Unlink file from uploadServerPath
 *
 * @param $filename string only Filename to delete withou path
 * @return void
 **/
	public function unlinkFile($filename) {

		if (!is_string($filename)) {
			return false;
		}

		$path = Configure::read('Nodeattachment.uploadsServerPath') . $filename;
		if (file_exists($path)) {
			return unlink($path);
		}
		return false;
	}	

/**
 * Get mime type of file in $path
 *
 * @param string $file File with full path to check mime
 * @return void
 **/
	public function getMime($file) {
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
			'wma' => 'audio/x-ms-wma',
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

		$ext = pathinfo($file, PATHINFO_EXTENSION);
		if (array_key_exists($ext, $mime_types)) {
			return $mime_types[$ext];
		} elseif (function_exists('finfo_open')) {
			$finfo = finfo_open(FILEINFO_MIME);
			$mimetype = finfo_file($finfo, $file);
			finfo_close($finfo);
			return $mimetype;
		} else {
			return 'application/octet-stream';
		}
    }	
}
