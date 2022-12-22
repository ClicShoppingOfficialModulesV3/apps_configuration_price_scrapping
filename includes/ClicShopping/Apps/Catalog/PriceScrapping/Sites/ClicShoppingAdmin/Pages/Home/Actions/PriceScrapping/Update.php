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

  namespace ClicShopping\Apps\Catalog\PriceScrapping\Sites\ClicShoppingAdmin\Pages\Home\Actions\PriceScrapping;

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;

  class Update extends \ClicShopping\OM\PagesActionsAbstract
  {
    protected $app;

    public function __construct()
    {
      $this->app = Registry::get('PriceScrapping');
    }

    public function execute()
    {

      if (isset($_GET['oID'])) $price_scrapping_id = HTML::sanitize($_GET['oID']);

      $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;

      $website_title = HTML::sanitize($_POST['price_scrapping_website_title']);
      $website_url = HTML::sanitize($_POST['price_scrapping_website_url']);
      $css_content = HTML::sanitize($_POST['price_scrapping_css_content']);
      $css_title = HTML::sanitize($_POST['price_scrapping_css_title']);
      $css_price = HTML::sanitize($_POST['price_scrapping_css_price']);

      $sql_data_array = ['website_title' => $website_title,
        'website_url' => $website_url,
        'css_content' => $css_content,
        'css_title' => $css_title,
        'css_price' => $css_price
      ];

      $this->app->db->save('price_scrapping', $sql_data_array, ['id' => (int)$price_scrapping_id]);

      $this->app->redirect('PriceScrapping&page=' . $page . '&oID=' . $price_scrapping_id);
    }
  }