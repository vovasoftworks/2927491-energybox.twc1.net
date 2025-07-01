<?php

defined('HOSTCMS') || exit('HostCMS: access denied.');

/**
 * Crm_Project_Model
 *
 * @package HostCMS
 * @subpackage Crm
 * @version 6.x
 * @author Hostmake LLC
 * @copyright © 2005-2020 ООО "Хостмэйк" (Hostmake LLC), http://www.hostcms.ru
 */
class Crm_Project_Model extends Core_Entity
{
	/**
	 * One-to-many or many-to-many relations
	 * @var array
	 */
	protected $_hasMany = array(
		'event' => array(),
		'deal' => array(),
		'crm_project_note' => array(),
	);

	/**
	 * Belongs to relations
	 * @var array
	 */
	protected $_belongsTo = array(
		'user' => array(),
		'site' => array(),
	);

	/**
	 * Constructor.
	 * @param int $id entity ID
	 */
	public function __construct($id = NULL)
	{
		parent::__construct($id);

		if (is_null($id) && !$this->loaded())
		{
			$oUser = Core_Auth::getCurrentUser();
			$this->_preloadValues['user_id'] = is_null($oUser) ? 0 : $oUser->id;
			$this->_preloadValues['site_id'] = defined('CURRENT_SITE') ? CURRENT_SITE : 0;
			$this->_preloadValues['datetime'] = Core_Date::timestamp2sql(time());
		}
	}

	/**
	 * Backend callback method
	 * @return string
	 */
	public function nameBackend($oAdmin_Form_Field, $oAdmin_Form_Controller)
	{
		$link = $oAdmin_Form_Field->link;
		$onclick = $oAdmin_Form_Field->onclick;

		$link = $oAdmin_Form_Controller->doReplaces($oAdmin_Form_Field, $this, $link);
		$onclick = $oAdmin_Form_Controller->doReplaces($oAdmin_Form_Field, $this, $onclick);

		return '<i class="fa fa-circle" style="margin-right: 5px; color: ' . ($this->color ? htmlspecialchars($this->color) : '#aebec4' ) . '"></i> '
			. '<a href="' . $link . '" onclick="' . $onclick . '">' . htmlspecialchars($this->name) . '</a>';
	}

	/**
	 * Backend callback method
	 * @return string
	 */
	public function nameBadge($oAdmin_Form_Field, $oAdmin_Form_Controller)
	{
		if (Core::moduleIsActive('event') && $this->Events->getCount())
		{
			$countEvents = $this->Events->getCount();

			Core::factory('Core_Html_Entity_Span')
				->class('label label-palegreen label-crm-project')
				->value('<i class="fa fa-tasks"></i> ' . $countEvents)
				->title(Core::_('Crm_Project.events_count', $countEvents))
				->execute();
		}

		if (Core::moduleIsActive('deal') && $this->Deals->getCount())
		{
			$countDeals = $this->Deals->getCount();

			Core::factory('Core_Html_Entity_Span')
				->class('label label-azure label-crm-project')
				->value('<i class="fa fa-handshake-o"></i> ' . $countDeals)
				->title(Core::_('Crm_Project.deals_count', $countDeals))
				->execute();
		}

		$countNotes = $this->Crm_Project_Notes->getCount();

		$countNotes && Core::factory('Core_Html_Entity_Span')
			->class('label label-warning label-crm-project')
			->value('<i class="fa fa-comment-o"></i> ' . $countNotes)
			->title(Core::_('Crm_Project.notes_count', $countNotes))
			->execute();
	}

	/**
	 * Backend callback method
	 * @return string
	 */
 	public function datetimeBackend()
	{
		return $this->datetime != '0000-00-00 00:00:00'
			? Core_Date::timestamp2string(Core_Date::sql2timestamp($this->datetime))
			: '—';
	}

	/**
	 * Backend callback method
	 * @return string
	 */
 	public function deadlineBackend()
	{
		return $this->deadline != '0000-00-00 00:00:00'
			? '<span class="' . $this->getDeadlineClass() . '">' . Core_Date::timestamp2string(Core_Date::sql2timestamp($this->deadline)) . '</span>'
			: '—';
	}

	/**
	 * Get deadline class
	 * @return string
	 */
	public function getDeadlineClass()
	{
		$deadlineTimestamp = Core_Date::sql2timestamp($this->deadline);

		$today = strtotime('today');
		$tomorrow = strtotime('+1 day', $today);
		$after_tomorrow = strtotime('+2 day', $today);

		if($deadlineTimestamp < time())
		{
			$class = 'darkorange';
		}
		elseif (($deadlineTimestamp > $today && $deadlineTimestamp < $tomorrow)
			|| ($deadlineTimestamp > $tomorrow && $deadlineTimestamp < $after_tomorrow)
		)
		{
			$class = 'palegreen';
		}
		else
		{
			$class = '';
		}

		return $class;
	}

	/**
	 * Delete object from database
	 * @param mixed $primaryKey primary key for deleting object
	 * @return Core_Entity
	 * @hostcms-event crm_project.onBeforeRedeclaredDelete
	 */
	public function delete($primaryKey = NULL)
	{
		if (is_null($primaryKey))
		{
			$primaryKey = $this->getPrimaryKey();
		}

		$this->id = $primaryKey;

		Core_Event::notify($this->_modelName . '.onBeforeRedeclaredDelete', $this, array($primaryKey));

		$this->Crm_Project_Notes->deleteAll(FALSE);

		if (Core::moduleIsActive('event'))
		{
			Core_QueryBuilder::update('events')
				->set('crm_project_id', 0)
				->where('crm_project_id', '=', $this->id)
				->execute();
		}

		if (Core::moduleIsActive('deal'))
		{
			Core_QueryBuilder::update('deals')
				->set('crm_project_id', 0)
				->where('crm_project_id', '=', $this->id)
				->execute();
		}

		return parent::delete($primaryKey);
	}
}