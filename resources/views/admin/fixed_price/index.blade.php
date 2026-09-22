@include('admin.include.sidebar')

<!-- =========================================
     TOP NAVBAR
========================================= -->

<nav class="navbar navbar-expand-lg fixed-price-navbar">

    <div class="container-fluid">

        <!-- Sidebar Toggle -->
        <button
            type="button"
            id="sidebarCollapse"
            class="btn btn-primary sidebar-toggle-btn"
        >
            <i class="fas fa-align-left"></i>
        </button>


        <!-- Mobile Toggle -->
        <button
            class="btn btn-primary d-inline-block d-lg-none ml-auto mobile-menu-btn"
            type="button"
            data-toggle="collapse"
            data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <i class="fas fa-align-justify"></i>
        </button>


        <!-- Alerts -->
        <div class="fixed-price-alerts">

            @if(session()->has('success'))

                <div class="alert alert-success alert-dismissible fade show mb-0">

                    <i class="fas fa-check-circle mr-1"></i>

                    {{ session()->get('success') }}

                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                    >
                        <span>&times;</span>
                    </button>

                </div>

            @endif


            @if(session()->has('error'))

                <div class="alert alert-danger alert-dismissible fade show mb-0">

                    <i class="fas fa-exclamation-circle mr-1"></i>

                    {{ session()->get('error') }}

                    <button
                        type="button"
                        class="close"
                        data-dismiss="alert"
                    >
                        <span>&times;</span>
                    </button>

                </div>

            @endif

        </div>


        <!-- Actions -->
        <div class="fixed-price-actions">

            <!-- Add -->
            <a
                class="fp-action-btn add-btn"
                href="/admfixedprice/create"
            >
                <i class="fas fa-plus"></i>
                <span>Add Fixed Price</span>
            </a>


            <!-- Export -->
            <a
                class="fp-action-btn export-btn"
                href="{{ route('admfixedprice.export') }}"
            >
                <i class="fas fa-file-download"></i>
                <span>Export CSV</span>
            </a>


            <!-- Import -->
            <form
                action="{{ route('admfixedprice.import') }}"
                method="POST"
                enctype="multipart/form-data"
                class="import-form"
            >

                @csrf

                <label class="csv-file-box">

                    <i class="fas fa-file-csv"></i>

                    <span class="file-label">
                        Choose CSV
                    </span>

                    <input
                        type="file"
                        name="csv_file"
                        accept=".csv,text/csv"
                        required
                        onchange="showFileName(this)"
                    >

                </label>


                <button
                    type="submit"
                    class="fp-action-btn import-btn"
                >
                    <i class="fas fa-file-upload"></i>
                    <span>Import CSV</span>
                </button>

            </form>

        </div>

    </div>

</nav>



<!-- =========================================
     PAGE CONTENT
========================================= -->

<div class="wrapper">

    <div id="content">


        <!-- =========================================
             PAGE HEADER
        ========================================= -->

        <div class="fixed-price-header">

            <div class="fixed-price-title">

                <div class="fixed-price-icon">
                    <i class="fas fa-tags"></i>
                </div>

                <div>

                    <h3>Fixed Price Management</h3>

                    <p>
                        Manage destination-based fixed pricing for all cars
                    </p>

                </div>

            </div>


            <div class="price-info-badge">

                <i class="fas fa-database"></i>

                Fixed Pricing

            </div>

        </div>



        <!-- =========================================
             TABLE CARD
