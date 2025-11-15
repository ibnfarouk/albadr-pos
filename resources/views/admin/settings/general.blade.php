@extends('admin.layouts.app', [
    'pageName' => __('trans.general_settings'),
])

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">__('trans.general_settings')</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.settings.general.update') }}" id="main-form">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Company Name</label>
                            <input class="form-control @error('company_name') is-invalid @enderror"
                                   id="name"
                                   placeholder="Enter company name"
                                   name="company_name"
                                   value="{{ old('company_name', $generalSettings->company_name) }}"
                                   required>
                            @error('company_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Company Email</label>
                            <input class="form-control @error('company_email') is-invalid @enderror"
                                   id="email"
                                   placeholder="Enter company name"
                                   name="company_email"
                                   value="{{ old('company_email', $generalSettings->company_email) }}"
                                   required>
                            @error('company_email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Company Phone</label>
                            <input class="form-control @error('company_phone') is-invalid @enderror"
                                   id="phone"
                                   placeholder="Enter company name"
                                   name="company_phone"
                                   value="{{ old('company_phone', $generalSettings->company_phone) }}"
                                   required>
                            @error('company_phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="logo">Company Logo</label>
                            <input class="form-control @error('company_logo') is-invalid @enderror"
                                   type="file"
                                   id="logo"
                                   name="company_logo"
                                   required>
                            @error('company_phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div>
                            <img src="{{ asset('storage/'.$generalSettings->company_logo) }}" style="height:100px" alt="">
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <x-form-submit text="Update"></x-form-submit>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
