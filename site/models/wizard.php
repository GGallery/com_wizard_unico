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
class wizardModelwizard extends JModelLegacy {

	private $_japp;
	protected $_db;
	public $_session;
	public $_userid;
//	public $_parametri;

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

		if($_REQUEST['id_farmacia'])
			$this->_session->set( 'id_farmacia',  $_REQUEST['id_farmacia'] );


//		var_dump($this->_session);

	}

	public function __destruct() {

	}

	public function getFarmacia() {

		if(!$this->_session->get('id_farmacia', null))
			return array();


		$query = $this->_db->getQuery(true);
		try {
			$query->select('*');
			$query->from('#__clienti_unico');
			$query->where('id = '. $this->_session->get('id_farmacia'));
			$this->_db->setQuery((string) $query, 0);
			$res = $this->_db->loadAssoc();
		} catch (Exception $e) {
			var_dump($e);
		}


		return $res;
	}



	////////////////////////////////
}

