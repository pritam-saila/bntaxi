@include('admin.include.sidebar')

<!-- =========================================
     TOP NAVBAR
========================================= -->

<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <div class="container-fluid">

        <button type="button" id="sidebarCollapse" class="btn btn-primary">
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


        <!-- Alerts -->

        <div class="admin-alert-area">

            @if(session()->has('success'))

                <div class="alert alert-success mb-0 alert-dismissible fade show" role="alert">

                    <i class="fas fa-check-circle mr-1"></i>

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

                <div class="alert alert-danger mb-0 alert-dismissible fade show" role="alert">

                    <i class="fas fa-exclamation-circle mr-1"></i>

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


        <!-- Add Car -->

        <a
            class="btn btn-primary add-car-btn"
            href="{{ route('admcar.create') }}"
        >
            <i class="fas fa-plus mr-1"></i>
            Add New Car
        </a>

    </div>

</nav>



<!-- =========================================
     PAGE CONTENT
========================================= -->

<div class="wrapper">

    <div id="content">


        <!-- PAGE HEADER -->

        <div class="car-page-header">

            <div class="car-title">

                <div class="car-title-icon">
                    <i class="fas fa-car"></i>
                </div>

                <div>

                    <h3>Car Management</h3>

                    <p>
                        Manage cars, pricing routes and display order
                    </p>

                </div>

            </div>


            <div class="drag-info">

                <i class="fas fa-grip-vertical"></i>

                Drag rows to reorder

            </div>

        </div>



        <!-- TABLE CARD -->

        <div class="car-table-card">


            <!-- TABLE TOP -->

            <div class="table-card-top">

                <div>

                    <h5>
                        <i class="fas fa-list mr-2"></i>
                        Cars List
                    </h5>

                    <span>
                        Drag and drop to change sort order
                    </span>

                </div>


                <div class="sort-help">

                    <span class="sort-dot"></span>

                    Sort order updates automatically

                </div>

            </div>



            <!-- TABLE -->

            <div class="table-responsive">

                <table
                    id="example"
                    class="table car-table"
                    style="width:100%"
                >

                    <thead>

                        <tr>

                            <th width="80">
                                ID
                            </th>

                            <th width="130">
                                Sort Order
                            </th>

                            <th>
                                Car Name
                            </th>

                            <th width="150">
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody id="sortable-cars">

                        @foreach ($data as $item)

                        <tr
                            data-id="{{ $item->id }}"
                            class="car-row"
                        >

                            <!-- ID -->

                            <td>

                                <div class="drag-id">

                                    <span class="drag-handle">
                                        <i class="fas fa-grip-vertical"></i>
                                    </span>

                                    <span>
                                        {{ $loop->iteration }}
                                    </span>

                                </div>

                            </td>


                            <!-- SORT -->

                            <td>

                                <span class="sort-badge">

                                    <i class="fas fa-sort-numeric-down mr-1"></i>

                                    {{ $item->sort_order }}

                                </span>

                            </td>


                            <!-- CAR NAME -->

                            <td>

                                <a
                                    class="car-name"
                                    href="{{ route('admcar.admdistance.index',$item->id) }}"
                                >

                                    <span class="car-icon">
                                        <i class="fas fa-car"></i>
                                    </span>

                                    <span>
                                        {{ $item->name }}
                                    </span>

                                    <i class="fas fa-chevron-right car-arrow"></i>

                                </a>

                            </td>


                            <!-- ACTION -->

                            <td class="action">

                                <a
                                    class="action-btn edit-btn"
                                    href="{{ route('admcar.edit',$item->id) }}"
                                    title="Edit Car"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>


                                <form
                                    action="{{ route('admcar.destroy', $item->id) }}"
                                    method="POST"
                                    style="display:inline;"
                                >

                                    @csrf

                                    @method('delete')

                                    <button
                                        type="submit"
                                        class="action-btn delete-btn"
                                        onclick="return condelete()"
                                        title="Delete Car"
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
     SORTABLE JS
