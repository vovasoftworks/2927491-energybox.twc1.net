<?php

defined('HOSTCMS') || exit('HostCMS: access denied.');

/**
 * Form Backend Editing Controller.
 *
 * @package HostCMS
 * @subpackage Form
 * @version 6.x
 * @author Hostmake LLC
 * @copyright © 2005-2020 ООО "Хостмэйк" (Hostmake LLC), http://www.hostcms.ru
 */
class Form_Controller_Edit extends Admin_Form_Action_Controller_Type_Edit
{
	/**
	 * Set object
	 * @param object $object object
	 * @return self
	 */
	public function setObject($object)
	{
		$title = $object->id
			? Core::_('Form.edit_title', $object->name)
			: Core::_('Form.add_title');

		parent::setObject($object);

		$oMainTab = $this->getTab('main');
		$oAdditionalTab = $this->getTab('additional');

		$oMainTab
			->add($oMainRow1 = Admin_Form_Entity::factory('Div')->class('row'))
			->add($oMainRow2 = Admin_Form_Entity::factory('Div')->class('row'))
			->add($oMainRow3 = Admin_Form_Entity::factory('Div')->class('row'))
			->add($oMainRow4 = Admin_Form_Entity::factory('Div')->class('row'))
			->add($oMainRow5 = Admin_Form_Entity::factory('Div')->class('row'))
			->add($oMainRowCaptcha = Admin_Form_Entity::factory('Div')->class('row'))
			->add($oMainRowLead = Admin_Form_Entity::factory('Div')->class('row'))
			->add($oMainRowNotification = Admin_Form_Entity::factory('Div')->class('row'))
			->add($oMainRow6 = Admin_Form_Entity::factory('Div')->class('row'));

		$oMainTab
			->move($this->getField('name'), $oMainRow1)
			->move($this->getField('description')
				->rows(10)
				->wysiwyg(Core::moduleIsActive('wysiwyg')
			), $oMainRow2);

		$oAdditionalTab->delete($this->getField('site_id'));

		$oUser_Controller_Edit = new User_Controller_Edit($this->_Admin_Form_Action);

		// Список сайтов
		$oSelect_Sites = Admin_Form_Entity::factory('Select')
			->options($oUser_Controller_Edit->fillSites())
			->name('site_id')
			->value($this->_object->site_id)
			->divAttr(array('class' => 'form-group col-xs-12 col-sm-6'))
			->caption(Core::_('Form.site_id'));

		$oMainRow3->add($oSelect_Sites);

		$oMainTab
			->move($this->getField('email')->format(array('lib' => array()))->divAttr(array('class' => 'form-group col-xs-12 col-sm-6')), $oMainRow3)
			->move($this->getField('button_name')->divAttr(array('class' => 'form-group col-xs-12 col-sm-6')), $oMainRow4)
			->move($this->getField('button_value')->divAttr(array('class' => 'form-group col-xs-12 col-sm-6')), $oMainRow4)
			->move($this->getField('email_subject')->divAttr(array('class' => 'form-group col-xs-12')), $oMainRow5)
			->move($this->getField('success_text')
				->rows(10)
				->wysiwyg(Core::moduleIsActive('wysiwyg')
			), $oMainRow6);

			// Notification subscribers
			if (Core::moduleIsActive('notification'))
			{
				$oSite = Core_Entity::factory('Site', CURRENT_SITE);
				$aSelectSubscribers = $oSite->Companies->getUsersOptions();

				$oModule = Core::$modulesList['form'];

				$aSubscribers = array();

				$oNotification_Subscribers = Core_Entity::factory('Notification_Subscriber');
				$oNotification_Subscribers->queryBuilder()
					->where('notification_subscribers.module_id', '=', $oModule->id)
					->where('notification_subscribers.type', '=', 0)
					->where('notification_subscribers.entity_id', '=', $this->_object->id);

				$aNotification_Subscribers = $oNotification_Subscribers->findAll(FALSE);

				foreach ($aNotification_Subscribers as $oNotification_Subscriber)
				{
					$aSubscribers[] = $oNotification_Subscriber->user_id;
				}

				$oNotificationSubscribersSelect = Admin_Form_Entity::factory('Select')
					->caption(Core::_('Form.notification_subscribers'))
					->options($aSelectSubscribers)
					->name('notification_subscribers[]')
					->class('form-notification-subscribers')
					->value($aSubscribers)
					->style('width: 100%')
					->multiple('multiple')
					->divAttr(array('class' => 'form-group col-xs-12'));

				$oMainRowNotification->add($oNotificationSubscribersSelect);

				$html = '
					<script>
						$(function(){
							$(".form-notification-subscribers").select2({
								language: "' . Core_i18n::instance()->getLng() . '",
								placeholder: "' . Core::_('Form.type_subscriber') . '",
								allowClear: true,
								templateResult: $.templateResultItemResponsibleEmployees,
								escapeMarkup: function(m) { return m; },
								templateSelection: $.templateSelectionItemResponsibleEmployees,
								width: "100%"
							});
						})</script>
					';

				$oMainRowNotification->add(Admin_Form_Entity::factory('Code')->html($html));
			}

		$oMainTab->move($this->getField('use_captcha')->divAttr(array('class' => 'form-group col-xs-12 col-sm-6 col-md-4 margin-top-21')), $oMainRowCaptcha);

		if (Core::moduleIsActive('lead'))
		{
			$hidden = !$this->_object->create_lead ? ' hidden' : '';

			$oMainTab->move($this->getField('create_lead')->divAttr(array('class' => 'form-group col-xs-12 col-sm-6 col-md-4 margin-top-21')), $oMainRowCaptcha);

			$oAdditionalTab->delete($this->getField('crm_source_id'));

			$aMasCrmSources = array(array('value' => Core::_('Admin.none'), 'color' => '#aebec4'));

			$aCrm_Sources = Core_Entity::factory('Crm_Source')->findAll();
			foreach ($aCrm_Sources as $oCrm_Source)
			{
				$aMasCrmSources[$oCrm_Source->id] = array(
					'value' => $oCrm_Source->name,
					'color' => $oCrm_Source->color,
					'icon' => $oCrm_Source->icon
				);
			}

			$oDropdownlistCrmSources = Admin_Form_Entity::factory('Dropdownlist')
				->options($aMasCrmSources)
				->name('crm_source_id')
				->value($this->_object->crm_source_id)
				->caption(Core::_('Form.crm_source_id'))
				->divAttr(array('class' => 'form-group col-xs-12 col-sm-3 crm-source' . $hidden));

			$oMainRowCaptcha
				->add($oDropdownlistCrmSources);

			$oFormTabConformity = Admin_Form_Entity::factory('Tab')
				->caption(Core::_('Form.tab_conformity'))
				->name('Conformity')
				->class('lead-tab' . $hidden);

			$oFormTabConformity
				->add($oFormTabConformityRow1 = Admin_Form_Entity::factory('Div')->class('row'));

			$this
				->addTabAfter($oFormTabConformity, $oMainTab);

			$script = '
				<script>
					$(function(){
						$("input[name = create_lead]").on("change", function(){
							$(".lead-tab, .crm-source").toggleClass("hidden");
						});
					})</script>
				';

			$oMainRowLead->add(Admin_Form_Entity::factory('Code')->html($script));

			$aForm_Lead_Conformities = $this->_object->Form_Lead_Conformities->findAll();

			$aMasFormField = array('...');

			$aAvailableFieldTypes = array(0, 5);

			$oForm_Fields = $this->_object->Form_Fields;
			$oForm_Fields->queryBuilder()
				->where('form_fields.type', 'IN', $aAvailableFieldTypes);

			$aForm_Fields = $oForm_Fields->findAll();

			foreach ($aForm_Fields as $oForm_Field)
			{
				$aMasFormField[$oForm_Field->id] = $oForm_Field->caption;
			}

			$aConformities = array(
				'' => '...',
				'name' => Core::_('Lead.name'),
				'surname' => Core::_('Lead.surname'),
				'patronymic' => Core::_('Lead.patronymic'),
				'post' => Core::_('Lead.post'),
				'company' => Core::_('Lead.company'),
				'comment' => Core::_('Lead.comment'),
				'email' => Core::_('Directory_Email.email'),
				'phone' => Core::_('Directory_Phone.phone'),
				'postcode' => Core::_('Directory_Address.address_postcode'),
				'country' => Core::_('Directory_Address.address_country'),
				'city' => Core::_('Directory_Address.address_city'),
				'address' => Core::_('Directory_Address.address'),
				'website' => Core::_('Directory_Website.site'),
			);

			if (count($aForm_Lead_Conformities))
			{
				foreach ($aForm_Lead_Conformities as $oForm_Lead_Conformity)
				{
					$oFormTabConformity->add($oFormTabConformityRow = Admin_Form_Entity::factory('Div')->class('row'));

					 $oFormTabConformityRow->add(
							Admin_Form_Entity::factory('Select')
								->options($aMasFormField)
								->name('form_lead_comformity_field#' . $oForm_Lead_Conformity->id)
								->value($oForm_Lead_Conformity->form_field_id)
								->caption(Core::_('Form.form_fields'))
								->divAttr(array('class' => 'form-group col-xs-4'))
						)
						->add(
							Admin_Form_Entity::factory('Select')
								->options($aConformities)
								->name('form_lead_comformity#' . $oForm_Lead_Conformity->id)
								->value($oForm_Lead_Conformity->conformity)
								->caption(Core::_('Form.lead_conformity'))
								->divAttr(array('class' => 'form-group col-xs-4'))
						)
						->add(
							Admin_Form_Entity::factory('Div') // div с кноками + и -
								->class('no-padding add-remove-property margin-top-23 pull-left')
								->add(
									Admin_Form_Entity::factory('Code')
										->html('<div class="btn btn-palegreen" onclick="$.cloneFormRow(this); event.stopPropagation();"><i class="fa fa-plus-circle close"></i></div><div class="btn btn-darkorange btn-delete" onclick="$.deleteFormRow(this); event.stopPropagation();"><i class="fa fa-minus-circle close"></i></div>')
								)
						);
				}
			}
			else
			{
				 $oFormTabConformityRow1->add(
						Admin_Form_Entity::factory('Select')
							->options($aMasFormField)
							->name('form_lead_comformity_field[]')
							->value(0)
							->caption(Core::_('Form.form_fields'))
							->divAttr(array('class' => 'form-group col-xs-4'))
					)
					->add(
						Admin_Form_Entity::factory('Select')
							->options($aConformities)
							->name('form_lead_comformity[]')
							->value('')
							->caption(Core::_('Form.lead_conformity'))
							->divAttr(array('class' => 'form-group col-xs-4'))
					)
					->add(
						Admin_Form_Entity::factory('Div') // div с кноками + и -
							->class('no-padding add-remove-property margin-top-23 pull-left')
							->add(
								Admin_Form_Entity::factory('Code')
									->html('<div class="btn btn-palegreen" onclick="$.cloneFormRow(this); event.stopPropagation();"><i class="fa fa-plus-circle close"></i></div><div class="btn btn-darkorange btn-delete hide" onclick="$.deleteFormRow(this); event.stopPropagation();"><i class="fa fa-minus-circle close"></i></div>')
							)
					);
			}
		}

		$this->title($title);

		return $this;
	}

