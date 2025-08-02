

{{-- <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      <div class="flex items-center justify-start rtl:justify-end">
        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
               <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
         </button>
        <a href="https://flowbite.com" class="flex ms-2 md:me-24">
          <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="FlowBite Logo" />
          <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">Flowbite</span>
        </a>
      </div>
      <div class="flex items-center">
          <div class="flex items-center ms-3">
            <div>
              <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                <span class="sr-only">Open user menu</span>
                <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
              </button>
            </div>
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-sm shadow-sm dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
              <div class="px-4 py-3" role="none">
                <p class="text-sm text-gray-900 dark:text-white" role="none">
                  Neil Sims
                </p>
                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                  neil.sims@flowbite.com
                </p>
              </div>
              <ul class="py-1" role="none">
                <li>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Dashboard</a>
                </li>
                <li>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Settings</a>
                </li>
                <li>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Earnings</a>
                </li>
                <li>
                  <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Sign out</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
    </div>
  </div>
</nav> --}}

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
   <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
      <ul class="space-y-2 font-medium">

         @php
            $isITSupportActive = request()->routeIs('dashboard') || 
                                 request()->routeIs('visits.*') || 
                                 request()->routeIs('schedules.*');
         
            $isMaintenanceActive = request()->routeIs('building.tickets.*') || 
                                 request()->routeIs('building.visits.*') || 
                                 request()->routeIs('schedulebuilds.*');

            $isAdminActive = request()->routeIs('admin.users.*') || 
                                 request()->routeIs('roles.*') || 
                                 request()->routeIs('permissions.*');
         @endphp

         {{-- IT Support --}}
         @if(auth()->user()->hasRole('superadmin|admin|hrd|direksi'))
         <li>
            <button type="button"
               class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group
               {{ $isITSupportActive ? 'bg-gray-200 dark:bg-gray-700 text-blue-600 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}"
               aria-controls="dropdown-it"
               data-collapse-toggle="dropdown-it">
               
               <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            
               <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 16H5a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v1M9 12H4m8 8V9h8v11h-8Zm0 0H9m8-4a1 1 0 1 0-2 0 1 1 0 0 0 2 0Z"/>
               </svg>


               <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">IT Support</span>
               <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
               </svg>
            </button>
            @endif

            <ul id="dropdown-it" class="py-2 space-y-2 {{ $isITSupportActive ? '' : 'hidden' }}">
               @if(auth()->user()->hasRole('superadmin|admin|direksi'))
                     <li>
                        <a href="{{ route('dashboard') }}"
                           class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group 
                           {{ request()->routeIs('dashboard') ? 'text-blue-600 font-semibold' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                           Ticketing
                        </a>
                     </li>
                     <li>
                        <a href="{{ route('visits.index') }}"
                           class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group 
                           {{ request()->routeIs('visits.*') ? 'text-blue-600 font-semibold' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                           Visit Schedule
                        </a>
                     </li>
               @endif

               @if(auth()->user()->hasRole('superadmin|admin|hrd|direksi'))
                     <li>
                        <a href="{{ route('schedules.index') }}"
                           class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group 
                           {{ request()->routeIs('schedules.*') ? 'text-blue-600 font-semibold' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                           Schedule
                        </a>
                     </li>
               @endif
            </ul>
         </li>

         {{-- Maintenance --}}
         <li>
            <button type="button"
               class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group
               {{ $isMaintenanceActive ? 'bg-gray-200 dark:bg-gray-700 text-blue-600 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}"
               aria-controls="dropdown-mt"
               data-collapse-toggle="dropdown-mt">
               
               <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M7.58209 8.96025 9.8136 11.1917l-1.61782 1.6178c-1.08305-.1811-2.23623.1454-3.07364.9828-1.1208 1.1208-1.32697 2.8069-.62368 4.1363.14842.2806.42122.474.73509.5213.06726.0101.1347.0133.20136.0098-.00351.0666-.00036.1341.00977.2013.04724.3139.24069.5867.52125.7351 1.32944.7033 3.01552.4971 4.13627-.6237.8375-.8374 1.1639-1.9906.9829-3.0736l4.8107-4.8108c1.0831.1811 2.2363-.1454 3.0737-.9828 1.1208-1.1208 1.3269-2.80688.6237-4.13632-.1485-.28056-.4213-.474-.7351-.52125-.0673-.01012-.1347-.01327-.2014-.00977.0035-.06666.0004-.13409-.0098-.20136-.0472-.31386-.2406-.58666-.5212-.73508-1.3294-.70329-3.0155-.49713-4.1363.62367-.8374.83741-1.1639 1.9906-.9828 3.07365l-1.7788 1.77875-2.23152-2.23148-1.41419 1.41424Zm1.31056-3.1394c-.04235-.32684-.24303-.61183-.53647-.76186l-1.98183-1.0133c-.38619-.19746-.85564-.12345-1.16234.18326l-.86321.8632c-.3067.3067-.38072.77616-.18326 1.16235l1.0133 1.98182c.15004.29345.43503.49412.76187.53647l1.1127.14418c.3076.03985.61628-.06528.8356-.28461l.86321-.8632c.21932-.21932.32446-.52801.2846-.83561l-.14417-1.1127ZM19.4448 16.4052l-3.1186-3.1187c-.7811-.781-2.0474-.781-2.8285 0l-.1719.172c-.7811.781-.7811 2.0474 0 2.8284l3.1186 3.1187c.7811.781 2.0474.781 2.8285 0l.1719-.172c.7811-.781.7811-2.0474 0-2.8284Z"/>
               </svg>

               <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Maintenance</span>
               <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
               </svg>
            </button>

            <ul id="dropdown-mt" class="py-2 space-y-2 {{ $isMaintenanceActive ? '' : 'hidden' }}">
                     @if(auth()->user()->hasRole('superadmin|admin|building|direksi|maintenance|maintenance1'))

                     <li>
                        <a href="{{ route('building.tickets.index') }}"
                           class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group 
                           {{ request()->routeIs('building.tickets.*') ? 'text-blue-600 font-semibold' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                           Ticketing
                        </a>
                     </li>
                     @endif

                     @if(auth()->user()->hasRole('superadmin|admin|direksi|maintenance|maintenance1'))
                     <li>
                        <a href="{{ route('building.visits.index') }}"
                           class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group 
                           {{ request()->routeIs('building.visits.*') ? 'text-blue-600 font-semibold' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                           Visit Schedule
                        </a>
                     </li>
                     @endif

                     @if(auth()->user()->hasRole('superadmin|admin|hrd|direksi|maintenance|maintenance1'))
                     <li>
                        <a href="{{ route('schedulebuilds.index') }}"
                           class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group 
                           {{ request()->routeIs('schedulebuilds.*') ? 'text-blue-600 font-semibold' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                           Schedule
                        </a>
                     </li>
                     @endif
            </ul>
         </li>

         <li>
            <a href="{{ route('outlets.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
               <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                  <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                  <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
               </svg>
               <span class="ms-3">Area Outlet</span>
            </a>
         </li>
         {{-- Master Data --}}
         @if(auth()->user()->hasRole('superadmin'))
         <li class="space-y pt-4 mt-4 font-medium border-t border-gray-200 dark:border-gray-700">
            <button type="button"
               class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group
               {{ $isAdminActive ? 'bg-gray-200 dark:bg-gray-700 text-blue-600 dark:text-white' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}"
               aria-controls="dropdown-admin"
               data-collapse-toggle="dropdown-admin">
               
               <svg class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M10 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h2m10 1a3 3 0 0 1-3 3m3-3a3 3 0 0 0-3-3m3 3h1m-4 3a3 3 0 0 1-3-3m3 3v1m-3-4a3 3 0 0 1 3-3m-3 3h-1m4-3v-1m-2.121 1.879-.707-.707m5.656 5.656-.707-.707m-4.242 0-.707.707m5.656-5.656-.707.707M12 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
               </svg>


               <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Master Data</span>
               <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
               </svg>
            </button>

            <ul id="dropdown-admin" 
               class="py-2 space-y-2  
               {{ $isAdminActive ? '' : 'hidden' }}">
                     <li>
                        <a href="{{ route('admin.users.index') }}"
                           class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group 
                           {{ request()->routeIs('admin.users.*') ? 'text-blue-600 font-semibold' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                           Users
                        </a>
                     </li>
                     <li>
                        <a href="{{ route('roles.index') }}"
                           class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group 
                           {{ request()->routeIs('roles.*') ? 'text-blue-600 font-semibold' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                           Roles
                        </a>
                     </li>
                     <li>
                        <a href="{{ route('permissions.index') }}"
                           class="flex items-center w-full p-2 transition duration-75 rounded-lg pl-11 group 
                           {{ request()->routeIs('permissions.*') ? 'text-blue-600 font-semibold' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                           Permissions
                        </a>
                     </li>
            </ul>

         </li>
         @endif

         
         
         
      </ul>
      @include('components.footer')
   </div>
</aside>


