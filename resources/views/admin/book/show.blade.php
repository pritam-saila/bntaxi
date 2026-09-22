@include('admin.include.sidebar')



<style>

/* =========================================================

   BN TAXI ANYTIME - BOOKING DETAILS

   Professional Admin Design

   ========================================================= */



:root {

    --bn-blue: #0757d9;

    --bn-blue-dark: #063b91;

    --bn-blue-light: #eaf3ff;



    --bn-green: #16a34a;

    --bn-green-light: #ecfdf3;



    --bn-orange: #f59e0b;

    --bn-orange-light: #fff7e6;



    --bn-red: #dc2626;

    --bn-red-light: #fff1f1;



    --bn-purple: #6d28d9;



    --bn-bg: #f3f6fa;

    --bn-card: #ffffff;

    --bn-border: #dce5ef;



    --bn-text: #172b4d;

    --bn-muted: #64748b;

}





/* =========================================================

   MAIN

   ========================================================= */



#content {

    min-height: 100vh;

    background: var(--bn-bg);

    padding: 25px !important;

}



.bn-booking-page {

    width: 100%;

    max-width: 1500px;

    margin: 0 auto;

}





/* =========================================================

   TOP HEADER

   ========================================================= */



.bn-top-header {

    background: linear-gradient(

        135deg,

        #0757d9 0%,

        #063b91 100%

    );



    border-radius: 18px;

    padding: 22px 25px;

    margin-bottom: 22px;



    color: #fff;



    display: flex;

    align-items: center;

    justify-content: space-between;



    gap: 20px;



    box-shadow:

        0 10px 30px rgba(7, 87, 217, .20);

}





.bn-header-left {

    display: flex;

    align-items: center;

    gap: 15px;

}





.bn-header-icon {

    width: 58px;

    height: 58px;



    border-radius: 14px;



    background: rgba(255,255,255,.14);



    display: flex;

    align-items: center;

    justify-content: center;



    font-size: 27px;

}





.bn-header-title h2 {

    margin: 0;



    font-size: 25px;

    font-weight: 800;

}





.bn-header-title p {

    margin: 5px 0 0;



    font-size: 12px;



    opacity: .85;

}





.bn-booking-number {

    background: #fff;

    color: var(--bn-blue);



    padding: 12px 18px;



    border-radius: 10px;



    font-size: 13px;

    font-weight: 800;



    box-shadow: 0 4px 12px rgba(0,0,0,.12);

}





.bn-back-btn {

    display: inline-flex;

    align-items: center;

    gap: 7px;



    color: #fff !important;



    border: 1px solid rgba(255,255,255,.4);



    background: rgba(255,255,255,.10);



    border-radius: 8px;



    padding: 9px 14px;



    font-size: 12px;

    font-weight: 700;



    text-decoration: none !important;

}





.bn-back-btn:hover {

    background: #fff;

    color: var(--bn-blue) !important;

}





/* =========================================================

   ACTION ALERTS

   ========================================================= */



.bn-action-alert {

    border-radius: 15px !important;



    border: 0 !important;



    padding: 20px 22px !important;



    margin-bottom: 22px;



    box-shadow:

        0 7px 22px rgba(0,0,0,.07);

}





.bn-action-alert h5 {

    margin: 0 0 5px;



    font-size: 16px;

    font-weight: 800;

}





.bn-action-alert p {

    margin: 0;



    font-size: 12px;

}





.bn-action-alert .btn {

    border-radius: 8px;



    font-size: 11px;



    padding: 10px 15px;

}





/* PENDING */



.bn-alert-pending {

    background: var(--bn-orange-light);



    border-left: 5px solid var(--bn-orange) !important;

}





/* CONFIRMED */



.bn-alert-confirmed {

    background: var(--bn-green-light);



    border-left: 5px solid var(--bn-green) !important;

}





/* REJECTED */



.bn-alert-rejected {

    background: var(--bn-red-light);



    border-left: 5px solid var(--bn-red) !important;

}





/* =========================================================

   STATUS STRIP

   ========================================================= */



.bn-status-strip {

    display: flex;

    flex-wrap: wrap;



    gap: 10px;



    margin-bottom: 22px;

}





.bn-status-card {

    flex: 1 1 180px;



    background: #fff;



    border: 1px solid var(--bn-border);



    border-radius: 12px;



    padding: 13px 15px;



    box-shadow:

        0 4px 15px rgba(31,52,73,.05);

}





.bn-status-label {

    font-size: 9px;



    color: var(--bn-muted);



    text-transform: uppercase;



    font-weight: 800;



    letter-spacing: .5px;

}





.bn-status-value {

    margin-top: 5px;



    font-size: 14px;



    font-weight: 800;



    color: var(--bn-text);

}





.bn-dot {

    display: inline-block;



    width: 9px;

    height: 9px;



    border-radius: 50%;



    margin-right: 6px;

}





.bn-dot-green {

    background: var(--bn-green);

}





.bn-dot-orange {

    background: var(--bn-orange);

}





.bn-dot-red {

    background: var(--bn-red);

}





.bn-dot-blue {

    background: var(--bn-blue);

}





/* =========================================================

   MAIN CARD

   ========================================================= */



.bn-main-card {

    background: var(--bn-card);



    border: 1px solid var(--bn-border);



    border-radius: 18px;



    overflow: hidden;



    box-shadow:

        0 8px 28px rgba(31,52,73,.08);

}