	/**
	 * Processing of the form. Apply object fields.
	 * @hostcms-event Form_Controller_Edit.onAfterRedeclaredApplyObjectProperty
	 */
	protected function _applyObjectProperty()
	{
		// Backup revision
		if (Core::moduleIsActive('revision')  && $this->_object->id)
		{
			$this->_object->backupRevision();
		}

		parent::_applyObjectProperty();

		$windowId = $this->_Admin_Form_Controller->getWindowId();

		// Соответствия, установленные значения
		$aForm_Lead_Conformities = $this->_object->Form_Lead_Conformities->findAll();
		foreach ($aForm_Lead_Conformities as $oForm_Lead_Conformity)
		{
			$iFormLeadComformityField = intval(Core_Array::getPost("form_lead_comformity_field#{$oForm_Lead_Conformity->id}"));

			if ($iFormLeadComformityField)
			{
				$oForm_Lead_Conformity
					->form_field_id($iFormLeadComformityField)
					->conformity(strval(Core_Array::getPost("form_lead_comformity#{$oForm_Lead_Conformity->id}")))
					->save();
			}
			else
			{
				// Удаляем пустую строку с полями
				ob_start();
				Core::factory('Core_Html_Entity_Script')
					->value("$.deleteFormRow($(\"#{$windowId} select[name='form_lead_comformity_field#{$oForm_Lead_Conformity->id}']\").closest('.row').find('.btn-delete').get(0));")
					->execute();

				$this->_Admin_Form_Controller->addMessage(ob_get_clean());
				$oForm_Lead_Conformity->delete();
			}
		}

		// Соответствия, новые значения
		$aFormLeadComformityFields = Core_Array::getPost('form_lead_comformity_field', array());
		$aLeadConformities = Core_Array::getPost('form_lead_comformity', array());

		$i = 0;

		foreach($aFormLeadComformityFields as $key => $form_field_id)
		{
			$form_field_id = intval($form_field_id);

			if ($form_field_id)
			{
				$oForm_Lead_Conformity = Core_Entity::factory('Form_Lead_Conformity');
				$oForm_Lead_Conformity->form_id = $this->_object->id;
				$oForm_Lead_Conformity->form_field_id = $form_field_id;
				$oForm_Lead_Conformity->conformity = strval(Core_Array::get($aLeadConformities, $key));
				$oForm_Lead_Conformity->save();

				ob_start();
				Core::factory('Core_Html_Entity_Script')
					->value("$(\"#{$windowId} select[name='form_lead_comformity_field\\[\\]']\").eq({$i}).prop('name', 'form_lead_comformity_field#{$oForm_Lead_Conformity->id}').closest('.row').find('.btn-delete').removeClass('hide');
					$(\"#{$windowId} select[name='form_lead_comformity\\[\\]']\").eq({$i}).prop('name', 'form_lead_comformity#{$oForm_Lead_Conformity->id}');
					")
					->execute();

				$this->_Admin_Form_Controller->addMessage(ob_get_clean());
			}
			else
			{
				$i++;
			}
		}

		if (Core::moduleIsActive('notification'))
		{
			$oModule = Core::$modulesList['form'];

			$aRecievedNotificationSubscribers = Core_Array::getPost('notification_subscribers', array());
			!is_array($aRecievedNotificationSubscribers) && $aRecievedNotificationSubscribers = array();

			$aTmp = array();

			// Выбранные сотрудники
			$oNotification_Subscribers = Core_Entity::factory('Notification_Subscriber');
			$oNotification_Subscribers->queryBuilder()
				->where('notification_subscribers.module_id', '=', $oModule->id)
				->where('notification_subscribers.type', '=', 0)
				->where('notification_subscribers.entity_id', '=', $this->_object->id)
				;

			$aNotification_Subscribers = $oNotification_Subscribers->findAll(FALSE);

			foreach ($aNotification_Subscribers as $oNotification_Subscriber)
			{
				!in_array($oNotification_Subscriber->user_id, $aRecievedNotificationSubscribers)
					? $oNotification_Subscriber->delete()
					: $aTmp[] = $oNotification_Subscriber->user_id;
			}

			// $aNewRecievedNotificationSubscribers = array_diff($aRecievedNotificationSubscribers, $aTmp);

			foreach ($aRecievedNotificationSubscribers as $user_id)
			{
				$oNotification_Subscribers = Core_Entity::factory('Notification_Subscriber');
				$oNotification_Subscribers->queryBuilder()
					->where('notification_subscribers.module_id', '=', $oModule->id)
					->where('notification_subscribers.user_id', '=', intval($user_id))
					->where('notification_subscribers.entity_id', '=', $this->_object->id)
					;

				$iCount = $oNotification_Subscribers->getCount();

				if (!$iCount)
				{
					$oNotification_Subscriber = Core_Entity::factory('Notification_Subscriber');
					$oNotification_Subscriber
						->module_id($oModule->id)
						->type(0)
						->entity_id($this->_object->id)
						->user_id($user_id)
						->save();
				}
			}
		}

		Core_Event::notify(get_class($this) . '.onAfterRedeclaredApplyObjectProperty', $this, array($this->_Admin_Form_Controller));
	}
}