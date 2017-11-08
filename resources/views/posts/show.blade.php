@extends('layouts.app')

@section('content')
<div class="container">
    @if(Auth::user() !== null)
        @if( Auth::user()->id == $post->user_id || Auth::user()->user_type_id == 1 )
            <div class="row">
                <div  class="col-md-8 col-md-offset-2">
                    <a href="{{ route('posts.edit' , $post->id ) }}" style="float: right;" class="btn btn-warning">
                        Update
                    </a>
                    <form action="{{ route('post.destroy' , $post->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button  style="float: right;" class="btn btn-danger">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endif
    @endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <div class="row">
                        <div class="col-md-8">

                           {{ $post->title }}
                           
                        </div>
                        <div class="col-md-4" >
                            {{ $post->created_at->diffForHumans() }} , by : <a href="{{ route('users.profile' , $post->user_id) }}">{{ $post->user->name }}</a> 
                        </div> 
                    </div>
                </div>

                <div class="panel-body">
                    {{ $post->body }}
                </div>
            </div>
        </div>
    </div>
    <div class="row" >
        <div class="col-md-8 col-md-offset-2">
            <h4>Comments Section</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <ul class="list-group">
                @foreach($post->comments as $comment )
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-8" >{{ $comment->body }}</div>
                            <div style="text-align:right;" class="col-md-4" > {{ $comment->created_at->diffForHumans() }} , <a href="{{ route('users.profile' , $comment->user->id ) }}"> by : {{ $comment->user->name }} </a> </div>
                        </div>
                    </li>
                @endforeach  

            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Comment</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('comments.store' , $post->id) }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                            <label style="text-align:left" for="body" class="col-md-12 control-label">Comment</label><br>

                            <div class="col-md-6">
                                <textarea id="body" rows="6" class="form-control" name="body" value="{{ old('body') }}" required></textarea>
                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Comment !
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
