<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __("You're logged in as an admin.") }}
            </div>
        </div>
    </div>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 flex gap-6 lg:gap-8">
        <a href="{{ route('my.reports') }}" class="flex-1 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex">
            <div>
                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                        <i class="far fa-eye" style="font-size: 20px; color:#ef4444;margin-right: 20px"></i>
                    </svg>
                </div>

                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">View my previous reports</h2>

                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                    You can access the report you have previously made here.
                </p>
            </div>
        </a>

        <a href="{{ route('show.create.report') }}" class="flex-1 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex">
            <div>
                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                        <i class="fas fa-plus" style="font-size: 20px; color:#ef4444;margin-right: 23px"></i>
                    </svg>
                </div>

                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Create a report</h2>

                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                    Even though you are an admin, you still have permission to create reports, just like on the TruckersMP website.
                </p>
            </div>
        </a>

        <a href="{{ route('handle.reports') }}" class="flex-1 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex">
            <div>
                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                        <i class="fas fa-hammer" style="font-size: 20px; color:#ef4444;margin-right: 20px"></i>
                    </svg>
                </div>

                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Handle reports</h2>

                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                    You can abuse your admin powers here.
                </p>
            </div>
        </a>
        
    </div>

    
</x-app-layout>
