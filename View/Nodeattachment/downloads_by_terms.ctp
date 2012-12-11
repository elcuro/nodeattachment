<div class="nodes downloads">
<?php 
foreach ($terms as $term) {?>
        <div class="term">
                <h3><?php echo $term['Term']['title']; ?></h3>
                <?php 
                $term_nodes = Set::extract("/Node[terms=/".$term['Term']['slug']."/i]", $nodes);                
                foreach ($term_nodes as $node) {?>
                        <?php
                        $nodeattachments = Set::extract("/Nodeattachment[node_id=".$node['Node']['id']."]", $nodes);
                        ?>
                        <div class="node">
                                <?php 
                                echo $node['Node']['title']; 
                                ?>
                        </div>
                        <ul class="node-downloads">
                                <?php
                                foreach($nodeattachments as $nodeattachment) {
                                        echo $this->Html->tag('li', $nodeattachment['Nodeattachment']['title']);
                                }
                                ?>
                        </ul>
                <?php
                } ?>
        </div>
<?php 
} ?>
</div>