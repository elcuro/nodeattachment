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
                
                $conf = Configure::read('Nodeattachment');
                
                // delete all attachments for node
                foreach ($model->data['Nodeattachment'] as $attachment) {
                        $model->Nodeattachment->delete($attachment['id']);
                        
                        $filename_expl = explode('.', $attachment['slug']);
                        $files_to_delete = array(
                                WWW_ROOT . $attachment['path'], // uploaded file
                                $conf['flvDir'] . DS . $filename_expl[0] . '.flv', // flv variant
                                $conf['thumbDir'] . DS . $filename_expl[0] . '.' . $conf['thumbExt'], // video thumb
                        );
                        foreach($files_to_delete as $file) {
                                if (file_exists($file)) {
                                        unlink($file);
                                }
                        }                        
                        
                }
                
                
        }

}
?>