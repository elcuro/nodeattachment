<?php
        Croogo::hookBehavior('Node', 'Nodeattachment.Nodeattachment');
        Croogo::hookHelper('*', 'Image');
        Croogo::hookAdminTab('Nodes/admin_edit', 'Attachments', 'nodeattachment.admin_tab_node');
        Croogo::hookAdminMenu('Nodeattachment');
?>