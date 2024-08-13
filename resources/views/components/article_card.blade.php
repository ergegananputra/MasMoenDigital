<div class="col">
    <div class="card h-100">
        <a href="{{route('management.articles.show', $article)}}" class="card-clickable-body">
            <img src="{{asset($article->getThumbnailUrlAttribute())}}" class="card-img-top img-article" alt="...">
            <div class="card-body">
                <h5 class="card-title
                ">{{ $article->title }}</h5>
                <p class="card-text">{{ $article->getShortContentAttribute() }}</p>
    
                {{-- show the tags --}}
                <div class="d-flex flex-wrap">
                    @foreach ($article->tags as $tag)
                        <span class="badge bg-secondary mr-2">{{ $tag->name }}</span>
                    @endforeach
                </div>
    
                {{-- show the date --}}
                <p class="card-text mt-2"><small class="text-muted">{{ $article->created_at->diffForHumans() }}</small></p>
    
            </div>
        </a>
        <div class="card-footer">
            <a href="{{ route('management.articles.edit', $article->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square mx-2"></i>
            </a>
            <form action="{{ route('management.articles.destroy', $article->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash mx-2"></i>
                </button>
            </form>

            {{-- Show Author --}}
            <div class="btn">
                <i class="bi bi-person"></i> <small>{{ $article->user->name }} </small> 
            </div>

        </div>
    </div>
</div>