.bn-main-card-header {

    background: #fff;



    padding: 18px 22px;



    border-bottom: 1px solid var(--bn-border);



    display: flex;

    align-items: center;

    justify-content: space-between;

}





.bn-main-card-title {

    display: flex;

    align-items: center;



    gap: 10px;

}





.bn-main-card-title i {

    color: var(--bn-blue);



    font-size: 19px;

}





.bn-main-card-title h4 {

    margin: 0;



    font-size: 17px;



    font-weight: 800;



    color: var(--bn-text);

}





.bn-main-card-body {

    padding: 25px;

}





/* =========================================================

   SECTION CARD

   ========================================================= */



.bn-section {

    background: #fff;



    border: 1px solid var(--bn-border);



    border-radius: 14px;



    overflow: hidden;



    margin-bottom: 22px;



    box-shadow:

        0 4px 15px rgba(31,52,73,.04);

}





.bn-section-header {

    padding: 14px 17px;



    background: #f8fafc;



    border-bottom: 1px solid var(--bn-border);



    display: flex;

    align-items: center;



    gap: 9px;

}





.bn-section-header i {

    color: var(--bn-blue);



    font-size: 15px;

}





.bn-section-header h5 {

    margin: 0;



    color: var(--bn-text);



    font-size: 13px;



    font-weight: 800;

}





.bn-section-body {

    padding: 0;

}





/* =========================================================

   DETAILS TABLE

   ========================================================= */



.bn-detail-table {

    margin: 0 !important;



    width: 100%;

}





.bn-detail-table tr {

    border-bottom: 1px solid #edf1f5;

}





.bn-detail-table tr:last-child {

    border-bottom: 0;

}





.bn-detail-table th {

    width: 34%;



    background: #fbfcfe;



    color: #53657d;



    font-size: 11px;



    font-weight: 800;



    padding: 13px 15px;



    vertical-align: middle;



    border: 0 !important;

}





.bn-detail-table td {

    color: var(--bn-text);



    font-size: 12px;



    font-weight: 600;



    padding: 13px 15px;



    vertical-align: middle;



    border: 0 !important;

}





.bn-detail-table a {

    color: var(--bn-blue);



    font-weight: 700;



    text-decoration: none;

}





.bn-detail-table a:hover {

    text-decoration: underline;

}





/* =========================================================

   ADDRESS

   ========================================================= */



.bn-pickup {

    color: var(--bn-green) !important;



    font-weight: 800;

}





.bn-dropoff {

    color: var(--bn-red) !important;



    font-weight: 800;

}





.bn-via {

    display: flex;

    align-items: center;



    gap: 7px;



    color: #475569;



    font-weight: 600;

}





.bn-via-dot {

    width: 7px;

    height: 7px;



    border-radius: 50%;



    background: #94a3b8;

}





/* =========================================================

   DATE BADGES

   ========================================================= */



.bn-date-badge {

    display: inline-flex;

    align-items: center;



    gap: 6px;



    background: var(--bn-blue-light);



    color: var(--bn-blue);



    padding: 7px 10px;



    border-radius: 7px;



    font-size: 10px;



    font-weight: 800;

}





.bn-return-badge {

    background: var(--bn-green-light);



    color: var(--bn-green);

}





/* =========================================================

   MAP

   ========================================================= */



.bn-map-wrapper {

    margin: 15px;



    border-radius: 12px;



    overflow: hidden;



    border: 1px solid var(--bn-border);



    box-shadow:

        0 5px 15px rgba(0,0,0,.08);

}





.bn-map-wrapper iframe {

    display: block;



    width: 100%;



    height: 300px;



    border: 0;

}





/* =========================================================

   PAYMENT

   ========================================================= */



.bn-payment-paid {

    display: inline-flex;

    align-items: center;



    gap: 6px;



    background: var(--bn-green-light);



    color: var(--bn-green);



    border-radius: 20px;



    padding: 7px 11px;



    font-size: 10px;



    font-weight: 800;

}





.bn-payment-pending {

    display: inline-flex;

    align-items: center;



    gap: 6px;



    background: var(--bn-orange-light);



    color: #b45309;



    border-radius: 20px;



    padding: 7px 11px;



    font-size: 10px;



    font-weight: 800;

}





.bn-price {

    color: var(--bn-blue);



    font-size: 22px;



    font-weight: 900;

}





/* =========================================================

   FLIGHT CARD

   ========================================================= */



.bn-flight-box {

    background:

        linear-gradient(

            135deg,

            #f5f9ff,

            #ffffff

        );



    border: 1px solid #dbeafe;



    border-radius: 12px;



    padding: 14px;

}





.bn-flight-title {

    display: flex;

    align-items: center;



    gap: 8px;



    color: var(--bn-blue);



    font-weight: 800;



    font-size: 13px;



    margin-bottom: 10px;

}





/* =========================================================

   TIMELINE

   ========================================================= */



.bn-timeline-card {

    background: #fff;



    border: 1px solid var(--bn-border);



    border-radius: 15px;



    overflow: hidden;



    box-shadow:

        0 6px 20px rgba(31,52,73,.06);

}





.bn-timeline-header {

    background:

        linear-gradient(

            135deg,

            #172b4d,

            #0b1d36

        );



    color: #fff;



    padding: 16px 20px;

}





.bn-timeline-header h5 {

    margin: 0;



    font-size: 14px;



    font-weight: 800;

}





