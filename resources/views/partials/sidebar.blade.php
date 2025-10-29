<aside class="w-64 bg-white shadow-md">
    <div class="pl-8 pt-6 mt-2">
        <h6 class="text-lg font-bold text-gray-700">Menu Admin</h6>
    </div>
    <nav class="p-4">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="block px-4 py-2 rounded-lg 
                   {{ Route::is('admin.dashboard') ? 'bg-blue-500 text-white font-semibold' : 'hover:bg-blue-50 text-gray-700 font-medium' }}">
                    <i class="fa-solid fa-chart-line mr-2"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('reservasi.admin') }}"
                   class="block px-4 py-2 rounded-lg 
                   {{ Route::is('reservasi.admin') ? 'bg-blue-500 text-white font-semibold' : 'hover:bg-blue-50 text-gray-700 font-medium' }}">
                    <i class="fa-solid fa-calendar-check mr-2"></i> Kelola Reservasi
                </a>
            </li>

            <li>
                <a href="{{ route('admin.reservations.history') }}"
                   class="block px-4 py-2 rounded-lg 
                   {{ Route::is('reservations.history') ? 'bg-blue-500 text-white font-semibold' : 'hover:bg-blue-50 text-gray-700 font-medium' }}">
                    <i class="fa-solid fa-clock-rotate-left mr-2"></i> Riwayat Reservasi
                </a>
            </li>

            <li>
                <a href="{{ route('treatments.manage') }}"
                   class="block px-4 py-2 rounded-lg 
                   {{ Route::is('treatments.manage') ? 'bg-blue-500 text-white font-semibold' : 'hover:bg-blue-50 text-gray-700 font-medium' }}">
                    <i class="fa-solid fa-spa mr-2"></i> Kelola Treatment
                </a>
            </li>

            <li>
                <a href="{{ route('admin.faq.index') }}"
                   class="block px-4 py-2 rounded-lg 
                   {{ Route::is('admin.faq.*') ? 'bg-blue-500 text-white font-semibold' : 'hover:bg-blue-50 text-gray-700 font-medium' }}">
                    <i class="fa-solid fa-circle-question mr-2"></i> Kelola FAQ
                </a>
            </li>

            <li>
                <a href="{{ route('admin.feedback.index') }}"
                   class="block px-4 py-2 rounded-lg 
                   {{ Route::is('admin.feedback.*') ? 'bg-blue-500 text-white font-semibold' : 'hover:bg-blue-50 text-gray-700 font-medium' }}">
                    <i class="fa-solid fa-comments mr-2"></i> Kelola Feedback
                </a>
            </li>
        </ul>
    </nav>
</aside>
