@extends('admin.layouts.app',[
    'pageName'=>'Items Page',
    ])
@section('content')
    @if (session('add_item'))
        <div class="alert alert-success">
            {{ session('add_item') }}
        </div>
    @elseif (session('update_item'))
        <div class="alert alert-success">
            {{ session('update_item') }}
        </div>
    @endif
    <div class="row">
    <div class="mb-3">
        <a href="{{ route('admin.items.create') }}" class="btn btn-primary">
            Add New Item
        </a>
    </div>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 10px">#</th>
                <th style="width: 50px">Name</th>
                <th>Item Code</th>
                <th style="width: 200px">Description</th>
                <th>Price</th>
                <th style="width: 10px">Quantity</th>
                <th style="width: 10px">M.Stock</th>
                <th style="width: 50px">Category</th>
                <th>Unit</th>
                <th style="width: 10px">Show In Store</th>
                <th>Action</th>

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
                                <span class="badge bg-success">Show</span>
                            </td>
                        @else
                            <td>
                                <span class="badge bg-danger">Hide</span>
                            </td>
                        @endif
                        <td>
                            <a href="{{route('admin.items.show',$item->id)}}" class="btn btn-sm btn-info">View</a>
                            <a href="{{  route('admin.items.edit',$item->id) }}" class="btn btn-sm btn-info">Edit</a>
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
        <div class="mt-4">
            {{ $items->links() }}
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
