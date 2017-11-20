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

class wizardController030 extends JControllerForm {


    public function save($key = NULL, $urlVar = NULL)
    {

        $app = JFactory::getApplication();
        $postData = $app->input->post;

        $data = $postData->get('jform', 'defaultvalue', 'filter');


        $model = $this->getModel();
        $model->store($data);

        $this->setRedirect('index.php?option=com_wizard&view=030s', JText::_('Partita IVA salvata e CF associati allineati al gruppo 030'));
    }

}
