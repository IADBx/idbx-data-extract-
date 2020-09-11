@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Comments')])

@section('content')
<div class="content">
  <div class="container-fluid">

    
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">{{$question}}</h4>
            <p class="card-category"> {{$course}}</p>
            <p class="card-category"> {{$edition}}</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>
                    Comments
                  </th>
                </thead>
                <tbody>
                  @foreach($data as $comment)
                    @if ($loop->first)
                      @php
                        $resource_id = $comment->resource_id
                      @endphp
                    @endif
                  <tr>
                      <td>{{$comment->comment}}</td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
              {{ $data->appends(['resource' => $resource_id,'question'=>$question,'edition'=>$edition,'course'=>$course])->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection