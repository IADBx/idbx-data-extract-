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
            $courses=Course::where('name', 'ilike', '%'.trim($search).'%')->orderBy('name', 'asc')->paginate(15);
            #dd($courses);

        }
        else{
            $courses = Course::paginate(15);
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
        #dd($registrados);
        return view('course.dashboard', compact('report','report_group','report_type'));
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
        $sql = "select an.display_name,d.total,d.percentage from control_panel_course_answers_students d
        INNER JOIN control_panel_course_resource_questions q on(d.question_id=q.module_id)
        INNER JOIN control_panel_course_resource_answers an on(d.answer_id=an.module_id)
        inner JOIN control_panel_course_resources r on (r.module_id=q.resource_id)
        INNER JOIN control_panel_course_verticals v on(v.module_id=r.vertical_id)
        INNER JOIN control_panel_course_sequentials s on (s.module_id=v.sequential_id)
        INNER JOIN control_panel_course_chapters ch on(ch.module_id=s.chapter_id)
        where ch.course_id='".$request->get('course_id')."' and q.question_id='".$request->get('question')."' and v.poll='1'";    

              
        $answers = DB::connection('pgsql')->select($sql);  
        $answers_collection=collect($answers);
        $sample=$answers_collection->sum('total');
        $answers_display_name=[];
        $answers_total=[];
        $answers_percentage=[];

        foreach ($answers_collection as $answer) {
            array_push($answers_display_name,$answer->display_name);
            array_push($answers_total,$answer->total);
            array_push($answers_percentage,$answer->percentage);
        }
        
        
        return response()->json(['display_name'=>$answers_display_name,'total'=>$answers_total,'percentage'=>$answers_percentage]);
        
    }

    public function surveySatisfaction(Request $request)
    {
        $sql= "select d.*,q.display_name from control_panel_course_report_satisfaction d
        INNER JOIN control_panel_course_resource_questions q on(d.question_id=q.question_id)
        inner JOIN control_panel_course_resources r on (r.module_id=q.resource_id)
        INNER JOIN control_panel_course_verticals v on(v.module_id=r.vertical_id)
        INNER JOIN control_panel_course_sequentials s on (s.module_id=v.sequential_id)
        INNER JOIN control_panel_course_chapters ch on(ch.module_id=s.chapter_id)
        where ch.course_id='".$request->get('course_id')."' and q.question_parent='".$request->get('question')."' and v.poll='3'";            
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
