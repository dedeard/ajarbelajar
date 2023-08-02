<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller;

class CategoriesController extends Controller
{
    public function __construct()
    {
        // Middleware to check user permissions for specific actions
        $this->middleware('can:read category')->only('index');
        $this->middleware('can:create category')->only(['create', 'store']);
        $this->middleware('can:update category')->only(['edit', 'update']);
        $this->middleware('can:delete category')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        Paginator::useBootstrapFour();

        // Get the value of the 'search' input from the request, if not provided, set it as an empty string
        $search = $request->input('search', '');

        // Query the Category model and apply a conditional filter based on the 'search' input
        $categories = Category::when($search, fn ($query, $search) => $query->where('name', 'like', "%$search%"))
            ->orderBy('id', 'desc')
            ->paginate(10) // Paginate the results with 10 items per page
            ->appends(['search' => $search]); // Append the 'search' input to the pagination links

        // Pass the categories data to the view
        return view('admin::categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('admin::categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function store(Request $request)
    {
        // Validation rules for the category form data
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Create a new category instance and save it to the database
        Category::create($request->all());

        // Redirect to the category index page or show a success message
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit($id)
    {
        // Find the category by the given ID
        $category = Category::findOrFail($id);

        // Pass the category data to the view
        return view('admin::categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        // Find the category by the given ID
        $category = Category::findOrFail($id);

        // Validation rules for the category form data
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Update the category's attributes and save it to the database
        $category->update($request->all());

        // Redirect to the category index page or show a success message
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function destroy($id)
    {
        // Find the category by the given ID
        $category = Category::findOrFail($id);

        // Delete the category from the database
        $category->delete();

        // Redirect to the category index page or show a success message
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
