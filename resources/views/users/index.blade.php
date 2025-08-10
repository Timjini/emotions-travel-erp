<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            {{ __('messages.users') }}
        </h2>
    </x-slot>

    <nav class="max-w-3xl sm:px-6 lg:px-8" aria-label="Breadcrumb">  
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li>
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l6 6a1 1 0 010 1.414l-6 6A1 1 0 0110 17V3z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li class="text-gray-800 font-medium">Users</li>
        </ol>
    </nav>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <h1 class="text-2xl font-bold">{{ __('Users List') }}</h1>
                        <x-link-button :href="route('users.create')" class="w-full sm:w-auto text-center">
                            {{ __('Add New User') }}
                        </x-link-button>
                    </div>

                    <div class="overflow-x-auto bg-white shadow rounded-lg">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-50 hidden sm:table-header-group">
                                    <tr>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Joined</th>
                                        <th class="px-4 sm:px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse ($users as $user)
                                    <tr class="block sm:table-row">
                                        <!-- Name Column -->
                                        <td class="px-4 sm:px-6 py-4 block sm:table-cell">
                                            <div class="flex justify-between sm:block">
                                                <span class="text-xs font-semibold text-gray-600 uppercase sm:hidden">Name</span>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ '@' . $user->username }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Email Column -->
                                        <td class="px-4 sm:px-6 py-4 block sm:table-cell">
                                            <div class="flex justify-between sm:block">
                                                <span class="text-xs font-semibold text-gray-600 uppercase sm:hidden">Email</span>
                                                <span class="text-gray-700">{{ $user->email }}</span>
                                            </div>
                                        </td>
                                        
                                        <!-- Joined Column -->
                                        <td class="px-4 sm:px-6 py-4 block sm:table-cell">
                                            <div class="flex justify-between sm:block">
                                                <span class="text-xs font-semibold text-gray-600 uppercase sm:hidden">Joined</span>
                                                <span class="text-gray-600">{{ $user->created_at->format('M d, Y') }}</span>
                                            </div>
                                        </td>
                                        
                                        <!-- Actions Column -->
                                        <td class="px-4 sm:px-6 py-4 block sm:table-cell">
                                            <div class="flex justify-between sm:justify-end gap-2 flex-wrap">
                                                <span class="text-xs font-semibold text-gray-600 uppercase sm:hidden w-full">Actions</span>
                                                <x-link-button :href="route('users.show', $user)" class="text-xs sm:text-sm px-2 py-1 sm:px-4 sm:py-2">
                                                    {{ __('View') }}
                                                </x-link-button>
                                                @can('update', $user)
                                                <x-primary-button :href="route('users.edit', $user)" class="text-xs sm:text-sm px-2 py-1 sm:px-4 sm:py-2">
                                                    {{ __('Edit') }}
                                                </x-primary-button>
                                                @endcan
                                                <x-danger-button
                                                    x-data=""
                                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                                                    class="text-xs sm:text-sm px-2 py-1 sm:px-4 sm:py-2">
                                                    {{ __('Delete') }}
                                                </x-danger-button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            {{ __('No users found.') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete User Confirmation Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('users.destroy', $user ?? null) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete this user?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once this user is deleted, all of their resources and data will be permanently removed.') }}
            </p>

            <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="w-full sm:w-auto text-center">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="w-full sm:w-auto text-center">
                    {{ __('Delete User') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>