<p class="warning">Completa questo modulo per consentire a tutto il personale della tua farmacia di beneficiare dei prezzi dedicati ai Clienti UNICO. <br>
<b>QUESTA PROCEDURA NON RAPPRESENTA LA REGISTRAZIONE AL PORTALE CHE DOVRA' ESSERE EFFETTUATA DA OGNI SINGOLO FARMACISTA.</b>
</p>


<h1>Farmacia: <?php echo $this->farmacia['ragione_sociale'] ?></h1>
<h3>Indirizzo: <?php echo $this->farmacia['indirizzo'] ?></h3>

<hr>
<div class="row">
    <div class="span6">
        <b>Aggiungi il tuo codice fiscale e quelli dei tuoi dipendenti </b>
        <form id="formnuovo" class="">
            <div class="input-append">
                <input class="span3" id="codice" size="16" type="text"><button class="btn" type="button" onclick="valida(event)">Aggiungi</button>
            </div>
        </form>
        <div id="log"></div>
    </div>
    <div class="span5">
        <div id="codicipresenti" ></div>
    </div>
</div>

<hr>

<div class="row">
    <a class="push-right" href="<?php echo JUri::base()."registrazione.html" ;?>" >REGISTRATI ORA AL PORTALE</a>
</div>


<script type="text/javascript">
    id_farmacia= <?php echo $this->farmacia['id']; ?>;
    getCodici();

    //Click eliminazione
    jQuery('.elimina').live('click', function() {
        jQuery('#log').html('rimozione codice in corso...').removeClass().addClass('info');
        removeCodice(jQuery(this).attr('data-value'));
    });

    function valida(e) {
        e.preventDefault();
        codice = jQuery('#codice').val();
        jQuery('#log').html("verifica e inserimento in corso...").removeClass().addClass('info');

        jQuery.post( "index.php", { option:'com_wizard', task:'checkcodicefiscale', codice: codice }, function(data) {

            if(String(data.valido) == "false" ){
                jQuery('#log').html(data.msg).removeClass().addClass('error');
                return false;
            }
            else {
                addCodice(codice);
            }
        },"json");
    }

    function addCodice(codice){

        jQuery.post( "index.php", { option:'com_wizard', task:'addcodicefiscale', id_farmacia: id_farmacia , codice: codice }, function(data) {

            if (String(data) == 'true') {
                jQuery('#log').html("codice inserito").removeClass().addClass('success');
                getCodici(id_farmacia);
            }
            else {
                jQuery('#log').html("errore inserimento").removeClass().addClass('error');
            }
        });
    }


    function removeCodice(codice){
        jQuery.post( "index.php", { option:'com_wizard', task:'removecodicefiscale', id_farmacia: id_farmacia , codice: codice }, function(data) {

            if (String(data) == 'true') {
                jQuery('#log').html("codice eliminato").removeClass().addClass('success');
                getCodici(id_farmacia);
            }
            else {
                jQuery('#log').html("errore cancellazione").removeClass().addClass('error');
            }
        });
    }

    function getCodici(){
        jQuery.post( "index.php", { option:'com_wizard', task:'getcodicifiscali', id_farmacia: id_farmacia}, function(data) {
            jQuery('#codicipresenti').html('');
            jQuery.each(data, function (key, val){
                tmp='<div class="input-append"><input class="span3" id="appendedInputButton" size="20"  disabled type="text" value="'+val.cf+'"><button class="btn btn-danger elimina" data-value="'+val.cf+'" type="button">Elimina</button></div>';
                jQuery('#codicipresenti').append(tmp);
            });
            jQuery('#log').html("").removeClass();
        },'json');
    }






</script>