<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Weapon;
use Illuminate\Auth\Access\Response;

class WeaponPolicy
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
    public function view(User $user, Weapon $weapon): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isCountryUser();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Weapon $weapon): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return $user->isCountryUser() && $user->country()->is($weapon->country);
    }
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Weapon $weapon): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return $user->isCountryUser() && $user->country()->is($weapon->country);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Weapon $weapon): bool
    {
        return false;
    }

    public function ban(User $user, Weapon $weapon): bool
    {
        return $user->isAdmin() || ($user->isCountryUser() && $user->country()->is($weapon->country));
    }


    public function purchase(User $user, Weapon $weapon): bool
    {
        if ($weapon->isAvailableForPurchase() && !$user->hasWeapon($weapon)) {
            if ($user->isAdmin()) return true;
            if ($user->isCountryUser()) return true;
            if ($user->isGeneralUser()) return ($user->country->is($weapon->country));
        }
        return false;
    }


    public function hasDiscount(User $user, Weapon $weapon): bool
    {
        return $user->country->team->is($weapon->country->team);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Weapon $weapon): bool
    {
        return false;
    }
}
