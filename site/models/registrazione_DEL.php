<?php

/**
 * WebTVContenuto Model
 *
 * @package    Joomla.Components
 * @subpackage WebTV
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');


/**
 * WebTVContenuto Model
 *
 * @package    Joomla.Components
 * @subpackage WebTV
 */
class wizardModelRegistrazione extends JModelLegacy {

	private $_japp;
	protected $_db;
	public $_session;
	public $_userid;
	public $_parametri;

	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->_japp = &JFactory::getApplication();
		$this->_db = &JFactory::getDbo();

		$this->_session = JFactory::getSession();

		$user = JFactory::getUser();
		$this->_userid = $user->get('id');


		if($_REQUEST['position'])
			$this->_session->set( 'position',  $_REQUEST['position'] );


		$this->_parametri['position'] = $this->_session->get('position');
		$this->_parametri['titolare'] = $this->_session->get('titolare');


//		$user = JFactory::getUser();
//		$this->_userid = $user->get('id');
	}

	public function __destruct() {

	}

	public function storeAccount(){

		jimport('joomla.user.helper');

		//insert user
		$query = $this->_db->getQuery(true);
		$query->insert("#__users");
		$query->set("name='".$_REQUEST['username']."'");
		$query->set("username='".$_REQUEST['username']."'");
		$query->set("email='".$_REQUEST['email']."'");
		$query->set("password='".JUserHelper::hashPassword($_REQUEST['password'])."'");
		$query->set("registerDate= now() ");

		$this->_db->setQuery((string) $query);
		$this->_db->execute();

		$user_id= $this->_db->insertid();

		//add usergroup
		$query = $this->_db->getQuery(true);
		$query->insert("#__user_usergroup_map");
		$query->set("user_id='".$user_id."'");
		$query->set("group_id='10'"); //Unico

		$this->_db->setQuery((string) $query);
		$this->_db->execute();

		//add extra field
		$query = $this->_db->getQuery(true);
		$query->insert("#__eb_registrants");
		$query->set("id='".$user_id."'");
		$query->set("email='".$_REQUEST['email']."'");
		$query->set("zip='".$_REQUEST['codicefiscale']."'");

		$this->_db->setQuery((string) $query);
		$this->_db->execute();

		//login
		$credentials = array();
		$credentials['username'] =$_REQUEST['username'];
		$credentials['password'] =$_REQUEST['password'];

		$options = array();
		$this->_japp->login($credentials, $options);


//		$this->_japp->close();

	}

}

