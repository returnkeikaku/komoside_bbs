@extends('layouts.app')

@section('content')
<div class="card-header">詳細一覧</div>
<div class="card-body">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    
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
                <img src="{{ asset('storage/image/'.$post->image) }}" class="rounded">
            </div>
        </diV>
    </div>
    <br>

    <div class="home_button row justify-content-center">
        <a href="{{ route('comments.create', ['post_id' => $post->id]) }}" class="btn btn-primary">コメントする</a>
    </div>
    
    <div class="p-3">
        <h6 class="card-title">コメント一覧</h6>
        @foreach($post->comments as $comment)
            <div class="card">
                <div class="card-body">
                    <p class="card-text">{!! nl2br($comment->comment) !!}</p>
                    <p class="card-text">
                        投稿者:
                        <a href="{{ route('users.show', $comment->user->id) }}">
                            {{ $comment->user->name }}
                        </a>
                    </p>
                    <p>{{ $comment->created_at }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
