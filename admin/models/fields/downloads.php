<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
JFormHelper::loadFieldClass('list');
 
/**
 * HelloWorld Form Field class for the HelloWorld component
 *
 * @since  0.0.1
 */
class JFormFieldDownloads extends JFormFieldList
{
  /**
   * The field type.
   *
   * @var         string
   */
  protected $type = 'HelloWorld';
 
  /**
   * Method to get a list of options for a list input.
   *
   * @return  array  An array of JHtml options.
   */
  protected function getOptions()
  {
    $db    = JFactory::getDBO();
    $query = $db->getQuery(true);
    $query->select('id,email');
    $query->from('#_downloads');
    $db->setQuery((string) $query);
    $messages = $db->loadObjectList();
    $options  = array();
 
    if ($messages)
    {
      foreach ($messages as $message)
      {
        $options[] = JHtml::_('select.option', $message->id, $message->email);
      }
    }
 
    $options = array_merge(parent::getOptions(), $options);
 
    return $options;
  }
}