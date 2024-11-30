<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('app.pages');
        $pages = Post::whereType('page')->orderBy('id', 'desc')->paginate(10);

        return view('admin.posts.index', compact('title', 'pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('app.pages');
        return view('admin.posts.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'title'     => 'required',
            'post_content'   => 'required',
        ];
        $this->validate($request, $rules);

        $show_in_header_menu = $request->show_in_header_menu ? 1:0;
        $show_in_footer_menu = $request->show_in_footer_menu ? 1:0;

        $slug = unique_slug($request->title, 'Post');
        $data = [
            'user_id'               => $user->id,
            'title'                 => $request->title,
            'slug'                  => $slug,
            'post_content'          => $request->post_content,
            'type'                  => 'page',
            'status'                => 1,
            'show_in_header_menu'   => $show_in_header_menu,
            'show_in_footer_menu'   => $show_in_footer_menu,
        ];

        $post_created = Post::create($data);

        if ($post_created){
            return redirect(route('pages'))->with('success', trans('app.page_has_been_created'));
        }
        return redirect()->back()->with('error', trans('app.error_msg'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $title = trans('app.edit_page');
        $page = Post::whereSlug($slug)->first();
        return view('admin.posts.edit', compact('title', 'page'));
    }

    public function update(Request $request, $slug){
        $rules = [
            'title'     => 'required',
            'post_content'   => 'required',
        ];
        $this->validate($request, $rules);
        $page = Post::whereSlug($slug)->first();

        $show_in_header_menu = $request->show_in_header_menu ? 1:0;
        $show_in_footer_menu = $request->show_in_footer_menu ? 1:0;

        $data = [
            'title'                 => $request->title,
            'post_content'          => $request->post_content,
            'status'                => 1,
            'show_in_header_menu'   => $show_in_header_menu,
            'show_in_footer_menu'   => $show_in_footer_menu,
        ];

        $post_update = $page->update($data);
        if ($post_update){
            return redirect()->back()->with('success', trans('app.page_has_been_updated'));
        }
        return redirect()->back()->with('error', trans('app.error_msg'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $slug = $request->slug;
        $page = Post::whereSlug($slug)->first();
        if ($page){
            $page->delete();
            return ['success' => 1, 'msg' => trans('app.operation_success')];
        }
        return ['success' => 0, 'msg' => trans('app.error_msg')];
    }
}
