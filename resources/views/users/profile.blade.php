@extends('layouts.app')

@section('content')

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                   		Profile
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="/uploads/avatars/{{ $user->image }}" alt="avatar" class="img-thumbnail">
                            </div>
                            @if(Auth::user() !== null )
                                @if( Auth::user()->id == $user->id )
                                    <div class="col-md-10">
                                        <form class="form-horizontal" method="POST" action="{{ route('user.update_avatar' , $user->id ) }}" enctype="multipart/form-data">

                                            {{ csrf_field() }}

                                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                                <label for="image" class="col-md-2 control-label">Update Your Avatar :</label>

                                                <div class="col-md-6">
                                                    <input id="image" type="file" class="form-control" name="image">

                                                    @if ($errors->has('image'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('image') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <button type="submit" class="btn btn-primary">
                                                        Update !
                                                </button>
                                            </div>

                                        </form>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div><strong>Name :</strong>  {{ $user->name }}</div>
                                <div><strong>Email :</strong> {{ $user->email }}</div>
                                <div><strong>Type :</strong> {{ $user->user_type->name }}</div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

@endsection
