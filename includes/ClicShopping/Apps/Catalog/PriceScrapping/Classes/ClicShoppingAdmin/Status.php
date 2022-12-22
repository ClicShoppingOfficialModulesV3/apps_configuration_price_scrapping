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

  namespace ClicShopping\Apps\Catalog\PriceScrapping\Classes\ClicShoppingAdmin;

  use ClicShopping\OM\Registry;

  class Status
  {

    protected $status;
    protected $price_scrapping_id;

    /**
     * Status price_scrapping  - Sets the status of price_scrapping
     *
     * @param string $price_scrapping_id, status
     * @return string status on or off
     * @access public
     */

    public static function getPriceScrappingStatus(int $price_scrapping_id, int $status)
    {
      $CLICSHOPPING_Db = Registry::get('Db');

      if ($status == '1') {
        return $CLICSHOPPING_Db->save('price_scrapping', ['status' => 1],
          ['id' => (int)$price_scrapping_id]
        );
      } elseif ($status == '0') {
        return $CLICSHOPPING_Db->save('price_scrapping', ['status' => 0],
          ['id' => (int)$price_scrapping_id]
        );
      } else {
        return -1;
      }
    }
  }