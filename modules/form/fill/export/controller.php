<?php

defined('HOSTCMS') || exit('HostCMS: access denied.');

/**
 * Form_Fill_Export_Controller
 *
 * @package HostCMS
 * @subpackage Form
 * @version 6.x
 * @author Hostmake LLC
 * @copyright © 2005-2020 ООО "Хостмэйк" (Hostmake LLC), http://www.hostcms.ru
 */
class Form_Fill_Export_Controller
{
	/**
	 * Form object
	 * @var Form_Model
	 */
	private $_Form = NULL;

	/**
	 * CSV data
	 * @var array
	 */
	private $_aCurrentData = array();

	protected $_aForm_Fields = array();

	/**
	 * Constructor.
	 * @param object $oForm Form_Model object
	 */
	public function __construct(Form_Model $oForm)
	{
		$this->_Form = $oForm;

		$this->_aForm_Fields = $this->_Form->Form_Fields->findAll();

		$aTmp = array(
			'"' . Core::_('Form_Fill_Export.id') . '"',
			'"' . Core::_('Form_Fill_Export.datetime') . '"',
			'"' . Core::_('Form_Fill_Export.ip') . '"',
			'"' . Core::_('Form_Fill_Export.read') . '"'
		);

		foreach ($this->_aForm_Fields as $oForm_Field)
		{
			$aTmp[] = $oForm_Field->caption;
		}

		$this->_aCurrentData[] = $aTmp;
	}

	/**
	 * Executes the business logic.
	 */
	public function execute()
	{
		$oUser = Core_Auth::getCurrentUser();
		if ($oUser->only_access_my_own)
		{
			return FALSE;
		}

		header('Pragma: public');
		header('Content-Description: File Transfer');
		header('Content-Type: application/force-download');
		header('Content-Disposition: attachment; filename = "' . $this->_Form->name . '_' . date("Y_m_d_H_i_s") . '.csv' . '";');
		header('Content-Transfer-Encoding: binary');

		foreach ($this->_aCurrentData as $aData)
		{
			$this->_printRow($aData);
		}

		$offset = 0;
		$limit = 100;

		do {
			$oForm_Fills = $this->_Form->Form_Fills;
			$oForm_Fills->queryBuilder()
				->clearOrderBy()
				->orderBy('form_fills.id', 'DESC')
				->offset($offset)
				->limit($limit);

			$aForm_Fills = $oForm_Fills->findAll(FALSE);

			foreach ($aForm_Fills as $oForm_Fill)
			{
				$read = $oForm_Fill->read
					? Core::_('Admin_Form.yes')
					: Core::_('Admin_Form.no');

				$aForm_Fill_Fields = $oForm_Fill->Form_Fill_Fields->findAll();

				$aData = array(
					sprintf('"%s"', $this->_prepareString($oForm_Fill->id)),
					sprintf('"%s"', $this->_prepareString(Core_Date::sql2datetime($oForm_Fill->datetime))),
					sprintf('"%s"', $this->_prepareString($oForm_Fill->ip)),
					sprintf('"%s"', $this->_prepareString($read))
				);

				$aTmp = array();
				foreach ($aForm_Fill_Fields as $oForm_Fill_Field)
				{
					$aTmp[$oForm_Fill_Field->form_field_id] = $oForm_Fill_Field;
				}

				foreach ($this->_aForm_Fields as $oForm_Field)
				{
					$value = '';
					if (isset($aTmp[$oForm_Field->id]))
					{
						/*switch($oForm_Field->type)
						{
							case 0:
							case 1:
							default:
								$value = $aTmp[$oForm_Field->id]->value;
							break;
							case 3:

							break;
						}*/

						$value = $aTmp[$oForm_Field->id]->value;
					}

					$aData[] = sprintf('"%s"', $this->_prepareString($value));
				}



				$this->_printRow($aData);
			}

			$offset += $limit;
		}
		while (count($aForm_Fills));

		exit();
	}

	/**
	 * Prepare string
	 * @param string $string
	 * @return string
	 */
	protected function _prepareString($string)
	{
		return str_replace('"', '""', trim($string));
	}

	/**
	 * Print array
	 * @param array $aData
	 * @return self
	 */
	protected function _printRow($aData)
	{
		echo Shop_Item_Import_Csv_Controller::CorrectToEncoding(implode(';', $aData) . "\n", 'Windows-1251');
		return $this;
	}
}