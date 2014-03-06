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
    public function beforeFind(Model $model, $query) {
        
        $model->bindModel(array(
            'hasMany' => array(
                'Nodeattachment' => array(
                	'className' => 'Nodeattachment.Nodeattachment',
                    'order' => array(
                        'Nodeattachment.priority ASC',
                        'Nodeattachment.created DESC'
                    ),
                ))
        ));

        return $query;
    }
}
?>