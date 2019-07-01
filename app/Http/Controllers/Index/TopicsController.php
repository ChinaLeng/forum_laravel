<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\Category;
use App\Http\Requests\TopicRequest;
use Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * 文章展示
     * @param Request $request
     * @param Topic $topic
     * @return mixed
     */
    public function index(Request $request, Topic $topic)
    {
        $topics = $topic->withOrder($request->order)->paginate(20);

        return view('index.topics.index', compact('topics'));
    }

    /**
     * 文章详情
     * @param Request $request
     * @param Topic $topic
     * @return mixed
     */
    public function show(Request $request, Topic $topic)
    {
        // URL 矫正
        if ( ! empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }
        return view('index.topics.show', compact('topic'));
    }

    /**
     * 创建文章
     * @param Topic $topic
     * @return mixed
     */
    public function create(Topic $topic)
    {
        $categories = Category::all();
        return view('index.topics.create_and_edit', compact('topic', 'categories'));
    }
    /**
     * 帖子存储
     */
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

        return redirect()->route('topics.show', $topic->id)->with('success', '帖子创建成功！');
    }
}