========================================= -->

        <div class="fixed-price-card">


            <!-- Card Header -->

            <div class="fixed-price-card-header">

                <div>

                    <h5>
                        <i class="fas fa-list mr-2"></i>
                        Fixed Prices
                    </h5>

                    <span>
                        Manage car, destination and pickup/drop pricing
                    </span>

                </div>


                <div class="pricing-legend">

                    <span>
                        <i class="fas fa-arrow-down"></i>
                        Drop Price
                    </span>

                    <span>
                        <i class="fas fa-arrow-up"></i>
                        Pickup Price
                    </span>

                </div>

            </div>



            <!-- Table -->

            <div class="table-responsive fixed-price-table-wrap">

                <table
                    id="example"
                    class="table fixed-price-table"
                    style="width:100%"
                >

                    <thead>

                        <tr>

                            <th>ID</th>

                            <th>Car</th>

                            <th>Destination</th>

                            <th>Drop Price</th>

                            <th>Pickup Price</th>

                            <th>Keywords</th>

                            <th>Action</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach ($data as $item)

                        <tr>

                            <!-- ID -->

                            <td>

                                <span class="id-badge">

                                    #{{ $loop->iteration }}

                                </span>

                            </td>


                            <!-- CAR -->

                            <td>

                                <div class="car-cell">

                                    <div class="mini-car-icon">

                                        <i class="fas fa-car"></i>

                                    </div>

                                    <span>

                                        {{ $item->car->name ?? 'N/A' }}

                                    </span>

                                </div>

                            </td>


                            <!-- DESTINATION -->

                            <td>

                                <div class="destination-cell">

                                    <i class="fas fa-map-marker-alt"></i>

                                    <span>
                                        {{ $item->destination_name }}
                                    </span>

                                </div>

                            </td>


                            <!-- DROP PRICE -->

                            <td>

                                <span class="price-badge drop-price">

                                    <i class="fas fa-arrow-down"></i>

                                    £{{ $item->drop_price }}

                                </span>

                            </td>


                            <!-- PICKUP PRICE -->

                            <td>

                                <span class="price-badge pickup-price">

                                    <i class="fas fa-arrow-up"></i>

                                    £{{ $item->pickup_price }}

                                </span>

                            </td>


                            <!-- KEYWORDS -->

                            <td>

                                @if($item->keywords)

                                    <div class="keyword-box">

                                        <i class="fas fa-key"></i>

                                        <code>
                                            {{ $item->keywords }}
                                        </code>

                                    </div>

                                @else

                                    <span class="no-keywords">
                                        No keywords
                                    </span>

                                @endif

                            </td>


                            <!-- ACTION -->

                            <td class="action">

                                <a
                                    class="fixed-action-btn edit-action"
                                    href="/admfixedprice/{{ $item->id }}/edit"
                                    title="Edit Fixed Price"
                                >

                                    <i class="fas fa-edit"></i>

                                </a>


                                <form
                                    action="/admfixedprice/{{ $item->id }}"
                                    method="POST"
                                    style="display:inline;"
                                >

                                    @csrf

                                    @method('delete')

                                    <button
                                        type="submit"
                                        class="fixed-action-btn delete-action"
                                        onclick="return condelete()"
                                        title="Delete Fixed Price"
                                    >

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>



<!-- =========================================
     JAVASCRIPT
========================================= -->

<script>

    /* -----------------------------------------
       DELETE CONFIRMATION
    ----------------------------------------- */

    function condelete()
    {
        return confirm(
            "Do you really want to delete this fixed price?"
        );
    }


    /* -----------------------------------------
       CSV FILE NAME
    ----------------------------------------- */

    function showFileName(input)
    {
        var label = input
            .closest('.csv-file-box')
            .querySelector('.file-label');

        if (input.files && input.files.length > 0) {

            label.innerText = input.files[0].name;

        } else {

            label.innerText = 'Choose CSV';

        }
    }

</script>



<!-- =========================================
     DESIGN
========================================= -->

<style>

/* =========================================
   CONTENT
========================================= */

#content {
    padding: 25px !important;

    background: #f5f7fb;

    min-height: calc(100vh - 70px);
}


/* =========================================
   TOP NAVBAR
========================================= */

.fixed-price-navbar {
    background: #ffffff !important;

    border: none !important;

    border-radius: 12px !important;

    margin: 20px 20px 0 20px !important;

    padding: 14px 18px !important;

    box-shadow: 0 4px 18px rgba(0,0,0,.06) !important;
}


.sidebar-toggle-btn {
    width: 42px;
    height: 42px;

    display: flex;

    align-items: center;

    justify-content: center;

    border: none !important;

    border-radius: 8px !important;

    background: #0d6efd !important;

    color: #fff !important;
}


