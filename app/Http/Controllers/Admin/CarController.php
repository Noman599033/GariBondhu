<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarCategory;
use App\Models\CarBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $carsQuery = Car::with(['category', 'brand'])->orderBy('id', 'desc');

        if ($search) {
            $carsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('registration_number', 'like', "%{$search}%")
                  ->orWhereHas('category', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $cars = $carsQuery->paginate(15)->appends(['search' => $search]);
        return view('admin.cars.index', compact('cars', 'search'));
    }

    public function create()
    {
        $categories = CarCategory::where('status', 'active')->get();
        $brands = CarBrand::where('status', 'active')->get();
        
        return view('admin.cars.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'registration_number' => 'required|string|max:255|unique:cars,registration_number',
            'category_id' => 'required|exists:car_categories,id',
            'brand_id' => 'required|exists:car_brands,id',
            'transmission' => 'required|string',
            'fuel_type' => 'required|string',
            'seats' => 'required|integer|min:2',
            'doors' => 'required|integer|min:2',
            'status' => 'required|in:active,inactive,retired',
            'security_deposit_amount' => 'required|numeric|min:0',
            'custom_daily_rate' => 'nullable|numeric|min:0',
            'custom_hourly_rate' => 'nullable|numeric|min:0',
            'custom_hourly_penalty' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['name'] . '-' . $validated['model'] . '-' . uniqid());

        $car = Car::create(\Illuminate\Support\Arr::except($validated, ['image']));

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $mimeType = $file->getClientMimeType();
            $base64 = base64_encode(file_get_contents($file->getRealPath()));
            $base64Image = 'data:' . $mimeType . ';base64,' . $base64;

            $car->images()->create([
                'image' => $base64Image,
                'is_primary' => true,
                'sort_order' => 1
            ]);
        }

        return redirect()->route('admin.cars.index')->with('success', 'Car added successfully.');
    }

    public function edit(Car $car)
    {
        $categories = CarCategory::where('status', 'active')->get();
        $brands = CarBrand::where('status', 'active')->get();
        
        return view('admin.cars.edit', compact('car', 'categories', 'brands'));
    }

    public function update(Request $request, Car $car)
    {
        // Simple update logic for demonstration
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'status' => 'required|in:active,inactive,retired',
            'custom_daily_rate' => 'nullable|numeric|min:0',
            'custom_hourly_rate' => 'nullable|numeric|min:0',
            'custom_hourly_penalty' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $car->update(\Illuminate\Support\Arr::except($validated, ['image']));

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $mimeType = $file->getClientMimeType();
            $base64 = base64_encode(file_get_contents($file->getRealPath()));
            $base64Image = 'data:' . $mimeType . ';base64,' . $base64;

            // Find existing primary image or create a new one
            $primaryImage = $car->images()->where('is_primary', true)->first();
            if ($primaryImage) {
                $primaryImage->update(['image' => $base64Image]);
            } else {
                $car->images()->create([
                    'image' => $base64Image,
                    'is_primary' => true,
                    'sort_order' => 1
                ]);
            }
        }

        return redirect()->route('admin.cars.index')->with('success', 'Car updated successfully.');
    }

    public function destroy(Car $car)
    {
        $car->delete(); // Soft delete
        return redirect()->route('admin.cars.index')->with('success', 'Car deactivated/deleted successfully.');
    }
}
