@extends('layouts.app')

@section('content')

<div class="container">
    @foreach( $posts as $post )
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-8">
                           <a href="{{ route('posts.show' , $post->id ) }}">{{ $post->title }}</a>
                           
                        </div>
                        <div class="col-md-4" >
                            {{ $post->created_at->diffForHumans() }} , by : <a href="{{ route('users.profile' , $post->user_id) }}">{{ $post->user->name }}</a> 
                        </div> 
                    </div>

                    </div>

                    <div class="panel-body">
                        <a href="{{ route('posts.show' , $post->id ) }}"><img src="/uploads/images/{{ $post->image }}" class="img-responsive" alt="Responsive image"></a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection


