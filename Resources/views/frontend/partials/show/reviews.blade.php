<div class="reviews">
    @if($product->ratings && $product->ratings->count())
        @foreach($product->ratings as $rating)
            <x-icomments::comments :model="$rating" :approved="true" :showRating="setting('icommerce::showRatingInReviewsProduct')" />
        @endforeach
    @else
        <div class="alert alert-info" role="alert">
            {{trans('icomments::comments.messages.not infor')}}
        </div>
    @endif
</div>