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

class WizardViewRegistrazione extends JViewLegacy {

    function display($tpl = null) {

        $this->user = JFactory::getUser();
        if (!$this->user->guest == 1)
            $tpl = 'logout';

        if($_REQUEST['lyt'] =='regcompleted')
            $tpl='registrazionecompletata';


        parent::display($tpl);
    }
}