.bn-timeline-body {

    padding: 25px;

}





.bn-timeline {

    position: relative;



    margin-left: 8px;



    padding-left: 28px;



    border-left: 2px solid #dbeafe;

}





.bn-timeline-item {

    position: relative;



    margin-bottom: 22px;



    padding: 15px 17px;



    background: #f8fafc;



    border: 1px solid #e6edf5;



    border-radius: 10px;

}





.bn-timeline-item:last-child {

    margin-bottom: 0;

}





.bn-timeline-dot {

    position: absolute;



    left: -36px;



    top: 18px;



    width: 13px;

    height: 13px;



    border-radius: 50%;



    background: var(--bn-blue);



    border: 3px solid #fff;



    box-shadow:

        0 0 0 2px #bfdbfe;

}





.bn-timeline-time {

    font-size: 10px;



    color: #64748b;



    font-weight: 700;

}





.bn-timeline-event {

    margin-top: 5px;



    font-size: 13px;



    color: var(--bn-text);



    font-weight: 800;

}





.bn-timeline-details {

    margin-top: 4px;



    font-size: 11px;



    color: #64748b;



    line-height: 1.5;

}





/* =========================================================

   MODALS

   ========================================================= */



.bn-modal-content {

    border: 0;



    border-radius: 16px;



    overflow: hidden;



    box-shadow:

        0 20px 60px rgba(0,0,0,.20);

}





.bn-modal-header {

    background:

        linear-gradient(

            135deg,

            var(--bn-blue),

            var(--bn-blue-dark)

        );



    color: #fff;



    border: 0;



    padding: 17px 20px;

}





.bn-modal-header h5 {

    font-size: 15px;



    font-weight: 800;



    margin: 0;

}





.bn-modal-body {

    padding: 22px;

}





.bn-modal-label {

    color: var(--bn-text);



    font-size: 12px;



    font-weight: 800;



    margin-bottom: 7px;

}





.bn-modal-textarea {

    width: 100%;



    border: 1px solid #cfd9e5;



    border-radius: 9px;



    padding: 12px;



    font-size: 12px;



    outline: none;



    resize: vertical;

}





.bn-modal-textarea:focus {

    border-color: var(--bn-blue);



    box-shadow:

        0 0 0 3px rgba(7,87,217,.10);

}





.bn-modal-footer {

    padding: 15px 20px;



    background: #f8fafc;



    border-top: 1px solid var(--bn-border);

}





/* =========================================================

   MOBILE / TABLET

   ========================================================= */



@media (max-width: 991px) {



    #content {

        padding: 18px !important;

    }



    .bn-top-header {

        padding: 18px;

    }



    .bn-header-title h2 {

        font-size: 21px;

    }



    .bn-main-card-body {

        padding: 18px;

    }



    .bn-map-wrapper iframe {

        height: 250px;

    }

}





@media (max-width: 767px) {



    #content {

        padding: 12px !important;

    }



    .bn-top-header {

        flex-direction: column;



        align-items: stretch;



        border-radius: 13px;



        padding: 16px;



        gap: 12px;

    }



    .bn-header-left {

        align-items: flex-start;

    }



    .bn-header-icon {

        width: 45px;

        height: 45px;



        font-size: 20px;

    }



    .bn-header-title h2 {

        font-size: 18px;

    }



    .bn-header-title p {

        font-size: 10px;

    }



    .bn-booking-number {

        text-align: center;

    }



    .bn-back-btn {

        justify-content: center;

    }



    .bn-main-card {

        border-radius: 12px;

    }



    .bn-main-card-body {

        padding: 12px;

    }



    .bn-detail-table th {

        width: 40%;



        font-size: 9px;



        padding: 10px;

    }



    .bn-detail-table td {

        font-size: 10px;



        padding: 10px;

    }



    .bn-map-wrapper {

        margin: 10px;

    }



    .bn-map-wrapper iframe {

        height: 220px;

    }



    .bn-action-alert {

        padding: 15px !important;

    }



    .bn-action-alert .btn {

        margin-top: 7px;



        width: 100%;

    }



    .bn-timeline-body {

        padding: 16px;

    }



    .bn-timeline-item {

        padding: 12px;

    }



    .bn-price {

        font-size: 18px;

    }

}

</style>





