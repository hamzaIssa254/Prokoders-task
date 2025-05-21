<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\User\StoreUserRequest;

class UserController extends Controller
{
    protected $userService;
    /**
     * Summary of __construct
     * @param \App\Services\UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Summary of index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $users = $this->userService->listAllUsers($perPage);
        return $this->success($users);

    }

    /**
     * Summary of store
     * @param \App\Http\Requests\User\StoreUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $user = $this->userService->createUSer($data);
        return $this->success($user,"user created success");
    }

    /**
     * Summary of show
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        $user = $this->userService->getUser($user);
        return $this->success($user,"user retreive success");
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\User\UpdateUserRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $user = $this->userService->updateUser($data,$user);
        return $this->success($user,"user updated success");
    }

    /**
     * Summary of destroy
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $this->userService->deleteUser($user);
        return $this->success(null,"user deleted success");
    }
}
