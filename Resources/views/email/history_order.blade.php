@extends('email.plantilla')

@section('content')

<table width="528" border="0" align="center" cellpadding="0" cellspacing="0" class="mainContent">
<tbody>
    <tr>
        <td mc:edit="title1" class="main-header" style="color: #484848; font-size: 16px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
            <multiline>{{$data['title'] or ''}}</multiline>
        </td>
    </tr>
    
    <tr><td height="20"></td></tr>
        
    <tr>
        <td mc:edit="subtitle1" class="main-subheader" style="color: #a4a4a4; font-size: 12px; font-weight: normal; font-family: Helvetica, Arial, sans-serif;">
            <multiline>

                {{$data['intro'] or ''}}
                <br><br>

                @php
                    $user=$data['content']['user'];
                @endphp

                <div style="margin-bottom: 5px"><span style="color: #484848;">Sr/Sra</span>
                    @if(isset($user))
                        {{$user}}
                    @endif
                </div>

                <div style="margin-bottom: 5px">
                    <span style="color: #484848;">
                       Order: # {{$data['content']['order'] or ''}}
                    </span>
                       Status: <strong>{{$data['content']['status'] or ''}}</strong>
                </div>

                 <div style="margin-bottom: 5px">
                    {{trans('icommerce::common.emailMsg.comment')}}: {{$data['content']['comment'] or '---'}}
                 </div>

            </multiline>
        </td>
    </tr>

</tbody>
</table>
@endsection