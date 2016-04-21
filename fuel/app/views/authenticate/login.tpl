{extends file="layout.tpl"}

{block name="localstyle"}
{asset_css refs="table-display.css"}
{/block}

{block name="content"}
<h2>Login</h2>

<p>Please enter access information</p>
{form attrs=['action' => '/authenticate/validate']}
<table>
    <tr>
        <th>user:</th>
        <td><input type="text" name="name" autofocus="on" value="{$name|default}" /></td>
    </tr>
    <tr>
        <th>password:</th>
        <td><input type="password" name="password" /></td>
    </tr>
    <tr>
        <td></td>
        <td><button type="submit">Access</button></td>
    </tr>
</table>
{/form}

<h4 class="messgae">{session_get_flash var='message'}</h4>
{/block}