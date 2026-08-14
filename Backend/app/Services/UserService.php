<?php

namespace App\Services;

use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\DTOs\User\UpdateUserRoleDTO;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private RoleService $roleService,
    ) {}

    public function create(CreateUserDTO $dto): User
    {
        return DB::transaction(function () use ($dto) {
            $user = new User([
                'first_name' => $dto->first_name,
                'last_name' => $dto->last_name,
                'middle_name' => $dto->middle_name,
                'email' => $dto->email,
                'password' => Hash::make($dto->password),
                'mobile_number' => $dto->mobile_number,
            ]);

            $user->save();

            $cus_role_id = $this->roleService->getRoleID(UserRole::CUSTOMER);
            $user->roles()->attach($cus_role_id);

            return $user;
        });
    }

    public function update(UpdateUserDTO $dto, User $user): User
    {
        $user->update($dto->attributes);

        return $user;
    }

    public function setRoles(UpdateUserRoleDTO $dto): User
    {
        $customerRoleId = $this->roleService->getRoleID(UserRole::CUSTOMER);

        $roleIds = collect($dto->roles)
            ->push($customerRoleId)
            ->unique()
            ->values()
            ->all();

        $dto->user->roles()->sync($roleIds);

        return $dto->user;
    }

    public function addRole(User $user, UserRole $role): User
    {
        $roleId = $this->roleService->getRoleID($role);

        $user->roles()->syncWithoutDetaching([
            $roleId,
        ]);

        return $user->refresh();
    }

    public function removeRole(UpdateUserRoleDTO $dto): User
    {
        $this->setRoles($dto);

        return $dto->user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
