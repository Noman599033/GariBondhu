<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoriesQuery = CarCategory::orderBy('sort_order', 'asc')->orderBy('id', 'desc');

        if ($search) {
            $categoriesQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('slug', 'like', "%{$search}%");
        }

        $categories = $categoriesQuery->paginate(15)->appends(['search' => $search]);
        return view('admin.categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['slug'] = Str::slug($validated['name'] . '-' . uniqid());
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        CarCategory::create($validated);

        return redirect()->route('admin.settings.categories.index')->with('success', 'Car category created successfully.');
    }

    public function edit(CarCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, CarCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $category->update($validated);

        return redirect()->route('admin.settings.categories.index')->with('success', 'Car category updated successfully.');
    }

    public function destroy(CarCategory $category)
    {
        // Don't delete if there are associated cars
        if ($category->cars()->exists()) {
            return redirect()->route('admin.settings.categories.index')->with('error', 'Cannot delete category that is attached to cars.');
        }

        $category->delete();
        return redirect()->route('admin.settings.categories.index')->with('success', 'Car category deleted successfully.');
    }
}
