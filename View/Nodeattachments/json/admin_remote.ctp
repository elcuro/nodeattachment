<?php

if ($success) {
	$response = array(
		'success' => true,
		'html' => $this->element('Nodeattachment.item', array(
			'data' => $nodeattachment['Nodeattachment'])
		)
	);
    echo json_encode($response);
} else {
    echo $message;
}