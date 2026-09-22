@if($reviews->isEmpty())
    <p class="dd-hist-empty">No activity yet.</p>
@else
    <ol class="dd-hist">
        @foreach($reviews as $r)
            <li>
                <div class="dd-hist-top">
                    <strong>{{ $r->actionLabel() }}</strong>
                    @if($r->from_status !== $r->to_status && $r->to_status)
                        <span class="dd-hist-flow">{{ \App\Models\DriverDocument::STATUS_LABELS[$r->from_status] ?? '—' }} → {{ \App\Models\DriverDocument::STATUS_LABELS[$r->to_status] ?? $r->to_status }}</span>
                    @endif
                </div>
                <div class="dd-hist-meta">
                    {{ $r->created_at?->format('d M Y, H:i') }} · {{ $r->actor?->name ?? 'Unknown user' }} ({{ $r->actor_role }})
                </div>
                @if($r->reason)
                    <p class="dd-hist-reason">{{ $r->reason }}</p>
                @endif
                @if($r->note)
                    <p class="dd-hist-note"><span>Internal</span> {{ $r->note }}</p>
                @endif
            </li>
        @endforeach
    </ol>
@endif
