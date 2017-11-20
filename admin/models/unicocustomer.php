<?php

/**
 * @package		Joomla.Tutorials
 * @subpackage	Component
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');
require_once 'libs/getid3/getid3.php';

class wizardModelUnicocustomer extends JModelAdmin {
    
    public function getForm($data = array(), $loadData = true) {
        // Get the form.
        $form = $this->loadForm('com_wizard.Unicocustomer', 'Unicocustomer', array('control' => 'jform', 'load_data' => $loadData));

        return $form;
    }

    protected function loadFormData() {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_wizard.edit.unicocustomer.data', array());

        if (empty($data)) {
            $data = $this->getItem();

        }
        return $data;
    }

    /*
     * Verifico la durata del contenuto 
     */

    public function getTable($name = '', $prefix = 'wizardTable', $options = array()) {

        return parent::getTable($name, $prefix, $options);
    }

    /**
     * Method to get a single record.
     *
     * @param	integer	The id of the primary key.
     *
     * @return	mixed	Object on success, false on failure.
     */
    public function getItem($pk = null) {

        if ($item = parent::getItem($pk)) {
            $item->iscrizione030  = wizardHelper::getIscrizione030($item);
            
            $item->cfassociati_arr = wizardHelper::GetCFAssociati($item);

            $item->cfassociati= implode(",",$item->cfassociati_arr);

            $item->utenti_associati = wizardHelper::GetUtentiAssociati($item->cfassociati_arr);


        }

        return $item;
    }


   
}
