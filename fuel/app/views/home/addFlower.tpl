{*Teddy Segal*}

{extends file="layout.tpl"}

{block name="content"}
    <h1>AddFlower</h1>
    {form action="admin/addFlowerReentrant" name="addFlower" method="post"}
    <table>
        <tr><td>name: </td><td><input type="text" name="name" size="40" value="{$name|default}" />
                <br /><span class="error">{$validator->error_message('name')}</span></td></tr>
        <tr><td>price: </td><td>$<input type="text" name="price" size="40" value="{$price}" />
            <br /><span class="error">{$validator->error_message('price')}</span></td></tr>
        <tr><td>description: </td><td><textarea itemtype="text" name="description" cols="40" rows='5'>{$description}</textarea></td></tr>
        <tr><td>instock: </td><td><input type="text" name="instock" size="10" value="{$instock}" />
            <br /><span class="error">{$validator->error_message('price')}</span></td></tr>
        <tr><td><button type="submit" name="doit">Add</button></td></tr>
    </table>
    {/form}
{/block}