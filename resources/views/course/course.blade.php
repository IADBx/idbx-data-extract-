@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Courses')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">{{$data->name}}</h4>
            <p class="card-category"> {{$data->id}}</p>
          </div>
          <div class="card-body">
            <div id="accordion">
              <div class="card">
                  @foreach($data->chapters as $chapter)
                    <div class="card-header" id="head-{{$chapter->module_id}}">
                      <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-{{$chapter->module_id}}" aria-expanded="false" aria-controls="collapse-{{$chapter->module_id}}">
                          {{$chapter->display_name}} 
                        </button>
                      </h5>
                  </div>

                  <div id="collapse-{{$chapter->module_id}}" class="collapse" aria-labelledby="head-{{$chapter->module_id}}" data-parent="#accordion">
                    <div class="card-body">
                      <div id="accordion_sequential">
                        <div class="card">
                          @foreach($chapter->sequentials as $sequential)
                            <div class="card-header" id="head-{{$sequential->module_id}}">
                              <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-{{$sequential->module_id}}" aria-expanded="false" aria-controls="collapse-{{$sequential->module_id}}">
                                  {{$sequential->display_name}} 
                                </button>
                              </h5>
                            </div>
                            <div id="collapse-{{$sequential->module_id}}" class="collapse" aria-labelledby="head-{{$sequential->module_id}}" data-parent="#accordion_sequential">
                              <div class="card-body">
                                <div id="accordion_vertical">
                                  <div class="card">
                                    @foreach($sequential->verticals as $vertical)
                                      <div class="card-header" id="head-{{$vertical->module_id}}">
                                        <h5 class="mb-0">
                                          <button class="btn btn-link" data-toggle="collapse" data-target="#collapse-{{$vertical->module_id}}" aria-expanded="false" aria-controls="collapse-{{$vertical->module_id}}">
                                            {{$vertical->display_name}} 
                                          </button>
                                        </h5>
                                      </div>
                                      <div id="collapse-{{$vertical->module_id}}" class="collapse" aria-labelledby="head-{{$vertical->module_id}}" data-parent="#accordion_vertical">
                                        <div class="card-body">
                                          <div id="accordion_resource">
                                            <div class="card">
                                              @foreach($vertical->resources as $resource)
                                                @if ($resource->category == 'problem')
                                                  <p class="h5">{{$resource->display_name}}</p>
                                                  <p class="h5">{{count($resource->comments)}} comments</p>
                                                  <div class="copyright float-right">
                                                      @if (count($resource->comments)>1)
                                                      
                                                      <a href="{{ route('problems.show',$resource->module_id)}}" class="btn btn-warning">Download</a>                                                                                                    
                                                      
                                                      <a href="{{ route('problems.index',['resource'=>$resource->module_id, 'course'=>$data->name,'edition'=>$data->id,'question'=>$resource->display_name])}}" class="btn btn-info">View</a>
                                                        
                                                      @endif
                                                  </div>
     

                                                @else
                                                  @foreach($resource->questions as $question)
                                                  <p class="h5">{{$question->display_name}}</p>
                                                      @php
                                                          $total = 0;
                                                      @endphp
                                                    <div class="row">
                                                      <div class="col-md-6">
                                                        <div class="table-responsive">
                                                          <table class="table">
                                                            <thead class=" text-primary">
                                                                <tr>
                                                                    <th class="text-center">Answer</th>
                                                                    <th class="text-center">QUESTION MATCH</th>
                                                                    <th class="text-center">ID MATCH</th>
                                                                    <th>quantity</th>
                                                                    <th>%</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                              @foreach($question->students as $student)
                                                                @php
                                                                    $total = isset($total) ? $total + $student->total : 0;

                                                                @endphp
                                                                <tr>
                                                                  <td>{{$student->answer->display_name}}</td>
                                                                  <td>{{$student->answer->question_parent}}</td>
                                                                  <td>{{$student->answer->answer_id}}</td>
                                                                  <td>{{$student->total}}</td>
                                                                  <td>{{$student->percentage}}%</td>
                                                                </tr>
                                                              @endforeach
                                                                <tr>
                                                                  <td>TOTAL</td>
                                                                  <td>{{ $total }}</td>
                                                                </tr>
                                                            </tbody>
                                                            
                                                          </table>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  @endforeach
                                                @endif
                                              @endforeach
                                            </div>
                                          </div>
                                        </div>
                                      </div>                                    
                                    @endforeach

                                  </div>

                                </div>
                              </div>
                            </div>

                          @endforeach
                        </div>

                      </div>
                      
                    </div>
                  </div>            
                  @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection