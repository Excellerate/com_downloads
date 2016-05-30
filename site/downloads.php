<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_Downloads
 *
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// Get an instance of the controller prefixed by Downloads
$controller = JControllerLegacy::getInstance('Downloads');
 
// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();