<?php

/**
 * @file plugins/generic/disqus/DisqusSettingsForm.inc.php
 *
 * Copyright (c) 2014-2018 Simon Fraser University
 * Copyright (c) 2003-2018 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class disqusSettingsForm
 * @ingroup plugins_generic_disqus
 *
 * @brief Form for managers to modify disqus plugin settings
 */

import('lib.pkp.classes.form.Form');

class DisqusSettingsForm extends Form {

	/** @var int */
	var $contextId;

	/** @var object */
	var $plugin;

	/**
	 * Constructor
	 * @param $plugin DisqusPlugin
	 * @param $contextId int
	 */
	function __construct($plugin, $contextId) {
		$this->contextId = $contextId;
		$this->plugin = $plugin;

		parent::__construct($plugin->getTemplateResource('settingsForm.tpl'));

		$this->addCheck(new FormValidator($this, 'disqusForumName', 'required', 'plugins.generic.disqus.manager.settings.disqusForumNameRequired'));

		$this->addCheck(new FormValidatorPost($this));
		$this->addCheck(new FormValidatorCSRF($this));
	}

	/**
	 * Initialize form data.
	 */
	function initData() {
		$this->_data = array(
			'disqusForumName' => $this->plugin->getSetting($this->contextId, 'disqusForumName'),
		);
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
		$this->readUserVars(array('disqusForumName'));
	}

	/**
	 * Fetch the form.
	 * @copydoc Form::fetch()
	 */
	function fetch($request, $template = null, $display = false) {
		$templateMgr = TemplateManager::getManager($request);
		$templateMgr->assign('pluginName', $this->plugin->getName());
		return parent::fetch($request, $template, $display);
	}

	/**
	 * Save settings.
	 */
	function execute() {
		$this->plugin->updateSetting($this->contextId, 'disqusForumName', trim($this->getData('disqusForumName'), "\"\';"), 'string');
	}
}

?>
