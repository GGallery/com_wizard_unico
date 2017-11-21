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
JHtml::_('behavior.formvalidation');
?>


<form action="<?php echo JRoute::_('index.php?option=com_wizard&view=unicocustomer&layout=edit&id=' . (int) $this->item->id); ?>"
      method="post"
      name="adminForm"
      id="adminForm"
      class="form-validate form-horizontal">

    <div class="row-fluid">
        <div class="span12">

            <div class="span4">
                <div class="row-fluid">
                    <?php echo $this->form->renderField('id'); ?>
                </div>

                <div class="row-fluid">
                    <?php echo $this->form->renderField('cf');?>
                </div>

            </div>

            <div class="span4">

            </div>

            <div class ="span4">

            </div>

            </fieldset>
            <div>
                <input type="hidden" name="task" value="unicocustomer.edit" />
                <?php echo JHtml::_('form.token'); ?>
            </div>

        </div>
    </div>



    <input id="idelemento" type="hidden" name="idelemento" value="<?php echo $this->item->id; ?>" size = "150px">
    <input id="path" type="hidden" name="path" value="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/mediagg/images/unit/" size = "150px">
    <input id="subpath" type="hidden" name="subpath" value="" size = "150px">
    <input id="url" type="hidden" name="url" value="<?php echo JURI::root(); ?>/contenuti/<?php echo $this->item->id; ?>/" size = "150px">
    <input id="tipologia" type="hidden" name="tipologia" value="" size = "150px">

</form>