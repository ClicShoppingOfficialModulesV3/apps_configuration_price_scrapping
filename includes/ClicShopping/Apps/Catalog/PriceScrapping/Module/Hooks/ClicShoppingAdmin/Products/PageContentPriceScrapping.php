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

  namespace ClicShopping\Apps\Catalog\PriceScrapping\Module\Hooks\ClicShoppingAdmin\Products;

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  use ClicShopping\Apps\Catalog\PriceScrapping\PriceScrapping as PriceScrappingApp;

  class PageContentPriceScrapping implements \ClicShopping\OM\Modules\HooksInterface
  {
    protected $app;

    public function __construct()
    {
      if (!Registry::exists('PriceScrapping')) {
        Registry::set('PriceScrapping', new PriceScrappingApp());
      }

      $this->app = Registry::get('PriceScrapping');
    }

    public function display()
    {
      $CLICSHOPPING_Template = Registry::get('TemplateAdmin');

      if (!defined('CLICSHOPPING_APP_CONFIGURATION_PRICE_SCRAPPING_PS_STATUS') || CLICSHOPPING_APP_CONFIGURATION_PRICE_SCRAPPING_PS_STATUS == 'False') {
        return false;
      }

      $this->app->loadDefinitions('Module/Hooks/ClicShoppingAdmin/page_content_price_scrapping');

      $QPrice = $this->app->db->prepare('select distinct * 
                                         from :table_price_scrapping
                                         where status = 1
                                         ');
      $QPrice->execute();

      $count = $QPrice->rowCount();

      if ($count >= 1) {
        $content = '<!-- Price scrapping start -->';
        $content .= '<a href="#" data-toggle="modal" data-refresh="true" data-target="#myModalPriceScrapping">' . HTML::image($CLICSHOPPING_Template->getImageDirectory() . 'icons/price_scrapping.png', $this->app->getDef('text_price_scrapping')) . '</a>';
        $content .= HTML::form('PriceScrapping', CLICSHOPPING::link(null, 'A&Catalog\PriceScrapping&AnalysePrice'));
        $content .= HTML::hiddenField('products_id', $_GET['pID']);
        $content .= HTML::hiddenField('cPath', $_GET['cPath']);

        $content .= '<div class="modal fade" id="myModalPriceScrapping" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
        $content .= '<div class="modal-dialog" role="document">';
        $content .= '<div class="modal-content">';
        $content .= '<div class="modal-header">';
        $content .= '<h5 class="modal-title" id="exampleModalLabel">' . $this->app->getDef('text_title') . '</h5>';
        $content .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
        $content .= '<span aria-hidden="true">&times;</span>';
        $content .= '</button>';
        $content .= '</div>';
        $content .= '<div class="modal-body">';
        $content .= $this->app->getDef('text_information');
        $content .= '<div class="separator"></div>';

        $content .= '<div><h6>' . $this->app->getDef('text_web_search_criteria') . '</h6></div>';
        $content .= '<div class="row">';
        $content .= '<div class="col-md-12 ml-auto">' . HTML::inputField('price_scrapping_web_search', null, 'required aria-required="true" placeholder="' . $this->app->getDef('text_web_search_keywords') . '"') . '</div>';
        $content .= '</div>';
        $content .= '<div class="separator"></div>';

        $content .= '<div><h6>' . $this->app->getDef('text_select_website') . '</h6></div>';

        while ($QPrice->fetch()) {
          $content .= '<div class="row">';
          $content .= '<div class="col-md-1">';
          $content .= '<ul class="list-group-slider list-group-flush">';
          $content .= '<li class="list-group-item-slider">';
          $content .= '<label class="switch">';
          $content .=  HTML::checkboxField('analyse[' . $QPrice->value('id') . ']',  'yes', false, 'class="success"');
          $content .= '<span class="slider"></span>';
          $content .= '</label>';
          $content .= '</li>';
          $content .= '</ul>';
          $content .= '</div>';
          $content .= '<div class="col-md-11 ml-auto">' . $QPrice->value('website_title') . '</div>';
          $content .= '</div>';
        }

        $content .= '<div class="separator"></div>';
        $content .= '<div class="modal-footer">';
        $content .= HTML::button($this->app->getDef('button_analyse'), null, null, 'info', ['newwindow' => 'blank'], 'sm');
        $content .= '</div>';

        $content .= '</div>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= '</form>';
        $content .= '<!-- Price scrapping end -->';



        $output = <<<EOD
<!-- ######################## -->
<!--  Start PriceScrappingApp     -->
<!-- ######################## -->
<script>
$('#tab3ContentRow2').append(
    '{$content}'
);
</script>
<!-- ######################## -->
<!--  End PriceScrappingApp      -->
<!-- ######################## -->

EOD;
        return $output;
      }
    }
  }
