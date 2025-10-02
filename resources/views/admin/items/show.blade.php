@extends('admin.layouts.app',[
    'pageName'=>'show page'
  ])
@section('content')
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
                <div class="col-12">
                    <img src="{{ asset('storage/' . $item->mainPhoto->path) }}" class="product-image" alt="Main">
                </div>
                <div class="col-12 product-image-thumbs">
                    @foreach ($item->gallery as $gallery)
                        <div class="product-image-thumb"><img src="{{ asset('storage/' . $gallery->path) }}" alt="gallery"></div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-sm-6">
              <h2 class="my-3">{{ $item->name }}</h2>
              <hr>
              <h4> Item Code : {{ $item->item_code }}</h4>
              <hr>
              <h4>Item Quantity : {{ $item->quantity }} {{$item->unit->name  }}</h4>

              <div class="bg-gray py-2 px-3 mt-4">
                <h2 class="mb-0">
                  {{ $item->price }} $
                </h2>
                <h4 class="mt-0">
                  <small>Ex Tax: {{ $item->price }} $   </small>
                </h4>
              </div>

            </div>
          </div>
          <div class="row mt-4">
            <nav class="w-100">
              <div class="nav nav-tabs" id="product-tab" role="tablist">
                <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
              </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
              <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab"> {{ $item->description }}</div>
            </div>
          </div>
        </div>
      </div>
@endsection
