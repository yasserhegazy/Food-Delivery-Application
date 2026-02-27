@props(['order'])

@php
    $allStatuses = ['pending', 'confirmed', 'preparing', 'ready_for_pickup', 'on_way', 'delivered'];
    $statusLabels = [
        'pending' => 'Order Placed',
        'confirmed' => 'Confirmed',
        'preparing' => 'Preparing',
        'ready_for_pickup' => 'Ready for Pickup',
        'on_way' => 'On the Way',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled',
    ];

    $isCancelled = $order->status === 'cancelled';
    $currentIndex = array_search($order->status, $allStatuses);
    if ($currentIndex === false) {
        $currentIndex = -1;
    }

    // Build a lookup of history entries keyed by status
    $historyByStatus = $order->statusHistory->keyBy('status');
@endphp

<div class="space-y-0">
    @foreach($allStatuses as $index => $status)
        @php
            $isCompleted = $index < $currentIndex || $order->status === 'delivered';
            $isCurrent = $index === $currentIndex && !$isCancelled && $order->status !== 'delivered';
            $isFuture = $index > $currentIndex || $isCancelled;
            if ($order->status === 'delivered' && $index === count($allStatuses) - 1) {
                $isCompleted = true;
                $isCurrent = false;
                $isFuture = false;
            }
            $historyEntry = $historyByStatus->get($status);
            $isLast = $index === count($allStatuses) - 1;
        @endphp

        <div class="relative flex gap-4 {{ !$isLast ? 'pb-8' : '' }}">
            {{-- Connecting line --}}
            @if(!$isLast)
                <div class="absolute left-[15px] top-[30px] bottom-0 w-0.5
                    {{ $isCompleted ? 'bg-green-400' : ($isCurrent ? 'bg-orange-300' : 'bg-gray-200') }}">
                </div>
            @endif

            {{-- Circle indicator --}}
            <div class="relative z-10 flex-shrink-0 flex items-center justify-center w-[31px] h-[31px]">
                @if($isCompleted)
                    <div class="w-7 h-7 rounded-full bg-green-500 flex items-center justify-center shadow-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                @elseif($isCurrent)
                    <div class="relative flex items-center justify-center">
                        <div class="absolute w-7 h-7 rounded-full bg-orange-400 opacity-30 animate-ping"></div>
                        <div class="w-7 h-7 rounded-full bg-orange-500 border-4 border-orange-200 shadow-md"></div>
                    </div>
                @else
                    <div class="w-7 h-7 rounded-full border-2 border-gray-300 bg-white"></div>
                @endif
            </div>

            {{-- Content --}}
            <div class="flex-1 min-w-0 pt-0.5">
                <p class="text-sm font-semibold
                    {{ $isCompleted ? 'text-green-700' : ($isCurrent ? 'text-orange-700' : 'text-gray-400') }}">
                    {{ $statusLabels[$status] }}
                </p>

                @if($historyEntry)
                    <p class="text-xs text-gray-500 mt-0.5">
                        {{ $historyEntry->created_at->format('M d, Y \a\t h:i A') }}
                    </p>
                    @if($historyEntry->changedBy)
                        <p class="text-xs text-gray-400 mt-0.5">
                            by {{ $historyEntry->changedBy->name }}
                        </p>
                    @endif
                    @if($historyEntry->notes)
                        <p class="text-xs text-gray-500 mt-1 italic bg-gray-50 rounded px-2 py-1">
                            {{ $historyEntry->notes }}
                        </p>
                    @endif
                @elseif($isCompleted || $isCurrent)
                    {{-- Fallback for orders without history records --}}
                    @if($status === 'pending')
                        <p class="text-xs text-gray-500 mt-0.5">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                    @endif
                @endif
            </div>
        </div>
    @endforeach

    {{-- Cancelled status --}}
    @if($isCancelled)
        <div class="relative flex gap-4 pt-4 mt-4 border-t border-gray-200">
            <div class="relative z-10 flex-shrink-0 flex items-center justify-center w-[31px] h-[31px]">
                <div class="w-7 h-7 rounded-full bg-red-500 flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
            </div>
            <div class="flex-1 min-w-0 pt-0.5">
                <p class="text-sm font-semibold text-red-600">Order Cancelled</p>
                @if($historyByStatus->get('cancelled'))
                    <p class="text-xs text-gray-500 mt-0.5">
                        {{ $historyByStatus->get('cancelled')->created_at->format('M d, Y \a\t h:i A') }}
                    </p>
                    @if($historyByStatus->get('cancelled')->changedBy)
                        <p class="text-xs text-gray-400 mt-0.5">
                            by {{ $historyByStatus->get('cancelled')->changedBy->name }}
                        </p>
                    @endif
                    @if($historyByStatus->get('cancelled')->notes)
                        <p class="text-xs text-gray-500 mt-1 italic bg-red-50 rounded px-2 py-1">
                            {{ $historyByStatus->get('cancelled')->notes }}
                        </p>
                    @endif
                @endif
            </div>
        </div>
    @endif
</div>
