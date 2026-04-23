<div style="background: white; padding: 2rem; border-radius: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
    <h3 style="color: #3d2b1f; font-weight: bold; margin-bottom: 1rem;">Personnel Summary</h3>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <p style="color: #6b7280; margin: 0;">Active Staff</p>
        <p style="color: #3d2b1f; font-weight: 900; font-size: 1.5rem; margin: 0;">
            {{ sprintf('%02d', $staffs->count()) }}
        </p>
    </div>
    <a href="{{ route('staff.create') }}"
        style="display: block; text-align: center; text-decoration: none; margin-top: 1.5rem; background-color: #3d2b1f; color: #d4b08c; padding: 1rem; border-radius: 1rem; font-weight: bold;">
        + Register Staff
    </a>
</div>

<div style="display: flex; flex-direction: column; gap: 1rem;">
    @foreach ($staffs as $staff)
        <div
            style="background-color: #fcf9f1; padding: 1.5rem; border-radius: 1.5rem; display: flex; justify-content: space-between; align-items: center; border: 1px solid #f3f4f6;">
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div
                    style="width: 50px; height: 50px; background: #3d2b1f; color: #d4b08c; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                    {{ strtoupper(substr($staff->name, 0, 1)) }}
                </div>
                <div>
                    <h4 style="margin: 0; color: #3d2b1f; font-weight: bold;">{{ $staff->name }}</h4>
                    <p style="font-size: 0.7rem; color: #9ca3af; margin: 0;">{{ $staff->email }}</p>
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 3rem;">
                <span style="font-size: 0.8rem; font-weight: 900; color: #3d2b1f; text-transform: uppercase;">
                    {{ $staff->role }}
                </span>

                @if ($staff->id !== auth()->id())
                    <form action="{{ route('staff.destroy', $staff->id) }}" method="POST"
                        onsubmit="return confirm('Remove this staff member?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            style="background: white; border: 1px solid #e5e7eb; padding: 0.75rem; border-radius: 10px; color: #ef4444; cursor: pointer;">
                            ✕
                        </button>
                    </form>
                @else
                    <div
                        style="background: #3d2b1f; color: #d4b08c; padding: 0.5rem 1rem; border-radius: 10px; font-size: 0.6rem; font-weight: 900;">
                        YOU
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
