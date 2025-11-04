@extends('admin.layouts.app', [
    'pageName' => __('trans.clients'),
])

@section('content')
    <div class="row">
    <div class="col-sm-12">
        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-success text-white">
                <h3 class="card-title">{{ __('trans.edit client') }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="POST" action="{{ route('admin.clients.update', $client->id) }}" id="main-form">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="form-group">
                        <label for="name">{{ __('trans.client name') }}</label>
                        <input class="form-control @error('name') is-invalid @enderror" id="name"
                            placeholder="{{ __('trans.enter client name') }}" name="name" value="{{ old('name', $client->name) }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">{{ __('trans.email') }}</label>
                        <input class="form-control @error('email') is-invalid @enderror" id="email" type="email"
                            placeholder="{{ __('trans.enter client email') }}" name="email" value="{{ old('email', $client->email) }}">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone">{{ __('trans.phone') }}</label>
                        <input class="form-control @error('phone') is-invalid @enderror" id="phone"
                            placeholder="{{ __('trans.enter client phone') }}" name="phone" value="{{ old('phone', $client->phone) }}">
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label for="address">{{ __('trans.address') }}</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address"
                            placeholder="{{ __('trans.enter client address') }}" name="address">{{ old('address', $client->address) }}</textarea>
                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                    <!-- Status -->
                    <div class="form-group">
                        <label>{{ __('trans.status') }}</label>
                        @foreach ($clientStatus as $value => $label)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="{{ $value }}"
                                    @checked(old('status', $client->status->value) == $value)>
                                <label class="form-check-label">{{ $label }}</label>
                            </div>
                        @endforeach
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <x-form-submit text="{{ __('trans.update') }}"></x-form-submit>
            </div>
        </div>
        <!-- /.card -->
    </div>
    </div>
@endsection
