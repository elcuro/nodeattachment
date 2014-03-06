<?php
	Configure::write('Nodeattachment.uploadsPath', '/uploads/');
    Configure::write('Nodeattachment.uploadsServerPath', WWW_ROOT . 'uploads/');

	Croogo::hookBehavior('Node', 'Nodeattachment.Nodeattachment');
	Croogo::hookAdminTab('Nodes/admin_edit', 'Attachments', 'Nodeattachment.admin_tab_node');

	CroogoNav::add('extensions.children.nodeattachment', array(
		'title' => 'Nodeattachment',
		'url' => '#',
		'children' => array(
			'example1' => array(
				'title' => 'Settings',
				'url' => array(
					'plugin' => 'settings', 
					'controller' => 'settings', 
					'action' => 'prefix', 
					'Nodeattachment')
			),
		),
	));	
?>