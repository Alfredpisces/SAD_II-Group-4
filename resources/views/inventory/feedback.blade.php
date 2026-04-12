<x-app-layout>
    <div style="background-color: #fcf9f1; min-height: 100vh; padding: 2rem;">

        <div
            style="background-color: #3d2b1f; border-radius: 1rem; padding: 1.5rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; color: #fcf9f1;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <span style="font-size: 1.5rem;">📜</span>
                <h1 style="font-size: 1.25rem; font-weight: bold; margin: 0;">CafeEase | Customer Reviews</h1>
            </div>
            <span
                style="background-color: #d4b08c; color: #3d2b1f; padding: 0.25rem 1rem; border-radius: 99px; font-size: 0.75rem; font-weight: 900; text-transform: uppercase;">
                {{ count($feedbacks) }} Total Responses
            </span>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 3fr; gap: 2rem;">

            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div
                    style="background: white; padding: 2rem; border-radius: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                    <h3 style="color: #3d2b1f; font-weight: bold; margin-bottom: 1rem;">Customer Sentiment</h3>

                    <div
                        style="background-color: #fcf9f1; border-radius: 1.5rem; padding: 1rem; border: 1px solid #d4b08c20;">
                        <p style="color: #6b7280; font-size: 0.8rem; margin: 0;">Average Satisfaction</p>

                        <p style="color: #3d2b1f; font-weight: 900; font-size: 2rem; margin: 0.5rem 0;">
                            {{ $sentiment }}
                        </p>

                        <div style="color: #d4b08c; font-size: 1.2rem;">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= round($average))
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                            <span style="font-size: 0.8rem; color: #6b7280; margin-left: 5px;">
                                ({{ number_format($average, 1) }})
                            </span>
                        </div>
                    </div>

                    @if (session('success'))
                        <div
                            style="margin-top: 1rem; padding: 1rem; background-color: #d1fae5; color: #065f46; border-radius: 1rem; font-size: 0.8rem; text-align: center;">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>

            <div
                style="background: white; padding: 2.5rem; border-radius: 2.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02); min-height: 500px;">
                <h2 style="font-size: 1.8rem; font-weight: 900; color: #3d2b1f; margin-bottom: 2rem;">Recent Feedback
                </h2>

                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @forelse ($feedbacks as $fb)
                        <div
                            style="background-color: #fcf9f1; padding: 1.5rem; border-radius: 1.5rem; border: 1px solid #f3f4f6;">

                            <div
                                style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">

                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div
                                        style="width: 40px; height: 40px; background: #3d2b1f; color: #d4b08c; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                        {{ $fb->rating }}★
                                    </div>
                                    <span
                                        style="font-size: 0.7rem; font-weight: 900; color: #d4b08c; text-transform: uppercase;">
                                        {{ $fb->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <form action="{{ route('feedback.destroy', $fb->id) }}" method="POST"
                                    onsubmit="return confirm('Remove this review from records?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="background: none; border: none; cursor: pointer; color: #ef4444; opacity: 0.6; transition: opacity 0.2s;"
                                        onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.6'">
                                        🗑️
                                    </button>
                                </form>

                            </div>

                            <p style="margin: 0; color: #3d2b1f; line-height: 1.6; font-style: italic;">
                                "{{ $fb->comments }}"
                            </p>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 5rem; color: #9ca3af;">
                            <p>No feedback received yet. Time to print those QR codes!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
