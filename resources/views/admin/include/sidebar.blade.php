<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

{{-- <title>Collapsible sidebar using Bootstrap 4</title> --}}

<!-- Bootstrap CSS CDN -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
<!-- Our Custom CSS -->
<link rel="stylesheet" href="{{url('/admin/css/custom.css')}}">

<!-- Font Awesome JS -->
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
<!-- jQuery (full build) - MUST load before Popper/Bootstrap so Bootstrap's
     plugins (.modal, .alert, ...) bind to this jQuery instance. Loading jQuery
     a second time after Bootstrap wipes those plugins and breaks the modals. -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

<!-- CKEditor 5 Classic CDN -->
<script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@35.0.1/build/ckeditor.js"></script>

<script>
    let editors = [];

    document.addEventListener("DOMContentLoaded", function () {
        // Opt a textarea out of the rich-text editor with data-no-richtext.
        const rtTargets = Array.from(document.querySelectorAll('textarea:not([data-no-richtext])'));

        rtTargets.forEach((el, index) => {
            ClassicEditor.create(el).then(editor => {
                editors[index] = editor;
            });
        });

        document.querySelector('form')?.addEventListener('submit', function () {
            editors.forEach((editor, index) => {
                if (rtTargets[index]) rtTargets[index].value = editor.getData();
            });
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('active');
        });
    });

    // $(document).ready(function() {
    //     $('#example').DataTable();
    // });

    $(document).ready(function() {
        $('#example').DataTable({
            "order": [[0, "desc"]] // 0 = first column, "desc" = descending
        });
    });
</script>

<style>
    /* =========================================
   STANDARD ADMIN SIDEBAR
   Royal Blue + White Theme
   ========================================= */

#sidebar {
    min-width: 250px;
    max-width: 250px;
    min-height: 100vh;

    background: #0d6efd;
    color: #ffffff;

    transition: all 0.3s ease;
}

/* Sidebar Header / App Name */
#sidebar .components > p {
    color: #ffffff;
    font-size: 20px;
    font-weight: 600;
    padding: 22px 15px;
    margin: 0;
    letter-spacing: 0.3px;
}

/* All menu links */
#sidebar ul li a {
    display: flex;
    align-items: center;

    padding: 14px 20px;

    color: #ffffff;
    background: transparent;

    font-size: 16px;
    font-weight: 500;

    text-decoration: none;

    border-radius: 0;
    transition: all 0.2s ease;
}

/* Icons */
#sidebar ul li a i {
    width: 24px;
    min-width: 24px;

    margin-right: 16px !important;

    color: #ffffff;
    font-size: 16px;
    text-align: center;
}

/* Hover */
#sidebar ul li a:hover {
    background: rgba(255, 255, 255, 0.15);
    color: #ffffff;
}

/* Hover icon */
#sidebar ul li a:hover i {
    color: #ffffff;
}

/* =========================================
   ACTIVE MENU
   Dynamic active class already exists
   ========================================= */

#sidebar ul li.active > a {
    background: #ffffff;
    color: #0d6efd;

    font-weight: 600;

    border-radius: 0;
}

/* Active icon */
#sidebar ul li.active > a i {
    color: #0d6efd;
}

/* =========================================
   Sidebar Collapse
   ========================================= */

#sidebar.active {
    min-width: 80px;
    max-width: 80px;
    text-align: center;
}

/* Hide text when collapsed */
#sidebar.active .components > p {
    font-size: 0;
    padding: 20px 0;
}

/* Center icons when collapsed */
#sidebar.active ul li a {
    justify-content: center;
    padding: 15px 10px;
}

/* Remove icon spacing when collapsed */
#sidebar.active ul li a i {
    margin-right: 0 !important;
}

/* Hide menu text when collapsed */
#sidebar.active ul li a {
    font-size: 0;
}

#sidebar.active ul li a i {
    font-size: 18px;
}

/* Active collapsed item */
#sidebar.active ul li.active > a {
    background: #ffffff;
    color: #0d6efd;
}

