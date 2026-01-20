@extends('admin.layouts.app')

@section('title', 'Company Profile')
@section('page-title', 'Company Profile')

@section('content')
    <div class="page-header">
        <h1><i class="fas fa-building"></i> Company Profile</h1>
        <p>Manage company information and branding</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Company Information
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.company-profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Company Name -->
                        <div class="mb-3">
                            <label for="company_name" class="form-label">
                                <i class="fas fa-font"></i> Company Name
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('company_name') is-invalid @enderror" 
                                id="company_name" 
                                name="company_name" 
                                placeholder="Enter company name" 
                                value="{{ old('company_name', $company->company_name ?? '') }}"
                                required
                            >
                            @error('company_name')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">
                                <i class="fas fa-map-marker-alt"></i> Address
                            </label>
                            <textarea 
                                class="form-control @error('address') is-invalid @enderror" 
                                id="address" 
                                name="address" 
                                rows="3" 
                                placeholder="Enter company address"
                                required
                            >{{ old('address', $company->address ?? '') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Phone -->
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone"></i> Phone Number
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('phone') is-invalid @enderror" 
                                    id="phone" 
                                    name="phone" 
                                    placeholder="Enter phone number" 
                                    value="{{ old('phone', $company->phone ?? '') }}"
                                    required
                                >
                                @error('phone')
                                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email Address
                                </label>
                                <input 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    id="email" 
                                    name="email" 
                                    placeholder="Enter email address" 
                                    value="{{ old('email', $company->email ?? '') }}"
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Logo Upload -->
                        <div class="mb-3">
                            <label for="logo" class="form-label">
                                <i class="fas fa-image"></i> Company Logo
                            </label>
                            @if($company && $company->logo)
                                <div style="margin-bottom: 15px;">
                                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" style="max-width: 200px; height: auto; border-radius: 8px;">
                                    <p style="font-size: 12px; color: #7f8c8d; margin-top: 8px;">Current logo</p>
                                </div>
                            @endif
                            <input 
                                type="file" 
                                class="form-control @error('logo') is-invalid @enderror" 
                                id="logo" 
                                name="logo" 
                                accept="image/jpeg,image/png,image/jpg,image/gif"
                            >
                            <small style="color: #7f8c8d;">Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB</small>
                            @error('logo')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div style="display: flex; gap: 10px; margin-top: 30px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Company Profile
                            </button>
                            <a href="/admin/dashboard" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="col-lg-4">
            <div class="card" style="background: linear-gradient(135deg, #43e97b, #38f9d7); color: white; border: none;">
                <div class="card-header" style="background: transparent; border: none; color: white;">
                    <i class="fas fa-info-circle"></i> Profile Information
                </div>
                <div class="card-body" style="color: white;">
                    @if($company)
                        <ul style="margin-left: 0; padding-left: 20px; list-style: none;">
                            <li style="margin-bottom: 10px;">
                                <strong>Company:</strong> {{ $company->company_name ?? 'Not set' }}
                            </li>
                            <li style="margin-bottom: 10px;">
                                <strong>Phone:</strong> {{ $company->phone ?? 'Not set' }}
                            </li>
                            <li style="margin-bottom: 10px;">
                                <strong>Email:</strong> {{ $company->email ?? 'Not set' }}
                            </li>
                            <li style="margin-bottom: 10px;">
                                <strong>Logo:</strong> @if($company->logo) Uploaded @else Not set @endif
                            </li>
                            <li>
                                <strong>Last Updated:</strong> {{ $company->updated_at->diffForHumans() ?? 'Never' }}
                            </li>
                        </ul>
                    @else
                        <p style="margin: 0;">No company profile set. Create one now!</p>
                    @endif

                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.3);">
                        <h6 style="color: white; margin-bottom: 10px;">Guidelines:</h6>
                        <ul style="margin-left: 0; padding-left: 20px; font-size: 12px;">
                            <li>Update company info regularly</li>
                            <li>Logo should be clear and readable</li>
                            <li>Use verified contact details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
