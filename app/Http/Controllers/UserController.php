<?php

namespace App\Http\Controllers;

use App\Enums\User\GenderEnum;
use App\Http\Filters\UserFilter;
use App\Http\Requests\User\IndexRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(IndexRequest $request)
    {
        $filter = app()->make(UserFilter::class, ['queryParams' => array_filter($request->validated())]);
        $users = User::filter($filter)->where('id', '!=', auth()->user()->id)->paginate(15);

        return view('user.index', [
            'users' => $users,
        ]);
    }

    public function edit(User $user): View
    {
        return view('user.edit', [
            'user' => $user,
            'genders' => GenderEnum::asSelectArray(),
            'address' => $user->address,
        ]);
    }

    public function update(UpdateRequest $request, User $user, UserService $userService): RedirectResponse
    {
        $data = $request->validated();

        $data = $userService->processAddress($user, $data);

        $user->update($data);

        return Redirect::route('users.edit', $user->id)->with('status', 'Данные пользователя обновлены.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->orders()->delete();
        $user->delete();
        return Redirect::route('users.index')->with('status', 'Пользователь "' . $user->name . '" удален.');
    }

    public function restore(int $userId)
    {
        User::withTrashed()->find($userId)->restore();
        return Redirect::route('users.edit', $userId)->with('status', 'Пользователь восстановлен');
    }
}
