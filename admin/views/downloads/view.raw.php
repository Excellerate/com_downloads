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
 * View class for a list of tracks.
 *
 * @since  1.6
 */
class DownloadsViewDownloads extends JViewLegacy
{
  /**
   * Display the view
   *
   * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
   *
   * @return  void
   */
  public function display($tpl = null)
  {
    // Pull items
    $items = $this->get('Export');

    // Format into CSV
    $content = $this->arrayToCsv($items);

    // Download
    $document = JFactory::getDocument();
    $document->setMimeEncoding('text/csv');
    JFactory::getApplication()
      ->setHeader(
        'Content-disposition',
        'attachment; filename="downloads.csv"; creation-date="' . JFactory::getDate()->toRFC822() . '"',
        true
      );
    print $content;
  }

  /**
   * Adapted from http://stackoverflow.com/questions/3933668/convert-array-into-csv
   */
  private function arrayToCsv( array &$data, $delimiter = ',', $enclosure = '"', $encloseAll = true)
  {
    $delimiter_esc = preg_quote($delimiter, '/');
    $enclosure_esc = preg_quote($enclosure, '/');

    $output = array();
    
    foreach($data as $r => $fields){
      foreach ( $fields as $field ) {
          
        // Enclose fields containing $delimiter, $enclosure or whitespace
        if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
            $row[$r][] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
        }
        else {
            $row[$r][] = $field;
        }
      }
      $output[] = implode($delimiter, $row[$r]);
    }

    return implode(PHP_EOL, $output);
  }
}
