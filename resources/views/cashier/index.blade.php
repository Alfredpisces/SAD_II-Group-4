<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CafeEase - Order Entry</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .animate-ready {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .7;
            }
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: #3D2314;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-amber-50 h-screen flex flex-col p-4 md:p-8">

    @if (session('notification'))
        <div
            class="fixed top-24 left-1/2 -translate-x-1/2 z-50 w-full max-w-md bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-2xl rounded-lg flex justify-between items-center animate-bounce">
            <p class="text-sm font-bold">🔔 {{ session('notification') }}</p>
            <button onclick="this.parentElement.remove()" class="font-bold text-xl">&times;</button>
        </div>
    @endif

    @if (session('success'))
        <div
            class="fixed top-24 left-1/2 -translate-x-1/2 z-50 w-full max-w-md bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow-2xl rounded-lg flex justify-between items-center">
            <p class="text-sm font-bold">✅ {{ session('success') }}</p>
            <button onclick="this.parentElement.remove()" class="font-bold text-xl">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div
            class="fixed top-24 left-1/2 -translate-x-1/2 z-50 w-full max-w-md bg-red-100 border-l-4 border-red-500 text-red-700 p-4 shadow-2xl rounded-lg flex justify-between items-center">
            <p class="text-sm font-bold">⚠️ {{ session('error') }}</p>
            <button onclick="this.parentElement.remove()" class="font-bold text-xl">&times;</button>
        </div>
    @endif

    <header class="w-full bg-[#3D2314] text-[#EADECB] p-5 rounded-2xl shadow-xl flex justify-between items-center mb-6">
        <div class="text-2xl font-bold">☕ CafeEase</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="text-sm border border-[#EADECB] px-3 py-1 rounded-full hover:bg-red-900 transition">Logout</button>
        </form>
    </header>

    <main class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6 overflow-hidden">
        <section class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 overflow-y-auto">
            <h2 class="text-2xl font-bold text-[#3D2314] mb-6">Menu</h2>
            <div class="grid grid-cols-2 gap-4">
                @foreach ($products as $product)
                    <button onclick="addToOrder('{{ $product->name }}', {{ $product->price }})"
                        class="p-6 bg-[#EADECB] text-[#3D2314] rounded-2xl hover:bg-[#3D2314] hover:text-[#EADECB] transition-all text-left group">
                        <span class="block font-bold">{{ $product->name }}</span>
                        <span class="block text-lg font-black mt-2">₱{{ number_format($product->price, 0) }}</span>
                    </button>
                @endforeach
            </div>
        </section>

        <aside class="flex flex-col gap-6 overflow-hidden">
            <div class="bg-white p-6 rounded-3xl shadow-lg border-2 border-green-50">
                <h3 class="text-xs font-bold text-green-600 uppercase mb-4">Ready for Pickup</h3>
                <div class="space-y-3 max-h-40 overflow-y-auto">
                    @php $readyOrders = \App\Models\Order::where('status', 'ready')->latest()->get(); @endphp
                    @forelse($readyOrders as $ready)
                        <div
                            class="bg-green-50 border border-green-100 p-4 rounded-xl flex justify-between items-center animate-ready">
                            <div>
                                <p class="text-xs font-bold text-green-900">{{ $ready->item_name }}</p>
                            </div>
                            <form action="{{ route('orders.updateStatus', $ready->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="completed">
                                <button type="submit"
                                    class="bg-green-600 text-white text-[10px] px-3 py-1 rounded-full font-bold">Served</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 italic text-center">No orders ready.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-lg flex-1 flex flex-col overflow-hidden">
                <h2 class="text-2xl font-bold mb-4 text-[#3D2314]">Current Order</h2>
                <div id="order-items-list" class="flex-1 overflow-y-auto border-b mb-4"></div>
                <form action="{{ route('cashier.orders.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="item_name" id="hidden-item-name">
                    <input type="hidden" name="total" id="hidden-total">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-500">Total:</span>
                        <span class="text-3xl font-black">₱<span id="total-display">0</span></span>
                    </div>
                    <button type="submit" id="submit-btn" disabled
                        class="w-full py-4 bg-gray-200 text-gray-400 rounded-full font-bold">Submit Order</button>
                </form>
            </div>
        </aside>
    </main>

    <script>
        let cart = [];

        function addToOrder(name, price) {
            cart.push({
                name,
                price
            });
            renderCart();
        }

        function renderCart() {
            const list = document.getElementById('order-items-list');
            list.innerHTML = cart.map(item =>
                    `<div class="flex justify-between py-2 text-sm"><span>${item.name}</span><b>₱${item.price}</b></div>`)
                .join('');
            const total = cart.reduce((sum, i) => sum + i.price, 0);
            document.getElementById('total-display').innerText = total.toLocaleString();
            document.getElementById('hidden-item-name').value = cart.map(i => i.name).join(', ');
            document.getElementById('hidden-total').value = total;
            const btn = document.getElementById('submit-btn');
            btn.disabled = cart.length === 0;
            btn.className = cart.length ? "w-full py-4 bg-[#3D2314] text-white rounded-full font-bold shadow-lg" :
                "w-full py-4 bg-gray-200 text-gray-400 rounded-full font-bold";
        }
        setInterval(() => {
            if (cart.length === 0) window.location.reload();
        }, 20000);
    </script>
</body>

</html>
