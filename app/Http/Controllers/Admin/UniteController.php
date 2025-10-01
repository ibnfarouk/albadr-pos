<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UnitStatusEnum;
use App\Models\Unit;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUnitRequest;

class UniteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.unites.index');
    }

    public function create()
    {
        $uniteStatuses = UnitStatusEnum::labels();
        return view('admin.unites.create');
    }

    public function store(StoreUnitRequest $request)
    {
        Unit::create($request->validated());
        session()->flash('success', 'Unit created successfully.');
        return redirect()->route('admin.unites.index');
    }

    public function edit($id)
    {
        $unit = Unit::findOrFail($id);
        $uniteStatuses = UnitStatusEnum::labels();
        return view('admin.unites.edit', compact('unit'));
    }

    public function update(StoreUnitRequest $request, $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->update($request->validated());
        session()->flash('success', 'Unit updated successfully.');
        return redirect()->route('admin.unites.index');
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);

        if ($unit->items()->count() > 0) {
            session()->flash('error', 'Cannot delete unit with associated items.');
            return redirect()->route('admin.unites.index');
        }

        $unit->delete();
        session()->flash('success', 'Unit deleted successfully.');
        return redirect()->route('admin.unites.index');
    }
}
