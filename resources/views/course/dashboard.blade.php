@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Courses')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">{{$report->name}}</h4>
            <h4 class="card-title "> Fecha de inicio: {{$report->start_date}}</h4>
            <h4 class="card-title "> Fecha de fin: {{$report->end_date}}</h4>
            <h4 class="card-title "> Fecha de actualización del reporte: </h4>
            <input type="hidden" id="course_id" name="course_id" value='{{$report->course_id}}'>
          </div> <!-- end card-header -->
          <div class="card-body"> 
          </div> <!-- end card-body -->
        </div> <!-- end card -->
      </div>
    </div> <!-- end row -->
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
                        <?php if($report_year[0]>0){?>
                          <?php if($versions_total>1){?>
                            <th>Año {{substr($report->start_date,0,4)}}<br> ({{$versions_total}} ediciones) </th>
                          <?php } else{?>
                            <th>Año {{substr($report->start_date,0,4)}}<br> ({{$versions_total}} edición) </th>
                          <?php }?>    
                        <?php }?>
                        
                        <?php if($report_group[0]>0){?>
                          <th>Promedio <br>ediciones anteriores</th>
                        <?php }?>
                        
                        <?php if($report_group[0]>0){?>
                          <!-- <th>Promedio todas las ediciones hasta la edición {{$report->edition}}</th> -->
                        <?php }?>                        

                        <th>Promedio histórico<br> {{$report->type}}s finalizados en {{$language}}<br> del programa IDBx*</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Registrados totales <sup>1</sup> </td>
                        <td>{{$report->registrado}}</td>

                        <?php if($report_year_total[0]>0){ ?>
                          <td>{{$report_year_total[0]}}</td>                          
                        <?php }?>

                        <?php if($report_group[0]>0){ ?>
                          <td>{{$report_group[0]}}</td>                          
                        <?php }?>

                        <?php if($report_group[0]>0){ ?>
                          <!-- <td>{{$report_group_all[0]}}</td>  -->                        
                        <?php }?>

                        <td>{{$report_type[0]}}</td>
                    </tr>
                    <tr>
                      <td>Registrados a la fecha de cierre <sup>2</sup></td>
                      <td>{{$report->in_date}}</td>

                      <?php if($report_year_total[0]>0){ ?>
                          <td>{{$report_year_total[1]}}</td>                          
                        <?php }?>

                      <?php if($report_group[0]>0){ ?>
                        <td>{{$report_group[1]}}</td>                                              
                      <?php } ?>

                      <?php if($report_group[0]>0){ ?>
                        <!-- <td>{{$report_group_all[1]}}</td> -->                                             
                      <?php } ?>

                      <td>{{$report_type[1]}}</td>
                    </tr>
                    <tr>
                      <td>Verificados a la fecha de cierre </td>
                      <td>{{$report->verified}}</td>

                      <?php if($report_year_total[0]>0){ ?>
                          <td>{{$report_year_total[6]}}</td>                          
                        <?php }?>

                      <?php if($report_group[0]>0){ ?>
                        <td>{{$report_group[6]}}</td>                                              
                      <?php } ?>

                      <?php if($report_group[0]>0){ ?>
                        <!-- <td>{{$report_group_all[1]}}</td> -->                                             
                      <?php } ?>

                      <td>{{$report_type[6]}}</td>
                    </tr>
                    <tr>
                      <td>Países representados   <sup>3</sup></td>
                      <td>{{$report->country}}</td>

                      <?php if($report_year[0]>0){ ?>
                          <td>{{$report_year[4]}}</td>                          
                        <?php }?>

                      <?php if($report_group[0]>0){ ?>
                        <td>{{$report_group[4]}}</td>                      
                      <?php }  ?>

                      <?php if($report_group[0]>0){ ?>
                        <!-- <td>{{$report_group_all[4]}}</td>  -->                    
                      <?php }  ?>

                      <td>{{$report_type[4]}}</td>
                    </tr>
                    <tr>
                      <td>Participantes<sup>4</sup><br>(% de registrados totales)</td>
                      <td>{{$report->participant}}<br>({{round(($report->participant/$report->registrado)*100,2)}}%)</td>

                      <?php if($report_year_total[0]>0){ ?>                          
                          <td>{{$report_year_total[2]}}<br>({{round(($report_year_total[2]/$report_year_total[0])*100,2)}}%)</td>                        
                        <?php }?>


                      <?php if($report_group[0]>0){ ?>
                        <td>{{$report_group[2]}}<br>({{round(($report_group[2]/$report_group[0])*100,2)}}%)</td>
                      <?php }?>
                      <?php if($report_group[0]>0){ ?>
                        <!-- <td>{{$report_group_all[2]}}<br>({{round(($report_group_all[2]/$report_group_all[0])*100,2)}}%)</td> -->
                      <?php }?>                      
                      <td>{{$report_type[2]}}<br>({{round(($report_type[2]/$report_type[0])*100,2)}}%)</td>
                    </tr>
                    <tr>
                      <td>Participantes a la fecha de cierre <sup>5</sup> <br>(% de registrados al cierre)</td>
                      <td>{{$report->in_date_participant}}<br>({{round(($report->in_date_participant/$report->in_date)*100,2)}}%)</td>

                      <?php if($report_year_total[0]>0){ ?>
                        <td>{{$report_year_total[5]}}<br>({{round(($report_year_total[5]/$report_year_total[1])*100,2)}}%)</td>
                      <?php }?>

                      <?php if($report_group[0]>0){ ?>
                        <td>{{$report_group[5]}}<br>({{round(($report_group[5]/$report_group[1])*100,2)}}%)</td>
                      <?php }?>
                      <!-- <td></td> -->
                      <td>{{$report_type[5]}}<br>({{round(($report_type[5]/$report_type[1])*100,2)}}%)</td>
                    </tr>
                    <tr>
                      <td>Certificados <sup>6</sup>  <br>(% de participantes al cierre)<br>(% de verificados)</td>
                      <td>{{$report->certificate}}<br>({{round(($report->certificate/$report->in_date_participant)*100,2)}}%)
                          <br>({{$report->verified == 0 ? 0 : round(($report->certificate/$report->verified)*100,2)}}%)</td>

                      <?php if($report_year[0]>0){ ?>
                        <td>{{$report_year_total[3]}}<br>({{$report_year_total[5] == 0 ? 0 :round(($report_year_total[3]/$report_year_total[5])*100,2)}}%)
                        <br>({{$report_year_total[6] == 0 ? 0 : round(($report_year_total[3]/$report_year_total[6])*100,2)}}%)</td>
                      <?php }?>


                      <?php if($report_group[0]>0){ ?>
                        <td>{{$report_group[3]}}<br>({{$report_group[5] == 0 ? 0 :round(($report_group[3]/$report_group[5])*100,2)}}%)
                        <br>({{$report_group[6] == 0 ? 0 : round(($report_group[3]/$report_group[6])*100,2)}}%)</td>
                        <?php }?>

                        <?php if($report_group[0]>0){ ?>
                        <!-- <td>{{$report_group_all[3]}}<br>({{round(($report_group_all[3]/$report_group_all[2])*100,2)}}%)</td> -->
                        <?php }?>


                      <td>{{$report_type[3]}}<br>({{round(($report_type[3]/$report_type[5])*100,2)}}%)
                          <br>({{$report_type[6] == 0 ? 0 : round(($report_type[3]/$report_type[6])*100,2)}}%)</td>
                    </tr>                                                                                

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4"><strong>Nota: </strong><p>Se hace la comparación con los MOOC que ya están cerrados. Con fecha de corte {{$report->end_date}}. 
                    <br>(*) Hasta {{$report->end_date}}</p></td>
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
          </div><!--end card body -->
        </div><!-- end card -->
      </div> <!-- end row-md-12 -->
    </div><!-- end row -->



    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Características de los registrados en el curso </h4>
          </div>
          <div class="card-body"> 

            <div class="row">
              <div class="col-md-12">
                <h4><strong>1.  Género con el cual los registrados se identifican</strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta inicial, pregunta 8</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4>muestra:<strong><span id="sample_question_8"> </span> </strong>participantes</h4>                
              </div>                                          
            </div>

            <div class="row justify-content-md-center">              
                <div id="question_8"></div>              
            </div>

            <br><br>

            <div class="row">
              <div class="col-md-12">
                <h4><strong>2.  Origen étnico con el cual los registrados se identifican</strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta inicial, pregunta 9</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4>muestra:<strong><span id="sample_question_9"> </span> </strong>participantes</h4>                 
              </div>                                          
            </div>

            <div class="row justify-content-md-center">              
                <div id="question_9" ></div>              
            </div>    

            <div class="row">
              <div class="col-md-12">
                <h4><strong>3.  Nivel de educación de los registrados</strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta inicial, pregunta 10</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4>muestra:<strong><span id="sample_question_10"> </span> </strong>participantes</h4>                   
              </div>                                          
            </div>

            <div class="row justify-content-md-center">              
                <div id="question_10" ></div>              
            </div>   

            <div class="row">
              <div class="col-md-12">
                <h4><strong>4.  Rango de edad de los registrados</strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta inicial, pregunta 7</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4>muestra:<strong><span id="sample_question_7"> </span> </strong>participantes</h4>                   
              </div>                                          
            </div>

            <div class="row justify-content-md-center">              
                <div id="question_7" ></div>              
            </div> 

            <div class="row">
              <div class="col-md-12">
                <h4><strong>5.  Sector o actividad a la que los participantes dedican más tiempo</strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta inicial, pregunta 11</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4>muestra:<strong><span id="sample_question_11"> </span> </strong>participantes</h4>                   
              </div>                                          
            </div>

            <div class="row justify-content-md-center">              
                <div id="question_11" ></div>              
            </div> 

            <div class="row">
              <div class="col-md-12">
                <h4><strong>
                  6.  Presencia de discapacidad visual, auditiva o motora que limite al participante a aprovechar los contenidos del curso 
                </strong></h4>                
              </div>              

              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta inicial, pregunta 14</strong></h4>                
              </div> 

              <div class="col-md-12">
                <h4>muestra:<strong><span id="sample_question_14"> </span> </strong>participantes</h4>                   
              </div>                                          
            </div>

            <div class="row justify-content-md-center">              
                <div id="question_14" ></div>              
            </div>  

            <div class="row">
              <div class="col-md-12">
                <h4><strong>
                  7. Los 10 países de Latinoamérica y el Caribe con mayor registro de usuarios 
                </strong></h4>                
              </div>              

              <div class="col-md-12">
                <h4><strong>Fuente: IDBx Dashboard</strong></h4>                
              </div> 

              <div class="col-md-12">
                <h4>muestra:<strong>{{$report->registrado}} </strong>registros</h4>                   
              </div>                                          
            </div>
            <div class="row justify-content-md-center">              
                <div id="course_country" ></div>              
            </div>

            <div class="row">
              <div class="col-md-12">
                <h4><strong>
                  8.Primeros 10 países con mayor registro de usuarios como proporción en relación con la Población Económicamente Activa (PEA) por cada 100,000 habitantes 
                </strong></h4>                
              </div>              

              <div class="col-md-12">
                <h4><strong>Fuente: IDBx Dashboard</strong></h4>                
              </div> 

              <div class="col-md-12">
                <h4>muestra:<strong>{{$report->registrado}} </strong>registros</h4>                   
              </div>                                          
            </div>
            <div class="row justify-content-md-center">              
                <div id="course_country_pea" ></div>              
            </div>


          </div>
        </div>
      </div> <!-- end row md-12 -->
    </div> <!--end row -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Evaluación del curso y sus contenidos por parte de los participantes </h4>            
          </div> <!-- end card header -->
          <div class="card-body"> 
            <div class="row">
              <div class="col-md-12">
                <h4><strong>1.  Intención de los participantes al registrarse en el curso (%)</strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta inicial, pregunta 1</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4>muestra:<strong><span id="sample_question_1"> </span> </strong>participantes</h4>                   
              </div>            
            </div> <!-- end row -->
            <div class="row justify-content-md-center">              
              <div id="question_1"></div>              
            </div> <!-- end row -->
            <div class="row">
              <div class="col-md-12">
                <h4><strong>2.  Ganancia de aprendizaje (conocimiento sobre los temas tratados en el curso antes y después del curso) </strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta final de satisfacción, Pregunta 2</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4>muestra:<strong><span id="sample_final_question_2"> </span> </strong>participantes</h4>                
              </div>                                          
            </div> <!-- end row -->
            <div class="row justify-content-md-center">              
              <div id="final_question_2" ></div>              
            </div><!-- end row -->           
            <div class="row">
              <div class="col-md-12">
                <p>•  La ganancia de aprendizaje de este MOOC, por parte de los participantes, es de <strong><span id='ganancia_individual'></span></strong>  puntos.</p>
                <p>•  La ganancia de aprendizaje promedio para todos los MOOC, por parte de los participantes, es de <strong><span id='ganancia_individual_historical'></span>  puntos.<p>
              </div>
            </div> <!-- end row -->
            <div class="row justify-content-md-center">              
              <div id="final_question_ganancia" ></div>              
            </div>
            <div class="row">
              <div class="col-md-12">
                <h4><strong>3. Promedio de logro de objetivos de aprendizaje, comparado con promedio general de los MOOC </strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta final de satisfacción, pregunta 1.1</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4>muestra:<strong><span id="sample_final_question_1"> </span> </strong>participantes</h4>                
              </div>
              <div class="col-md-12">
                <p>Rating:</p>
                <p>-  Entre 5 y 4,5 = Excelente.</p>
                <p>-  Entre 4,5 y 4,0 = Adecuado.</p>
                <p>-  Entre 4,0 y 3,0 = Deficiente. Revisar curso y tomar medidas.</p>
                <p>-  Entre 3,0 y 0 = Muy deficiente. Revisar el curso con urgencia y tomar medidas.</p>
              </div>                                                          
            </div> <!-- end row -->              
            <div class="row justify-content-md-center">              
              <div id="final_question_1" ></div>              
            </div>   

            <div class="row">
              <div class="col-md-12">
                <h4><strong>4a. Calidad de los contenidos del curso en general, comparado con el promedio general de los MOOC  </strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta final de satisfacción, pregunta 3</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4>muestra:<strong><span id="sample_final_question_3_a"> </span> </strong>participantes</h4>                
              </div>
              <div class="col-md-12">
                <p>Rating:</p>
                <p>-  Entre 5 y 4,5 = Excelente.</p>
                <p>-  Entre 4,5 y 4,0 = Adecuado.</p>
                <p>-  Entre 4,0 y 3,0 = Deficiente. Revisar curso y tomar medidas.</p>
                <p>-  Entre 3,0 y 0 = Muy deficiente. Revisar el curso con urgencia y tomar medidas.</p>
              </div>                                                          
            </div>              
            <div class="row justify-content-md-center">              
              <div id="final_question_3_a" ></div>              
            </div>
            <div class="row">
              <div class="col-md-12">
                <h4><strong>4b. Calidad de los contenidos del curso , por tipo de contenido  </strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta final de satisfacción, Pregunta 3</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4>muestra:<strong><span id="sample_final_question_3_b"> </span> </strong>participantes</h4>                
              </div>
              <div class="col-md-12">
                <p>Rating:</p>
                <p>-  Entre 5 y 4,5 = Excelente.</p>
                <p>-  Entre 4,5 y 4,0 = Adecuado.</p>
                <p>-  Entre 4,0 y 3,0 = Deficiente. Revisar curso y tomar medidas.</p>
                <p>-  Entre 3,0 y 0 = Muy deficiente. Revisar el curso con urgencia y tomar medidas.</p>
              </div>                                                          
            </div>              
            <div class="row justify-content-md-center">              
              <div id="final_question_3_b" ></div>              
            </div> 

            <div class="row">
              <div class="col-md-12">
                <h4><strong>5.  Calidad de los recursos de aprendizaje del curso (videos, lecturas, evaluaciones formativas y cuestionarios de evaluación calificados)  </strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta final de satisfacción, pregunta 4</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4>muestra:<strong><span id="sample_final_question_4"> </span> </strong>participantes</h4>                
              </div>
              <div class="col-md-12">
                <p>Rating:</p>
                <p>-  Entre 5 y 4,5 = Excelente.</p>
                <p>-  Entre 4,5 y 4,0 = Adecuado.</p>
                <p>-  Entre 4,0 y 3,0 = Deficiente. Revisar curso y tomar medidas.</p>
                <p>-  Entre 3,0 y 0 = Muy deficiente. Revisar el curso con urgencia y tomar medidas.</p>
              </div>                                                          
            </div>
            <div class="row justify-content-md-center">              
              <div id="final_question_4" ></div>              
            </div> 
            <div class="row">
              <div class="col-md-12">
                <p>•  El promedio de la calidad de los recursos del curso de {{$report->name}} es de <strong><span id='calidad_individual'></span> puntos</strong> de un máximo de 5.</p>
                <p>•  El promedio histórico de la calidad de todos los recursos de todos los MOOC es de  <strong><span id='calidad_individual_historical'></span> puntos </strong>de un máximo de 5.<p>
              </div>
            </div> <!-- end row -->

            <div class="row">
              <div class="col-md-12">
                <h4><strong>6.  Utilidad del curso en general  </strong></h4>                
              </div>              
              <div class="col-md-12">
                <h4><strong>Fuente: Encuesta final de satisfacción, Pregunta 5</strong></h4>                
              </div> 
              <div class="col-md-12">
                <h4>muestra:<strong><span id="sample_final_question_5"> </span> </strong>participantes</h4>                
              </div>
              <div class="col-md-12">
                <p>Rating:</p>
                <p>-  Entre 5 y 4,5 = Excelente.</p>
                <p>-  Entre 4,5 y 4,0 = Adecuado.</p>
                <p>-  Entre 4,0 y 3,0 = Deficiente. Revisar curso y tomar medidas.</p>
                <p>-  Entre 3,0 y 0 = Muy deficiente. Revisar el curso con urgencia y tomar medidas.</p>
              </div>                                                          
            </div>                            
            <div class="row justify-content-md-center">              
              <div id="final_question_5" ></div>              
            </div>  
            <div class="row">
                <div class="col-md-12">
                  <h4><strong>7.  Índice de calidad del MOOC (MQI)  </strong></h4>                
                </div>              
                <div class="col-md-12">
                    <p>Rating:</p>
                    <p>-  Entre 5 y 4,5 = Excelente.</p>
                    <p>-  Entre 4,5 y 4,0 = Adecuado.</p>
                    <p>-  Entre 4,0 y 3,0 = Deficiente. Revisar curso y tomar medidas.</p>
                    <p>-  Entre 3,0 y 0 = Muy deficiente. Revisar el curso con urgencia y tomar medidas.</p>

                </div>                                          
              </div>
              <div class="row justify-content-md-center">              
                  <div id="satisfaction_mqi" ></div>              
              </div>                                              


          </div> <!--end card body -->
          
        </div> <!-- end card -->
      </div> <!-- end row md-12 -->
    </div> <!-- end row -->
  </div> <!-- end container-fluid -->
