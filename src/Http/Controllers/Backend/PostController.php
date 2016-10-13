<?php

namespace Easel\Http\Controllers\Backend;

use Easel\Http\Controllers\Controller;
use Easel\Http\Jobs\PostFormFields;
use Easel\Http\Requests\PostCreateRequest;
use Easel\Http\Requests\PostUpdateRequest;
use Easel\Http\Requests\FileImporterRequest;
use Easel\Models\Post;
use Session;
use Carbon\Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data = Post::with('author')->get();

        return view('easel::backend.post.index', compact('data'));
    }

    /**
     * Show the new post form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = $this->dispatch(new PostFormFields());

        return view('easel::backend.post.create', $data);
    }

    /**
     * Store a newly created Post.
     *
     * @param PostCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostCreateRequest $request)
    {
        /** @var Post $post */
        $post = Post::create($request->postFillData());
        $post->syncTags($request->get('tags', []));

        Session::set('_new-post', trans('easel::messages.create_success', ['entity' => 'Post']));

        return redirect()->route('admin.post.index');
    }

    /**
     * Show the post edit form.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data = $this->dispatch(new PostFormFields($id));

        return view('easel::backend.post.edit', $data);
    }

    /**
     * Update the Post.
     *
     * @param PostUpdateRequest $request
     * @param int               $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostUpdateRequest $request, $id)
    {
        /** @var Post $post */
        $post = Post::findOrFail($id);
        $post->fill($request->postFillData());
        $post->save();
        $post->syncTags($request->get('tags', []));

        Session::set('_update-post', trans('easel::messages.update_success', ['entity' => 'Post']));

        return redirect('/admin/post/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        /** @var Post $post */
        $post = Post::findOrFail($id);
        $post->tags()->detach();
        $post->delete();

        Session::set('_delete-post', trans('easel::messages.delete_success', ['entity' => 'Post']));

        return redirect()->route('admin.post.index');
    }

    public function importFile(FileImporterRequest $request)
    {
        $delimiter = $request->get('delimiter');
        $postsFile = $request->file('posts');
        $contents = \File::get($postsFile->path());
        //$contents = nl2br($contents);
        $posts = explode($delimiter,$contents);

        //dump($posts);

        $time = Carbon::now();
        $time = $time->subDays(7);

        foreach($posts as $postText) {
            $time = $time->addMinutes(10);
            $post = Post::create([
                'title'            => "Entry {$time->timestamp}",
                'slug'             => "entry-{$time->timestamp}",
                'subtitle'         => '',
                'content_raw'      => $postText,
                'is_draft'         => 0,
                'published_at'     => $time->format('Y-m-d H:i:s'),
                'author_id'        => 1,
            ]);
        }

        Session::set('_new-post', trans('easel::messages.create_success', ['entity' => 'Post']));

        return redirect()->route('admin.post.index');

    }
}