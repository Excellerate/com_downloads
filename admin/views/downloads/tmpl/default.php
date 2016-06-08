<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));

?>

<form action="<?= JRoute::_('index.php?option=com_downloads&view=downloads'); ?>" method="post" name="adminForm" id="adminForm">
  <div id="j-main-container" class="span12">

    <?php
      echo JLayoutHelper::render(
        'joomla.searchtools.default',
        array('view' => $this)
      );
    ?>

    <?php if (empty($this->items)) : ?>
      <div class="alert alert-no-items">
        <?= JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
      </div>
    <?php else : ?>

    <table class="table table-striped" id="articleList">
      <thead>
        <th width="1%" class="nowrap center hidden-phone">#</td>
        <th width="1%" class="nowrap center hidden-phone"><?= JHtml::_('grid.checkall'); ?></td>
        <th width="" class="nowrap hidden-phone"><?= JHtml::_('grid.sort', 'File Name', 'file', $listDirn, $listOrder); ?></td>
        <th width="20%" class="nowrap hidden-phone"><?= JHtml::_('grid.sort', 'Download by', 'name', $listDirn, $listOrder); ?></td>
        <th width="20%" class="nowrap hidden-phone"><?= JHtml::_('grid.sort', 'Email', 'email', $listDirn, $listOrder); ?></td>
        <th width="5%" class="nowrap hidden-phone"><?= JHtml::_('grid.sort', 'Count', 'count', $listDirn, $listOrder); ?></td>
        <th width="5%" class="nowrap hidden-phone"><?= JHtml::_('grid.sort', 'Date', 'updated_at', $listDirn, $listOrder); ?></td>
      </thead>
      <tfoot>
        <tr>
          <td colspan=7>
            <?= $this->pagination->getListFooter(); ?>
          </td>
        </tr>
      </tfoot>
      <tbody>
        <?php foreach($this->items as $i => $item) : ?>
        <tr>
          <td><?= $item->id; ?></td>
          <td><?= JHtml::_('grid.id', $i, $item->id); ?></td>
          <td><?= $item->file; ?></td>
          <td><?= $item->name; ?></td>
          <td><?= $item->email; ?></td>
          <td><?= $item->count; ?></td>
          <td><?= $item->updated_at_formated; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <?php endif; ?>

  <input type="hidden" name="task" value="" />
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="filter_order" value="<?= $listOrder; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?= $listDirn; ?>" />
  <?= JHtml::_('form.token'); ?>

</form>