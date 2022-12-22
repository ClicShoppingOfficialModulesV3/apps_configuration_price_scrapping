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

  $CLICSHOPPING_PriceScrapping = Registry::get('PriceScrapping');
  $CLICSHOPPING_Language = Registry::get('Language');

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
          <span class="col-md-7 text-end">
<?php
  echo HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_cancel'), null, $CLICSHOPPING_PriceScrapping->link('PriceScrapping'), 'warning') . ' ';
  echo HTML::form('status_price_scrapping', $CLICSHOPPING_PriceScrapping->link('PriceScrapping&Insert&page=' . $page));
  echo HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_insert'), null, null, 'success') . ' ';
  echo HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_help'), null, $CLICSHOPPING_PriceScrapping->link('Help'), 'info', null);
?>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="separator"></div>

  <div class="col-md-12 mainTitle">
    <strong><?php echo $CLICSHOPPING_PriceScrapping->getDef('text_info_heading_edit_price_scrapping'); ?></strong></div>
  <div class="adminformTitle">

    <div class="row">
      <div class="col-md-12">
        <div class="form-group row">
          <label for="<?php echo $CLICSHOPPING_PriceScrapping->getDef('text_info_edit_intro'); ?>"
                 class="col-12 col-form-label"><?php echo $CLICSHOPPING_PriceScrapping->getDef('text_info_edit_intro'); ?></label>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-5">
        <div class="form-group row">
          <label for="lang"
                 class="col-5 col-form-label"><?php echo $CLICSHOPPING_PriceScrapping->getDef('text_info_price_scrapping_website_title'); ?></label>
          <div class="col-md-7">
            <?php echo HTML::inputField('price_scrapping_website_title', null, 'class="form-control" required aria-required="true"'); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-5">
        <div class="form-group row">
          <label for="lang"
                 class="col-5 col-form-label"><?php echo $CLICSHOPPING_PriceScrapping->getDef('text_info_price_scrapping_website_url'); ?></label>
          <div class="col-md-7">
            <?php echo HTML::inputField('price_scrapping_website_url', null, 'class="form-control" required aria-required="true"'); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-5">
        <div class="form-group row">
          <label for="lang"
                 class="col-5 col-form-label"><?php echo $CLICSHOPPING_PriceScrapping->getDef('text_info_price_scrapping_css_content'); ?></label>
          <div class="col-md-7">
            <?php echo HTML::inputField('price_scrapping_css_content', null, 'class="form-control" required aria-required="true"'); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-5">
        <div class="form-group row">
          <label for="lang"
                 class="col-5 col-form-label"><?php echo $CLICSHOPPING_PriceScrapping->getDef('text_info_price_scrapping_css_title'); ?></label>
          <div class="col-md-7">
            <?php echo HTML::inputField('price_scrapping_css_title', null, 'class="form-control" required aria-required="true"'); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-5">
        <div class="form-group row">
          <label for="lang"
                 class="col-5 col-form-label"><?php echo $CLICSHOPPING_PriceScrapping->getDef('text_info_price_scrapping_css_price'); ?></label>
          <div class="col-md-7">
            <?php echo HTML::inputField('price_scrapping_css_price', null, 'class="form-control" required aria-required="true"'); ?>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>