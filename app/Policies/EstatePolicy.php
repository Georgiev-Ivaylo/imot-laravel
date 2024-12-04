<?php

namespace App\Policies;

use App\Models\Estate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EstatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Estate $estate): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Estate $estate): bool
    {
        dd($estate->user_id, $user->id);
        return $user->id === $estate->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Estate $estate): bool
    {
        return $user->id === $estate->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Estate $estate): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Estate $estate): bool
    {
        return $user->id === $estate->user_id;
    }
}
