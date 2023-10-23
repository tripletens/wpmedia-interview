<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>
    <div class="text-5xl font-extrabold ...">
        <span class="bg-clip-text text-transparent bg-gradient-to-r from-green-400 to-blue-500">
            Hello world
        </span>

        
        <x-welcomemsg></x-welcomemsg>
    </div>
</x-admin-layout>
