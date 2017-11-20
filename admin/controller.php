<?php

/**
 * @package		Joomla.Tutorials
 * @subpackage	Component
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class wizardController extends JControllerLegacy {

    public function __construct($config = array()) {
        parent::__construct($config);
    }

    public function __destruct() {
    }

    function display($cachable = false, $urlparams = false) {

// Add submenu
        wizardHelper::addSubmenu('wizard');
//        echo  $this->sidebar = JHtmlSidebar::render();  //RS

        
        JRequest::setVar('view', JRequest::getCmd('view', 'wizard'));
        parent::display($cachable);
    }

}
