@extends ('layouts.app')

@section ('content')

  <thread-view initial-replies-count="{{ $thread->replies_count }}" inline-template >
      <div class="container">

          <div class="row">
              <div class="col-md-8">
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <div class="level">
                <span class="flex">
                    <a href="{{ route('profile', $thread->creator->name)  }}">{{ $thread->creator->name }}</a> posted:
                    {{ $thread->title }}
                </span>

                              @can('update', $thread)

                                  <form action="{{ $thread->path() }}" method="post">
                                      {{ csrf_field() }}
                                      {{ method_field('DELETE') }}

                                      <button class="btn btn-link" type="submit">Delete Thread</button>
                                  </form>

                              @endcan

                          </div>

                      </div>

                      <div class="panel-body">
                          {{ $thread->body }}
                      </div>

                  </div>

                  <replies data="{{ json_encode($replies) }}" @removed="repliesCount--" ></replies>

                  {{--@foreach ($replies as $reply)--}}

                  {{--@include ('threads.reply')--}}

                  {{--@endforeach--}}

                  {{--{{ $replies->links() }}--}}

                  @if (auth()->check())
                      <form method="POST" action="{{ $thread->path() }}.'/replies" >
                          {{ csrf_field() }}
                          <div class="form-group" >
                              <textarea placeholder="Have somethind to say?" rows="5 " name="body" id="body" class="form-control" ></textarea>
                          </div>
                          <input type="submit" class="btn btn-primary" value="Post">
                      </form>
                  @else
                      <p class="text-center" >Please <a href="{{ route('login') }}">sign in</a> to participate in this discution.</p>
                  @endif

              </div>

              <div class="col-md-4">

                  <div class="panel panel-default">

                      <div class="panel-body">
                          This thread was published {{ $thread->created_at->diffForHumans()  }} by
                          <a href="#">{{ $thread->creator->name }}</a>, and currently has <span v-text="repliesCount" ></span> {{ str_plural('comment', $thread->replies_count)  }}.
                      </div>

                  </div>

              </div>

          </div>


      </div>
  </thread-view>

@endsection
