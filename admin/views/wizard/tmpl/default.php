<?php
/**
 * @package		Joomla.Tutorials
 * @subpackage	Component
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		License GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');


//Get companie options
JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');



?>
<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">

    <div class="span12">
        <h3><b>Totale clienti Unico: </b> <?php echo $this->clientiunico; ?></h3>
        <h3><b>Totale aderenti progetto 030: </b> <?php echo $this->aderenti030; ?></h3>
        <h3><b>Totale utenti registrati: </b> <?php echo $this->totusers; ?></h3>

    </div>
</div>

