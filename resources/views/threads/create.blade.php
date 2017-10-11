@extends ('layouts.app')

@section ('content')

  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Create a New Thread</div>

          <div class="panel-body">
            <form action="/threads" method="POST" >
              {{ csrf_field() }}

              <div class="form-group">
                <label for="channel_id">Choose a Channel:</label>
                <select name="channel_id" id="channel_id" class="form-control" required >
                  <option value="">Chose a Channel...</option>
                  @foreach (App\Channel::all() as $channel)
                    <option  {{ old('channel_id') == $channel->id ? 'selected' : ''  }} value="{{ $channel->id  }}">
                      {{ $channel->name  }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="form-group" >
                <label for="title" >Title:</label>
                <input required type="text" name="title" id="title" class="form-control" value="{{ old('title')  }}" >
              </div>

              <div class="form-group" >
                <label for="body" >Body:</label>
                <textarea required name="body" id="body" rows="8" class="form-control" >{{ old('body')  }}</textarea>
              </div>

              <button type="submit" class="btn btn-submit btn-primary" >Publish</button>

            </form>

            <br>

            @if (count($errors))

              <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                  <li>{{ $error  }}</li>
                @endforeach
              </ul>

            @endif
          </div>

        </div>
      </div>
    </div>
  </div>

@endsection
