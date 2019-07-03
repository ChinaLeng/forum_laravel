<?php
namespace App\Observers;
use App\Models\Topic;

class TopicObserver
{
	/**
	 * 监听数据即将保存的事件。
	 * @param  Topic  $topic [description]
	 * @return [type]        [description]
	 */
    public function saving(Topic $topic)
    {
        $topic->body = clean($topic->body, 'user_topic_body');

        $topic->excerpt = make_excerpt($topic->body);
    }
}