<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Course;
use App\Report;



class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search =  $request->input('q');
        #dd($search);
        if($search!=""){
            $courses=Course::where('name', 'ilike', '%'.trim($search).'%')->orderBy('name', 'asc')->paginate(40);
            #dd($courses);

        }
        else{
            $courses = Course::paginate(40);
        }
        return View('course.index')->with('data',$courses);
    }

    public function dashboard($id)
    {
        $versions_total=1;
        $report=Report::where('course_id','=',$id)->firstOrFail();

        #dd(substr($report->start_date,0,4));
        $report_all = Report::where('group_name','=',trim($report->group_name))->where( DB::raw('EXTRACT(YEAR FROM start_date)'), '=', substr($report->start_date,0,4))->where('start_date','<=',$report->start_date)->where('type','=',trim($report->type))->where('olp','=',trim($report->olp))->get();
        $versions_total = $report_all->count();
        $registered=round($report_all->avg('registrado'));
        $registered_total=round($report_all->sum('registrado'));
        $registered_in_date=round($report_all->avg('in_date'));
        $registered_in_date_total=round($report_all->sum('in_date'));
        $participant_in_date=round($report_all->avg('in_date_participant'));
        $participant_in_date_total=round($report_all->sum('in_date_participant'));
        $participants=round($report_all->avg('participant'));
        $participants_total=round($report_all->sum('participant'));
        $verified=round($report_all->avg('verified'));
        $verified_total=round($report_all->sum('verified'));
        $certificates=round($report_all->avg('certificate'));
        $certificates_total=round($report_all->sum('certificate'));
        $countries=round($report_all->avg('country'));
        $report_year = array($registered, $registered_in_date,$participants,$certificates,$countries,$participant_in_date,$verified);
        $report_year_total = array($registered_total, $registered_in_date_total,$participants_total,$certificates_total,$countries,$participant_in_date_total,$verified_total);


        $registered=0;
        $registered_in_date=0;
        $participant_in_date=0;
        $participants=0;
        $certificates=0;
        $verified=0;
        $report_all = Report::where('group_name','=',trim($report->group_name))->where('end_date',"<",$report->start_date)->where('type','=',trim($report->type))->where('olp','=',trim($report->olp))->get();

        $registered=round($report_all->avg('registrado'));
        $registered_in_date=round($report_all->avg('in_date'));
        $participant_in_date=round($report_all->avg('in_date_participant'));
        $participants=round($report_all->avg('participant'));
        $verified=round($report_all->avg('verified'));
        $certificates=round($report_all->avg('certificate'));

        /*
        $registered_total=round($report_all->sum('registrado'));
        $registered_in_date_total=round($report_all->sum('in_date'));
        $participant_in_date_total=round($report_all->sum('in_date_participant'));
        $participants_total=round($report_all->sum('participant'));
        $verified_total=round($report_all->sum('verified'));
        $certificates_total=round($report_all->sum('certificate'));
        */

        $countries=round($report_all->avg('country'));
        $report_group = array($registered, $registered_in_date,$participants,$certificates,$countries,$participant_in_date,$verified);
        #$report_group_total = array($registered_total, $registered_in_date_total,$participants_total,$certificates_total,$countries,$participant_in_date_total,$verified_total);
        $registered=0;
        $registered_in_date=0;
        $participant_in_date=0;
        $participants=0;
        $certificates=0;
        $verified=0;
        $report_type = Report::where('type','=',$report->type)->where('language','=',$report->language)->where('end_date',"<=",$report->end_date)->where('olp','=',trim($report->olp))->get();
        $registered=round($report_type->avg('registrado'));
        $registered_in_date=round($report_type->avg('in_date'));
        $participant_in_date=round($report_type->avg('in_date_participant'));
        $participants=round($report_type->avg('participant'));
        $verified=round($report_type->avg('verified'));
        $certificates=round($report_type->avg('certificate'));
        $countries=round($report_type->avg('country'));
        $report_type = array($registered, $registered_in_date,$participants,$certificates,$countries,$participant_in_date,$verified);

        $registered=0;
        $registered_in_date=0;
        $participants=0;
        $certificates=0;
        $report_all = Report::where('group_name','=',trim($report->group_name))->where('end_date',"<=",$report->end_date)->where('type','=',trim($report->type))->where('olp','=',trim($report->olp))->get();
        $registered=round($report_all->avg('registrado'));
        $registered_in_date=round($report_all->avg('in_date'));
        $participant_in_date=round($report_all->avg('in_date_participant'));
        $participants=round($report_all->avg('participant'));
        $certificates=round($report_all->avg('certificate'));
        $countries=round($report_all->avg('country'));
        $report_group_all = array($registered, $registered_in_date,$participants,$certificates,$countries,$participant_in_date);
        #dd($registrados);
        switch ($report->language) {
            case "es":
              $language = "espa??ol";
              break;
            case "en":
                $language = "ingl??s";
              break;
            case "pt":
                $language = "portugu??s";
              break;
            case "fr":
                $language = "franc??s";
            break;
          }
        return view('course.dashboard', compact('report','report_group','report_type','report_group_all','report_year','report_year_total','language','versions_total'));
    }



    public function surveyMqi(Request $request)
    {

        $sql="select * from metadata_courses where  studio_id_1='".$request->get('course_id')."'";
        $course = DB::connection('pgsql')->select($sql);
        $course_collection=collect($course);
        $start_date=$course_collection->first()->start_date;
        $language_course=$course_collection->first()->language;
        $type_course=$course_collection->first()->type;
        $olp=$course_collection->first()->olp;
        $time = strtotime($start_date);
        $year_course = date('Y',$time);



        switch ($language_course) {
            case "es":
              $language_course = "espa??ol";
              break;
            case "en":
                $language_course = "ingl??s";
              break;
            case "pt":
                $language_course = "portugu??s";
              break;
            case "fr":
                $language_course = "franc??s";
            break;
          }


        /*
        $report=Report::where('course_id','=',$request->get('course_id'))->firstOrFail();
        $mqi_data=[];
        array_push($mqi_data,$report->mqi);
        */

        $old_data= 0;
        $year_data= 0;
        $mqi_data_group=[];
        $mqi_data_year=[];
        $sql="select * from control_panel_course_report_mqi where  course_id='".$request->get('course_id')."'";
        $course = DB::connection('pgsql')->select($sql);
        $course_collection=collect($course);
        $mqi_course=$course_collection->first()->mqi;
        $edition_course=$course_collection->first()->edition;
        $mqi_data=[];
        array_push($mqi_data,round($mqi_course,2));

        $sql="select * from metadata_courses
        where \"Course_Name_AllEditions\"=(select \"Course_Name_AllEditions\" from metadata_courses
        where studio_id_1='".$request->get('course_id')."')
        and start_date < (select start_date from metadata_courses
        where studio_id_1='".$request->get('course_id')."')";
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);

        if($answers_collection->count()>0){
            $old_data= 1;
            $sql="select avg(CAST(m.mqi AS FLOAT)) as average_group from control_panel_course_report_mqi as m
            INNER JOIN metadata_courses c on(m.id=c.id)
            where
            c.\"Course_Name_AllEditions\" =
            (select \"Course_Name_AllEditions\" from metadata_courses where studio_id_1='".$request->get('course_id')."')
             and c.start_date <
             (select start_date from metadata_courses where studio_id_1='".$request->get('course_id')."')
            and trim(c.type)=trim((select type from metadata_courses where studio_id_1='".$request->get('course_id')."'))";
            $course = DB::connection('pgsql')->select($sql);
            $course_collection=collect($course);
            $mqi_course=$course_collection->first()->average_group;
            array_push($mqi_data_group,round($mqi_course,2));
        }





        $sql="select * from metadata_courses
        where \"Course_Name_AllEditions\"=(select \"Course_Name_AllEditions\" from metadata_courses
        where studio_id_1='".$request->get('course_id')."')
        and EXTRACT(YEAR FROM start_date)=$year_course
        and start_date <= (select start_date from metadata_courses
        where studio_id_1='".$request->get('course_id')."')";
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);


        if($answers_collection->count()>0){
            $year_data= 1;
            $sql="select avg(CAST(m.mqi AS FLOAT)) as average_group from control_panel_course_report_mqi as m
            INNER JOIN metadata_courses c on(m.id=c.id)
            where
            c.\"Course_Name_AllEditions\" =
            (select \"Course_Name_AllEditions\" from metadata_courses where studio_id_1='".$request->get('course_id')."')
            and EXTRACT(YEAR FROM c.start_date)=$year_course
            and c.start_date <=
            (select start_date from metadata_courses where studio_id_1='".$request->get('course_id')."')
            and trim(c.type)=trim((select type from metadata_courses where studio_id_1='".$request->get('course_id')."'))";
            $course = DB::connection('pgsql')->select($sql);
            $course_collection=collect($course);
            $mqi_course=$course_collection->first()->average_group;
            array_push($mqi_data_year,round($mqi_course,2));

        }





        $sql="select avg(CAST(m.mqi AS FLOAT)) as average_group from control_panel_course_report_mqi as m
        INNER JOIN metadata_courses c on(m.id=c.id)
        where
        trim(c.language)=
        trim((select language from metadata_courses where studio_id_1='".$request->get('course_id')."'))
        and c.end_date <=
        (select end_date from metadata_courses where studio_id_1='".$request->get('course_id')."')
        and trim(c.type)=
        trim((select type from metadata_courses where studio_id_1='".$request->get('course_id')."'))
        and c.olp=".$olp."
        and c.studio_id_1 not in('".$request->get('course_id')."')";
        $course = DB::connection('pgsql')->select($sql);
        $course_collection=collect($course);
        $mqi_course=$course_collection->first()->average_group;
        $mqi_data_old=[];
        array_push($mqi_data_old,round($mqi_course,2));




        return response()->json(['mqi'=>$mqi_data,'mqi_group'=>$mqi_data_group,'mqi_old'=>$mqi_data_old,'old_data'=>$old_data,'mqi_year'=>$mqi_data_year,'year_data'=>$year_data,'edition_course'=>$edition_course,'language_course'=>$language_course,'year_course'=>$year_course, 'type_course'=>$type_course]);

    }

    public function courseCountry(Request $request)
    {
        $sql ="Select country,total FROM control_panel_course_report_general_country c
        inner join metadata_courses m on(c.course_id=m.id)
        where m.studio_id_1='".$request->get('course_id')."'
        ORDER BY cast(total as INTEGER) DESC
        LIMIT 10";

        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);
        $answers_display_name=[];
        $answers_average_question=[];
        $answers_total=[];
        foreach ($answers_collection as $answer) {
            array_push($answers_display_name,$answer->country);
            array_push($answers_average_question,$answer->total);
        }

        return response()->json(['display_name'=>$answers_display_name,'average_question'=>$answers_average_question]);

    }

    public function courseCountryPea(Request $request)
    {
        $sql ="Select country,pea_student FROM control_panel_course_report_general_country c
        inner join metadata_courses m on(c.course_id=m.id)
        where m.studio_id_1='".$request->get('course_id')."'
        ORDER BY cast(pea_student as FLOAT) DESC
        LIMIT 10";

        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);
        $answers_display_name=[];
        $answers_average_question=[];
        $answers_total=[];
        foreach ($answers_collection as $answer) {
            array_push($answers_display_name,$answer->country);
            array_push($answers_average_question,round($answer->pea_student,2));
        }

        return response()->json(['display_name'=>$answers_display_name,'average_question'=>$answers_average_question]);

    }

    public function surveySatisfactionIndividual(Request $request)
    {
        /*
        $sql="select * from control_panel_course_report_satisfaction where  course_id='".$request->get('course_id')."' and question_parent='".$request->get('question')."'";
        $course = DB::connection('pgsql')->select($sql);
        $course_collection=collect($course);
        $average_course=$course_collection->first()->average_total;
        $total_sample=$course_collection->first()->total_sample;

        $average_data=[];
        array_push($average_data,round($average_course,2));

        return response()->json(['sample_survey'=>$total_sample,'average_survey'=>$average_data]);
        */
        $old_data= 0;
        $answers_display_name_old=[];
        $answers_average_question_old=[];
        $answers_display_name_historical=[];
        $answers_average_question_historical=[];
        $mqi_data_group=[];
        $request->get('question');
        $sql ="select d.*,tq.*,m.language as language_metadata,m.type as type_metadata,m.edition as edition_metadata,m.olp from control_panel_course_report_satisfaction as d
        INNER JOIN control_panel_course_template_question_survey tq on(tq.question_id = d.question_id)
        INNER JOIN metadata_courses m on(m.studio_id_1=d.course_id)
        where d.course_id='".$request->get('course_id')."'
        and d.question_id='".$request->get('question')."'
        order by tq.display_name_es desc";
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);
        $edition_course=$answers_collection->first()->edition_metadata;
        $language_course=$answers_collection->first()->language_metadata;
        $type_course=$answers_collection->first()->type_metadata;
        $language_course_original = $language_course;
        $olp=$answers_collection->first()->olp;
        $answers_display_name=[];
        $answers_total=[];
        $answers_percentage=[];
        $answers_average_question=[];


        switch ($language_course) {
            case "es":
              $language_course = "espa??ol";
              break;
            case "en":
                $language_course = "ingl??s";
              break;
            case "pt":
                $language_course = "portugu??s";
              break;
            case "fr":
                $language_course = "franc??s";
            break;
          }

        foreach ($answers_collection as $answer) {
            array_push($answers_display_name,$answer->display_name_es);
            array_push($answers_average_question,round($answer->average_total,2));
            $total_sample=$answer->total_sample;
        }
        $sample_survey=$total_sample;

        $sql="select * from metadata_courses
        where \"Course_Name_AllEditions\"=(select \"Course_Name_AllEditions\" from metadata_courses
        where studio_id_1='".$request->get('course_id')."')
        and start_date < (select start_date from metadata_courses
        where studio_id_1='".$request->get('course_id')."')";
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);

        if($answers_collection->count()>0){
            $old_data= 1;
            $sql="select tq.display_name_es, avg(CAST(d.average_total AS FLOAT)) as average_group from control_panel_course_report_satisfaction as d
            INNER JOIN metadata_courses c on(d.id=c.id)
            INNER JOIN control_panel_course_template_question_survey tq on(tq.question_id = d.question_id)
            where
            c.\"Course_Name_AllEditions\" =
            (select \"Course_Name_AllEditions\" from metadata_courses where studio_id_1='".$request->get('course_id')."')
             and c.start_date <
             (select start_date from metadata_courses where studio_id_1='".$request->get('course_id')."')
            and trim(c.type)=trim((select type from metadata_courses where studio_id_1='".$request->get('course_id')."'))
            and d.question_id='".$request->get('question')."'
            GROUP BY tq.question_id,tq.display_name_es
            ORDER BY tq.question_id asc";
            $answers = DB::connection('pgsql')->select($sql);
            $answers_collection=collect($answers);
            $answers_display_name_old=[];
            $answers_average_question_old=[];

            foreach ($answers_collection as $answer) {
                array_push($answers_display_name_old,$answer->display_name_es);
                array_push($answers_average_question_old,round($answer->average_group,2));
            }
        }
        $sql="select tq.display_name_es, avg(CAST(d.average_total AS FLOAT)) as average_group from control_panel_course_report_satisfaction as d
        INNER JOIN metadata_courses c on(d.id=c.id)
        INNER JOIN control_panel_course_template_question_survey tq on(tq.question_id = d.question_id)
        where
        trim(c.language)=trim('".$language_course_original."')
        and c.end_date <=
        (select end_date from metadata_courses where studio_id_1='".$request->get('course_id')."')
        and trim(c.type)=trim('".$type_course."')
        and c.studio_id_1 not in('".$request->get('course_id')."')
        and c.olp=".$olp."
        and d.question_id in (
        select question_id from control_panel_course_report_satisfaction where course_id='".$request->get('course_id')."'
        )
        and d.question_id='".$request->get('question')."'
        GROUP BY tq.question_id,tq.display_name_es
        ORDER BY tq.question_id asc";
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);
        $answers_display_name_historical=[];
        $answers_average_question_historical=[];

        foreach ($answers_collection as $answer) {
            array_push($answers_display_name_historical,$answer->display_name_es);
            array_push($answers_average_question_historical,round($answer->average_group,2));
        }

        return response()->json(['display_name_historical'=>$answers_display_name_historical,'average_question_historical'=>$answers_average_question_historical,'display_name_old'=>$answers_display_name_old,'average_question_old'=>$answers_average_question_old,'sample_survey'=>$sample_survey,'display_name'=>$answers_display_name,'average_question'=>$answers_average_question,'total_sample'=>$total_sample,'old_data'=>$old_data,'edition_course'=>$edition_course, 'language_course'=>$language_course, 'type_course'=>$type_course]);

    }

    public function surveySatisfactionIndividualGanancia(Request $request)
    {
        $old_data= 0;
        $answers_display_name_old=[];
        $answers_average_question_old=[];
        $answers_display_name_historical=[];
        $answers_average_question_historical=[];
        $mqi_data_group=[];
        $request->get('question');
        $sql ="select d.*,tq.*,m.language as language_metadata,m.type as type_metadata,m.edition as edition_metadata,m.olp from control_panel_course_report_satisfaction as d
        INNER JOIN control_panel_course_template_question_survey tq on(tq.question_id = d.question_id)
        INNER JOIN metadata_courses m on(m.studio_id_1=d.course_id)
        where d.course_id='".$request->get('course_id')."'
        and d.question_id='".$request->get('question')."'
        order by tq.display_name_es desc";
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);
        $edition_course=$answers_collection->first()->edition_metadata;
        $language_course=$answers_collection->first()->language_metadata;
        $type_course=$answers_collection->first()->type_metadata;
        $language_course_original = $language_course;
        $olp=$answers_collection->first()->olp;
        $answers_display_name=[];
        $answers_total=[];
        $answers_percentage=[];
        $answers_average_question=[];
        $total_gain=0;


        switch ($language_course) {
            case "es":
              $language_course = "espa??ol";
              break;
            case "en":
                $language_course = "ingl??s";
              break;
            case "pt":
                $language_course = "portugu??s";
              break;
            case "fr":
                $language_course = "franc??s";
            break;
          }

        foreach ($answers_collection as $answer) {
            array_push($answers_display_name,$answer->display_name_es);
            array_push($answers_average_question,round($answer->total_gain,2));
            $total_gain=round($answer->total_gain,2);
            $total_sample=$answer->total_sample;
        }
        $sample_survey=$total_sample;

        $sql="select * from metadata_courses
        where \"Course_Name_AllEditions\"=(select \"Course_Name_AllEditions\" from metadata_courses
        where studio_id_1='".$request->get('course_id')."')
        and start_date < (select start_date from metadata_courses
        where studio_id_1='".$request->get('course_id')."')";
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);

        if($answers_collection->count()>0){
            $old_data= 1;
            $sql="select tq.display_name_es, avg(CAST(d.total_gain AS FLOAT)) as average_group from control_panel_course_report_satisfaction as d
            INNER JOIN metadata_courses c on(d.id=c.id)
            INNER JOIN control_panel_course_template_question_survey tq on(tq.question_id = d.question_id)
            where
            c.\"Course_Name_AllEditions\" =
            (select \"Course_Name_AllEditions\" from metadata_courses where studio_id_1='".$request->get('course_id')."')
             and c.start_date <
             (select start_date from metadata_courses where studio_id_1='".$request->get('course_id')."')
            and trim(c.type)=trim((select type from metadata_courses where studio_id_1='".$request->get('course_id')."'))
            and d.question_id='".$request->get('question')."'
            GROUP BY tq.question_id,tq.display_name_es
            ORDER BY tq.question_id asc";
            $answers = DB::connection('pgsql')->select($sql);
            $answers_collection=collect($answers);
            $answers_display_name_old=[];
            $answers_average_question_old=[];

            foreach ($answers_collection as $answer) {
                array_push($answers_display_name_old,$answer->display_name_es);
                array_push($answers_average_question_old,round($answer->average_group,2));
            }
        }
        $sql="select tq.display_name_es, avg(CAST(d.total_gain AS FLOAT)) as average_group from control_panel_course_report_satisfaction as d
        INNER JOIN metadata_courses c on(d.id=c.id)
        INNER JOIN control_panel_course_template_question_survey tq on(tq.question_id = d.question_id)
        where
        trim(c.language)=trim('".$language_course_original."')
        and c.end_date <=
        (select end_date from metadata_courses where studio_id_1='".$request->get('course_id')."')
        and trim(c.type)=
        trim('".$type_course."')
        and d.question_id in (
        select question_id from control_panel_course_report_satisfaction where course_id='".$request->get('course_id')."'
        )
        and c.olp=".$olp."
        and d.question_id='".$request->get('question')."'
        GROUP BY tq.question_id,tq.display_name_es
        ORDER BY tq.question_id asc";
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);
        $answers_display_name_historical=[];
        $answers_average_question_historical=[];
        $total_gain_historical=0;

        foreach ($answers_collection as $answer) {
            array_push($answers_display_name_historical,$answer->display_name_es);
            array_push($answers_average_question_historical,round($answer->average_group,2));
            $total_gain_historical=round($answer->average_group,2);
        }

        return response()->json(['total_gain'=>$total_gain,'total_gain_historical'=>$total_gain_historical,'display_name_historical'=>$answers_display_name_historical,'average_question_historical'=>$answers_average_question_historical,'display_name_old'=>$answers_display_name_old,'average_question_old'=>$answers_average_question_old,'sample_survey'=>$sample_survey,'display_name'=>$answers_display_name,'average_question'=>$answers_average_question,'total_sample'=>$total_sample,'old_data'=>$old_data,'edition_course'=>$edition_course,'language_course'=>$language_course,'type_course'=>$type_course]);

    }

    public function surveyInitial(Request $request)
    {
        $answers_display_name_old=[];
        $answers_total_old=[];
        $answers_percentage_old=[];
        $sql="select * from metadata_courses where  studio_id_1='".$request->get('course_id')."'";
        $course = DB::connection('pgsql')->select($sql);
        $course_collection=collect($course);
        $language_course=$course_collection->first()->language;
        $language_course_original=$course_collection->first()->language;
        $edition_course=$course_collection->first()->edition;
        $start_date=$course_collection->first()->start_date;
        $olp=$course_collection->first()->olp;
        $course_id=$course_collection->first()->studio_id_1;
        $time = strtotime($start_date);
        $year_course = date('Y',$time);
        $type_course=$course_collection->first()->type;


        switch ($language_course) {
            case "es":
              $language_course = "espa??ol";
              break;
            case "en":
                $language_course = "ingl??s";
              break;
            case "pt":
                $language_course = "portugu??s";
              break;
            case "fr":
                $language_course = "franc??s";
            break;
          }


        if($year_course>=2020){
            $sql = "select ta.display_name_es as display_name,d.total,d.percentage from control_panel_course_answers_students d
            INNER JOIN control_panel_course_resource_questions q on(d.question_id=q.module_id)
            INNER JOIN control_panel_course_resource_answers an on(d.answer_id=an.module_id)
            INNER JOIN control_panel_course_template_answer_survey ta on(an.answer_id = ta.answer_id and ta.poll='1')
            inner JOIN control_panel_course_resources r on (r.module_id=q.resource_id)
            INNER JOIN control_panel_course_verticals v on(v.module_id=r.vertical_id)
            INNER JOIN control_panel_course_sequentials s on (s.module_id=v.sequential_id)
            INNER JOIN control_panel_course_chapters ch on(ch.module_id=s.chapter_id)
            where ch.course_id='".$request->get('course_id')."' and q.question_id='".$request->get('question')."' and v.poll='1'
            order by ta.display_name_es asc";


            $answers = DB::connection('pgsql')->select($sql);
            $answers_collection=collect($answers);
            $sample=$answers_collection->sum('total');
            $answers_display_name=[];
            $answers_total=[];
            $answers_percentage=[];


            foreach ($answers_collection as $answer) {
                array_push($answers_display_name,$answer->display_name);
                array_push($answers_total,$answer->total);
                array_push($answers_percentage,round($answer->percentage,2));
            }
            $sample_survey=$sample;

        } else{
            $sql ="select ta.display_name_es,d.total,d.percentage from control_panel_course_answers_students_old d
            INNER JOIN control_panel_course_template_answer_survey ta on(d.answer_id = CAST (ta.answer_id AS INTEGER) and ta.poll='1')
            INNER JOIN control_panel_course_template_question_survey tq on(ta.question_id=tq.id and tq.poll='1')
            INNER JOIN metadata_courses c on(d.course_id=c.id)
            where d.poll=1
            and c.studio_id_1='".$request->get('course_id')."'
            and tq.question_id='".$request->get('question')."'
            ORDER BY ta.display_name_es asc";

            $answers = DB::connection('pgsql')->select($sql);
            $answers_collection=collect($answers);
            $sample=$answers_collection->sum('total');
            $answers_display_name=[];
            $answers_total=[];
            $answers_percentage=[];

            foreach ($answers_collection as $answer) {
                array_push($answers_display_name,$answer->display_name_es);
                array_push($answers_total,$answer->total);
                array_push($answers_percentage,round($answer->percentage,2));
            }
            $sample_survey=$sample;

        }

        /* version for year*/
        $year_data=0;
        $answers_display_name_year=[];
        $answers_total_year=[];
        $answers_percentage_year=[];
        if($year_course>=2020){
            $sql="select * from metadata_courses
            where \"Course_Name_AllEditions\"=(select \"Course_Name_AllEditions\" from metadata_courses
            where studio_id_1='".$request->get('course_id')."')
            and start_date <= (select start_date from metadata_courses
            where studio_id_1='".$request->get('course_id')."') and type='$type_course'
            and EXTRACT(YEAR FROM start_date)=$year_course" ;
            $answers = DB::connection('pgsql')->select($sql);
            $answers_collection=collect($answers);
                if($answers_collection->count()>0){
                    $year_data=1;
                    $sql="select sum(CAST (d.total AS INTEGER)) as total,ta.display_name_es as display_name
                    from control_panel_course_answers_students d
                    INNER JOIN control_panel_course_resource_questions q on(d.question_id=q.module_id)
                    INNER JOIN control_panel_course_resource_answers an on(d.answer_id=an.module_id)
                    INNER JOIN control_panel_course_template_answer_survey ta on(an.answer_id = ta.answer_id and ta.poll='1')
                    inner JOIN control_panel_course_resources r on (r.module_id=q.resource_id)
                    INNER JOIN control_panel_course_verticals v on(v.module_id=r.vertical_id)
                    INNER JOIN control_panel_course_sequentials s on (s.module_id=v.sequential_id)
                    INNER JOIN control_panel_course_chapters ch on(ch.module_id=s.chapter_id)
                    INNER JOIN metadata_courses c on(ch.course_id=c.studio_id_1)
                    where  q.question_id='".$request->get('question')."' and v.poll='1'
                    and trim(c.\"Course_Name_AllEditions\")=trim((select \"Course_Name_AllEditions\" from metadata_courses
                        where studio_id_1='".$request->get('course_id')."'))
                    and c.start_date <= (select start_date from metadata_courses
                        where studio_id_1='".$request->get('course_id')."')
                    and trim(c.type)=trim((select type from metadata_courses
                        where studio_id_1='".$request->get('course_id')."'))
                    and EXTRACT(YEAR FROM c.start_date)=$year_course
                    GROUP BY ta.id,ta.display_name_es
                    ORDER BY ta.id asc";
                    $answers = DB::connection('pgsql')->select($sql);
                    $answers_collection=collect($answers);
                    if ($answers_collection->count()>0){
                        $sample=$answers_collection->sum('total');
                        foreach ($answers_collection as $answer) {
                            array_push($answers_display_name_year,$answer->display_name);
                            array_push($answers_total_year,$answer->total);
                            if($sample>0){
                                array_push($answers_percentage_year,round(($answer->total/$sample)*100,2));
                            }else{
                                array_push($answers_percentage_year,0);
                            }
                        }

                    }else{
                        $year_data= 0;
                    }
                }else{
                    $year_data= 0;
                }
        }else{
            $sql="select * from metadata_courses
            where \"Course_Name_AllEditions\"=(select \"Course_Name_AllEditions\" from metadata_courses
            where studio_id_1='".$request->get('course_id')."')
            and start_date <= (select start_date from metadata_courses
            where studio_id_1='".$request->get('course_id')."') and type='$type_course'
            and EXTRACT(YEAR FROM start_date)=$year_course" ;
            $answers = DB::connection('pgsql')->select($sql);
            $answers_collection=collect($answers);
                if($answers_collection->count()>0){
                    $year_data= 1;
                    $sql="select sum(d.total) as total,ta.display_name_es as display_name
                    from control_panel_course_answers_students_old d
                    INNER JOIN control_panel_course_template_answer_survey ta on(d.answer_id = CAST (ta.answer_id AS INTEGER) and ta.poll='1')
                    INNER JOIN control_panel_course_template_question_survey tq on(ta.question_id=tq.id and tq.poll='1')
                    INNER JOIN metadata_courses c on(d.course_id=c.id)
                    where d.poll=1
                    and trim(c.\"Course_Name_AllEditions\")=trim((select \"Course_Name_AllEditions\" from metadata_courses
                    where studio_id_1='".$request->get('course_id')."'))
                    and c.start_date <= (select start_date from metadata_courses
                    where studio_id_1='".$request->get('course_id')."')
                    and trim(c.type)=trim((select type from metadata_courses
                        where studio_id_1='".$request->get('course_id')."'))
                    and tq.question_id='".$request->get('question')."'
                    and EXTRACT(YEAR FROM c.start_date)=$year_course
                    GROUP BY ta.id,ta.display_name_es
                    ORDER BY ta.id asc)";
                    $answers = DB::connection('pgsql')->select($sql);
                    $answers_collection=collect($answers);
                    if ($answers_collection->count()>0){
                        $sample=$answers_collection->sum('total');
                        foreach ($answers_collection as $answer) {
                            array_push($answers_display_name_year,$answer->display_name);
                            array_push($answers_total_year,$answer->total);
                            if($sample>0){
                                array_push($answers_percentage_year,round(($answer->total/$sample)*100,2));
                            }else{
                                array_push($answers_percentage_year,0);
                            }
                        }

                    }else{
                        $year_data= 0;
                    }

                }else{
                    $year_data= 0;
                }
        }


        /* end version for year */

        $sql="select * from metadata_courses
        where \"Course_Name_AllEditions\"=(select \"Course_Name_AllEditions\" from metadata_courses
        where studio_id_1='".$request->get('course_id')."')
        and start_date < (select start_date from metadata_courses
        where studio_id_1='".$request->get('course_id')."') and type='$type_course'" ;
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);

        if($answers_collection->count()>0){
            $old_data= 1;
            $sql="Select display_name,sum(total) as total
            from
            ((select sum(d.total) as total,ta.display_name_es as display_name
            from control_panel_course_answers_students_old d
            INNER JOIN control_panel_course_template_answer_survey ta on(d.answer_id = CAST (ta.answer_id AS INTEGER) and ta.poll='1')
            INNER JOIN control_panel_course_template_question_survey tq on(ta.question_id=tq.id and tq.poll='1')
            INNER JOIN metadata_courses c on(d.course_id=c.id)
            where d.poll=1
            and trim(c.\"Course_Name_AllEditions\")=trim((select \"Course_Name_AllEditions\" from metadata_courses
            where studio_id_1='".$request->get('course_id')."'))
            and c.start_date < (select start_date from metadata_courses
            where studio_id_1='".$request->get('course_id')."')
            and trim(c.type)=trim((select type from metadata_courses
                where studio_id_1='".$request->get('course_id')."'))
            and tq.question_id='".$request->get('question')."'
            GROUP BY ta.id,ta.display_name_es
            ORDER BY ta.id asc)
            UNION ALL
            (select sum(CAST (d.total AS INTEGER)) as total,ta.display_name_es as display_name
            from control_panel_course_answers_students d
            INNER JOIN control_panel_course_resource_questions q on(d.question_id=q.module_id)
            INNER JOIN control_panel_course_resource_answers an on(d.answer_id=an.module_id)
            INNER JOIN control_panel_course_template_answer_survey ta on(an.answer_id = ta.answer_id and ta.poll='1')
            inner JOIN control_panel_course_resources r on (r.module_id=q.resource_id)
            INNER JOIN control_panel_course_verticals v on(v.module_id=r.vertical_id)
            INNER JOIN control_panel_course_sequentials s on (s.module_id=v.sequential_id)
            INNER JOIN control_panel_course_chapters ch on(ch.module_id=s.chapter_id)
            INNER JOIN metadata_courses c on(ch.course_id=c.studio_id_1)
            where  q.question_id='".$request->get('question')."' and v.poll='1'
            and trim(c.\"Course_Name_AllEditions\")=trim((select \"Course_Name_AllEditions\" from metadata_courses
                where studio_id_1='".$request->get('course_id')."'))
            and c.start_date < (select start_date from metadata_courses
                where studio_id_1='".$request->get('course_id')."')
            and trim(c.type)=trim((select type from metadata_courses
                where studio_id_1='".$request->get('course_id')."'))
            GROUP BY ta.id,ta.display_name_es
            ORDER BY ta.id asc)) as data
            GROUP BY display_name
            order by display_name ASC";

            $answers = DB::connection('pgsql')->select($sql);
            $answers_collection=collect($answers);
            if ($answers_collection->count()>0){
                $sample=$answers_collection->sum('total');

                foreach ($answers_collection as $answer) {
                    array_push($answers_display_name_old,$answer->display_name);
                    array_push($answers_total_old,$answer->total);
                    if($sample>0){
                        array_push($answers_percentage_old,round(($answer->total/$sample)*100,2));
                    }else{
                        array_push($answers_percentage_old,0);
                    }
                }
            }else{
                $old_data= 0;
            }


        }else{
            $old_data= 0;
        }



        //******************************************** //
        // Begin Historical Data x Type x Language //
        //*********************************************//

        $sql="Select display_name,sum(total) as total
        from
        ((select sum(d.total) as total,ta.display_name_es as display_name
        from control_panel_course_answers_students_old d
        INNER JOIN control_panel_course_template_answer_survey ta on(d.answer_id = CAST (ta.answer_id AS INTEGER) and ta.poll='1')
        INNER JOIN control_panel_course_template_question_survey tq on(ta.question_id=tq.id and tq.poll='1')
        INNER JOIN metadata_courses c on(d.course_id=c.id)
        where d.poll=1
        and trim(c.language)=trim('".$language_course_original."')
        and c.olp=".$olp."
        and c.end_date <= (select end_date from metadata_courses
        where studio_id_1='".$request->get('course_id')."')
        and trim(c.type)=trim('".$type_course."')
        and tq.question_id='".$request->get('question')."'
        and c.studio_id_1 not in('".$request->get('course_id')."')
        GROUP BY ta.id,ta.display_name_es
        ORDER BY ta.id asc)
        UNION ALL
        (select sum(CAST (d.total AS INTEGER)) as total,ta.display_name_es as display_name
        from control_panel_course_answers_students d
        INNER JOIN control_panel_course_resource_questions q on(d.question_id=q.module_id)
        INNER JOIN control_panel_course_resource_answers an on(d.answer_id=an.module_id)
        INNER JOIN control_panel_course_template_answer_survey ta on(an.answer_id = ta.answer_id and ta.poll='1')
        inner JOIN control_panel_course_resources r on (r.module_id=q.resource_id)
        INNER JOIN control_panel_course_verticals v on(v.module_id=r.vertical_id)
        INNER JOIN control_panel_course_sequentials s on (s.module_id=v.sequential_id)
        INNER JOIN control_panel_course_chapters ch on(ch.module_id=s.chapter_id)
        INNER JOIN metadata_courses c on(ch.course_id=c.studio_id_1)
        where  q.question_id='".$request->get('question')."' and v.poll='1'
        and trim(c.language)=trim('".$language_course_original."')
        and c.olp=".$olp."
        and c.end_date <= (select end_date from metadata_courses
            where studio_id_1='".$request->get('course_id')."')
        and trim(c.type)=trim('".$type_course."')
        and c.studio_id_1 not in('".$request->get('course_id')."')
        GROUP BY ta.id,ta.display_name_es
        ORDER BY ta.id asc)) as data
        GROUP BY display_name
        order by display_name ASC";
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);
        $sample=$answers_collection->sum('total');
        $answers_display_name_historical=[];
        $answers_total_historical=[];
        $answers_percentage_historical=[];

        foreach ($answers_collection as $answer) {
            array_push($answers_display_name_historical,$answer->display_name);
            array_push($answers_total_historical,$answer->total);
            array_push($answers_percentage_historical,round(($answer->total/$sample)*100,2));
        }

        //******************************************** //
        // End Historical Data x Type x Language //
        //*********************************************//


        return response()->json(['sample_survey'=>$sample_survey,'display_name_historical'=>$answers_display_name_historical,'total_historical'=>$answers_total_historical,'percentage_historical'=>$answers_percentage_historical,'edition_course'=>$edition_course,'year_course'=>$year_course,'display_name_old'=>$answers_display_name_old,'total_old'=>$answers_total_old,'percentage_old'=>$answers_percentage_old,'display_name'=>$answers_display_name,'total'=>$answers_total,'percentage'=>$answers_percentage,'old_data'=>$old_data,'year_data'=>$year_data,'display_name_year'=>$answers_display_name_year,'total_year'=>$answers_total_year,'percentage_year'=>$answers_percentage_year, 'language_course'=>$language_course,'type_course'=>$type_course]);

    }

    public function surveySatisfaction(Request $request)
    {
        $answers_display_name_historical=[];
        $answers_average_question_historical=[];
        $answers_display_name_old=[];
        $answers_average_question_old=[];

        $old_data= 0;
        $mqi_data_group=[];
        $request->get('question');
        $sql ="select d.*,tq.*,m.language as language_metadata,m.type as type_metadata,m.edition as edition_metadata,m.olp from control_panel_course_report_satisfaction as d
        INNER JOIN control_panel_course_template_question_survey tq on(tq.question_id = d.question_id)
        INNER JOIN metadata_courses m on(m.studio_id_1=d.course_id)
        where d.course_id='".$request->get('course_id')."'
        and d.question_parent='".$request->get('question')."'
        and tq.poll='3'
        order by tq.display_name_es desc";
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);
        $edition_course=$answers_collection->first()->edition_metadata;
        $language_course=$answers_collection->first()->language_metadata;
        $type_course=$answers_collection->first()->type_metadata;
        $language_course_original = $language_course;
        $olp=$answers_collection->first()->olp;
        $answers_display_name=[];
        $answers_total=[];
        $answers_percentage=[];
        $answers_average_question=[];


        switch ($language_course) {
            case "es":
              $language_course = "espa??ol";
              break;
            case "en":
                $language_course = "ingl??s";
              break;
            case "pt":
                $language_course = "portugu??s";
              break;
            case "fr":
                $language_course = "franc??s";
            break;
          }

        foreach ($answers_collection as $answer) {
            array_push($answers_display_name,$answer->display_name_es);
            array_push($answers_average_question,round($answer->average_question,2));
            $total_sample=$answer->total_sample;
        }
        $sample_survey=$total_sample;

        $sql="select * from metadata_courses
        where \"Course_Name_AllEditions\"=(select \"Course_Name_AllEditions\" from metadata_courses
        where studio_id_1='".$request->get('course_id')."')
        and start_date < (select start_date from metadata_courses
        where studio_id_1='".$request->get('course_id')."')";
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);

        if($answers_collection->count()>0){
            $old_data= 1;
            $sql="select tq.display_name_es, avg(CAST(d.average_question AS FLOAT)) as average_group from control_panel_course_report_satisfaction as d
            INNER JOIN metadata_courses c on(d.id=c.id)
            INNER JOIN control_panel_course_template_question_survey tq on(tq.question_id = d.question_id)
            where
            c.\"Course_Name_AllEditions\" =
            (select \"Course_Name_AllEditions\" from metadata_courses where studio_id_1='".$request->get('course_id')."')
             and c.start_date <
             (select start_date from metadata_courses where studio_id_1='".$request->get('course_id')."')
            and trim(c.type)=trim((select type from metadata_courses where studio_id_1='".$request->get('course_id')."'))
            and d.question_parent='".$request->get('question')."'
            and tq.poll='3'
            GROUP BY tq.question_id,tq.display_name_es
            ORDER BY tq.question_id asc";
            $answers = DB::connection('pgsql')->select($sql);
            $answers_collection=collect($answers);
            $answers_display_name_old=[];
            $answers_average_question_old=[];

            foreach ($answers_collection as $answer) {
                array_push($answers_display_name_old,$answer->display_name_es);
                array_push($answers_average_question_old,round($answer->average_group,2));
            }
        }


        //******************************************** //
        // Begin Historical Data x Type x Language //
        //*********************************************//

        $sql="select tq.display_name_es, avg(CAST(d.average_question AS FLOAT)) as average_group from control_panel_course_report_satisfaction as d
        INNER JOIN metadata_courses c on(d.id=c.id)
        INNER JOIN control_panel_course_template_question_survey tq on(tq.question_id = d.question_id)
        where
        trim(c.language)=trim('".$language_course_original."')
        and c.end_date <=
        (select end_date from metadata_courses where studio_id_1='".$request->get('course_id')."')
        and trim(c.type)=trim('".$type_course."')
        and c.studio_id_1 not in('".$request->get('course_id')."')
        and d.question_id in (
        select question_id from control_panel_course_report_satisfaction where course_id='".$request->get('course_id')."'
        )
        and d.question_parent='".$request->get('question')."'
        and c.olp=".$olp."
        and tq.poll='3'
        GROUP BY tq.question_id,tq.display_name_es
        ORDER BY tq.question_id asc";
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);
        $answers_display_name_historical=[];
        $answers_average_question_historical=[];

        foreach ($answers_collection as $answer) {
            array_push($answers_display_name_historical,$answer->display_name_es);
            array_push($answers_average_question_historical,round($answer->average_group,2));
        }

        return response()->json(['display_name_historical'=>$answers_display_name_historical,'average_question_historical'=>$answers_average_question_historical,'display_name_old'=>$answers_display_name_old,'average_question_old'=>$answers_average_question_old,'sample_survey'=>$sample_survey,'display_name'=>$answers_display_name,'average_question'=>$answers_average_question,'total_sample'=>$total_sample,'old_data'=>$old_data,'edition_course'=>$edition_course,'language_course'=>$language_course,'type_course'=>$type_course]);

    }

    public function surveySatisfactionIndividualPromedio(Request $request)
    {

        $old_data= 0;
        $answers_display_name_old=[];
        $answers_average_question_old=[];
        $answers_display_name_historical=[];
        $answers_average_question_historical=[];
        $mqi_data_group=[];
        $request->get('question');
        $sql ="select d.*,tq.*,m.language as language_metadata,m.type as type_metadata,m.edition as edition_metadata,m.olp from control_panel_course_report_satisfaction as d
        INNER JOIN control_panel_course_template_question_survey tq on(tq.question_id = d.question_id)
        INNER JOIN metadata_courses m on(m.studio_id_1=d.course_id)
        where d.course_id='".$request->get('course_id')."'
        and d.question_id='".$request->get('question')."'
        and tq.poll='3'
        order by tq.display_name_es desc";
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);
        $edition_course=$answers_collection->first()->edition_metadata;
        $language_course=$answers_collection->first()->language_metadata;
        $type_course=$answers_collection->first()->type_metadata;
        $language_course_original = $language_course;
        $olp=$answers_collection->first()->olp;
        $answers_display_name=[];
        $answers_total=[];
        $answers_percentage=[];
        $answers_average_question=[];

        switch ($language_course) {
            case "es":
              $language_course = "espa??ol";
              break;
            case "en":
                $language_course = "ingl??s";
              break;
            case "pt":
                $language_course = "portugu??s";
              break;
            case "fr":
                $language_course = "franc??s";
            break;
          }

        foreach ($answers_collection as $answer) {
            array_push($answers_display_name,$answer->display_name_es);
            array_push($answers_average_question,round($answer->average_question,2));
            $total_sample=$answer->total_sample;
        }
        $sample_survey=$total_sample;

        $sql="select * from metadata_courses
        where \"Course_Name_AllEditions\"=(select \"Course_Name_AllEditions\" from metadata_courses
        where studio_id_1='".$request->get('course_id')."')
        and start_date < (select start_date from metadata_courses
        where studio_id_1='".$request->get('course_id')."')";
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);

        if($answers_collection->count()>0){
            $old_data= 1;
            $sql="select tq.display_name_es, avg(CAST(d.average_question AS FLOAT)) as average_group from control_panel_course_report_satisfaction as d
            INNER JOIN metadata_courses c on(d.id=c.id)
            INNER JOIN control_panel_course_template_question_survey tq on(tq.question_id = d.question_id)
            where
            c.\"Course_Name_AllEditions\" =
            (select \"Course_Name_AllEditions\" from metadata_courses where studio_id_1='".$request->get('course_id')."')
             and c.start_date <
             (select start_date from metadata_courses where studio_id_1='".$request->get('course_id')."')
            and trim(c.type)=trim((select type from metadata_courses where studio_id_1='".$request->get('course_id')."'))
            and d.question_id='".$request->get('question')."'
            and tq.poll='3'
            GROUP BY tq.question_id,tq.display_name_es
            ORDER BY tq.question_id asc";
            $answers = DB::connection('pgsql')->select($sql);
            $answers_collection=collect($answers);
            $answers_display_name_old=[];
            $answers_average_question_old=[];

            foreach ($answers_collection as $answer) {
                array_push($answers_display_name_old,$answer->display_name_es);
                array_push($answers_average_question_old,round($answer->average_group,2));
            }
        }



        //******************************************** //
        // Begin Historical Data x Type x Language //
        //*********************************************//


        $sql="select tq.display_name_es, avg(CAST(d.average_question AS FLOAT)) as average_group from control_panel_course_report_satisfaction as d
        INNER JOIN metadata_courses c on(d.id=c.id)
        INNER JOIN control_panel_course_template_question_survey tq on(tq.question_id = d.question_id)
        where
        trim(c.language)=trim('".$language_course_original."')
        and c.end_date <=
        (select end_date from metadata_courses where studio_id_1='".$request->get('course_id')."')
        and trim(c.type)=trim('".$type_course."')
        and c.studio_id_1 not in('".$request->get('course_id')."')
        and c.olp=".$olp."
        and d.question_id in (
        select question_id from control_panel_course_report_satisfaction where course_id='".$request->get('course_id')."'
        )
        and d.question_id='".$request->get('question')."'
        and tq.poll='3'
        GROUP BY tq.question_id,tq.display_name_es
        ORDER BY tq.question_id asc";
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);
        $answers_display_name_historical=[];
        $answers_average_question_historical=[];

        foreach ($answers_collection as $answer) {
            array_push($answers_display_name_historical,$answer->display_name_es);
            array_push($answers_average_question_historical,round($answer->average_group,2));
        }

        return response()->json(['display_name_historical'=>$answers_display_name_historical,'average_question_historical'=>$answers_average_question_historical,'display_name_old'=>$answers_display_name_old,'average_question_old'=>$answers_average_question_old,'sample_survey'=>$sample_survey,'display_name'=>$answers_display_name,'average_question'=>$answers_average_question,'total_sample'=>$total_sample,'old_data'=>$old_data,'edition_course'=>$edition_course, 'language_course'=>$language_course,'type_course'=>$type_course]);

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $sql="select count(*) as total from control_panel_course_verticals v
        INNER JOIN control_panel_course_sequentials s on(v.sequential_id=s.module_id)
        inner join control_panel_course_chapters ch on(ch.module_id=s.chapter_id)
        where v.poll='1'
        and ch.course_id='".$id."'";
        $survey_initial = DB::connection('pgsql')->select($sql);
        $survey_collection=collect($survey_initial);
        $survey_initial=$survey_collection->first()->total;

        $sql="select count(*) as total from control_panel_course_verticals v
        INNER JOIN control_panel_course_sequentials s on(v.sequential_id=s.module_id)
        inner join control_panel_course_chapters ch on(ch.module_id=s.chapter_id)
        where v.poll='3'
        and ch.course_id='".$id."'";
        $survey_final = DB::connection('pgsql')->select($sql);
        $survey_collection=collect($survey_final);
        $survey_final=$survey_collection->first()->total;

        #$course = Course::find($id)->chapters;
        $data=Course::with(['chapters.sequentials.verticals.resources.questions.students.answer','chapters.sequentials.verticals.resources.comments'])->find($id);
        #dd($data);
        return view('course.course', compact('data','survey_initial','survey_final'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function structureSurveyFinal($id,$survey)
    {
        $course = Course::where('studio_id_1', $id)->first();

        //***Con esto sacamos el a??o *//
        $sql="select * from metadata_courses where  studio_id_1='".$id."'";
        $course_list = DB::connection('pgsql')->select($sql);
        $course_collection=collect($course_list);
        $start_date=$course_collection->first()->start_date;
        $time = strtotime($start_date);
        $year_course = date('Y',$time);
        //*** *//

        $is_spoc=0;

        if($course->type=="SPOC"){
            $is_spoc=1;
        }

        if($is_spoc==0){
            if($year_course<=2022){
                $sql="select * from control_panel_course_template_question_survey tq
                where tq.year=2022 and tq.poll='".$survey."' and is_spoc=".$is_spoc."
                ORDER BY tq.question_id  asc";
            }else{
                $sql="select * from control_panel_course_template_question_survey tq
                where tq.year=".$year_course." and tq.poll='".$survey."' and is_spoc=".$is_spoc."
                ORDER BY tq.question_id  asc";
            }

        }else{
            if($year_course<=2022){
                $sql="select * from control_panel_course_template_question_survey tq
                    where tq.year=2022 and tq.poll='".$survey."'
                    ORDER BY tq.question_id  asc";
            }else{
                $sql="select * from control_panel_course_template_question_survey tq
                    where tq.year=".$year_course." tq.poll='".$survey."'
                    ORDER BY tq.question_id  asc";
            }
        }
        $questions_template = collect(DB::connection('pgsql')->select($sql));



        $sql="select q.display_name,q.question_id,tq.id as id_template from  control_panel_course_resource_questions q
        LEFT JOIN control_panel_course_template_question_survey tq on(tq.question_id=q.question_id and tq.poll='".$survey."')
        INNER JOIN control_panel_course_resources r on(r.module_id=q.resource_id)
        inner join control_panel_course_verticals v on(v.module_id=r.vertical_id)
        inner join control_panel_course_sequentials s on(s.module_id=v.sequential_id)
        inner join control_panel_course_chapters ch on(ch.module_id=s.chapter_id)
        INNER JOIN metadata_courses m on(m.studio_id_1=ch.course_id)
        where r.poll='".$survey."'
        and m.studio_id_1='".$id."'";
        $questions_edx = collect(DB::connection('pgsql')->select($sql));


        if($survey==1){
            $sql="select tq.question_parent,tq.question_id,ta.display_name_es,ta.answer_id FROM control_panel_course_template_answer_survey ta
            INNER JOIN control_panel_course_template_question_survey tq on(ta.question_id=tq.id)
            where tq.poll='".$survey."'
            order by CAST(tq.question_id AS INTEGER),CAST(ta.answer_id AS INTEGER) asc";

        }
        if($survey==3){
            $sql="select tq.question_parent,tq.question_id,ta.display_name_es,ta.answer_id FROM control_panel_course_template_answer_survey ta
            INNER JOIN control_panel_course_template_question_survey tq on(ta.question_id=tq.id)
            where tq.poll='".$survey."'
            order by CAST(ta.answer_id AS INTEGER) asc ,tq.question_id asc";

        }

        $answers_template = collect(DB::connection('pgsql')->select($sql));

        $sql="select an.display_name,an.answer_id,ta.id as id_template,an.question_parent,tq.question_id from  control_panel_course_resource_answers an
        left JOIN control_panel_course_template_answer_survey ta on(ta.answer_id=an.answer_id)
        left JOIN control_panel_course_template_question_survey tq on(ta.question_id=tq.id)
        INNER JOIN control_panel_course_resources r on(r.module_id=an.resource_id)
        inner join control_panel_course_verticals v on(v.module_id=r.vertical_id)
        inner join control_panel_course_sequentials s on(s.module_id=v.sequential_id)
        inner join control_panel_course_chapters ch on(ch.module_id=s.chapter_id)
        INNER JOIN metadata_courses m on(m.studio_id_1=ch.course_id)
        where r.poll='".$survey."'
        and m.studio_id_1='".$id."'";
        $answers_edx = collect(DB::connection('pgsql')->select($sql));


        return view('course.course_survey_final', compact('questions_template','questions_edx','answers_template','answers_edx'));
    }

    public function structureSurvey($id,$survey)
    {
        $sql="select * from control_panel_course_template_question_survey tq
        where tq.poll='".$survey."'
        ORDER BY CAST(tq.question_id AS INTEGER) asc";
        $questions_template = collect(DB::connection('pgsql')->select($sql));

        $sql="select q.display_name,q.question_id,tq.id as id_template from  control_panel_course_resource_questions q
        LEFT JOIN control_panel_course_template_question_survey tq on(tq.question_id=q.question_id and tq.poll='".$survey."')
        INNER JOIN control_panel_course_resources r on(r.module_id=q.resource_id)
        inner join control_panel_course_verticals v on(v.module_id=r.vertical_id)
        inner join control_panel_course_sequentials s on(s.module_id=v.sequential_id)
        inner join control_panel_course_chapters ch on(ch.module_id=s.chapter_id)
        INNER JOIN metadata_courses m on(m.studio_id_1=ch.course_id)
        where r.poll='".$survey."'
        and m.studio_id_1='".$id."'";
        $questions_edx = collect(DB::connection('pgsql')->select($sql));


        if($survey==1){
            $sql="select tq.question_parent,tq.question_id,ta.display_name_es,ta.answer_id FROM control_panel_course_template_answer_survey ta
            INNER JOIN control_panel_course_template_question_survey tq on(ta.question_id=tq.id)
            where tq.poll='".$survey."'
            order by CAST(tq.question_id AS INTEGER),CAST(ta.answer_id AS INTEGER) asc";

        }
        if($survey==3){
            $sql="select tq.question_parent,tq.question_id,ta.display_name_es,ta.answer_id FROM control_panel_course_template_answer_survey ta
            INNER JOIN control_panel_course_template_question_survey tq on(ta.question_id=tq.id)
            where tq.poll='".$survey."'
            order by CAST(ta.answer_id AS INTEGER) asc ,tq.question_id asc";

        }

        $answers_template = collect(DB::connection('pgsql')->select($sql));

        $sql="select an.display_name,an.answer_id,ta.id as id_template,an.question_parent,tq.question_id from  control_panel_course_resource_answers an
        left JOIN control_panel_course_template_answer_survey ta on(ta.answer_id=an.answer_id)
        left JOIN control_panel_course_template_question_survey tq on(ta.question_id=tq.id)
        INNER JOIN control_panel_course_resources r on(r.module_id=an.resource_id)
        inner join control_panel_course_verticals v on(v.module_id=r.vertical_id)
        inner join control_panel_course_sequentials s on(s.module_id=v.sequential_id)
        inner join control_panel_course_chapters ch on(ch.module_id=s.chapter_id)
        INNER JOIN metadata_courses m on(m.studio_id_1=ch.course_id)
        where r.poll='".$survey."'
        and m.studio_id_1='".$id."'";
        $answers_edx = collect(DB::connection('pgsql')->select($sql));


        return view('course.course_survey', compact('questions_template','questions_edx','answers_template','answers_edx'));

    }
}
