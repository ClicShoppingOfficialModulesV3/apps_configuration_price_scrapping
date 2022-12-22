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

  use ClicShopping\Apps\Catalog\PriceScrapping\Classes\ClicShoppingAdmin\PriceScrappingDimDom;

  $CLICSHOPPING_PriceScrapping = Registry::get('PriceScrapping');
  $CLICSHOPPING_Page = Registry::get('Site')->getPage();
  $CLICSHOPPING_MessageStack = Registry::get('MessageStack');

  $CLICSHOPPING_PriceScrappingDimDom = new PriceScrappingDimDom();

  $product_id = HTML::sanitize($_POST['products_id']);
  $cPath = HTML::sanitize($_POST['cPath']);
  $search_keywords = $_POST['price_scrapping_web_search'];

  $price_scrapping_content_search = $_POST['price_scrapping_content_search'];

  if (!empty($_POST['analyse'])) {
    $i = 0;

    foreach ($_POST['analyse'] as $key => $selected) {
      $Qanalyse = $CLICSHOPPING_PriceScrapping->db->prepare('select distinct * 
                                                            from :table_price_scrapping 
                                                            where id = :id
                                                            and status = 1      
                                                           ');
      $Qanalyse->bindInt(':id', $key);
      $Qanalyse->execute();

      $website_title[] = $Qanalyse->value('website_title');
      $website_url[] = $Qanalyse->value('website_url');
      $css_content[] = $Qanalyse->value('css_content');
      $css_title[] = $Qanalyse->value('css_title');
      $css_price[] = $Qanalyse->value('css_price');

      $i++;
    }
  }

  $search_keywords = str_replace(' ', '+', $search_keywords);
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
            class="col-md-7 pageHeading"><?php echo '&nbsp;' . $CLICSHOPPING_PriceScrapping->getDef('heading_title'); ?></span>
          <span class="col-md-4 text-end">
          <button class="print-link btn  btn-info"
                  onclick="jQuery('#PrintDocument').print()"><?php echo $CLICSHOPPING_PriceScrapping->getDef('button_print'); ?></button>
<?php
    echo HTML::button($CLICSHOPPING_PriceScrapping->getDef('button_cancel'), null, CLICSHOPPING::link(null, 'A&Catalog\Products&Edit&cPath=' . $cPath . '&pID=' . $product_id), 'warning');
?>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="separator"></div>
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-4 text-center">
        <?php
          echo HTML::inputField('analyse', null, 'id="search" placeholder="' . $CLICSHOPPING_PriceScrapping->getDef('text_specific_search_keywords') . '"');
         ?>
      </div>
    </div>
  </div>

  <div id="PrintDocument">
    <?php
      if ($CLICSHOPPING_MessageStack->exists('scrapping')) {
        echo $CLICSHOPPING_MessageStack->get('scrapping');
      }

      $n = 0;

      if (is_array($website_title)) {
        foreach ($website_title as $value) {
          $search_tag = (strpos($website_url[$n], '{search_tag}'));

          if ($search_tag !== false) {
            $url = str_replace('{search_tag}', $search_keywords, $website_url[$n]);
          } else {
            $url = $website_url[$n] . $search_keywords;
          }

          $parameters_content = $css_content[$n];
          $parameters_title = $css_title[$n];
          $parameters_price = $css_price[$n];

          $result = $CLICSHOPPING_PriceScrappingDimDom->getProductListingPrice($url, $parameters_content, $parameters_title, $parameters_price);

        if (!is_null($result) || !empty($result)) {
          if ($result !== false) {
            ?>
            <div class="separator"></div>
            <table class="table table-sm table-hover table-striped">
            <thead>
            <tr class="dataTableHeadingRow">
              <td><?php echo $CLICSHOPPING_PriceScrapping->getDef('heading_title'); ?></td>
              <td class="text-end"><?php echo $CLICSHOPPING_PriceScrapping->getDef('heading_price'); ?></td>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td colspan="2"><span class="alert-success"
                                    role="alert"><?php echo HTML::link($url, $url, 'target="_blank" rel="noreferrer"'); ?></span>
              </td>
            </tr>
            <?php
            echo '<div class="alert alert-info" role="alert">' . $value . '</div>';

            foreach ($result as $item) {
              $price = $item['1'];
              if (!empty($text_search)) {
                if (strstr($item['0'], $text_search)) {
                  echo '<tr>';
                  echo '<td>' . $item['0'] . '</td>';
                  echo '<td class="text-end">' . $item['1'] . '</td>';
                  echo '</tr>';
                }
              } else {
                echo '<tr>';
                echo '<td>' . $item['0'] . '</td>';
                echo '<td class="text-end">' . $item['1'] . '</td>';
                echo '</tr>';
              }
            }
          } else {
            echo '<div class="alert alert-warning" role="alert">' . $CLICSHOPPING_PriceScrapping->getDef('text_error_url_link', ['text_error_url' => $url]) . '</div>';
          }
          ?>
          </tbody>
          </table>
          <?php
        } else {
          ?>
          <div class="separator"></div>
          <div class="alert alert-info"
               role="alert"><?php echo $CLICSHOPPING_PriceScrapping->getDef('text_no_result_identified', ['text_error_url' => $url]); ?></div>
          <?php
        }

        $n++;
      }
    }
    ?>
  </div>
</div>
<script>
    $("#search").keyup(function () {
        var value = this.value.toLowerCase().trim();

        $("table tr").each(function (index) {
            if (!index) return;
            $(this).find("td").each(function () {
                var id = $(this).text().toLowerCase().trim();
                var not_found = (id.indexOf(value) == -1);
                $(this).closest('tr').toggle(!not_found);
                return not_found;
            });
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.5.1/jQuery.print.min.js"></script>
