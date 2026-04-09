





<nav class="bg-gray-800 md:bg-gray-800/50 fixed w-full z-20 top-0 start-0 border-b border-default">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto">
    <a href="{{ route('dashboard') }}" class="flex items-center rtl:space-x-reverse">
        {{-- <img src="../images/logo-rr.png" class="h-12 text-center" alt="Flowbite Logo"> --}}
        <x-application-logo class="flex items-center h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
        <span class="self-center text-xl text-heading font-semibold whitespace-nowrap text-white">The RR Chocolate</span>
    </a>
    <div class="flex md:order-2 space-x-3 items-center md:space-x-0 rtl:space-x-reverse">
        {{-- Login --}}
        <div class="flex items-center">

                @auth
                    <!-- USER DROPDOWN -->
                    <div class="relative">
                        {{-- <button id="userMenuBtn" --}}
                        <button
                            class="flex items-center rounded-full gap-2 px-3 py-2  hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            
                            <!-- Avatar Circle -->
                            <div class="w-9 h-9 bg-blue-500 text-white rounded-full flex items-center justify-center font-semibold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <!-- Username (hide on mobile) -->
                            <span class="hidden sm:block text-gray-700 dark:text-gray-300">
                                {{ Auth::user()->name }}
                            </span>

                        </button>
                    </div>

                    <!-- Toggle Script -->
                    <script>
                        const btn = document.getElementById('userMenuBtn');
                        const menu = document.getElementById('userMenu');

                        btn.addEventListener('click', () => {
                            menu.classList.toggle('hidden');
                        });

                        // close on click outside
                        document.addEventListener('click', function (e) {
                            if (!btn.contains(e.target) && !menu.contains(e.target)) {
                                menu.classList.add('hidden');
                            }
                        });
                    </script>

                @else
                    <!-- SIGN IN -->
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition">
                        Sign In
                    </a>

                    <!-- REGISTER -->
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        Register
                    </a>
                @endauth
        </div>
        <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex text-white items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden hover:bg-gray-400/50 hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary" aria-controls="navbar-sticky" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/></svg>
        </button>
    </div>
    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1 " id="navbar-sticky">
      <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-default rounded-base text-gray-200 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 ">
        <li>
          <a href="{{ route('dashboard') }}" class="block py-2 px-3 text-white bg-brand rounded-sm md:bg-transparent md:text-fg-brand md:p-0" aria-current="page">Dashboard</a>
        </li>
        <li>
          <a href="{{ route('tickets.index') }}" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Ticket</a>
        </li>
        <li>
          <a href="{{ route('struktur.index') }}" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Operational Structure</a>
        </li>
        {{-- <li>
          <a href="{{ route('inventory.index') }}" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Inventory</a>
        </li> --}}
      </ul>
    </div>
  </div>
</nav>

