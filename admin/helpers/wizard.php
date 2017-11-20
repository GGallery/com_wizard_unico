<?php

/**
 * @package		Joomla.Tutorials
 * @subpackage	Components
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;

class wizardHelper {

    public static function addSubmenu($submenu) {

        JHtmlSidebar::addEntry(
            '<i class="icon-info"></i>' . 'Dashbaord',
            'index.php?option=com_wizard ',
            $submenu == 'contents'
        );

        JHtmlSidebar::addEntry(
            '<i class="icon-user"></i>' . 'Clienti Unico',
            'index.php?option=com_wizard&view=unicocustomers',
            $submenu == 'contents'
        );

        JHtmlSidebar::addEntry(
            '<i class="icon-users"></i>' . JText::_('Clienti 030'),
            'index.php?option=com_wizard&view=030s',
            $submenu == 'unitas'
        );
// 

        $document = JFactory::getDocument();

        if ($submenu == 'wizard') {
            $document->setTitle("Dashboard");
        }

        if ($submenu == 'unicocustomers') {
            $document->setTitle("Clienti Unico");
        }

        if ($submenu == '030s') {
            $document->setTitle("Clienti 030");
        }


    }


    public static function SetCFAssociati($item){
        $db = JFactory::getDBO();

        $contentid=$item['id'];
        $cfassociati = explode("," , $item['cfassociati']);

        if(!$contentid)
            return false;

        foreach ($cfassociati as $value) {
            $query = "INSERT IGNORE INTO #__farmacisti_unico (id_farmacia, cf) values ($contentid , '$value')";
            $db->setQuery((string) $query);
            $db->execute();
        }

        return true;
    }

    public static function GetCFAssociati($item){

        $res= array();
        if(!$item->id)
            return $res;

        try{
            $db = JFactory::getDBO();

            $query = $db->getQuery(true);
            $query->select('UPPER(cf)')
                ->from('#__farmacisti_unico')
                ->where('id_farmacia = '.$item->id)

            ;

            $db->setQuery((string) $query);
            $res = $db->loadColumn();


            return $res;
        }
        catch(Exception $e)
        {
            echo (string)$query;
        }
    }

    public static function GetUtentiAssociati($cflist){

        $res= array();
        if(empty($cflist))
            return $res;

        try{
            $db = JFactory::getDBO();

            $query = $db->getQuery(true);
            $query->select('u.*, ucf.codicefiscale')
                ->from('#__users_codicefiscale as ucf')
                ->join('inner' , '#__users as u on u.id = ucf.id')
                ->where('ucf.codicefiscale in ("'  .implode('","',$cflist ).  '")'  );
            
            $db->setQuery((string) $query);
            $res = $db->loadObjectList();


            return $res;
        }
        catch(Exception $e)
        {
            echo "ERRORE in GetUtentiAssociati ";
            echo (string)$query;
            die();
        }
    }

    public static function GetIscrizioniEB($userid){

        $res= array();

        try{
            $db = JFactory::getDBO();

            $query = $db->getQuery(true);
            $query->select('DISTINCT e.title, r.published')
                ->from('#__eb_registrants AS r')
                ->join('inner' , '#__eb_events AS e ON e.id = r.event_id')
                ->where('r.user_id = '. $userid );

            $db->setQuery((string) $query);
            $res = $db->loadObjectList();


            return $res;
        }
        catch(Exception $e)
        {
            echo "ERRORE in GetUtentiAssociati ";
            echo (string)$query;
            die();
        }
    }

    public static function getIscrizione030($item){

        $res= array();
        if(empty($item))
            return $res;

        try{
            $db = JFactory::getDBO();

            $query = $db->getQuery(true);
            $query->select('count(*) as res')
                ->from('#__clienti_unico_030 as zero')
                ->where('zero.partita_iva = "'.$item->partita_iva.'"' );

            $db->setQuery((string) $query);
            $res = $db->loadResult();

            return $res;
        }
        catch(Exception $e)
        {
            echo "ERRORE in getIscrizione030  ";
            echo (string)$query;
            die();
        }
    }




}