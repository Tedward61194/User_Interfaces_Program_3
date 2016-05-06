{*Teddy Segal*}

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
    <strong style="color: red;">{$message}</strong>
    <table>
    {foreach $baskets as $basket}
        <tr>
        <td>{html_anchor href="show/adminBasket/{$basket->id}" text="Order #{$basket->id}"}</td>
            <td>Time: {$basket->made_on}</td>
            {foreach $members as $member}
                {if $member->id ==$basket->member_id}
                    <td>Made by: {$member->name}</td>
                {/if}
            
            {/foreach}
        </tr>
    {/foreach}
    </table>
{/block}