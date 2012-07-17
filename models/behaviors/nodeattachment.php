<?php
/**
* Nodeattachment behavior
*
* @author Juraj Jancuska <jjancuska@gmail.com>
* @copyright (c) 2010 Juraj Jancuska
* @license MIT License - http://www.opensource.org/licenses/mit-license.php
*/
class NodeattachmentBehavior extends ModelBehavior {

        /**
         * Before find callback,
         * bind Nodeattachment with hasMany relation
         *
         * @param object $model
         * @param array $query
         * @return array $query
         */
        public function beforeFind(&$model, $query) {

                $model->bindModel(array(
                    'hasMany' => array(
                        'Nodeattachment' => array(
                            'order' => array(
                                'Nodeattachment.priority ASC',
                                'Nodeattachment.created ASC')
                        ))
                ));

                return $query;

        }
        
        /**
         * After delete callback
         *
         * @param object $model
         * @return void
         */
        public function afterDelete(&$model) {
                
                parent::afterDelete($model);
                
                App::import('Model', 'Nodeattachment.Nodeattachment');
                $Nodeattachment = new Nodeattachment;
                
                // delete all attachments for node
                foreach ($model->data['Nodeattachment'] as $attachment) {
                       
                       $Nodeattachment->read(null, $attachment['id']);
                       $Nodeattachment->id = $attachment['id'];
                       $Nodeattachment->delete();
                }                               
        }

}
?>