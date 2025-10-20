<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\category;
use App\Models\unit;
use App\Http\Requests\Admin\ItemRequest;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with(['category','unit'])->paginate(10);
        return view('admin.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $units = Unit::all();
        return view('admin.items.create', compact('categories', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {
        $item = Item::create($request->validated());
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $ext = $file->getClientOriginalExtension();
            $path = $file->storeAs('items', $fileName, 'public');
            $item->mainPhoto()->create([
            'path' => $path,
            'ext' => $ext,
            'usage' => 'item_photo'
            ]) ;
        }
        if ($request->hasfile('gallery')) {
            foreach ($request->file('gallery') as $gallery) {
                $fileName = time() . '_' . $gallery->getClientOriginalName();
                $path = $gallery->storeAs('items/gallery', $fileName, 'public');
                $ext = $gallery->getClientOriginalExtension();
                $item->gallery()->create([
                    'path' => $path,
                    'ext' => $ext,
                    'usage' => 'item_gallery',
                ]);
            }
        }
        return to_route('admin.items.index')->with('success', 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::findOrFail($id);
        return view('admin.items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $units = Unit::all();
        $item = Item::findOrFail($id);
        return view('admin.items.edit', compact('item', 'categories', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ItemRequest $request, string $id)
    {
        $item = Item::findOrFail($id);
        $item->update($request->validated());
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $fileName = time() . "_" . $file->getClientOriginalName();
            $path = $file->storeAs('items', $fileName, 'public');
            $ext = $file->getClientOriginalExtension();
            if ($item->mainPhoto) {
                Storage::disk('public')->delete($item->mainPhoto->path);
                $item->mainPhoto->update([
                    'path' => $path,
                    'ext' => $ext,
                ]);
            } else {
                $item->mainPhoto()->create([
                    'path' => $path,
                    'ext' => $ext,
                    'usage' => 'item_photo',
                ]);
            }
        }
        if ($request->hasFile('gallery')) {
            foreach ($item->gallery as $oldGallery) {
                Storage::disk('public')->delete($oldGallery->path);
                $oldGallery->delete();
            }
            foreach ($request->file('gallery') as $galleryFile) {
                $path = $galleryFile->store('items/gallery', 'public');

                $item->gallery()->create([
                    'path'  => $path,
                    'ext'   => $galleryFile->getClientOriginalExtension(),
                    'usage' => 'item_gallery',
                ]);
            }
        }
        return to_route('admin.items.index')->with('success', 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        if ($item->sales()->exists() || $item->returns()->exists()) {
            return to_route('admin.items.index')->with('error', 'Cannot delete item with associated sales or returns.');
        }
        if ($item->mainPhoto) {
            Storage::disk('public')->delete($item->mainPhoto->path);
        }
        foreach ($item->gallery as $oldGallery) {
            Storage::disk('public')->delete($oldGallery->path);
            $oldGallery->delete();
        }
        $item->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'item deleted successfully'
            ]);
    }
}
