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
{$total = 0}
    <h1>Order #{$basket->id}</h1>
    Member: {$member->name}<br/>
    Email: {$member->email}
    <hr/>
    <table>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Sub Total</th>
            <th>In Stock</th>
        </tr>
    {foreach $items as $item}
        <tr>
            {if $item->basket_id == $basket_id}
                {foreach $flowers as $flower}
                    {if $item->flower_id == $flower->id}
                        <td>{$flower->name}</td>
                        <td>{$item->price}</td>
                        <td>{$item->quantity}</td>
                        <td>{($item->price)*($item->quantity)}</td>
                        <td>{$flower->instock}</td>
                    {/if}
                {/foreach}
                {$total = $total + (($item->price)*($item->quantity))}
            {/if}
        </tr>
    {/foreach}
    <tr><th>Total:</th><td></td><td></td><td>{$total}</td></tr>
    <hr/>
    {form action="admin/processOrder" name='processOrder' method="post"}
    <td><input type="submit" name='processOrder' value='Process Order'></td>
    </table>
    {/form}
{/block}