@extends ('layouts.app')

@section ('content')

  <div class="container">

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            <a href="#">{{ $thread->creator->name }}</a> posted: {{ $thread->title }}
          </div>

          <div class="panel-body">
            {{ $thread->body }}
          </div>

        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        @foreach ($thread->replies as $reply)

          @include ('threads.reply')

        @endforeach        
      </div>
    </div>

    @if (auth()->check())
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          
          <form method="POST" action="{{ $thread->path() }}.'/replies" >
            {{ csrf_field() }}
             <div class="form-group" >
                <textarea placeholder="Have somethind to say?" rows="5 " name="body" id="body" class="form-control" ></textarea>
             </div>
             <input type="submit" class="btn btn-primary" value="Post">
          </form>

        </div>
      </div>
    @else
      <p class="text-center" >Please <a href="{{ route('login') }}">sign in</a> to participate in this discution.</p>
    @endif

  </div>

@endsection
