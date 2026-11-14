@stylesheet('goods/css/partials/dashboad-menu.css')


<div class="bntx-user-nav">

    <ul class="bntx-user-list">


        <!-- DASHBOARD -->

        <li class="bntx-user-item">

            <a
                class="bntx-user-link {{ Request::is('user-account') ? 'is-active' : '' }}"
                href="{{ url('user-account') }}"
            >

                <span class="bntx-user-icon">

                    <svg viewBox="0 0 24 24">

                        <path d="M3 10.5L12 3l9 7.5"></path>

                        <path d="M5 9.5V21h14V9.5"></path>

                        <path d="M9 21v-7h6v7"></path>

                    </svg>

                </span>


                <span class="bntx-user-label">
                    Dashboard
                </span>


                <span class="bntx-user-arrow">

                    <svg viewBox="0 0 24 24">

                        <path d="M9 18l6-6-6-6"></path>

                    </svg>

                </span>

            </a>

        </li>


        <!-- BOOKINGS -->

        <li class="bntx-user-item">

            <a
                class="bntx-user-link {{ Request::is('my-booking') ? 'is-active' : '' }}"
                href="{{ url('my-booking') }}"
            >

                <span class="bntx-user-icon">

                    <svg viewBox="0 0 24 24">

                        <path d="M5 17h14"></path>

                        <path d="M6 17l1-6h10l1 6"></path>

                        <path d="M8 11l1.2-3h5.6l1.2 3"></path>

                        <circle cx="8" cy="17.5" r="1.5"></circle>

                        <circle cx="16" cy="17.5" r="1.5"></circle>

                    </svg>

                </span>


                <span class="bntx-user-label">
                    Bookings
                </span>


                <span class="bntx-user-arrow">

                    <svg viewBox="0 0 24 24">

                        <path d="M9 18l6-6-6-6"></path>

                    </svg>

                </span>

            </a>

        </li>


        <!-- PROFILE -->

        <li class="bntx-user-item">

            <a
                class="bntx-user-link {{ Request::is('my-profile') ? 'is-active' : '' }}"
                href="{{ url('my-profile') }}"
            >

                <span class="bntx-user-icon">

                    <svg viewBox="0 0 24 24">

                        <circle cx="12" cy="8" r="3.5"></circle>

                        <path d="M5 21c.7-4 3-6 7-6s6.3 2 7 6"></path>

                    </svg>

                </span>


                <span class="bntx-user-label">
                    Profile
                </span>


                <span class="bntx-user-arrow">

                    <svg viewBox="0 0 24 24">

                        <path d="M9 18l6-6-6-6"></path>

                    </svg>

                </span>

            </a>

        </li>


        <!-- CHANGE PASSWORD -->

        <li class="bntx-user-item">

            <a
                class="bntx-user-link {{ Request::is('user-change-password') ? 'is-active' : '' }}"
                href="{{ url('user-change-password') }}"
            >

                <span class="bntx-user-icon">

                    <svg viewBox="0 0 24 24">

                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>

                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>

                    </svg>

                </span>


                <span class="bntx-user-label">
                    Change Password
                </span>


                <span class="bntx-user-arrow">

                    <svg viewBox="0 0 24 24">

                        <path d="M9 18l6-6-6-6"></path>

                    </svg>

                </span>

            </a>

        </li>


        <!-- LOGOUT -->

        <li class="bntx-user-item bntx-user-logout">

            <a
                class="bntx-user-link logout-style"
                href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
            >

                <span class="bntx-user-icon">

                    <svg viewBox="0 0 24 24">

                        <path d="M10 4H5v16h5"></path>

                        <path d="M14 8l4 4-4 4"></path>

                        <path d="M18 12H9"></path>

                    </svg>

                </span>


                <span class="bntx-user-label">
                    Logout
                </span>


                <span class="bntx-user-arrow">

                    <svg viewBox="0 0 24 24">

                        <path d="M9 18l6-6-6-6"></path>

                    </svg>

                </span>

            </a>


            <form
                id="logout-form"
                action="{{ route('logout') }}"
                method="POST"
                class="d-none"
            >

                @csrf

            </form>

        </li>


    </ul>

</div>
