<?php

defined('HOSTCMS') || exit('HostCMS: access denied.');

/**
 * List Backend Editing Controller.
 *
 * @package HostCMS
 * @subpackage List
 * @version 6.x
 * @author Hostmake LLC
 * @copyright © 2005-2020 ООО "Хостмэйк" (Hostmake LLC), http://www.hostcms.ru
 */
class List_Controller_Edit extends Admin_Form_Action_Controller_Type_Edit
{
	/**
	 * Set object
	 * @param object $object object
	 * @return self
	 */
	public function setObject($object)
	{
		parent::setObject($object);

		$modelName = $this->_object->getModelName();

		$oMainTab = $this->getTab('main');
		$oAdditionalTab = $this->getTab('additional');

		$oSelect_Dirs = Admin_Form_Entity::factory('Select');

		switch ($modelName)
		{
			case 'list':
				if (!$this->_object->id)
				{
					$this->_object->list_dir_id = Core_Array::getGet('list_dir_id');
				}

				$oMainTab
					->add($oMainRow1 = Admin_Form_Entity::factory('Div')->class('row'))
					->add($oMainRow2 = Admin_Form_Entity::factory('Div')->class('row'))
					->add($oMainRow3 = Admin_Form_Entity::factory('Div')->class('row'))
				;

				$oMainTab
					->move($this->getField('name')->divAttr(array('class' => 'form-group col-xs-12')), $oMainRow1)
					->move($this->getField('description')->divAttr(array('class' => 'form-group col-xs-12')), $oMainRow2);

				$oAdditionalTab->delete($this->getField('list_dir_id'));

				// Добавляем группу списков
				$aResult = $this->listDirShow('list_dir_id');
				foreach ($aResult as $resultItem)
				{
					$oMainRow3->add($resultItem);
				}

				// Удаляем стандартный <input>
				$oAdditionalTab->delete($this->getField('site_id'));

				$oUser_Controller_Edit = new User_Controller_Edit($this->_Admin_Form_Action);

				// Селектор с группой
				$oSelect_Sites = Admin_Form_Entity::factory('Select')
					->options($oUser_Controller_Edit->fillSites())
					->name('site_id')
					->value($this->_object->site_id)
					->caption(Core::_('List.site_id'))
					->divAttr(array('class' => 'form-group col-xs-12 col-sm-4'));

				$oMainRow3->add($oSelect_Sites);

				$oMainTab->delete($this->getField('url_type'));

				$oSelect_Url = Admin_Form_Entity::factory('Select')
					->options(array(
						0 => Core::_('List.url_type0'),
						1 => Core::_('List.url_type1'),
						2 => Core::_('List.url_type2')
					))
					->name('url_type')
					->value($this->_object->url_type)
					->caption(Core::_('List.url_type'))
					->divAttr(array('class' => 'form-group col-xs-12 col-sm-4'));

				$oMainRow3->add($oSelect_Url);

				$title = $this->_object->id
					? Core::_('List.edit_title', $this->_object->name)
					: Core::_('List.add_title');
			break;
			case 'list_dir':
			default:
				// Значения директории для добавляемого объекта
				if (!$this->_object->id)
				{
					$this->_object->parent_id = Core_Array::getGet('list_dir_id');
				}

				$oMainTab
					->add($oMainRow1 = Admin_Form_Entity::factory('Div')->class('row'))
					->add($oMainRow2 = Admin_Form_Entity::factory('Div')->class('row'))
					->add($oMainRow3 = Admin_Form_Entity::factory('Div')->class('row'));

				$oMainTab
					->move($this->getField('name')->divAttr(array('class' => 'form-group col-xs-12')), $oMainRow1)
					->move($this->getField('description')->divAttr(array('class' => 'form-group col-xs-12')), $oMainRow2);

				// Удаляем стандартный <input>
				$oAdditionalTab->delete($this->getField('parent_id'));

				$aResult = $this->listDirShow('parent_id');
				foreach ($aResult as $resultItem)
				{
					$oMainRow3->add($resultItem);
				}

				$title = $this->_object->id
					? Core::_('List_Dir.edit_title', $this->_object->name)
					: Core::_('List_Dir.add_title');
			break;
		}

		$this->title($title);

		return $this;
	}

