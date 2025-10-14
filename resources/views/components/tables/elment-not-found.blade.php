@props(
[
    'title' => 'No data found',
    'subtitle' => 'Try adjusting your filters or add a new destination.',
    'colspan' => '3',
]
)
                <tr>
                  <td colspan="{{$colspan}}" class="px-6 py-10 text-center">
                    <div class="inline-flex flex-col items-center justify-center bg-gradient-to-br from-white via-[#f8fbff] to-[#e6edf5] border border-gray-200/60 rounded-2xl shadow-sm p-6 relative overflow-hidden">
                      <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(200,220,255,0.25),transparent_70%)]"></div>
                      <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,rgba(210,240,255,0.25),transparent_70%)]"></div>
        
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg>
        
                      <p class="text-gray-600 font-medium">{{$title}}</p>
                      <p class="text-gray-400 text-sm mt-1">{{$subtitle}}</p>
                    </div>
                  </td>
                </tr>