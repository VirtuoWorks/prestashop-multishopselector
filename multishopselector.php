<?php
if (!defined('_PS_VERSION_'))
  exit;

class MultishopSelector extends Module
{
  public function __construct()
  {
    $this->name = 'multishopselector';
    $this->tab = 'front_office_features';
    $this->version = '1';
    $this->author = 'Marc Boussoulade - Virtuoworks.com';
    $this->need_instance = 0;
    $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    $this->bootstrap = true;

    parent::__construct();

    $this->displayName = $this->l('Multishop Selector');
    $this->description = $this->l('Display a select on home page for choosing the desired store.');

    $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

    if(!Configuration::get("PS_MULTISHOP_FEATURE_ACTIVE"))
    {
      $this->warning = $this->l("Your site has only one store. Multi-store feature must be enabled to use this module");
    }

  }

  public function install()
  {
    if (Shop::isFeatureActive())
      Shop::setContext(Shop::CONTEXT_ALL);

    if (!parent::install()
      || !$this->registerHook('displayHeader')
      || !$this->registerHook('displayHome')
      || !$this->registerHook('displayNav')
      )
      return false;
    return true;
  }

  public function uninstall()
  {
    return parent::uninstall();
  }

  function hookDisplayHeader($params)
  {
    $this->context->controller->addJS($this->_path.'js/scripts.js');
    $this->context->controller->addCSS($this->_path.'css/style.css');
  }

  function _getShopsInformations()
  {
    $defaultShop = (int)Configuration::get('PS_SHOP_DEFAULT');
    return Db::getInstance()->executeS("select
        s.id_shop,
        s.name,
        sg.name as group_name,
        su.domain,
        su.domain_ssl,
        su.physical_uri,
        su.virtual_uri
      from `"._DB_PREFIX_."shop` s
        inner join `"._DB_PREFIX_."shop_url` su
          on s.id_shop = su.id_shop
        inner join `"._DB_PREFIX_."shop_group` sg
          on s.id_shop_group = sg.id_shop_group
      where s.active=true and s.deleted=false and s.id_shop !=" . $defaultShop . "
       order by s.name ASC");
  }
//exclusion d'une boutique : and su.virtual_uri != 'a-emporter/'

  function _stateShopGetAway()
  {
    $idTakeAway = Db::getInstance()->executeS("select
      id_shop
      from ps_shop
      where name like 'a-emporter'");
      if($idTakeAway)
      {
        $data = Db::getInstance()->executeS("select
        value
        from ps_configuration
        where id_shop=" . $idTakeAway[0]['id_shop'] . " and name like 'PS_CATALOG_MODE'");
        if ($data && !empty($data[0]['value'])) {
          return $data[0]['value'];
        }
        return false;
      }
      return false;
  }


  function hookDisplayHome($params)
  {
    $shopsInformations = $this->_getShopsInformations();
    $stateGetAway = $this->_stateShopGetAway();
    for($i = 0; $i < count($shopsInformations); $i++)
    {
        // Récupération du transporteur lié au nom du magasin
        $resultQuery1 = (Db::getInstance()->executeS('select id_carrier from ps_carrier where name =' . $shopsInformations[$i]['name'] . ' AND deleted = 0'));
        // Récupération du tarif minimal de livraison du transporteur trouvé ci-dessus
        if(count($resultQuery1))
        {
          $resultQuery2 = (Db::getInstance()->executeS('select delimiter1 from ps_range_price where id_carrier =' . $resultQuery1[0]['id_carrier']));
          $minPrice =  intval($resultQuery2[0]['delimiter1']) . '€';
        }
        else
        {
          $minPrice = 'Pas de somme fixée';
        }

      $shopsInformations[$i]['min_price'] = $minPrice;
    }

    $this->context->smarty->assign(array(
          'shop_list' => $shopsInformations,
          'shop_ta_state' => $stateGetAway,
          'protocol' => Tools::getShopProtocol(),
          'url_take_way' => $shopsInformations[0]['domain'] . $shopsInformations[0]['physical_uri']
    ));
    return $this->display(__FILE__, 'multishopselector.tpl');
  }

  function hookDisplayNav($params)
  {
    $this->context->smarty->assign(array(
      'shop' => $this->context->shop,
    ));
    return $this->display(__FILE__, 'nav.tpl');
  }
}