	/**
	 * Показ списка групп или поле ввода с autocomplete для большого количества групп
	 * @param string $fieldName имя поля группы
	 * @return array  массив элементов, для добавления в строку
	 */
	public function listDirShow($fieldName)
	{
		$return = array();

		$iCountDirs = $this->_object->Site->List_Dirs->getCount();

		switch (get_class($this->_object))
		{
			case 'List_Model':
				$aExclude = array();
			break;
			case 'List_Dir_Model':
			default:
				$aExclude = array($this->_object->id);
		}

		if ($iCountDirs < Core::$mainConfig['switchSelectToAutocomplete'])
		{
			$oListDirSelect = Admin_Form_Entity::factory('Select');
			$oListDirSelect
				->caption(Core::_('List_Dir.parent_name'))
				->options(array(' … ') + $this->fillListDir(0, $aExclude))
				->name($fieldName)
				->value($this->_object->$fieldName)
				->divAttr(array('class' => 'form-group col-xs-12'));

			$return = array($oListDirSelect);
		}
		else
		{
			$oList_Dir = Core_Entity::factory('List_Dir', $this->_object->$fieldName);

			$oListDirInput = Admin_Form_Entity::factory('Input')
				->caption(Core::_('List_Dir.parent_name'))
				->divAttr(array('class' => 'form-group col-xs-12'))
				->name('list_dir_name');

			$this->_object->$fieldName
				&& $oListDirInput->value($oList_Dir->name . ' [' . $oList_Dir->id . ']');

			$oListDirInputHidden = Admin_Form_Entity::factory('Input')
				->divAttr(array('class' => 'form-group col-xs-12 hidden'))
				->name($fieldName)
				->value($this->_object->$fieldName)
				->type('hidden');

			$oCore_Html_Entity_Script = Core::factory('Core_Html_Entity_Script')
				->value("
					$('[name = list_dir_name]').autocomplete({
						  source: function(request, response) {

							$.ajax({
							  url: '/admin/list/index.php?autocomplete=1&show_dir=1&site_id={$this->_object->site_id}',
							  dataType: 'json',
							  data: {
								queryString: request.term
							  },
							  success: function( data ) {
								response( data );
							  }
							});
						  },
						  minLength: 1,
						  create: function() {
							$(this).data('ui-autocomplete')._renderItem = function( ul, item ) {
								return $('<li></li>')
									.data('item.autocomplete', item)
									.append($('<a>').text(item.label))
									.appendTo(ul);
							}

							 $(this).prev('.ui-helper-hidden-accessible').remove();
						  },
						  select: function( event, ui ) {
							$('[name = {$fieldName}]').val(ui.item.id);
						  },
						  open: function() {
							$(this).removeClass('ui-corner-all').addClass('ui-corner-top');
						  },
						  close: function() {
							$(this).removeClass('ui-corner-top').addClass('ui-corner-all');
						  }
					});
				");

			$return = array($oListDirInput, $oListDirInputHidden, $oCore_Html_Entity_Script);
		}

		return $return;
	}

	/**
	 * Executes the business logic.
	 * @param mixed $operation Operation name
	 * @return self
	 */
	public function execute($operation = NULL)
	{
		if (!is_null($operation) && $operation != '')
		{
			$list_name = trim(Core_Array::get($this->_formValues, 'name'));
			$site_id = Core_Array::get($this->_formValues, 'site_id');
			$list_dir_id = Core_Array::get($this->_formValues, 'list_dir_id');
			$id = Core_Array::get($this->_formValues, 'id');

			$oSameLists = Core_Entity::factory('Site', $site_id)->Lists;
			$oSameLists->queryBuilder()
				->where('lists.list_dir_id', '=', $list_dir_id)
				->where('lists.name', '=', $list_name)
				->where('lists.id', '!=', $id);

			if ($oSameLists->getCount(FALSE))
			{
				$this->addMessage(
					Core_Message::get(Core::_('List.list_exists'), 'error')
				);

				return TRUE;
			}
		}

		return parent::execute($operation);
	}

	/**
	 * List dirs tree
	 * @var array
	 */
	protected $_aDirsTree = array();

	/**
	 * Create visual tree of the directories
	 * @param int $iListDirParentId parent directory ID
	 * @param array $aExclude exclude dir ID
	 * @param int $iLevel current nesting level
	 * @return array
	 */
	public function fillListDir($iListDirParentId = 0, $aExclude = array(), $iLevel = 0)
	{
		$iListDirParentId = intval($iListDirParentId);
		$iLevel = intval($iLevel);

		if ($iLevel == 0)
		{
			$aTmp = Core_QueryBuilder::select('id', 'parent_id', 'name')
				->from('list_dirs')
				->where('site_id', '=', CURRENT_SITE)
				->where('deleted', '=', 0)
				->execute()->asAssoc()->result();

			foreach ($aTmp as $aDir)
			{
				$this->_aDirsTree[$aDir['parent_id']][] = $aDir;
			}
		}

		$aReturn = array();

		if (isset($this->_aDirsTree[$iListDirParentId]))
		{
			$countExclude = count($aExclude);
			foreach ($this->_aDirsTree[$iListDirParentId] as $childrenDir)
			{
				if ($countExclude == 0 || !in_array($childrenDir['id'], $aExclude))
				{
					$aReturn[$childrenDir['id']] = str_repeat('  ', $iLevel) . $childrenDir['name'] . ' [' . $childrenDir['id'] . ']';
					$aReturn += $this->fillListDir($childrenDir['id'], $aExclude, $iLevel + 1);
				}
			}
		}

		$iLevel == 0 && $this->_aDirsTree = array();

		return $aReturn;
	}

	/**
	 * Fill lists list
	 * @param itn $iSiteId site id
	 * @param itn $parent_id
	 * @return array
	 */
	public function fillLists($iSiteId, $parent_id = 0, $iLevel = 0)
	{
		$iSiteId = intval($iSiteId);
		$parent_id = intval($parent_id);

		$aReturn = array();

		$oList_Dirs = Core_Entity::factory('Site', $iSiteId)->List_Dirs;
		$oList_Dirs->queryBuilder()
			->where('list_dirs.parent_id', '=', $parent_id);

		$aList_Dirs = $oList_Dirs->findAll(FALSE);

		foreach ($aList_Dirs as $oList_Dir)
		{
			$aReturn['dir-' . $oList_Dir->id] = array (
				'value' => str_repeat('  ', $iLevel) . $oList_Dir->name,
				'attr' => array('disabled' => 'disabled')
			);

			$aReturn += $this->fillLists($iSiteId, $oList_Dir->id, $iLevel + 1);
		}

		$oLists = Core_Entity::factory('Site', $iSiteId)->Lists;
		$oLists->queryBuilder()
			->where('lists.list_dir_id', '=', $parent_id);

		$aLists = $oLists->findAll(FALSE);

		foreach ($aLists as $oList)
		{
			$aReturn[$oList->id] = str_repeat('  ', $iLevel) . $oList->name;
		}

		return $aReturn;
	}
}