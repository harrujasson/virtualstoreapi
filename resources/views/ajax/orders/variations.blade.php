<div class="table-vertical">
    <table class="table table-striped">
      <thead>
        <tr>
          <th style="padding-right:100px">Name</th>                             
          <th>Value</th>
          <th>Price</th>          
        </tr>
      </thead>
      <tbody>
          @if(!empty($var))
          @foreach($var as $v)
          <tr>
                <td data-title="Name">{{$callback->get_attribute_name($v->attribute_id)}} ({{$callback->get_attribute_name($v->attribute_id,'name')}})</td>
                <td data-title="Value"> @if(is_array($v->attribute_value)) {{implode(',',$v->attribute_value)}} @else {{$v->attribute_value}} @endif</td>
                <td data-title="Price">{{number_format($v->attribute_value_price,2)}}</td>
          </tr>
          @endforeach          
          @endif
          
      </tbody>
    </table>
    <h4>Total Variations Price: {{number_format($total_price,2)}}</h4>
</div>