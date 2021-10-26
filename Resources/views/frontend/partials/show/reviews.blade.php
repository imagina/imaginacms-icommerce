<div class="reviews">

    @if($entity->approvedComments && $entity->approvedComments->count())

        @foreach($entity->approvedComments as $comment)
            <div class="review w-75 mb-3">
                <div class="card">
                  <div class="card-header">
                    Por: {{$comment->user->first_name}} {{$comment->user->last_name}}
                  </div>
                  <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <div class="comment mb-1">
                            {!! $comment->comment !!}
                        </div>
                        <footer class="blockquote-footer">
                            {{format_date($comment->created_at)}}
                        </footer>
                    </blockquote>
                  </div>
                </div>
            </div>
        @endforeach

    @else
        <div class="alert alert-info" role="alert">
            {{trans('icomments::comments.messages.not infor')}}
        </div>
    @endif

    
</div>