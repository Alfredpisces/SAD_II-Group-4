<x-guest-layout>
    <style>
        /* This removes the default layout styling and forces your theme */
        .min-h-screen {
            background-color: #FDF8F1 !important;
        }

        nav,
        .py-6.flex.flex-col {
            display: none !important;
        }

        /* Hides extra Breeze elements */

        .cafe-container {
            width: 100%;
            max-width: 400px;
            margin: auto;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(61, 35, 20, 0.3);
        }
    </style>

    <div class="fixed inset-0 flex items-center justify-center bg-[#FDF8F1]">

        <div class="cafe-container flex flex-col">
            <div class="bg-[#3D2314] p-6 text-center border-b border-[#D8CAB2]">
                <div class="flex items-center justify-center gap-2">
                    <span class="text-2xl">☕</span>
                    <h2 class="text-2xl font-bold text-[#FDF8F1] tracking-tight">CafeEase</h2>
                </div>
            </div>

            <div class="bg-[#F4EBDC] px-8 py-10">
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus
                            class="w-full px-4 py-4 rounded-xl border-[#D8CAB2] focus:border-[#3D2314] focus:ring-[#3D2314] shadow-sm"
                            placeholder="Username or Email">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <input id="password" type="password" name="password" required
                            class="w-full px-4 py-4 rounded-xl border-[#D8CAB2] focus:border-[#3D2314] focus:ring-[#3D2314] shadow-sm"
                            placeholder="Password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <button type="submit"
                        class="w-full bg-[#3D2314] hover:bg-[#2A180E] text-[#FDF8F1] font-bold py-4 rounded-xl transition-all shadow-lg active:scale-95 uppercase tracking-widest text-sm">
                        Login
                    </button>
                </form>
            </div>

            <div class="bg-[#D8CAB2] py-4 flex justify-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-white opacity-40"></span>
                <span class="w-2 h-2 rounded-full bg-white opacity-40"></span>
                <span class="w-2 h-2 rounded-full bg-white"></span>
                <span class="w-2 h-2 rounded-full bg-white opacity-40"></span>
                <span class="w-2 h-2 rounded-full bg-white opacity-40"></span>
            </div>
        </div>
    </div>
</x-guest-layout>