.sidebar-toggle-btn:hover {
    background: #0756c9 !important;
}


/* =========================================
   ALERT
========================================= */

.fixed-price-alerts {
    margin-left: auto;

    margin-right: 15px;
}


.fixed-price-alerts .alert {
    border-radius: 7px;

    font-size: 13px;

    padding: 9px 13px;
}


/* =========================================
   ACTION AREA
========================================= */

.fixed-price-actions {

    display: flex;

    align-items: center;

    gap: 8px;

    flex-wrap: wrap;

}


.fp-action-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    padding: 10px 15px;

    border: none;

    border-radius: 7px;

    color: #fff !important;

    text-decoration: none !important;

    font-size: 13px;

    font-weight: 600;

    transition: all .2s ease;

}


.fp-action-btn:hover {

    transform: translateY(-1px);

    color: #fff !important;

}


/* Add */

.add-btn {

    background: #0d6efd;

    box-shadow: 0 3px 8px rgba(13,110,253,.15);

}


.add-btn:hover {

    background: #0756c9;

}


/* Export */

.export-btn {

    background: #0d9bb5;

}


.export-btn:hover {

    background: #087f95;

}


/* Import */

.import-btn {

    background: #198754;

}


.import-btn:hover {

    background: #157347;

}


/* =========================================
   IMPORT FORM
========================================= */

.import-form {

    display: flex;

    align-items: center;

    gap: 7px;

    margin: 0;

}


.csv-file-box {

    height: 40px;

    max-width: 190px;

    display: flex;

    align-items: center;

    gap: 7px;

    padding: 0 10px;

    background: #f5f7fb;

    border: 1px solid #dfe3ea;

    border-radius: 7px;

    margin: 0;

    cursor: pointer;

    overflow: hidden;

}


.csv-file-box i {

    color: #198754;

}


.csv-file-box .file-label {

    color: #687386;

    font-size: 12px;

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;

}


.csv-file-box input {

    display: none;

}


/* =========================================
   PAGE HEADER
========================================= */

.fixed-price-header {

    background: #fff;

    padding: 21px 24px;

    border-radius: 12px;

    margin-bottom: 20px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    box-shadow: 0 4px 18px rgba(0,0,0,.06);
}


.fixed-price-title {

    display: flex;

    align-items: center;

    gap: 15px;

}


.fixed-price-icon {

    width: 52px;
    height: 52px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #eef5ff;

    color: #0d6efd;

    border-radius: 10px;

    font-size: 22px;

}


.fixed-price-header h3 {

    margin: 0;

    color: #172033;

    font-size: 21px;

    font-weight: 700;

}


.fixed-price-header p {

    margin: 5px 0 0;

    color: #6b7280;

    font-size: 13px;

}


.price-info-badge {

    display: flex;

    align-items: center;

    gap: 7px;

    padding: 9px 13px;

    background: #eef5ff;

    color: #0d6efd;

    border-radius: 7px;

    font-size: 12px;

    font-weight: 700;

}


/* =========================================
   TABLE CARD
========================================= */

.fixed-price-card {

    background: #fff;

    border-radius: 12px;

    overflow: hidden;

    box-shadow: 0 4px 18px rgba(0,0,0,.06);
}


/* =========================================
   TABLE CARD HEADER
========================================= */

.fixed-price-card-header {

    padding: 20px 22px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    border-bottom: 1px solid #edf0f4;

}


.fixed-price-card-header h5 {

    margin: 0;

    color: #172033;

    font-size: 16px;

    font-weight: 700;

}


.fixed-price-card-header h5 i {

    color: #0d6efd;

}


.fixed-price-card-header span {

    display: block;

    margin-top: 4px;

    color: #8a93a2;

    font-size: 12px;

}


.pricing-legend {

    display: flex;

    gap: 8px;

}


.pricing-legend span {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 7px 10px;

    background: #f7f8fa;

    border-radius: 6px;

    color: #687386 !important;

    font-size: 11px !important;

    font-weight: 600;

}


.pricing-legend i {

    color: #0d6efd;

}


/* =========================================
   TABLE
========================================= */

.fixed-price-table {

    margin: 0 !important;

    border-collapse: collapse !important;

}


