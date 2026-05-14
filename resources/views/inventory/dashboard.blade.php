<x-app-layout>
    <div style="background-color: #fcf9f1; min-height: 100vh; padding: 2rem;">

        {{-- Header --}}
        <div
            style="background-color: #3d2b1f; border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; color: #fcf9f1;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="font-size: 1.5rem;">🏠</span>
                <h1 style="font-size: 1.25rem; font-weight: bold; margin: 0;">CafeEase | Admin Dashboard</h1>
            </div>
            <span
                style="background-color: #d4b08c; color: #3d2b1f; padding: 0.25rem 1rem; border-radius: 99px; font-size: 0.75rem; font-weight: 900; text-transform: uppercase;">
                Overview
            </span>
        </div>

        {{-- KPI Cards --}}
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-bottom: 2rem;">

            <div style="background: white; padding: 1.5rem; border-radius: 1.5rem; border-left: 8px solid #d4b08c; box-shadow: 0 2px 4px rgba(0,0,0,0.04);">
                <p style="color: #6b7280; font-size: 0.7rem; margin: 0; text-transform: uppercase; font-weight: bold;">Total Revenue</p>
                <h2 style="color: #3d2b1f; font-size: 1.8rem; font-weight: 900; margin: 0.5rem 0;">
                    ₱{{ number_format($totalRevenue, 2) }}
                </h2>
                <span style="font-size: 0.75rem; color: #9ca3af;">Completed orders</span>
            </div>

            <div style="background: white; padding: 1.5rem; border-radius: 1.5rem; border-left: 8px solid #3d2b1f; box-shadow: 0 2px 4px rgba(0,0,0,0.04);">
                <p style="color: #6b7280; font-size: 0.7rem; margin: 0; text-transform: uppercase; font-weight: bold;">Orders Today</p>
                <h2 style="color: #3d2b1f; font-size: 1.8rem; font-weight: 900; margin: 0.5rem 0;">{{ $ordersToday }}</h2>
                <span style="font-size: 0.75rem; color: #9ca3af;">Total all-time: {{ $totalOrders }}</span>
            </div>

            <div style="background: white; padding: 1.5rem; border-radius: 1.5rem; border-left: 8px solid #ef4444; box-shadow: 0 2px 4px rgba(0,0,0,0.04);">
                <p style="color: #6b7280; font-size: 0.7rem; margin: 0; text-transform: uppercase; font-weight: bold;">Low Stock Items</p>
                <h2 style="color: {{ $lowStockCount > 0 ? '#ef4444' : '#3d2b1f' }}; font-size: 1.8rem; font-weight: 900; margin: 0.5rem 0;">
                    {{ $lowStockCount }}
                </h2>
                <span style="font-size: 0.75rem; color: #9ca3af;">Raw materials below threshold</span>
            </div>

            <div style="background: white; padding: 1.5rem; border-radius: 1.5rem; border-left: 8px solid #634832; box-shadow: 0 2px 4px rgba(0,0,0,0.04);">
                <p style="color: #6b7280; font-size: 0.7rem; margin: 0; text-transform: uppercase; font-weight: bold;">Active Promotions</p>
                <h2 style="color: #3d2b1f; font-size: 1.8rem; font-weight: 900; margin: 0.5rem 0;">{{ $activePromotions }}</h2>
                <span style="font-size: 0.75rem; color: #9ca3af;">Running right now</span>
            </div>

        </div>

        {{-- Middle Row --}}
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">

            {{-- Best Sellers --}}
            <div style="background: white; padding: 2rem; border-radius: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                <h3 style="color: #3d2b1f; font-weight: 900; font-size: 1.1rem; margin-bottom: 1.5rem;">🏆 Top Selling Items</h3>
                @forelse ($topItems as $item)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                        <span style="color: #3d2b1f; font-weight: 600;">{{ $item->item_name }}</span>
                        <span style="background-color: #fcf9f1; color: #3d2b1f; padding: 2px 10px; border-radius: 99px; font-size: 0.75rem; font-weight: 700;">
                            {{ $item->total_sales }} orders
                        </span>
                    </div>
                @empty
                    <p style="color: #9ca3af; text-align: center; padding: 2rem 0;">No sales recorded yet.</p>
                @endforelse
            </div>

            {{-- Recent Feedback --}}
            <div style="background: white; padding: 2rem; border-radius: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                <h3 style="color: #3d2b1f; font-weight: 900; font-size: 1.1rem; margin-bottom: 1.5rem;">💬 Recent Customer Feedback</h3>
                @forelse ($recentFeedbacks as $fb)
                    <div style="padding: 0.75rem 0; border-bottom: 1px solid #f3f4f6;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                            <span style="background: #3d2b1f; color: #d4b08c; border-radius: 8px; padding: 2px 8px; font-size: 0.75rem; font-weight: 900;">
                                {{ $fb->rating }}★
                            </span>
                            <span style="font-size: 0.7rem; color: #9ca3af;">{{ $fb->created_at->diffForHumans() }}</span>
                        </div>
                        <p style="margin: 0; color: #3d2b1f; font-size: 0.85rem; font-style: italic;">"{{ \Illuminate\Support\Str::limit($fb->comments, 80) }}"</p>
                    </div>
                @empty
                    <p style="color: #9ca3af; text-align: center; padding: 2rem 0;">No feedback received yet.</p>
                @endforelse
                <a href="{{ route('feedback.index') }}"
                    style="display: block; margin-top: 1rem; text-align: center; font-size: 0.8rem; color: #d4b08c; font-weight: 700; text-decoration: none;">
                    View All Feedback →
                </a>
            </div>

        </div>

        {{-- Quick Links --}}
        <div style="background: white; padding: 2rem; border-radius: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
            <h3 style="color: #3d2b1f; font-weight: 900; font-size: 1.1rem; margin-bottom: 1.5rem;">⚡ Quick Actions</h3>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('inventory.index') }}"
                    style="display: flex; align-items: center; gap: 0.5rem; background-color: #3d2b1f; color: #d4b08c; padding: 0.75rem 1.5rem; border-radius: 1rem; text-decoration: none; font-weight: 700; font-size: 0.85rem;">
                    📦 Manage Inventory
                </a>
                <a href="{{ route('staff.index') }}"
                    style="display: flex; align-items: center; gap: 0.5rem; background-color: #3d2b1f; color: #d4b08c; padding: 0.75rem 1.5rem; border-radius: 1rem; text-decoration: none; font-weight: 700; font-size: 0.85rem;">
                    👥 Manage Staff
                </a>
                <a href="{{ route('promotions.index') }}"
                    style="display: flex; align-items: center; gap: 0.5rem; background-color: #3d2b1f; color: #d4b08c; padding: 0.75rem 1.5rem; border-radius: 1rem; text-decoration: none; font-weight: 700; font-size: 0.85rem;">
                    🎁 Manage Promotions
                </a>
                <a href="{{ route('reports.index') }}"
                    style="display: flex; align-items: center; gap: 0.5rem; background-color: #3d2b1f; color: #d4b08c; padding: 0.75rem 1.5rem; border-radius: 1rem; text-decoration: none; font-weight: 700; font-size: 0.85rem;">
                    📊 View Reports
                </a>
            </div>
        </div>

    </div>
</x-app-layout>
