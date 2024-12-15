<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories =Category::all();
        return view('dashboard.categories.index' , compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories =Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('category','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(Category::rules());

        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);
        $data =$request->except('image');
        if($request->hasFile('image'))
        {
            $file =$request->file('image');
            $path =$file->store('uploads','public');
            $data['image'] = $path;
        }   
        

        Category::create($data);
        return redirect()->route('categories.index')->with('success' , 'Category created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //SELECT * FROM Category WHERE id <> $id 
        //AND( parent_id IS NULL OR parent_id <> $id)
        $category=Category::findOrFail($id);
        $categories =Category::where('id','<>',$id)
            ->where(function($query) use($id){
                $query->whereNull('parent_id')
                      ->orWhere('parent_id','<>',$id);
            })
        ->get() ;
        return view('dashboard.categories.edit', compact('category','categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(Category::rules($id));

        $category=Category::findOrFail($id);

        $old_image = $category->image;
        $data =$request->except('image');
        if($request->hasFile('image'))
        {
            $file =$request->file('image');
            $path =$file->store('uploads',[
                'disk'=> 'public'
            ]);
            $data['image'] = $path;
        }
        $category->update($data);
        if($old_image && isset($data['image']))
        {
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('categories.index')->with('success' , 'Category update');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category =Category::findOrFail($id);
        $category->delete();
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        // Category::destroy($id);
        return redirect()->route('categories.index')->with('success' , 'Category deleted');

    }
}
