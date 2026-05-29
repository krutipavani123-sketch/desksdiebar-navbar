<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestAttributeValueResolver;

class CategoryController extends Controller
{

    public function create()
    {
        return view('categories.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        Category::create([
            'name' => $request->name,
            // 'team_id' => $request->team_id,
        ]);

        return redirect()->route('categories.list')->with('success', 'Category created');
    }

    public function list(Request $request)
    {
        $categories = Category::all();

        if ($request->filled('search')) {
            $search = $request->search;
            $categories->where('name', 'like', "%{$search}%");
        }
        return view('categories.list', compact('categories'));
        // return redirect()->route('categories.list')->with('success', 'Category List');
    }

    public function edit($id)
    {

        $categories = Category::findOrFail($id);
        return view('categories.edit', compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $categories = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name'
        ]);

        if ($validator->passes()) {
            $categories->name = $request->name;
            $categories->save();

            return redirect()->route('categories.list')->with('success', 'Category Updated');
        } else {
            return back()->with('Error', 'Category Not Updated');
        }
    }

    public function delete($id)
    {

        $categories = Category::findOrFail($id);
        $categories->delete();

        return redirect()->route('categories.list')->with('success', 'Category Deleted');
    }
}
