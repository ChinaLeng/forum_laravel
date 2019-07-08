<?php

namespace App\Observers;

use App\Models\Replie;
use App\Notifications\TopicReplied;
// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplieObserver
{
    public function created(Replie $reply)
    {
        // $reply->topic->increment('reply_count', 1);
        $reply->topic->updateReplyCount();
                // 通知话题作者有新的评论
        $reply->topic->user->notify(new TopicReplied($reply));
    }
/*    public function creating(Replie $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }*/
    public function deleted(Replie $reply)
    {
        $reply->topic->updateReplyCount();
    }
}