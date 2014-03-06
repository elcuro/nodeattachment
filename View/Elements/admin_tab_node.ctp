<?php 
	echo $this->Html->css(
		array(
			'Nodeattachment.nodeattachment',
			'Nodeattachment.fileuploader',			
			'//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap-editable/css/bootstrap-editable.css'
		),
		array('inline' => false)
	);
	echo $this->Html->script(
		array(
			'Nodeattachment.fileuploader',
			'Nodeattachment.nodeattachment',
			'//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap-editable/js/bootstrap-editable.min.js'
		),
		array('inline' => false)
	);

	$node = $this->request->data;
 ?>

<div id="nodeattachment-container" data-node-id="<?php echo $node['Node']['id'];?>">
	<div id="file-uploader" class="pull-left">       
		<noscript>          
		    <p><?php echo __d('nodeattachment', 'Please enable JavaScript to use file uploader.') ?></p>
		</noscript>         
	</div>
	<div class="pull-right">
		<button class="btn remote-upload" data-value="" data-name="uri" data-pk="<?php echo $node['Node']['id'];?>">
			<?php echo __d('nodeattachment', 'Remote upload'); ?>
		</button>
	</div>		

	<table id="listing" class="table table-striped">
		<thead>
			<tr>
				<th></th>
				<th><?php echo __d('nodeattachment', 'Thumb');?></th>
				<th><?php echo __d('nodeattachment', 'Title');?></th>
				<th><?php echo __d('nodeattachment', 'Tags');?></th>
			 	<th><?php echo __d('nodeattachment', 'Actions');?></th>
			</tr>
		</thead>
		<tbody class="sortable">
			<?php 
				foreach ($node['Nodeattachment'] as $na) {
					echo $this->element('Nodeattachment.item', array('data' => $na));
				}
			 ?>
		 </tbody>
	 </table>
</div>