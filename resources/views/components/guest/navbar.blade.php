<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-default">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LOGO -->
            <div class="flex items-center">
                <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="../images/logo-rr.png" class="h-10" alt="Flowbite Logo" />
                    <span class="self-center text-xl text-white text-heading font-semibold whitespace-nowrap">The RR Chocolate</span>
                </a>
            </div>

            <div class="items-center justify-between hidden w-full md:flex md:w-auto" id="navbar-user">
              <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-default rounded-base bg-neutral-secondary-soft md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-neutral-primary">
                <li>
                  <a href="{{ route('dashboard') }}" aria-current="page" class="block text-white py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent" aria-current="page">Home</a>
                </li>
                <li>
                  <a href="{{ route('tickets.index') }}" class="block text-gray-300 py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Tickets</a>
                </li>
                <li>
                  <a href="#" class="block text-gray-300 py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Struktur Operational</a>
                </li>
              </ul>
            </div>

            <!-- RIGHT MENU -->
            <div class="flex items-center gap-4 top-10">

                @auth
                    <!-- USER DROPDOWN -->
                    <div class="relative top-2 pb-4">
                        {{-- <button id="userMenuBtn" --}}
                        <button
                            class="flex items-center gap-2 px-3 py-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            
                            <!-- Avatar Circle -->
                            <div class="w-9 h-9 bg-blue-500 text-white rounded-full flex items-center justify-center font-semibold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <!-- Username (hide on mobile) -->
                            <span class="hidden sm:block text-gray-700 dark:text-gray-300">
                                {{ Auth::user()->name }}
                            </span>

                            <!-- Chevron -->
                            {{-- <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg> --}}
                        </button>

                        <!-- DROPDOWN PANEL -->
                        {{-- <div id="userMenu"
                            class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-lg py-2 border border-gray-200 dark:border-gray-700">
                            
                            <a href="{{ route('dashboard') }}"
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Dashboard
                            </a>

                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm z-auto text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Log Out
                                </button>
                            </form>
                        </div> --}}
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
        </div>
    </div>
</nav>



{{-- <nav class="bg-gray-800 fixed w-full z-20 top-0 start-0 border-b border-default">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
  <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="../images/logo-rr.png" class="h-10" alt="Flowbite Logo" />
      <span class="self-center text-xl text-white text-heading font-semibold whitespace-nowrap">The RR Chocolate</span>
  </a>
  <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
    <a href="{{ route('tickets.index') }}">
    <button type="button" class="text-white bg-[#0f1419] hover:bg-[#0f1419]/90 focus:ring-4 focus:outline-none focus:ring-[#0f1419]/50 box-border border border-transparent font-medium leading-5 rounded-xl text-sm px-4 py-2.5 text-center inline-flex items-center dark:hover:bg-[#24292F] dark:focus:ring-[#24292F]/55">
      Sign in
    </button>
    </a>
  </div>
  <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
    <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-default rounded-base bg-neutral-secondary-soft md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-neutral-primary">
      <li>
        <a href="{{ route('dashboard') }}" aria-current="page" class="block text-white py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent" aria-current="page">Home</a>
      </li>
      <li>
        <a href="{{ route('tickets.index') }}" class="block text-gray-300 py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Tickets</a>
      </li>
      <li>
        <a href="#" class="block text-gray-300 py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Struktur Operational</a>
      </li>
    </ul>
  </div>
  </div>
</nav> --}}
