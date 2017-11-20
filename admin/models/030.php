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

class wizardModel030 extends JModelAdmin {

    public function getForm($data = array(), $loadData = true) {
        // Get the form.
        $form = $this->loadForm('com_wizard.030', '030', array('control' => 'jform', 'load_data' => $loadData));

        return $form;
    }

    protected function loadFormData() {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_wizard.edit.030.data', array());

        if (empty($data)) {
            $data = $this->getItem();

            // $data->categoria = explode(',', $data->categoria);
            // $data->esercizi = explode(',', $data->esercizi);


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
        //debug::msg('model->getItem');

        if ($item = parent::getItem($pk)) {

        }

        return $item;
    }


    public function store($data)
    {

        $piva= $data['partita_iva'];

        $db = JFactory::getDBO();
        $query = "INSERT IGNORE INTO #__clienti_unico_030 (partita_iva) values ('$piva')";


        $db->setQuery((string) $query);
        $db->execute();

        $this->allineamntoUtentiGruppo030($piva);

        return true;
    }

    public function allineamntoUtentiGruppo030($piva){

        $db = JFactory::getDBO();

        $elenco_cf_farmacisti = $this->getFarmacistiaventidiritto($piva);

        $elenco_id_farmacisti = $this->cf_to_id($elenco_cf_farmacisti);

        foreach ($elenco_id_farmacisti as $farmacista){
            $query = "INSERT IGNORE INTO #__user_usergroup_map (user_id, group_id) values ($farmacista->id , 11)";
            $db->setQuery((string) $query);
            $db->execute();
        }

    }

    public function getFarmacistiaventidiritto($piva){

        $db = JFactory::getDBO();
        try {
            $query = $db->getQuery(true);
            $query->select('farmacisti.cf')
                ->from('#__clienti_unico_030 as zero')
                ->join('inner', '#__clienti_unico  as clienti on clienti.partita_iva=zero.partita_iva')
                ->join('inner', '#__farmacisti_unico  as farmacisti on clienti.id=farmacisti.id_farmacia')
                ->where('zero.partita_iva = "'.$piva.'"')

            ;

            $db->setQuery((string)$query);
            $res = $db->loadColumn();

            return $res;
        }
        catch (Exception $e){
            echo "Errore getFarmacistiaventidiritto";
            print_r($e);
            die();
        }
        return null;
    }

    public function cf_to_id($elenco_cf){


        $db = JFactory::getDBO();
        try {
            $query = $db->getQuery(true);
            $query->select('id')
                ->from('#__users_codicefiscale as ucf')
                ->where('ucf.codicefiscale in ( "' . implode('", "', $elenco_cf) . '" )')
            ;
            $db->setQuery((string)$query);
            $res = $db->loadObjectList();

            return $res;
        }
        catch (Exception $e){
            echo "Errore cf_to_id";
            print_r($e);
            die();
        }
        return null;
    }
}
