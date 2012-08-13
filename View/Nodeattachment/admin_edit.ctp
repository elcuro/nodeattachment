<div class="attachments form">
       <div class="actions">
              <ul>
                     <li>
                            <?php
                            /* echo $this->Ajax->link(__('<< Back', true), array(
                              'plugin' => 'nodeattachment',
                              'controller' => 'nodeattachment',
                              'action' => 'nodeIndex',
                              $this->data['Nodeattachment']['node_id']),
                              array('update' => 'attachments-listing', 'indicator' => 'loading')
                              ); */
                            echo $this->Js->link(__('<< Back to listing', true), 
                                    array(
                                        'plugin' => 'nodeattachment',
                                        'controller' => 'nodeattachment',
                                        'action' => 'nodeIndex',
                                        $this->data['Nodeattachment']['node_id']
                                    ),
                                    $this->Nodeattachment->requestOptions()
                            );                            
                            ?>
                     </li>
              </ul>

       </div>
       <?php echo $this->Form->create('Nodeattachment'); ?>
       <fieldset>

              <div id="node-basic">
                     <div class="thumbnail">
                            <?php
                            $this->Nodeattachment->setNodeattachment($this->data);

                            echo $this->Image2->resize(
                                    $this->Nodeattachment->field('thumb_path'), 
                                    140, 140, 'resizeRatio', 
                                    array('alt' => $this->Nodeattachment->field('slug')), 
                                    false, 
                                    $this->Nodeattachment->field('server_thumb_path')
                            );
                            ?>
                     </div>

                     <?php
                     echo $this->Form->input('id');
                     echo $this->Form->input('title', array('label' => __('Title', true)));
                     echo $this->Form->input('description', array('label' => __('Description', true)));
                     echo $this->Form->input('type', array('label' => __('Category', true)));
                     echo $this->Form->input('author', array('label' => __('Author', true)));
                     echo $this->Form->input('author_url', array('label' => __('Author Url', true)));
                     echo $this->Form->input('status', array('label' => __('Status', true)));
                     echo $this->Form->hidden('node_id');
                     echo $this->Form->hidden('mime_type');
                     echo $this->Form->hidden('slug');
                     ?>
              </div>

              <div id="node-info">
                     <?php
                     echo $this->Form->input('file_url', array('label' => __('File URL', true), 'value' => Router::url($this->data['Nodeattachment']['path'], true), 'readonly' => 'readonly'));
                     echo $this->Form->input('file_type', array('label' => __('Mime Type', true), 'value' => $this->data['Nodeattachment']['mime_type'], 'readonly' => 'readonly'));
                     ?>
              </div>
       </fieldset>
       <?php
       echo $this->Js->submit(__('Save attachment', true), $this->Nodeattachment->requestOptions());
       
       
       echo $this->Js->writeBuffer();
       
       
       /* echo $this->Ajax->submit(__('Save attachment', true), array(
         'url' => array(
         'plugin' => 'nodeattachment',
         'controller' => 'nodeattachment',
         'action' => 'edit',
         $this->data['Nodeattachment']['id']),
         'update' => 'attachments-listing',
         'indicator' => 'loading')); */
       ?>
</div>