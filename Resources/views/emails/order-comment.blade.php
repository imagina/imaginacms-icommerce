@if(!empty($order->comment))
  <tr>
    <td>
      <table role="presentation" cellpadding="0" cellspacing="0" border="0"
        style="width: 100%; text-align:left; margin-bottom: 20px;">
        <caption
          style="background-color:#a5a5a53b;padding:15px 10px 15px;margin:0;font-weight:600;color:#212529;font-size:14px;line-height:1;text-transform:capitalize;text-align:left;width:97%;border-radius:4px 4px 4px 4px; margin-bottom:10px;">
          Comentario Adicional</caption>
        <tr style="font-size: 13px;">
          <td>{{$order->comment}}</td>
        </tr>

      </table>
    </td>
@endif