<?php
        $tmp_conf = Configure::read('Nodeattachment');
        $conf = array(
            'thumbDir' => APP . 'plugins' . DS . 'nodeattachment' . DS .
                'webroot' . DS . 'img' . DS . 'tn',
            'iconDir' => APP . 'plugins' . DS . 'nodeattachment' . DS .
                'webroot' . DS . 'img',
            'flvDir' => APP . 'plugins' . DS . 'nodeattachment' . DS .
                'webroot' . DS .'flv',
            'thumbExt' => 'png'
        );
        Configure::write('Nodeattachment', Set::merge($tmp_conf, $conf));
        Configure::write('Nodeattachment.thumbnailExt', 'png');

        Croogo::hookBehavior('Node', 'Nodeattachment.Nodeattachment');
        Croogo::hookHelper('*', 'Nodeattachment.Nodeattachment');
        
        CroogoNav::add('extensions.children.nodeattachment', array(
            'title' => 'Nodeattachment',
            'url' => '#',
            'children' => array(
                'settings' => array(
                    'title' => __('Configure'),
                    'url' => array('plugin' => '', 'controller' => 'settings', 'action' => 'prefix', 'Nodeattachment')
                )
            )
        ));
        
        Croogo::hookAdminTab('Nodes/admin_edit', 'Attachments', 'Nodeattachment.admin_tab_node');
        Croogo::hookAdminMenu('Nodeattachment');
?>