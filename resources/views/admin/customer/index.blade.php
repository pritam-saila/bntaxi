<style>
    
   /* =========================================================
   MODERN BN TAXI ADMIN PANEL
   Royal Blue + White Theme
   ========================================================= */

:root {
    --primary: #0d6efd;
    --primary-dark: #0756c9;
    --primary-light: #eef5ff;
    --white: #ffffff;
    --text: #172033;
    --muted: #6b7280;
    --border: #e5e7eb;
    --bg: #f5f7fb;
}


/* =========================================================
   BODY
   ========================================================= */

body {
    background: var(--bg);
    color: var(--text);
    font-family: Arial, Helvetica, sans-serif;
}


/* =========================================================
   SIDEBAR
   ========================================================= */

#sidebar {
    min-width: 250px;
    max-width: 250px;
    min-height: 100vh;

    background: var(--primary);
    color: var(--white);

    box-shadow: 3px 0 15px rgba(0, 0, 0, 0.08);

    transition: all 0.3s ease;
}


/* Logo / App Name */

#sidebar .components > p {
    background: var(--primary);
    color: #fff;

    font-size: 19px;
    font-weight: 700;

    padding: 25px 10px;
    margin: 0;

    letter-spacing: .3px;
}


/* Sidebar menu */

#sidebar ul li {
    margin: 3px 10px;
}


#sidebar ul li a {
    display: flex;
    align-items: center;

    padding: 13px 15px;

    color: #fff !important;

    font-size: 15px;
    font-weight: 600;

    text-decoration: none;

    border-radius: 8px;

    transition: all .2s ease;
}


/* Icons */

#sidebar ul li a i {
    width: 24px;
    min-width: 24px;

    margin-right: 15px !important;

    font-size: 16px;

    text-align: center;
}


/* Hover */

#sidebar ul li a:hover {
    background: rgba(255, 255, 255, .14);
    transform: translateX(2px);
}


/* Active menu */

#sidebar ul li.active > a {
    background: #fff !important;
    color: var(--primary) !important;

    box-shadow: 0 3px 10px rgba(0, 0, 0, .08);
}


#sidebar ul li.active > a i {
    color: var(--primary) !important;
}


/* Logout */

#sidebar ul li:last-child {
    margin-top: 15px;
    border-top: 1px solid rgba(255,255,255,.15);
    padding-top: 8px;
}


/* =========================================================
   CONTENT
   ========================================================= */

#content {
    width: 100%;
    padding: 20px !important;

    background: var(--bg);
}


/* =========================================================
   TOP NAVBAR
   ========================================================= */

.navbar {
    background: #fff !important;

    border: 0 !important;
    border-radius: 12px !important;

    padding: 14px 18px !important;

    margin: 20px 20px 0 20px !important;

    box-shadow: 0 4px 18px rgba(0, 0, 0, .06) !important;
}


/* Sidebar toggle button */

#sidebarCollapse {
    background: var(--primary) !important;
    border: none !important;

    width: 42px;
    height: 42px;

    border-radius: 8px !important;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #fff !important;

    box-shadow: none !important;
}


#sidebarCollapse:hover {
    background: var(--primary-dark) !important;
}


/* =========================================================
   TOP BUTTONS
   ========================================================= */

.navbar .btn-danger,
.navbar .btn-dark {
    background: var(--primary) !important;
    border: none !important;

    border-radius: 7px !important;

    font-weight: 600;

    padding: 10px 18px;
}


.navbar .btn-danger:hover,
.navbar .btn-dark:hover {
    background: var(--primary-dark) !important;
}


/* =========================================================
   ALERT
   ========================================================= */

.navbar .alert {
    margin-left: 15px;
    border-radius: 7px;
}


/* =========================================================
   TABLE CONTAINER
   ========================================================= */

#content > .navbar-expand-lg {
    background: #fff !important;

    border-radius: 12px;

    padding: 20px !important;

    margin-top: 20px;

    box-shadow: 0 4px 18px rgba(0,0,0,.06);
}


/* =========================================================
   DATATABLE
   ========================================================= */

#example {
    width: 100% !important;

    border-collapse: separate !important;
    border-spacing: 0;

    border: 1px solid var(--border);

    border-radius: 8px;
    overflow: hidden;
}


/* Table header */

