@extends('admin.layouts.app',[
        'pageName' => 'Add Item'
    ])
@section('content')
    <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data" >
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Item Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                 name="name" id="name" value='{{ old('name') }}'
                 placeholder="Enter name">
                @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="item_code">Item Code</label>
                <input type="text" class="form-control @error('item_code') is-invalid @enderror"
                 name="item_code" id="item_code" value='{{ old('item_code') }}'
                 placeholder="Enter Item Code as 'Itm000'">
                @error('item_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                  <textarea
                        class="form-control @error('description') is-invalid @enderror"
                        name="description"
                        id="description"
                        class="form-control"
                        rows="4"
                        placeholder="Enter a description...">{{ old('description') }}</textarea>
                    @error('item_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>

            <div class="form-group">
                <label for="price">Item Price</label>
                <input type="text" class="form-control @error('price') is-invalid @enderror"
                 name="price" id="price" value='{{ old('price') }}'
                 placeholder="Enter The Item Price">
                @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="quantity">Item Quantity</label>
                <input type="text" class="form-control @error('quantity') is-invalid @enderror"
                 name="quantity" id="quantity" value='{{ old('quantity') }}'
                 placeholder="Enter The Item Quantity">
                @error('quantity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="minimum_stock">Minimum Stock</label>
                <input type="text" class="form-control @error('minimum_stock') is-invalid @enderror"
                 name="minimum_stock" id="minimum_stock" value='{{ old('minimum_stock','5') }}'
                 placeholder="Enter Munimum Stock">
                @error('minimum_stock')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" name="photo" id="photo" accept="image/*" class="form-control @error('photo') is-invalid @enderror" >
                @error('photo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="gallery">Gallery</label>
                <input type="file" name="gallery[]" id="gallery"  multiple accept="image/*" class="form-control @error('gallery') is-invalid @enderror" >
                <small>You can select multiple images.</small>
                @error('gallery')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id">Select Category</label>
                <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                    <option value="">-- Choose a category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ (string) old('category_id') === (string) $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
               @error('category_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            
            <div class="form-group">
               <label for="unit_id">Select Unit</label>
                <select id="unit_id" name="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                    <option value="">-- Choose a unit --</option>
                    @foreach ($units as $unit)
                          <option value="{{ $unit->id }}"
                                {{ (string) old('unit_id') === (string) $unit->id ? 'selected' : '' }}>
                                {{ $unit->name }}
                            </option>
                    @endforeach
                </select>

                @error('unit_id')
                   <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

           <div class="form-group">
                <label for="is_shown_in_store">Status</label>

                <div class="form-check">
                    <input type="radio"
                        class="form-check-input @error('is_shown_in_store') is-invalid @enderror"
                        id="show"
                        name="is_shown_in_store"
                        value="1"
                        {{ old('is_shown_in_store') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="show">Show</label>
                </div>

                <div class="form-check">
                    <input type="radio"
                        class="form-check-input @error('is_shown_in_store') is-invalid @enderror"
                        id="hide"
                        name="is_shown_in_store"
                        value="0"
                        {{ old('is_shown_in_store', $item->is_shown_in_store ?? '') == '0' ? 'checked' : '' }}>
                    <label class="form-check-label" for="hide">Hide</label>
                </div>

                @error('is_shown_in_store')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
@endsection
