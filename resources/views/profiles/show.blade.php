@extends ('layouts.app')

@section ('content')

    <div class="container">
        <div class="row">
        </div>
        <div class="page-header">
            <h1>
                {{ $profileUser->name  }}
            </h1>
        </div>

        @foreach ($activities as $date => $activity)

            <h3 class="page-header">{{ $date }}</h3>

            @foreach($activity as $record)

                @include ('profiles.activities.'.$record->type, ['activity' => $record])

            @endforeach
        @endforeach

        {{--{{ $threads->links()  }}--}}

    </div>

@endsection