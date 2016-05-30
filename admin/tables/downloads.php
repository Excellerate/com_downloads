<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 */
// No direct access
defined('_JEXEC') or die('Restricted access');
 
/**
 * Hello Table class
 *
 * @since  0.0.1
 */
class DownloadsTableDownloads extends JTable
{
  /**
   * Constructor
   *
   * @param   JDatabaseDriver  &$db  A database connector object
   */
  function __construct(&$db)
  {
    parent::__construct('#__downloads', 'id', $db);
  }
}
