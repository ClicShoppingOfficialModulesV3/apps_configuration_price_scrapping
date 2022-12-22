<?php
  /**
   *
   * @copyright 2008 - https://www.clicshopping.org
   * @Brand : ClicShopping(Tm) at Inpi all right Reserved
   * @Licence GPL 2 & MIT
   * @licence MIT - Portion of osCommerce 2.4
   * @Info : https://www.clicshopping.org/forum/trademark/
   *
   */

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;

  $CLICSHOPPING_MessageStack = Registry::get('MessageStack');
  $CLICSHOPPING_PriceScrapping = Registry::get('PriceScrapping');
  $CLICSHOPPING_Page = Registry::get('Site')->getPage();
  $CLICSHOPPING_Composer = Registry::get('Composer');

  $current_module = $CLICSHOPPING_Page->data['current_module'];

  $CLICSHOPPING_PriceScrapping_Config = Registry::get('PriceScrappingAdminConfig' . $current_module);

  if ($CLICSHOPPING_MessageStack->exists('PriceScrapping')) {
    echo $CLICSHOPPING_MessageStack->get('PriceScrapping');
  }
?>

<div class="contentBody">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-block headerCard">
        <div class="row">
          <span
            class="col-md-1 logoHeading"><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'categories/price_scrapping.png', $CLICSHOPPING_PriceScrapping->getDef('heading_title'), '40', '40'); ?></span>
          <span
            class="col-md-4 pageHeading"><?php echo '&nbsp;' . $CLICSHOPPING_PriceScrapping->getDef('heading_title'); ?></span>
          <span class="col-md-7 text-end">
            <?php echo HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_price_scrapping'), null, $CLICSHOPPING_PriceScrapping->link('PriceScrapping'), 'success'); ?>
            <?php echo HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_back'), null, $CLICSHOPPING_PriceScrapping->link(null, 'A&Catalog\PriceScrapping'), 'primary'); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="separator"></div>
  <ul class="nav nav-tabs flex-column flex-sm-row" role="tablist" id="appPriceScrappingToolbar">
    <li class="nav-item">
     <?php
        foreach ($CLICSHOPPING_PriceScrapping->getConfigModules() as $m) {
          if ($CLICSHOPPING_PriceScrapping->getConfigModuleInfo($m, 'is_installed') === true) {
            echo '<li class="nav-link active" data-module="' . $m . '"><a href="' . $CLICSHOPPING_PriceScrapping->link('Configure&module=' . $m) . '">' . $CLICSHOPPING_PriceScrapping->getConfigModuleInfo($m, 'short_title') . '</a></li>';
          }
        }
      ?>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
         aria-expanded="false">Install</a>
      <div class="dropdown-menu">
        <?php
          foreach ($CLICSHOPPING_PriceScrapping->getConfigModules() as $m) {
            if ($CLICSHOPPING_PriceScrapping->getConfigModuleInfo($m, 'is_installed') === false) {
              echo '<a class="dropdown-item" href="' . $CLICSHOPPING_PriceScrapping->link('Configure&module=' . $m) . '">' . $CLICSHOPPING_PriceScrapping->getConfigModuleInfo($m, 'title') . '</a>';
            }
          }
        ?>
      </div>
    </li>
  </ul>
  <?php

    if ($CLICSHOPPING_Composer->checkComposerInstalled() === false) {
      echo '<div class="alert alert-warning" role="alert">' . $CLICSHOPPING_PriceScrapping->getDef('text_error_composer') . '</div>';
    }

    if ($CLICSHOPPING_Composer->checkExecEnabled() === false) {
      echo '<div class="alert alert-warning" role="alert">' . $CLICSHOPPING_PriceScrapping->getDef('text_error_exec') . '</div>';
    }


    if ($CLICSHOPPING_PriceScrapping_Config->is_installed === true) {
      ?>
      <form name="CatalogPriceScrappingConfigure"
            action="<?php echo $CLICSHOPPING_PriceScrapping->link('Configure&Process&module=' . $current_module); ?>"
            method="post">

        <div class="mainTitle">
          <?php echo $CLICSHOPPING_PriceScrapping->getConfigModuleInfo($current_module, 'title'); ?>
        </div>
        <div class="adminformTitle">
          <div class="card-block">

            <p class="card-text">
              <?php
                foreach ($CLICSHOPPING_PriceScrapping_Config->getInputParameters() as $cfg) {
                  echo '<div>' . $cfg . '</div>';
                  echo '<div class="separator"></div>';
                }
              ?>
            </p>
          </div>
        </div>

        <div class="separator"></div>
        <div class="col-md-12">
          <?php
            echo HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_save'), null, null, 'success');

            if ($CLICSHOPPING_PriceScrapping->getConfigModuleInfo($current_module, 'is_uninstallable') === true) {
              echo '<span class="float-end">' . HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_dialog_uninstall'), null, '#', 'warning', ['params' => 'data-toggle="modal" data-target="#ppUninstallModal"']) . '</span>';
            }
          ?>
        </div>
      </form>
      <?php
      if ($CLICSHOPPING_PriceScrapping->getConfigModuleInfo($current_module, 'is_uninstallable') === true) {
        ?>
        <div id="ppUninstallModal" class="modal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4
                  class="modal-title"><?php echo $CLICSHOPPING_PriceScrapping->getDef('dialog_uninstall_title'); ?></h4>
              </div>
              <div class="modal-body">
                <?php echo $CLICSHOPPING_PriceScrapping->getDef('dialog_uninstall_body'); ?>
              </div>
              <div class="modal-footer">
                <?php echo HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_delete'), null, $CLICSHOPPING_PriceScrapping->link('Configure&Delete&module=' . $current_module), 'danger'); ?>
                <?php echo HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_uninstall'), null, $CLICSHOPPING_PriceScrapping->link('Configure&Uninstall&module=' . $current_module), 'danger'); ?>
                <?php echo HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_cancel'), null, '#', 'warning', ['params' => 'data-dismiss="modal"']); ?>
              </div>
            </div>
          </div>
        </div>
        <?php
      }
    } else {
      ?>
      <div class="col-md-12 mainTitle">
        <strong><?php echo $CLICSHOPPING_PriceScrapping->getConfigModuleInfo($current_module, 'title'); ?></strong>
      </div>
      <div class="adminformTitle">
        <div class="row">
          <div class="separator"></div>
          <div class="col-md-12">
            <div><?php echo $CLICSHOPPING_PriceScrapping->getConfigModuleInfo($current_module, 'introduction'); ?></div>
            <div class="separator"></div>
            <div><?php echo HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_install_title', ['title' => $CLICSHOPPING_PriceScrapping->getConfigModuleInfo($current_module, 'title')]), null, $CLICSHOPPING_PriceScrapping->link('Configure&Install&module=' . $current_module), 'warning'); ?></div>
          </div>
        </div>
      </div>
      <?php
    }
  ?>
</div>