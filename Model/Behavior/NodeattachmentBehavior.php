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
         * Before delete callback
         *
         * @param object $model
         * @return void
         */
        public function beforeDelete(&$model) {
                
                parent::beforeDelete($model);
                
                $model->bindModel(array(
                    'hasMany' => array(
                        'Nodeattachment' => array(
                            'order' => array(
                                'Nodeattachment.priority ASC',
                                'Nodeattachment.created ASC')
                        ))
                ));                
                $data = $model->findById($model->id);
                
                if (isset($data['Nodeattachment'])) {
                     App::import('Model', 'Nodeattachment.Nodeattachment');
                     $Nodeattachment = new Nodeattachment;

                     // delete all attachments for node
                     foreach ($data['Nodeattachment'] as $attachment) {
                            $Nodeattachment->read(null, $attachment['id']);
                            if (!$Nodeattachment->delete($attachment['id'])) {
                                   return FALSE;
                            }
                     } 
                }
                
                return true;
        }

}
?>