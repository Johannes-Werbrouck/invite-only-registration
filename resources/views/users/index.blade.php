@php use App\Enums\UserLevel; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- MESSAGES --}}
            @if(session('success'))
                <div class="flex items-center bg-green-50 p-6 mb-6 w-full sm:rounded-lg sm:px-10 transition duration-700 ease-in-out"
                     x-data="{show: true}"
                     x-show="show"
                     x-init="setTimeout(() => show = false, 30000)"
                     x-transition>
                    <div class="flex mx-auto">
                        <svg class="h-6 w-6 flex-none fill-green-800 stroke-green-50 stroke-2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="11" />
                            <path d="m8 13 2.165 2.165a1 1 0 0 0 1.521-.126L16 9" fill="none" />
                        </svg>
                        <p class="ml-2 text-green-800">
                            {!! session('success') !!}
                        </p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="flex items-center bg-red-100 p-6 mb-6 w-full sm:rounded-lg sm:px-10 transition duration-700 ease-in-out"
                     x-data="{show: true}"
                     x-show="show"
                     x-init="setTimeout(() => show = false, 30000)"
                     x-transition>
                    <div class="flex mx-auto">
                        <svg class="w-6 h-6 flex-none fill-red-800 stroke-red-100 stroke-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5"  >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                        <p class="ml-2 text-red-800">
                            {!! session('error') !!}
                        </p>
                    </div>
                </div>
            @endif

            <div class="flex items-center">
                <h1 class="text-2xl font-extrabold flex-1">Users</h1>
                @can('invite', App\Models\User::class)
                    <a href="{{route('userinvites.create')}}"
                       class="inline-flex items-center m-4 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase
                    tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out
                    duration-150">
                        + Invite New User
                    </a>
                @endcan
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full table-auto">
                    <thead class="font-bold bg-gray-50 border-b-2">
                    <tr>
                        <td class="p-4">{{__('ID')}}</td>
                        <td class="p-4">{{__('Name')}}</td>
                        <td class="p-4">{{__('Email')}}</td>
                        <td class="p-4">{{__('Level')}}</td>
                        <td class="p-4">{{__('Actions')}}</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr class="border">
                            <td class="p-4">{{$user->id}}</td>
                            <td class="p-4">{{$user->name}}</td>
                            <td class="p-4">{{$user->email}}</td>
                            <td class="p-4">
                            <span @class([
                                   'px-2 py-1 font-semibold text-sm rounded-lg',
                                   'text-indigo-700 bg-indigo-100' => UserLevel::Member === $user->level,
                                   'text-sky-700 bg-sky-100' => UserLevel::Contributor === $user->level,
                                   'text-teal-700 bg-teal-100' => UserLevel::Administrator === $user->level,
                                   ])>
                             {{__($user->level->name)}}
                           </span>
                            </td>
                            <td class="p-4">
                                @can('updateLevel', $user)
                                <a href="{{route('userlevels.edit', $user)}}" class="px-4 py-2 bg-gray-800 rounded-md font-semibold text-xs text-white uppercase tracking-widest">Edit</a>
                                @endcan
                                @can('delete', $user)
                                    <form class="inline-block" method="post" action="{{route('users.destroy', $user)}}">
                                        @csrf
                                        @method('delete')
                                        <x-danger-button>Delete</x-danger-button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
