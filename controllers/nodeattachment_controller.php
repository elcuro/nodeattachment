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

                $this->set('title_for_layout', __('Attachments', true));

                $this->data = array('Nodeattachment' => array('parent_id' => $id));

                $this->Node->recursive = 0;
                $node = $this->Node->read(null, $id);
                $this->set('Node', $node);

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
                $ParentNode['ParentNode'] = $this->Node->read(null, $Nodeattachment['Nodeattachment']['parent_id']);
                $this->data = array_merge($Node, $ParentNode);
        }
}
?>
