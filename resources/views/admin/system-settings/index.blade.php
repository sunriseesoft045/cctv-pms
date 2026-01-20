@extends('admin.layouts.app')

@section('title', 'System Settings')
@section('page-title', 'System Settings')

@section('content')
    <div class="page-header">
        <h1><i class="fas fa-cogs"></i> System Settings</h1>
        <p>Configure system-wide settings and preferences</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-sliders-h"></i> Settings Configuration
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.system-settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- App Name -->
                        <div class="mb-3">
                            <label for="app_name" class="form-label">
                                <i class="fas fa-font"></i> Application Name
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('app_name') is-invalid @enderror" 
                                id="app_name" 
                                name="app_name" 
                                placeholder="Enter application name" 
                                value="{{ old('app_name', $settings['app_name'] ?? 'CCTV PMS') }}"
                            >
                            @error('app_name')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- App Description -->
                        <div class="mb-3">
                            <label for="app_description" class="form-label">
                                <i class="fas fa-align-left"></i> Application Description
                            </label>
                            <textarea 
                                class="form-control @error('app_description') is-invalid @enderror" 
                                id="app_description" 
                                name="app_description" 
                                rows="4" 
                                placeholder="Enter application description"
                            >{{ old('app_description', $settings['app_description'] ?? '') }}</textarea>
                            @error('app_description')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Support Email -->
                        <div class="mb-3">
                            <label for="support_email" class="form-label">
                                <i class="fas fa-envelope"></i> Support Email
                            </label>
                            <input 
                                type="email" 
                                class="form-control @error('support_email') is-invalid @enderror" 
                                id="support_email" 
                                name="support_email" 
                                placeholder="Enter support email" 
                                value="{{ old('support_email', $settings['support_email'] ?? '') }}"
                            >
                            @error('support_email')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Support Phone -->
                        <div class="mb-3">
                            <label for="support_phone" class="form-label">
                                <i class="fas fa-phone"></i> Support Phone
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('support_phone') is-invalid @enderror" 
                                id="support_phone" 
                                name="support_phone" 
                                placeholder="Enter support phone number" 
                                value="{{ old('support_phone', $settings['support_phone'] ?? '') }}"
                            >
                            @error('support_phone')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Session Timeout -->
                        <div class="mb-3">
                            <label for="session_timeout" class="form-label">
                                <i class="fas fa-hourglass-end"></i> Session Timeout (minutes)
                            </label>
                            <input 
                                type="number" 
                                class="form-control @error('session_timeout') is-invalid @enderror" 
                                id="session_timeout" 
                                name="session_timeout" 
                                placeholder="30" 
                                value="{{ old('session_timeout', $settings['session_timeout'] ?? 30) }}"
                                min="5"
                                max="600"
                            >
                            <small style="color: #7f8c8d;">Automatically logout users after inactivity (5-600 minutes)</small>
                            @error('session_timeout')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Max Login Attempts -->
                        <div class="mb-3">
                            <label for="max_login_attempts" class="form-label">
                                <i class="fas fa-lock"></i> Max Login Attempts
                            </label>
                            <input 
                                type="number" 
                                class="form-control @error('max_login_attempts') is-invalid @enderror" 
                                id="max_login_attempts" 
                                name="max_login_attempts" 
                                placeholder="5" 
                                value="{{ old('max_login_attempts', $settings['max_login_attempts'] ?? 5) }}"
                                min="1"
                                max="20"
                            >
                            <small style="color: #7f8c8d;">Number of failed login attempts before account lockout</small>
                            @error('max_login_attempts')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Enable Maintenance Mode -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input 
                                    type="checkbox" 
                                    class="form-check-input" 
                                    id="maintenance_mode" 
                                    name="maintenance_mode"
                                    value="1"
                                    @if(old('maintenance_mode', $settings['maintenance_mode'] ?? 0))
                                        checked
                                    @endif
                                >
                                <label class="form-check-label" for="maintenance_mode">
                                    <i class="fas fa-tools"></i> Enable Maintenance Mode
                                </label>
                            </div>
                            <small style="color: #7f8c8d; display: block; margin-top: 5px;">
                                When enabled, only Master Admin can access the system
                            </small>
                        </div>

                        <!-- Submit Button -->
                        <div style="display: flex; gap: 10px; margin-top: 30px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Settings
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
            <div class="card" style="background: linear-gradient(135deg, #4facfe, #00f2fe); color: white; border: none;">
                <div class="card-header" style="background: transparent; border: none; color: white;">
                    <i class="fas fa-info-circle"></i> Settings Information
                </div>
                <div class="card-body" style="color: white;">
                    <h6 style="color: white; margin-bottom: 15px;">Configuration Options:</h6>
                    <ul style="margin-left: 0; padding-left: 20px;">
                        <li style="margin-bottom: 10px;"><strong>Application Name:</strong> Displayed throughout the system</li>
                        <li style="margin-bottom: 10px;"><strong>Support Contact:</strong> Email and phone for user inquiries</li>
                        <li style="margin-bottom: 10px;"><strong>Session Timeout:</strong> Auto-logout after inactivity</li>
                        <li style="margin-bottom: 10px;"><strong>Login Attempts:</strong> Security limitation</li>
                        <li><strong>Maintenance Mode:</strong> Restrict access during updates</li>
                    </ul>

                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.3);">
                        <p style="font-size: 12px; margin-bottom: 0;">
                            <i class="fas fa-sync"></i> <strong>Last Updated:</strong> Now
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
