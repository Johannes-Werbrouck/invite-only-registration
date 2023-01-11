@php use App\Enums\UserLevel; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invite Users') }}
        </h2>
    </x-slot>

    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">

        <div class=" w-full sm:max-w-md mt-24 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ url('/users/invite') }}">
                @csrf

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')"/>

                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus/>

                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <!-- User Level -->
                <div class="mt-4">
                    <x-input-label for="level" :value="__('User Level')"/>

                    <select name="level" id="level" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @foreach(UserLevel::cases() as $levelOption)
                            <option value="{{$levelOption}}" @if ($levelOption == old('level')) selected="selected" @endif>
                                {{$levelOption->name}}
                            </option>
                        @endforeach
                    </select>

                    <x-input-error :messages="$errors->get('level')" class="mt-2"/>
                </div>

                <div class="flex items-center justify-end mt-6">
                    {{-- back button --}}
                    <a href="{{url()->previous()}}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase
                        tracking-widest hover:bg-gray-400 active:bg-gray-100 focus:outline-none focus:border-gray-100 focus:ring ring-gray-900 disabled:opacity-25 transition ease-in-out
                        duration-150">
                        Go Back
                    </a>

                    <x-primary-button class="ml-4">
                        {{ __('Invite') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
