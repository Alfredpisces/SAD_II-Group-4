<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CafeEase | We Value Your Feedback</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#fcf9f1] min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-xl p-8 border border-[#d4b08c20]">
        <div class="text-center mb-8">
            <span class="text-4xl">☕</span>
            <h1 class="text-2xl font-black text-[#3d2b1f] mt-2">CafeEase</h1>
            <p class="text-[#d4b08c] font-bold uppercase text-xs tracking-widest">Share your experience</p>
        </div>

        <form action="{{ url('/submit-feedback') }}" method="POST" class="space-y-6">
            @csrf

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-2xl text-sm text-center font-bold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-row-reverse justify-center gap-2 mb-4">
                @foreach (range(5, 1) as $i)
                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                        class="hidden peer" {{ $i == 5 ? 'checked' : '' }}>
                    <label for="star{{ $i }}"
                        class="text-4xl cursor-pointer text-gray-300 peer-hover:text-[#d4b08c] peer-checked:text-[#d4b08c] transition-colors">
                        ★
                    </label>
                @endforeach
            </div>
            <p class="text-center text-xs text-[#d4b08c] font-bold mb-6">TAP TO RATE</p>

            <div>
                <label class="block text-[#3d2b1f] font-bold mb-2">Tell us more...</label>
                <textarea name="comments" rows="4" required placeholder="Was your barista friendly? How was the atmosphere?"
                    class="w-full bg-[#fcf9f1] border-none rounded-2xl p-4 text-[#3d2b1f] focus:ring-2 focus:ring-[#d4b08c] placeholder-[#d4b08c80]"></textarea>
            </div>

            <button type="submit"
                class="w-full bg-[#3d2b1f] text-[#d4b08c] font-black py-4 rounded-2xl hover:bg-[#2a1d15] transition-all shadow-lg active:scale-95">
                SUBMIT FEEDBACK
            </button>
        </form>

        <p class="text-center text-[#9ca3af] text-[10px] mt-8 uppercase tracking-widest">
            Thank you for being part of the CafeEase community
        </p>
    </div>

</body>

</html>
