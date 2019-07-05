<?php

namespace App\Http\Controllers\Index;

use App\Models\Replie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * 评论
     * @param  ReplyRequest $request [description]
     * @param  Reply        $reply   [description]
     * @return [type]                [description]
     */
    public function store(ReplyRequest $request, Replie $reply)
    {
    	 // XSS 过滤
    	$content = clean($request->get('content'), 'user_topic_body');
        if (empty($content)) {
            return redirect()->back()->withErrors('回复内容错误！');
        }
        // dd($request->all());
        $reply->content = $content;
        $reply->user_id = Auth::id();
        $reply->topic_id = $request->topic_id;
        $reply->save();

        return redirect()->to($reply->topic->link())->with('success', '评论创建成功！');
    }
	/**
	 * 删除评论
	 * @param  Reply  $reply [description]
	 * @return [type]        [description]
	 */
    public function destroy(Replie $reply)
    {
        $this->authorize('destroy', $reply);
        $reply->delete();

        return redirect()->route('replies.index')->with('success', '评论删除成功！');
    }
}
