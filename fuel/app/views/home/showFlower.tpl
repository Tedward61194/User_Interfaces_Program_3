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

  <table class='showFlower'>
    <tr>
      <td>
       {asset_img refs="flower/{$flower->imagefile}" attrs=['class' => 'flower']}
      </td>
      <td>
        <b>{$flower->name} (#{$flower->id})</b>
        <br />
        price: ${$flower->price}
        <br />
        <br />
        {$flower->description}
        <br />
        <br />
        <b>Cart</b>
        {form}
        <table>
            <tr><td><input type="text" name="quantity" value="{input_post index='quantity' default=$quantity}" /></td>
                <td><button type="submit" name="doit">Submit</button></td></tr>
            <td><button type="submit" name="clear">Clear</button></td>
            <br />
        <span class="error">{$validator->error_message('quantity')}</span>
        </table>
        {/form}
      </td>
    </tr>
  </table>

{/block}
