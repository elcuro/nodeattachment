<?php
echo $html->css('admin');
echo $html->script('jquery/jquery.min');
?>
<script type="text/javascript">
    $(document).ready(function() {
        parent.refreshListing();
    });
</script>

<?php
if (!empty($notice)) {
        echo $this->Html->div($notice['class'], $notice['text'], array(
            'id' => 'flashMessage')
        );
}
?>
<div>
        <ul>
                <?php
                foreach ($content['1'] AS $file) {  ?>
                        <li>
                                <strong>
                                <?php
                                        echo $this->Html->link($file, array(
                                            'plugin' => 'nodeattachment',
                                            'controller' => 'nodeattachment',
                                            'action' => 'addStorageFile',
                                            'file' => $file,
                                            'node_id' => $node_id
                                        ));
                                ?>
                                </strong>&nbsp;
                                <?php
                                        echo $this->Html->link(__('Delete', true), array(
                                            'plugin' => 'nodeattachment',
                                            'controller' => 'nodeattachment',
                                            'action' => 'deleteStorageFile',
                                            'file' => $file,
                                            'node_id' => $node_id
                                        ));
                                ?>

                        </li>
                <?php } ?>
        </ul>
</div>