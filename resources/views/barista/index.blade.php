<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CafeEase - Barista Station</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .preparing-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-amber-50 h-screen flex flex-col p-4 md:p-8">
    <header class="w-full bg-[#3D2314] text-[#EADECB] p-5 rounded-2xl shadow-xl flex justify-between items-center mb-6">
        <div class="flex items-center gap-3 text-2xl font-bold tracking-tight"><span>☕</span> CafeEase | Barista</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="text-sm border border-[#EADECB] px-4 py-1.5 rounded-full hover:bg-red-900 transition">Logout</button>
        </form>
    </header>

    <main class="flex-1 bg-white p-8 rounded-3xl shadow-lg border border-gray-100 flex flex-col overflow-hidden">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-[#3D2314]">Incoming Orders</h1>
            <span
                class="text-xs font-bold text-amber-600 bg-amber-100 px-3 py-1 rounded-full uppercase tracking-widest">Live
                Queue</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-1 flex-1 overflow-y-auto">
            @forelse ($orders as $order)
                <div
                    class="bg-[#EADECB] p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col hover:border-orange-200 transition h-fit relative">
                    <div class="absolute top-4 right-4">
                        @if ($order->status == 'preparing')
                            <span
                                class="text-[9px] bg-blue-500 text-white px-2 py-0.5 rounded-full font-bold uppercase preparing-pulse">Preparing</span>
                        @else
                            <span
                                class="text-[9px] bg-amber-600 text-white px-2 py-0.5 rounded-full font-bold uppercase">New</span>
                        @endif
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <span class="font-bold text-xl text-[#3D2314]">#{{ $order->id }}</span>
                        <span
                            class="text-[10px] font-bold text-gray-500 uppercase mr-12">{{ $order->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-[#3D2314] font-semibold text-lg mb-1">{{ $order->item_name }}</p>
                    <p class="text-gray-600 text-xs mb-6 italic">Quantity: {{ $order->quantity }}</p>

                    <div class="flex gap-2 justify-end mt-auto">
                        @if ($order->status != 'preparing')
                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="preparing">
                                <button type="submit"
                                    class="px-4 py-2 bg-[#E0D1B9] text-[#3D2314] text-xs font-semibold rounded-full hover:bg-stone-300 transition">Start
                                    Making</button>
                            </form>
                        @endif
                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="ready">
                            <button type="submit"
                                class="px-4 py-2 bg-[#3D2314] text-[#EADECB] text-xs font-semibold rounded-full hover:bg-green-900 shadow-md transition">Mark
                                as Ready</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-20 text-gray-400">
                    <div class="text-6xl mb-4 text-amber-200">☕</div>
                    <p class="text-xl font-medium italic">The queue is empty. Relax!</p>
                </div>
            @endforelse
        </div>
    </main>

    <script>
        setTimeout(() => {
            window.location.reload();
        }, 15000);
    </script>
</body>

</html>
