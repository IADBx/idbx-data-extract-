@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Courses')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">{{$report->name}}</h4>
            <h4 class="card-title "> Inicio {{$report->start_date}}</h4>
            <input type="hidden" id="course_id" name="course_id" value='{{$report->course_id}}'>
          </div>
          <div class="card-body"> 

          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Visión general del curso en comparación al promedio de todos los cursos similares (MOOC) del programa IDBx</h4>
          </div>
          <div class="card-body">            
            <h4><b>Fuente:</b> IDBx Dinamic Report</h4>
            <div class="col-md-12">
              <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Indicador</th>
                        <th>Edición {{$report->edition}} </th>
                        <?php if($report_group[0]>0){?>
                          <th>Promedio ediciones anteriores</th>
                        <?php }?>

                        <?php if($report_group[0]>0){?>
                          <th>Promedio todas las ediciones hasta la edición {{$report->edition}}</th>
                        <?php }?>                        

                        <th>Promedio histórico<br> MOOCs finalizados en español<br> del programa IDBx*</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Registrados totales <sup>1</sup> </td>
                        <td>{{$report->registrado}}</td>

                        <?php if($report_group[0]>0){ ?>
                          <td>{{$report_group[0]}}</td>                          
                        <?php }?>

                        <?php if($report_group[0]>0){ ?>
                          <td>{{$report_group_all[0]}}</td>                          
                        <?php }?>

                        <td>{{$report_type[0]}}</td>
                    </tr>
                    <tr>
                      <td>Registrados a la fecha de cierre <sup>2</sup></td>
                      <td>{{$report->in_date}}</td>

                      <?php if($report_group[0]>0){ ?>
                        <td>{{$report_group[1]}}</td>                                              
                      <?php } ?>

                      <?php if($report_group[0]>0){ ?>
                        <td>{{$report_group_all[1]}}</td>                                              
                      <?php } ?>

                      <td>{{$report_type[1]}}</td>
                    </tr>
                    <tr>
                      <td>Países representados   <sup>3</sup></td>
                      <td>{{$report->country}}</td>

                      <?php if($report_group[0]>0){ ?>
                        <td>{{$report_group[4]}}</td>                      
                      <?php }  ?>

                      <?php if($report_group[0]>0){ ?>
                        <td>{{$report_group_all[4]}}</td>                      
                      <?php }  ?>

                      <td>{{$report_type[4]}}</td>
                    </tr>
                    <tr>
                      <td>Participantes<sup>4</sup><br>(% de registrados totales)</td>
                      <td>{{$report->participant}}<br>({{round(($report->participant/$report->registrado)*100,2)}}%)</td>
                      <?php if($report_group[0]>0){ ?>
                        <td>{{$report_group[2]}}<br>({{round(($report_group[2]/$report_group[0])*100,2)}}%)</td>
                      <?php }?>
                      <?php if($report_group[0]>0){ ?>
                        <td>{{$report_group_all[2]}}<br>({{round(($report_group_all[2]/$report_group_all[0])*100,2)}}%)</td>
                      <?php }?>                      
                      <td>{{$report_type[2]}}<br>({{round(($report_type[2]/$report_type[0])*100,2)}}%)</td>
                    </tr>
                    <tr>
                      <td>Participantes a la fecha de cierre <sup>5</sup> <br>(% de registrados al cierre)</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Certificados <sup>6</sup>  <br>(% de participantes al cierre)</td>
                      <td>{{$report->certificate}}<br>({{round(($report->certificate/$report->participant)*100,2)}}%)</td>
                      <?php if($report_group[0]>0){ ?>
                        <td>{{$report_group[3]}}<br>({{round(($report_group[3]/$report_group[2])*100,2)}}%)</td>
                        <?php }?>

                        <?php if($report_group[0]>0){ ?>
                        <td>{{$report_group_all[3]}}<br>({{round(($report_group_all[3]/$report_group_all[2])*100,2)}}%)</td>
                        <?php }?>


                      <td>{{$report_type[3]}}<br>({{round(($report_type[3]/$report_type[2])*100,2)}}%)</td>
                    </tr>                                                                                

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4"><strong>Nota: </strong><p>se hace el comparativo con los MOOC que ya están cerrados. Con fecha de corte {{$report->start_date}}. 
                    <br>(*) Hasta {{$report->start_date}}</p></td>
                    </td>                    
                  </tr>
                  <tr>
                    <td colspan="4">

                        <p><sup>1</sup>El número de registrados en el curso hasta la fecha de este reporte.<br>
                        <sup>2</sup>El número de registrados al cierre del curso se utiliza como referencia para calcular porcentajes de participantes activos. Este número no incluye registros posteriores a esta fecha. <br>
                        <sup>3</sup>Este es el valor promedio. <br>
                        <sup>4</sup>Usuarios registrados que accedieron a la dirección URL del curso para hacer uso de sus recursos de aprendizaje (videos, lecturas, foros de discusión, etc.) <br>
                        <sup>5</sup>El número de participantes del curso se utiliza como referencia para calcular porcentajes de personas que completaron el curso. Este número no incluye registrados posteriores a esta fecha. <br>
                        <sup>6</sup>Participantes que efectivamente obtuvieron el certificado del curso.<br>                        
                    </td>                    
                  </tr>                  
                </tfoot>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Características de los registrados en el curso </h4>
          </div>
          <div class="card-body"> 
            <div class="row">
              <div class="col-md-12">
                <h4><strong>1.	Género con el cual los registrados se identifican</strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta inicial, pregunta 8</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4><strong>muestra: </strong></h4>                
              </div>                                          
            </div>
            <div class="row justify-content-md-center">              
                <div id="question_8"></div>              
            </div>
            <br><br>
            <div class="row">
              <div class="col-md-12">
                <h4><strong>2.	Origen étnico con el cual los registrados se identifican</strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta inicial, pregunta 9</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4><strong>muestra: </strong></h4>                
              </div>                                          
            </div>
            <div class="row justify-content-md-center">              
                <div id="question_9" ></div>              
            </div>     
            <div class="row">
              <div class="col-md-12">
                <h4><strong>3.	Nivel de educación de los registrados</strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta inicial, pregunta 10</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4><strong>muestra: </strong></h4>                
              </div>                                          
            </div>
            <div class="row justify-content-md-center">              
                <div id="question_10" ></div>              
            </div>   
            <div class="row">
              <div class="col-md-12">
                <h4><strong>4.	Rango de edad de los registrados</strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta inicial, pregunta 7</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4><strong>muestra: </strong></h4>                
              </div>                                          
            </div>
            <div class="row justify-content-md-center">              
                <div id="question_7" ></div>              
            </div> 
            <div class="row">
              <div class="col-md-12">
                <h4><strong>5.	Sector o actividad a la que los participantes dedican más tiempo</strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta inicial, pregunta 11</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4><strong>muestra: </strong></h4>                
              </div>                                          
            </div>
            <div class="row justify-content-md-center">              
                <div id="question_11" ></div>              
            </div> 

            <div class="row">
              <div class="col-md-12">
                <h4><strong>6.	¿Tienes algún tipo de discapacidad visual, auditiva o motora que te limite aprovechar los contenidos del curso?
</strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta inicial, pregunta 14</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4><strong>muestra: </strong></h4>                
              </div>                                          
            </div>
            <div class="row justify-content-md-center">              
                <div id="question_14" ></div>              
            </div>                                                          

          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Evaluación del curso y sus contenidos por parte de los participantes </h4>            
          </div>
          <div class="card-body"> 
            <div class="row">
                <div class="col-md-12">
                  <h4><strong>1.	Intención de los participantes al registrarse en el curso (%)</strong></h4>                
                </div>              
                <div class="col-md-12">
                  <h4><strong>Fuente: Encuesta inicial, pregunta 1</strong></h4>                
                </div> 
                <div class="col-md-12">
                  <h4><strong>muestra: </strong></h4>                
                </div>                                          
              </div>
              <div class="row justify-content-md-center">              
                  <div id="question_1" style="width:300x;height:400px;"></div>              
              </div>
              <div class="row">
                <div class="col-md-12">
                  <h4><strong>2.	Ganancia de aprendizaje (conocimiento sobre los temas tratados en el curso antes y después del curso) </strong></h4>                
                </div>              
                <div class="col-md-12">
                  <h4><strong>Fuente: Encuesta inicial, pregunta 2</strong></h4>                
                </div> 
                <div class="col-md-12">
                  <h4><strong>muestra: </strong></h4>                
                </div>                                          
              </div>
              <div class="row justify-content-md-center">              
                  <div id="final_question_2" ></div>              
              </div>           
              <div class="row">
                <div class="col-md-12">
                    <p>•	La ganancia de aprendizaje de este MOOC, por parte de los participantes, es de  puntos.</p>
                    <p>•	La ganancia de aprendizaje promedio para todos los MOOC, por parte de los participantes, es de  puntos.<p>
                </div>
              </div>


              <div class="row">
                <div class="col-md-12">
                  <h4><strong>3. Promedio de logro de objetivos de aprendizaje, comparado con promedio general de los MOOC </strong></h4>                
                </div>              
                <div class="col-md-12">
                  <h4><strong>Fuente: Encuesta inicial, pregunta 1.1</strong></h4>                
                </div> 
                <div class="col-md-12">
                  <h4><strong>muestra: </strong></h4>                
                </div>
                <div class="col-md-12">
                    <p>Rating:</p>
                    <p>-	Entre 5 y 4,5 = Excelente.</p>
                    <p>-	Entre 4,5 y 4,0 = Adecuado.</p>
                    <p>-	Entre 4,0 y 3,0 = Deficiente. Revisar curso y tomar medidas.</p>
                    <p>-	Entre 3,0 y 0 = Muy deficiente. Revisar el curso con urgencia y tomar medidas.</p>

                </div>                                          
              </div>


              <div class="row">
                <div class="col-md-12">
                  <h4><strong>7.	Índice de calidad del MOOC (MQI)  </strong></h4>                
                </div>              
                <div class="col-md-12">
                  <h4><strong>Fuente: Encuesta inicial, pregunta 1.1</strong></h4>                
                </div> 
                <div class="col-md-12">
                  <h4><strong>muestra: </strong></h4>                
                </div>
                <div class="col-md-12">
                    <p>Rating:</p>
                    <p>-	Entre 5 y 4,5 = Excelente.</p>
                    <p>-	Entre 4,5 y 4,0 = Adecuado.</p>
                    <p>-	Entre 4,0 y 3,0 = Deficiente. Revisar curso y tomar medidas.</p>
                    <p>-	Entre 3,0 y 0 = Muy deficiente. Revisar el curso con urgencia y tomar medidas.</p>

                </div>                                          
              </div>
              <div class="row justify-content-md-center">              
                  <div id="satisfaction_mqi" style="width:400x;height:400px;"></div>              
              </div>  
             
              

          </div>
        </div>
      </div>
    </div>

    
  </div>
