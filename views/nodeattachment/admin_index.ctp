<div class="attachments form">
        <h2>
                <?php __('Attachments for') ?>&nbsp;
                <?php
                echo $html->link($node['Node']['title'], array(
                    'plugin' => false,
                    'controller' => 'nodes',
                    'action' => 'edit',
                    $node['Node']['id'])
                );?>
        </h2>
        <?php
                $formUrl = array('plugin' => false, 'controller' => 'attachments', 'action' => 'add');
                if (isset($this->params['named']['editor'])) {
                        $formUrl['editor'] = 1;
                }
        ?>
        <?php echo $form->create('Node', array('url' => $formUrl, 'type' => 'file'));?>
                <fieldset>
                <?php
                    echo $form->input('Node.file', array('label' => __('Upload', true), 'type' => 'file',));
                    echo $form->hidden('Nodeattachment.parent_node_id');
                ?>
                </fieldset>
        <?php echo $form->end('Submit');?>
</div>

<div class="attachments index">
    <table cellpadding="0" cellspacing="0">
    <?php
        $tableHeaders = $html->tableHeaders(array(
            'id',
            '&nbsp;',
            __('Title', true),
            __('URL', true),
            __('Actions', true),
        ));
        echo $tableHeaders;

        $rows = array();
        foreach ($node['Attachments'] AS $attachment) {
            $actions  = $html->link(__('Edit', true), array(
                'plugin' => 'nodeattachment',
                'controller' => 'nodeattachment',
                'action' => 'edit',
                $attachment['Node']['id'],
            ));
            $actions  .= $html->link(__('Move Down', true), array(
                'plugin' => 'nodeattachment',
                'controller' => 'nodeattachment',
                'action' => 'movedown',
                $attachment['Nodeattachment']['id'],
            ));
            $actions  .= $html->link(__('Move Up', true), array(
                'plugin' => 'nodeattachment',
                'controller' => 'nodeattachment',
                'action' => 'moveup',
                $attachment['Nodeattachment']['id'],
            ));
            $actions .= ' ' . $layout->adminRowActions($attachment['Node']['id']);
            $actions .= ' ' . $html->link(__('Delete', true), array(
                'plugin' => false,
                'controller' => 'attachments',
                'action' => 'delete',
                $attachment['Node']['id'],
                'token' => $this->params['_Token']['key'],
            ), null, __('Are you sure?', true));

            $mimeType = explode('/', $attachment['Node']['mime_type']);
            $mimeType = $mimeType['0'];
            if ($mimeType == 'image') {
                $thumbnail = $html->link($image->resize('/uploads/' . $attachment['Node']['slug'], 100, 200), array('controller' => 'nodeattachment', 'action' => 'edit', $attachment['Node']['id']), array('escape' => false));
            } else {
                $thumbnail = $html->image('/img/icons/page_white.png') . ' ' . $attachment['Node']['mime_type'] . ' (' . $filemanager->filename2ext($attachment['Node']['slug']) . ')';
            }

            $rows[] = array(
                $attachment['Node']['id'],
                $thumbnail,
                $attachment['Node']['title'],
                $html->link($text->truncate($html->url($attachment['Node']['path'], true), 20), $attachment['Node']['path']),
                $actions,
            );
        }

        echo $html->tableCells($rows);
        echo $tableHeaders;
    ?>
    </table>
</div>