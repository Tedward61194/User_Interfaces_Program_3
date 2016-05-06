{*Teddy Segal*}

{extends file="layout.tpl"}

{block name="content"}
<h1>Modify Flower</h1>
{form method="post"}
<table>
    <tr>
        <td>Name:</td>
        <td>{$flower->name}</td>
    </tr>
    <tr>
        <td>Price:</td>
        <td>$<input type="text" name="price" size="40" value="{$flower->price}" /></td>
    </tr>
    <tr>
        <td>Description:</td>
        <td><textarea itemtype ="text" name="description" cols="40" rows="5">{$flower->description} </textarea></td>
    </tr>
    <tr>
        <td>instock</td>
        <td><input type="text" name="instock" size="10" value="{$flower->instock}" /></td>
    </tr>
    <tr>
        <td><input type='submit' name='modify' value ='Modify'></td>
        <td><input type='submit' name='cancel' value='Cancel'></td>
    </tr>
</table>
{/form}
{/block}