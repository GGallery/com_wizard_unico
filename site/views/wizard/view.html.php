<?php

/**
 * @version		1
 * @package		webtv
 * @author 		antonio
 * @author mail	tony@bslt.it
 * @link
 * @copyright	Copyright (C) 2011 antonio - All rights reserved.
 * @license		GNU/GPL
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
JHtml::_('behavior.formvalidator');

class WizardViewWizard extends JViewLegacy {

    function display($tpl = null) {

        $session = JFactory::getSession();
        $model = & $this->getModel();

        $tpl = $session->get( 'position', 'w0' );
        
        if($tpl=='w1')
            $this->farmacia = $model->getFarmacia();


        parent::display($tpl);
    }
}
