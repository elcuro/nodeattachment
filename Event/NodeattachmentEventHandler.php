<?php

App::uses('CakeEventListener', 'Event');
App::uses('Nodeattachment', 'Nodeattachment.Model');

/**
 * Nodeattachment Event Handler
 *
 * @category Event
 * @package  Croogo
 * @version  1.0
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class NodeattachmentEventHandler extends Object implements CakeEventListener {

/**
 * implementedEvents
 *
 * @return array
 */
	public function implementedEvents() {
		return array(
			'Controller.Nodes.afterDelete' => array(
				'callable' => 'onNodesAfterDelete',
			),
			'Controller.Nodeattachments.remote' => array(
				'callable' => 'onNodeattachmentsRemote'
			)
		);
	}

/**
 * onNodeasAfterDelete
 * Called in NodesController > admin_process
 *
 * @param CakeEvent $event
 * @return void
 */
	public function onNodesAfterDelete($event) {
		
        $Nodeattachment = new Nodeattachment();        
        $Controller = $event->subject();
        $ids = array(); // Where are ids transported from NodesController ?!
		foreach ($Controller->request->data['Node'] as $id => $value) {
			if ($id != 'action' && $value['id'] == 1) {
				$res = $Nodeattachment->deleteAll(array('Nodeattachment.node_id' => $id), false, true);
			}
		}   
	}

/**
 * onNodeattachmentsRemote
 * Nodeattachment remote upload
 *
 * @param CakeEvent $event
 * @return void
 */
	public function onNodeattachmentsRemote($event) {	

		$Controller = $event->subject();
		$ext = strtolower(pathinfo($Controller->ndata['remote_url'], PATHINFO_EXTENSION));
		$allowedExtensions = array_map('trim', 
			explode(',', strtolower(Configure::read('Nodeattachment.allowedExtensions'))));
		
        if (!empty($ext) && in_array($ext, $allowedExtensions) && !isset($Controller->ndata['title'])) {
            $uploadsDir = Configure::read('Nodeattachment.uploadsServerPath');
            $filename = pathinfo($Controller->ndata['remote_url'], PATHINFO_FILENAME);
            $ext = pathinfo($Controller->ndata['remote_url'], PATHINFO_EXTENSION);
            
            while (file_exists($uploadsDir . $filename . '.' . $ext)) {
                $filename .= rand(10, 99);
            }
            
            $wholeFilename = $filename . '.' . $ext;
            if (copy($Controller->ndata['remote_url'], $uploadsDir . $wholeFilename)) {
                $Controller->ndata['filename'] = $wholeFilename;
                $Controller->ndata['title'] = $wholeFilename;                
            }
        }			
	}
}
