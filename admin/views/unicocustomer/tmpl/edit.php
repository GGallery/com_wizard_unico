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
                    <?php echo $this->form->renderField('codice'); ?>
                </div>

                <div class="row-fluid">
                    <?php echo $this->form->renderField('ragione_sociale'); ?>
                </div>

                <div class="row-fluid">
                    <?php echo $this->form->renderField('partita_iva'); ?>
                </div>

                <div class="row-fluid">
                    <?php echo $this->form->renderField('email'); ?>
                </div>




            </div>

            <div class="span4">
                <div class="row-fluid">
                    <?php echo $this->form->renderField('descrizione'); ?>
                </div>


                <div class="row-fluid">
                    <?php echo $this->form->renderField('localita'); ?>
                </div>


                <div class="row-fluid">
                    <?php echo $this->form->renderField('provincia'); ?>
                </div>

                <div class="row-fluid">
                    <?php echo $this->form->renderField('indirizzo'); ?>
                </div>

                <div class="row-fluid">
                    <?php echo $this->form->renderField('cap'); ?>
                </div>


                <div class="row-fluid">
                    <?php echo $this->form->renderField('prefisso'); ?>
                </div>

                <div class="row-fluid">
                    <?php echo $this->form->renderField('telefono'); ?>
                </div>



            </div>

            <div class ="span4">

                <div class="row-fluid">
                    <?php echo $this->form->renderField('cfassociati'); ?>
                </div>

                <label>Lista dei cf leggibile</label>
                <ul>
                    <?php foreach ($this->item->cfassociati_arr as $cf){
                        echo "<li>$cf</li>";
                    } ?>
                </ul>



            </div>

            </fieldset>
            <div>
                <input type="hidden" name="task" value="unicocustomer.edit" />
                <?php echo JHtml::_('form.token'); ?>
            </div>

        </div>
    </div>

    <div class="row-fluid">
        <div class="span12">

            <?php
            if($this->item->iscrizione030){
                echo "<h2>Farmacia iscritta allo 030</h2>";
            }
            else
            {
                echo "<h2>Farmacia NON iscritta allo 030</h2>";
            }
            ?>

            <h3>Utenti che si sono registrati al portale associati a questa farmacia</h3>
            <table class="table table-striped">
                <thead>
                <td>ID</td>
                <td>Name</td>
                <td>Email</td>
                <td>Codice Fiscale</td>
                <td>Data Registr.</td>
                <td>Gruppo Unico</td>
                <td>Gruppo Fonditalia</td>
                <td>Si è iscritto ai seguenti corsi (confermato/non confermato)</td>
                </thead>

                <?php
                foreach ($this->item->utenti_associati as $utente) {
                    echo "<tr>";
                    echo "<td>$utente->id</td>";
                    echo "<td>$utente->username</td>";
                    echo "<td>$utente->email</td>";
                    echo "<td>".strtoupper($utente->codicefiscale)."</td>";
                    echo "<td>$utente->registerDate</td>";

                    $groups = JAccess::getGroupsByUser($utente->id);
                    if(in_array(10, $groups))
                        echo "<td align='center'><span class='icon-thumbs-up'> </span></td>";
                    else
                        echo "<td align='center'><span class='icon-minus-sign'> </span></td>";

                    if(in_array(11, $groups))
                        echo "<td align='center'><span class='icon-thumbs-up'> </span></td>";
                    else
                        echo "<td align='center'><span class='icon-minus-sign'> </span></td>";



                    echo "<td>";
                    $iscrizioni = wizardHelper::GetIscrizioniEB($utente->id);

//                        print_r($iscrizioni);
                    foreach ($iscrizioni as $iscrizione){
                        echo $iscrizione->title. " -> ";
                        echo ($iscrizione->published) ?  "<span class='icon-thumbs-up'> </span>" : "<span class='icon-minus-sign'> </span>";
                        echo "<br>";

                    }
                    echo "</td>";

                    echo "</tr>";

                }
                ?>
            </table>
        </div>
    </div>


    <input id="idelemento" type="hidden" name="idelemento" value="<?php echo $this->item->id; ?>" size = "150px">
    <input id="path" type="hidden" name="path" value="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/mediagg/images/unit/" size = "150px">
    <input id="subpath" type="hidden" name="subpath" value="" size = "150px">
    <input id="url" type="hidden" name="url" value="<?php echo JURI::root(); ?>/contenuti/<?php echo $this->item->id; ?>/" size = "150px">
    <input id="tipologia" type="hidden" name="tipologia" value="" size = "150px">

</form>