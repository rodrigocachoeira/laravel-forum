<reply :attributes="{{ $reply }}" inline-template v-cloak>

  <div id="reply-{{ $reply->id }}" class="panel panel-default">

    <div class="panel-heading">
      <div class="level">
        <h5 class="flex" >
          <a href="{{ route('profile', $reply->owner->name)  }}" >{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}
        </h5>
        <div>
          <form method="POST" action="/replies/{{ $reply->id  }}/favorites">
            {{ csrf_field()  }}
            <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : ''    }} >
              {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
            </button>
          </form>
        </div>
      </div>
    </div>

    <div class="panel-body">

      <div v-if="editing" >
        <div class="form-group">
          <textarea v-model="body" class="form-control" name="" id="" cols="30" rows="5"></textarea>
        </div>

        <button @click="update" class="btn btn-xs btn-primary">Update</button>
        <button @click="editing = false" class="btn btn-xs btn-link">Cancel</button>
      </div>
      <div v-else v-text="body" ></div>
    </div>

    @can('update', $reply)

      <div class="panel-footer level">

        <button @click="editing = true" class="btn btn-xs mr-1">Edit</button>
        <button @click="destroy" class="btn btn-danger btn-xs">Delete</button>

      </div>

      @endif

  </div>

</reply>