.fixed-price-table thead th {

    background: #0d6efd !important;

    color: #fff !important;

    border: none !important;

    padding: 14px 15px !important;

    font-size: 12px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .25px;

    white-space: nowrap;

}


.fixed-price-table tbody td {

    padding: 14px 15px !important;

    vertical-align: middle !important;

    border-bottom: 1px solid #edf0f4 !important;

    color: #263143;

    font-size: 14px;

}


.fixed-price-table tbody tr {

    background: #fff;

    transition: all .2s ease;

}


.fixed-price-table tbody tr:hover {

    background: #f8fbff !important;

    box-shadow: inset 3px 0 0 #0d6efd;

}


/* =========================================
   ID
========================================= */

.id-badge {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    min-width: 40px;

    padding: 6px 8px;

    background: #f1f4f8;

    color: #596579;

    border-radius: 6px;

    font-size: 12px;

    font-weight: 700;

}


/* =========================================
   CAR
========================================= */

.car-cell {

    display: flex;

    align-items: center;

    gap: 9px;

    font-weight: 600;

    color: #172033;

}


.mini-car-icon {

    width: 34px;
    height: 34px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #eef5ff;

    color: #0d6efd;

    border-radius: 7px;

}


/* =========================================
   DESTINATION
========================================= */

.destination-cell {

    display: flex;

    align-items: center;

    gap: 8px;

    font-weight: 500;

}


.destination-cell i {

    color: #ef4444;

    font-size: 13px;

}


/* =========================================
   PRICE
========================================= */

.price-badge {

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 7px 10px;

    border-radius: 6px;

    font-size: 13px;

    font-weight: 700;

    white-space: nowrap;

}


.drop-price {

    background: #fff4f4;

    color: #dc3545;

}


.pickup-price {

    background: #eefaf3;

    color: #198754;

}


/* =========================================
   KEYWORDS
========================================= */

.keyword-box {

    display: flex;

    align-items: flex-start;

    gap: 7px;

}


.keyword-box i {

    color: #0d6efd;

    margin-top: 3px;

    font-size: 12px;

}


.keyword-box code {

    color: #d63384;

    background: transparent;

    padding: 0;

    font-size: 12px;

    line-height: 1.5;

    word-break: break-word;

}


.no-keywords {

    color: #9ca3af;

    font-size: 12px;

    font-style: italic;

}


/* =========================================
   ACTION
========================================= */

.action {

    white-space: nowrap;

}


.fixed-action-btn {

    width: 40px;
    height: 38px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    border: none !important;

    border-radius: 7px;

    margin-right: 5px;

    color: #fff !important;

    text-decoration: none !important;

    transition: all .2s ease;

}


.edit-action {

    background: #0d9bb5;

}


.edit-action:hover {

    background: #087f95;

    transform: translateY(-1px);

}


.delete-action {

    background: #ef4444;

    cursor: pointer;

}


.delete-action:hover {

    background: #dc2626;

    transform: translateY(-1px);

}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 1100px) {

    .fixed-price-actions {

        justify-content: flex-end;

    }

    .fp-action-btn span {

        display: none;

    }

    .fp-action-btn {

        width: 40px;
        height: 40px;

        padding: 0;

    }

    .import-form {

        gap: 5px;

    }

}


@media (max-width: 768px) {

    #content {

        padding: 15px !important;

    }


    .fixed-price-navbar {

        margin: 10px !important;

    }


    .fixed-price-alerts {

        display: none;

    }


    .fixed-price-header {

        padding: 17px;

        align-items: flex-start;

        flex-direction: column;

        gap: 15px;

    }


    .price-info-badge {

        width: 100%;

        justify-content: center;

    }


    .fixed-price-card-header {

        align-items: flex-start;

        flex-direction: column;

        gap: 12px;

    }


    .pricing-legend {

        width: 100%;

    }


    .pricing-legend span {

        flex: 1;

        justify-content: center;

    }


    .fixed-price-table {

        min-width: 950px;

    }


    .fixed-price-table-wrap {

        overflow-x: auto;

    }

}

</style>