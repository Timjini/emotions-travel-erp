<x-app-layout>
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li>
                <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            </li>
            <li>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l6 6a1 1 0 010 1.414l-6 6A1 1 0 0110 17V3z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li class="text-gray-800 font-medium">Destinations</li>
        </ol>
    </nav>
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                    <h1 class="text-2xl font-bold text-gray-900">Destinations Management</h1>
                    <p class="text-sm text-gray-500 mt-1">Create agency's destinations, travels and packages.</p>
                </div>
            <x-link-button :href="route('destinations.create')">
                Add New Destination
            </x-link-button>
        </div>

       <div class="overflow-x-auto rounded-2xl shadow-sm border border-gray-100 bg-gradient-to-br from-white via-[#f9fbff] to-[#eef3f9] relative">
          <table class="min-w-full text-sm text-gray-700">
             <x-tables.table-header :columns="['Name', 'Country', 'Actions']" />
        
            <tbody class="divide-y divide-gray-100/80">
              @forelse ($destinations as $destination)
                <tr class="hover:bg-gradient-to-r hover:from-[#f7faff] hover:to-[#eef5fb] transition">
                  <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">
                    {{ $destination->name }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                    {{ $destination->country->name }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <x-action-buttons 
                      viewRoute="{{ route('destinations.show', $destination) }}"
                      editRoute="{{ route('destinations.edit', $destination) }}"
                      deleteRoute="{{ route('destinations.destroy', $destination) }}"
                    />
                  </td>
                </tr>
              @empty
               <x-tables.elment-not-found
                      title="No destinations found" 
                      subtitle="Try adjusting your filters or add a new destination."
                      :colspan="3" 
                  />
              @endforelse
            </tbody>
          </table>
        </div>


        <div class="mt-6">
            {{ $destinations->links() }}
        </div>
    </div>
</x-app-layout>