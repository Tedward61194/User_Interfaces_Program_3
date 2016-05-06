{*Teddy Segal*}

{extends file="layout.tpl"}

{block name="localstyle"}
  {asset_css refs="table-display.css"}
  <style type='text/css'>
  </style>
{/block}

{block name="content"}
{$total = 0}

  <h2>My Cart</h2>
  {if $cart_data == null}
      Empty Cart
  {else}
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
                {$total = $total + $cur_flower->price*$entry}
              {/if}
              {/foreach}
          </tr>
      {/foreach}
      <tr><th>Total:</th><td>{$total}</td></tr>
      {if $session->get('member') and $session->get(member)->is_admin}
        {form action="admin/allOrders" name='allOrders' method="post"}
        <tr><td><input type='submit' name='allOrders' value ='Place Order'></td></tr>
        {/form}
      {/if}
      {if $session->get('member') and !($session->get(member)->is_admin)}
        {form action="member/myOrders" name='myOrders' method="post"}
        <tr><td><input type='submit' name='myOrders' value ='Place Order'></td></tr>
        {/form}
      {/if}
  </table>
  {/if}
{/block}
