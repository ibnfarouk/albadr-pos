@extends('admin.layouts.app', [
    'pageName' => __('trans.clients'),
])

@section('content')
    <div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('trans.clients list') }}</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.clients.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> {{ __('trans.create') }}
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
                            <th>{{ __('trans.name') }}</th>
                            <th>{{ __('trans.email') }}</th>
                            <th>{{ __('trans.phone') }}</th>
                            <th>{{ __('trans.address') }}</th>
                            <th>{{ __('trans.balance') }}</th>
                            <th>{{ __('trans.status') }}</th>
                            <th>{{ __('trans.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)                                
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ $client->address }}</td>
                                <td>{{ number_format($client->balance, 2) }}</td>
                                <td>
                                    <span class="badge badge-{{ $client->status->style() }}">
                                        {{ $client->status->label() }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-edit"></i> {{ __('trans.edit') }}
                                    </a>
                                    <a href="#"
                                        data-url="{{ route('admin.clients.destroy', $client->id) }}"
                                        data-id="{{ $client->id }}"
                                        class="btn btn-danger btn-sm delete-button">
                                        <i class="fas fa-trash"></i> {{ __('trans.delete') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $clients->links() }}
            </div>
        </div>
    </div>
    </div>
@endsection

@push('js')
    <script>
        $('.delete-button').on('click', function (e) {
            e.preventDefault();
            Swal.fire({
                title: "{{ __('trans.are you sure?') }}",
                text: "{{ __('trans.you won\'t be able to revert this!') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "{{ __('trans.yes, delete it!') }}"
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
                            Swal.fire("{{ __('trans.deleted!') }}", response.message, "success");
                            location.reload();
                        },
                        error: function (xhr) {
                            Swal.fire("{{ __('trans.error!') }}", "{{ __('trans.an error occurred while deleting the client.') }}", "error");
                        }
                    });
                }
            });
        });
    </script>
@endpush
