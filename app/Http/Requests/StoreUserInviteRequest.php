<?php

namespace App\Http\Requests;

use App\Enums\UserLevel;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreUserInviteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('invite', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'level' => ['required', new Enum(UserLevel::class)]
        ];
    }
}
