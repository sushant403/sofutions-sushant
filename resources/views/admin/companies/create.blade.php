@extends('layouts.master')
@section('content')

<div class="card">
    <div class="card-header">
        Add a Company
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.companies.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="company_name">Name</label>
                <input class="form-control {{ $errors->has('company_name') ? 'is-invalid' : '' }}" type="text" name="company_name" id="company_name" value="{{ old('company_name', '') }}">
                @if($errors->has('company_name'))
                    <span class="text-danger">{{ $errors->first('company_name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="company_email">Email</label>
                <input class="form-control {{ $errors->has('company_email') ? 'is-invalid' : '' }}" type="text" name="company_email" id="company_email" value="{{ old('company_email', '') }}">
                @if($errors->has('company_email'))
                    <span class="text-danger">{{ $errors->first('company_email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="company_logo">Logo</label>
                <input class="form-control {{ $errors->has('company_logo') ? 'is-invalid' : '' }}" type="file" name="company_logo" id="company_logo" value="{{ old('company_logo', '') }}">
                @if($errors->has('company_logo'))
                    <span class="text-danger">{{ $errors->first('company_logo') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="company_website">Website</label>
                <input class="form-control {{ $errors->has('company_website') ? 'is-invalid' : '' }}" type="text" name="company_website" id="company_website" value="{{ old('company_website', '') }}">
                @if($errors->has('company_website'))
                    <span class="text-danger">{{ $errors->first('company_website') }}</span>
                @endif
            </div>

            <hr>
            <h5 class="text-center my-4"><strong>Additional Company Data</strong></h5>
            <hr>

            <div class="form-group">
                <label for="email">Email 2</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', '') }}">
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}">
                @if($errors->has('phone'))
                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                @endif
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>



@endsection