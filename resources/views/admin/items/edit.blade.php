@extends('admin.layouts.app',[
        'pageName' => __('trans.edit_item')
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.items_edit')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.items.update',$item->id) }}" method="POST" enctype="multipart/form-data" >
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">@lang('trans.name')</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" id="name" value='{{ old('name',$item->name) }}'>
                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="item_code">@lang('trans.item_code')</label>
                            <input type="text" class="form-control @error('item_code') is-invalid @enderror"
                            name="item_code" id="item_code" value='{{ old('item_code',$item->item_code) }}'>
                            @error('item_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">@lang('trans.description')</label>
                            <textarea
                                    class="form-control @error('description') is-invalid @enderror"
                                    name="description"
                                    id="description"
                                    class="form-control"
                                    rows="4">{{ old('description',$item->description) }}</textarea>
                                @error('item_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">@lang('trans.price')</label>
                            <input type="text" class="form-control @error('price') is-invalid @enderror"
                            name="price" id="price" value='{{ old('price',$item->price) }}'>
                            @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div> 
                        <div class="form-group">
                            <label for="quantity">@lang('trans.quantity')</label>
                            <input type="text" class="form-control @error('quantity') is-invalid @enderror"
                            name="quantity" id="quantity" value='{{ old('quantity',$item->quantity) }}'>
                            @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="minimum_stock">@lang('trans.minimum_stock')</label>
                            <input type="text" class="form-control @error('minimum_stock') is-invalid @enderror"
                            name="minimum_stock" id="minimum_stock" value='{{ old('minimum_stock',$item->minimum_stock) }}'>
                            @error('minimum_stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="photo">@lang('trans.photo')</label>
                            <input type="file" name="photo" id="photo" accept="image/*" class="form-control @error('photo') is-invalid @enderror" >
                            @error('photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if ($item->mainPhoto)
                                <div style="margin-top: 10px;">
                                    <strong>@lang('trans.current_photo'):</strong><br>
                                    <img src="{{ asset('storage/' . $item->mainPhoto->path) }}" alt="Current" width="150">
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="gallery">@lang('trans.gallery')</label>
                            <input type="file" name="gallery[]" id="gallery"  multiple accept="image/*" class="form-control @error('gallery.*') is-invalid @enderror" >
                            <small>@lang('trans.you_can_select_multiple_images').</small>
                            @error('gallery.*')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if ($item->gallery)
                                <div style="margin-top: 10px;">
                                    <strong>@lang('trans.gallery_photos'):</strong><br>
                                    @foreach ($item->gallery as $gallery)
                                        <img src="{{ asset('storage/' . $gallery->path) }}" alt="Current" width="150">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="category_id">@lang('trans.select_category')</label>
                            <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ (string) old('category_id', $item->category_id ?? '') === (string) $category->id ? 'selected' : '' }}>
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
                            <label for="unit_id">@lang('trans.select_unit')</label>
                            <select id="unit_id" name="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}"
                                            {{ (string) old('unit_id', $item->unit_id ?? '') === (string) $unit->id ? 'selected' : '' }}>
                                            {{ $unit->name }}
                                        </option>
                                @endforeach
                            </select>
                            @error('unit_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="is_shown_in_store">@lang('trans.status')</label>
                            <div class="form-check">
                                <input type="radio"
                                    class="form-check-input @error('is_shown_in_store') is-invalid @enderror"
                                    id="show"
                                    name="is_shown_in_store"
                                    value="1"
                                    {{ old('is_shown_in_store', $item->is_shown_in_store ?? '') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="show">@lang('trans.show')</label>
                            </div>
                            <div class="form-check">
                                <input type="radio"
                                    class="form-check-input @error('is_shown_in_store') is-invalid @enderror"
                                    id="hide"
                                    name="is_shown_in_store"
                                    value="0"
                                    {{ old('is_shown_in_store', $item->is_shown_in_store ?? '') == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="hide">@lang('trans.hide')</label>
                            </div>
                            @error('is_shown_in_store')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>
                <div class="card-footer clearfix">
                    <x-form-submit text="__('trans.update')"></x-form-submit>
                </div>
            </div>
        </div>
    </div>
@endsection
