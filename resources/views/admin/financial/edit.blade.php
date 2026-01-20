@extends('admin.layouts.app')

@section('title', 'Edit Transaction')
@section('page-title', 'Edit Transaction')

@section('content')
    <div class="page-header">
        <h1><i class="fas fa-edit"></i> Edit Transaction</h1>
        <p>Update financial transaction details</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-money-bill-wave"></i> Transaction Details
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.financial.update', $report->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Title Field -->
                        <div class="mb-3">
                            <label for="title" class="form-label">
                                <i class="fas fa-heading"></i> Transaction Title
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('title') is-invalid @enderror" 
                                id="title" 
                                name="title" 
                                placeholder="Enter transaction title" 
                                value="{{ old('title', $report->title) }}"
                                required
                            >
                            @error('title')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Amount Field -->
                        <div class="mb-3">
                            <label for="amount" class="form-label">
                                <i class="fas fa-coins"></i> Amount (₨)
                            </label>
                            <input 
                                type="number" 
                                class="form-control @error('amount') is-invalid @enderror" 
                                id="amount" 
                                name="amount" 
                                placeholder="Enter amount" 
                                value="{{ old('amount', $report->amount) }}"
                                step="0.01"
                                min="0.01"
                                required
                            >
                            @error('amount')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Type Field -->
                        <div class="mb-3">
                            <label for="type" class="form-label">
                                <i class="fas fa-tag"></i> Transaction Type
                            </label>
                            <select 
                                class="form-control @error('type') is-invalid @enderror" 
                                id="type" 
                                name="type" 
                                required
                            >
                                <option value="credit" @if(old('type', $report->type) === 'credit') selected @endif>
                                    <i class="fas fa-arrow-up"></i> Credit (Income)
                                </option>
                                <option value="debit" @if(old('type', $report->type) === 'debit') selected @endif>
                                    <i class="fas fa-arrow-down"></i> Debit (Expense)
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div class="mb-3">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left"></i> Description
                            </label>
                            <textarea 
                                class="form-control @error('description') is-invalid @enderror" 
                                id="description" 
                                name="description" 
                                rows="4" 
                                placeholder="Enter transaction description"
                            >{{ old('description', $report->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div style="display: flex; gap: 10px; margin-top: 30px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Transaction
                            </button>
                            <a href="/admin/financial" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="col-lg-4">
            <div class="card" style="background: linear-gradient(135deg, #f093fb, #f5576c); color: white; border: none;">
                <div class="card-header" style="background: transparent; border: none; color: white;">
                    <i class="fas fa-info-circle"></i> Transaction Info
                </div>
                <div class="card-body" style="color: white;">
                    <ul style="margin-left: 0; padding-left: 20px; list-style: none;">
                        <li style="margin-bottom: 10px;">
                            <strong>Current Type:</strong>
                            @if($report->type === 'credit')
                                <span style="color: #d4edda;">Credit (Income)</span>
                            @else
                                <span style="color: #f8d7da;">Debit (Expense)</span>
                            @endif
                        </li>
                        <li style="margin-bottom: 10px;">
                            <strong>Current Amount:</strong> ₨ {{ number_format($report->amount, 2) }}
                        </li>
                        <li style="margin-bottom: 10px;">
                            <strong>Created By:</strong> {{ $report->createdBy->name ?? 'N/A' }}
                        </li>
                        <li style="margin-bottom: 10px;">
                            <strong>Created At:</strong> {{ $report->created_at->format('M d, Y') }}
                        </li>
                    </ul>

                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.3);">
                        <h6 style="color: white; margin-bottom: 10px;">Update Guidelines</h6>
                        <ul style="font-size: 12px; margin-left: 0; padding-left: 20px;">
                            <li>You cannot change who created this</li>
                            <li>All changes are logged in system</li>
                            <li>Double-check before updating</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
