<?php
App::uses('NodeattachmentAppController', 'Nodeattachment.Controller');
App::import('Vendor', 'Nodeattachment.valums-file-uploader/server/php');

/**
 * Nodeattachments Controller
 *
 */
class NodeattachmentsController extends NodeattachmentAppController {

/**
 * Components
 *
 * @var array
 **/
	 public $components = array(
	 	'RequestHandler',
	 	'Security'
	 );

/**
* Before filter callback,
* disable CSFR security check to avoid security error
*
* @return void
*/
	function beforeFilter() {

		parent::beforeFilter();
		$this->Security->csrfCheck = false;
		$this->Security->enable = false;
		$this->Security->validatePost = false;
	}	 

/**
 * Ajax upload with Valums File Uploader
 *
 * @return void
 **/
	public function admin_upload($node_id = null) {

		$this->_setResponse(400, __d('nodeattachment', 'Can not upload file(s)'));

		if (is_null($node_id)) {
			return;
		}

		$allowedExtensions = array_map('trim', 
			explode(',', Configure::read('Nodeattachment.allowedExtensions')));
		$sizeLimit = Configure::read('Nodeattachment.sizeLimit') * 1048576;
		$Uploader = new qqFileUploader($allowedExtensions, $sizeLimit);

		$result = $Uploader->handleUpload(Configure::read('Nodeattachment.uploadsServerPath'));		
		if (isset($result['success'])) {
			$filename = basename($result['savePath']);				
			$data = array(
				'node_id' => $node_id,
				'filename' => $filename,				
				'title' => $filename
			);
			if ($this->Nodeattachment->save($data)) {	
				$this->_setResponse(200, __d('nodeattachment', 'File uploaded'));
				$this->set('nodeattachment', 
					$this->Nodeattachment->findById($this->Nodeattachment->id)
				);
			}
		}	
	}

/**
 * Upload remote file
 *
 * @return void
 **/
	public function admin_remote() {

		$this->_setResponse(400, __d('nodeattachment', 'Url can not be uploaded'));

		$this->ndata = array(
			'node_id' => $this->request->data['pk'],
			'remote_url' => $this->request->data['value']
		);

        if ($this->ndata['remote_url'] = $this->_normalizeUrl($this->ndata['remote_url'])) { 
            Croogo::dispatchEvent('Controller.Nodeattachments.remote', $this, $this->ndata);
        }
        
        if (isset($this->ndata['title'])) {
			if ($this->Nodeattachment->save($this->ndata)) {	
				$this->_setResponse(200, __d('nodeattachment', 'Upload OK'));
				$this->set('nodeattachment', 
					$this->Nodeattachment->findById($this->Nodeattachment->id));
			}
        }
	}	
    
/**
 * Normalize url
 *
 * @param string $url
 * @return void
 **/
	protected function _normalizeUrl($url = '') {
        
        if (empty($url)) {
            return false;
        }
        $url = trim($url);
        if (strpos($url, 'http://') === false ) {
            $url = 'http://' . $url;
        } 
        return $url;
    }

/**
 * Update title and description via X-editable ajax request
 *
 * @return void
 **/
	public function admin_update() {

		$this->_setResponse(400, __d('nodeattachment', 'Field can not be updated'));

		$data = array(
			'id' => $this->request->data['pk'],
			$this->request->data['name'] => $this->request->data['value']
		);
		if ($res = $this->Nodeattachment->save($data)) {
			$this->_setResponse(200, __d('nodeattachment', 'Updated succesfully'));
		}
	}

/**
* Ajax Sort call
*
* @return array
*/
	public function admin_sort() {

		$this->disableCache();
		$this->_setResponse(400);

		$ids = $this->request->query['na'];
		foreach ($ids as $position => $id) {
			$this->Nodeattachment->id = $id;
			$position = $position + 3;
			if ($this->Nodeattachment->saveField('priority', $position)) {
				$this->_setResponse(200);
			}
		}
	}	

/**
 * Delete nodeattachment via ajax
 *
 * @param integer $id
 * @return void
 **/
	public function admin_delete($id = null) {

		$this->_setResponse(400);
		if (is_null($id)) {
			return;
		}
		if ($this->Nodeattachment->delete($id)) {
			$this->_setResponse(200);
		}
	}	

/**
 * Set response for ajax request
 *
 * @param integer $code Http status code
 * @param string $message Message
 * @return void
 **/
	protected function _setResponse($code, $message = '') {

		if ($code == 200) {
			$this->response->statusCode(200);
			$this->set('success', true);            
		} else {
			$this->response->statusCode($code);
			$this->set('success', false);
		}
        $this->set('message', $message);
	}
}
