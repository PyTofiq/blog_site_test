<div class="blogs row mt-5">
    @foreach ($blogs as $blog)
    <div class="blog col-md-3">
        <div class="card">
          <img src="{{ asset('storage/uploads/blogs/'.$blog->image) }}" class="card-img-top" alt="{{ $blog->image }}">
          <div class="card-body">
            <h5 class="card-title"><a href="{{ route('blog-details', $blog->id) }}">{{ $blog->title }}</a></h5>
            <p class="card-text">
                @if($blog->categories)
                @foreach($blog->categories as $cat)
                <span>{{$cat->name}},</span>
                @endforeach
                @endif  
            </p>
          </div>
        </div>
      </div>
    @endforeach
</div>
