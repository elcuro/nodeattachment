<style type="text/css">
.qq-uploader { position:relative; width: 100%;}

.qq-upload-button {
    display:block; /* or inline-block */
    width: 105px; padding: 7px 0; text-align:center;
    background:#DEDFDE; border-bottom:1px solid #ddd;color:#fff;
    color: black;
    position: relative;
}
.qq-upload-button-hover {background:#cc0000; color: white;}
.qq-upload-button-focus {outline:1px dotted black;}

.qq-upload-drop-area {
    position:relative; top:0; left:0; width:100%; height:70px; min-height: 70px; z-index:2;
    background:#FF9797; text-align:center;
}
.qq-upload-drop-area span {
    display:block; position:absolute; top: 50%; width:100%; margin-top:-8px; font-size:16px;
}
.qq-upload-drop-area-active {background:#FF7171;}

.qq-upload-list {margin:15px 35px; padding:0; list-style:disc;}
.qq-upload-list li { margin:0; padding:0; line-height:15px; font-size:12px;}
.qq-upload-file, .qq-upload-spinner, .qq-upload-size, .qq-upload-cancel, .qq-upload-failed-text {
    margin-right: 7px;
}

.qq-upload-file {}
.qq-upload-spinner {display:inline-block; background: url("loading.gif"); width:15px; height:15px; vertical-align:text-bottom;}
.qq-upload-size,.qq-upload-cancel {font-size:11px;}

.qq-upload-failed-text {display:none;}
.qq-upload-fail .qq-upload-failed-text {display:inline;}
#loading
{
        position: absolute;
        width: 200px;
        height: 200px;
        z-index: 1000;
        text-align: left;
}
</style>

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
        echo $this->Html->script(array(
            '/nodeattachment/js/valums-file-uploader/client/fileuploader.js'),
                array('inline' => false));

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
            debug: false,
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