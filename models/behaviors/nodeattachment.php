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
         * Nodeattachment model
         *
         * @var object
         */
        private $Nodeattachmet = null;

        /**
         * Setup
         *
         * @param object $model
         * @param array  $config
         * @return void
         */
        public function setup(&$model, $config = array()) {
                if (is_string($config)) {
                        $config = array($config);
                }

                $this->settings[$model->alias] = $config;
        }

        /**
         * After save callback
         *
         * @param object $model
         * @param boolean $created
         * @return void
         */
        public function  afterSave(&$model, $created) {
               parent::afterSave($model, $created);

               if ($created && isset($model->data['Nodeattachment']) && ($model->type == 'attachment')) {
                       $Nodeattachment = ClassRegistry::init('Nodeattachment.Nodeattachment');                       
                       $Nodeattachment->create();
                       $Nodeattachment->save(array(
                           'id' => $model->id,
                           'parent_node_id' => $model->data['Nodeattachment']['parent_node_id']
                       ));
                       $Nodeattachment->recover();
               }
        }

        /**
         * After find callback
         *
         * @param object $model
         * @param array $results
         * @param boolean $primary
         * @return array
         */
         public function  afterFind(&$model, $results, $primary) {
                parent::afterFind($model, $results, $primary);

                if ($model->type != 'attachment') {
                        if ($primary && isset($results[0][$model->alias])) {
                            foreach ($results AS $i => $result) {
                                if (isset($results[$i][$model->alias]['title'])) {
                                    $results[$i]['Attachments'] = $this->_getAttachments($model, $result[$model->alias]['id']);
                                }
                            }
                        } elseif (isset($results[$model->alias])) {
                            if (isset($results[$model->alias]['title'])) {
                                $results['Attachments'] = $this->_getAttachments($model, $results[$model->alias]['id']);
                            }
                        }
                }

                return $results;

        }

        /**
         * Get all attachments for node
         *
         * @param object $model
         * @param integer $nodeid
         * @return array
         */
        private function _getAttachments(&$model, $node_id) {

                $data = array();
                $cond = array();

                if (!is_object($this->Nodeattachmet)) {
                        $this->Nodeattachment = ClassRegistry::init('Nodeattachment.Nodeattachment');
                }

                // bind Node model
                $this->Nodeattachment->bindModel(array(
                    'hasOne' => array(
                        'Node' => array(
                            'className' => 'Node',
                            'foreignKey' => 'id'
                        )
                    )
                ));
                // unbind unnecessary models from Node model
                $this->Nodeattachment->Node->unbindModel(array(
                    'belongsTo' => array('User'),
                    'hasMany' => array('Comment', 'Meta'),
                    'hasAndBelongsToMany' => array('Taxanomy')
                ));
                
                $this->Nodeattachment->Node->recursive = 0;
                $attachments = $this->Nodeattachment->find('all', array(
                    'conditions' => array('Nodeattachment.parent_node_id' => $node_id),
                    'order' => 'Nodeattachment.lft ASC'
                ));
                
                return $attachments;

        }

        /**
         * After delete callback
         *
         * @param object $model
         * @return void
         */
        public function  beforeDelete(&$model) {
                parent::beforeDelete($model);
                
                $Nodeattachment = ClassRegistry::init('Nodeattachment.Nodeattachment');

                if ($model->type == 'attachment') {
                        // delete attachment by id
                        $Nodeattachment->delete($model->id);
                } else {
                        // delete by parent_id
                        $results = $Nodeattachment->findByParent_id($model->id);
                        foreach ($results as $result) {
                                $Nodeattachment->delete ($result['Nodeattachment']['id']);
                        }
                }
        }

}
?>