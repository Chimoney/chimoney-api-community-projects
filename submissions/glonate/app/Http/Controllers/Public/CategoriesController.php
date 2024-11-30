<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CategoriesController extends Controller
{
    public function index(){
        $title = trans('app.crowdfunding_categories');
        $categories = Category::orderBy('category_name', 'asc')->get();
        return view('public.categories.index', compact('title', 'categories'));
    }

    public function show($id, $slug = null){
        $title = trans('app.crowdfunding_categories');
        $category = Category::find($id);
        return view('public.categories.show', compact('title', 'category'));
    }

    public function search(Request $request){
        if ($request->q){
            $q = $request->q;
            $title = trans('app.search_campaigns');
            $campaigns = Campaign::active()->where('title', 'like', "%{$q}%")->orWhere('short_description', 'like', "%{$request->q}%")->orWhere('description', 'like', "%{$q}%")->simplePaginate(20);
            return view('public.categories.search', compact('title', 'campaigns', 'q'));
        }else{
            return $this->index();
        }
    }
    

}
