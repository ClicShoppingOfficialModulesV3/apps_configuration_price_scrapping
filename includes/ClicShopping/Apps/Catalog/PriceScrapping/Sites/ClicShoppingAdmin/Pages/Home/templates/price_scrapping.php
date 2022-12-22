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
  use ClicShopping\OM\CLICSHOPPING;

  $CLICSHOPPING_Language = Registry::get('Language');
  $CLICSHOPPING_PriceScrapping = Registry::get('PriceScrapping');
  $CLICSHOPPING_Page = Registry::get('Site')->getPage();

  $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;
?>
<!-- body //-->
<div class="contentBody">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-block headerCard">
        <div class="row">
          <span
            class="col-md-1 logoHeading"><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'categories/price_scrapping.png', $CLICSHOPPING_PriceScrapping->getDef('heading_title'), '40', '40'); ?></span>
          <span
            class="col-md-4 pageHeading"><?php echo '&nbsp;' . $CLICSHOPPING_PriceScrapping->getDef('heading_title'); ?></span>
          <span
            class="col-md-7 text-end"><?php echo HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_insert'), null, $CLICSHOPPING_PriceScrapping->link('Insert'), 'success', null, 'xs'); ?></span>
        </div>
      </div>
    </div>
  </div>
  <div class="separator"></div>

  <table border="0" width="100%" cellspacing="0" cellpadding="2">
    <td>
      <table class="table table-sm table-hover table-striped">
        <thead>
        <tr class="dataTableHeadingRow">
          <th><?php echo $CLICSHOPPING_PriceScrapping->getDef('table_heading_website_title'); ?></th>
          <th><?php echo $CLICSHOPPING_PriceScrapping->getDef('table_heading_website_url'); ?></th>
          <th><?php echo $CLICSHOPPING_PriceScrapping->getDef('table_heading_status'); ?></th>
          <th class="text-end"><?php echo $CLICSHOPPING_PriceScrapping->getDef('table_heading_action'); ?>&nbsp;
          </th>
        </tr>
        </thead>
        <tbody>
        <?php

          $QPriceScrapping = $CLICSHOPPING_PriceScrapping->db->prepare('select SQL_CALC_FOUND_ROWS   *
                                                                        from :table_price_scrapping
                                                                        order by id
                                                                        limit :page_set_offset,
                                                                              :page_set_max_results
                                                                      ');
          $QPriceScrapping->setPageSet((int)MAX_DISPLAY_SEARCH_RESULTS_ADMIN);
          $QPriceScrapping->execute();

          $listingTotalRow = $QPriceScrapping->getPageSetTotalRows();

          if ($listingTotalRow > 0) {

          while ($QPriceScrapping->fetch()) {
          echo '<th scope="row"><strong>' . $QPriceScrapping->value('website_title') . '</strong></th>' . "\n";
          echo '<th scope="row">' . $QPriceScrapping->value('website_url') . '</th>' . "\n";
        ?>

        <th scope="row" class="text-center">
          <?php
            if ($QPriceScrapping->value('status') == '0') {
              echo '<a href="' . $CLICSHOPPING_PriceScrapping->link('PriceScrapping&SetFlag&page=' . $page . '&flag=1&id=' . $QPriceScrapping->valueInt('id')) . '"><i class="fas fa-check fa-lg" aria-hidden="true"></i></a>';
            } else {
              echo '<a href="' . $CLICSHOPPING_PriceScrapping->link('PriceScrapping&SetFlag&page=' . $page . '&flag=0&id=' . $QPriceScrapping->valueInt('id')) . '"><i class="fas fa-times fa-lg" aria-hidden="true"></i></a>';
            }
          ?>
        </th>
        <td class="text-end">
          <?php
            echo '<a href="' . $CLICSHOPPING_PriceScrapping->link('Delete&page=' . $page . '&oID=' . $QPriceScrapping->valueInt('id')) . '">' . HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'icons/delete.gif', $CLICSHOPPING_PriceScrapping->getDef('icon_delete')) . '</a>';
            echo '&nbsp;';
            echo '<a href="' . $CLICSHOPPING_PriceScrapping->link('Edit&page=' . $page . '&oID=' . $QPriceScrapping->valueInt('id')) . '">' . HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'icons/edit.gif', $CLICSHOPPING_PriceScrapping->getDef('icon_edit')) . '</a>';
            echo '&nbsp;';
          ?>
        </td>
        </tbody>
        </tr>
        <?php
            }
          } // end $listingTotalRow
        ?>
      </table>
    </td>
  </table>
  <?php
    if ($listingTotalRow > 0) {
      ?>
      <div class="row">
        <div class="col-md-12">
          <div
            class="col-md-6 float-start pagenumber hidden-xs TextDisplayNumberOfLink"><?php echo $QPriceScrapping->getPageSetLabel($CLICSHOPPING_PriceScrapping->getDef('text_display_number_of_link')); ?></div>
          <div
            class="float-end text-end"> <?php echo $QPriceScrapping->getPageSetLinks(CLICSHOPPING::getAllGET(array('page', 'info', 'x', 'y'))); ?></div>
        </div>
      </div>
      <?php
    }
  ?>
</div>