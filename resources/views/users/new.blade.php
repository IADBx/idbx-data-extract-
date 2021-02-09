<!-- Modal -->
<div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-horizontal" method="post" id="frm-newuser">
            @csrf
            
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{__('Add a new user')}}</h4>
                    <p class="card-category">{{ __('Create a new user') }}</p>
                </div>
                <div class="card-body">
                
                    <div class="row">
                        <label class="col-sm-3 col-form-label" for="input-name">{{ __('Name') }}</label>
                        <div class="col-sm-8">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : ''}}" input type="text" name="name" id="input-name" placeholder="{{__('Name')}}" value="" maxlength="150" />
                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3 col-form-label" for="input-email">{{ __('Email') }}</label>
                        <div class="col-sm-8">
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : ''}}" input type="email" name="email" id="input-email" placeholder="{{__('Email')}}" value="" maxlength="100"/>
                              
                                <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('name') }}</span>
                              
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label" for="input-password">{{ __('Password') }}</label>
                        <div class="col-sm-8">
                          <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="input-password" type="password" placeholder="{{ __('Password') }}" value=""  maxlength="15"/>
                            
                              <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                            
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3 col-form-label" for="input-type">{{ __('Type User') }}</label>
                        <div class="col-sm-8">
                          <div class="form-group{{ $errors->has('type') ? ' has-danger' : '' }}">
                            <select required class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" name="type" id="input-type" >
                                <option value="">Choose a type</option>
                                <option value="1">Admin</option>
                                <option value="0">User</option>
                            </select>
                            
                              <span id="type-error" class="error text-danger" for="input-type">{{ $errors->first('type') }}</span>
                            
                          </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="btn-nuser" class="btn btn-primary">{{__('Save Changes')}}</button>
                      </div>
            </div>
          </form>
        </div>
       
      </div>
    </div>
  </div>
  