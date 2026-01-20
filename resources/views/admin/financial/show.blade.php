@extends('admin.layouts.app')

@section('title', 'Transaction Details')
@section('page-title', 'Transaction Details')

@section('content')
    <div class="page-header">
        <h1><i class="fas fa-receipt"></i> {{ $report->title }}</h1>
        <p>View transaction details</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Transaction Information
                </div>
                <div class="card-body">
                    <div class="row" style="margin-bottom: 30px;">
                        <!-- Title -->
                        <div class="col-md-6 mb-4">
                            <div style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
                                <small style="color: #7f8c8d; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 8px;">
                                    <i class="fas fa-heading"></i> Title
                                </small>
                                <div style="font-size: 18px; font-weight: 600; color: #2c3e50;">
                                    {{ $report->title }}
                                </div>
                            </div>
                        </div>

                        <!-- Amount -->
                        <div class="col-md-6 mb-4">
                            <div style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
                                <small style="color: #7f8c8d; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 8px;">
                                    <i class="fas fa-coins"></i> Amount
                                </small>
                                <div style="font-size: 24px; font-weight: 600; color: #27ae60;">
                                    ₨ {{ number_format($report->amount, 2) }}
                                </div>
                            </div>
                        </div>

                        <!-- Type -->
                        <div class="col-md-6 mb-4">
                            <div style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
                                <small style="color: #7f8c8d; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 8px;">
                                    <i class="fas fa-tag"></i> Type
                                </small>
                                @if($report->type === 'credit')
                                    <span class="badge" style="background: #d4edda; color: #155724; padding: 8px 12px; font-size: 14px;">
                                        <i class="fas fa-arrow-up"></i> Credit
                                    </span>
                                @else
                                    <span class="badge" style="background: #f8d7da; color: #721c24; padding: 8px 12px; font-size: 14px;">
                                        <i class="fas fa-arrow-down"></i> Debit
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Created By -->
                        <div class="col-md-6 mb-4">
                            <div style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
                                <small style="color: #7f8c8d; font-weight: 600; text-transform: uppercase; display: block; margin-bottom: 8px;">
                                    <i class="fas fa-user"></i> Created By
                                </small>
                                <div style="font-size: 16px; font-weight: 500; color: #2c3e50;">
                                    {{ $report->createdBy->name ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div style="margin-bottom: 30px;">
                        <label style="font-weight: 600; color: #7f8c8d; text-transform: uppercase; font-size: 12px; display: block; margin-bottom: 10px;">
                            <i class="fas fa-align-left"></i> Description
                        </label>
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px; min-height: 100px; word-wrap: break-word;">
                            {{ $report->description ?? 'No description provided' }}
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="row">
                        <div class="col-md-6">
                            <div style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
                                <small style="color: #7f8c8d; font-weight: 600; display: block; margin-bottom: 5px;">
                                    <i class="fas fa-calendar"></i> Created At
                                </small>
                                <div style="color: #2c3e50;">
                                    {{ $report->created_at->format('M d, Y H:i:s') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
                                <small style="color: #7f8c8d; font-weight: 600; display: block; margin-bottom: 5px;">
                                    <i class="fas fa-sync"></i> Last Updated
                                </small>
                                <div style="color: #2c3e50;">
                                    {{ $report->updated_at->format('M d, Y H:i:s') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="margin-top: 30px; display: flex; gap: 10px;">
                        <a href="/admin/financial/{{ $report->id }}/edit" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Transaction
                        </a>
                        <a href="/admin/financial" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Financial
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="col-lg-4">
            <div class="card" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none;">
                <div class="card-header" style="background: transparent; border: none; color: white;">
                    <i class="fas fa-shield-alt"></i> Transaction Status
                </div>
                <div class="card-body" style="color: white;">
                    <div style="padding: 15px; background: rgba(255,255,255,0.1); border-radius: 8px;">
                        <small style="display: block; margin-bottom: 8px;">Transaction ID</small>
                        <strong style="font-size: 14px;">{{ $report->id }}</strong>
                    </div>

                    <div style="margin-top: 15px; padding: 15px; background: rgba(255,255,255,0.1); border-radius: 8px;">
                        <small style="display: block; margin-bottom: 8px;">Status</small>
                        <strong style="font-size: 14px; color: #d4edda;">
                            <i class="fas fa-check-circle"></i> Recorded
                        </strong>
                    </div>

                    <div style="margin-top: 15px; padding: 15px; background: rgba(255,255,255,0.1); border-radius: 8px;">
                        <small style="display: block; margin-bottom: 8px;">Age</small>
                        <strong style="font-size: 14px;">{{ $report->created_at->diffForHumans() }}</strong>
                    </div>

                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.3);">
                        <form action="{{ route('admin.financial.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Are you sure? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Delete Transaction
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
