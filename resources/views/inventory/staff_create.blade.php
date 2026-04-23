<body class="bg-[#F9F6F2] p-8">
    <div class="max-w-md mx-auto bg-white p-10 rounded-[30px] shadow-sm border border-gray-100">
        <h2 class="text-2xl font-bold text-[#3D2314] mb-2">Register Staff</h2>
        <p class="text-gray-400 text-sm mb-8">Create a new account for your team.</p>

        <form method="POST" action="{{ route('staff.store') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-bold text-[#3D2314] uppercase mb-2">Full Name</label>
                <input type="text" name="name"
                    class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-[#3D2314]" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#3D2314] uppercase mb-2">Email Address</label>
                <input type="email" name="email"
                    class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-[#3D2314]" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#3D2314] uppercase mb-2">Role</label>
                <select name="role"
                    class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-[#3D2314]" required>
                    <option value="cashier">Cashier</option>
                    <option value="barista">Barista</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#3D2314] uppercase mb-2">Password</label>
                <input type="password" name="password"
                    class="w-full p-4 bg-gray-50 border-none rounded-2xl focus:ring-2 focus:ring-[#3D2314]" required>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full py-4 bg-[#3D2314] text-white rounded-2xl font-bold shadow-lg shadow-brown-200 hover:scale-[1.02] transition-transform">
                    Confirm Registration
                </button>
                <a href="{{ route('staff.index') }}" class="block text-center mt-4 text-sm text-gray-400">Cancel</a>
            </div>
        </form>
    </div>
</body>
