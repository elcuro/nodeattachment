<?php
/**
 * Nodeattachment Activation
 *
 */
class NodeattachmentActivation {

/**
 * onActivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
	public function beforeActivation(&$controller) {
		
		return true;
	}

/**
 * Called after activating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
	public function onActivation(&$controller) {

		App::uses('CroogoPlugin', 'Extensions.Lib');
		$CroogoPlugin = new CroogoPlugin();
		$CroogoPlugin->migrate('Nodeattachment');		

		$controller->Croogo->addAco('Nodeattachment/Nodeattachments/admin_upload');
		$controller->Croogo->addAco('Nodeattachment/Nodeattachments/admin_remote');
		$controller->Croogo->addAco('Nodeattachment/Nodeattachments/admin_sort');
		$controller->Croogo->addAco('Nodeattachment/Nodeattachments/admin_delete');

        $controller->Setting->write('Nodeattachment.allowedExtensions', 'jpg,jpeg, png, pdf', array(
            'editable' => 1, 'description' => __d('nodeattachment', 'Allowed extensions'))
        );		
        $controller->Setting->write('Nodeattachment.sizeLimit', 5, array(
            'editable' => 1, 'description' => __d('nodeattachment', 'Max. upload size (MB)'))
        );        
	}

/**
 * onDeactivate will be called if this returns true
 *
 * @param  object $controller Controller
 * @return boolean
 */
	public function beforeDeactivation(&$controller) {
		
		return true;
	}

/**
 * Called after deactivating the plugin in ExtensionsPluginsController::admin_toggle()
 *
 * @param object $controller Controller
 * @return void
 */
	public function onDeactivation(&$controller) {

		$controller->Croogo->removeAco('Nodeattachment'); 
		$controller->Setting->deleteKey('Nodeattachment.allowedExtensions');
		$controller->Setting->deleteKey('Nodeattachment.sizeLimit');		
	}
}
