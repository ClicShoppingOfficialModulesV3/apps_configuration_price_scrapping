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

  class DeleteConfirm extends \ClicShopping\OM\PagesActionsAbstract
  {
    protected $app;

    public function __construct()
    {
      $this->app = Registry::get('PriceScrapping');
    }

    public function execute()
    {
      if (isset($_GET['oID'])) {
        $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int)$_GET['page'] : 1;

        $oID = HTML::sanitize($_GET['oID']);

        $this->app->db->delete('price_scrapping', ['id' => (int)$oID]);

        $this->app->redirect('PriceScrapping&page=' . $page);
      }
    }
  }