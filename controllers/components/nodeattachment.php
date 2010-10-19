<?php

/**
 * NodeAttachments component
 *
 * @author Duro
 */
class NodeattachmentComponent extends Object {

        /**
         * Redirect to
         *
         * @var string
         */
        private $redirectTo = null;

        /**
         * startup callback
         *
         * @param object Object
         * @return void
         */
        public function startup (&$controller) {
                $beforeActionMethod = 'beforeAction_'.$controller->action;
                $referer = $controller->referer();
                if (method_exists($this, $beforeActionMethod)) {
                        $this->$beforeActionMethod($controller);
                }
        }

        /**
         * Before redirect callbacka
         *
         * @param object Object
         * @return void
         */
        public function beforeRedirect(&$controller, $url, $status=null, $exit=true) {
                if ($this->redirectTo) {
                        return $this->redirectTo;
                } else {
                        return compact('url', 'status', 'exit');
                }
        }

        /**
         * Before admin_add action
         *
         * @param object $controller
         * @return void
         */
        public function beforeAction_admin_add (&$controller) {
                if (isset($controller->data['Nodeattachment'])) {
                        $this->redirectTo = array(
                            'plugin' => 'nodeattachment',
                            'controller' => 'nodeattachment',
                            'action' => 'index',
                            $controller->data['Nodeattachment']['parent_id']
                        );
                }
        }

        /**
         * Before admin_edit action
         *
         * @param object $controller
         * @return void
         */
        function beforeAction_admin_edit(&$controller) {
                if (isset($controller->data['ParentNode'])) {
                        $this->redirectTo = array(
                            'plugin' => 'nodeattachment',
                            'controller' => 'nodeattachment',
                            'action' => 'index',
                            $controller->data['ParentNode']['id']
                        );
                }
        }

        /**
         * Before admin_delete
         *
         * @param array $var
         * @return array
         */
        public function beforeAction_admin_delete(&$controller) {
                $referer = $controller->referer();
                if (stristr($referer, 'nodeattachment')) {
                        $this->redirectTo = $referer;
                }
        }

}
?>
