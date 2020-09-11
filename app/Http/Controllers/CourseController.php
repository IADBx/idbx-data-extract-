<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Course;



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
            $courses=Course::where('name', 'ilike', '%'.trim($search).'%')->orderBy('name', 'asc')->paginate(6);
            #dd($courses);

        }
        else{
            $courses = Course::paginate(6);
        }
        return View('course.index')->with('data',$courses);
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
