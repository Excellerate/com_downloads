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
 * HelloWorlds View
 *
 * @since  0.0.1
 */
class DownloadsViewDownloads extends JViewLegacy
{
  /**
   * An array of items
   *
   * @var  array
   */
  protected $items;

  /**
   * The pagination object
   *
   * @var  JPagination
   */
  protected $pagination;

  /**
   * The model state
   *
   * @var  object
   */
  protected $state;
 
  /**
   * Display the Hello World view
   *
   * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
   *
   * @return  void
   */
  public function display($tpl = null)
  {
    // Get application
    $app = JFactory::getApplication();
    $context = "downloads.list.admin.downloads";
    // Get data from the model
    $this->items            = $this->get('Items');
    $this->pagination       = $this->get('Pagination');
    $this->state            = $this->get('State');
    $this->filter_order     = $app->getUserStateFromRequest($context.'filter_order', 'filter_order', 'file', 'cmd');
    $this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', 'asc', 'cmd');
    $this->filterForm       = $this->get('FilterForm');
    $this->activeFilters    = $this->get('ActiveFilters');
 
    // Check for errors.
    if (count($errors = $this->get('Errors'))){
      JError::raiseError(500, implode('<br />', $errors));
      return false;
    }
 
    // Set the toolbar and number of found items
    $this->addToolBar();
 
    // Display the template
    parent::display($tpl);
 
    // Set the document
    $this->setDocument();
  }

  /**
   * Add the page title and toolbar.
   *
   * @return  void
   *
   * @since   1.6
   */
  protected function addToolBar()
  {
    // Set title
    $title = JText::_('COM_DOWNLOADS_MANAGER');
 
    // Add total number of downloads to title 
    if ($this->pagination->total){
      $title .= " <span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
    }

    // Set toolbar options
    JToolBarHelper::title($title, 'downloads');

    // Get and set an export toolbar option
    $bar = JToolbar::getInstance('toolbar');
    $bar->appendButton('Popup', 'download', 'JTOOLBAR_EXPORT', 'index.php?option=com_downloads&amp;view=downloads&amp;layout=export&tmpl=component', 300, 300);
    $bar->appendButton('Confirm', 'This can not be undone!', 'delete', 'Delete', 'downloads.delete', false);
  }
  /**
   * Method to set up the document properties
   *
   * @return void
   */
  protected function setDocument() 
  {
    $document = JFactory::getDocument();
    $document->setTitle(JText::_('COM_DOWNLOADS_ADMINISTRATION'));
  }
}