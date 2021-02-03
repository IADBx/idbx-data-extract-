@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Courses')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Encuesta Inicial</h4>
          </div>
          <div class="card-body">
            <div class='row'>
              <div class="col-md-11">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                    
                          <th class="text-center" colspan='2'><strong>Template</strong></th>
                          <th class="text-center"><strong>EDX</strong></th>
                          <th class="text-center"><strong>Verificación</strong></th>
                     
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($questions_template as $question_template)
                          <tr>
                            <td>
                              <strong>Pregunta {{$question_template->question_id}}</strong>
                            </td>
                            <td>
                              <strong>{{$question_template->display_name_es}}</strong>
                            </td>
                            <?php
                              $id_template=0                       
                            ?>                              
                              @foreach($questions_edx as $question_edx)
                                @if($question_edx->question_id==$question_template->question_id)
                                  <td>
                                    <strong>
                                      {{$question_edx->display_name}}
                                    </strong>
                                    <?php
                                    
                                      $id_template=$question_edx->id_template
                                    ?> 
                                  </td>
                                  @break
                                @endif                                
                              @endforeach
                              @if($id_template==0)
                                <td>No se encontró la pregunta</td>
                                <td><i class="material-icons" style="color:red">dangerous</i></td>
                              @else
                                <td><i class="material-icons" style="color:green">check_circle_outline</i></td>
                              @endif
                          </tr>
                          @foreach($answers_template as $answer_template)
                            @if($question_template->question_id==$answer_template->question_id)
                              <tr>
                                <td>
                                </td>
                                <td>
                                  {{$answer_template->display_name_es}}
                                </td>
                                <?php
                                  $id_answer=0                       
                                ?> 
                                @foreach($answers_edx as $answer_edx)
                                  @if($answer_edx->answer_id==$answer_template->answer_id)
                                    <td>
                                      {{$answer_edx->display_name}}
                                    </td>
                                    <?php
                                      $id_answer=$answer_edx->id_template
                                    ?> 
                                    @break
                                  @endif
                                @endforeach
                                @if($id_answer==0)
                                  <td style="color:red">No se encontró la respuesta</td>
                                  <td><i class="material-icons" style="color:red">dangerous</i></td>
                                @else
                                  <td><i class="material-icons" style="color:green">check_circle_outline</i></td>
                                @endif
                              </tr>
                              
                            @endif

                          

                          @endforeach
                          

                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection