<?php

namespace App\Observers;

use App\Models\Replie;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplieObserver
{
    public function created(Replie $reply)
    {
        // $reply->topic->increment('reply_count', 1);
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();
    }
/*    public function creating(Replie $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }*/
}