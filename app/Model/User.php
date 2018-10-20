<?php

namespace App\Model;


use App\Core\BaseModel;

class User extends BaseModel
{
    public function createUser(array $fields)
    {
        if (!$userId = $this->create("users", $fields)) {
            throw new \Exception('Error happened when creating user!');
        }

        return $userId;
    }

    public function updateUser(array $fields, $userId = null)
    {
        if (!$this->update("users", $fields, $userId)) {
            throw new \Exception('Error happened when updating user!');
        }
    }

    public static function findUserByEmail($email)
    {
        $user = new self();
        if ($user->find("users", ['email', "=", $email])->exists()) {
            return $user;
        }

        return false;
    }

    public static function findUser($id)
    {
        $user = new self();
        if ($user->find("users", ['id', "=", $id])->exists()) {
            return $user;
        }

        return false;
    }
}
