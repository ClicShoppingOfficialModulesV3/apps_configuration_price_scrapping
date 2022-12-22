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

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTTP;

  use DiDom\Document;
  use DiDom\Query;
  use DiDom\Errors;

  class PriceScrappingDimDom
  {
    protected $error;
    protected $query;
    protected $document;
    protected $element;

    public function __construct()
    {
      $this->document = new Document();
      $this->query = new Query();
      $this->errors = new Errors();
    }

    /*
    *  Return rl content
    * @$url : $url, website url
    * @params : $argument_title : paramters about title search
    * @return : $html, result of the contentparse_str
    * private
    */
    private function getHTML(string $url)
    {

      $html = HTTP::getResponse([
        'url' => $url,
      ]);

      return $html;
    }


    /*
    *  Return all Title and Price about an URL
    * @params : $url, listing product url
    * @params : $argument_title : paramters about title search
    * @params : $parameters_price : css paramters about price search
    * @return : $result array about tile and price
    * help information :http://simplehtmldom.sourceforge.net/manual.htm
     * https://github.com/samacs/simple_html_dom
     * a[class="postlink"]
     * a[href*="phpbb.com"]
     * div#content
     * public
    */

    public function getProductListingPrice($url = null, $parameters_content = null, $parameters_title = null, $parameters_price = null)
    {
      $CLICSHOPPING_MessageStack = Registry::get('MessageStack');

      if (is_null($url) || is_null($parameters_title) || is_null($parameters_price)) {
        return false;
      }

      $html = $this->getHTML($url);

      if ($html === false) {
        return false;
      }

      $element = $this->document->loadHtml($html);

      if ($element->has($parameters_content)) {
        $content = $element->first($parameters_content); // content of the div

        if ($content->has($parameters_price)) {
          $price = $content->find($parameters_price); // price content inside the div
        }

        if ($content->has($parameters_title)) {
          $title = $content->find($parameters_title); // tile inside the div
        }
      } else {
        if ($element->has($parameters_price)) {
          $price = $element->find($parameters_price); // price content inside the div
        }

        if ($element->has($parameters_title)) {
          $title = $element->find($parameters_title); // tile inside the div
        }
      }

      $i = 0;

      if (!empty($price) && !empty($title)) {
        foreach ($price as $value) {
          $product_price[$i] = $value->text();

          preg_match_all('!\d+!', preg_replace('/\s/', '', $product_price[$i]), $matches);
          $price_extracted = (float)implode('.', $matches[0]);
          $item['normal_price'] = $price_extracted;

          $price_result[] = $item['normal_price'];
          $i++;
        }

        foreach ($title as $value) {
          $product_title[$i] = html_entity_decode($value->text());
          $title_result[] = $product_title[$i];
          $i++;
        }

        $result = array_map(null, $title_result, $price_result);

        return $result;
      } else {
        $CLICSHOPPING_MessageStack->add(CLICSHOPPING::getDef('text_error_price_title_css'), 'error', 'scrapping');
      }
    }
  }