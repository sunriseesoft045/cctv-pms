<?php

namespace App\Policies;

use App\Models\FinancialReport;
use App\Models\User;

class FinancialReportPolicy
{
    /**
     * Determine if the user can view the model.
     */
    public function view(User $user, FinancialReport $financialReport): bool
    {
        // Master admin can view all
        return $user->isMasterAdmin();
    }

    /**
     * Determine if the user can create models.
     */
    public function create(User $user): bool
    {
        // Only master admin can create financial reports
        return $user->isMasterAdmin();
    }

    /**
     * Determine if the user can update the model.
     */
    public function update(User $user, FinancialReport $financialReport): bool
    {
        // Only the creator (master admin) can update
        return $user->isMasterAdmin();
    }

    /**
     * Determine if the user can delete the model.
     */
    public function delete(User $user, FinancialReport $financialReport): bool
    {
        // Only master admin can delete
        return $user->isMasterAdmin();
    }

    /**
     * Determine if the user can restore the model.
     */
    public function restore(User $user, FinancialReport $financialReport): bool
    {
        return false;
    }

    /**
     * Determine if the user can permanently delete the model.
     */
    public function forceDelete(User $user, FinancialReport $financialReport): bool
    {
        return false;
    }
}
