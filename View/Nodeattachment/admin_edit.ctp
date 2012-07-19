<div class="attachments form">
        <div class="actions">
                <ul>
                        <li>
                        <?php
                        echo $this->Ajax->link(__('<< Back', true), array(
                            'plugin' => 'nodeattachment',
                            'controller' => 'nodeattachment',
                            'action' => 'nodeIndex',
                            $this->data['Nodeattachment']['node_id']),
                                array('update' => 'attachments-listing', 'indicator' => 'loading')
                        );
                        ?>
                        </li>
                </ul>

        </div>
    <?php echo $this->Form->create('Nodeattachment');?>
        <fieldset>

                <div id="node-basic">
                    <div class="thumbnail">
                        <?php
                            $fileType = explode('/', $this->data['Nodeattachment']['mime_type']);
                            $fileType = $fileType['0'];
                            if ($fileType == 'image') {
                                echo $image->resize('/uploads/'.$this->data['Nodeattachment']['slug'], 200, 300);
                            } else {
                                echo $html->image('/img/icons/' . $filemanager->mimeTypeToImage($this->data['Nodeattachment']['mime_type'])) . ' ' . $this->data['Nodeattachment']['mime_type'];
                            }
                        ?>
                    </div>

                    <?php
                        echo $form->input('id');
                        echo $form->input('title', array('label' => __('Title', true)));
                        echo $form->input('description', array('label' => __('Description', true)));
                        echo $form->input('type', array('label' => __('Type', true)));
                        echo $form->input('author', array('label' => __('Author', true)));
                        echo $form->input('author_url', array('label' => __('Author Url', true)));
                        echo $form->input('status', array('label' => __('Status', true)));
                        echo $form->hidden('node_id');
                        echo $form->hidden('mime_type');
                        echo $form->hidden('slug');
                    ?>
                </div>

                <div id="node-info">
                    <?php
                        echo $form->input('file_url', array('label' => __('File URL', true), 'value' => Router::url($this->data['Nodeattachment']['path'], true), 'readonly' => 'readonly'));
                        echo $form->input('file_type', array('label' => __('Mime Type', true), 'value' => $this->data['Nodeattachment']['mime_type'], 'readonly' => 'readonly'));
                    ?>
                </div>
        </fieldset>
    <?php 
    echo $this->Ajax->submit(__('Save attachment', true), array(
        'url' => array(
            'plugin' => 'nodeattachment',
            'controller' => 'nodeattachment',
            'action' => 'edit',
            $this->data['Nodeattachment']['id']),
        'update' => 'attachments-listing',
        'indicator' => 'loading'));
    ?>
</div>