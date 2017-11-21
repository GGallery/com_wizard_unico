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

class wizardModelCfordine extends JModelAdmin {

    public function getForm($data = array(), $loadData = true) {
        // Get the form.
        $form = $this->loadForm('com_wizard.Cfordine', 'Cfordine', array('control' => 'jform', 'load_data' => $loadData));

        return $form;
    }

    protected function loadFormData() {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState('com_wizard.edit.Cfordine.data', array());

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
        $cf= $data['cf'];
        $cf=preg_split('/[\r\n]+/', $cf, -1, PREG_SPLIT_NO_EMPTY);
        $esito_controllo=$this->controllocf($cf); //esito_controllo array composto da due array
        $badcf=$esito_controllo[0];
        $goodcf=$esito_controllo[1];
        $db = JFactory::getDBO();

    //IN QUESTO BLOCCO VENGONO CARICATI I CF BUONI

        foreach ($goodcf as $codice_singolo){
            $cs=$codice_singolo['cf'];
            $query = "INSERT IGNORE INTO #__clienti_ordine_farmacisti (cf) values ('$cs')";
            $db->setQuery((string)$query);
            $db->execute();
            $this->allineamentoUtentiGruppoCfordine($goodcf);
    }
    // FINE BLOCCO DEI CF BUONI
    //INIZIO BLOCCO DEI CF CATTIVI
        if (count($badcf)>0) {
            $application=JFactory::getApplication();
            $error_cf_descr=(count($badcf)>1)?(string)count($badcf).' Codici Fiscali errati:':'un Codice Fiscale errato';
            foreach ($badcf as $wrongcf){
                $error_cf_descr=$error_cf_descr."<br>"." ".(string)$wrongcf['cf']." ".$wrongcf['msg'];
            }
            $application->enqueueMessage(JText::_($error_cf_descr), 'error');
        }
    //FINE BLOCCO DEI CF CATTIVI
        return count($goodcf);
    }
    public function controllocf($list){

        $bad=  array();
        $good= array();
        foreach ($list as $cf) {
            $cf= str_replace(array("\n","\r"), "", $cf);
            if($cf!="") {
                $res = $this->docheck($cf);
                if (!$res['valido']) {
                    array_push($bad, $res);
                }else{
                    array_push($good,$res);
                }
            }
        }
       // \Debugbar::log($bad, 'bad');
        return [$bad,$good];
    }
    public function docheck($cf)
    {
        $cf = strtoupper($cf);
        if( $cf === '' ) {
            $res['valido']= false;
            $res['msg'] = 'non è compilato';
            $res['cf'] = $cf;
            return $res;
        } ;
        if( strlen($cf) != 16 ){

            if(strlen($cf) == 15){
                $possibile = $this->try_resolve($cf);

                if($possibile) {
                    $res['valido'] = false;
                    $res['msg'] = "Dovrebbe essere cosi =>" . $possibile;
                    $res['cf'] = $cf;
                    return $res;
                }
            }


            $res['valido']= false;
            $res['msg'] = "ha una lunghezza non \n"
                ."corretta: il codice fiscale dovrebbe essere lungo\n"
                ."esattamente 16 caratteri";
            $res['cf'] = $cf;
            return $res;
        }

        if( preg_match("/^[A-Z0-9]+\$/", $cf) != 1 ){

            $res['valido']= false;
            $res['msg'] = "contiene dei caratteri non validi:\n"
                ."i soli caratteri validi sono le lettere e le cifre";
            $res['cf'] = $cf;
            return $res;

        }
        $s = 0;
        for( $i = 1; $i <= 13; $i += 2 ){
            $c = $cf[$i];
            if( strcmp($c, "0") >= 0 and strcmp($c, "9") <= 0 )
                $s += ord($c) - ord('0');
            else
                $s += ord($c) - ord('A');
        }
        for( $i = 0; $i <= 14; $i += 2 ){
            $c = $cf[$i];
            switch( $c ){
                case '0':  $s += 1;  break;
                case '1':  $s += 0;  break;
                case '2':  $s += 5;  break;
                case '3':  $s += 7;  break;
                case '4':  $s += 9;  break;
                case '5':  $s += 13;  break;
                case '6':  $s += 15;  break;
                case '7':  $s += 17;  break;
                case '8':  $s += 19;  break;
                case '9':  $s += 21;  break;
                case 'A':  $s += 1;  break;
                case 'B':  $s += 0;  break;
                case 'C':  $s += 5;  break;
                case 'D':  $s += 7;  break;
                case 'E':  $s += 9;  break;
                case 'F':  $s += 13;  break;
                case 'G':  $s += 15;  break;
                case 'H':  $s += 17;  break;
                case 'I':  $s += 19;  break;
                case 'J':  $s += 21;  break;
                case 'K':  $s += 2;  break;
                case 'L':  $s += 4;  break;
                case 'M':  $s += 18;  break;
                case 'N':  $s += 20;  break;
                case 'O':  $s += 11;  break;
                case 'P':  $s += 3;  break;
                case 'Q':  $s += 6;  break;
                case 'R':  $s += 8;  break;
                case 'S':  $s += 12;  break;
                case 'T':  $s += 14;  break;
                case 'U':  $s += 16;  break;
                case 'V':  $s += 10;  break;
                case 'W':  $s += 22;  break;
                case 'X':  $s += 25;  break;
                case 'Y':  $s += 24;  break;
                case 'Z':  $s += 23;  break;
                /*. missing_default: .*/
            }
        }
        if( chr($s%26 + ord('A')) != $cf[15] ){
            $res['valido']= false;
            $res['msg'] = "non &egrave; corretto:\n"
                ."il codice di controllo non corrisponde";
            $res['cf'] = $cf;
            return $res;
        }

        $res['valido']= true;
        $res['msg'] = '';
        $res['cf'] = $cf;
        return  $res;
    }
    public function try_resolve($cf){

        $alfabeto = array('a', 'b','c','d','e','g','h','i','l','m','n','o','p','q','r','s','t','u','v','z','w','y','k', 'j', 'f');

        foreach ($alfabeto as $lettera){

            $tmp = strtoupper($cf.$lettera);
            $check = $this->docheck($tmp);
            if($check['valido'])
                return $tmp;
        }

    }
    public function allineamentoUtentiGruppoCfordine($cf){
        $db = JFactory::getDBO();
        $elenco_id_farmacisti = $this->cf_to_id($cf);
        foreach ($elenco_id_farmacisti as $farmacista){
            $query = "INSERT IGNORE INTO #__user_usergroup_map (user_id, group_id) values ($farmacista->id , 13)";
            $db->setQuery((string) $query);
            $db->execute();
        }
    }
    public function cf_to_id($cf){
        $elenco_cf= array();
        foreach ($cf as $codicefiscale){
            array_push($elenco_cf, $codicefiscale['cf']);
        }
        $db = JFactory::getDBO();
        try {
            $query = $db->getQuery(true);
            $query->select('id')
                ->from('#__users_codicefiscale as ucf')
                ->where('ucf.codicefiscale in ( "' . implode('", "', $elenco_cf) . '" )');
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
