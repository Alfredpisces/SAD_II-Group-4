<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CafeEase - Admin Inventory</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Smooth scrollbar for the table container */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #3D2314;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-amber-50 h-screen flex flex-col p-4 md:p-8">

    <header class="w-full bg-[#3D2314] text-[#EADECB] p-5 rounded-2xl shadow-xl flex justify-between items-center mb-6">
        <div class="flex items-center gap-3 text-2xl font-bold tracking-tight">
            <span>☕</span> CafeEase Admin
        </div>
        <div class="flex items-center gap-6 text-[#EADECB]">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="text-sm border border-[#EADECB] px-4 py-1.5 rounded-full hover:bg-red-900 transition font-semibold">Logout</button>
            </form>
        </div>
    </header>

    <main
        class="flex-1 bg-white p-6 md:p-10 rounded-3xl shadow-lg border border-gray-100 flex flex-col overflow-hidden">

        @if (session('success'))
            <div
                class="mb-4 p-3 bg-green-100 border border-green-200 text-green-700 rounded-xl text-sm font-bold animate-pulse">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-3xl font-bold text-[#3D2314]">Ingredient Inventory</h1>
                <p class="text-gray-500 text-sm italic">Tracking raw materials for precision brewing.</p>
            </div>


            <div class="bg-amber-50 px-5 py-3 rounded-2xl border border-amber-100 shadow-sm">
                <p class="text-[10px] uppercase font-black text-amber-800 tracking-widest">Total Supplies</p>
                <p class="text-2xl font-black text-[#3D2314]">{{ $ingredients->count() }}</p>
            </div>
        </div>
        </div>

        <div class="bg-gray-50 rounded-2xl border border-gray-100 flex-1 overflow-y-auto custom-scrollbar mb-6">
            <table class="w-full text-left text-sm">
                <thead class="sticky top-0 bg-[#3D2314] text-[#EADECB] z-10">
                    <tr class="font-semibold uppercase text-[11px] tracking-wider">
                        <th class="p-5">Ingredient Name</th>
                        <th class="p-5">Category</th>
                        <th class="p-5 text-center">Remaining Stock</th>
                        <th class="p-5 text-center">Status</th>
                        <th class="p-5 text-right">Quick Update</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($ingredients as $ingredient)
                        <tr class="hover:bg-amber-50/40 transition-colors">
                            <td class="p-5 font-bold text-[#3D2314]">{{ $ingredient->name }}</td>
                            <td class="p-5">
                                <span
                                    class="bg-gray-100 px-2 py-1 rounded text-[9px] font-bold text-gray-500 uppercase tracking-tighter">
                                    {{ $ingredient->category ?? 'Supply' }}
                                </span>
                            </td>

                            <td class="p-5 text-center font-mono font-bold text-lg">
                                {{ number_format($ingredient->stock) }}
                                <span
                                    class="text-[10px] text-gray-400 font-normal lowercase">{{ $ingredient->unit }}</span>
                            </td>

                            <td class="p-5 text-center">
                                @if ($ingredient->stock <= ($ingredient->min_stock ?? 20))
                                    <span
                                        class="px-4 py-1.5 rounded-full text-[10px] font-black bg-red-600 text-white shadow-sm">
                                        RESTOCK NOW
                                    </span>
                                @else
                                    <span
                                        class="px-4 py-1.5 rounded-full text-[10px] font-black bg-green-100 text-green-600 border border-green-200">
                                        STABLE
                                    </span>
                                @endif
                            </td>

                            <td class="p-5 text-right">
                                <form action="{{ route('inventory.update', $ingredient->id) }}" method="POST"
                                    class="flex justify-end items-center gap-3">
                                    @csrf
                                    <input type="number" name="stock" value="{{ $ingredient->stock }}"
                                        class="w-24 p-2 border-2 border-gray-200 rounded-xl text-center text-sm font-bold focus:border-[#3D2314] focus:ring-0 transition-all outline-none">
                                    <button type="submit"
                                        class="bg-[#3D2314] text-white px-4 py-2 rounded-xl hover:bg-black transition-all shadow-md active:scale-95 font-bold text-xs uppercase">
                                        Save
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-20 text-center">
                                <div class="flex flex-col items-center opacity-30">
                                    <span class="text-5xl mb-2">📦</span>
                                    <p class="italic font-bold">Your inventory is empty. Start adding ingredients!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex gap-4 mt-auto">
            <button
                class="flex-1 py-4 bg-[#3D2314] text-[#EADECB] text-sm font-bold rounded-2xl hover:bg-[#52301c] shadow-xl transition-all uppercase tracking-widest active:scale-[0.98]">
                ➕ Add New Ingredient
            </button>
        </div>
    </main>

    <footer class="mt-6 text-center text-[10px] font-bold text-[#3D2314]/40 uppercase tracking-[0.2em] pb-2">
        CafeEase Systems • Secure Admin Terminal
    </footer>

</body>

</html>