</div>
@endsection

@push('js')

<script>
  jQuery(document).ready(function($){

      var course_id = $("input[name=course_id]").val();
      

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
           type:'GET',
           url:"{{ route('survey.initial') }}",
           data:{course_id:course_id,question:8},
           success:function(data_question){  
             
              if(data_question['old_data']==0){
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['percentage'],
                name: 'Edición:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage'],
              };

              var trace2 = {
                x: data_question['display_name_historical'],
                y: data_question['percentage_historical'],
                name: 'Historico MOOCs español',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_historical'],
              };

              var data = [trace1, trace2];

              var layout = {
                barmode: 'group',
                width: 900,
                height: 600,
                };


               Plotly.newPlot('question_8', data,layout);
              } else{
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['percentage'],
                name: 'Edición:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage'],
              };

              var trace2 = {
                x: data_question['display_name_old'],
                y: data_question['percentage_old'],
                name: 'Histórico del curso hasta la edición '+ (data_question['edition_course']-1),
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_old'],
              };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['percentage_historical'],
                name: 'Historico MOOCs español',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_historical'],
              };

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                width: 900,
                height: 600,
                };


               Plotly.newPlot('question_8', data,layout);
              }
           }
      });




      $.ajax({
           type:'GET',
           url:"{{ route('survey.initial') }}",
           data:{course_id:course_id,question:9},
           success:function(data_question){  
             
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: data_question['display_name'],
                  y: data_question['percentage'],
                  name: 'Edición:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage'],
                };

                var trace2 = {
                  x: data_question['display_name_historical'],
                  y: data_question['percentage_historical'],
                  name: 'Historico MOOCs español',
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage_historical'],
                };

              var data = [trace1, trace2];

              var layout = {
                barmode: 'group',
                width: 900,
                height: 600,
                };


               Plotly.newPlot('question_9', data,layout);
              } else{
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['percentage'],
                name: 'Edición:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage'],
              };

              var trace2 = {
                x: data_question['display_name_old'],
                y: data_question['percentage_old'],
                name: 'Histórico del curso hasta la edición '+ (data_question['edition_course']-1),
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_old'],
              };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['percentage_historical'],
                name: 'Historico MOOCs español',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_historical'],
              };

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                width: 900,
                height: 600,
              };


               Plotly.newPlot('question_9', data,layout);
              }
           }
      });


      $.ajax({
           type:'GET',
           url:"{{ route('survey.initial') }}",
           data:{course_id:course_id,question:10},
           success:function(data_question){  
            
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: data_question['display_name'],
                  y: data_question['percentage'],
                  name: 'Edición:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage'],
                };

                var trace2 = {
                  x: data_question['display_name_historical'],
                  y: data_question['percentage_historical'],
                  name: 'Historico MOOCs español',
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage_historical'],
                };

              var data = [trace1, trace2];

              var layout = {
                barmode: 'group',
                width: 900,
                height: 600,
                };


               Plotly.newPlot('question_10', data,layout);
              } else{
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['percentage'],
                name: 'Edición:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage'],
              };

              var trace2 = {
                x: data_question['display_name_old'],
                y: data_question['percentage_old'],
                name: 'Histórico del curso hasta la edición '+ (data_question['edition_course']-1),
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_old'],
              };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['percentage_historical'],
                name: 'Historico MOOCs español',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_historical'],
              };

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                width: 900,
                height: 600,
                };


               Plotly.newPlot('question_10', data,layout);
              }
           }
      });

      $.ajax({
           type:'GET',
           url:"{{ route('survey.initial') }}",
           data:{course_id:course_id,question:7},
           success:function(data_question){              
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: data_question['display_name'],
                  y: data_question['percentage'],
                  name: 'Edición:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage'],
                };

                var trace2 = {
                  x: data_question['display_name_historical'],
                  y: data_question['percentage_historical'],
                  name: 'Historico MOOCs español',
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage_historical'],
                };

              var data = [trace1, trace2];

              var layout = {
                barmode: 'group',
                width: 900,
                height: 600,
                };


               Plotly.newPlot('question_7', data,layout);
              } else{
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['percentage'],
                name: 'Edición:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage'],
              };

              var trace2 = {
                x: data_question['display_name_old'],
                y: data_question['percentage_old'],
                name: 'Histórico del curso hasta la edición '+ (data_question['edition_course']-1),
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_old'],
              };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['percentage_historical'],
                name: 'Historico MOOCs español',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_historical'],
              };

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                width: 900,
                height: 600,
                };


               Plotly.newPlot('question_7', data,layout);
              }
           }
      });

      $.ajax({
           type:'GET',
           url:"{{ route('survey.initial') }}",
           data:{course_id:course_id,question:11},
           success:function(data_question){               
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: data_question['display_name'],
                  y: data_question['percentage'],
                  name: 'Edición:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage'],
                };

                var trace2 = {
                  x: data_question['display_name_historical'],
                  y: data_question['percentage_historical'],
                  name: 'Historico MOOCs español',
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage_historical'],
                };

              var data = [trace1, trace2];

              var layout = {
                barmode: 'group',
                width: 900,
                height: 600,
                };


               Plotly.newPlot('question_11', data,layout);
              } else{
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['percentage'],
                name: 'Edición:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage'],
              };

              var trace2 = {
                x: data_question['display_name_old'],
                y: data_question['percentage_old'],
                name: 'Histórico del curso hasta la edición '+ (data_question['edition_course']-1),
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_old'],
              };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['percentage_historical'],
                name: 'Historico MOOCs español',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_historical'],
              };

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                width: 900,
                height: 600,
                };


               Plotly.newPlot('question_11', data,layout);
              }
           }
      });

      $.ajax({
           type:'GET',
           url:"{{ route('survey.initial') }}",
           data:{course_id:course_id,question:14},
           success:function(data_question){               
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: data_question['display_name'],
                  y: data_question['percentage'],
                  name: 'Edición:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage'],
                };

                var trace2 = {
                  x: data_question['display_name_historical'],
                  y: data_question['percentage_historical'],
                  name: 'Historico MOOCs español',
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage_historical'],
                };

              var data = [trace1, trace2];

              var layout = {
                barmode: 'group',
                width: 900,
                height: 600,
                };


               Plotly.newPlot('question_14', data,layout);
              } else{
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['percentage'],
                name: 'Edición:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage'],
              };

              var trace2 = {
                x: data_question['display_name_old'],
                y: data_question['percentage_old'],
                name: 'Histórico del curso hasta la edición '+ (data_question['edition_course']-1),
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_old'],
              };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['percentage_historical'],
                name: 'Historico MOOCs español',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_historical'],
              };

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                width: 900,
                height: 600,
                };


               Plotly.newPlot('question_14', data,layout);
              }
           }
      });

      $.ajax({
           type:'GET',
           url:"{{ route('survey.initial') }}",
           data:{course_id:course_id,question:1},
           success:function(data_question){  
             console.log(data_question)                          
              var data = [{
                type: 'bar',
                y: data_question['percentage'],
                x: data_question['display_name'],
              }];

          Plotly.newPlot('question_1', data);



           }
      });

      $.ajax({
           type:'GET',
           url:"{{ route('survey.satisfaction') }}",
           data:{course_id:course_id,question:2},
           success:function(data_question){  
             console.log(data_question)                          
              var data = [{
                type: 'bar',
                x: data_question['average_question'],
                y: data_question['display_name'],
                orientation: 'h',
                marker:{color: ['#2ca02c', '#1f77b4']},
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question'],                
                
              }];

              var layout = {
                width: 900,
                height: 400,
                yaxis: {
                  automargin: true
                  }              
                };              

          Plotly.newPlot('final_question_2', data,layout);



           }
      });

      $.ajax({
           type:'GET',
           url:"{{ route('survey.mqi') }}",
           data:{course_id:course_id},
           success:function(data_question){  
             console.log(data_question)                          
              var data = [{
                type: 'bar',
                y: data_question['mqi'],
                x: ['MQI del MOOC'],
              }];

          Plotly.newPlot('satisfaction_mqi', data);



           }
      });



  });  
</script>
@endpush
