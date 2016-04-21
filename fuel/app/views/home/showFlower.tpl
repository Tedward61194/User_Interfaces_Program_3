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
        {form attrs=[]}
        CART QUANTITY FORM
        {/form}
      </td>
    </tr>
  </table>

{/block}
