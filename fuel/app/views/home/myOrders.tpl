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
    <h1>My Orders</h1>
    <table>
    {foreach $baskets as $basket}
        {if $basket->member_id==$member_id}
            <tr>
                <td>{html_anchor href="show/myBasket/{$basket->id}" text="Order #{$basket->id}"}</td>
                <td>Time: {$basket->made_on}</td>
            </tr>
        {/if}
    {/foreach}
    </table>
{/block}