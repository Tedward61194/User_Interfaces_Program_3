{extends file="layout.tpl"}

{block name="localstyle"}
  {asset_css refs="table-display.css"}
  <style type='text/css'>
  </style>
{/block}

{block name="content"}

  <h2>My Cart</h2>

  {var_export($cart_data)}
  
{/block}
