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

class wizardViewcfordines extends JViewLegacy {

    function display($tpl = null) {

        $this->items = $this->get('Items');
        //var_dump($this->items);
        $this->pagination = $this->get('Pagination');
        $this->state = $this->get('State');

//      Following variables used more than once
//      $this->sortColumn = $this->state->get('list.ordering');
//      $this->sortDirection = $this->state->get('list.direction');
        $this->searchterms = $this->state->get('filter.search');


        $this->sidebar = JHtmlSidebar::render();
        // Set the toolbar
        $this->addToolBar();

        // Display the template
        parent::display($tpl);

        // Set the document
        $this->setDocument();
    }

    protected function addToolBar() {

        JToolBarHelper::title('Codici Fiscali Ordine Farmacisti', 'Cfordines');
        //JToolBarHelper::deleteList('Elimina farmacia', 'Cfordine.delete');
        //JToolBarHelper::editList('Cfordine.edit');
        JToolBarHelper::addNew('Cfordine.add','Nuovi Codici Fiscali');
    }

    protected function setDocument() {
        $document = JFactory::getDocument();
        $document->setTitle(JText::_('Codici Fiscali Ordine Farmacisti'));
    }

}
