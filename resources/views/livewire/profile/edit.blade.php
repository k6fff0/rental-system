<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">تعديل الملف الشخصي</h1>

    @if (session()->has('success'))
        <div class="mb-4 text-green-600 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="bg-white shadow rounded-lg p-6" enctype="multipart/form-data">

        {{-- الاسم --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">الاسم</label>
            <input type="text" wire:model.defer="name"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
            @error('name')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- البريد الإلكتروني --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
            <input type="email" wire:model.defer="email"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
            @error('email')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- رقم الهاتف --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">رقم الهاتف</label>
            <input type="text" wire:model.defer="phone"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
            @error('phone')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- كلمة المرور --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">كلمة المرور الجديدة</label>
            <input type="password" wire:model.defer="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
            @error('password')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{-- صورة الملف الشخصي --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">الصورة الشخصية</label>
            <input type="file" wire:model="photo" class="mt-1 block w-full">
            @error('photo')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror

            @if ($photo || $currentPhotoUrl)
                <div class="mt-3">
                    <button type="button"
                        @click="window.open('{{ $photo ? $photo->temporaryUrl() : $currentPhotoUrl }}', '_blank')"
                        class="text-blue-600 hover:underline text-sm">
                        عرض الصورة الحالية
                    </button>
                </div>
            @endif
        </div>

        <hr class="my-6">

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            حفظ التعديلات
        </button>
    </form>
</div>
