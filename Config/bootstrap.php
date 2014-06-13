<?php
	Configure::write('Nodeattachment.uploadsPath', '/uploads/');
    Configure::write('Nodeattachment.uploadsServerPath', WWW_ROOT . 'uploads/');

	Croogo::hookBehavior('Node', 'Nodeattachment.Nodeattachment');
	Croogo::hookHelper('*', 'Nodeattachment.Nodeattachment');
	
	Croogo::hookAdminTab('Nodes/admin_edit', 'Attachments', 'Nodeattachment.admin_tab_node');

	CroogoNav::add('settings.children.nodeattachment', array(
		'title' => 'Nodeattachment',
		'url' => array(
			'admin' => true,
			'plugin' => 'settings',
			'controller' => 'settings',
			'action' => 'prefix',
			'Nodeattachment',
		),
	));		
?>