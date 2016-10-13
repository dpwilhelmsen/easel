<?php
/**
 * Created by PhpStorm.
 * User: daniel.wilhelmsen
 * Date: 10/12/16
 * Time: 11:47 PM
 */

namespace Easel\Observers;

use Easel\Models\Post;


class PostObserver
{
    /**
     * Listen to the Post saved event.
     *
     * @param  User  $user
     * @return void
     */
    public function saved(Post $post)
    {
        $posts = Post:where('is_draft', 0)
            ->orderBy('published_at', 'asc')->all();

        $posts->each(function ($post, $key) {
            $post->post_number = $key + 1;
            $post->save();
        });
    }
}