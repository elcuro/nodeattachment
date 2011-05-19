<div class="nodeattachments all">
        <h2><?php echo $title_for_layout; ?></h2>

        <?php
        foreach ($nodes as $node) {?>
        <div class="nodeattachments-node">
                <?php
                $this->Layout->setNode($node);
                echo $this->Html->tag('h3', $this->Layout->node('title'));
                
                // here you can filter mime type of nodeattachments
                $images = $this->Nodeattachment->filterMime('image');

                foreach ($images as $image) {
                        $this->Nodeattachment->setNodeattachment($image);
                        $thumb = $this->Image2->resize(
                            $this->Nodeattachment->field('thumb_path'),
                            150, 100, 'resizeCrop');
                        echo $this->Html->link(
                            $thumb,
                            $this->Nodeattachment->field('path'),
                            array('rel' => 'colorbox', 'escape' => false));

                }?>
        </div>
        <?php
        } ?>
</div>