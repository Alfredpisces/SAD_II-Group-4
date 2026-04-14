<x-app-layout>
    <div style="background-color: #fcf9f1; min-height: 100vh; padding: 2rem;">

        <div
            style="background-color: #3d2b1f; border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; color: #fcf9f1;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="font-size: 1.5rem;">👥</span>
                <h1 style="font-size: 1.25rem; font-weight: bold; margin: 0;">CafeEase | Staff Management</h1>
            </div>
            <span
                style="background-color: #d4b08c; color: #3d2b1f; padding: 0.25rem 1rem; border-radius: 99px; font-size: 0.75rem; font-weight: 900; text-transform: uppercase;">
                Terminal Active
            </span>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div style="margin-bottom: 1.5rem; padding: 1rem 1.5rem; background-color: #d1fae5; color: #065f46; border-radius: 1rem; font-size: 0.85rem; font-weight: 600; border-left: 4px solid #059669;">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div style="margin-bottom: 1.5rem; padding: 1rem 1.5rem; background-color: #fee2e2; color: #991b1b; border-radius: 1rem; font-size: 0.85rem; font-weight: 600; border-left: 4px solid #dc2626;">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 3fr; gap: 2rem;">

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div
                    style="background: white; padding: 2rem; border-radius: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                    <h3 style="color: #3d2b1f; font-weight: bold; margin-bottom: 1rem;">Personnel Summary</h3>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <p style="color: #6b7280; margin: 0;">Active Staff</p>
                        <p style="color: #3d2b1f; font-weight: 900; font-size: 1.5rem; margin: 0;">
                            {{ sprintf('%02d', count($staffs)) }}</p>
                    </div>

                    {{-- Default Login Info Box --}}
                    <div style="margin-top: 1.5rem; background-color: #fcf9f1; border: 1px dashed #d4b08c; border-radius: 1rem; padding: 1rem;">
                        <p style="margin: 0 0 0.5rem 0; font-size: 0.7rem; font-weight: 900; color: #3d2b1f; text-transform: uppercase; letter-spacing: 0.05em;">Default Credentials</p>
                        <p style="margin: 0; font-size: 0.75rem; color: #6b7280;"><strong>Admin:</strong> admin@cafe.com / admin123</p>
                        <p style="margin: 0.25rem 0 0 0; font-size: 0.75rem; color: #6b7280;"><strong>Barista:</strong> barista@cafe.com / barista123</p>
                        <p style="margin: 0.25rem 0 0 0; font-size: 0.75rem; color: #6b7280;"><strong>Cashier:</strong> cashier@cafe.com / cashier123</p>
                        <p style="margin: 0.5rem 0 0 0; font-size: 0.65rem; color: #9ca3af; font-style: italic;">Change passwords after first login.</p>
                    </div>

                    <button onclick="document.getElementById('addStaffModal').classList.remove('hidden')"
                        style="width: 100%; margin-top: 1.5rem; background-color: #3d2b1f; color: #d4b08c; padding: 1rem; border-radius: 1rem; border: none; font-weight: bold; cursor: pointer;">
                        + Register Staff
                    </button>
                </div>
            </div>

            <div
                style="background: white; padding: 2.5rem; border-radius: 2.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02); min-height: 500px;">
                <h2 style="font-size: 1.8rem; font-weight: 900; color: #3d2b1f; margin-bottom: 2rem;">Team Members</h2>

                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach ($staffs as $staff)
                        <div
                            style="background-color: #fcf9f1; padding: 1.5rem; border-radius: 1.5rem; display: flex; justify-content: space-between; align-items: center; border: 1px solid #f3f4f6;">

                            <div style="display: flex; align-items: center; gap: 1.5rem;">
                                <div
                                    style="width: 50px; height: 50px; background: #3d2b1f; color: #d4b08c; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                    {{ substr($staff->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 style="margin: 0; color: #3d2b1f; font-weight: bold;">{{ $staff->name }}</h4>
                                    <span
                                        style="font-size: 0.7rem; font-weight: 900; color: #d4b08c; text-transform: uppercase;">
                                        {{ $staff->email }}
                                    </span>
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 3rem;">
                                <div style="text-align: right;">
                                    @php
                                        $roleColors = ['admin' => '#ef4444', 'barista' => '#3d82f6', 'cashier' => '#059669'];
                                        $roleColor  = $roleColors[$staff->role] ?? '#6b7280';
                                    @endphp
                                    <span style="font-size: 0.75rem; font-weight: 900; color: white; background: {{ $roleColor }}; padding: 2px 10px; border-radius: 99px; text-transform: uppercase; letter-spacing: 1px;">
                                        {{ $staff->role }}
                                    </span>
                                </div>

                                @if ($staff->id !== auth()->id())
                                    <form action="{{ route('staff.destroy', $staff->id) }}" method="POST"
                                        style="margin: 0;">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            style="background: white; border: 1px solid #e5e7eb; padding: 0.75rem; border-radius: 10px; cursor: pointer; color: #ef4444;"
                                            onclick="return confirm('Remove this staff member?')">
                                            ✕
                                        </button>
                                    </form>
                                @else
                                    <div
                                        style="background: #3d2b1f; color: #d4b08c; padding: 0.5rem 1rem; border-radius: 10px; font-size: 0.6rem; font-weight: 900; text-transform: uppercase;">
                                        You
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Add Staff Modal --}}
    <div id="addStaffModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center"
        style="background-color: rgba(0,0,0,0.5);"
        onclick="if(event.target===this) this.classList.add('hidden')">

        <div style="background: white; border-radius: 2rem; padding: 2.5rem; width: 100%; max-width: 460px; position: relative; box-shadow: 0 25px 50px rgba(0,0,0,0.2);">

            <button onclick="document.getElementById('addStaffModal').classList.add('hidden')"
                style="position: absolute; top: 1.25rem; right: 1.5rem; background: none; border: none; font-size: 1.25rem; cursor: pointer; color: #6b7280;">✕</button>

            <h3 style="color: #3d2b1f; font-weight: 900; font-size: 1.2rem; margin: 0 0 0.25rem 0;">Register New Staff</h3>
            <p style="color: #9ca3af; font-size: 0.8rem; margin: 0 0 1.5rem 0;">Staff can log in immediately with these credentials.</p>

            @if ($errors->any())
                <div style="margin-bottom: 1rem; padding: 0.75rem 1rem; background-color: #fee2e2; color: #991b1b; border-radius: 0.75rem; font-size: 0.8rem;">
                    <ul style="margin: 0; padding-left: 1rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('staff.store') }}" method="POST">
                @csrf

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 700; color: #3d2b1f; text-transform: uppercase; margin-bottom: 0.4rem;">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Juan Dela Cruz"
                        style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.75rem; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 700; color: #3d2b1f; text-transform: uppercase; margin-bottom: 0.4rem;">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="staff@cafe.com"
                        style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.75rem; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.7rem; font-weight: 700; color: #3d2b1f; text-transform: uppercase; margin-bottom: 0.4rem;">Role</label>
                    <select name="role" required
                        style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.75rem; font-size: 0.9rem; outline: none; background: white; box-sizing: border-box;">
                        <option value="cashier" {{ old('role') === 'cashier' ? 'selected' : '' }}>Cashier</option>
                        <option value="barista" {{ old('role') === 'barista' ? 'selected' : '' }}>Barista</option>
                        <option value="admin"   {{ old('role') === 'admin'   ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 700; color: #3d2b1f; text-transform: uppercase; margin-bottom: 0.4rem;">Password</label>
                        <input type="password" name="password" required placeholder="Min. 8 characters"
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.75rem; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.7rem; font-weight: 700; color: #3d2b1f; text-transform: uppercase; margin-bottom: 0.4rem;">Confirm</label>
                        <input type="password" name="password_confirmation" required placeholder="Repeat password"
                            style="width: 100%; padding: 0.75rem 1rem; border: 1px solid #e5e7eb; border-radius: 0.75rem; font-size: 0.9rem; outline: none; box-sizing: border-box;">
                    </div>
                </div>

                <div style="display: flex; gap: 0.75rem;">
                    <button type="button" onclick="document.getElementById('addStaffModal').classList.add('hidden')"
                        style="flex: 1; padding: 1rem; background: #f3f4f6; color: #6b7280; border: none; border-radius: 1rem; font-weight: 700; cursor: pointer;">
                        Cancel
                    </button>
                    <button type="submit"
                        style="flex: 2; padding: 1rem; background-color: #3d2b1f; color: #d4b08c; border: none; border-radius: 1rem; font-weight: 900; cursor: pointer; text-transform: uppercase; letter-spacing: 0.05em;">
                        Register Staff
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Re-open modal if there are validation errors --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('addStaffModal').classList.remove('hidden');
            });
        </script>
    @endif
</x-app-layout>
