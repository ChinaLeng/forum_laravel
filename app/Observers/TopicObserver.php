<?php
namespace App\Observers;
use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;

class TopicObserver
{
	/**
	 * 监听数据即将保存的事件。
	 * @param  Topic  $topic [description]
	 * @return [type]        [description]
	 */
    public function saving(Topic $topic)
    {
    	// XSS 过滤
        $topic->body = clean($topic->body, 'user_topic_body');
 		// 生成话题摘录
        $topic->excerpt = make_excerpt($topic->body);
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
/*        if ( ! $topic->slug) {
            // $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }*/
    }
    /**
     * 监听数据保存后的事件。
     * @param  Topic  $topic [description]
     * @return [type]        [description]
     */
    public function saved(Topic $topic)
    {
        // 如 slug 字段无内容，即使用翻译器对 title 进行翻译
        if ( ! $topic->slug) {

            // 推送任务到队列
            dispatch(new TranslateSlug($topic));
        }
    }
}