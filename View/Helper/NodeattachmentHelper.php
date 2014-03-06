<?php
App::uses('AppHelper', 'View/Helper');

/**
 * Nodeattachment Helper
 *
 *
 * @category Helper
 * @package  Croogo
 * @version  1.5
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class NodeattachmentHelper extends AppHelper {

/**
 * Other helpers used by this helper
 *
 * @var array
 * @access public
 */
	public $helpers = array(
		'Html',
		'Croogo.Layout',
		'Nodes' => array('className' => 'Nodes.Nodes'),
	);

/**
 * Before render callback. Called before the view file is rendered.
 *
 * @return void
 */
	public function beforeRender($viewFile) {
	}

/**
 * After render callback. Called after the view file is rendered
 * but before the layout has been rendered.
 *
 * @return void
 */
	public function afterRender($viewFile) {
	}

/**
 * Called before LayoutHelper::nodeBody()
 *
 * @return string
 */
	public function beforeNodeBody() {

		$body = $this->Layout->filter($this->Nodes->field('body'));
		$this->Nodes->field('body', $body);
	}
}
