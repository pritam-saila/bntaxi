

<div class="dashboard-menu">
    <ul class="nav flex-column" role="tablist">
        <!-- <li class="nav-item">
            <a class="nav-link " href=""></i>Dashboard</a>
        </li> -->
        <li class="nav-item">
            <a class="nav-link " href="{{url('order')}}"><i class="fi-rs-shopping-bag mr-10"></i>Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{url('user-account')}}"><i class="fi-rs-user mr-10"></i>Account details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('user-change-password')}}"><i class="fi-rs-user mr-10"></i>Change Password</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fi fi-rs-sign-out mr-10"></i>Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</div> 