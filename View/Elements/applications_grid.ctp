<div id="node-id-<?php echo $this->Nodes->field('id');?>" class="applications <?php echo $config['containerClass'];?>">
	<ul class="grid">
		<?php 
			$uploadsPath = Configure::read('Nodeattachment.uploadsPath');
			$uploadsServerPath = Configure::read('Nodeattachment.uploadsServerPath');
			foreach ($items as $item) {
				$file = new File($uploadsServerPath . $item['filename']);
				$fileinfo = $file->info();
				$linkContent = $item['title'];
				$link = $this->Html->link($linkContent, $uploadsPath.$item['filename'], array(
					'title' => $item['title'],
					'class' => $config['linkClass'],
					'escape' => false));
				echo $this->Html->tag('li', $link . ' [' . $this->Number->toReadableSize($fileinfo['filesize']) . ']');				
			}	
		 ?>
	</ul>
</div>