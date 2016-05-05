{extends file="layout.tpl"}

{block name="localstyle"}
  <style type="text/css">
    .showFlower {
      margin-top: 20px;
    }
    .showFlower tr {
      vertical-align: top;
    }
    .showFlower tr td:first-child {
      padding-right: 10px;
    }
    img.flower {
      width: 220px;
      height: 220px;
    }
  </style>
{/block}

{block name="content"}
    {$name}
    {foreach $baskets as $basket}
        {$basket->member_id}
    {/foreach}
    {foreach $members as $member}
        {$member->name}
    {/foreach}
{/block}