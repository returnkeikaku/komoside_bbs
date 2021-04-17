<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;

use App\Post;
use App\Tag;

use \InterventionImage;

use Intervention\Image\Facades\Image; // Imageファサードを使う
use Illuminate\Support\Facades\Storage; // Storageファサードを使う

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q = \Request::query();

        if(isset($q['category_id'])){
            $posts = Post::latest()->where('category_id', $q['category_id'])->paginate(10);
            $posts->load('category', 'user');

            return view('posts.index', [
                'posts' => $posts,
                'category_id' => $q['category_id']
            ]);
        }
        if(isset($q['tag_name'])){

            $posts = Post::latest()->where('content', 'like', "%{$q['tag_name']}%")->paginate(10);
            $posts->load('category', 'user', 'tags');

            return view('posts.index', [
                'posts' => $posts,
                'tag_name' => $q['tag_name']
            ]);
        }
        else{
            $posts = Post::latest()->paginate(10);
            $posts->load('category', 'user');

            return view('posts.index', [
                'posts' => $posts,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $post = new Post;
        $post->user_id = $request->user_id;
        $post->category_id = $request->category_id;
        $post->content = $request->content;
        $post->title = $request->title;

        //IPアドレス取得
        $post->ip_address = $request->ip();
                
        //対象のテキスト内にurlが書き込まれたらハイパーリンクにする
        $pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
        $replace = '<a href="$1" target="_blank">$1</a>';
        $post->content = preg_replace( $pattern, $replace, $post->content );

        //imageを変数に入れる
        $sample_img = $request->file('image');
            
        //画像ファイルが添付されていたら以下の処理
        if(isset($sample_img)){

            $filename = $request->file('image')->store('public/image');                   

            $post->image = basename($filename);

            //画像リサイズ
            $resized_image = Image::make($request->file('image'))->fit(524, 324);
            //画像の回転とEXIF情報の処理
            $resized_image->orientate()->save();
            //ファイル保存
            Storage::put('/' . $filename, $resized_image); 
        }
        //画像ファイルが添付されていなかったらデフォルトのnoimageの画像を表示
        else{  

            $post->image = basename('storage/image/noimage.jpg');

        }                    

        // contentからtagを抽出
        preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $request->content, $match);

        $tags = [];
        foreach ($match[1] as $tag) {
            $found = Tag::firstOrCreate(['tag_name' => $tag]);

            array_push($tags, $found);
        }

        $tag_ids = [];

        foreach ($tags as $tag) {
            array_push($tag_ids, $tag['id']);
        }

        $post->save();
        $post->tags()->attach($tag_ids);            

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load('category', 'user', 'comments.user');

        return view('posts.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($post_id)
    {
        $post = Post::findOrFail($post_id);

        \DB::transaction(function () use ($post) {
            $post->comments()->delete();
            $post->delete();
        });

        return redirect('/');
    }

    public function search(Request $request)
    {
        $posts = Post::where('title', 'like', "%{$request->search}%")
                ->orWhere('content', 'like', "%{$request->search}%")
                ->paginate(10);
        

        $search_result = $request->search.'の検索結果'.$posts->total().'件';

        return view('posts.index', [
            'posts' => $posts,
            'search_result' => $search_result,
            'search_query'  => $request->search
        ]);
    }
}
