<?php
        Croogo::hookBehavior('Node', 'Nodeattachment.Nodeattachment');
        Croogo::hookHelper('*', 'Image');
        Croogo::hookHelper('Nodes', 'Nodeattachment.Nodeattachment');
        Croogo::hookAdminTab('Nodes/admin_edit', 'Attachments', 'nodeattachment.admin_tab_node');
        Croogo::hookAdminMenu('Nodeattachment');
?>