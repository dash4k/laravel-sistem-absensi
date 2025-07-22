<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full flex flex-row justify-end items-center mb-4">
                <button id="addButton" class="w-auto px-4 py-2 bg-blue-600 text-white rounded-md hover:cursor-pointer hover:bg-blue-200 hover:text-black transition-all duration-150" title="Tambah Buku"><i class="fa-solid fa-plus"></i></button>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="w-full h-auto p-2 mt-4 flex flex-col justify-between items-center gap-10">
                        <div class="w-full">
                            <table class="table-fixed w-full text-center text-sm break-words">
                                <thead class="bg-blue-600 text-white font-black">
                                    <tr>
                                        <th class="border px-4 py-2 w-2/4">Nama Pegawai</th>
                                        <th class="border px-4 py-2">Email</th>
                                        <th class="border px-4 py-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $pegawai)
                                        <tr>
                                            <td class="border px-4 py-2 capitalize">{{ $pegawai->name }}</td>
                                            <td class="border px-4 py-2">{{ $pegawai->email }}</td>
                                            <td class="border px-4 py-2">
                                                <form action="{{ route('admin.pegawai.destroy', $pegawai->id) }}" method="post" class="deleteForm">
                                                    @csrf
                                                    @method('DELETE')
    
                                                    <button type="button" class="deleteButton bg-red-600 text-white hover:bg-red-400 hover:text-black px-2 py-1 rounded hover:cursor-pointer transition-all duration-150" title="Hapus Akun"><i class="fa-solid fa-eraser"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="border px-4 py-2" colspan="3">Tidak ada data pegawai.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <div id="formContainer" class="fixed inset-0 bg-blue-200/30 backdrop-blur-sm z-100 flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300 ease-out w-full h-full pl-5 pr-5 lg:pl-0 lg:pr-0">
            <div class="bg-white dark:bg-gray-700 p-6 rounded max-w-lg w-full transform transition-all duration-300 ease-in-out shadow-lg shadow-blue-300/50">
                <form id="pegawaiForm" class="hidden flex flex-col gap-2" action="{{ route('admin.pegawai.store') }}" method="POST">
                    @csrf
                    <div class="w-full flex flex-row justify-center items-center">
                        <h1 class="font-bold text-lg dark:text-white">Registrasi Akun Pegawai</h1>
                    </div>
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-secondary-button class="ms-4" id="cancelButton">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-primary-button class="ms-4" id="submitButton">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        @if ($errors->any() || session('error'))
            <script>
                window.laravelErrors = [];

                @if ($errors->any())
                    window.laravelErrors = @json($errors->all());
                @endif

                @if (session('error'))
                    window.laravelErrors.push(@json(session('error')));
                @endif
            </script>
        @endif
        @if (session('success'))
            <script>
                window.laravelSuccess = @json(session('success'));
            </script>
        @endif
    @endpush
</x-app-layout>