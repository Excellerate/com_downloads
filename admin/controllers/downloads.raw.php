<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Tracks list controller class.
 *
 * @since  1.6
 */
class DownloadsControllerDownloads extends JControllerLegacy
{
  /**
   * The context for persistent state.
   *
   * @var    string
   * @since  1.6
   */
  protected $context = 'com_downloads.downloads';

  /**
   * Method to get a model object, loading it if required.
   *
   * @param   string  $name    The name of the model.
   * @param   string  $prefix  The prefix for the model class name.
   * @param   array   $config  Configuration array for model. Optional.
   *
   * @return  JModelLegacy
   *
   * @since   1.6
   */
  public function getModel($name = 'Downloads', $prefix = 'DownloadsModel', $config = array())
  {
    return parent::getModel($name, $prefix, array('ignore_request' => true));
  }

  /**
   * Display method for the raw track data.
   *
   * @param   boolean  $cachable   If true, the view output will be cached
   * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
   *
   * @return  BannersControllerTracks  This object to support chaining.
   *
   * @since   1.5
   * @todo    This should be done as a view, not here!
   */
  public function display($cachable = false, $urlparams = array())
  {
    parent::display();
  }
}
