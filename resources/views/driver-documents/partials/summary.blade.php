@php
    $o   = $overall;
    $pct = $o['required_total'] ? (int) round($o['approved'] / $o['required_total'] * 100) : 0;
    $icons = ['ok' => '✓', 'pending' => '…', 'action' => '⚠', 'optional' => '–'];
@endphp
<section class="dd-summary dd-tone-{{ $o['tone'] }}" aria-live="polite">
    <div class="dd-summary-head">
        <div>
            <h2 class="dd-h">Driver Documentation</h2>
            <p class="dd-sub">{{ $o['summary'] }}</p>
        </div>
        <div class="dd-overall">
            <span class="dd-overall-label">Overall Status</span>
            <span class="dd-pill dd-pill-{{ $o['tone'] }}">{{ $o['label'] }}</span>
        </div>
    </div>

    <div class="dd-meter" role="progressbar" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100" aria-label="Required documents approved">
        <span style="width: {{ $pct }}%"></span>
    </div>
    <p class="dd-meter-text">
        {{ $o['approved'] }} of {{ $o['required_total'] }} required documents approved
        @if($o['expiring'])
            · <strong class="dd-warn-text">{{ $o['expiring'] }} {{ $o['expiring'] === 1 ? 'document is' : 'documents are' }} expired or expiring soon</strong>
        @endif
    </p>

    <ul class="dd-checklist">
        @foreach($o['items'] as $item)
            <li class="dd-check dd-check-{{ $item['state'] }} {{ $item['warn'] ? 'dd-check-warn' : '' }}">
                <span class="dd-check-icon" aria-hidden="true">{{ $item['warn'] ? '⚠' : $icons[$item['state']] }}</span>
                <span class="dd-check-label">{{ $item['label'] }}</span>
                <span class="dd-check-note">{{ $item['note'] }}</span>
            </li>
        @endforeach
    </ul>
</section>
