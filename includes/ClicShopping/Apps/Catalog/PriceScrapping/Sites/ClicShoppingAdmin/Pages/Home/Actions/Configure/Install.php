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

  namespace ClicShopping\Apps\Catalog\PriceScrapping\Sites\ClicShoppingAdmin\Pages\Home\Actions\Configure;

  use ClicShopping\OM\Registry;

  use ClicShopping\OM\Cache;

  class Install extends \ClicShopping\OM\PagesActionsAbstract
  {

    public function execute()
    {

      $CLICSHOPPING_MessageStack = Registry::get('MessageStack');
      $CLICSHOPPING_PriceScrapping = Registry::get('PriceScrapping');
      $CLICSHOPPING_Composer = Registry::get('Composer');

      $current_module = $this->page->data['current_module'];

      $CLICSHOPPING_PriceScrapping->loadDefinitions('Sites/ClicShoppingAdmin/install');

      $m = Registry::get('PriceScrappingAdminConfig' . $current_module);
      $m->install();

      static::installDbMenuAdministration();
      static::installProductsPriceScrappingDb();
      $CLICSHOPPING_Composer->install('imangazaliev/didom');

      $CLICSHOPPING_MessageStack->add($CLICSHOPPING_PriceScrapping->getDef('alert_module_install_success'), 'success', 'PriceScrapping');

      $CLICSHOPPING_PriceScrapping->redirect('Configure&module=' . $current_module);
    }

    private static function installDbMenuAdministration()
    {
      $CLICSHOPPING_Db = Registry::get('Db');
      $CLICSHOPPING_PriceScrapping = Registry::get('PriceScrapping');
      $CLICSHOPPING_Language = Registry::get('Language');
      $Qcheck = $CLICSHOPPING_Db->get('administrator_menu', 'app_code', ['app_code' => 'app_catalog_price_scrapping']);

      if ($Qcheck->fetch() === false) {

        $sql_data_array = ['sort_order' => 7,
          'link' => 'index.php?A&Catalog\PriceScrapping&PriceScrapping',
          'image' => 'price_scrapping.png',
          'b2b_menu' => 0,
          'access' => 0,
          'app_code' => 'app_catalog_price_scrapping'
        ];

        $insert_sql_data = ['parent_id' => 3];

        $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

        $CLICSHOPPING_Db->save('administrator_menu', $sql_data_array);

        $id = $CLICSHOPPING_Db->lastInsertId();

        $languages = $CLICSHOPPING_Language->getLanguages();

        for ($i = 0, $n = count($languages); $i < $n; $i++) {

          $language_id = $languages[$i]['id'];

          $sql_data_array = ['label' => $CLICSHOPPING_PriceScrapping->getDef('title_menu')];

          $insert_sql_data = ['id' => (int)$id,
            'language_id' => (int)$language_id
          ];

          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

          $CLICSHOPPING_Db->save('administrator_menu_description', $sql_data_array);

        }

        Cache::clear('menu-administrator');
      }
    }


    private function installProductsPriceScrappingDb()
    {
      $CLICSHOPPING_Db = Registry::get('Db');

      $Qcheck = $CLICSHOPPING_Db->query('show tables like ":table_price_scrapping"');

      if ($Qcheck->fetch() === false) {
        $sql = <<<EOD
CREATE TABLE :table_price_scrapping (
  id int(11) NOT NULL,
  website_title varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  website_url varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  css_content varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  css_title varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  css_price varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  status tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE :table_price_scrapping  ADD PRIMARY KEY (id), ADD KEY idx_website_title (website_title);

ALTER TABLE :table_price_scrapping  MODIFY id int(11) NOT NULL AUTO_INCREMENT;
EOD;

        $CLICSHOPPING_Db->exec($sql);
      }
    }
  }
