<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CafeEase - Staff Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-amber-50 min-h-screen p-4 md:p-8">
    <div class="max-w-6xl mx-auto">
        <header class="flex justify-between items-center mb-8 bg-[#3D2314] p-6 rounded-2xl shadow-lg">
            <div>
                <h1 class="text-2xl font-bold text-[#EADECB]">CafeEase | Staff Management</h1>
                <p class="text-[#EADECB] text-xs opacity-70">Manage barista and cashier access</p>
            </div>
            <a href="{{ route('inventory.index') }}"
                class="text-sm text-[#EADECB] border border-[#EADECB] px-6 py-2 rounded-full hover:bg-[#EADECB] hover:text-[#3D2314] transition font-bold">
                Back to Inventory
            </a>
        </header>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-xl shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <section class="lg:col-span-1">
                <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-[#3D2314] mb-6 flex items-center">
                        <span class="bg-[#3D2314] text-white p-2 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </span>
                        Register Staff
                    </h2>

                    <form action="{{ route('staff.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Full Name</label>
                            <input type="text" name="name"
                                class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-[#3D2314] outline-none"
                                placeholder="Enter staff name" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Email
                                Address</label>
                            <input type="email" name="email"
                                class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-[#3D2314] outline-none"
                                placeholder="staff@email.com" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Assign Role</label>
                            <select name="role"
                                class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-[#3D2314] outline-none appearance-none"
                                required>
                                <option value="cashier">Cashier</option>
                                <option value="barista">Barista</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Password</label>
                            <input type="password" name="password"
                                class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-[#3D2314] outline-none"
                                placeholder="••••••••" required>
                        </div>

                        <button type="submit"
                            class="w-full py-4 bg-[#3D2314] text-white rounded-2xl font-bold shadow-lg hover:bg-black transition-all active:scale-95">
                            + Add to Team
                        </button>
                    </form>
                </div>
            </section>

            <section class="lg:col-span-2">
                <div class="bg-white p-8 rounded-[32px] shadow-sm border border-gray-100 h-full">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-xl font-bold text-[#3D2314]">Team Members</h2>
                        <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full">
                            {{ count($staffs) }} ACTIVE
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-gray-400 text-[10px] uppercase tracking-widest border-b">
                                    <th class="pb-4 font-black">Personnel</th>
                                    <th class="pb-4 font-black">Role</th>
                                    <th class="pb-4 text-right font-black">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($staffs as $staff)
                                    <tr class="group hover:bg-gray-50 transition-colors">
                                        <td class="py-5">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center text-[#3D2314] font-bold mr-3 uppercase">
                                                    {{ substr($staff->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="font-bold text-[#3D2314]">{{ $staff->name }}</p>
                                                    <p class="text-xs text-gray-400">{{ $staff->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-5">
                                            <span
                                                class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $staff->role == 'barista' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                                {{ $staff->role }}
                                            </span>
                                        </td>
                                        <td class="py-5 text-right">
                                            <form action="{{ route('staff.destroy', $staff->id) }}" method="POST"
                                                onsubmit="return confirm('Remove staff member?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-gray-300 hover:text-red-500 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-20 text-center">
                                            <p class="text-gray-400 italic">No staff members registered yet.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>

</html>
