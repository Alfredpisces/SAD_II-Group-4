<x-app-layout>
    <div style="background-color: #fcf9f1; min-height: 100vh; padding: 2rem;">

        <div
            style="background-color: #3d2b1f; border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; color: #fcf9f1;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="font-size: 1.5rem;">➕</span>
                <h1 style="font-size: 1.25rem; font-weight: bold; margin: 0;">Add Stock to Ingredients</h1>
            </div>
            <a href="{{ route('inventory.index') }}"
                style="background-color: #d4b08c; color: #3d2b1f; padding: 0.5rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: bold; cursor: pointer;">
                ← Back to Inventory
            </a>
        </div>

        <div style="display: flex; justify-content: center;">
            <div
                style="background: white; padding: 2.5rem; border-radius: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02); width: 100%; max-width: 600px;">

                @if ($errors->any())
                    <div style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                        <strong>Oops! There were some errors:</strong>
                        <ul style="margin: 0.5rem 0 0 1.5rem; padding-left: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('inventory.store') }}" method="POST" id="stockForm">
                    @csrf

                    <!-- Tabs for switching between Add to Existing vs Create New -->
                    <div style="display: flex; gap: 0.5rem; margin-bottom: 2rem; border-bottom: 2px solid #f3f4f6;">
                        <button type="button" onclick="switchTab('existing')" id="existingTab"
                            style="flex: 1; padding: 1rem; background: none; border: none; cursor: pointer; font-weight: 600; color: #3d2b1f; border-bottom: 3px solid #3d2b1f;">
                            📦 Add to Existing
                        </button>
                        <button type="button" onclick="switchTab('new')" id="newTab"
                            style="flex: 1; padding: 1rem; background: none; border: none; cursor: pointer; font-weight: 600; color: #9ca3af; border-bottom: 3px solid transparent;">
                            ✨ Create New
                        </button>
                    </div>

                    <!-- ===== TAB 1: Add to Existing Ingredient ===== -->
                    <div id="existingSection">
                        @if($existingIngredients->count() > 0)
                            <div style="margin-bottom: 1.5rem;">
                                <label for="ingredient_id" style="display: block; margin-bottom: 0.5rem; color: #3d2b1f; font-weight: 600;">
                                    Select Ingredient <span style="color: #dc2626;">*</span>
                                </label>
                                <select name="ingredient_id" id="ingredient_id"
                                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; font-family: inherit;">
                                    <option value="">-- Select an Ingredient --</option>
                                    @foreach($existingIngredients as $ingredient)
                                        <option value="{{ $ingredient->id }}" {{ old('ingredient_id') == $ingredient->id ? 'selected' : '' }}>
                                            {{ $ingredient->name }} (Currently: {{ $ingredient->stock }} {{ $ingredient->unit }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('ingredient_id')
                                    <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div style="margin-bottom: 2rem;">
                                <label for="stock" style="display: block; margin-bottom: 0.5rem; color: #3d2b1f; font-weight: 600;">
                                    Stock Quantity to Add <span style="color: #dc2626;">*</span>
                                </label>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', '') }}" min="1"
                                    style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; font-family: inherit;"
                                    placeholder="e.g., 500">
                                <small style="color: #6b7280; margin-top: 0.25rem; display: block;">This will be added to the existing stock</small>
                                @error('stock')
                                    <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                        @else
                            <div style="background-color: #fef3c7; border: 1px solid #fcd34d; color: #92400e; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                                <p style="margin: 0;"><strong>ℹ️ No ingredients yet</strong> — Create a new ingredient first!</p>
                            </div>
                        @endif
                    </div>

                    <!-- ===== TAB 2: Create New Ingredient ===== -->
                    <div id="newSection" style="display: none;">
                        <div style="margin-bottom: 1.5rem;">
                            <label for="new_ingredient_name" style="display: block; margin-bottom: 0.5rem; color: #3d2b1f; font-weight: 600;">
                                Ingredient Name <span style="color: #dc2626;">*</span>
                            </label>
                            <input type="text" name="new_ingredient_name" id="new_ingredient_name" value="{{ old('new_ingredient_name', '') }}"
                                style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; font-family: inherit;"
                                placeholder="e.g., Coffee Beans, Fresh Milk">
                            @error('new_ingredient_name')
                                <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label for="new_stock" style="display: block; margin-bottom: 0.5rem; color: #3d2b1f; font-weight: 600;">
                                Initial Stock Quantity <span style="color: #dc2626;">*</span>
                            </label>
                            <input type="number" name="stock" id="new_stock" value="{{ old('stock', '') }}" min="1"
                                style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; font-family: inherit;"
                                placeholder="e.g., 500">
                            @error('stock')
                                <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label for="unit" style="display: block; margin-bottom: 0.5rem; color: #3d2b1f; font-weight: 600;">
                                Unit of Measurement <span style="color: #dc2626;">*</span>
                            </label>
                            <select name="unit" id="unit"
                                style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; font-family: inherit;">
                                <option value="">-- Select Unit --</option>
                                <option value="grams" {{ old('unit') === 'grams' ? 'selected' : '' }}>Grams (g)</option>
                                <option value="ml" {{ old('unit') === 'ml' ? 'selected' : '' }}>Milliliters (ml)</option>
                                <option value="liters" {{ old('unit') === 'liters' ? 'selected' : '' }}>Liters (L)</option>
                                <option value="kg" {{ old('unit') === 'kg' ? 'selected' : '' }}>Kilograms (kg)</option>
                                <option value="pcs" {{ old('unit') === 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                                <option value="cup" {{ old('unit') === 'cup' ? 'selected' : '' }}>Cups</option>
                                <option value="box" {{ old('unit') === 'box' ? 'selected' : '' }}>Box</option>
                            </select>
                            @error('unit')
                                <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div style="margin-bottom: 2rem;">
                            <label for="min_stock" style="display: block; margin-bottom: 0.5rem; color: #3d2b1f; font-weight: 600;">
                                Minimum Stock Alert Level <span style="color: #dc2626;">*</span>
                            </label>
                            <input type="number" name="min_stock" id="min_stock" value="{{ old('min_stock', 100) }}" min="0"
                                style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 1rem; font-family: inherit;"
                                placeholder="e.g., 100">
                            <small style="color: #6b7280; margin-top: 0.25rem; display: block;">You'll get alerts when stock falls below this level</small>
                            @error('min_stock')
                                <span style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                        <a href="{{ route('inventory.index') }}"
                            style="background-color: #f3f4f6; color: #3d2b1f; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600; border: none; cursor: pointer;">
                            Cancel
                        </a>
                        <button type="submit"
                            style="background-color: #3d2b1f; color: #d4b08c; padding: 0.75rem 2rem; border-radius: 0.5rem; font-weight: 600; border: none; cursor: pointer; transition: background-color 0.3s;">
                            ✓ Add Stock
                        </button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <script>
        function switchTab(tab) {
            const existingSection = document.getElementById('existingSection');
            const newSection = document.getElementById('newSection');
            const existingTab = document.getElementById('existingTab');
            const newTab = document.getElementById('newTab');

            if (tab === 'existing') {
                existingSection.style.display = 'block';
                newSection.style.display = 'none';
                existingTab.style.color = '#3d2b1f';
                existingTab.style.borderBottom = '3px solid #3d2b1f';
                newTab.style.color = '#9ca3af';
                newTab.style.borderBottom = '3px solid transparent';

                // Enable existing fields, disable new fields
                document.getElementById('ingredient_id').disabled = false;
                document.getElementById('stock').disabled = false;
                document.getElementById('new_ingredient_name').disabled = true;
                document.getElementById('new_stock').disabled = true;
                document.getElementById('unit').disabled = true;
                document.getElementById('min_stock').disabled = true;
            } else {
                existingSection.style.display = 'none';
                newSection.style.display = 'block';
                existingTab.style.color = '#9ca3af';
                existingTab.style.borderBottom = '3px solid transparent';
                newTab.style.color = '#3d2b1f';
                newTab.style.borderBottom = '3px solid #3d2b1f';

                // Disable existing fields, enable new fields
                document.getElementById('ingredient_id').disabled = true;
                document.getElementById('stock').disabled = true;
                document.getElementById('new_ingredient_name').disabled = false;
                document.getElementById('new_stock').disabled = false;
                document.getElementById('unit').disabled = false;
                document.getElementById('min_stock').disabled = false;
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            switchTab('existing');
        });
    </script>
</x-app-layout>
