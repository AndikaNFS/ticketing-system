<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Dashboard') }}</title>
        <link rel="icon" href="{{ asset('images/logo-rr.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-300 dark:bg-gray-900">
            @include('layouts.navigation-user')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
  
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('ticketForm').addEventListener('submit', function(e) {
            e.preventDefault(); // cegah submit default

            const formData = new FormData(this);
            
            fetch("{{ route('tickets.store') }}" , {
                method: "POST",
                body: formData,
                header: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    Swal.fire({
                        title: 'Tiket Berhasil Dibuat!',
                        text: 'Kode Tiket' + data.ticket_code,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // redirect atau reset form setelah popup
                        document.getElementById('ticketForm').reset()
                    });
                } else {
                    Swal.fire('Gagal', data.message ?? 'Terjadi kesalahan.','error');
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Gagal','Terjadi kesalahan saat menyimpan.','error');
            });
        });
    </script> --}}
</html>
