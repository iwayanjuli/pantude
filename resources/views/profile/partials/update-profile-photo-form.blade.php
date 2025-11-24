<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Foto Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui foto profil akun Anda.") }}
        </p>
    </header>

    <!-- Tampilkan Foto Saat Ini -->
    <div class="mt-4 mb-4">
        @if(Auth::user()->avatar)
            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full object-cover border shadow">
        @else
            <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 border shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
        @endif
    </div>

    <form method="post" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="avatar" :value="__('Upload Foto Baru')" />
            <input id="avatar" name="avatar" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required />
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-[#3bdc16] hover:bg-green-700">{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'avatar-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>