<x-app-layout>
    <div style="background-color: #fcf9f1; min-height: 100vh; padding: 2rem;">

        {{-- Header --}}
        <div
            style="background-color: #3d2b1f; border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; color: #fcf9f1;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="font-size: 1.5rem;">🎁</span>
                <h1 style="font-size: 1.25rem; font-weight: bold; margin: 0;">CafeEase | Promotions</h1>
            </div>
            <span
                style="background-color: #d4b08c; color: #3d2b1f; padding: 0.25rem 1rem; border-radius: 99px; font-size: 0.75rem; font-weight: 900; text-transform: uppercase;">
                {{ $promotions->count() }} Total
            </span>
        </div>

        @if (session('success'))
            <div
                style="margin-bottom: 1.5rem; padding: 1rem 1.5rem; background-color: #d1fae5; color: #065f46; border-radius: 1rem; font-size: 0.85rem; font-weight: 600;">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">

            {{-- Create Promotion Form --}}
            <div>
                <div
                    style="background: white; padding: 2rem; border-radius: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                    <h3 style="color: #3d2b1f; font-weight: 900; margin-bottom: 1.5rem;">+ New Promotion</h3>

                    <form action="{{ route('promotions.store') }}" method="POST">
                        @csrf

                        <div style="margin-bottom: 1rem;">
                            <label
                                style="display: block; font-size: 0.75rem; font-weight: 700; color: #3d2b1f; text-transform: uppercase; margin-bottom: 0.4rem;">
                                Promotion Name
                            </label>
                            <input type="text" name="name" placeholder="e.g. Summer Discount" required
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.75rem; font-size: 0.9rem; outline: none; box-sizing: border-box;"
                                value="{{ old('name') }}">
                            @error('name') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-bottom: 1rem;">
                            <label
                                style="display: block; font-size: 0.75rem; font-weight: 700; color: #3d2b1f; text-transform: uppercase; margin-bottom: 0.4rem;">
                                Description
                            </label>
                            <textarea name="description" rows="2" placeholder="Optional description..."
                                style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.75rem; font-size: 0.9rem; outline: none; resize: vertical; box-sizing: border-box;">{{ old('description') }}</textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                            <div>
                                <label
                                    style="display: block; font-size: 0.75rem; font-weight: 700; color: #3d2b1f; text-transform: uppercase; margin-bottom: 0.4rem;">
                                    Discount Type
                                </label>
                                <select name="discount_type" required
                                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.75rem; font-size: 0.9rem; outline: none; background: white; box-sizing: border-box;">
                                    <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                    <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed (₱)</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    style="display: block; font-size: 0.75rem; font-weight: 700; color: #3d2b1f; text-transform: uppercase; margin-bottom: 0.4rem;">
                                    Value
                                </label>
                                <input type="number" name="discount_value" step="0.01" min="0" placeholder="0.00" required
                                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.75rem; font-size: 0.9rem; outline: none; box-sizing: border-box;"
                                    value="{{ old('discount_value') }}">
                                @error('discount_value') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1rem;">
                            <div>
                                <label
                                    style="display: block; font-size: 0.75rem; font-weight: 700; color: #3d2b1f; text-transform: uppercase; margin-bottom: 0.4rem;">
                                    Start Date
                                </label>
                                <input type="date" name="start_date" required
                                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.75rem; font-size: 0.9rem; outline: none; box-sizing: border-box;"
                                    value="{{ old('start_date') }}">
                                @error('start_date') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label
                                    style="display: block; font-size: 0.75rem; font-weight: 700; color: #3d2b1f; text-transform: uppercase; margin-bottom: 0.4rem;">
                                    End Date
                                </label>
                                <input type="date" name="end_date" required
                                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.75rem; font-size: 0.9rem; outline: none; box-sizing: border-box;"
                                    value="{{ old('end_date') }}">
                                @error('end_date') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div style="margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                style="width: 16px; height: 16px; cursor: pointer;"
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active"
                                style="font-size: 0.85rem; font-weight: 600; color: #3d2b1f; cursor: pointer;">
                                Active (visible to staff)
                            </label>
                        </div>

                        <button type="submit"
                            style="width: 100%; background-color: #3d2b1f; color: #d4b08c; padding: 1rem; border-radius: 1rem; border: none; font-weight: 900; font-size: 0.9rem; cursor: pointer; text-transform: uppercase; letter-spacing: 0.05em;">
                            Create Promotion
                        </button>
                    </form>
                </div>
            </div>

            {{-- Promotions List --}}
            <div
                style="background: white; padding: 2.5rem; border-radius: 2.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02); min-height: 500px;">
                <h2 style="font-size: 1.5rem; font-weight: 900; color: #3d2b1f; margin-bottom: 2rem;">All Promotions</h2>

                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @forelse ($promotions as $promo)
                        <div
                            style="background-color: #fcf9f1; padding: 1.5rem; border-radius: 1.5rem; border: 1px solid {{ $promo->isRunning() ? '#d4b08c' : '#f3f4f6' }}; display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;">

                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                                    <h4 style="margin: 0; color: #3d2b1f; font-weight: 900; font-size: 1rem;">{{ $promo->name }}</h4>
                                    @if ($promo->isRunning())
                                        <span
                                            style="background-color: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 99px; font-size: 0.65rem; font-weight: 900; text-transform: uppercase;">
                                            Active
                                        </span>
                                    @elseif (!$promo->is_active)
                                        <span
                                            style="background-color: #fee2e2; color: #991b1b; padding: 2px 8px; border-radius: 99px; font-size: 0.65rem; font-weight: 900; text-transform: uppercase;">
                                            Disabled
                                        </span>
                                    @else
                                        <span
                                            style="background-color: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 99px; font-size: 0.65rem; font-weight: 900; text-transform: uppercase;">
                                            Scheduled
                                        </span>
                                    @endif
                                </div>

                                @if ($promo->description)
                                    <p style="margin: 0 0 0.5rem 0; color: #6b7280; font-size: 0.85rem;">{{ $promo->description }}</p>
                                @endif

                                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                                    <span style="font-size: 0.8rem; color: #3d2b1f; font-weight: 700;">
                                        💰 {{ $promo->discount_type === 'percentage' ? $promo->discount_value . '%' : '₱' . number_format($promo->discount_value, 2) }} off
                                    </span>
                                    <span style="font-size: 0.8rem; color: #6b7280;">
                                        📅 {{ $promo->start_date->format('M d, Y') }} – {{ $promo->end_date->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-end;">
                                {{-- Toggle Active --}}
                                <form action="{{ route('promotions.toggle', $promo->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        style="background: white; border: 1px solid #e5e7eb; padding: 0.5rem 0.75rem; border-radius: 10px; cursor: pointer; font-size: 0.75rem; font-weight: 700; color: #3d2b1f;">
                                        {{ $promo->is_active ? '⏸ Disable' : '▶ Enable' }}
                                    </button>
                                </form>

                                {{-- Delete --}}
                                <form action="{{ route('promotions.destroy', $promo->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this promotion?');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="background: none; border: none; cursor: pointer; color: #ef4444; font-size: 0.75rem; font-weight: 700; padding: 0.5rem 0.75rem; border-radius: 10px; border: 1px solid #fecaca;">
                                        🗑 Delete
                                    </button>
                                </form>
                            </div>

                        </div>
                    @empty
                        <div style="text-align: center; padding: 5rem; color: #9ca3af;">
                            <p style="font-size: 3rem; margin-bottom: 1rem;">🎁</p>
                            <p>No promotions yet. Create your first one!</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
