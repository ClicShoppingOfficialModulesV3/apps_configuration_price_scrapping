Some example

cdiscout.com
  $url = 'https://www.cdiscount.com/high-tech/televiseurs/tv-4k-uhd/toutes-les-tv-4k-uhd/l-106262305.html#_his_';
  $parameters_content = 'div.lpTopBox';
  $parameters_title = 'div.prdtBTit';
  $parameters_price = 'span.price';

amazon.com
  $url = 'https://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Daps&field-keywords=ordinateur';
  $parameters_content = '#atfResults';
  $parameters_title = 'h2';
  $parameters_price = 'span.a-offscreen';

boulanger.com
    url =https://www.boulanger.com/c/televiseur/{search_tag}
    content = div.productListe
    title = a
    price = span.exponent

Ldlc.com
    url = https://www.ldlc.com/recherche/{search_tag}/
    content = div.listing-product
    title = h3.title-3
    price = div.price
or
    $url = 'https://www.ldlc.com/navigation/galaxy+note+8/';
    $parameters_content = '#productListingWrapper';
    $parameters_title = 'a.nom';
    $parameters_price = 'span.price';
    $text_search = 'Samsung Galaxy Note 8';


rueducommerce.fr
    $url = 'https://www.rueducommerce.fr/recherche/ordinateur-samsung?sort=score&universe=MC-3540&view=grid';
    $parameters_content = 'section.grid';
    $parameters_title = 'span[itemprop=name]';
    $parameters_price = 'div.price';

bestbuy.ca
    $search_keywords = 'Galaxy%20note%208';
    $url = 'https://www.bestbuy.ca/fr-CA/Search/SearchResults.aspx?query=' . $search_keywords;
    $parameters_content = '#ctl00_CC_ListingProduct';
    $parameters_title = 'h4.prod-title';
    $parameters_price = 'span.amount';
    $text_search = 'Galaxy Note8 de 64 Go';

canadiantire.ca
    $url =  'http://www.canadiantire.ca/en/sports-rec/bikes-accessories/bikes/hybrid-bikes.html?adlocation=LIT_Category_Product_HybridBikesCat_en';
    $parameters_content = 'div.assortment-right-column';
    $parameters_title = 'h3.product-tile-srp__title';
    $parameters_price = 'div.product-tile__price';
