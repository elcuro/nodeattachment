<?php 
	$defaults = array(
		'limit' => 100,
		'width' => 250,
		'height' => 130,
		'resizeMethod' => 'resizeit',
		'ofType' => 'image',
		'linkClass' => 'thickbox',
		'containerClass' => 'nodeattachment',
		'listingElement' => 'Nodeattachment.images_grid',
		'tag' => '');
	$config = compact(
		'limit', 
		'width', 
		'height', 
		'resizeMethod', 
		'ofType', 
		'linkClass', 
		'containerClass', 
		'listingElement',
		'tag');
	$config = array_merge($defaults, $config);


	$items = array();
	foreach ($this->Nodes->node['Nodeattachment'] as $key => $data) {
		if ($data['type'] == $config['ofType']) {
			$items[] = $data;
			unset($this->Nodes->node['Nodeattachment'][$key]);
		}
	}

	if (!empty($items)) {
		echo $this->element($config['listingElement'], array(
			'items' => $items,
			'config' => $config));
	}
 ?>