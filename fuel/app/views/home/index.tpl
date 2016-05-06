{*Teddy Segal*}

{extends file="layout.tpl"}

{block name='localstyle'}
  <style type='text/css'>
    img.flower {
      width: 50px;
      height: 50px;
    }
    .showFlowers tr td:first-child {
      padding-right: 10px;
    }
    .setOrder {
      position: absolute;
      top: 10px;
      right: 10px;
    }
  </style>
{/block}

{block name="content"}
  <h2>Listing (by ...)</h2>

  {form attrs=['class' => 'setOrder']}
  SET ORDER
  {/form}

  <table class='showFlowers'>
    {foreach $flowers as $flower}
      <tr>
        <td>
          {html_anchor href="/show/flower/{$flower->id}" text="{$flower->name}"}
          <br />
          price: ${$flower->price|string_format: "%.2f"}
        </td>

        <td>
          {asset_img refs="flower/{$flower->imagefile}" attrs=['class' => 'flower']}
        </td>
      </tr>
    {/foreach}
  </table>

{/block}
