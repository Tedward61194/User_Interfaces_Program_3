<li>{html_anchor href="/" text="Home"}</li>
<li>{html_anchor href="/show/cart" text="Cart"}</li>

{if $session->get('member') and $session->get(member)->is_admin}
    <li>{html_anchor href="/admin/allOrders" text="allOrders"}</li>
{/if}
{if $session->get('member')}
    <li>{html_anchor href='/authenticate/logout' text='Logout'}</li>
{else}
    <li>{html_anchor href='/authenticate/login' text='Login'}</li>
{/if}