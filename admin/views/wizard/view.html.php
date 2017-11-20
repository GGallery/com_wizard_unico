<?php

/**
 * @package		Joomla.Tutorials
 * @subpackage	Component
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

class wizardViewWizard extends JViewLegacy {

    function display($tpl = null) {

//        $this->farmacisti = $this->get('farmacisti');
        $this->clientiunico = $this->get('clientiunico');
        $this->aderenti030  = $this->get('aderenti030');
        $this->totusers     = $this->get('users');

        $this->sidebar = JHtmlSidebar::render();
        // Set the toolbar
        $this->addToolBar();

        // Display the template
        parent::display($tpl);

        // Set the document
        $this->setDocument();
    }

    protected function addToolBar() {

        JToolBarHelper::title('Dashboard', 'Wizard');
    }

    protected function setDocument() {
        $document = JFactory::getDocument();
        $document->setTitle(JText::_('Dashboard'));
    }

}