========================================= -->

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {

    var el = document.getElementById('sortable-cars');

    if (el) {

        Sortable.create(el, {

            animation: 200,

            handle: '.drag-handle',

            ghostClass: 'sortable-ghost',

            chosenClass: 'sortable-chosen',

            dragClass: 'sortable-drag',

            onStart: function () {

                document.body.classList.add('sorting-active');

            },

            onEnd: function () {

                document.body.classList.remove('sorting-active');

                var order = [];

                var rows = el.querySelectorAll('tr');

                rows.forEach(function (row) {

                    order.push(
                        row.getAttribute('data-id')
                    );

                });


                fetch('{{ route("admin.cars.reorder") }}', {

                    method: 'POST',

                    headers: {

                        'Content-Type': 'application/json',

                        'X-CSRF-TOKEN':
                            '{{ csrf_token() }}'

                    },

                    body: JSON.stringify({
                        order: order
                    })

                })

                .then(function (response) {

                    return response.json();

                })

                .then(function (data) {

                    if (data.success) {

                        rows.forEach(function (row, index) {

                            var badge =
                                row.querySelector('.sort-badge');

                            if (badge) {

                                badge.innerHTML =
                                    '<i class="fas fa-sort-numeric-down mr-1"></i> ' +
                                    (index + 1);

                            }

                        });

                    }

                })

                .catch(function (error) {

                    console.error(
                        'Sort update failed:',
                        error
                    );

                });

            }

        });

    }

});


/* =========================================
   DELETE CONFIRMATION
========================================= */

function condelete()
{
    return confirm("Do you really want to delete this car?");
}

</script>



<!-- =========================================
     PAGE DESIGN
========================================= -->

<style>

/* -----------------------------------------
   PAGE
----------------------------------------- */

#content {
    padding: 25px !important;
    background: #f5f7fb;
    min-height: calc(100vh - 70px);
}


/* -----------------------------------------
   TOP NAVBAR
----------------------------------------- */

.navbar {
    background: #fff !important;

    border: 0 !important;

    border-radius: 12px !important;

    margin: 20px 20px 0 20px !important;

    padding: 14px 18px !important;

    box-shadow: 0 4px 18px rgba(0,0,0,.06) !important;
}


#sidebarCollapse {
    background: #0d6efd !important;

    border: none !important;

    width: 42px;
    height: 42px;

    border-radius: 8px !important;

    color: #fff !important;
}


.add-car-btn {
    background: #0d6efd !important;

    border: none !important;

    border-radius: 7px !important;

    padding: 10px 18px !important;

    font-weight: 600;

    box-shadow: 0 3px 8px rgba(13,110,253,.18);
}


.add-car-btn:hover {
    background: #0756c9 !important;
}


/* -----------------------------------------
   HEADER
----------------------------------------- */

.car-page-header {
    background: #fff;

    padding: 22px 25px;

    border-radius: 12px;

    margin-bottom: 20px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    box-shadow: 0 4px 18px rgba(0,0,0,.06);
}


.car-title {
    display: flex;

    align-items: center;

    gap: 15px;
}


.car-title-icon {
    width: 50px;
    height: 50px;

    background: #eef5ff;

    color: #0d6efd;

    border-radius: 10px;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 22px;
}


.car-page-header h3 {
    margin: 0;

    color: #172033;

    font-size: 21px;

    font-weight: 700;
}


.car-page-header p {
    margin: 5px 0 0;

    color: #6b7280;

    font-size: 13px;
}


.drag-info {
    background: #f5f7fb;

    color: #6b7280;

    padding: 9px 13px;

    border-radius: 7px;

    font-size: 13px;

    font-weight: 600;
}


.drag-info i {
    color: #0d6efd;

    margin-right: 5px;
}


/* -----------------------------------------
   TABLE CARD
----------------------------------------- */

.car-table-card {
    background: #fff;

    border-radius: 12px;

    padding: 0;

    overflow: hidden;

    box-shadow: 0 4px 18px rgba(0,0,0,.06);
}


/* -----------------------------------------
   TABLE CARD HEADER
----------------------------------------- */

.table-card-top {
    padding: 20px 22px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    border-bottom: 1px solid #edf0f4;
}


.table-card-top h5 {
    margin: 0;

    color: #172033;

    font-size: 16px;

    font-weight: 700;
}


.table-card-top h5 i {
    color: #0d6efd;
}


.table-card-top span {
    display: block;

    margin-top: 4px;

    color: #8a93a2;

    font-size: 12px;
}


.sort-help {
    background: #eefaf3;

    color: #198754 !important;

    padding: 7px 11px;

    border-radius: 6px;

    font-size: 12px !important;

    font-weight: 600;
}


