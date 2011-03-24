<div class="attachments index">

    <table cellpadding="0" cellspacing="0">
    <tbody id="sortable">
    <?php
        foreach ($attachments AS $attachment) {
                $actions = $this->Ajax->link(__('Edit', true), array(
                            'plugin' => 'nodeattachment',
                            'controller' => 'nodeattachment',
                            'action' => 'edit',
                            $attachment['Nodeattachment']['id']),
                                array('update' => 'attachments-listing', 'indicator' => 'loading')
                );
                $actions .= ' ' . $this->Layout->adminRowActions($attachment['Nodeattachment']['id']);
                $actions .= ' ' . $this->Ajax->link(__('Delete', true), array(
                            'plugin' => 'nodeattachment',
                            'controller' => 'nodeattachment',
                            'action' => 'delete',
                            $attachment['Nodeattachment']['id'],
                            'token' => $this->params['_Token']['key']),
                                array('update' => 'attachments-listing', 'indicator' => 'loading')
                );

                $mimeType = explode('/', $attachment['Nodeattachment']['mime_type']);
                $mimeType = $mimeType['0'];
                if ($mimeType == 'image') {
                        $thumbnail = $this->Html->link($image->resize('/uploads/' . $attachment['Nodeattachment']['slug'], 100, 200), array('controller' => 'nodeattachment', 'action' => 'edit', $attachment['Nodeattachment']['id']), array('escape' => false));
                } else {
                        $thumbnail = $this->Html->image('/img/icons/page_white.png') . ' ' . $attachment['Nodeattachment']['mime_type'] . ' (' . $filemanager->filename2ext($attachment['Nodeattachment']['slug']) . ')';
                }

                $row = '';
                $row .= $this->Html->tag('td', $this->Html->tag('span', '', array('class' => 'ui-icon ui-icon-arrowthick-2-n-s')));
                $row .= $this->Html->tag('td', $attachment['Nodeattachment']['id']);
                $row .= $this->Html->tag('td', $thumbnail);
                $row .= $this->Html->tag('td', $attachment['Nodeattachment']['title']);
                $row .= $this->Html->tag('td', $actions);
                echo $this->Html->tag(
                        'tr',
                        $row,
                        array('class' => 'ui-state-default', 'id' => 'nodeattachments_' . $attachment['Nodeattachment']['id'])
                );
        }
    ?>
    </tbody>
    </table>
    <?php
        $sort_url = $this->Html->url(array(
            'plugin' => 'nodeattachment',
            'controller' => 'nodeattachment',
            'action' => 'sort' 
        ));
        $options = array(
            "update" => "$.post('".$sort_url."', $('#sortable').sortable('serialize'))"
        );
        echo $this->Ajax->sortable('sortable', $options);
    ?>
</div>

