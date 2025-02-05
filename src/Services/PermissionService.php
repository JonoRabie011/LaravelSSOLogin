<?php

namespace LaravelLogin\Services;

use GuzzleHttp\Exception\GuzzleException;

Trait PermissionService
{

    public $role;
    public $permissions;

    /**
     * Get the current loggedin user's role and permissions
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCurrentRoleFromApi()
    {
        $response = $this->get("/user/role");

        $body = json_decode($response->getBody(), true);

        $this->role = $body['name'];
        $this->permissions = $this->decodePermissions($body['permissions']);

        return [
            'role' => $this->role,
            'permissions' => $this->permissions
        ];
    }


    public function decodePermissions($permissions)
    {
        return base64_decode(substr($permissions, 5));
    }

    /**
     * Check if the current user has a specific permission
     * @param $permission string Permission to check e.g. 'view_users'
     * @return bool
     * @throws GuzzleException
     */
    public function hasPermission($permission): bool
    {
        if(empty($this->permissions)) {
            $this->getCurrentRoleFromApi();
        }

        return in_array($permission, explode(',', $this->permissions));
    }

    /**
     * Check if the current user has all of the specified permissions
     * @param array $permissions Array of permissions e.g. ['view_users', 'edit_users']
     * @return bool
     * @throws GuzzleException
     */
    public function hasPermissions(array $permissions = []): bool
    {
        if(empty($this->permissions)) {
            $this->getCurrentRoleFromApi();
        }

//        $permissions = explode(',', $permissions);
        foreach ($permissions as $permission) {
            if (!in_array($permission, explode(',', $this->permissions))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Return the current user's permissions in snake_case
     * @return array Array of permissions in snake_case e.g. ['view_users', 'edit_users']
     */
    public function getPermissionsInSnakeCase(): array
    {
        $permissions = explode(',', $this->permissions);
        $snakeCasePermissions = [];
        foreach ($permissions as $permission) {
            $snakeCasePermissions[] = $this->snake_case($permission);
        }

        return $snakeCasePermissions;
    }

    /**
     * Return the current user's permissions in camelCase
     * @return array Array of permissions in camelCase e.g. ['viewUsers', 'editUsers']
     */
    public function getPermissionsInCamelCase(): array
    {
        $permissions = explode(',', $this->permissions);
        $camelCasePermissions = [];
        foreach ($permissions as $permission) {
            $camelCasePermissions[] = $this->camel_case($permission);
        }

        return $camelCasePermissions;
    }




}