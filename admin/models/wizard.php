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

class wizardModelWizard extends JModelLegacy {

    public function getClientiunico(){

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);

        // Select some fields
        $query->select('count(id)')
            ->from('#__clienti_unico as u')
            ->order('id asc')
        ;

        $db->setQuery((string) $query);
        $res = $db->loadResult();

        return $res;
    }

    public function getAderenti030(){

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);

        // Select some fields
        $query->select('count(id)')
            ->from('#__clienti_unico_030 as u')
            ->order('id asc')
        ;

        $db->setQuery((string) $query);
        $res = $db->loadResult();

        return $res;
    }

    public function getUsers(){

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);

        // Select some fields
        $query->select('count(id)')
            ->from('#__users as u')
            ->order('id asc')
        ;

        $db->setQuery((string) $query);
        $res = $db->loadResult();

        return $res;
    }


}
