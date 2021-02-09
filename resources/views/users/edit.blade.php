<!-- Modal -->
<div class="modal fade" id="edit-user_{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" id="frm-upduser_{{$user->id}}" method="post">
            @csrf
            @method('put')
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{__('Edit a user')}}</h4>
                    <p class="card-category">{{ __('Update a user') }}</p>
                </div>
                <div class="card-body">
                    
                    <div class="row">
                        <label class="col-sm-3 col-form-label" for="input-name">{{ __('Name') }}</label>
                        <div class="col-sm-8">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <input class="input-name-ed form-control{{ $errors->has('name') ? ' is-invalid' : ''}}" input type="text" name="name"  placeholder="{{__('Name')}}" value="{{$user->name}}" required maxlength="150"/>
                                <span id="" class="name-error error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                              
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3 col-form-label" for="input-email-ed">{{ __('Email') }}</label>
                        <div class="col-sm-8">
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <input class="input-email-ed form-control{{ $errors->has('email') ? ' is-invalid' : ''}}" input type="email" name="email"  placeholder="{{__('Email')}}" value="{{$user->email}}" required maxlength="100"/>
                                
                                <span id="" class="email-error error text-danger" for="input-email">{{ $errors->first('name') }}</span>
                              
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label" for="input-password-ed">{{ __('Password') }}</label>
                        <div class="col-sm-8">
                          <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" type="password" placeholder="{{ __('Password') }}" value=""  maxlength="15"/>
                            
                              <span id="" class="password-error error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                            
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3 col-form-label" for="input-type-ed">{{ __('Type User') }}</label>
                        <div class="col-sm-8">
                          <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                            <select required class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" id="input-type-ed-{{$user->id}}" >
                                <option value="">Choose a type</option>
                                <option value="1" @if($user->type==1)  {{' selected' }}  @endif">Admin</option>
                                <option value="0" @if($user->type==0)  {{' selected' }}  @endif">User</option>
                            </select>
                            
                              <span id="" class="type-error error text-danger" for="input-type">{{ $errors->first('type') }}</span>
                            
                          </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn-updus btn btn-primary" data-user="{{$user->id}}">{{__('Save Changes')}}</button>
                      </div>
            </div>
          </form>
        </div>
       
      </div>
    </div>
  </div>