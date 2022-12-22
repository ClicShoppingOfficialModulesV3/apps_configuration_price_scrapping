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

  namespace ClicShopping\Apps\Catalog\PriceScrapping\Sites\ClicShoppingAdmin\Pages\Home\Actions;

  use ClicShopping\OM\Registry;

  class AnalysePrice extends \ClicShopping\OM\PagesActionsAbstract
  {
    public function execute()
    {
      $CLICSHOPPING_PriceScrapping = Registry::get('PriceScrapping');

      $this->page->setFile('analyse_price.php');
      $this->page->data['action'] = 'AnalysePrice';

      $CLICSHOPPING_PriceScrapping->loadDefinitions('Sites/ClicShoppingAdmin/analyse_price');
    }
  }