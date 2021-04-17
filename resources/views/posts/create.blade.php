@extends('layouts.app')

@section('content')
<div class="card-header">投稿する</div>
<div class="card-body">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="exampleInputEmail1">タイトル（必須）</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="title" name="title">
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1">カテゴリー（当てはまらなければ"その他"を選択してください）</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="category_id">
                        <option selected="">選択する</option>
                        <option value="1">思春期、青年期のひきこもり（15歳～39歳）</option>
                        <option value="2">中高年のひきこもり（40歳～64歳）</option>
                        <option value="3">悩み事、不安なこと、困っていること</option>
                        <option value="4">自立に関すること</option>
                        <option value="5">家族に関すること</option>
                        <option value="6">他愛のない話題、ゆるい話</option>
                        <option value="7">その他</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlFile1">画像ファイル（なければデフォルト画像が表示されます）</label>
                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image">
                </div>

                <div class="form-group">
                  <label for="comment">投稿内容（必須）</label>
                  <textarea class="form-control" rows="5" id="comment" name="content"></textarea>
                </div>

                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                <button type="submit" class="btn btn-primary">送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection
