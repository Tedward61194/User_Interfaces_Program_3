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
    <table>
    {foreach $baskets as $basket}
        {if $basket->member_id==$member_id}
            <tr>
                <td>{html_anchor href="show/item/{$basket->id}" text="Order #{$basket->id}"}</td>
            </tr>
        {/if}
    {/foreach}
    </table>
    {*<br />
    <h2>My Cart</h2>
  <table>
      <tr>
          <th>Name</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Sub Total</th>
      </tr>
      {foreach $cart_data as $index => $entry}
          <tr>
              {foreach $flowers as $cur_flower}
              {if $cur_flower->id==$index && !$cart_data[$cur_flower->id]==null}
                <td>{html_anchor href="/show/flower/{$cur_flower->id}" text="{$cur_flower->name}"}</td>
                <td>{$cur_flower->price}</td>
                <td>{$entry}</td>
                <td>{$entry * $cur_flower->price}
              {/if}
              {/foreach}
          </tr>
        {/foreach}
        
        {foreach $items as $item}
            {$item->price}
        {/foreach} *}
{/block}