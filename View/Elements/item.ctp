<?php 
	$thumb = '';	
	$imagePath = Configure::read('Nodeattachment.uploadsPath').$data['filename'];
	if ((strpos($data['mime'], 'image') !== false) && !empty($data['filename']) ) {		
		$tpath = $this->Image2
			->source($imagePath)
			->crop(60, 40, true)
			->imagePath();
		$timage = $this->Html->image($tpath, array(
			'alt' => $data['filename'])
		);
		$thumb = $this->Html->link($timage, $imagePath, array(
			'escape' => false,
			'rel' => 'nodeattachment-gallery',
			'class' => 'thickbox')
		);
	} elseif (!empty($data['filename']) && empty($data['remote_url'])) {
		$span = $this->Html->tag('span', pathinfo($data['filename'], PATHINFO_EXTENSION), array(
			'class' => 'label lable-info')
		);
		$thumb = $this->Html->link($span, $imagePath, array(
			'target' => '_download')
		);
	}

	echo $this->Html->tableCells(array(
		array(
			$this->Html->tag('span', '::', array(
				'class' => 'move')
			),
			$thumb,
			$this->Html->link($data['title'], '#', array(
				'data-pk' => $data['id'],
				'data-name' => 'title',
				'class' => 'editable')
			),	
			$this->Html->link($data['tags'], '#', array(
				'data-pk' => $data['id'],
				'data-name' => 'tags',
				'data-value' => 'tags',
				'class' => 'editable')
			),	
			$this->Croogo->adminRowAction('',
				'/admin/nodeattachment/nodeattachments/delete/'.$data['id'].'.json',
				array(
					'icon' => 'trash',
					'class' => 'delete',
					'data-pk' => $data['id'],
					'tooltip' => __d('croogo', 'Delete'),
				)
			),						
		)),
		array('id' => 'na_'.$data['id']),
		array('id' => 'na_'.$data['id'])
	);
 ?>