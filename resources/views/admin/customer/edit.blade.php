@include('admin.include.sidebar')

<!-- Page Content -->
<div class="wrapper">

    <div id="content">

        <!-- Page Header -->
        <div class="edit-page-header">
            <div>
                <h4>
                    <i class="fas fa-user-edit"></i>
                    Edit Customer
                </h4>
                <p>Update customer information</p>
            </div>

            <a href="{{ route('admcustomer.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i>
                Back to Customers
            </a>
        </div>


        <!-- Edit Customer Card -->
        <div class="edit-card">

            <form action="{{ route('admcustomer.update', $data->id) }}" method="POST">

                @method('PATCH')
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
                            value="{{ $data->name }}"
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
                            value="{{ $data->email }}"
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
                            value="{{ $data->phone }}"
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
                            placeholder="Leave blank to keep current"
                        >

                        <small class="password-help">
                            Leave blank if you don't want to change the password.
                        </small>
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
                        >{{ $data->address }}</textarea>
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
                        class="update-btn"
                    >
                        <i class="fas fa-save"></i>
                        Update Customer
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<style>

/* =========================================================
   EDIT CUSTOMER PAGE
   ========================================================= */

#content {
    padding: 25px !important;
    background: #f5f7fb;
}


/* =========================================================
   PAGE HEADER
   ========================================================= */

.edit-page-header {
    background: #ffffff;

    border-radius: 12px;

    padding: 18px 22px;

    margin-bottom: 20px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    box-shadow: 0 4px 18px rgba(0, 0, 0, .06);
}


.edit-page-header h4 {
    margin: 0;

    color: #172033;

    font-size: 21px;
    font-weight: 700;
}


.edit-page-header h4 i {
    color: #0d6efd;
    margin-right: 8px;
}


.edit-page-header p {
    margin: 5px 0 0;

    color: #6b7280;

    font-size: 13px;
}


/* =========================================================
   BACK BUTTON
   ========================================================= */

.back-btn {
    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 9px 15px;

    background: #eef5ff;

    color: #0d6efd !important;

    border-radius: 7px;

    font-size: 14px;
    font-weight: 600;

    text-decoration: none !important;

    transition: .2s;
}


.back-btn:hover {
    background: #0d6efd;

    color: #ffffff !important;
}


/* =========================================================
   FORM CARD
   ========================================================= */

.edit-card {
    background: #ffffff;

    border-radius: 12px;

    padding: 30px;

    box-shadow: 0 4px 18px rgba(0, 0, 0, .06);
}


/* =========================================================
   FORM LABEL
   ========================================================= */

.edit-card label {
    display: block;

    color: #263143;

    font-size: 14px;
    font-weight: 600;

    margin-bottom: 8px;
}


.edit-card label i {
    color: #0d6efd;

    width: 18px;

    margin-right: 4px;
}


/* =========================================================
   INPUT
   ========================================================= */

.edit-card .form-control {
    height: 45px;

    border: 1px solid #dfe3ea;

    border-radius: 7px;

    padding: 10px 13px;

    color: #172033;

    font-size: 14px;

    background: #ffffff;

    box-shadow: none;

    transition: all .2s;
}


.edit-card .form-control:focus {
    border-color: #0d6efd;

    box-shadow: 0 0 0 3px rgba(13, 110, 253, .10);

    outline: none;
}


/* Placeholder */

.edit-card .form-control::placeholder {
    color: #9ca3af;
}


/* =========================================================
   ADDRESS
   ========================================================= */

.edit-card textarea.address-box {
    height: 120px;

    resize: vertical;
}


/* =========================================================
   FORM GROUP
   ========================================================= */

.edit-card .form-group {
    margin-bottom: 22px;
}


/* =========================================================
   PASSWORD HELP
   ========================================================= */

.password-help {
    display: block;

    margin-top: 6px;

    color: #8a93a2;

    font-size: 12px;
}


/* =========================================================
   FORM FOOTER
   ========================================================= */

.form-footer {
    display: flex;

    justify-content: flex-end;

    align-items: center;

    gap: 10px;

    margin-top: 5px;

    padding-top: 20px;

    border-top: 1px solid #edf0f4;
}


/* =========================================================
   CANCEL
   ========================================================= */

.cancel-btn {
    padding: 10px 20px;

    background: #f1f3f5;

    color: #495057 !important;

    border-radius: 7px;

    font-size: 14px;

    font-weight: 600;

    text-decoration: none !important;

    transition: .2s;
}


.cancel-btn:hover {
    background: #e2e6ea;

    color: #212529 !important;
}


/* =========================================================
   UPDATE BUTTON
   ========================================================= */

.update-btn {
    border: none;

    padding: 10px 20px;

    background: #0d6efd;

    color: #ffffff;

    border-radius: 7px;

    font-size: 14px;

    font-weight: 600;

    cursor: pointer;

    transition: .2s;
}


.update-btn:hover {
    background: #0756c9;

    transform: translateY(-1px);

    box-shadow: 0 4px 10px rgba(13, 110, 253, .20);
}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 768px) {

    #content {
        padding: 15px !important;
    }

    .edit-page-header {
        padding: 15px;

        align-items: flex-start;

        gap: 12px;

        flex-direction: column;
    }

    .edit-card {
        padding: 20px;
    }

    .form-footer {
        flex-direction: column-reverse;

        align-items: stretch;
    }

    .cancel-btn,
    .update-btn {
        width: 100%;

        text-align: center;

        justify-content: center;
    }
}

</style>