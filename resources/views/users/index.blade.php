@extends('layouts.app',  ['activePage' => 'Admin User', 'titlePage' => __('Admin User')])
@section('content')
<div class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">Users</h4>
                <p class="card-category"></p>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-12 text-right">
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add-user">Add user</a>
                        @include('users.new')
                    </div>
                </div> 
                <div class="row mx-auto col-md-10">
                    <div class="table-responsive">
                    <table class="table table-stripped table-hover">
                        <thead class="text-primary">
                        <tr><th>
                            Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Type
                        </th>
                        <th>
                            Creation date
                        </th>
                        <th class="text-center" colspan="2">
                            Actions
                        </th>
                        </tr></thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                            <td>
                                {{$user->name}}
                            </td>
                            <td>
                                {{$user->email}}
                            </td>
                            <td>
                                @if($user->type==1)
                                <span class="badge badge-success">Admin</span>
                                @else
                                <span class="badge badge-secondary">User</span>
                                @endif
                            </td>
                            <td>
                                {{ date('d/m/Y',strtotime($user->created_at)) }}
                            </td>
                            @include('users.edit')
                            <td class="td-actions text-right">
                                <a rel="tooltip" class="btn btn-success btn-link" data-toggle="modal" data-target="#edit-user_{{$user->id}}" data-user="{{$user->id}}">
                                    <i class="material-icons">edit</i>
                                    <div class="ripple-container"></div>
                                </a>
                            </td>
                            <td class="td-actions text-right">
                                <form method="post" class="frm-usdel">
                                    @csrf
                                <input type="hidden" name="_method" value="DELETE" />
                                <button type ="button" rel="tooltip" class="btn-delus btn btn-success btn-link" href="#" data-original-title="" title="" data-user="{{$user->id}}">
                                    <i class="material-icons">delete</i>
                                    <div class="ripple-container"></div>
                                </button>
                                </form>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$users->links()}}
                    </div>
                                        
                    @if (session('status_deleted'))
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="alert alert-danger">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                          </button>
                          <span>{{ session('status_deleted') }}</span>
                        </div>
                      </div>
                    </div>
                  @endif
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
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        
        $("#btn-nuser").on('click',function (e){
            e.preventDefault();
            let data = $("#frm-newuser").serializeArray();
            $('.error').removeClass('error');
            $('span').html('');
            $.ajax({
                type:'POST',
                url:"{{route('user.store')}}",
                data: data
            }).done(data => {
                $("#add-user").modal('hide');
                Swal.fire(
                'User saved!',
                'The user was created successfully',
                'success'
                );
                let page = location.href.split("?")[1];
                let url =  location.href.split("?")[0];
                location.href = url + "?" +page;
            }).fail(errors => {
                let error = errors.responseJSON.errors
                $.each(error, function(i,v){
                    $('#' + i+ '-' +'error').addClass('error');
                    $('#' + i+ '-' +'error').html(v);
                });
            })
        });

        $(".btn-updus").on('click',function (e){
            e.preventDefault();
            let elem = $(this);
            let id = elem.data('user');
            let data = $("#frm-upduser_"+id).serializeArray();
            
            $('.error').removeClass('error');
            $('span').html('');
                        
            $.ajax({
                type:'POST',
                url:"user/"+id,
                data: data,
            }).done(data => {
                $("#edit-user_"+id).modal('hide');
               
                Swal.fire(
                 'User updated!',
                'The user was created successfully',
                'success'
                );
                let page = location.href.split("?")[1];
                let url =  location.href.split("?")[0];
                location.href = url + "?" +page;
            }).fail(errors => {
                let error = errors.responseJSON.errors
                
                $.each(error, function(i,v){
                    $('.' + i+ '-' +'error').addClass('error');
                    $('.' + i+ '-' +'error').html(v);
                });
            })
        });

        $(".btn-delus").on('click', function (e){
            e.preventDefault();
            let data = $(".frm-usdel").serializeArray();
            let elem = $(this);
            $('.error').removeClass('error');
            $('span').html('');
            var id = elem.data('user');
            
            swal.fire({
  				title: 'Are you sure?',
  				text: "You won't be able to revert this!",
  				type: 'warning',
  				showCancelButton: true,
  				confirmButtonColor: '#3085d6',
  				cancelButtonColor: '#d33',
  				confirmButtonText: 'Yes, delete it!'
					}).then((result) => {

						if(result.value){
                            $.ajax({
                                type:'DELETE',
                                url: "user/"+id
                            }).done(data => {
                                swal.fire(
      							'Deleted!',
      							'The user has been deleted.',
                                  'success')
                            let page = location.href.split("?")[1];
                            let url =  location.href.split("?")[0];
                            location.href = url + "?" +page;                                
                            }).fail(error => {
							swal.fire("Failed!", "There was something wrong","warning");
						})	
					}
				})
        });

        let input_name = $('#input-name');
        let input_name_ed= $(".input-name-ed");
        let input_email = $('#input-email');
        let input_email_ed = $('.input-email-ed');
        let input_password = $("#input-password");
        let input_type = $("#input-type");
        let input_type_ed = $(".input-type-ed");

        input_name.on('keyup',function (e){
            $('.error').removeClass('error');
            $('#name-error').html('');
            if(input_name.val().length==0){
                $('#name-error').addClass('error');
                $('#name-error').html('The name field is required.');
                
            }    
        });
        
        input_name_ed.on('keyup',function (e){
            $('.error').removeClass('error');
            $('.name-error').html('');
            if(input_name_ed.val().length==0){
                $('.name-error').addClass('error');
                $('.name-error').html('The name field is required.');
                
            }    
        });

        input_email.on('keyup', function(e){
            $('.error').removeClass('error');
            $('#email-error').html('');
            if(input_email.val().length==0){
                $('#email-error').addClass('error');
                $('#email-error').html('The email field is required.');
            }    
        });

        input_email_ed.on('keyup', function(e){
            $('.error').removeClass('error');
            $('.email-error').html('');
            if(input_email_ed.val().length==0){
                $('.email-error').addClass('error');
                $('.email-error').html('The email field is required.');
            }    
        });
        
        input_password.on('keyup', function (e){
            $('.error').removeClass('error');
            $('#password-error').html('');
            if(input_password.val().length==0){
                $('#password-error').addClass('error');
                $('#password-error').html('The password field is required.');
            }
        });
        
        input_type.on('change', function (e){
            $('.error').removeClass('error');
            $('#type-error').html('');
            if(input_type.val()==''){
                $('#type-error').addClass('error');
                $('#type-error').html('The type field is required.');
            }
        });

        input_type_ed.on('change', function (e){
            $('.error').removeClass('error');
            $('.type-error').html('');
            if(input_type_ed.val()==''){
                $('.type-error').addClass('error');
                $('.type-error').html('The type field is required.');
            }
        });
     
      });
</script>
@endpush

