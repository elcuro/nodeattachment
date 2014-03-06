<div id="node-id-<?php echo $this->Nodes->field('id');?>" class="images <?php echo $config['containerClass'];?>">
	<ul class="grid">
		<?php 
			$uploadsPath = Configure::read('Nodeattachment.uploadsPath');
			foreach ($items as $item) {
				$imgPath = $this->Image2
					->source($uploadsPath.$item['filename'])
					->$config['resizeMethod']($config['width'], $config['height'], true)
					->imagePath();
				$img = $this->Html->image($imgPath, array(
					'alt' => $item['title']));
				$link = $this->Html->link($img, $uploadsPath.$item['filename'], array(
					'title' => $item['title'],
					'class' => $config['linkClass'],
					'escape' => false));
				echo $this->Html->tag('li', $link);				
			}	
		 ?>
	</ul>
</div>