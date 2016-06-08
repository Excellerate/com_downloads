<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_downloads
 *
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<!-- Modal Window -->
<div class="ui small download modal">
  <i class="close icon"></i>
  <div class="header">
    <i class="ui download icon"></i><span id="fileTodownloadHeading"></span>
  </div>
  <div class="image content">
    <div class="description">
      <form id="downloadRequestForm" class="ui form" action="<?=JURI::current();?>" method="post" target="_blank">
        <div class="ui two column grid">
          <div class="column">
            <div class="ui required field">
              <label>Full name:</label>
              <input name="name" type="text">
            </div>
            <div class="ui required field">
              <label>Email address:</label>
              <input name="email" type="email" >
            </div>
            <input id="filename" name="filename" type="hidden" >
          </div>
          <div class="column">
            <?php if($this->use_recapture) : ?>
            <div class="g-recaptcha" data-size="normal" data-theme="light" data-sitekey="<?= $this->recapture_key; ?>"></div>
            <?php endif; ?>
            <?php if($this->capture_passed) : ?>
                <div class="ui icon message">
                  <i class="ui check mark icon"></i>
                  <div class="content">
                    <div class="header">
                      I am not a Robot
                    </div>
                    <p>You are already validated.</p>
                  </div>
                </div>
            <?php endif; ?>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="actions">
    <div class="ui black deny button">Cancel</div>
    <div class="ui right labeled icon ok button"><i class="ui check mark icon"></i>Submit</div>
  </div>
</div>

<!-- Title -->
<?php if($this->title) : ?>
<h1><?= $this->title; ?></h1>
<?php endif; ?>

<!-- Before Text -->
<?= $this->before; ?>

<!-- List -->
<table class="ui table">
  <thead>
  <tr>
    <th>File</th>
    <th>Size</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($this->files as $file) : ?>
    <tr>
      <td><a class="download link" data-filename="<?= $file->name; ?>" href="#"><?= $file->name; ?></a></td>
      <td><?= $file->size; ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
  <tfoot>
  </tfoot>
</table>

<!-- After Text -->
<?= $this->after; ?>