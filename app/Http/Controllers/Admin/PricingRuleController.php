<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarCategory;
use App\Models\CarBrand;
use App\Models\PricingRule;
use Illuminate\Http\Request;

class PricingRuleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $rulesQuery = PricingRule::with(['category', 'brand'])->orderBy('id', 'desc');

        if ($search) {
            $rulesQuery->whereHas('category', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('brand', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $rules = $rulesQuery->paginate(15)->appends(['search' => $search]);
        return view('admin.pricing_rules.index', compact('rules', 'search'));
    }

    public function create()
    {
        $categories = CarCategory::where('status', 'active')->get();
        $brands = CarBrand::where('status', 'active')->get();
        return view('admin.pricing_rules.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:car_categories,id',
            'brand_id' => 'nullable|exists:car_brands,id',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'seats' => 'nullable|integer|min:1',
            'hourly_rate' => 'required|numeric|min:0',
            'daily_rate' => 'required|numeric|min:0',
            'hourly_penalty' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        PricingRule::create($validated);

        return redirect()->route('admin.settings.pricing_rules.index')->with('success', 'Pricing rule created successfully.');
    }

    public function edit(PricingRule $pricing_rule)
    {
        $categories = CarCategory::where('status', 'active')->get();
        $brands = CarBrand::where('status', 'active')->get();
        return view('admin.pricing_rules.edit', compact('pricing_rule', 'categories', 'brands'));
    }

    public function update(Request $request, PricingRule $pricing_rule)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:car_categories,id',
            'brand_id' => 'nullable|exists:car_brands,id',
            'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'seats' => 'nullable|integer|min:1',
            'hourly_rate' => 'required|numeric|min:0',
            'daily_rate' => 'required|numeric|min:0',
            'hourly_penalty' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $pricing_rule->update($validated);

        return redirect()->route('admin.settings.pricing_rules.index')->with('success', 'Pricing rule updated successfully.');
    }

    public function destroy(PricingRule $pricing_rule)
    {
        $pricing_rule->delete();
        return redirect()->route('admin.settings.pricing_rules.index')->with('success', 'Pricing rule deleted successfully.');
    }
}
