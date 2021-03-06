{*Teddy Segal*}

{extends file="layout.tpl"}

{block name="content"} 
{$total = 0}
    <h1>Order #{$basket->id}</h1>
    <hr/>
    <table>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Sub Total</th>
        </tr>
    {foreach $items as $item}
        <tr>
            {if $item->basket_id == $basket_id}
                {foreach $flowers as $flower}
                    {if $item->flower_id == $flower->id}
                        <td>{$flower->name}</td>
                    {/if}
                {/foreach}
                <td>{$item->price}</td>
                <td>{$item->quantity}</td>
                <td>{($item->price)*($item->quantity)}</td>
                {$total = $total + (($item->price)*($item->quantity))}
            {/if}
        </tr>
    {/foreach}
    <tr><th>Total:</th><td>{$total}</td></tr>
    </table>
{/block}