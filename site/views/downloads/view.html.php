<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * HTML View class for the HelloWorld Component
 *
 * @since  0.0.1
 */
class DownloadsViewDownloads extends JViewLegacy
{
  /**
   * Display the Hello World view
   *
   * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
   *
   * @return  void
   */
  function display($tpl = null)
  {
    // Uses to check for previous passed capture
    $session = JFactory::getSession();

    // Get app, model and document
    $app = JFactory::getApplication();
    $model = $this->getModel();
    $doc = JFactory::getDocument();

    // Include required js and css files
    JHtml::_('jquery.framework');
    $doc->addScript('components/com_downloads/assets/js/actions.js');
    $doc->addScript('https://www.google.com/recaptcha/api.js');
    $doc->addStyleSheet('components/com_downloads/assets/css/download.css');
    
    // Gather componant params
    $params = $app->getParams('com_downloads');

    // Get menu input params
    $baseFolder = $app->input->get('folder');
    $fileTypes = $app->input->get('types', array('.pdf', '.docx', '.xlsx', '.pptx', '.doc', '.xls', '.ppt'));
    $useRecapture = $app->input->get('no_robots', '1') == 1 ? true : false;
    $downloadFile = $app->input->get('filename');

    // Gather file list
    $list = $model->getFolder($baseFolder, $fileTypes);

    // Check for a download request
    if($downloadFile){

      // Check that the file was part of the origional list
      if(array_key_exists(md5($downloadFile), $list)){

        // Validate data
        if(filter_var(JRequest::getVar('email'), FILTER_VALIDATE_EMAIL) === false){
          throw new Exception('Required data invalid', 403);
        }

        // Check with reCAPTURE
        if($useRecapture){

          // Check for previous passed capture or validate capture
          if( ! $session->get('capture')){
            if( ! $this->verify($params->get('recapture_secret'), JRequest::getVar('g-recaptcha-response'))){
              JError::raiseWarning( 403, 'Robot check has failed!' );
              return false;
            }
          }

          // Capture done
          $session->set('capture', true);
        }

        // Count file download and store details
        $model->recordDownload(JRequest::getVar('name'), JRequest::getVar('email'), JRequest::getVar('filename'));

        // Download the file
        $this->download($baseFolder, $downloadFile);

        // Done
        return true;
      }
    }

    // Kill any prev session if recapture is switched off
    if($useRecapture == false){
      $session->set('capture', false);
    }

    // Check for previous passed capture or validate capture
    if($useRecapture and $session->get('capture')){
      $useRecapture = false;
    }

    // Load jquery and semantic-ui
    if($params->get('add_extension_resources', true)){
      //$doc->addScript('media/com_fancy/js/fancy-script.js');
    }

    // Assign data to the view
    $this->title = $params->get('show_page_heading') ? $this->document->title : false;
    $this->files = $model->getFolder($baseFolder, $fileTypes);
    $this->before = $app->input->get('before', false, 'raw');
    $this->after = $app->input->get('after', false, 'raw');
    $this->recapture_key = $params->get('recapture_key');
    $this->use_recapture = $useRecapture;
    $this->capture_passed = $session->get('capture') ? true : false;
 
    // Display the view
    parent::display($tpl);
  }

  /**
   * Verify users response with reCAPTURE
   *
   * @param String Google secret
   * @param String Google response
   */
  private function verify($secret, $response)
  {
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
      'secret' => $secret,
      'response' => $response 
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { return true; }

    // Decode JSON response
    if($r = json_decode($result) and $r->success == true){
      return true;
    }

    // Nope
    return false;
  }

  private function download($folder, $filename)
  {
    header("Location: ".JUri::base()."images/".$folder."/".$filename);
    die();
  }
}