.sort-dot {
    display: inline-block;

    width: 7px;
    height: 7px;

    background: #22a06b;

    border-radius: 50%;

    margin-right: 5px;
}


/* -----------------------------------------
   TABLE
----------------------------------------- */

.car-table {
    margin: 0 !important;

    border-collapse: collapse !important;
}


.car-table thead th {
    background: #0d6efd !important;

    color: #fff !important;

    border: none !important;

    padding: 14px 16px !important;

    font-size: 12px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .3px;
}


.car-table tbody td {
    padding: 15px 16px !important;

    vertical-align: middle !important;

    border-bottom: 1px solid #edf0f4 !important;

    color: #263143;

    font-size: 14px;
}


.car-row {
    background: #fff;

    transition: all .2s ease;
}


.car-row:hover {
    background: #f8fbff !important;

    box-shadow: inset 3px 0 0 #0d6efd;
}


/* -----------------------------------------
   DRAG HANDLE
----------------------------------------- */

.drag-id {
    display: flex;

    align-items: center;

    gap: 10px;
}


.drag-handle {
    width: 28px;
    height: 28px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #f1f4f8;

    color: #8a93a2;

    border-radius: 6px;

    cursor: grab;
}


.drag-handle:hover {
    background: #eef5ff;

    color: #0d6efd;
}


.drag-handle:active {
    cursor: grabbing;
}


/* -----------------------------------------
   SORT BADGE
----------------------------------------- */

.sort-badge {
    display: inline-flex;

    align-items: center;

    background: #eef5ff;

    color: #0d6efd;

    padding: 7px 10px;

    border-radius: 6px;

    font-size: 12px;

    font-weight: 700;
}


/* -----------------------------------------
   CAR NAME
----------------------------------------- */

.car-name {
    display: inline-flex;

    align-items: center;

    gap: 10px;

    color: #172033 !important;

    text-decoration: none !important;

    font-weight: 600;

    transition: .2s;
}


.car-name:hover {
    color: #0d6efd !important;
}


.car-icon {
    width: 36px;
    height: 36px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #eef5ff;

    color: #0d6efd;

    border-radius: 8px;
}


.car-arrow {
    margin-left: 5px;

    font-size: 10px;

    color: #9ca3af;

    transition: .2s;
}


.car-name:hover .car-arrow {
    color: #0d6efd;

    transform: translateX(3px);
}


/* -----------------------------------------
   ACTION BUTTONS
----------------------------------------- */

.action {
    white-space: nowrap;
}


.action-btn {
    width: 38px;
    height: 38px;

    display: inline-flex;

    align-items: center;

    justify-content: center;

    border: none !important;

    border-radius: 7px;

    margin-right: 5px;

    color: #fff !important;

    text-decoration: none !important;

    transition: all .2s;
}


.edit-btn {
    background: #0d9bb5;
}


.edit-btn:hover {
    background: #087f95;

    transform: translateY(-1px);
}


.delete-btn {
    background: #ef4444;

    cursor: pointer;
}


.delete-btn:hover {
    background: #dc2626;

    transform: translateY(-1px);
}


/* -----------------------------------------
   SORTABLE EFFECT
----------------------------------------- */

.sortable-ghost {
    opacity: .45;

    background: #eef5ff !important;
}


.sortable-chosen {
    background: #f8fbff !important;
}


.sortable-drag {
    box-shadow: 0 10px 30px rgba(0,0,0,.15);
}


/* -----------------------------------------
   ALERT
----------------------------------------- */

.admin-alert-area {
    margin-left: auto;

    margin-right: 15px;
}


.admin-alert-area .alert {
    border-radius: 7px;

    font-size: 13px;
}


/* -----------------------------------------
   MOBILE
----------------------------------------- */

@media (max-width: 768px) {

    #content {
        padding: 15px !important;
    }


    .navbar {
        margin: 10px !important;
    }


    .car-page-header {
        padding: 18px;

        align-items: flex-start;

        flex-direction: column;

        gap: 15px;
    }


    .drag-info {
        width: 100%;

        text-align: center;
    }


    .table-card-top {
        align-items: flex-start;

        flex-direction: column;

        gap: 12px;
    }


    .sort-help {
        width: 100%;

        text-align: center;
    }


    .car-table {
        min-width: 700px;
    }


    .car-table-card {
        overflow-x: auto;
    }


    .admin-alert-area {
        display: none;
    }

}

</style>