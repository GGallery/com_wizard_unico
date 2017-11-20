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

class wizardView030 extends JViewLegacy {

    public function display($tpl = null) {
        $form = $this->get('Form');
        $item = $this->get('Item');


        $this->form = $form;
        $this->item = $item;

        $this->addToolBar();

        jimport('joomla.environment.uri');
        $host = JURI::root();

        // Display the template
        parent::display($tpl);

        // Set the document
    }

    protected function addToolBar() {
         
        JFactory::getApplication()->input->get('hidemainmenu', true); 
        $isNew = ($this->item->id == 0);
        JToolBarHelper::title($isNew ? 'Nuova partita iva' : 'Modifica partita iva', '030');
        JToolBarHelper::save('030.save');
        JToolBarHelper::apply('030.apply');
        JToolBarHelper::cancel('030.cancel', $isNew ? 'Annulla' : 'Chiudi');
    }

    /**
     * Method to set up the document properties
     *
     * @return void
     */

}
