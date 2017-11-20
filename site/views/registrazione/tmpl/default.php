<h2 class="title" xmlns="http://www.w3.org/1999/html">NUOVO UTENTE? REGISTRATI</h2>

<div class="row">
    <div class="col-md-7">

        <br>
        <form id="form" class="form-horizontal form-validate " method="post">


            <div class="control-group ">
                <label for="username" class=" control-label">Username</label>
                <div class="controls">
                    <input type="text" class=" required validate-username" id="username" name="username" placeholder="Username">

                </div>
            </div>


            <div class="control-group ">
                <label for="password" class=" control-label">Password</label>
                <div class="controls">
                    <input type="password" class=" required validate-password" id="username" name="password" placeholder="Password">
                </div>
            </div>

            <div class="control-group ">
                <label for="verificapassword" class=" control-label">Verifica password</label>
                <div class="controls">
                    <input type="password" class=" required validate-password" id="verificapassword" placeholder="Verifica passsword">
                </div>
            </div>


            <div class="control-group ">
                <label for="email" class=" control-label">Email</label>
                <div class="controls">
                    <input type="email" class=" required validate-email" id="email" name="email" placeholder="Email">
                </div>
            </div>

            <div class="control-group ">
                <label for="codicefiscale" class=" control-label">Codice fiscale</label>
                <div class="controls">
                    <input type="text" class=" required " id="codicefiscale" name="codicefiscale" placeholder="Codice fiscale">
                </div>
            </div>

            <div class="control-group ">
                <label for="codicefiscale" class=" control-label">Termini e condizioni della <a href="<?php echo JUri::base()."/condizioni.html"; ?>">privacy</a></label>

                <div class="controls">
                    <input id="privacy" type="checkbox" class="required"> Accetta </input>
                </div>
            </div>

            <br><br>

            <input type="hidden"  name="option" value="com_wizard">
            <input type="hidden"  name="task" value="storeaccount">


            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="button" name="Submit" value="Salva" type="submit">
                </div>
            </div>
        </form>

        <div id="log"></div>
    
    </div>
    
    <!--    IMMAGINE DISATTIVATA  -->
    <!--    <div class="col-md-4 text-center box3 ">-->
    <!--        <br>-->
    <!--        <span class="rt-image">-->
    <!--            <img src="/home/images/farmacisti.jpg" alt="farmacisti" style="vertical-align: top; border: 2px solid #ffffff; margin-right: 10px;" height="183" width="349">-->
    <!--        </span>-->
    <!--        <div class="gantry-width-spacer" style="text-align: left;">-->
    <!--            <strong>Registrati/Accedi</strong>-->
    <!--            per iscriverti ai percorsi formativi desiderati.-->
    <!--            <br>-->
    <!--            Se la Farmacia per cui lavori è registrata come Cliente Unico e/o aderente al Progetto zero30, potrai usufruire di prezzi speciali.-->
    <!--        </div>-->
    <!--    </div>-->
</div>


<script type="text/javascript">

    jQuery(document).ready(function(){
        document.formvalidator.setHandler('passverify', function (value) {
            return (jQuery('#password').value == value);
        });
    });

    useraname=false;
    email=false;
    codicefiscale=false;


    jQuery('#username').change(function(){
        field=jQuery('#username').val();
        jQuery.post( "index.php", { option:'com_wizard', task:'checkusername', username: field},function(data){
            if(data >0) {
                jQuery('#username').after('<span class="help-inline">Username già esistente</span>');
                jQuery('#username').parent().parent().addClass('error');
                username = false;
            }
            else {
                jQuery('#username').next('span').remove();
                jQuery('#username').parent().parent().removeClass('error');
                username = true
            }
        });
    });

    jQuery('#email').change(function(){
        field=jQuery('#email').val();
        jQuery.post( "index.php", { option:'com_wizard', task:'checkemail', email: field},function(data){
            if(data >0) {
                jQuery('#email').after('<span class="help-inline">Email già esistente</span>');
                jQuery('#email').parent().parent().addClass('error');
                email = false;
            }
            else {
                jQuery('#email').next('span').remove();
                jQuery('#email').parent().parent().removeClass('error');
                email = true
            }
        });
    });

    jQuery('#codicefiscale').change(function(){
        jQuery('#codicefiscale').after('<span class="help-inline">Validazione in corso</span>');
        jQuery('#codicefiscale').parent().parent().addClass('warning');

        field=jQuery('#codicefiscale').val();
        jQuery.post( "index.php", { option:'com_wizard', task:'checkcodicefiscale', codice: field},function(data){

            jQuery('#codicefiscale').parent().parent().removeClass('error, warning, success');

            if(String(data.valido) == 'false') {
                jQuery('#codicefiscale').parent().parent().removeClass('success, warning');
                jQuery('#codicefiscale').after('<span class="help-inline">'+data.msg+'</span>');
                jQuery('#codicefiscale').parent().parent().addClass('error');
                codicefiscale = false;
            }
            else {
                jQuery('#codicefiscale').next('span').remove();
                jQuery('#codicefiscale').parent().parent().addClass('success');
                jQuery('#codicefiscale').parent().parent().removeClass('error, warning');
                codicefiscale = true
            }
        },'json');
    });





    jQuery('#form').submit(function(e){

//        e.preventDefault();

//        privacy = ( jQuery("#privacy").is(':checked') ) ? 1 : 0;
//        if(!privacy) {
//            alert("Devi accettare le condizioni della privacy");
//            return false;
//        }


        console.log(useraname + email + codicefiscale);
        if(username && email && codicefiscale){
            return true;
        }

        return false;

    })

</script>