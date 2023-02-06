<div class="table-vertical">
    <table class="table table-striped">
      <thead>
        <tr>
          <th style="padding-right:100px">Sr.</th>                             
          <th>Download</th>                 
        </tr>
      </thead>
      <tbody>
          
          @if(!empty($attach))
          @php $cnt=1; @endphp
          @foreach($attach as $a)
          <tr>
                <td data-title="Sr">{{$cnt}}</td>
                <td data-title="Download"><a download="" href="{{asset("public/uploads/product/".$a)}}"><i class="fa fa-download"></i></a></td>
                
          </tr>
          @php $cnt++; @endphp
          @endforeach          
          @endif
          
      </tbody>
    </table>   
</div>