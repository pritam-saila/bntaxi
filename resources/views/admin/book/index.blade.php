@include('admin.include.sidebar')



<style>

    :root {

        --bn-blue: #0757d9;

        --bn-blue-dark: #063b91;

        --bn-green: #16a34a;

        --bn-green-bg: #ecfdf3;

        --bn-amber: #f59e0b;

        --bn-amber-bg: #fff8e6;

        --bn-journey: #1683e8;

        --bn-journey-bg: #eaf5ff;

        --bn-red: #dc2626;

        --bn-red-bg: #fff1f1;

        --bn-grey: #64748b;

        --bn-grey-bg: #f1f5f9;

    }



    #content {

        background: #f5f8fc;

        min-height: 100vh;

        padding: 20px 15px !important;

    }



    #content h3 {

        color: #123b72;

        font-size: 25px;

        font-weight: 800;

        margin-bottom: 18px !important;

    }



    .bn-top-navbar {

        background: #fff !important;

        border-bottom: 2px solid var(--bn-blue);

        min-height: 58px;

    }



    .bn-menu-btn {

        background: var(--bn-blue) !important;

        border-color: var(--bn-blue) !important;

        color: #fff !important;

        border-radius: 6px !important;

    }



    .bn-menu-btn:hover {

        background: var(--bn-blue-dark) !important;

    }



    .bn-filters {

        display: flex;

        flex-wrap: wrap;

        gap: 7px;

        margin-bottom: 16px;

    }



    .bn-filters .btn {

        margin: 0 !important;

        border-radius: 20px !important;

        padding: 7px 13px;

        font-size: 11px;

        font-weight: 700;

        transition: all .2s ease;

    }



    .bn-filters .btn:hover {

        transform: translateY(-1px);

    }



    .bn-filters .btn-danger {

        background: var(--bn-blue) !important;

        border-color: var(--bn-blue) !important;

    }



    .bn-filters .btn-outline-dark:hover {

        background: var(--bn-blue) !important;

        border-color: var(--bn-blue) !important;

        color: #fff !important;

    }



    .bn-status-legend {

        display: flex;

        flex-wrap: wrap;

        gap: 8px;

        margin-bottom: 15px;

    }



    .bn-status-legend-item {

        display: inline-flex;

        align-items: center;

        gap: 6px;

        padding: 6px 10px;

        background: #fff;

        border: 1px solid #dbe5ef;

        border-radius: 20px;

        color: #344054;

        font-size: 10px;

        font-weight: 700;

    }



    .bn-status-dot {

        width: 9px;

        height: 9px;

        border-radius: 50%;

        display: inline-block;

    }



    .bn-dot-green {

        background: var(--bn-green);

    }



    .bn-dot-amber {

        background: var(--bn-amber);

    }



    .bn-dot-blue {

        background: var(--bn-journey);

    }



    .bn-dot-red {

        background: var(--bn-red);

    }



    .bn-dot-grey {

        background: var(--bn-grey);

    }



    .bn-booking-table-wrap {

        background: #fff !important;

        border-radius: 14px;

        padding: 12px !important;

        border: 1px solid #dbe5f0;

        box-shadow: 0 5px 20px rgba(22, 48, 82, .07);

    }



    #example {

        width: 100% !important;

        margin: 0 !important;

        border-collapse: separate !important;

        border-spacing: 0 7px !important;

        background: transparent;

    }



    #example thead th {

        background: var(--bn-blue);

        color: #fff;

        border: none !important;

        padding: 12px 10px;

        font-size: 10px;

        font-weight: 800;

        text-transform: uppercase;

        vertical-align: middle;

        white-space: nowrap;

    }



    #example thead th:first-child {

        border-radius: 9px 0 0 9px;

    }



    #example thead th:last-child {

        border-radius: 0 9px 9px 0;

    }



    #example tbody tr {

        transition: transform .2s ease, box-shadow .2s ease;

    }



    #example tbody tr:hover {

        transform: translateY(-1px);

    }



    #example tbody td {

        padding: 11px 9px;

        font-size: 11px;

        vertical-align: middle;

        border-top: 1px solid #dfe7ef !important;

        border-bottom: 1px solid #dfe7ef !important;

        color: #243447;

        background: #fff;

    }



    #example tbody td:first-child {

        border-left: 1px solid #dfe7ef !important;

        border-radius: 9px 0 0 9px;

    }



    #example tbody td:last-child {

        border-right: 1px solid #dfe7ef !important;

        border-radius: 0 9px 9px 0;

    }



    /* CONFIRMED */

    #example tbody tr.bn-status-confirmed td {

        background: var(--bn-green-bg) !important;

        border-top-color: #b7e7c8 !important;

        border-bottom-color: #b7e7c8 !important;

    }



    #example tbody tr.bn-status-confirmed td:first-child {

        border-left: 5px solid var(--bn-green) !important;

    }



    /* PENDING */

    #example tbody tr.bn-status-pending td {

        background: var(--bn-amber-bg) !important;

        border-top-color: #f5d48a !important;

        border-bottom-color: #f5d48a !important;

    }



    #example tbody tr.bn-status-pending td:first-child {

        border-left: 5px solid var(--bn-amber) !important;

    }



    /* ON JOURNEY */

    #example tbody tr.bn-status-journey td {

        background: var(--bn-journey-bg) !important;

        border-top-color: #9acdf8 !important;

        border-bottom-color: #9acdf8 !important;

        color: #063b72;

    }



    #example tbody tr.bn-status-journey td:first-child {

        border-left: 5px solid var(--bn-journey) !important;

    }



    #example tbody tr.bn-status-journey {

        animation: bnJourneyPulse 2.2s ease-in-out infinite;

    }



    @keyframes bnJourneyPulse {

        0% {

            box-shadow: 0 2px 8px rgba(22,131,232,.08);

        }



        50% {

            box-shadow: 0 4px 20px rgba(22,131,232,.25);

        }



        100% {

            box-shadow: 0 2px 8px rgba(22,131,232,.08);

        }

    }



    /* REJECTED */

    #example tbody tr.bn-status-rejected td {

        background: var(--bn-red-bg) !important;

        border-top-color: #f4b4b4 !important;

        border-bottom-color: #f4b4b4 !important;

    }



    #example tbody tr.bn-status-rejected td:first-child {

        border-left: 5px solid var(--bn-red) !important;

    }



    /* URGENT */

    #example tbody tr.bn-status-urgent td {

        background: var(--bn-red-bg) !important;

        border-top-color: #f4b4b4 !important;

        border-bottom-color: #f4b4b4 !important;

    }



    #example tbody tr.bn-status-urgent td:first-child {

        border-left: 5px solid var(--bn-red) !important;

    }



    #example tbody tr.bn-status-urgent {

        animation: bnUrgentPulse 1.5s ease-in-out infinite;

    }



    @keyframes bnUrgentPulse {

        0% {

            box-shadow: 0 2px 8px rgba(220,38,38,.08);

        }



        50% {

            box-shadow: 0 4px 20px rgba(220,38,38,.25);

        }



        100% {

            box-shadow: 0 2px 8px rgba(220,38,38,.08);

        }

    }



    /* COMPLETED */

    #example tbody tr.bn-status-completed td {

        background: var(--bn-grey-bg) !important;

        color: var(--bn-grey) !important;

        border-top-color: #d7dee7 !important;

        border-bottom-color: #d7dee7 !important;

    }



    #example tbody tr.bn-status-completed td:first-child {

        border-left: 5px solid var(--bn-grey) !important;

    }



    .bn-status-badge {

        display: inline-flex;

        align-items: center;

        gap: 5px;

        padding: 5px 9px;

        border-radius: 20px;

        font-size: 10px;

        font-weight: 800;

        white-space: nowrap;

    }



    .bn-badge-confirmed {

        background: var(--bn-green);

        color: #fff;

    }



    .bn-badge-pending {

        background: var(--bn-amber);

        color: #111827;

    }



    .bn-badge-journey {

        background: var(--bn-journey);

        color: #fff;

    }



    .bn-badge-rejected {

        background: var(--bn-red);

        color: #fff;

    }



    .bn-badge-urgent {

        background: var(--bn-red);

        color: #fff;

    }



    .bn-badge-completed {

        background: var(--bn-grey);

        color: #fff;

    }



    .bn-badge-default {

        background: var(--bn-grey);

        color: #fff;

    }



    .bn-booking-id {

        color: var(--bn-blue);

        font-weight: 800;

        font-size: 12px;

    }



    .bn-customer-name {

        color: #172b4d;

        font-weight: 800;

    }



    .bn-pickup {

        color: #138a4b;

        font-weight: 700;

    }



    .bn-dropoff {

        color: #c62828;

        font-weight: 700;

    }



    .bn-date-badge,

    .bn-time-badge {

        display: inline-block;

        padding: 4px 7px;

        margin-top: 3px;

        border-radius: 5px;

        background: #eaf2ff;

        color: var(--bn-blue);

        font-size: 9px;

        font-weight: 700;

    }



    #example .btn {

        border-radius: 6px !important;

        font-size: 10px;

        font-weight: 700;

        padding: 5px 9px;

        border: none;

    }



    #example .btn-info {

        background: var(--bn-journey);

        color: #fff;

    }



    #example .btn-primary {

        background: var(--bn-blue);

        color: #fff;

    }



    #example .btn-danger {

        background: var(--bn-red);

        color: #fff;

    }



    #example .btn:hover {

        transform: translateY(-1px);

    }



    @media (max-width: 1100px) {

        #content {

            padding: 15px !important;

        }



        #example tbody td {

            font-size: 10px;

            padding: 8px 7px;

        }



        #example thead th {

            font-size: 9px;

            padding: 9px 7px;

        }

    }



    @media (max-width: 768px) {

        #content h3 {

            font-size: 20px;

        }



        .bn-status-legend-item {

            font-size: 9px;

        }

    }

