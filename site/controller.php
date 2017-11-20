<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once 'models/libs/FirePHPCore/fb.php';

jimport('joomla.application.component.controller');
jimport( 'joomla.access.access' );
jimport( 'joomla.application.application' );

class wizardController extends JControllerLegacy {

    protected $_db;
    private $_japp;
    private $_session;

    public function __construct($config = array()) {
        parent::__construct($config);
        $this->_db = &JFactory::getDbo();

        $document = JFactory::getDocument();

        JHtml::_('jquery.framework',true);
        JHtml::_('bootstrap.framework');
        $document->addStyleSheet('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
        $document->addStyleSheet('components/com_wizard/css/custom.css');

    }

    public function wizard(){

        $this->view= 'wizard';
        parent::display();
    }

    public function checkusername(){
        $this->_japp = &JFactory::getApplication();
        $query = $this->_db->getQuery(true);
        try {
            $query->select('count(id)');
            $query->from('#__users');
            $query->where('username = "'. $_REQUEST['username'].'"');

            $this->_db->setQuery((string) $query, 0);
            $res = $this->_db->loadResult();
        } catch (Exception $e) {
            FB::log($e);
        }
        echo  $res;
        $this->_japp->close();
    }

    public function checkfarmacia(){
        $this->_japp = &JFactory::getApplication();
        $query = $this->_db->getQuery(true);
        try {
            $query->select('id');
            $query->from('#__clienti_unico');
            $query->where('codice = "'. $_REQUEST['codice'].'"');
            $query->where('partita_iva= "'. $_REQUEST['partitaiva'].'"');

            $this->_db->setQuery((string) $query, 0);
            $res = $this->_db->loadResult();

        } catch (Exception $e) {
            FB::log($e);
        }

        $this->_session = JFactory::getSession();
        $this->_session->set( 'id_farmacia', $res  );

        echo  $res;
        $this->_japp->close();
    }

    public function checkcodicefiscale(){
        $this->_japp = &JFactory::getApplication();
        $res = $this->conformita_cf($_REQUEST['codice']);
        echo  json_encode($res);

        $this->_japp->close();
    }

    public function addcodicefiscale(){
        $this->_japp = &JFactory::getApplication();

        try {
            $query="INSERT IGNORE INTO #__farmacisti_unico set id_farmacia = ".$_REQUEST['id_farmacia'] . ", cf='".$_REQUEST['codice']."'";
            $this->_db->setQuery((string) $query, 0);
            $this->_db->execute();

            $query2="INSERT IGNORE INTO #__user_usergroup_map SELECT c.id, '10' FROM #__users_codicefiscale as c WHERE c.codicefiscale like '".$_REQUEST['codice']."'";
            $this->_db->setQuery((string) $query2);
            $this->_db->execute();

        } catch (Exception $e) {
            echo $query."<br>". $query2;
        }
        echo 'true';

        $this->_japp->close();
    }

    public function removecodicefiscale(){
        $this->_japp = &JFactory::getApplication();

        try {
            $query="DELETE FROM #__farmacisti_unico WHERE  cf = '".$_REQUEST['codice'] ."'   and id_farmacia='".$_REQUEST['id_farmacia']."'  ";
            $this->_db->setQuery((string) $query, 0);
            $res = $this->_db->loadResult();
        } catch (Exception $e) {
            echo $query;
        }
        echo 'true';

        $this->_japp->close();
    }

    public function getcodicifiscali(){
        $this->_japp = &JFactory::getApplication();
        $query = $this->_db->getQuery(true);
        try {
            $query->select('*');
            $query->from('#__farmacisti_unico');
            $query->where('id_farmacia= "'. $_REQUEST['id_farmacia'].'"');

            $this->_db->setQuery((string) $query, 0);
            $res = $this->_db->loadAssocList();

        } catch (Exception $e) {
            FB::log($e);
        }

        echo  json_encode($res);
        $this->_japp->close();
    }

    public function checkemail(){
        $this->_japp = &JFactory::getApplication();
        $query = $this->_db->getQuery(true);
        try {
            $query->select('count(id)');
            $query->from('#__users');
            $query->where('email = "'. $_REQUEST['email'].'"');

            $this->_db->setQuery((string) $query, 0);
            $res = $this->_db->loadResult();
        } catch (Exception $e) {
            FB::log($e);
        }
        echo  $res;
        $this->_japp->close();
    }

    public function conformita_cf($cf)
    {

        $cf = strtoupper($cf);

        if( $cf === '' ) {
            $res['valido']= false;
            $res['msg'] = 'non è compilato';
            $res['cf'] = $cf;
            return $res;
        } ;
        if( strlen($cf) != 16 ){
            $res['valido']= false;
            $res['msg'] = "ha una lunghezza non \n"
                ."corretta: il codice fiscale dovrebbe essere lungo\n"
                ."esattamente 16 caratteri";
            $res['cf'] = $cf;
            return $res;
        }




        if( preg_match("/^[A-Z0-9]+\$/", $cf) != 1 ){

            $res['valido']= false;
            $res['msg'] = "contiene dei caratteri non validi:\n"
                ."i soli caratteri validi sono le lettere e le cifre";
            $res['cf'] = $cf;
            return $res;

        }
        $s = 0;
        for( $i = 1; $i <= 13; $i += 2 ){
            $c = $cf[$i];
            if( strcmp($c, "0") >= 0 and strcmp($c, "9") <= 0 )
                $s += ord($c) - ord('0');
            else
                $s += ord($c) - ord('A');
        }
        for( $i = 0; $i <= 14; $i += 2 ){
            $c = $cf[$i];
            switch( $c ){
                case '0':  $s += 1;  break;
                case '1':  $s += 0;  break;
                case '2':  $s += 5;  break;
                case '3':  $s += 7;  break;
                case '4':  $s += 9;  break;
                case '5':  $s += 13;  break;
                case '6':  $s += 15;  break;
                case '7':  $s += 17;  break;
                case '8':  $s += 19;  break;
                case '9':  $s += 21;  break;
                case 'A':  $s += 1;  break;
                case 'B':  $s += 0;  break;
                case 'C':  $s += 5;  break;
                case 'D':  $s += 7;  break;
                case 'E':  $s += 9;  break;
                case 'F':  $s += 13;  break;
                case 'G':  $s += 15;  break;
                case 'H':  $s += 17;  break;
                case 'I':  $s += 19;  break;
                case 'J':  $s += 21;  break;
                case 'K':  $s += 2;  break;
                case 'L':  $s += 4;  break;
                case 'M':  $s += 18;  break;
                case 'N':  $s += 20;  break;
                case 'O':  $s += 11;  break;
                case 'P':  $s += 3;  break;
                case 'Q':  $s += 6;  break;
                case 'R':  $s += 8;  break;
                case 'S':  $s += 12;  break;
                case 'T':  $s += 14;  break;
                case 'U':  $s += 16;  break;
                case 'V':  $s += 10;  break;
                case 'W':  $s += 22;  break;
                case 'X':  $s += 25;  break;
                case 'Y':  $s += 24;  break;
                case 'Z':  $s += 23;  break;
                /*. missing_default: .*/
            }
        }
        if( chr($s%26 + ord('A')) != $cf[15] ){
            $res['valido']= false;
            $res['msg'] = "non &egrave; corretto:\n"
                ."il codice di controllo non corrisponde";
            $res['cf'] = $cf;
            return $res;
        }

        $res['valido']= true;
        $res['msg'] = '';
        $res['cf'] = $cf;
        return  $res;
    }

    public function storeaccount(){
        $this->_japp = &JFactory::getApplication();

        jimport('joomla.user.helper');

        //insert user
        $query = $this->_db->getQuery(true);
        $query->insert("#__users");
        $query->set("name=''");
        $query->set("username='".$_REQUEST['username']."'");
        $query->set("email='".$_REQUEST['email']."'");
        $query->set("password='".JUserHelper::hashPassword($_REQUEST['password'])."'");
        $query->set("registerDate= now() ");

        $this->_db->setQuery((string) $query);
        $this->_db->execute();


        //ID utente
        $user_id= $this->_db->insertid();


        //add usergroup Registred
        $query = $this->_db->getQuery(true);
        $query->insert("#__user_usergroup_map");
        $query->set("user_id='" . $user_id . "'");
        $query->set("group_id='2'"); //Registred

        $this->_db->setQuery((string)$query);
        $this->_db->execute();


        //add usergroup Fonditalia030, solo se se lo merita
        $query = $this->_db->getQuery(true);

        $query->select('count(*)');
        $query->from('#__farmacisti_unico as f');
        $query->join('inner','#__clienti_unico as u on u.id = f.id_farmacia');
        $query->join('inner','#__clienti_unico_030 as z on z.partita_iva = u.partita_iva');
        $query->where('f.cf like "'. $_REQUEST['codicefiscale'].'"');
        $this->_db->setQuery((string) $query, 0);
        $abilitato030 = $this->_db->loadResult();

        if($abilitato030) {
            try {
                $query = $this->_db->getQuery(true);
                $query->insert("#__user_usergroup_map");
                $query->set("user_id='" . $user_id . "'");
                $query->set("group_id='11'"); //fonditalia

                $this->_db->setQuery((string)$query);
                $this->_db->execute();
            }catch (Exception $e){
                var_dump($e);
            }
        }

        //add usergroup Unico , solo se se lo merita
        $query = $this->_db->getQuery(true);

        $query->select('count(id_farmacia)');
        $query->from('#__farmacisti_unico');
        $query->where('cf like "'. $_REQUEST['codicefiscale'].'"');
        $this->_db->setQuery((string) $query, 0);
        $abilitato = $this->_db->loadResult();

        if($abilitato) {
            try {
                $query = $this->_db->getQuery(true);
                $query->insert("#__user_usergroup_map");
                $query->set("user_id='" . $user_id . "'");
                $query->set("group_id='10'"); //Unico

                $this->_db->setQuery((string)$query);
                $this->_db->execute();
            }catch (Exception $e){
                var_dump($e);
            }
        }


        //add usergroup Unico , solo se se lo merita
        $query = $this->_db->getQuery(true);

        $query->select('count(cf)');
        $query->from('#__clienti_ordine_farmacisti');
        $query->where('cf like "'. $_REQUEST['codicefiscale'].'"');
        $this->_db->setQuery((string) $query, 0);
        $abilitato_ordini = $this->_db->loadResult();


        if($abilitato_ordini) {
            try {
                $query = $this->_db->getQuery(true);
                $query->insert("#__user_usergroup_map");
                $query->set("user_id='" . $user_id . "'");
                $query->set("group_id='13'"); //Ordine Farmacisti

                $this->_db->setQuery((string)$query);
                $this->_db->execute();
            }catch (Exception $e){
                var_dump($e);
            }
        }
    
        
        //add extra field
        $query = $this->_db->getQuery(true);
        $query->insert("#__users_codicefiscale");
        $query->set("id='".$user_id."'");
        $query->set("codicefiscale='".$_REQUEST['codicefiscale']."'");

        $this->_db->setQuery((string) $query);
        $this->_db->execute();



        //mail di conferma
        $destinatari = array( $_REQUEST['email']);
        $oggetto ="Registrazione UNIcollege completata";

        $body   = '<h2>Registrazione effettuata con successo.</h2>'
            .'Le tue credenziali sono: <br><br>'
            .'Username: <b>'.$_REQUEST['username'] .'</b> <br> '
            .'Password: <b>'.$_REQUEST['password'] .'</b> <br><br> '

            . '<div>Lo staff di UNIcollege </div> <br><br>'
            . '<img src="cid:logo_id" alt="logo"/></div>';

        $this->sendMail($destinatari, $oggetto ,$body);

        //login
        $credentials = array();
        $credentials['username'] =$_REQUEST['username'];
        $credentials['password'] =$_REQUEST['password'];

        $options = array();
        $this->_japp->login($credentials, $options);

        $msg = 'Registrazione completata';
        $this->_japp->redirect(JRoute::_('index.php?option=com_wizard&lyt=regcompleted'), $msg);


//        return;
    }

    public function sendMail($destinatari, $oggetto, $body ){

        $mailer = JFactory::getMailer();

        $config = JFactory::getConfig();
        $sender = array(
            $config->get( 'mailfrom' ),
            $config->get( 'fromname' )
        );
        $mailer->setSender($sender);


        $mailer->addRecipient($destinatari);
        $mailer->setSubject($oggetto);
        $mailer->isHtml(true);
        $mailer->Encoding = 'base64';
        $mailer->setBody($body);
        //optional
        $mailer->AddEmbeddedImage( JPATH_COMPONENT.'/images/logo.jpg', 'logo_id', 'logo.jpg', 'base64', 'image/jpeg' );


        $send = $mailer->Send();
        if ( $send !== true )
            return 'Errore invio mail: ';
        else
            return 'Mail inviata';

    }

    public function  logout(){
        $this->_japp = &JFactory::getApplication();

        $user = JFactory::getUser();
        $user_id = $user->get('id');

        $this->_japp->logout($user_id, array());
        $this->_japp->redirect(JURI::base().'index.php' );
    }
}

