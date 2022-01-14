<?php

namespace App\Http\Controllers;
use App\Repository\UserRepositoryInterface;
use App\Http\Resources\UsersResource;

class UsersController extends Controller
{
   private $userRepository;
  
   public function __construct(UserRepositoryInterface $userRepository)
   {
       $this->userRepository = $userRepository;
   }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepository->all();

        return UsersResource::collection($users);
    }
}