#example thead th {
    background: var(--primary) !important;

    color: #fff !important;

    border: none !important;

    padding: 14px 12px !important;

    font-size: 13px;
    font-weight: 700;

    white-space: nowrap;
}


/* Table rows */

#example tbody td {
    padding: 13px 12px !important;

    vertical-align: middle !important;

    color: #263143;

    font-size: 14px;

    border-color: var(--border) !important;
}


/* Row hover */

#example tbody tr:hover {
    background: var(--primary-light) !important;
}


/* Remove old striped grey */

#example.table-striped tbody tr:nth-of-type(odd) {
    background: #fff;
}


/* =========================================================
   SEARCH + SHOW ENTRIES
   ========================================================= */

.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    margin-bottom: 15px;
}


.dataTables_wrapper .dataTables_filter input {
    border: 1px solid #d7dce5 !important;

    border-radius: 7px !important;

    padding: 7px 12px !important;

    outline: none !important;
}


.dataTables_wrapper .dataTables_filter input:focus {
    border-color: var(--primary) !important;

    box-shadow: 0 0 0 2px rgba(13,110,253,.1);
}


.dataTables_wrapper .dataTables_length select {
    border: 1px solid #d7dce5;

    border-radius: 6px;

    padding: 5px 25px 5px 8px;
}


/* =========================================================
   ACTION BUTTONS
   ========================================================= */

td.action {
    white-space: nowrap;
}


td.action .btn {
    width: 40px;
    height: 38px;

    padding: 0 !important;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    border: none !important;

    border-radius: 7px !important;

    margin-right: 5px;

    box-shadow: none !important;
}


/* Edit */

td.action .btn-info {
    background: #0d9bb5 !important;
    color: #fff !important;
}


/* Delete */

td.action .btn-warning {
    background: #ef4444 !important;
    color: #fff !important;
}


/* =========================================================
   PAGINATION
   ========================================================= */

.dataTables_wrapper .pagination {
    margin-top: 15px;
}


.dataTables_wrapper .page-item.active .page-link {
    background: var(--primary) !important;
    border-color: var(--primary) !important;
}


.dataTables_wrapper .page-link {
    color: var(--primary);

    border-radius: 6px !important;

    margin: 0 2px;
}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 768px) {

    #sidebar {
        min-width: 220px;
        max-width: 220px;
    }

    #content {
        padding: 10px !important;
    }

    .navbar {
        margin: 10px 10px 0 10px !important;
    }

    #content > .navbar-expand-lg {
        padding: 10px !important;
        overflow-x: auto;
    }

    #example {
        min-width: 850px;
    }
} 
</style>

    @include('admin.include.sidebar')
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-danger">
                <i class="fas fa-align-left"></i>
            </button>
            <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-align-justify"></i>
            </button>
                @if(session()->has('success'))
                <div class="alert alert-success mb-0 alert-dismissible fade show" role="alert">
                   {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if(session()->has('error'))
                <div class="alert alert-danger mb-0 alert-dismissible fade show" role="alert">
                   {{ session()->get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
             <a class="btn btn-danger" href='{{route("admcustomer.create")}}'>Add New Customer</a>

        </div>
    </nav>

        <!-- Page Content  -->
    <div class="wrapper">
        <!-- Sidebar  -->


        <!-- Page Content  -->
        <div id="content" style="padding: 20px 0;">
            <div class="navbar-expand-lg navbar-light bg-light">
                <table id="example" class="table table-striped table-bordered dark" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone}}</td>
                            <td>{{$item->address}}</td>
                            <td class="action">
                                    <a class="btn btn-info" href="{{route('admcustomer.edit',$item->id)}}"><i class="fas fa-edit"></i></a>
                               
                                <form action="{{ route('admcustomer.destroy', $item->id) }}" method="POST" style="display: contents;">
                                    @csrf
                                    @method('delete')
                                <button type="submit" class="btn btn-warning" onclick="return condelete()"><i class="fas fa-trash"></i></button>
                                   </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>
    </div>

    <script type="text/javascript">
        function condelete()
        {
        var message=confirm("Do you really want to delete");
        if(message==true)
        {
        return true;
        }
        else
        {
        return false;
        }
        }
        bootbox.confirm("Are you sure?", function(result) {
          Example.show("Confirm result: "+result);
        });

      </script>
