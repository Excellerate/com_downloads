<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Downloads Model
 *
 * @since  0.0.1
 */
class DownloadsModelDownloads extends JModelList
{
  /**
   * Constructor.
   *
   * @param   array  $config  An optional associative array of configuration settings.
   *
   * @see     JController
   * @since   1.6
   */
  public function __construct($config = array())
  {
    if (empty($config['filter_fields']))
    {
      $config['filter_fields'] = array(
        'file',
        'name',
        'email',
        'count',
        'updated_at'
      );
    }
 
    parent::__construct($config);
  }
 
  /**
   * Method to build an SQL query to load the list data.
   *
   * @return      string  An SQL query
   */
  public function getListQuery()
  {
    $this->state = $this->getState();

    // Initialize variables.
    $db    = JFactory::getDbo();
    $query = $db->getQuery(true);
 
    // Create the base select statement.
    $query->select('*, DATE_FORMAT(FROM_UNIXTIME(`updated_at`), \'%e %b %Y\') AS `updated_at_formated`')->from($db->quoteName('#__downloads'));
 
    // Filter: like / search @todo
    $search = $this->getState('filter.search');
    if ( ! empty($search)){
      $like = $db->quote('%' . $search . '%');
      $query->where('file LIKE ' . $like);
    }
 
    // Add the list ordering clause.
    $orderCol = $this->state->get('list.ordering', 'file');
    $orderDirn  = $this->state->get('list.direction', 'asc');
    
    $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
 
    return $query;
  }

  public function getExport()
  {
    // Initialize variables.
    $db    = JFactory::getDbo();
    $query = $db->getQuery(true);
 
    // Create the base select statement.
    $query->select('`file`,`name`,`email`,`count`,DATE_FORMAT(FROM_UNIXTIME(`updated_at`), \'%e %b %Y\') AS `updated_at_formated`')->from($db->quoteName('#__downloads'));
    $db->setQuery($query);
    $results = $db->loadObjectList();
    
    // Done
    return $results;
  }

  public function delete()
  {
    // Gather posted CIDS to delete
    $app = JFactory::getApplication();
    $cids = $app->input->get('cid');

    // Fire up database
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
     
    // Delete all selected files
    $conditions = array(
        $db->quoteName('id') . ' IN ('.implode(',',$cids).')', 
    );
     
    $query->delete($db->quoteName('#__downloads'));
    $query->where($conditions);
     
    $db->setQuery($query);
     
    $result = $db->execute();
  }
}