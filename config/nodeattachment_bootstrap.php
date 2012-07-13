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
        Croogo::hookAdminTab('Nodes/admin_edit', 'Attachments', 'nodeattachment.admin_tab_node');
        Croogo::hookAdminMenu('Nodeattachment');
?>