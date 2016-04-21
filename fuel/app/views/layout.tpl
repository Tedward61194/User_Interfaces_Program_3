<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>  
      {$page_title|default: {base_url|dirname|basename}}
    </title>
    {asset_css refs="nav.css"}
    {asset_css refs="layout.css"}
    {block name="localstyle"}{/block}
  </head>
  <body>
  <main>

  <header>
    {asset_img refs="header.png"}
    <span class="caption">{$session->get('user')->name|default}</span>
  </header>
    
  <nav>
  <ul>
  <li>
    <a href="#" class="no-action">
      {asset_img attrs=[class=>"menu"] refs="menu.png"}
    </a>
  <ul>
  {include file="links.tpl"}
  </ul>
  </li>
  </ul>
  </nav>
  
  <section>
    {block name="content"}{/block}
  </section>
  
  </main>
  <script type="text/javascript">window.onunload = function(){}</script>
  </body>
</html>
