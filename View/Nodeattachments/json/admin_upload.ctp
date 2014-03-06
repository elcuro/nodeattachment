<?php

if ($success) {
	$response = array(
		'success' => true,
		'html' => $this->element('Nodeattachment.item', array(
			'data' => $nodeattachment['Nodeattachment'])
		)
	);
} else {
	$response = array(
		'success' => false,
	);
}
$response['message'] = $message;
echo json_encode($response);