<?php

require_once 'Admin/pages/AdminObjectEdit.php';
require_once 'Admin/dataobjects/AdminComponent.php';
require_once 'Admin/dataobjects/AdminSubComponent.php';

/**
 * Edit page for AdminSubComponents
 *
 * @package   Admin
 * @copyright 2005-2014 silverorange
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 */
class AdminAdminSubComponentEdit extends AdminObjectEdit
{
	// {{{ protected properties

	protected $component;

	// }}}
	// {{{ protected function getObjectClass()

	protected function getObjectClass()
	{
		return 'AdminSubComponent';
	}

	// }}}
	// {{{ protected function getUiXml()

	protected function getUiXml()
	{
		return 'Admin/components/AdminSubComponent/edit.xml';
	}

	// }}}

	// init phase
	// {{{ protected function initInternal()

	protected function initInternal()
	{
		parent::initInternal();

		$this->initComponent();
	}

	// }}}
	// {{{ protected function initComponent()

	protected function initComponent()
	{
		if ($this->isNew()) {
			$parent_id = SiteApplication::initVar('parent');

			if ($parent_id === null) {
				throw new AdminNotFoundException(
					Admin::_(
						'Must supply a Component ID for newly created '.
						'Sub-Compoenets.'
					)
				);
			}

			$class_name = SwatDBClassMap::get('AdminComponent');
			$this->component = new $class_name();
			$this->component->setDatabase($this->app->db);

			if (!$this->component->load($parent_id)) {
				throw new AdminNotFoundException(
					sprintf(
						Admin::_('Component with id "%s" not found.'),
						$parent_id
					)
				);
			}
		} else {
			$this->component = $this->getObject()->component;
		}
	}

	// }}}

	// process phase
	// {{{ protected function validate()

	protected function validate()
	{
		$shortname_widget = $this->ui->getWidget('shortname');
		$shortname = $shortname_widget->value;

		if (!($this->isNew() && $shortname != '') &&
			!$this->validateShortname($shortname)) {
			$message = new SwatMessage(
				Admin::_('Shortname already exists and must be unique.'),
				'error'
			);

			$shortname_widget->addMessage($message);
		}
	}

	// }}}
	// {{{ protected function updateObject()

	protected function updateObject()
	{
		parent::updateObject();

		$this->assignUiValues(
			array(
				'title',
				'shortname',
				'visible',
			)
		);


		if ($this->isNew()) {
			$this->getObject()->component = $this->component;
		}
	}

	// }}}
	// {{{ protected function getSavedMessageText()

	protected function getSavedMessageText()
	{
		return sprintf(
			Admin::_('Sub-Component “%s” has been saved.'),
			$this->getObject()->title
		);
	}

	// }}}

	// build phase
	// {{{ protected function buildForm()

	protected function buildForm()
	{
		parent::buildForm();

		$form = $this->ui->getWidget('edit_form');
		$form->addHiddenField('parent', $this->component->id);
	}

	// }}}
	// {{{ protected function loadObject()

	protected function loadObject()
	{
		$this->assignValuesToUi(
			array(
				'title',
				'shortname',
				'visible',
			)
		);
	}

	// }}}
	// {{{ protected function buildNavBar()

	protected function buildNavBar()
	{
		$this->navbar->popEntry();

		$this->navbar->createEntry(
			Admin::_('Admin Components'),
			'AdminComponent'
		);

		$this->navbar->createEntry(
			$this->component->title,
			sprintf(
				'AdminComponent/Details?id=%s',
				$this->component->id
			)
		);

		$this->navbar->createEntry(
			($this->isNew())
				? Admin::_('Add Sub-Component')
				: Admin::_('Edit Sub-Component')
		);
	}

	// }}}
}

?>
