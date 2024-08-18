<div class="col">
    <div class="card article h-100">
        <a href="{{route('articles.show', $article)}}" class="card-clickable-body">
            <div class="img-container">
                <h5><span class="badge badge-top-right">{{ $article->category->name }}</span></h5>
                <img src="{{asset($article->getThumbnailUrlAttribute())}}" class="card-img-top img-article" alt="{{$article->slug}}">
            </div>
            <div class="card-body">
                <h5 class="card-title
                ">{{ $article->title }}</h5>
                <p class="card-text flex-grow-1">{!! $article->getShortContentAttribute() !!}</p>
    
                {{-- show the tags --}}
                <div class="d-flex flex-wrap">
                    @foreach ($article->tags->take(5) as $tag)
                        <h6><span class="badge bg-secondary mr-2 mb-2">{{ $tag->name }}</span></h6>
                    @endforeach
                </div>
    
                {{-- show the date --}}
                <p class="card-text mt-2"><small class="text-muted">{{ $article->created_at->diffForHumans() }}</small></p>
    
            </div>
        </a>
        <div class="card-footer mt-auto">
            {{-- show share button --}}
            <button class="btn btn-secondary" onclick="copyLink('{{ route('articles.show', $article) }}')">
                <i class="bi bi-share-fill"></i>
            </button>

            @auth
                @if ($article->user_id == Auth::user()->id || Auth::user()->isAdmin())
                    @isset($action)
                        <a href="{{ route('management.articles.edit', $article->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil-square mx-2"></i>
                        </a>
                        <form action="{{ route('management.articles.destroy', $article) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash mx-2"></i>
                            </button>
                        </form>
                    @endisset
                @endif
            @endauth

            {{-- Show Author --}}
            <div class="btn">
                <i class="bi bi-person"></i> <small>{{ $article->user->name }} </small> 
            </div>

        </div>
    </div>
</div>