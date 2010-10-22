<?php

/**
 * Description of nodeattachments_controller
 *
 * @author Duro
 */
class NodeattachmentController extends NodeattachmentAppController {
        /**
         * Controller Name
         *
         * @var string
         */
        public $name ='Nodeattachment';

        /**
         * Used models
         *
         * @var array
         */
        public $uses = array(
            'Setting',
            'Node',
            'Nodeattachment.Nodeattachment'
        );

        /**
         * Used helpers
         *
         * @var array
         */
        public $helpers = array(
            'Text',
            'Image',
            'Filemanager'
        );

        /**
        * Node attachment index
        *
        * @param  integer $id Node id
        * @return void
        */
        public function admin_index($id) {

                $this->set('title_for_layout', __('Attachments for node', true));

                $this->data = array('Nodeattachment' => array('parent_node_id' => $id));

                $this->Node->recursive = 0;
                $node = $this->Node->read(null, $id);
                $this->set('node', $node);

        }

        /**
         * Edit attachment
         *
         * @param integer $id  Attachment id
         * @return void
         */
        public function admin_edit($id) {
                $this->set('title_for_layout', __('Edit attachment', true));
                $Node = $this->Node->read(null, $id);
                $Nodeattachment = $this->Nodeattachment->read(null, $id);
                $ParentNode['ParentNode'] = $this->Node->read(null, $Nodeattachment['Nodeattachment']['parent_node_id']);
                $this->data = array_merge($Node, $ParentNode);
        }

        /**
         * Move attachment up
         *
         * @param integer $id Nodeattachment id
         * @param integer $step Move steps count
         * @return void
         */
        public function admin_moveup($id = false, $step = 1) {

                if (!$id) {
                      $this->Session->setFlash(__('Missing Nodeattachment id', true), 'default', 'error');
                      $this->redirect($this->referer());
                }

                $this->Nodeattachment->id = $id;
                $this->Nodeattachment->Behaviors->attach('Tree');
                $this->Nodeattachment->moveUp($this->Nodeattachment->id, $step);

                $this->redirect($this->referer());

        }

        /**
         * Move attachment down
         *
         * @param integer $id Nodeattachment id
         * @param integer $step Move steps count
         * @return void
         */
        public function admin_movedown($id = false, $step = 1) {

                if (!$id) {
                      $this->Session->setFlash(__('Missing Nodeattachment id', true), 'default', 'error');
                      $this->redirect($this->referer());
                }

                $this->Nodeattachment->id = $id;
                $this->Nodeattachment->moveDown($this->Nodeattachment->id, $step);

                $this->redirect($this->referer());

        }
}
?>
