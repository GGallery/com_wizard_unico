<?php

/**
 * @package		Joomla.Tutorials
 * @subpackage	Component
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;
jimport('joomla.application.component.controllerform');

class wizardControllerCfordine extends JControllerForm {

    public function save($key = NULL, $urlVar = NULL)
    {

        $app = JFactory::getApplication();
        $postData = $app->input->post;

        $data = $postData->get('jform', 'defaultvalue', 'filter');

        $model = $this->getModel();
        $inserted_rows_count=$model->store($data);
        if ($inserted_rows_count>0) {
            $insert_msg=($inserted_rows_count>1)?'Inseriti '.$inserted_rows_count.' CF corretti':'Inserito un CF corretto';
            $this->setRedirect('index.php?option=com_wizard&view=cfordines', JText::_($insert_msg));
        }else{

            $this->setRedirect('index.php?option=com_wizard&view=cfordines', JText::_('nessun codice fiscale inserito'));
        }
    }

}