</style>





<nav class="navbar navbar-expand-lg navbar-light bn-top-navbar">



    <div class="container-fluid">



        <button

            type="button"

            id="sidebarCollapse"

            class="btn bn-menu-btn"

        >

            <i class="fas fa-align-left"></i>

        </button>



        <button

            class="btn btn-dark d-inline-block d-lg-none ml-auto"

            type="button"

            data-toggle="collapse"

            data-target="#navbarSupportedContent"

            aria-controls="navbarSupportedContent"

            aria-expanded="false"

            aria-label="Toggle navigation"

        >

            <i class="fas fa-align-justify"></i>

        </button>



        @if(session()->has('success'))

            <div class="alert alert-success mb-0 ml-3 alert-dismissible fade show" role="alert">

                {{ session()->get('success') }}



                <button

                    type="button"

                    class="close"

                    data-dismiss="alert"

                    aria-label="Close"

                >

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

        @endif



        @if(session()->has('error'))

            <div class="alert alert-danger mb-0 ml-3 alert-dismissible fade show" role="alert">

                {{ session()->get('error') }}



                <button

                    type="button"

                    class="close"

                    data-dismiss="alert"

                    aria-label="Close"

                >

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

        @endif



    </div>



</nav>





<div class="wrapper">



    <div id="content">



        <div class="mb-4">



            <h3>

                <i class="fas fa-taxi mr-2"></i>

                BN Taxi Bookings Management

            </h3>



            @php

                $filters = [

                    '' => 'All Bookings',

                    'pending' => 'Pending Approval',

                    'confirmed' => 'Confirmed',

                    'rejected' => 'Rejected',

                    'cancelled' => 'Cancelled',

                    'completed' => 'Completed',

                    'today' => "Today's Journeys",

                    'tomorrow' => "Tomorrow's Journeys",

                    'airport' => 'Airport Bookings',

                    'online' => 'Online (Stripe)',

                    'cash' => 'Pay in Car',
                    'paid' => 'Paid',
                    'unpaid' => 'Unpaid / Outstanding',
                    'partially_paid' => 'Partially Paid',
                    'src_web' => 'Source: Online',
                    'src_admin' => 'Source: Admin',
                    'src_phone' => 'Source: Phone',

                    'urgent' => 'Urgent / Unapproved (2h)'

                ];

            @endphp



            <div class="bn-filters">



                @foreach($filters as $key => $label)



                    <a

                        href="{{ route('admbook.index', ['filter' => $key]) }}"

                        class="btn btn-sm {{ ($current_filter ?? '') === $key ? 'btn-danger' : 'btn-outline-dark' }}"

                    >

                        {{ $label }}

                    </a>



                @endforeach



            </div>





            <div class="bn-status-legend">



                <span class="bn-status-legend-item">

                    <span class="bn-status-dot bn-dot-green"></span>

                    Confirmed / Ready

                </span>



                <span class="bn-status-legend-item">

                    <span class="bn-status-dot bn-dot-amber"></span>

                    Pending Approval

                </span>



                <span class="bn-status-legend-item">

                    <span class="bn-status-dot bn-dot-blue"></span>

                    On Journey / In Progress

                </span>



                <span class="bn-status-legend-item">

                    <span class="bn-status-dot bn-dot-red"></span>

                    Urgent / Rejected

                </span>



                <span class="bn-status-legend-item">

                    <span class="bn-status-dot bn-dot-grey"></span>

                    Completed

                </span>



            </div>



        </div>





        <div class="table-responsive bn-booking-table-wrap">



            <table

                id="example"

                class="table"

                style="width:100%"

            >



                <thead>



                    <tr>

                        <th>Ref Number</th>

                        <th>Created Date</th>

                        <th>Customer Info</th>

                        <th>Pickup Details</th>

                        <th>Drop-off Address</th>

                        <th>Payment &amp; Amounts</th>

                        <th>Status</th>

                        <th>Actions</th>

                    </tr>



                </thead>



                <tbody>



                    @foreach ($data as $item)



                        @php

                            $isUrgent = false;



                            if (

                                $item->status === 'PENDING APPROVAL' &&

                                $item->pickup_date &&

                                $item->pickup_time

                            ) {

                                try {

                                    $pickupTimeObj = \Carbon\Carbon::parse(

                                        $item->pickup_date . ' ' . $item->pickup_time

                                    );



                                    $isUrgent =

                                        $pickupTimeObj->isFuture() &&

                                        $pickupTimeObj->diffInMinutes(now()) <= 120;



                                } catch (\Exception $e) {

                                    $isUrgent = false;

                                }

                            }



                            $statusClass = 'bn-status-pending';

                            $badgeClass = 'bn-badge-pending';

                            $statusIcon = 'fa-clock';

                            $displayStatus = $item->status;



                            if ($isUrgent) {



                                $statusClass = 'bn-status-urgent';

                                $badgeClass = 'bn-badge-urgent';

                                $statusIcon = 'fa-exclamation-triangle';

                                $displayStatus = 'URGENT';



                            } elseif ($item->status === 'CONFIRMED') {



                                $statusClass = 'bn-status-confirmed';

                                $badgeClass = 'bn-badge-confirmed';

                                $statusIcon = 'fa-check-circle';



                            } elseif (

                                $item->status === 'ON JOURNEY' ||

                                $item->status === 'IN PROGRESS' ||

                                $item->status === 'IN_PROGRESS'

                            ) {



                                $statusClass = 'bn-status-journey';

                                $badgeClass = 'bn-badge-journey';

                                $statusIcon = 'fa-car';



                            } elseif ($item->status === 'REJECTED') {



                                $statusClass = 'bn-status-rejected';

                                $badgeClass = 'bn-badge-rejected';

                                $statusIcon = 'fa-times-circle';



                            } elseif ($item->status === 'COMPLETED') {



                                $statusClass = 'bn-status-completed';

                                $badgeClass = 'bn-badge-completed';

                                $statusIcon = 'fa-check-double';



                            } elseif ($item->status === 'PENDING APPROVAL') {



                                $statusClass = 'bn-status-pending';

                                $badgeClass = 'bn-badge-pending';

                                $statusIcon = 'fa-clock';



                            } else {



                                $statusClass = 'bn-status-pending';

                                $badgeClass = 'bn-badge-default';

                                $statusIcon = 'fa-circle';

                            }

                        @endphp





                        <tr class="{{ $statusClass }}">



                            <td>



                                <strong class="bn-booking-id">

                                    {{ $item->booking_id }}

                                </strong>



                                @if($isUrgent)



                                    <br>



                                    <span class="bn-status-badge bn-badge-urgent">

                                        <i class="fas fa-exclamation-triangle"></i>

                                        Urgent

                                    </span>



                                @endif

                                <br>
                                <span class="badge {{ $item->source_badge }}" style="font-weight:700; margin-top:4px; display:inline-block;">
                                    <i class="fas {{ $item->source_icon }}"></i> {{ $item->source_label }}
                                </span>



                            </td>





                            <td>

                                {{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}

                            </td>





                            <td>



                                <strong class="bn-customer-name">

                                    {{ $item->name ?? $item->username }}

                                </strong>



                                <br>



                                <span class="small text-muted">

                                    {{ $item->email }}

                                </span>



                                <br>



                                <span class="small text-muted">

                                    {{ $item->phone ?? $item->userphone }}

                                </span>



                            </td>





                            <td>



                                <p class="mb-1 bn-pickup">



                                    <i class="fas fa-map-marker-alt"></i>



                                    {{ $item->pickup }}



                                </p>



                                <span class="bn-date-badge">



                                    <i class="far fa-calendar-alt"></i>



                                    {{ $item->pickup_date }}



                                </span>



                                <span class="bn-time-badge">



                                    <i class="far fa-clock"></i>



                                    {{ $item->pickup_time }}



                                </span>



                            </td>





                            <td>



                                <p class="mb-1 bn-dropoff">



                                    <i class="fas fa-map-pin"></i>



                                    {{ $item->dropoff }}



                                </p>



                                @if($item->vias && count($item->vias) > 2)



                                    <span class="badge badge-secondary">

                                        {{ count($item->vias) - 2 }} Stops

                                    </span>



                                @endif



                            </td>





                            <td>

                                <strong>£{{ number_format($item->price, 2) }}</strong>

                                <div class="small text-muted">{{ $item->payment_method_display }}</div>

                                <span class="badge {{ $item->payment_status_badge }}">{{ $item->payment_status_label }}</span>

                                <div class="small mt-1">
                                    Paid £{{ number_format((float) $item->amount_paid, 2) }}
                                    @if($item->outstandingBalance() > 0)
                                        <span class="text-danger font-weight-bold">&middot; Owes £{{ number_format($item->outstandingBalance(), 2) }}</span>
                                    @endif
                                </div>

                            </td>




                            <td>



                                <span class="bn-status-badge {{ $badgeClass }}">



                                    <i class="fas {{ $statusIcon }}"></i>



                                    {{ $displayStatus }}



                                </span>



                            </td>





                            <td>



                                <div class="btn-group-vertical">



                                    <a

                                        href="{{ route('admbook.show', $item->id) }}"

                                        class="btn btn-info btn-sm mb-1 rounded"

                                    >

                                        <i class="fas fa-eye"></i>

                                        View

                                    </a>



                                    <a

                                        href="{{ route('admbook.edit', $item->id) }}"

                                        class="btn btn-primary btn-sm mb-1 rounded"

                                    >

                                        <i class="fas fa-edit"></i>

                                        Edit

                                    </a>



                                    <form

                                        action="{{ route('admbook.destroy', $item->id) }}"

                                        method="POST"

                                        style="display:inline-block;"

                                        onsubmit="return condelete();"

                                    >



                                        @csrf



                                        @method('DELETE')



                                        <button

                                            type="submit"

                                            class="btn btn-danger btn-sm rounded"

                                        >

                                            <i class="fas fa-trash"></i>

                                            Delete

                                        </button>



                                    </form>



                                </div>



                            </td>



                        </tr>



                    @endforeach



                </tbody>



            </table>



        </div>



    </div>



</div>





<script>



    function condelete()

    {

        return confirm("Do you really want to delete?");

    }





    var i = 0;





    function addhtml()

    {

        i++;



        var html =

            '<div class="row mt-2" id="rem' + i + '">' +



                '<div class="col-md-5">' +



                    '<input ' +

                    'type="text" ' +

                    'name="heading[]" ' +

                    'class="form-control form-control-sm" ' +

                    'placeholder="Heading">' +



                '</div>' +



                '<div class="col-md-5">' +



                    '<input ' +

                    'type="text" ' +

                    'name="price[]" ' +

                    'class="form-control form-control-sm" ' +

                    'placeholder="Price">' +



                '</div>' +



                '<div class="col-md-2">' +



                    '<span ' +

                    'class="btn btn-danger btn-sm" ' +

                    'onclick="remhtml(' + i + ')">' +



                    '-' +



                    '</span>' +



                '</div>' +



            '</div>';



        $("#heade").append(html);

    }





    function remhtml(index)

    {

        $('#rem' + index).remove();

    }





    function remove(index)

    {

        $('#reme' + index).remove();

    }



</script>