<!-- Block multishopselector -->
<div class="blockCenterHome">
  <div class="row logoHome">
    <div class="block col-xs-12 col-sm-8 col-xs-offset-0 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
      <img src="{$base_dir_ssl}modules/multishopselector/img/home_logo.jpg" alt="logo" class="img-responsive">
    </div>
  </div>
  <div id="multishopselector_block_home" class="block col-xs-12 col-sm-10 col-xs-offset-0 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
    <form action="#" method="GET" class="row">
      <div class="col-xs-12 col-sm-11 col-xs-offset-0 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
        <div class="hideNoScript row">
          <div class="col-xs-12">
            <div class="row">
                <h2 class="col-xs-10 col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
                  {l s='Choose your shop :' mod='multishopselector'}
                </h2>
            </div>
          </div>
          <div class="col-xs-10 col-xs-offset-1 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
              <span class="custom-dropdown custom-dropdown--white">
                <select class="custom-dropdown__select custom-dropdown__select--white">
                  <option value="#">{l s='Choose your shop :' mod='multishopselector'}</option>
                  {foreach from=$shop_list item=shop}
                    {if $shop['virtual_uri']}
                      <option value="{$protocol}{$shop['domain']}{$shop['physical_uri']}{$shop['virtual_uri']}">{$shop['name']}</option>
                    {/if}
                  {/foreach}
                </select>
              </span>
          </div>
        </div>
        <noscript class="row">
          {if !($shop_ta_state && $PS_CATALOG_MODE)}
            <ul class="col-xs-12">
              {foreach from=$shop_list item=shop}
                {if $shop['virtual_uri']}
                  <li><a href="{$protocol}{$shop['domain']}{$shop['physical_uri']}{$shop['virtual_uri']}fr/">{$shop['name']}</a></li>
                {/if}
              {/foreach}
            </ul>
          {/if}
        </noscript>
      </div>
      <div class="col-xs-12 col-sm-11 col-xs-offset-0 col-sm-offset-1 col-md-offset-1 col-lg-offset-1">
        <div class="row">
            <span class="hideNoScript col-xs-3 col-md-2 col-xs-offset-1 col-sm-offset-1 col-md-offset-2 col-lg-offset-2">
              <input type="submit" value="{l s='Go :' mod='multishopselector'}" class="menu__button">
            </span>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="clearfix"></div>

<!-- /Block mymodule -->
