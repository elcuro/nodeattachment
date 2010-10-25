<?php
        Croogo::hookComponent('Attachments', 'Nodeattachment.Nodeattachment');
        Croogo::hookBehavior('Node', 'Nodeattachment.Nodeattachment');
        Croogo::hookAdminRowAction('Nodes/admin_index', 'Attachments', 'plugin:nodeattachment/controller:nodeattachment/action:index/:id');
        Croogo::hookAdminTab('Nodes/admin_edit', 'Attachments', 'nodeattachment.admin_tab_node');
?>