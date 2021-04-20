<?php

defined('HOSTCMS') || exit('HostCMS: access denied.');

/**
 * Backup.
 *
 * @package HostCMS
 * @subpackage Backup
 * @version 6.x
 * @author Hostmake LLC
 * @copyright © 2005-2018 ООО "Хостмэйк" (Hostmake LLC), http://www.hostcms.ru
 */
class Backup_File extends Wysiwyg_Filemanager_File
{
	/**
	 * Model name
	 * @var mixed
	 */
	protected $_modelName = 'backup';
}