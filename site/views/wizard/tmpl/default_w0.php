<h1>Abilita la tua farmacia ai servizi dedicati al Cliente UNICO</h1>

<div class="row">
    <div class="col-md-7  ">
        <br>
        <br>

        <form id="form" class="form-horizontal form-validate"  method="post">
            <div class="form-group">
                <label for="partitaiva" class="col-sm-2 control-label">Partita IVA</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control required validate-numeric" id="partitaiva" placeholder="Partita IVA">
                </div>
            </div>
            <div class="form-group">
                <label for="codiceunico" class="col-sm-2 control-label">Codice UNICO</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control required validate-numeric" id="codiceunico" placeholder="Codice UNICO">
                </div>
            </div>


            <input type="hidden"  name="option" value="com_wizard">
            <input type="hidden"  name="id_farmacia" id="id_farmacia" value="">
            <input type="hidden"  name="view" value="wizard">
            <input type="hidden"  name="position" value="w1">

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button id="verifica" type="submit" class="btn btn-default" onclick="valida(event)">Verifica</button>
                </div>
            </div>
        </form>

        <div id="log"></div>

    </div>
    <div class="col-md-4 text-center box3">
        <br>
        <span class="rt-image">
            <img src="/home/images/images/titolari.jpg" alt="titolari" style="vertical-align: top; border: 2px solid #ffffff; margin-right: 10px;" height="183" width="350">
        </span>
        <div class="gantry-width-spacer">
            <p style="text-align: left;">
                Abilita tutti i tuoi collaboratori sul sito UNIcollege per usufruire dei prezzi dedicati alle Farmacie
                <strong>Clienti Unico</strong>
                e/o aderenti al
                <strong> Progetto zero30</strong>
            </p>
        </div>
    </div>
</div>


<script type="text/javascript">

    function valida(e) {
        e.preventDefault();

        codice = jQuery('#codiceunico').val();
        partitaiva = jQuery('#partitaiva').val();

        if (codice.length < 6) {
            jQuery('#log').html("Codice UNICO troppo corto, digitare almeno 6 caratteri").removeClass().addClass('error');
            return false
        }

        if (partitaiva.length < 11) {
            jQuery('#log').html("Partita IVA troppo corta, digitare almeno 11 caratteri").removeClass().addClass('error');
            return false
        }
        jQuery('#log').html("Verifica dati in corso...").removeClass().addClass('info');

        jQuery.post( "index.php", { option:'com_wizard', task:'checkfarmacia', codice: codice, partitaiva: partitaiva})
            .done(function( data ) {

                if(data>0){
                    jQuery('#id_farmacia').val(data);
                    jQuery('#log').html("Codici corretti, proseguiamo...").removeClass().addClass('success');
                    jQuery('#form').submit();
                    return false;
                }
                else
                {
                    jQuery('#log').html("Codici errati").removeClass().addClass('error');
                    return false;
                }
            });

    }

</script>