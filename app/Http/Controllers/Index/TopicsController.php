<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\Category;
use App\Http\Requests\TopicRequest;
use Auth;
use App\Handlers\ImageUploadHandler;//图片上传类

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
     * 帖子储存
     * @param TopicRequest $request
     * @param Topic $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();

        return redirect()->to($topic->link())->with('success', '帖子创建成功！');
    }

    /**
     * 帖子编辑
     * @param Topic $topic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        $categories = Category::all();
        return view('index.topics.create_and_edit', compact('topic', 'categories'));
    }

    /**文章更新
     * @param TopicRequest $request
     * @param Topic $topic
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());

        return redirect()->to($topic->link())->with('success', '更新成功！');
    }

    /**
     * 帖子删除
     * @param Topic $topic
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', '成功删除！');
    }

    /**
     * 编辑器图片上传
     * @param Request $request
     * @param ImageUploadHandler $uploader
     * @return array
     */
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success' => false,
            'msg' => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'topics', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg'] = "上传成功!";
                $data['success'] = true;
            }
        }
        return $data;
    }
}
