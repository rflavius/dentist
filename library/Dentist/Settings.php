<?php
/**
 * WebDesignRR Application
 * developer: Flavius Rosu
 * email: rflavius@gmail.com
 * @copyright  Copyright (c) 2003-2015
 */

/**
 * Loading Settings from database, also set PHP settings from config file 
 * @category   Dentist
 * @package    Frontend
 */

class Dentist_Settings
{
	/**
	 * Get settings from database, table, and load into registry $settings
	 * @access public
	 * @static
	 * @return object with values from setting table
	 */
	public static function getSettings()
	{
		$settings = array();
		$db = Zend_Registry::get('database');
		$select = $db->select()
						->from('config');
		$results = $db->fetchAll($select);
		foreach ($results as $key => $val)
		{
			$settings[$val['variable']] = $val['value'];
		}
		return (object)$settings;
	}
	
	/**
	 * Set PHP configuration settings
	 * @access public
	 * @static
	 * @param  array $phpSettings
	 * @param  string $prefix Key prefix to prepend to array values (used to map . separated INI values)
	 * @return copied from Zend_Application class
	 */
	public static function setPhpSettings(array $phpSettings, $prefix = '')
	{
		foreach ($phpSettings as $key => $value)
		{
			$key = empty($prefix) ? $key : $prefix . $key;
			if (is_scalar($value)) ini_set($key, $value);
			elseif (is_array($value))  self::setPhpSettings($value, $key . '.');
		}
	}
}