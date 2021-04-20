@extends('layouts.app')

@section('content')
<div class="card-header">{{ $user->name }}の投稿</div>
<div class="card-body">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @foreach($user->posts as $post)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <h6 class="card-title">
                    投稿者:
                    <a href="{{ route('users.show', $post->user_id) }}">{{ $post->user->name }}</a>
                    カテゴリー:
                    <a href="{{ route('posts.index', ['category_id' => $post->category_id]) }}">
                        {{ $post->category->category_name }}
                    </a>
                    ハッシュタグ:
                    @foreach($post->tags as $tag)
                        <a href="{{ route('posts.index', ['tag_name' => $tag->tag_name]) }}">
                            #{{ $tag->tag_name }}
                        </a>
                    @endforeach
                    <h6>{{ $post->created_at }}</h6>
                </h6>
                <hr>

                <p class="card-text">{!! nl2br($post->content) !!}</p>

                <div style="text-align: center">
                    <img src="{{ asset('storage/image/'.$post->image) }}" class="rounded img-fluid">
                </div>
                <hr>

                @guest
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">詳細</a>
                    <a href="{{ route('comments.create', ['post_id' => $post->id]) }}" class="btn btn-primary">コメントする</a>
                @else
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">詳細</a>
                    <a href="{{ route('comments.create', ['post_id' => $post->id]) }}" class="btn btn-primary">コメントする</a>
                    
                    @if(Auth::id() === $post->user_id)
                    {{-- 削除ボタン --}}
                    <form
                        style="display: inline-block;"
                        method="POST"
                        action="{{ route('posts.destroy', $post->id) }}"
                    >
                        @csrf
                        @method('DELETE')

                        <input type="submit" value="削除" class="btn btn-danger" onclick='return confirm("投稿を削除しますか？");'>
                    </form>
                    @endif
                @endguest
            </div>
        </div>
    @endforeach
</div>
@endsection