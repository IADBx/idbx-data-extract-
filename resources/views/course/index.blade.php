@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Courses')])

@section('content')
<div class="content">
  <div class="container-fluid">
      <div class="row justify-content-end">
        <div class="col-md-6">
          <form class="navbar-form">
            <div class="input-group no-border">


            <input type="text" value="" name="q" class="form-control" placeholder="Search...">
            <button type="submit" value="Search" class="btn btn-white btn-round btn-just-icon">
              <i class="material-icons">search</i>
              <div class="ripple-container"></div>
            </button>
            </div>
          </form>
        </div>
      </div>
    
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Courses</h4>
            <p class="card-category"> Course List</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>
                    Id
                  </th>
                  <th>
                    Name
                  </th>
                  <th>
                    Options
                  </th>
                </thead>
                <tbody>
                  @foreach($data as $course)
                  <tr>
                      <td>{{$course->id}}</td>
                      <td>{{$course->name}}</td>
                      <td>
                      
                        <a href="{{ route('courses.show',$course->id) }}" class="btn btn-warning">Structure</a>
                        <a href="{{ route('course.dashboard',$course->id) }}" class="btn btn-primary">View</a>
                        
                      </td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
              {{ $data->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