<div class="wrapper">



    <div id="content">



        <div class="bn-booking-page">





            {{-- =====================================================

                TOP HEADER

            ====================================================== --}}



            <div class="bn-top-header">



                <div class="bn-header-left">



                    <div class="bn-header-icon">

                        <i class="fas fa-taxi"></i>

                    </div>



                    <div class="bn-header-title">



                        <h2>

                            BN Taxi Booking Details

                        </h2>



                        <p>

                            Complete booking information & journey management

                        </p>



                    </div>



                </div>





                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">



                    <div class="bn-booking-number">

                        <i class="fas fa-hashtag"></i>

                        {{ $data->booking_id }}

                    </div>



                    <a

                        href="{{ route('admbook.index') }}"

                        class="bn-back-btn"

                    >

                        <i class="fas fa-arrow-left"></i>

                        Back to Bookings

                    </a>



                </div>



            </div>





            {{-- =====================================================

                STATUS QUICK STRIP

            ====================================================== --}}



            <div class="bn-status-strip">



                <div class="bn-status-card">



                    <div class="bn-status-label">

                        Booking Status

                    </div>



                    <div class="bn-status-value">



                        @if($data->status === 'CONFIRMED')



                            <span class="bn-dot bn-dot-green"></span>

                            Confirmed



                        @elseif($data->status === 'PENDING APPROVAL')



                            <span class="bn-dot bn-dot-orange"></span>

                            Pending Approval



                        @elseif($data->status === 'REJECTED')



                            <span class="bn-dot bn-dot-red"></span>

                            Rejected



                        @else



                            <span class="bn-dot bn-dot-blue"></span>

                            {{ $data->status }}



                        @endif



                    </div>



                </div>





                <div class="bn-status-card">



                    <div class="bn-status-label">

                        Payment

                    </div>



                    <div class="bn-status-value">



                        <span class="bn-dot bn-dot-{{ ['paid' => 'green', 'partially_paid' => 'blue', 'refunded' => 'blue', 'payment_failed' => 'red'][$data->payment_status] ?? 'orange' }}"></span>

                        {{ $data->payment_status_label }}



                    </div>



                </div>





                <div class="bn-status-card">



                    <div class="bn-status-label">

                        Payment Method

                    </div>



                    <div class="bn-status-value">

                        {{ $data->payment_method_display }}

                    </div>



                </div>





                <div class="bn-status-card">



                    <div class="bn-status-label">

                        Journey Date

                    </div>



                    <div class="bn-status-value">

                        {{ $data->pickup_date }}

                    </div>



                </div>



                <div class="bn-status-card">

                    <div class="bn-status-label">
                        Booking Source
                    </div>

                    <div class="bn-status-value">
                        <i class="fas {{ $data->source_icon }}" style="color:var(--bn-blue); margin-right:6px;"></i>
                        {{ $data->source_label }}
                    </div>

                </div>



            </div>





            {{-- =====================================================

                ACTION NOTICES

            ====================================================== --}}



            @if($data->status === 'PENDING APPROVAL')



                <div class="alert bn-action-alert bn-alert-pending">



                    <div class="d-flex flex-wrap justify-content-between align-items-center">



                        <div class="mb-2 mb-md-0">



                            <h5>

                                <i class="fas fa-clock"></i>

                                Booking Request Awaiting Approval

                            </h5>



                            <p>

                                Please review the booking details and confirm or reject this request.

                            </p>



                        </div>





                        <div>



                            <form

                                action="{{ route('admin.book.confirm', $data->id) }}"

                                method="POST"

                                style="display:inline-block;"

                            >



                                @csrf



                                <button

                                    type="submit"

                                    class="btn btn-success font-weight-bold mr-2"

                                >

                                    <i class="fas fa-check"></i>

                                    CONFIRM BOOKING

                                </button>



                            </form>





                            <button

                                type="button"

                                class="btn btn-danger font-weight-bold"

                                data-toggle="modal"

                                data-target="#rejectModal"

                            >

                                <i class="fas fa-times"></i>

                                REJECT BOOKING

                            </button>



                        </div>



                    </div>



                </div>





            @elseif($data->status === 'REJECTED')



                <div class="alert bn-action-alert bn-alert-rejected">



                    <h5>

                        <i class="fas fa-ban"></i>

                        Booking Request Rejected

                    </h5>



                    <p>

                        <strong>Reason:</strong>

                        {{ $data->rejection_reason ?? 'Not specified' }}

                    </p>



                </div>





            @elseif($data->status === 'CONFIRMED')



                <div class="alert bn-action-alert bn-alert-confirmed">



                    <div class="d-flex flex-wrap justify-content-between align-items-center">



                        <div class="mb-2 mb-md-0">



                            <h5>

                                <i class="fas fa-check-circle"></i>

                                Booking Request Confirmed

                            </h5>



                            <p>

                                Confirmed at

                                {{ $data->confirmed_at }}

                                by Admin ID:

                                {{ $data->confirmed_by }}.

                            </p>



                        </div>





                        <div>



                            @if($data->isPayInCar() && !$data->isPaid())

                                <form
                                    action="{{ route('admin.book.record-cash', $data->id) }}"
                                    method="POST"
                                    style="display:inline-block;"
                                >
                                    @csrf
                                    <button type="submit" class="btn btn-dark font-weight-bold mr-2">
                                        <i class="fas fa-money-bill-wave"></i>
                                        MARK AS PAID (£{{ number_format((float) $data->price, 2) }})
                                    </button>
                                </form>

                            @endif





                            <button

                                type="button"

                                class="btn btn-danger font-weight-bold"

                                data-toggle="modal"

                                data-target="#cancelModal"

                            >

                                <i class="fas fa-times"></i>

                                CANCEL BOOKING

                            </button>



                        </div>



                    </div>



                </div>



            @endif





            {{-- =====================================================

                MAIN CARD

            ====================================================== --}}



            <div class="bn-main-card">



                <div class="bn-main-card-header">



                    <div class="bn-main-card-title">



                        <i class="fas fa-file-invoice"></i>



                        <h4>

                            Complete Booking Information

                        </h4>



                    </div>



                </div>





                <div class="bn-main-card-body">



                    <div class="row">





                        {{-- =================================================

                            LEFT SIDE

                        ================================================== --}}



                        <div class="col-lg-7">





                            {{-- CUSTOMER --}}



                            <div class="bn-section">



                                <div class="bn-section-header">



                                    <i class="fas fa-user-circle"></i>



                                    <h5>

                                        Customer & Passenger Information

                                    </h5>



                                </div>





                                <div class="bn-section-body">



                                    <table class="table bn-detail-table">



                                        <tr>



                                            <th>

                                                Customer Name

                                            </th>



                                            <td>

                                                {{ $data->name }}

                                            </td>



                                        </tr>





                                        <tr>



                                            <th>

                                                Email Address

                                            </th>



                                            <td>

                                                <a href="mailto:{{ $data->email }}">

                                                    {{ $data->email }}

                                                </a>

                                            </td>



                                        </tr>





                                        <tr>



                                            <th>

                                                Telephone

                                            </th>



                                            <td>

                                                <a href="tel:{{ $data->phone }}">

                                                    {{ $data->phone }}

                                                </a>

                                            </td>



                                        </tr>





                                        <tr>



                                            <th>

                                                Passengers

                                            </th>



                                            <td>



                                                <span class="bn-date-badge">

                                                    <i class="fas fa-users"></i>

                                                    {{ $data->passengers ?? '1' }}

                                                </span>



                                            </td>



                                        </tr>





                                        <tr>



                                            <th>

                                                Bags Count

                                            </th>



                                            <td>



                                                <span class="bn-date-badge">

                                                    <i class="fas fa-suitcase"></i>

                                                    {{ $data->bags ?? '0' }}

                                                </span>



                                            </td>



                                        </tr>





                                        @if(!empty($data->special_instructions))



                                            <tr>



                                                <th>

                                                    Special Instructions

                                                </th>



                                                <td>



                                                    <div

                                                        style="

                                                            background:#f8fafc;

                                                            border-left:4px solid #0757d9;

                                                            padding:10px;

                                                            border-radius:6px;

                                                        "

                                                    >

                                                        {{ $data->special_instructions }}

                                                    </div>



                                                </td>



                                            </tr>



                                        @endif



                                    </table>



                                </div>



                            </div>





                            {{-- ROUTE --}}



                            <div class="bn-section">



                                <div class="bn-section-header">



                                    <i class="fas fa-map-marked-alt"></i>



                                    <h5>

                                        Route & Stops Information

                                    </h5>



                                </div>





                                <div class="bn-section-body">



                                    <table class="table bn-detail-table">



                                        <tr>



                                            <th>

                                                <i class="fas fa-map-marker-alt"></i>

                                                Pickup Address

                                            </th>



                                            <td>

                                                <strong class="bn-pickup">

                                                    {{ $data->pickup }}

                                                </strong>

                                            </td>



                                        </tr>





                                        {{-- VIA LOCATIONS --}}



                                        @if($data->vias && is_array($data->vias) && count($data->vias) > 2)



                                            @foreach($data->vias as $key => $via)



                                                @if($key > 0 && $key < count($data->vias) - 1)



                                                    <tr>



                                                        <th>

                                                            Via Stop {{ $key }}

                                                        </th>



                                                        <td>



                                                            <div class="bn-via">



                                                                <span class="bn-via-dot"></span>



                                                                {{ $via }}



                                                            </div>



                                                        </td>



                                                    </tr>



                                                @endif



                                            @endforeach



                                        @endif





                                        <tr>



                                            <th>

                                                <i class="fas fa-map-pin"></i>

                                                Dropoff Address

                                            </th>



                                            <td>

                                                <strong class="bn-dropoff">

                                                    {{ $data->dropoff }}

                                                </strong>

                                            </td>



                                        </tr>





                                        <tr>



                                            <th>

                                                Pickup Date & Time

                                            </th>



                                            <td>



                                                <span class="bn-date-badge">



                                                    <i class="far fa-calendar-alt"></i>



                                                    {{ $data->pickup_date }}



                                                </span>



                                                <span class="bn-date-badge">



                                                    <i class="far fa-clock"></i>



                                                    {{ $data->pickup_time }}



                                                </span>



                                            </td>



                                        </tr>





                                        @if($data->is_return == 1)



                                            <tr>



                                                <th>

                                                    Return Date & Time

                                                </th>



                                                <td>



                                                    <span class="bn-date-badge bn-return-badge">



                                                        <i class="far fa-calendar-check"></i>



                                                        {{ $data->return_date }}



                                                    </span>



                                                    <span class="bn-date-badge bn-return-badge">



                                                        <i class="far fa-clock"></i>



                                                        {{ $data->return_time }}



                                                    </span>



                                                </td>



                                            </tr>



                                        @endif





                                        <tr>



                                            <th>

                                                Distance / Estimate

                                            </th>



                                            <td>

                                                <strong>

                                                    {{ $data->distance }}

                                                </strong>

                                                miles

                                            </td>



                                        </tr>



                                    </table>



                                </div>



                            </div>



                        </div>





                        {{-- =================================================

                            RIGHT SIDE

                        ================================================== --}}



                        <div class="col-lg-5">





                            {{-- MAP --}}



                            <div class="bn-section">



                                <div class="bn-section-header">



                                    <i class="fas fa-map"></i>



                                    <h5>

                                        Proposed Journey Map

                                    </h5>



                                </div>





                                @php



                                    $pickup = $data->pickup ?? '';



                                    $dropoff = $data->dropoff ?? '';



                                    $vias = $data->vias;



                                    $saddr = rawurlencode($pickup);



                                    if (is_array($vias) && count($vias) > 1) {



                                        $daddr_parts = array_slice($vias, 1);



                                        $daddr = implode(

                                            '+to:',

                                            array_map(

                                                'rawurlencode',

                                                $daddr_parts

                                            )

                                        );



                                    } else {



                                        $daddr = rawurlencode($dropoff);



                                    }



                                    $mapUrl =

                                        "https://maps.google.com/maps?f=d&source=s_d&dirflg=d&saddr="

                                        . $saddr

                                        . "&daddr="

                                        . $daddr

                                        . "&hl=en&output=embed";



                                @endphp





                                <div class="bn-map-wrapper">



                                    <iframe

                                        src="{{ $mapUrl }}"

                                        frameborder="0"

                                        allowfullscreen

                                    ></iframe>



                                </div>



                            </div>





                            {{-- PAYMENT --}}



                            <div class="bn-section">



                                <div class="bn-section-header">



                                    <i class="fas fa-credit-card"></i>



                                    <h5>

                                        Payment & Billing

                                    </h5>



                                </div>





                                <div class="bn-section-body">



                                    <table class="table bn-detail-table">

                                        <tr>
                                            <th>Payment Method</th>
                                            <td><strong>{{ $data->payment_method_display }}</strong></td>
                                        </tr>

                                        <tr>
                                            <th>Payment Status</th>
                                            <td>
                                                <span class="badge {{ $data->payment_status_badge }}" style="font-size:11px; padding:6px 10px;">
                                                    {{ $data->payment_status_label }}
                                                </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Total Booking Amount</th>
                                            <td><div class="bn-price">£{{ number_format((float) $data->price, 2) }}</div></td>
                                        </tr>

                                        <tr>
                                            <th>Amount Paid</th>
                                            <td><strong style="color:#16a34a;">£{{ number_format((float) $data->amount_paid, 2) }}</strong></td>
                                        </tr>

                                        <tr>
                                            <th>Outstanding Balance</th>
                                            <td>
                                                <strong style="color:{{ $data->outstandingBalance() > 0 ? '#dc2626' : '#16a34a' }};">
                                                    £{{ number_format($data->outstandingBalance(), 2) }}
                                                </strong>
                                            </td>
                                        </tr>

                                        @if($data->payment_actual_method)
                                            <tr>
                                                <th>Method Actually Used</th>
                                                <td>{{ $data->payment_actual_method_label }}</td>
                                            </tr>
                                        @endif

                                        @if($data->payment_date)
                                            <tr>
                                                <th>Payment Date</th>
                                                <td>{{ \Carbon\Carbon::parse($data->payment_date)->format('d M Y H:i') }}</td>
                                            </tr>
                                        @endif

                                        @if($data->payment_confirmed_by)
                                            <tr>
                                                <th>Payment Confirmed By</th>
                                                <td>{{ $data->payment_confirmed_by }}</td>
                                            </tr>
                                        @endif

                                        @if($data->payment_notes)
                                            <tr>
                                                <th>Payment Notes</th>
                                                <td>{{ $data->payment_notes }}</td>
                                            </tr>
                                        @endif

                                        @if($data->refund_status)
                                            <tr>
                                                <th>Refund Status</th>
                                                <td>
                                                    <span class="bn-payment-pending" style="background:#fff1f1; color:#dc2626;">
                                                        {{ $data->refund_status }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @if($data->refund_amount)
                                                <tr>
                                                    <th>Refunded Amount</th>
                                                    <td><strong style="color:#dc2626;">£{{ number_format($data->refund_amount, 2) }}</strong></td>
                                                </tr>
                                            @endif
                                        @endif

                                    </table>



                                </div>



                            </div>


                            {{-- MANAGE PAYMENT --}}

                            <div class="bn-section">

                                <div class="bn-section-header">
                                    <i class="fas fa-hand-holding-usd"></i>
                                    <h5>Manage Payment</h5>
                                </div>

                                <div class="bn-section-body" style="padding:16px;">

                                    <p style="font-size:11px; color:#64748b; margin:0 0 12px;">
                                        Record what the customer has actually paid. This never touches Stripe.
                                    </p>

                                    <form action="{{ route('admin.book.payment', $data->id) }}" method="POST">
                                        @csrf

                                        <div style="margin-bottom:10px;">
                                            <label class="bn-modal-label">Payment status</label>
                                            <select name="payment_status" class="bn-modal-textarea" style="height:auto;">
                                                @foreach(\App\Models\Book::PAYMENT_STATUSES as $k => $lbl)
                                                    <option value="{{ $k }}" {{ $data->payment_status === $k ? 'selected' : '' }}>{{ $lbl }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div style="display:flex; gap:10px; margin-bottom:10px;">
                                            <div style="flex:1;">
                                                <label class="bn-modal-label">Amount paid (£)</label>
                                                <input type="number" step="0.01" min="0" name="amount_paid"
                                                       value="{{ (float) $data->amount_paid }}"
                                                       class="bn-modal-textarea" style="height:auto;">
                                            </div>
                                            <div style="flex:1;">
                                                <label class="bn-modal-label">Payment date</label>
                                                <input type="datetime-local" name="payment_date"
                                                       value="{{ $data->payment_date ? \Carbon\Carbon::parse($data->payment_date)->format('Y-m-d\TH:i') : '' }}"
                                                       class="bn-modal-textarea" style="height:auto;">
                                            </div>
                                        </div>

                                        <div style="margin-bottom:10px;">
                                            <label class="bn-modal-label">Method actually used</label>
                                            <select name="payment_actual_method" class="bn-modal-textarea" style="height:auto;">
                                                <option value="">— Same as booked ({{ $data->payment_method_label }}) —</option>
                                                @foreach(\App\Models\Book::PAYMENT_METHODS as $k => $lbl)
                                                    <option value="{{ $k }}" {{ $data->payment_actual_method === $k ? 'selected' : '' }}>{{ $lbl }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div style="margin-bottom:12px;">
                                            <label class="bn-modal-label">Payment notes</label>
                                            <input type="text" name="payment_notes" value="{{ $data->payment_notes }}"
                                                   class="bn-modal-textarea" style="height:auto;"
                                                   placeholder="e.g. Cash collected by driver on arrival">
                                        </div>

                                        <button type="submit" class="btn btn-success btn-block font-weight-bold">
                                            <i class="fas fa-save"></i> Save Payment Details
                                        </button>
                                    </form>

                                </div>

                            </div>






                            {{-- FLIGHT --}}



                            @if(!empty($data->flight_number))



                                <div class="bn-section">



                                    <div class="bn-section-header">



                                        <i class="fas fa-plane"></i>



                                        <h5>

                                            Flight Details

                                        </h5>



                                    </div>





                                    <div class="bn-section-body">



                                        <table class="table bn-detail-table">



                                            <tr>

                                                <th>Flight Number</th>

                                                <td>

                                                    {{ $data->flight_number }}

                                                </td>

                                            </tr>



                                            <tr>

                                                <th>Airline</th>

                                                <td>

                                                    {{ $data->airline }}

                                                </td>

                                            </tr>



                                            <tr>

                                                <th>Airport</th>

                                                <td>

                                                    {{ $data->flight_airport ?? 'N/A' }}

                                                </td>

                                            </tr>



                                            <tr>

                                                <th>Direction</th>

                                                <td>

                                                    {{ $data->flight_direction ?? 'N/A' }}

                                                </td>

                                            </tr>



                                            <tr>

                                                <th>Origin / Destination</th>

                                                <td>

                                                    {{ $data->flight_origin_destination ?? 'N/A' }}

                                                </td>

                                            </tr>



                                            <tr>

                                                <th>Scheduled Time</th>

                                                <td>

                                                    {{ $data->flight_scheduled_time ?? 'N/A' }}

                                                </td>

                                            </tr>



                                        </table>



                                    </div>



                                </div>



                            @endif



                        </div>



                    </div>





                    {{-- =====================================================

                        TIMELINE

                    ====================================================== --}}



                    <div class="bn-timeline-card">



                        <div class="bn-timeline-header">



                            <h5>

                                <i class="fas fa-history mr-2"></i>



                                Booking Audit Log & Action History

                            </h5>



                        </div>





                        <div class="bn-timeline-body">



                            @if($data->timeline && is_array($data->timeline) && count($data->timeline) > 0)



                                <div class="bn-timeline">



                                    @foreach($data->timeline as $log)



                                        <div class="bn-timeline-item">



                                            <div class="bn-timeline-dot"></div>





                                            <div class="bn-timeline-time">



                                                <i class="far fa-clock"></i>



                                                {{ $log['timestamp'] }}



                                                &nbsp; • &nbsp;



                                                Actor:



                                                <em>

                                                    {{ $log['actor'] ?? 'System' }}

                                                </em>



                                            </div>





                                            <div class="bn-timeline-event">



                                                {{ $log['event'] }}



                                            </div>





                                            @if(!empty($log['details']))



                                                <div class="bn-timeline-details">



                                                    {{ $log['details'] }}



                                                </div>



                                            @endif



                                        </div>



                                    @endforeach



                                </div>



                            @else



                                <div

                                    style="

                                        text-align:center;

                                        padding:35px 15px;

                                        color:#94a3b8;

                                    "

                                >



                                    <i

                                        class="fas fa-history"

                                        style="

                                            font-size:30px;

                                            margin-bottom:10px;

                                        "

                                    ></i>



                                    <div>

                                        No actions logged against this booking request yet.

                                    </div>



                                </div>



                            @endif



                        </div>



                    </div>



                </div>



            </div>



        </div>



    </div>



</div>





{{-- =========================================================

    REJECTION REASON MODAL

========================================================= --}}



<div

    class="modal fade"

    id="rejectModal"

    tabindex="-1"

    role="dialog"

    aria-labelledby="rejectModalLabel"

    aria-hidden="true"

>



    <div class="modal-dialog modal-dialog-centered">



        <div class="modal-content bn-modal-content">



            <form

                action="{{ route('admin.book.reject', $data->id) }}"

                method="POST"

            >



                @csrf





                <div class="modal-header bn-modal-header">



                    <h5

                        class="modal-title"

                        id="rejectModalLabel"

                    >



                        <i class="fas fa-ban mr-2"></i>



                        Reject Booking Request



                    </h5>





                    <button

                        type="button"

                        class="close text-white"

                        data-dismiss="modal"

                        aria-label="Close"

                    >



                        <span aria-hidden="true">

                            &times;

                        </span>



                    </button>



                </div>





                <div class="bn-modal-body">



                    <label

                        for="rejection_reason"

                        class="bn-modal-label"

                    >

                        Please enter the reason for rejection *

                    </label>





                    <textarea

                        name="rejection_reason"

                        id="rejection_reason"

                        data-no-richtext

                        class="bn-modal-textarea"

                        rows="5"

                        required

                        placeholder="e.g. Unfortunately, no drivers are available at this time."

                    ></textarea>



                </div>





                <div class="modal-footer bn-modal-footer">



                    <button

                        type="button"

                        class="btn btn-secondary"

                        data-dismiss="modal"

                    >

                        Close

                    </button>





                    <button

                        type="submit"

                        class="btn btn-danger font-weight-bold"

                    >



                        <i class="fas fa-times mr-1"></i>



                        Confirm Reject & Refund



                    </button>



                </div>



            </form>



        </div>



    </div>



</div>





{{-- =========================================================

    CANCELLATION REASON MODAL

========================================================= --}}



<div

    class="modal fade"

    id="cancelModal"

    tabindex="-1"

    role="dialog"

    aria-labelledby="cancelModalLabel"

    aria-hidden="true"

>



    <div class="modal-dialog modal-dialog-centered">



        <div class="modal-content bn-modal-content">



            <form

                action="{{ route('admin.book.cancel', $data->id) }}"

                method="POST"

            >



                @csrf





                <div class="modal-header bn-modal-header">



                    <h5

                        class="modal-title"

                        id="cancelModalLabel"

                    >



                        <i class="fas fa-times-circle mr-2"></i>



                        Cancel Booking



                    </h5>





                    <button

                        type="button"

                        class="close text-white"

                        data-dismiss="modal"

                        aria-label="Close"

                    >



                        <span aria-hidden="true">

                            &times;

                        </span>



                    </button>



                </div>





                <div class="bn-modal-body">



                    <label

                        for="cancellation_reason"

                        class="bn-modal-label"

                    >

                        Please enter the reason for cancellation *

                    </label>





                    <textarea

                        name="cancellation_reason"

                        id="cancellation_reason"

                        data-no-richtext

                        class="bn-modal-textarea"

                        rows="5"

                        required

                        placeholder="e.g. Customer requested cancellation, Vehicle breakdown..."

                    ></textarea>



                </div>





                <div class="modal-footer bn-modal-footer">



                    <button

                        type="button"

                        class="btn btn-secondary"

                        data-dismiss="modal"

                    >

                        Close

                    </button>





                    <button

                        type="submit"

                        class="btn btn-danger font-weight-bold"

                    >



                        <i class="fas fa-times mr-1"></i>



                        Confirm Cancel & Refund



                    </button>



                </div>



            </form>



        </div>



    </div>



</div>


{{-- ============================================================
     Safety net for the Reject / Cancel modals.

     The admin layout has historically loaded jQuery twice (the 2nd
     load, after Bootstrap, wiped $.fn.modal). The load order is now
     fixed in admin/include/sidebar.blade.php, but this vanilla
     fallback keeps the modals working even if Bootstrap's modal
     plugin is unavailable for any reason. It stays dormant when
     Bootstrap's modal plugin is present.
============================================================ --}}
<script>
(function () {
    if (window.jQuery && window.jQuery.fn && window.jQuery.fn.modal) { return; }

    var IDS = ['#rejectModal', '#cancelModal'];

    function backdrops() { return document.querySelectorAll('.modal-backdrop, [data-bn-backdrop]'); }
    function anyOpen() { return document.querySelector('#rejectModal.show, #cancelModal.show'); }

    function open(modal) {
        if (!modal) { return; }
        closeAll();
        modal.style.display = 'block';
        modal.classList.add('show');
        modal.removeAttribute('aria-hidden');
        modal.setAttribute('aria-modal', 'true');
        document.body.classList.add('modal-open');
        var bd = document.createElement('div');
        bd.className = 'modal-backdrop fade show';
        bd.setAttribute('data-bn-backdrop', '');
        document.body.appendChild(bd);
        var field = modal.querySelector('textarea, input:not([type=hidden]), select');
        if (field) { try { field.focus(); } catch (e) {} }
    }

    function close(modal) {
        if (!modal) { return; }
        modal.style.display = 'none';
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        modal.removeAttribute('aria-modal');
        if (!anyOpen()) {
            document.body.classList.remove('modal-open');
            backdrops().forEach(function (b) { b.remove(); });
        }
    }

    function closeAll() {
        IDS.forEach(function (sel) { close(document.querySelector(sel)); });
    }

    // Capture phase: run before (and pre-empt) any stale Bootstrap
    // document-level delegated handler.
    document.addEventListener('click', function (e) {
        var trigger = e.target.closest('[data-target="#rejectModal"], [data-target="#cancelModal"]');
        if (trigger) {
            e.preventDefault();
            e.stopImmediatePropagation();
            open(document.querySelector(trigger.getAttribute('data-target')));
            return;
        }
        var dismiss = e.target.closest('#rejectModal [data-dismiss="modal"], #cancelModal [data-dismiss="modal"]');
        if (dismiss) {
            e.preventDefault();
            e.stopImmediatePropagation();
            close(dismiss.closest('.modal'));
            return;
        }
        if (e.target.classList && e.target.classList.contains('modal') &&
            (e.target.id === 'rejectModal' || e.target.id === 'cancelModal')) {
            close(e.target);
        }
    }, true);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' || e.keyCode === 27) {
            var m = anyOpen();
            if (m) { close(m); }
        }
    });
})();
</script>