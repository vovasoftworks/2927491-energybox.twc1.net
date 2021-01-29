<?php

return array (
	'skin' => 'bootstrap',
	'dateFormat' => 'd.m.Y',
	'dateTimeFormat' => 'd.m.Y H:i:s',
	//'reverseDateTimeFormat' => '',
	'datePickerFormat' => 'DD.MM.YYYY',
	'dateTimePickerFormat' => 'DD.MM.YYYY HH:mm:ss',
	'timezone' => 'Europe/Moscow',
	'translate' => TRUE,
	'chat' => TRUE,
	'switchSelectToAutocomplete' => 100,
	'autocompleteItems' => 10,
	'backendSessionLifetime' => 14400,
	'availableExtension' => array ('JPG', 'JPEG', 'GIF', 'PNG', 'WEBP', 'SVG', 'PDF', 'ZIP', 'DOC', 'DOCX',  'XLS', 'XLSX', 'TXT'),
	'defaultCache' => 'file',
	'session' => array(
		'driver' => 'database',
		'class' => 'Core_Session_Database',
		//'driver' => 'phpredis',
		//'class' => 'Core_Session_Phpredis',
		//'server' => '127.0.0.1',
		//'port' => 6379,
		//'auth' => '123456789'
	),
	'adminMenu' => array(
		0 => array(
			'image' => '/admin/images/structure.gif',
			'ico' => 'fa-sitemap'
		),
		1 => array(
			'image' => '/admin/images/service.gif',
			'ico' => 'fa-cubes'
		),
		2 => array(
			'image' => '/admin/images/users.gif',
			'ico' => 'fa-users'
		),
		3 => array(
			'image' => '/admin/images/system.gif',
			'ico' => 'fa-gear'
		)
	),
	'fileIcons' => array(
		'sql' => 'sql.gif',
		'txt' => 'txt.gif',
		'htaccess' => 'config.gif',
		'css' => 'css.gif',
		'php' => 'php.gif',
		'php3' => 'php.gif',
		'jpg' => 'jpg.gif',
		'jpeg' => 'jpg.gif',
		'gif' => 'gif.gif',
		'bmp' => 'bmp.gif',
		'png' => 'png.gif',
		'ico' => 'image.gif', //
		'htm' => 'html.gif',
		'html' => 'html.gif',
		'xml' => 'xml.gif', //
		'xsl' => 'xsl.gif',
		'zip' => 'zip.gif',
		'gz' => 'zip.gif',
		'7z' => 'zip.gif',
		'rar' => 'rar.gif',
		'pdf' => 'pdf.gif',
		'doc' => 'doc.gif',
		'docx' => 'doc.gif',
		'cdr' => 'vector.gif',
		'ai' => 'vector.gif',
		'eps' => 'vector.gif',
		'rb' => 'rb.gif',
		'ppt' => 'ppt.gif',
		'pptx' => 'ppt.gif',
		'pptm' => 'ppt.gif',
		'mdb' => 'mdb.gif',
		'h' => 'h.gif',
		'fh1' => 'fh1.gif',
		'fh2' => 'fh2.gif',
		'fh3' => 'fh3.gif',
		'fh4' => 'fh4.gif',
		'fh5' => 'fh5.gif',
		'fh6' => 'fh6.gif',
		'fh7' => 'fh7.gif',
		'fh8' => 'fh8.gif',
		'fh9' => 'fh9.gif',
		'fla' => 'flash.gif',
		'swf' => 'flash.gif',
		'xls' => 'xls.gif',
		'cpp' => 'cpp.gif',
		'chm' => 'chm.gif'
	)
);