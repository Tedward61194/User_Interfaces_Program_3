{*Teddy Segal*}

{extends file="layout.tpl"}

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