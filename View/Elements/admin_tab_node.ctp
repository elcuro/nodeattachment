<div id="storage-uploader">
<?php
$upload_dir = Configure::read('Nodeattachment.storageUploadDir');
if (!empty($upload_dir)) {
        echo $this->Html->link(__('Attach from server', true), Router::url(array(
                    'controller' => 'nodeattachment',
                    'action' => 'addStorageFile',
                    'plugin' => 'nodeattachment',
                    'node_id' => $this->data['Node']['id']), true) . '?KeepThis=true&TB_iframe=true&height=400&width=600',
                array(
                    'class' => 'thickbox'));
}
?>
</div>

<div id="file-uploader">
    <noscript>
        <p>Please enable JavaScript to use file uploader.</p>
        <!-- or put a simple form for upload here -->
    </noscript>
</div>



<div id="loading" style="display:none;">
        <?php echo $this->Html->image('/nodeattachment/img/loading-big.gif', array('alt' => 'Loader'));?>
</div>
<div id="attachments-listing">

</div>
<?php
       $this->append('css', $this->Html->css('Nodeattachment.admin.css'));
       $this->append('scriptBottom', $this->Html->script('/Nodeattachment/js/valums-file-uploader/client/fileuploader.js'));

        // vars for javacript
        $action_url = $this->Html->url(array(
            'controller' => 'nodeattachment',
            'action' => 'add',
            'plugin' => 'nodeattachment'
        ));
        $nodeIndex_url = $this->Html->url(array(
            'plugin' => 'nodeattachment',
            'controller' => 'nodeattachment',
            'action' => 'nodeIndex',
            $this->data['Node']['id'], md5(rand(1, 1000))
        ));
        $node_id = $this->data['Node']['id'];
?>
<script type="text/javascript">

function refreshListing() {
        $('#loading').show();
        $('#attachments-listing').load('<?php echo $nodeIndex_url; ?>', function(response, status, xhr) {
                $('#loading').hide();
        });
}

$(document).ready(function() {

        refreshListing();

        var uploader = new qq.FileUploader({
            element: document.getElementById('file-uploader'),
            action: '<?php echo $action_url;?>',
            debug: true,
            params: {
                    node_id: '<?php echo $node_id;?>'
            },
            onSubmit: function(id, fileName){
                $('#loading').show();
            },
            onComplete: function(id, fileName, responseJSON){                                        
                    refreshListing();
            }
        });
   

});
</script>