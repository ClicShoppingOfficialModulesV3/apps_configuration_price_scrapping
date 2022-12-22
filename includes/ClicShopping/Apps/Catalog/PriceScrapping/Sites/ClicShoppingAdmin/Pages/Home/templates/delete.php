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
  use ClicShopping\OM\ObjectInfo;

  $CLICSHOPPING_PriceScrapping = Registry::get('PriceScrapping');
  $CLICSHOPPING_Page = Registry::get('Site')->getPage();

  $oID = HTML::sanitize($_GET['oID']);
  $remove_status = true;

  $QordersStatusTracking = $CLICSHOPPING_PriceScrapping->db->prepare('select *
                                                                      from :table_price_scrapping
                                                                      where id = :id
                                                                      ');
  $QordersStatusTracking->bindInt(':id', (int)$_GET['oID']);

  $QordersStatusTracking->execute();

  $oInfo = new ObjectInfo($QordersStatusTracking->toArray());

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
            class="col-md-2 pageHeading"><?php echo '&nbsp;' . $CLICSHOPPING_PriceScrapping->getDef('heading_title'); ?></span>
        </div>
      </div>
    </div>
  </div>
  <div class="separator"></div>
  <div class="col-md-12 mainTitle">
    <strong><?php echo $CLICSHOPPING_PriceScrapping->getDef('text_info_delete_info'); ?></strong></div>
  <?php echo HTML::form('price_scrapping', $CLICSHOPPING_PriceScrapping->link('PriceScrapping&DeleteConfirm&page=' . $page . '&oID=' . $oInfo->id)); ?>
  <div class="adminformTitle">
    <div class="row">
      <div class="separator"></div>
      <div class="col-md-12"><?php echo $CLICSHOPPING_PriceScrapping->getDef('text_info_delete_info'); ?><br/><br/>
      </div>
      <div class="separator"></div>
      <div class="col-md-12"><?php echo '<strong>' . $oInfo->website_title . '</strong>'; ?><br/><br/></div>
      <div class="col-md-12 text-center">
        <?php
          if ($remove_status) {
            ?>
            <span><br/><?php echo HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_delete'), null, null, 'danger', null, 'sm') . ' </span><span>' . HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_cancel'), null, $CLICSHOPPING_PriceScrapping->link('PriceScrapping&page=' . (int)$_GET['page']), 'warning', null, 'sm'); ?></span>
            <?php
          } else {
            ?>
            <span><br/><?php echo HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_cancel'), null, $CLICSHOPPING_PriceScrapping->link('PriceScrapping&page=' . $page . '&oID=' . $oInfo->price_scrapping_id), 'warning', null, 'sm'); ?></span>
            <?php
          }
        ?>
      </div>
    </div>
  </div>
  </form>
</div>