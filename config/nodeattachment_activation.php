<?php
/**
 * Plugin activation
 *
 * Description
 *
 * @package  Croogo
 * @author Juraj Jancuska <jjancuska@gmail.com>
 */
class NodeattachmentActivation {

        /**
         * Before onActivation
         *
         * @param object $controller
         * @return boolean
         */
        public function beforeActivation(&$controller) {
                if (!$this->_createTablesFromSchemas($controller)) return false;

                return true;

        }

        /**
         * Activation of plugin,
         * called only if beforeActivation return true
         *
         * @param object $controller
         * @return void
         */
        public function onActivation(&$controller) {
                $controller->Croogo->addAco('Nodeattachment');
                $controller->Croogo->addAco('Nodeattachment/admin_index');
                $controller->Croogo->addAco('Nodeattachment/admin_edit');
        }

        /**
         * Before onDeactivation
         *
         * @param object $controller
         * @return boolean
         */
        public function beforeDeactivation(&$controller) {
                $db =& ConnectionManager::getDataSource('default');
                if (!$db->execute('DROP TABLE nodeattachments')) return false;
                return true;
        }

        /**
         * Deactivation of plugin,
         * called only if beforeActivation return true
         *
         * @param object $controller
         * @return void
         */
        public function onDeactivation(&$controller) {
                $controller->Croogo->removeAco('Nodeattachment');
        }

        /**
         * Create table from schemas in
         * plugin/config/schema folder
         *
         * @param object $controller
         * @return array
         */
        private function _createTablesFromSchemas(&$controller) {

                App::Import('CakeSchema');
                $CakeSchema = new CakeSchema();
                $db =& ConnectionManager::getDataSource('default');
                $cake_schema_files = array();

                // list schema files from config/schema dir
                if ($h = opendir(APP.'plugins'.DS.'nodeattachment'.DS.'config'.DS.'schemas')) {
                        while (false !== ($file = readdir($h))) {
                                if (($file != ".") && ($file != "..")) {
                                        $cake_schema_files[] = $file;
                                }
                        }
                } else {
                        return false;
                }
                
                // create table for each schema
                foreach ($cake_schema_files as $schema_file) {
                        $schema_name = substr($schema_file, 0, -4);
                        $schema_class_name = Inflector::camelize($schema_name);
                        $table_name = array_shift(explode('_', $schema_name));

                        if (!in_array($table_name, $db->_sources)) {
                                 include_once(APP.'plugins'.DS.'nodeattachment'.DS.'config'.DS.'schemas'.DS.$schema_file);
                                 $ActiveSchema = new $schema_class_name;
                                 if(!$db->execute($db->createSchema($ActiveSchema, $table_name))) {
                                         return false;
                                 }
                        }

                }

                return true;
                
        }
}
?>