/* =========================================
   Logout
   ========================================= */

#sidebar ul li:last-child {
    margin-top: 10px;
}

#sidebar ul li:last-child a {
    border-top: 1px solid rgba(255, 255, 255, 0.15);
}


/* =========================================
   Mobile / Responsive
   ========================================= */

@media (max-width: 768px) {

    #sidebar {
        min-width: 220px;
        max-width: 220px;
    }

    #sidebar.active {
        margin-left: -220px;
    }

    #content {
        width: 100%;
    }
}
</style>

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <ul class="list-unstyled components">
                <p class="text-center">{{env('APP_NAME')}}</p>


                @if(auth()->user()->type  == 1)
                <li class="{{request()->routeIs('admcustomer.*') ? 'active':''}}">
                    <a href="{{route('admcustomer.index')}}">
                        <i class="fa fa-users" aria-hidden="true" style="margin-right: 20px"></i>
                        Customers
                    </a>
                </li>

                <li class="{{request()->routeIs('admdriver.*') ? 'active':''}}">
                    <a href="{{route('admdriver.index')}}">
                        <i class="fa fa-id-card" aria-hidden="true" style="margin-right: 20px"></i>
                        Driver
                    </a>
                </li>
                

                <li class="{{request()->routeIs('admin.dv.*') ? 'active':''}}">
                    <a href="{{route('admin.dv.index')}}">
                        <i class="fa fa-clipboard-check" aria-hidden="true" style="margin-right: 20px"></i>
                        Driver Verification
                    </a>
                </li>

                <li class="{{request()->routeIs('admbook.*') ? 'active':''}}">
                    <a href="{{route('admbook.index')}}">
                        <i class="fa fa-book" aria-hidden="true" style="margin-right: 20px"></i>
                        Bookings
                    </a>
                </li>

                <li class="{{request()->routeIs('admcar.*') ? 'active':''}}">
                    <a href="{{route('admcar.index')}}">
                        <i class="fa fa-car" aria-hidden="true" style="margin-right: 20px"></i>
                        Car
                    </a>
                </li>

                <li class="{{request()->routeIs('admfixedprice.*') ? 'active':''}}">
                    <a href="/admfixedprice">
                        <i class="fa fa-dollar-sign" aria-hidden="true" style="margin-right: 20px"></i>
                        Fixed Prices
                    </a>
                </li>


                <li class="{{request()->routeIs('admgallery.*') ? 'active':''}}">
                    <a href="{{route('admgallery.index')}}">
                        <i class="fa fa-images" aria-hidden="true" style="margin-right: 20px"></i>
                        Gallery
                    </a>
                </li>

                <li class="{{request()->routeIs('admblog.*') ? 'active':''}}">
                    <a href="{{route('admblog.index')}}">
                        <i class="fa fa-newspaper" aria-hidden="true" style="margin-right: 20px"></i>
                        Blog
                    </a>
                </li>

                <li class="{{request()->routeIs('admcontent.*') ? 'active':''}}">
                    <a href="{{route('admcontent.index')}}">
                        <i class="fa fa-file-alt" aria-hidden="true" style="margin-right: 20px"></i>
                        Content
                    </a>
                </li>

                <li class="{{request()->routeIs('admbanner.*') ? 'active':''}}">
                    <a href="{{route('admbanner.index')}}">
                        <i class="fa fa-image" aria-hidden="true" style="margin-right: 20px"></i>
                        Banner
                    </a>
                </li>

                <li class="{{request()->routeIs('admtestimonial.*') ? 'active':''}}">
                    <a href="{{route('admtestimonial.index')}}">
                        <i class="fa fa-quote-left" aria-hidden="true" style="margin-right: 20px"></i>
                        Testimonial
                    </a>
                </li>

                <li class="{{request()->routeIs('admin.service.*') ? 'active':''}}">
                    <a href="{{route('admin.service.index')}}">
                        <i class="fa fa-cogs" aria-hidden="true" style="margin-right: 20px"></i>
                        service
                    </a>
                </li>

                <li class="{{request()->routeIs('admin.routehandles.*') ? 'active':''}}">
                    <a href="{{route('admin.routehandles.index')}}">
                        <i class="fa fa-route" aria-hidden="true" style="margin-right: 20px"></i>
                        route Handles description
                    </a>
                </li>

                <li class="{{request()->routeIs('admin.pagefaqs.*') ? 'active':''}}">
                    <a href="{{route('admin.pagefaqs.index')}}">
                        <i class="fa fa-question-circle" aria-hidden="true" style="margin-right: 20px"></i>
                        Page FAQs
                    </a>
                </li>

                               
                @elseif(auth()->user()->type  == 2)
                @if(auth()->user()->status == 1)
                @php
                    $ddBlockedFromJobs = app(\App\Services\DriverVerificationService::class)->blocksNewJobs(auth()->user());
                @endphp
                <li class="{{request()->routeIs('driver-booking.*') ? 'active':''}}">
                    <a href="{{route('driver-booking.index')}}">
                        <i class="fa fa-book" aria-hidden="true" style="margin-right: 20px"></i>
                        Booking
                        @if($ddBlockedFromJobs)
                            <i class="fa fa-exclamation-triangle" title="Blocked - a required document needs attention" style="margin-left: 8px; color: #ffd54a;"></i>
                        @endif
                    </a>
                </li>

                <li class="{{request()->routeIs('driver-accepted-booking.*') ? 'active':''}}">
                    <a href="{{route('driver-accepted-booking.index')}}">
                        <i class="fa fa-check-square" aria-hidden="true" style="margin-right: 20px"></i>
                        Accepted Booking
                    </a>
                </li>
                {{-- <li class="{{request()->route()->getName() == 'admweek.index' ? 'active':''}}">
                    <a href="{{route('admweek.index')}}">
                        <i class="fa fa-calendar-alt" aria-hidden="true" style="margin-right: 20px"></i>
                        Week
                    </a>
                </li>

                <li class="{{request()->route()->getName() == 'admholiday.index' ? 'active':''}}">
                    <a href="{{route('admholiday.index')}}">
                        <i class="fa fa-calendar-times" aria-hidden="true" style="margin-right: 20px"></i>
                        Holiday
                    </a>
                </li>  --}}
                @endif
                {{-- Documents stay available to drivers who registered but aren't active yet. --}}
                <li class="{{request()->routeIs('driver.docs.*') ? 'active':''}}">
                    <a href="{{route('driver.docs.index')}}">
                        <i class="fa fa-file-alt" aria-hidden="true" style="margin-right: 20px"></i>
                        My Documents
                    </a>
                </li>
                @if(auth()->user()->status == 1)
                <li class="{{request()->routeIs('driveraccount') ? 'active':''}}">
                    <a href="{{route('driveraccount')}}">
                        <i class="fa fa-user" aria-hidden="true" style="margin-right: 20px"></i>
                        My Account
                    </a>
                </li>
                <li class="{{request()->routeIs('driverchangepass') ? 'active':''}}">
                    <a href="{{route('driverchangepass')}}">
                        <i class="fa fa-lock" aria-hidden="true" style="margin-right: 20px"></i>
                        Change Password
                    </a>
                </li>
                @endif
                @endif
                <li>
                    <a href="{{ route('logout') }}"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out-alt" aria-hidden="true" style="margin-right: 20px"></i>
                        Logout
                    </a>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                </li>
            </ul>
                
                
        </nav>
        <div id="content">
        


            <style>
                .navbar-expand-lg {
                    padding: 15px;
                    margin-bottom: 0;
                    box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
                }
                li a i{
                    margin-right: 20px;
                }

                .list-unstyled i{
                    margin-right: 20px;
                }
                input[type='submit']{
                    text-transform: capitalize;
                }
                .btn-warning {
                    color: #fff !important;
                    background-color: red !important;
                    border-color: red !important;
                }
                .rounded{
                    margin: 0 auto;
                }
            </style>
            <script>
                $('.alert').alert()
            </script>
