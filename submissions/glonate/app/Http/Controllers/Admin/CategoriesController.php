<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CategoriesController extends Controller
{

    public function index(){
        $title = trans('app.categories');
        $categories = Category::all();

        return view('admin.categories.index', compact('title', 'categories'));
    }


    public function store(Request $request)
    {
        $rules = [
            'category_name' => 'required',
            'image'         => 'image'
        ];
        $this->validate($request, $rules);

        $slug = str_slug($request->category_name);
        $duplicate = Category::where('category_slug', $slug)->count();
        if ($duplicate > 0){
            return back()->with('error', trans('app.category_exists_in_db'));
        }

        /**
         * Upload image if any
         */
        $image_name = '';
        if ($request->hasFile('image')){
            $image = $request->file('image');
            $valid_extensions = ['jpg','jpeg','png'];
            if ( ! in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions) ){
                return redirect()->back()->withInput($request->input())->with('error', 'Only .jpg, .jpeg and .png is allowed extension') ;
            }


            $upload_dir = './storage/uploads/categories/';
            if ( ! file_exists($upload_dir)){
                mkdir($upload_dir, 0777, true);
            }

            $file_base_name = str_replace('.'.$image->getClientOriginalExtension(), '', $image->getClientOriginalName());
            $resized = Image::make($image)->resize(300, 200);

            $image_name = strtolower(time().str_random(5).'-'.str_slug($file_base_name)).'.' . $image->getClientOriginalExtension();
            $imageFileName = $upload_dir.$image_name;

            try{
                $resized->save($imageFileName);
            } catch (\Exception $e){
                return $e->getMessage();
            }
        }

        $data = [
            'category_name' => $request->category_name,
            'category_slug' => $slug,
            'image' => $image_name,
        ];

        Category::create($data);
        return back()->with('success', trans('app.category_created'));
    }

    public function edit($id){
        $category = Category::find($id);
        if (! $category){
            return trans('app.invalid_request');
        }
        $title = trans('app.edit_category');

        return view('admin.categories.edit', compact('title', 'category'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return string
     */
    public function update(Request $request, $id){
        $category = Category::find($id);
        if (! $category){
            return trans('app.invalid_request');
        }

        $rules = [
            'category_name' => 'required',
            'image'         => 'image'
        ];
        $this->validate($request, $rules);

        /**
         * Upload image if any
         */
        $image_name = $category->image;
        if ($request->hasFile('image')){
            $image = $request->file('image');
            $valid_extensions = ['jpg','jpeg','png'];
            if ( ! in_array(strtolower($image->getClientOriginalExtension()), $valid_extensions) ){
                return redirect()->back()->withInput($request->input())->with('error', 'Only .jpg, .jpeg and .png is allowed extension') ;
            }

            $upload_dir = './storage/uploads/categories/';
            if ( ! file_exists($upload_dir)){
                mkdir($upload_dir, 0777, true);
            }

            $file_base_name = str_replace('.'.$image->getClientOriginalExtension(), '', $image->getClientOriginalName());
            $resized = Image::make($image)->resize(300, 200);

            $image_name = strtolower(time().str_random(5).'-'.str_slug($file_base_name)).'.' . $image->getClientOriginalExtension();
            $imageFileName = $upload_dir.$image_name;

            try{
                $resized->save($imageFileName);
            } catch (\Exception $e){
                return $e->getMessage();
            }
        }

        $data = [
            'category_name' => $request->category_name,
            'image' => $image_name,
        ];

        $category->update($data);
        return back()->with('success', trans('app.category_updated'));
    }

    public function destroy(Request $request){
        $category_id = $request->data_id;
        Category::find($category_id)->delete();
        return ['success' => 1];
    }
}
