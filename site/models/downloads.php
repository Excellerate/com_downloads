<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_Downloads
 *
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Downloads Model
 *
 * @since  0.0.1
 */
class DownloadsModelDownloads extends JModelItem
{
  /**
   * Get a list of files that can be downloaded
   *
   */
  public function getFolder($folder = false, $filter = array())
  {
    if($folder){

      // Gather and set data
      $path = 'images'.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR;
      $filter = implode('|', $filter);

      // Check the folder exists
      if(file_exists($path)){

        // Joomla doesn't autoload JFile and JFolder
        JLoader::register('JFolder', JPATH_LIBRARIES . '/joomla/filesystem/folder.php');

        // Pull the files
        $files = JFolder::files($path, $filter);

        // Loop in extra info
        $newFiles = [];
        foreach($files as $file){

          // Set full path of file
          $src = $path . $file;

          // Get file size
          $size = filesize($src);

          // Build new array object
          $newFiles[md5($file)] = (object) ['name' => $file, 'size' => $this->formatBytes($size)];
        }

        // Done
        return $newFiles;
      }
    }

    // Oops
    throw new Exception("Folder not set or missing", 404);
  }

  /**
   * Count a files download
   */
  public function recordDownload($name, $email, $file)
  {
    // Fire up database
    $db = JFactory::getDbo();
    $query = $check = $db->getQuery(true);

    // Normalise
    $email = strtolower($email);

    // Check for already created entry
    $check->select(array('D.*'));
    $check->from('`#__downloads` D');
    $check->where('`name`="'.$name.'"');
    $check->where('`email`="'.$email.'"');
    $check->where('`file`="'.$file.'"');
    $db->setQuery($check);
    $results = $db->loadObject();

    // Check results
    if( ! $results ){

      // Create an object for the record we are going to insert.
      $object = new stdClass();
      $object->name = $name;
      $object->email = $email;
      $object->file = $file;
      $object->count = 1;
      $object->created_at = $object->updated_at = time();
      $result = JFactory::getDbo()->insertObject('#__downloads', $object);
    }

    else{
      
      // Create an object for the record we are going to update.
      $object = new stdClass();
      $object->id = $results->id;
      $object->count = $results->count + 1;
      $object->updated_at = time();
      $result = JFactory::getDbo()->updateObject('#__downloads', $object, 'id');
    }
  }

  /**
   * Get friendly file size
   *
   * http://php.net/manual/en/function.filesize.phpuser contributed example
   */
  private function formatBytes($bytes, $decimals = 2) { 
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
  }
}