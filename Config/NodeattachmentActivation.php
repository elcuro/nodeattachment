<?php
/**
 * Nodeattachment Activation
 *
 * Activation class for Example plugin.
 * This is optional, and is required only if you want to perform tasks when your plugin is activated/deactivated.
 *
 * @package  Croogo
 * @author   Fahad Ibnay Heylaal <contact@fahad19.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
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
