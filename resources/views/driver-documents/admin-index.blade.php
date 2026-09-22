@include('admin.include.sidebar')

@php $cssVer = @filemtime(public_path('admin/css/driver-documents.css')) ?: 1; @endphp
<link rel="stylesheet" href="{{ url('/admin/css/driver-documents.css') }}?v={{ $cssVer }}">

<div class="wrapper">
<div id="content">
<div class="dd">
    <header class="dd-page-head">
        <h1>Driver Verification</h1>
        <p class="dd-sub">Review each driver’s documents and see who still needs to act.</p>
    </header>

    @if(session('dd_success'))
        <div class="dd-flash" role="status">{{ session('dd_success') }}</div>
    @endif

    <form class="dd-search" method="GET" action="{{ route('admin.dv.index') }}">
        @if($filter)<input type="hidden" name="status" value="{{ $filter }}">@endif
        @if($onlyPending)<input type="hidden" name="application" value="pending">@endif
        <input type="search" name="q" value="{{ $q }}" placeholder="Search by name or email" aria-label="Search drivers">
        <button type="submit" class="dd-btn dd-btn-primary">Search</button>
    </form>

    <nav class="dd-filters" aria-label="Filter by status">
        <a href="{{ route('admin.dv.index', array_filter(['q' => $q])) }}" class="{{ $filter || $onlyPending ? '' : 'is-active' }}">All <small>{{ $counts->sum() }}</small></a>
        <a href="{{ route('admin.dv.index', array_filter(['application' => 'pending', 'q' => $q])) }}" class="{{ $onlyPending ? 'is-active' : '' }}">New applications <small>{{ $pendingCount }}</small></a>
        @foreach($statuses as $key => $meta)
            <a href="{{ route('admin.dv.index', array_filter(['status' => $key, 'q' => $q])) }}" class="{{ $filter === $key ? 'is-active' : '' }}">
                {{ $meta[0] }} <small>{{ $counts->get($key, 0) }}</small>
            </a>
        @endforeach
    </nav>

    <div class="dd-table-wrap">
        @if($rows->isEmpty())
            <p class="dd-empty">No drivers match.</p>
        @else
            <table class="dd-table">
                <thead>
                    <tr>
                        <th>Driver</th>
                        <th>Contact</th>
                        <th>Account</th>
                        <th>Documentation</th>
                        <th>Approved</th>
                        <th><span class="sr-only">Action</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                        @php $o = $row['overall']; $d = $row['driver']; @endphp
                        <tr>
                            <td><strong>{{ $d->name }}</strong><small>{{ $d->email }}</small></td>
                            <td>{{ $d->phone ?: '—' }}</td>
                            <td>
                                {{ $d->status == 1 ? 'Active' : 'Inactive' }}
                                @php $app = $d->driverProfile?->application_status; @endphp
                                @if($app === 'pending')<small class="dd-warn-text">Application pending</small>
                                @elseif($app === 'declined')<small>Application declined</small>@endif
                            </td>
                            <td>
                                <span class="dd-pill dd-pill-{{ $o['tone'] }}">{{ $o['label'] }}</span>
                                @if($o['expiring'])<small class="dd-warn-text">{{ $o['expiring'] }} expired / expiring</small>@endif
                            </td>
                            <td>{{ $o['approved'] }} / {{ $o['required_total'] }}</td>
                            <td><a class="dd-btn dd-btn-outline dd-btn-sm" href="{{ route('admin.dv.show', $d) }}">Review</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
</div>
</div>
