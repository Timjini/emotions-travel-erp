@props([
    'columns' => [],
])
<thead class="bg-gradient-to-r from-[#f3f7fc] to-[#eef3f8] border-b border-gray-200/70">
    <tr>
        @foreach ($columns as $column)
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider cursor-pointer hover:text-gray-800 transition">
                {{ $column }}
            </th>
        @endforeach
    </tr>
</thead>