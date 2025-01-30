<?php

namespace LaravelLogin\Services;

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
        $this->permissions = base64_decode(substr($body['permissions'], 5));

        return [
            'role' => $this->role,
            'permissions' => $this->permissions
        ];
    }


}