</div> <!-- end content -->
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
              $("#sample_question_8").html(data_question['sample_survey']);
              if(data_question['old_data']==0){
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['percentage'],
                name: 'Edición seleccionada:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage'],
                };

                var trace2 = {
                x: data_question['display_name_historical'],
                y: data_question['percentage_historical'],
                name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_historical'],
                };

                var trace3 = {
                x: data_question['display_name_year'],
                y: data_question['percentage_year'],
                name: 'Promedio (%) de las ediciones del '+ (data_question['year_course']) + '<br> incluye la edición seleccionada',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_historical'],
                };              

                var data = [trace1, trace2, trace3];

                var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  }           
                };


               Plotly.newPlot('question_8', data,layout);
              } else{
                var trace1 = {
                  x: data_question['display_name'],
                  y: data_question['percentage'],
                  name: 'Edición seleccionada:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage'],
                };

                var trace2 = {
                  x: data_question['display_name_old'],
                  y: data_question['percentage_old'],
                  name: 'Promedio (%) histórico del curso hasta la edición '+ (data_question['edition_course']-1) +'<br> desde la primera versión del curso',
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage_old'],
                };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['percentage_historical'],
                name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_historical'],
              };
              var trace4 = {
                x: data_question['display_name_year'],
                y: data_question['percentage_year'],
                name: 'Promedio (%) de las ediciones del '+ (data_question['year_course']) + '<br> incluye la edición seleccionada',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_year'],
              };  


              var data = [trace1,trace4,trace2, trace3 ];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  }           
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
                $("#sample_question_9").html(data_question['sample_survey']);
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: data_question['display_name'],
                  y: data_question['percentage'],
                  name: 'Edición seleccionada:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage'],
                };

                var trace2 = {
                  x: data_question['display_name_historical'],
                  y: data_question['percentage_historical'],
                  name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage_historical'],
                };

                var trace3 = {
                x: data_question['display_name_year'],
                y: data_question['percentage_year'],
                name: 'Promedio (%) de las ediciones del '+ (data_question['year_course']) + '<br> incluye la edición seleccionada',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_year'],
              };  

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  }           
                };


               Plotly.newPlot('question_9', data,layout);
              } else{
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['percentage'],
                name: 'Edición seleccionada:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage'],
              };

              var trace2 = {
                x: data_question['display_name_old'],
                y: data_question['percentage_old'],
                name: 'Promedio (%) histórico del curso hasta la edición '+ (data_question['edition_course']-1) +'<br> desde la primera versión del curso',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_old'],
              };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['percentage_historical'],
                name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_historical'],
              };

              var trace4 = {
                x: data_question['display_name_year'],
                y: data_question['percentage_year'],
                name: 'Promedio (%) de las ediciones del '+ (data_question['year_course']) + '<br> incluye la edición seleccionada',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_year'],
              };  

              var data = [trace1,trace4, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  }           
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
                $("#sample_question_10").html(data_question['sample_survey']);
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: data_question['display_name'],
                  y: data_question['percentage'],
                  name: 'Edición seleccionada:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage'],
                };

                var trace2 = {
                  x: data_question['display_name_historical'],
                  y: data_question['percentage_historical'],
                  name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage_historical'],
                };

                var trace3 = {
                x: data_question['display_name_year'],
                y: data_question['percentage_year'],
                name: 'Promedio (%) de las ediciones del '+ (data_question['year_course']) + '<br> incluye la edición seleccionada',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_year'],
              }; 

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  }           
                };


               Plotly.newPlot('question_10', data,layout);
              } else{
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['percentage'],
                name: 'Edición seleccionada:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage'],
              };

              var trace2 = {
                x: data_question['display_name_old'],
                y: data_question['percentage_old'],
                name: 'Promedio (%) histórico del curso hasta la edición '+ (data_question['edition_course']-1) +'<br> desde la primera versión del curso',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_old'],
              };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['percentage_historical'],
                name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_historical'],
              };

              var trace4 = {
                x: data_question['display_name_year'],
                y: data_question['percentage_year'],
                name: 'Promedio (%) de las ediciones del '+ (data_question['year_course']) + '<br> incluye la edición seleccionada',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_year'],
              }; 

              var data = [trace1,trace4, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  }           
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
                $("#sample_question_7").html(data_question['sample_survey']);             
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: data_question['display_name'],
                  y: data_question['percentage'],
                  name: 'Edición seleccionada:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage'],
                  };

                var trace2 = {
                  x: data_question['display_name_historical'],
                  y: data_question['percentage_historical'],
                  name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage_historical'],
                  };

                var trace3 = {
                x: data_question['display_name_year'],
                y: data_question['percentage_year'],
                name: 'Promedio (%) de las ediciones del '+ (data_question['year_course']) + '<br> incluye la edición seleccionada',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_year'],
              }; 

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  }           
                };


               Plotly.newPlot('question_7', data,layout);
              } else{
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['percentage'],
                name: 'Edición seleccionada:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage'],
              };

              var trace2 = {
                x: data_question['display_name_old'],
                y: data_question['percentage_old'],
                name: 'Promedio (%) histórico del curso hasta la edición '+ (data_question['edition_course']-1) +'<br> desde la primera versión del curso',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_old'],
              };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['percentage_historical'],
                name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_historical'],
              };

              var trace4 = {
                x: data_question['display_name_year'],
                y: data_question['percentage_year'],
                name: 'Promedio (%) de las ediciones del '+ (data_question['year_course']) + '<br> incluye la edición seleccionada',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_year'],
              }; 

              var data = [trace1,trace4, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  }           
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
                $("#sample_question_11").html(data_question['sample_survey']);        
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: data_question['display_name'],
                  y: data_question['percentage'],
                  name: 'Edición seleccionada:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage'],
                };

                var trace2 = {
                  x: data_question['display_name_historical'],
                  y: data_question['percentage_historical'],
                  name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage_historical'],
                };

                var trace3 = {
                x: data_question['display_name_year'],
                y: data_question['percentage_year'],
                name: 'Promedio (%) de las ediciones del '+ (data_question['year_course']) + '<br> incluye la edición seleccionada',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_year'],
              }; 

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  }           
                };


               Plotly.newPlot('question_11', data,layout);
              } else{
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['percentage'],
                name: 'Edición seleccionada:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage'],
              };

              var trace2 = {
                x: data_question['display_name_old'],
                y: data_question['percentage_old'],
                name: 'Promedio (%) histórico del curso hasta la edición '+ (data_question['edition_course']-1) +'<br> desde la primera versión del curso',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_old'],
              };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['percentage_historical'],
                name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_historical'],
              };

              var trace4 = {
                x: data_question['display_name_year'],
                y: data_question['percentage_year'],
                name: 'Promedio (%) de las ediciones del '+ (data_question['year_course']) + '<br> incluye la edición seleccionada',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_year'],
              }; 

              var data = [trace1,trace4, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  }           
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
                $("#sample_question_14").html(data_question['sample_survey']);       
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: data_question['display_name'],
                  y: data_question['percentage'],
                  name: 'Edición seleccionada:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage'],
                };

                var trace2 = {
                  x: data_question['display_name_historical'],
                  y: data_question['percentage_historical'],
                  name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['percentage_historical'],
                };

                var trace3 = {
                x: data_question['display_name_year'],
                y: data_question['percentage_year'],
                name: 'Promedio (%) de las ediciones del '+ (data_question['year_course']) + '<br> incluye la edición seleccionada',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_year'],
              }; 

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  }           
                };


               Plotly.newPlot('question_14', data,layout);
              } else{
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['percentage'],
                name: 'Edición seleccionada:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage'],
              };

              var trace2 = {
                x: data_question['display_name_old'],
                y: data_question['percentage_old'],
                name: 'Promedio (%) histórico del curso hasta la edición '+ (data_question['edition_course']-1) +'<br> desde la primera versión del curso',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_old'],
              };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['percentage_historical'],
                name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_historical'],
              };

              var trace4 = {
                x: data_question['display_name_year'],
                y: data_question['percentage_year'],
                name: 'Promedio (%) de las ediciones del '+ (data_question['year_course']) + '<br> incluye la edición seleccionada',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage_year'],
              }; 

              var data = [trace1,trace4, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  }           
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
             $("#sample_question_1").html(data_question['sample_survey']);
             console.log(data_question)                          
              var data = [{
                type: 'bar',
                y: data_question['percentage'],
                x: data_question['display_name'],
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['percentage'],
              }];
              var layout = {              
                width: 1200,
                height: 600,
                xaxis: {
                  automargin: true
                  }              
              };

          Plotly.newPlot('question_1', data,layout);



           }
      });

      $.ajax({
           type:'GET',
           url:"{{ route('survey.satisfaction') }}",
           data:{course_id:course_id,question:2},
           success:function(data_question){  
              $("#sample_final_question_2").html(data_question['sample_survey']);                         
              var data = [{
                type: 'bar',
                x: data_question['average_question'],
                y: data_question['display_name'],
                orientation: 'h',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question'],                
                
              }];

              var layout = {
                width: 900,
                height: 400,
                yaxis: {
                  automargin: true
                  },
                xaxis: {
                  automargin: false,
                  range: [0, 10]
                  }              
                };              

          Plotly.newPlot('final_question_2', data,layout);



           }
      });
      

      $.ajax({
           type:'GET',
           url:"{{ route('survey.individual_ganancia') }}",
           data:{course_id:course_id,question:'2,1'},
           success:function(data_question){    
                $("#ganancia_individual").html(data_question['total_gain']); 
                $("#ganancia_individual_historical").html(data_question['total_gain_historical']);          
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: ['Ganancia de aprendizaje'],
                  y: data_question['average_question'],
                  name: 'Edición seleccionada:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['average_question'],
                };

                var trace2 = {
                  x: ['Ganancia de aprendizaje'],
                  y: data_question['average_question_historical'],
                  name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['average_question_historical'],
                };

              var data = [trace1, trace2];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 700,
                height: 600,
                xaxis: {
                  automargin: false
                  },
                  yaxis: {
                  range: [0,10],
                  automargin: false

                },               
                };


               Plotly.newPlot('final_question_ganancia', data,layout);
              } else{
                var trace1 = {
                x: ['Ganancia de aprendizaje'],
                y: data_question['average_question'],
                name: 'Edición seleccionada:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question'],
              };

              var trace2 = {
                x: ['Ganancia de aprendizaje'],
                y: data_question['average_question_old'],
                name: 'Promedio (%) histórico del curso hasta la edición '+ (data_question['edition_course']-1) +'<br> desde la primera versión del curso',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question_old'],
              };

              var trace3 = {
                x: ['Ganancia de aprendizaje'],
                y: data_question['average_question_historical'],
                name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question_historical'],
              };

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 700,
                height: 600,
                xaxis: {
                  automargin: false
                  },
                yaxis: {
                  range: [0,10],
                  automargin: false

                },             
                };


               Plotly.newPlot('final_question_ganancia', data,layout);
              }
           }
      });

      $.ajax({
           type:'GET',
           url:"{{ route('survey.individual_promedio') }}",
           data:{course_id:course_id,question:'1,1'},
           success:function(data_question){        
                $("#sample_final_question_1").html(data_question['sample_survey']);       
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: data_question['display_name'],
                  y: data_question['average_question'],
                  name: 'Edición:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['average_question'],
                };

                var trace2 = {
                  x: data_question['display_name_historical'],
                  y: data_question['average_question_historical'],
                  name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['average_question_historical'],
                };

              var data = [trace1, trace2];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 900,
                height: 800,
                xaxis: {
                  automargin: false
                  },
                yaxis: {
                  automargin: false,
                  range: [0, 5]
                  }              
                };


               Plotly.newPlot('final_question_1', data,layout);
              } else{
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['average_question'],
                name: 'Edición seleccionada:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question'],
              };

              var trace2 = {
                x: data_question['display_name_old'],
                y: data_question['average_question_old'],
                name: 'Promedio (%) histórico del curso hasta la edición '+ (data_question['edition_course']-1) +'<br> desde la primera versión del curso',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question_old'],
              };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['average_question_historical'],
                name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question_historical'],
              };

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 900,
                height: 800,
                xaxis: {
                  automargin: false
                  },
                yaxis: {
                  automargin: false,
                  range: [0,5]
                  }               
                };


               Plotly.newPlot('final_question_1', data,layout);
              }
           }
      });




      $.ajax({
           type:'GET',
           url:"{{ route('survey.individual') }}",
           data:{course_id:course_id,question:'3,1'},
           success:function(data_question){        
                $("#sample_final_question_3_a").html(data_question['sample_survey']);       
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: ['Calidad de los recursos de aprendizaje de este MOOC'],
                  y: data_question['average_question'],
                  name: 'Edición seleccionada:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['average_question'],
                };

                var trace2 = {
                  x: ['Calidad de los recursos de aprendizaje de este MOOC'],
                  y: data_question['average_question_historical'],
                  name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['average_question_historical'],
                };

              var data = [trace1, trace2];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 900,
                height: 800,
                xaxis: {
                  automargin: false
                  },
                yaxis: {
                  range: [0,5],
                  automargin: false

                },               
                };


               Plotly.newPlot('final_question_3_a', data,layout);
              } else{
                var trace1 = {
                x: ['Calidad de los recursos de aprendizaje de este MOOC'],
                y: data_question['average_question'],
                name: 'Edición seleccionada:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question'],
              };

              var trace2 = {
                x: ['Calidad de los recursos de aprendizaje de este MOOC'],
                y: data_question['average_question_old'],
                name: 'Histórico del curso hasta la edición '+ (data_question['edition_course']-1),
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question_old'],
              };

              var trace3 = {
                x: ['Calidad de los recursos de aprendizaje de este MOOC'],
                y: data_question['average_question_historical'],
                name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question_historical'],
              };

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 900,
                height: 800,
                xaxis: {
                  automargin: false
                  },
                yaxis: {
                  range: [0,5],
                  automargin: false

                },              
                };


               Plotly.newPlot('final_question_3_a', data,layout);
              }
           }
      });





      $.ajax({
           type:'GET',
           url:"{{ route('survey.satisfaction') }}",
           data:{course_id:course_id,question:3},
           success:function(data_question){        
                $("#sample_final_question_3_b").html(data_question['sample_survey']);       
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: data_question['display_name'],
                  y: data_question['average_question'],
                  name: 'Edición seleccionada:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['average_question'],
                };

                var trace2 = {
                  x: data_question['display_name_historical'],
                  y: data_question['average_question_historical'],
                  name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['average_question_historical'],
                };

              var data = [trace1, trace2];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  },
                yaxis: {
                  automargin: false,
                  range: [0,5]
                  }            
                };


               Plotly.newPlot('final_question_3_b', data,layout);
              } else{
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['average_question'],
                name: 'Edición seleccionada:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question'],
              };

              var trace2 = {
                x: data_question['display_name_old'],
                y: data_question['average_question_old'],
                name: 'Promedio (%) histórico del curso hasta la edición '+ (data_question['edition_course']-1) +'<br> desde la primera versión del curso',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question_old'],
              };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['average_question_historical'],
                name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question_historical'],
              };

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  },
                yaxis: {
                  automargin: false,
                  range: [0,5]
                  }            
                };


               Plotly.newPlot('final_question_3_b', data,layout);
              }
           }
      });



      $.ajax({
           type:'GET',
           url:"{{ route('survey.satisfaction') }}",
           data:{course_id:course_id,question:4},
           success:function(data_question){        
                $("#sample_final_question_4").html(data_question['sample_survey']);       
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: data_question['display_name'],
                  y: data_question['average_question'],
                  name: 'Edición seleccionada:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['average_question'],
                };

                var trace2 = {
                  x: data_question['display_name_historical'],
                  y: data_question['average_question_historical'],
                  name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['average_question_historical'],
                };

              var data = [trace1, trace2];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  },
                yaxis: {
                  automargin: false,
                  range: [0,5]
                  }             
                };


               Plotly.newPlot('final_question_4', data,layout);
              } else{
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['average_question'],
                name: 'Edición seleccionada:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question'],
              };

              var trace2 = {
                x: data_question['display_name_old'],
                y: data_question['average_question_old'],
                name: 'Promedio (%) histórico del curso hasta la edición '+ (data_question['edition_course']-1) +'<br> desde la primera versión del curso',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question_old'],
              };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['average_question_historical'],
                name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question_historical'],
              };

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 1200,
                height: 800,
                xaxis: {
                  automargin: false
                  },
                yaxis: {
                  automargin: false,
                  range: [0,5]
                  }              
                };


               Plotly.newPlot('final_question_4', data,layout);
              }
           }
      });



      $.ajax({
           type:'GET',
           url:"{{ route('survey.satisfaction') }}",
           data:{course_id:course_id,question:5},
           success:function(data_question){        
                $("#sample_final_question_5").html(data_question['sample_survey']);       
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: data_question['display_name'],
                  y: data_question['average_question'],
                  name: 'Edición seleccionada:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['average_question'],
                };

                var trace2 = {
                  x: data_question['display_name_historical'],
                  y: data_question['average_question_historical'],
                  name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['average_question_historical'],
                };

              var data = [trace1, trace2];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 900,
                height: 800,
                xaxis: {
                  automargin: false
                  },
                yaxis: {
                  automargin: false,
                  range: [0,5]
                  }             
                };


               Plotly.newPlot('final_question_5', data,layout);
              } else{
                var trace1 = {
                x: data_question['display_name'],
                y: data_question['average_question'],
                name: 'Edición seleccionada:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question'],
              };

              var trace2 = {
                x: data_question['display_name_old'],
                y: data_question['average_question_old'],
                name: 'Promedio (%) histórico del curso hasta la edición '+ (data_question['edition_course']-1) +'<br> desde la primera versión del curso',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question_old'],
              };

              var trace3 = {
                x: data_question['display_name_historical'],
                y: data_question['average_question_historical'],
                name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question_historical'],
              };

              var data = [trace1, trace2, trace3];

              var layout = {
                barmode: 'group',
                margin: {
                  l: 40,
                  r: 120,
                  b: 260,
                  t: 20,
                  pad: 5
                },                 
                width: 900,
                height: 800,
                xaxis: {
                  automargin: false
                  },
                yaxis: {
                  automargin: false,
                  range: [0,5]
                  }              
                };


               Plotly.newPlot('final_question_5', data,layout);
              }
           }
      });





      $.ajax({
           type:'GET',
           url:"{{ route('survey.mqi') }}",
           data:{course_id:course_id},
           success:function(data_question){             
                if(data_question['old_data']==0){
                  var trace1 = {
                  x: ['MQI'],
                  y: data_question['mqi'],
                  name: 'Edición seleccionada:'+data_question['edition_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['mqi'],
                  };

                var trace2 = {
                  x: ['MQI'],
                  y: data_question['mqi_old'],
                  name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['mqi_old'],
                  };

                  var trace3 = {
                  x: ['MQI'],
                  y: data_question['mqi_year'],
                  name: 'Promedio (%) de las ediciones del '+ (data_question['year_course']) + '<br> incluye la edición seleccionada',
                  type: 'bar',
                  hoverinfo: 'none',
                  textposition: 'auto',
                  text: data_question['mqi_old'],
                  };                  

              var data = [trace1,trace3, trace2];

              var layout = {
                barmode: 'group',
                width: 900,
                height: 600,
                yaxis: {
                  automargin: false,
                  range: [0,5]
                  }
                };


               Plotly.newPlot('satisfaction_mqi', data,layout);
              } else{
                var trace1 = {
                x: ['MQI'],
                y: data_question['mqi'],
                name: 'Edición seleccionada:'+data_question['edition_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['mqi'],
              };

              var trace2 = {
                x: ['MQI'],
                y: data_question['mqi_group'],
                name: 'Promedio (%) histórico del curso hasta la edición '+ (data_question['edition_course']-1) +'<br> desde la primera versión del curso',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['mqi_group'],
              };

              var trace3 = {
                x: ['MQI'],
                y: data_question['mqi_old'],
                name: 'Promedio (%) historico de todos los MOOCs <br> en ' + data_question['language_course'] ,
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['mqi_old'],
              };

              var trace4 = {
                x: ['MQI'],
                y: data_question['mqi_year'],
                name: 'Promedio (%) de las ediciones del '+ (data_question['year_course']) + '<br> incluye la edición seleccionada',
                type: 'bar',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['mqi_year'],
              };

              var data = [trace1, trace4, trace2, trace3];

              var layout = {
                barmode: 'group',
                width: 900,
                height: 600,
                yaxis: {
                  automargin: false,
                  range: [0,5]
                  }
                };


               Plotly.newPlot('satisfaction_mqi', data,layout);
              }
           }
      });

      $.ajax({
           type:'GET',
           url:"{{ route('course.countries') }}",
           data:{course_id:course_id},
           success:function(data_question){                        
              var data = [{
                type: 'bar',
                x: data_question['average_question'],
                y: data_question['display_name'],
                orientation: 'h',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question'], 
                textfont: {
                  color: 'rgb(255, 255, 255)'
                },
                transforms: [{
                  type: 'sort',
                  target: 'y',
                  order: 'descending'
                }]               
                
              }];

              var layout = {
                width: 800,
                height: 500,
                yaxis: {
                  automargin: true
                  }
                          
                };              

          Plotly.newPlot('course_country', data,layout);



           }
      });

      $.ajax({
           type:'GET',
           url:"{{ route('course.pea') }}",
           data:{course_id:course_id},
           success:function(data_question){                        
              var data = [{
                type: 'bar',
                x: data_question['average_question'],
                y: data_question['display_name'],
                orientation: 'h',
                hoverinfo: 'none',
                textposition: 'auto',
                text: data_question['average_question'], 
                textfont: {
                  color: 'rgb(255, 255, 255)'
                },
                transforms: [{
                  type: 'sort',
                  target: 'y',
                  order: 'descending'
                }]               
                
              }];

              var layout = {
                width: 800,
                height: 500,
                yaxis: {
                  automargin: true
                  }
                          
                };              

          Plotly.newPlot('course_country_pea', data,layout);



           }
      });


  });  
</script>
@endpush
