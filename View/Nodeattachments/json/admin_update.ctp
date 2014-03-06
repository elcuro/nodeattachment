<?php

if ($success) {
	$response = array(
		'success' => true
	);
    echo json_encode($response);
} else {
    echo $message;
}