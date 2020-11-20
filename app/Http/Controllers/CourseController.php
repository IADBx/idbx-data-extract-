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
            $courses=Course::where('name', 'ilike', '%'.trim($search).'%')->orderBy('name', 'asc')->paginate(25);
            #dd($courses);

        }
        else{
            $courses = Course::paginate(25);
        }
        return View('course.index')->with('data',$courses);
    }

    public function dashboard($id)
    {    
        
        $report=Report::where('course_id','=',$id)->firstOrFail();                
        $report_all = Report::where('group_name','=',$report->group_name)->where('end_date',"<",$report->start_date)->get();
        $registered=round($report_all->avg('registrado'));
        $registered_in_date=round($report_all->avg('in_date'));
        $participants=round($report_all->avg('participant'));
        $certificates=round($report_all->avg('certificate'));
        $countries=round($report_all->avg('country'));
        $report_group = array($registered, $registered_in_date,$participants,$certificates,$countries);
        $registered=0;
        $registered_in_date=0;
        $participants=0;
        $certificates=0;
        $report_type = Report::where('type','=',$report->type)->where('language','=',$report->language)->where('end_date',"<=",$report->end_date)->get();
        $registered=round($report_type->avg('registrado'));
        $registered_in_date=round($report_type->avg('in_date'));
        $participants=round($report_type->avg('participant'));
        $certificates=round($report_type->avg('certificate')); 
        $countries=round($report_type->avg('country'));
        $report_type = array($registered, $registered_in_date,$participants,$certificates,$countries); 

        $registered=0;
        $registered_in_date=0;
        $participants=0;
        $certificates=0;              
        $report_all = Report::where('group_name','=',$report->group_name)->where('end_date',"<=",$report->end_date)->get();
        $registered=round($report_all->avg('registrado'));
        $registered_in_date=round($report_all->avg('in_date'));
        $participants=round($report_all->avg('participant'));
        $certificates=round($report_all->avg('certificate'));
        $countries=round($report_all->avg('country'));
        $report_group_all = array($registered, $registered_in_date,$participants,$certificates,$countries);



        #dd($registrados);
        return view('course.dashboard', compact('report','report_group','report_type','report_group_all'));
    }    

    public function surveyMqi(Request $request)
    {
        $report=Report::where('course_id','=',$request->get('course_id'))->firstOrFail(); 
        $mqi_data=[];
        array_push($mqi_data,$report->mqi);

        return response()->json(['mqi'=>$mqi_data]);

    }

    public function surveyInitial(Request $request)
    {
        $answers_display_name_old=[];
        $answers_total_old=[];
        $answers_percentage_old=[];  
        $sql="select * from metadata_courses where  studio_id_1='".$request->get('course_id')."'";
        $course = DB::connection('pgsql')->select($sql);
        $course_collection=collect($course);
        $edition_course=$course_collection->first()->edition;
        $start_date=$course_collection->first()->start_date;
        $time = strtotime($start_date);
        $year_course = date('Y',$time);

        if($year_course>=2020){
            $sql = "select ta.display_name_es as display_name,d.total,d.percentage from control_panel_course_answers_students d
            INNER JOIN control_panel_course_resource_questions q on(d.question_id=q.module_id)
            INNER JOIN control_panel_course_resource_answers an on(d.answer_id=an.module_id)
            INNER JOIN control_panel_course_template_answer_survey ta on(an.answer_id = ta.answer_id)
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

        } else{
            $sql ="select ta.display_name_es,d.total,d.percentage from control_panel_course_answers_students_old d
            INNER JOIN control_panel_course_template_answer_survey ta on(d.answer_id = CAST (ta.answer_id AS INTEGER))
            INNER JOIN control_panel_course_template_question_survey tq on(ta.question_id=tq.id)
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

        }  

        $sql="select * from metadata_courses
        where \"Course_Name_AllEditions\"=(select \"Course_Name_AllEditions\" from metadata_courses 
        where studio_id_1='".$request->get('course_id')."')
        and start_date < (select start_date from metadata_courses 
        where studio_id_1='".$request->get('course_id')."')";
        $answers = DB::connection('pgsql')->select($sql); 
        $answers_collection=collect($answers);

        if($answers_collection->count()>0){
            $old_data= 1;
            /*
            $sql ="select sum(d.total) as total,ta.display_name_es as display_name from control_panel_course_answers_students_old d
            INNER JOIN control_panel_course_template_answer_survey ta on(d.answer_id = CAST (ta.answer_id AS INTEGER))
            INNER JOIN control_panel_course_template_question_survey tq on(ta.question_id=tq.id)
            INNER JOIN metadata_courses c on(d.course_id=c.id)
            where d.poll=1
            and c.\"Course_Name_AllEditions\"=(select \"Course_Name_AllEditions\" from metadata_courses 
            where studio_id_1='".$request->get('course_id')."')
            and c.start_date < (select start_date from metadata_courses 
            where studio_id_1='".$request->get('course_id')."')
            and tq.question_id='".$request->get('question')."'
            GROUP BY ta.id,ta.display_name_es
            ORDER BY ta.id asc";    
            */
            $sql="Select display_name,sum(total) as total
            from
            ((select sum(d.total) as total,ta.display_name_es as display_name 
            from control_panel_course_answers_students_old d
            INNER JOIN control_panel_course_template_answer_survey ta on(d.answer_id = CAST (ta.answer_id AS INTEGER))
            INNER JOIN control_panel_course_template_question_survey tq on(ta.question_id=tq.id)
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
            INNER JOIN control_panel_course_template_answer_survey ta on(an.answer_id = ta.answer_id)
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
            $sample=$answers_collection->sum('total');          

            foreach ($answers_collection as $answer) {
                array_push($answers_display_name_old,$answer->display_name);
                array_push($answers_total_old,$answer->total);
                array_push($answers_percentage_old,round(($answer->total/$sample)*100,2));
            }        

        }else{
            $old_data= 0;
        }

        $sql="Select display_name,sum(total) as total
        from
        ((select sum(d.total) as total,ta.display_name_es as display_name 
        from control_panel_course_answers_students_old d
        INNER JOIN control_panel_course_template_answer_survey ta on(d.answer_id = CAST (ta.answer_id AS INTEGER))
        INNER JOIN control_panel_course_template_question_survey tq on(ta.question_id=tq.id)
        INNER JOIN metadata_courses c on(d.course_id=c.id)
        where d.poll=1
        and trim(c.language)=trim((select language from metadata_courses 
        where studio_id_1='".$request->get('course_id')."'))
        and c.end_date <= (select end_date from metadata_courses 
        where studio_id_1='".$request->get('course_id')."')
        and trim(c.type)=trim((select type from metadata_courses 
            where studio_id_1='".$request->get('course_id')."'))
        and tq.question_id='".$request->get('question')."'
        and c.studio_id_1 not in('".$request->get('course_id')."')
        GROUP BY ta.id,ta.display_name_es
        ORDER BY ta.id asc)
        UNION ALL
        (select sum(CAST (d.total AS INTEGER)) as total,ta.display_name_es as display_name  
        from control_panel_course_answers_students d
        INNER JOIN control_panel_course_resource_questions q on(d.question_id=q.module_id)
        INNER JOIN control_panel_course_resource_answers an on(d.answer_id=an.module_id)
        INNER JOIN control_panel_course_template_answer_survey ta on(an.answer_id = ta.answer_id)
        inner JOIN control_panel_course_resources r on (r.module_id=q.resource_id)
        INNER JOIN control_panel_course_verticals v on(v.module_id=r.vertical_id)
        INNER JOIN control_panel_course_sequentials s on (s.module_id=v.sequential_id)
        INNER JOIN control_panel_course_chapters ch on(ch.module_id=s.chapter_id)
        INNER JOIN metadata_courses c on(ch.course_id=c.studio_id_1)
        where  q.question_id='".$request->get('question')."' and v.poll='1'
        and trim(c.language)=trim((select language from metadata_courses 
            where studio_id_1='".$request->get('course_id')."'))
        and c.end_date <= (select end_date from metadata_courses 
            where studio_id_1='".$request->get('course_id')."')
        and trim(c.type)=trim((select type from metadata_courses 
            where studio_id_1='".$request->get('course_id')."'))
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

        
        return response()->json(['display_name_historical'=>$answers_display_name_historical,'total_historical'=>$answers_total_historical,'percentage_historical'=>$answers_percentage_historical,'edition_course'=>$edition_course,'year_course'=>$year_course,'display_name_old'=>$answers_display_name_old,'total_old'=>$answers_total_old,'percentage_old'=>$answers_percentage_old,'display_name'=>$answers_display_name,'total'=>$answers_total,'percentage'=>$answers_percentage,'old_data'=>$old_data]);
        
    }

    public function surveySatisfaction(Request $request)
    {
        $sql= "select d.*,q.display_name from control_panel_course_report_satisfaction d
        INNER JOIN control_panel_course_resource_questions q on(d.question_id=q.question_id)
        inner JOIN control_panel_course_resources r on (r.module_id=q.resource_id)
        INNER JOIN control_panel_course_verticals v on(v.module_id=r.vertical_id)
        INNER JOIN control_panel_course_sequentials s on (s.module_id=v.sequential_id)
        INNER JOIN control_panel_course_chapters ch on(ch.module_id=s.chapter_id)
        where ch.course_id='".$request->get('course_id')."' and q.question_parent='".$request->get('question')."' and v.poll='3'
         order by q.display_name desc";            
        $answers = DB::connection('pgsql')->select($sql);
        $answers_collection=collect($answers);  
        $answers_display_name=[];
        $answers_total=[];
        $answers_percentage=[];
        $answers_average_question=[];        

        foreach ($answers_collection as $answer) {
            array_push($answers_display_name,$answer->display_name);
            array_push($answers_average_question,$answer->average_question);
            $total_sample=$answer->total_sample;
        }
        
        
        return response()->json(['display_name'=>$answers_display_name,'average_question'=>$answers_average_question,'total_sample'=>$total_sample]);
        
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
        #$course = Course::find($id)->chapters;
        $data=Course::with(['chapters.sequentials.verticals.resources.questions.students.answer','chapters.sequentials.verticals.resources.comments'])->find($id);
        #dd($data);
        return view('course.course', compact('data'));
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
}
