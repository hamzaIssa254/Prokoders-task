<?php

namespace App\Services;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class UserService
{
    /**
     * Summary of createUSer
     * @param array $data
     * @return void
     */
    public function createUSer(array $data)
    {
        DB::beginTransaction();
        try {
            User::create($data);
            Cache::forget('users_');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('error when creating user ' . $e->getMessage());
        }

    }
    /**
     * Summary of listAllUsers
     * @param int $perPage
     */
    public function listAllUsers(int $perPage)
    {
        try {
            $cacheKey = 'users_' . md5($perPage . request('page', 1));

            $users = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($perPage) {
                return User::with('tasks')->paginate($perPage);
            });
            return $users;
        } catch (Exception $e) {

            Log::error('error when list all users ' . $e->getMessage());

        }


    }
    /**
     * Summary of getUser
     * @param \App\Models\User $user
     * @return User
     */
    public function getUser(User $user)
    {
        try {
            return $user->load('tasks');
        } catch (Exception $e) {
            Log::error('error when get the user ' . $e->getMessage());

        }
    }
    /**
     * Summary of updateUser
     * @param array $data
     * @param \App\Models\User $user
     * @return void
     */
    public function updateUser(array $data, User $user)
    {
        DB::beginTransaction();
        try {

            $user->update(array_filter($data));

            Cache::forget('users_');

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('error while updating user ' . $e->getMessage());


        }
    }
    /**
     * Summary of deleteUser
     * @param \App\Models\User $user
     * @return void
     */
    public function deleteUser(User $user)
    {
        DB::beginTransaction();

        try {
            $user->delete();
            Cache::forget('users_');

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('error while deleting user ' . $e->getMessage());

        }
    }
}
