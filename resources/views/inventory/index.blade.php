<x-app-layout>
    <div style="background-color: #fcf9f1; min-height: 100vh; padding: 2rem;">

        @if (session('success'))
            <div style="background-color: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <strong>✓ Success!</strong> {{ session('success') }}
            </div>
        @endif

        <div
            style="background-color: #3d2b1f; border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; color: #fcf9f1;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="font-size: 1.5rem;">📦</span>
                <h1 style="font-size: 1.25rem; font-weight: bold; margin: 0;">CafeEase | Inventory Vault</h1>
            </div>
            <span
                style="background-color: #d4b08c; color: #3d2b1f; padding: 0.25rem 1rem; border-radius: 99px; font-size: 0.75rem; font-weight: 900; text-transform: uppercase;">
                System Online
            </span>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 3fr; gap: 2rem;">

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div
                    style="background: white; padding: 2rem; border-radius: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                    <h3 style="color: #3d2b1f; font-weight: bold; margin-bottom: 1rem;">Stock Summary</h3>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <p style="color: #6b7280; margin: 0;">Total Items</p>
                        <p style="color: #3d2b1f; font-weight: 900; font-size: 1.5rem; margin: 0;">{{ count($ingredients) }}</p>
                    </div>
                    <a href="{{ route('inventory.create') }}"
                        style="width: 100%; margin-top: 1.5rem; background-color: #3d2b1f; color: #d4b08c; padding: 1rem; border-radius: 1rem; border: none; font-weight: bold; cursor: pointer; display: block; text-align: center; text-decoration: none;">
                        + Add New Ingredient
                    </a>
                </div>
            </div>

            <div
                style="background: white; padding: 2.5rem; border-radius: 2.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02); min-height: 500px;">
                <h2 style="font-size: 1.8rem; font-weight: 900; color: #3d2b1f; margin-bottom: 2rem;">Raw Materials</h2>

                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach ($ingredients as $item)
                        <div
                            style="background-color: #fcf9f1; padding: 1.5rem; border-radius: 1.5rem; display: flex; justify-content: space-between; align-items: center; border: 1px solid #f3f4f6;">
                            <div style="display: flex; align-items: center; gap: 1.5rem;">
                                <div
                                    style="width: 50px; height: 50px; background: #3d2b1f; color: #d4b08c; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                    {{ substr($item->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 style="margin: 0; color: #3d2b1f; font-weight: bold;">{{ $item->name }}</h4>
                                    <span
                                        style="font-size: 0.7rem; font-weight: 900; color: #d4b08c; text-transform: uppercase;">{{ $item->category }}</span>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 3rem;">
                                <div style="text-align: right;">
                                    <p style="margin: 0; font-size: 1.2rem; font-weight: 900; color: #3d2b1f;">
                                        {{ number_format($item->stock) }} <small
                                            style="font-weight: normal; color: #9ca3af;">{{ $item->unit }}</small>
                                    </p>
                                </div>
                                <button
                                    style="background: white; border: 1px solid #e5e7eb; padding: 0.75rem; border-radius: 10px; cursor: pointer;">
                                    ✏️
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
