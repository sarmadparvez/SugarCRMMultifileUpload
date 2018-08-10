<?php

$viewdefs['Leads']['base']['view']['record']['panels'][] = array(
	'name' => 'panel_body',
	'label' => 'LBL_UPLOAD_DOCUMENTS',
	'columns' => 2,
	'labels' => true,
	'labelsOnTop' => true,
	'placeholders' => true,
	'fields' => array(
		array(
		    'name' => 'multifile_upload',
		    'type' => 'multifile-upload',
		    'span' => 12,
		    'readonly' => true
		)
	)
);