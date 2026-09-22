@include('admin.include.sidebar')

<!-- Page Content -->
<div class="wrapper">

    <div id="content">

        <!-- Page Header -->
        <div class="create-page-header">

            <div>
                <h4>
                    <i class="fas fa-user-plus"></i>
                    Add New Customer
                </h4>

                <p>Create a new customer account</p>
            </div>

            <a href="{{ route('admcustomer.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Customers
            </a>

        </div>


        <!-- Create Customer Card -->
        <div class="create-card">

            <form action="{{ route('admcustomer.store') }}" method="POST">

                @csrf

                <div class="row">

                    <!-- Name -->
                    <div class="col-md-6 form-group">

                        <label>
                            <i class="fas fa-user"></i>
                            Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="name"
                            placeholder="Enter customer name"
                            required
                        >

                    </div>


                    <!-- Email -->
                    <div class="col-md-6 form-group">

                        <label>
                            <i class="fas fa-envelope"></i>
                            Email
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            name="email"
                            placeholder="Enter email address"
                            required
                        >

                    </div>


                    <!-- Phone -->
                    <div class="col-md-6 form-group">

                        <label>
                            <i class="fas fa-phone"></i>
                            Phone
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="phone"
                            placeholder="Enter phone number"
                            required
                        >

                    </div>


                    <!-- Password -->
                    <div class="col-md-6 form-group">

                        <label>
                            <i class="fas fa-lock"></i>
                            Password
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            name="password"
                            placeholder="Enter password"
                            required
                        >

                    </div>


                    <!-- Address -->
                    <div class="col-md-12 form-group">

                        <label>
                            <i class="fas fa-map-marker-alt"></i>
                            Address
                        </label>

                        <textarea
                            class="form-control address-box"
                            name="address"
                            placeholder="Enter customer address"
                        ></textarea>

                    </div>

                </div>


                <!-- Form Footer -->
                <div class="form-footer">

                    <a
                        href="{{ route('admcustomer.index') }}"
                        class="cancel-btn"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="create-btn"
                    >
                        <i class="fas fa-user-plus"></i>
                        Create Customer
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<style>





</style>