@extends('admin.layouts.app',[
    'pageName'=> __('trans.items'),
    ])
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('trans.items_list')</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.items.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> @lang('trans.create')
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @include('admin.layouts.partials._flash')
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th style="width: 50px">@lang('trans.name')</th>
                            <th>@lang('trans.item_Code')</th>
                            <th style="width: 200px">@lang('trans.description')</th>
                            <th>@lang('trans.price')</th>
                            <th style="width: 10px">@lang('trans.quantity')</th>
                            <th style="width: 10px">@lang('trans.m.stock')</th>
                            <th style="width: 50px">@lang('trans.category')</th>
                            <th>@lang('trans.unit')</th>
                            <th style="width: 10px">@lang('trans.show_in_store')</th>
                            <th>@lang('trans.action')</th>

                        </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->item_code}}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->minimum_stock}}</td>
                                    <td>{{ $item->category->name }}</td>
                                    <td>{{ $item->unit->name }}</td>
                                    @if($item->is_shown_in_store==1)
                                        <td>
                                            <span class="badge bg-success">@lang('trans.show')</span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="badge bg-danger">@lang('trans.hide')</span>
                                        </td>
                                    @endif
                                    <td>
                                        <a href="{{route('admin.items.show',$item->id)}}" class="btn btn-sm btn-info">@lang('trans.view')</a>
                                        <a href="{{  route('admin.items.edit',$item->id) }}" class="btn btn-sm btn-info">@lang('trans.edit')</a>
                                            <a href="#"
                                                data-url="{{ route('admin.items.destroy', $item->id) }}"
                                                data-id="{{$item->id}}"
                                                class="btn btn-danger btn-sm delete-button">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $items->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('.delete-button').on('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(this).data('url'),
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire("Deleted!", response.message, "success");
                            location.reload();
                        },
                        error: function (xhr) {
                            Swal.fire("Error!", "An error occurred while deleting the item.", "error");
                        }
                    });
                }
            });
        });
    </script>
@endpush
