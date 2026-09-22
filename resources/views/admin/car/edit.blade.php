@include('admin.include.sidebar')

<!-- =========================================
     PAGE CONTENT
========================================= -->

<div class="wrapper">

    <div id="content">


        <!-- =========================================
             PAGE HEADER
        ========================================= -->

        <div class="car-edit-header">

            <div class="car-edit-title">

                <div class="car-edit-icon">
                    <i class="fas fa-car"></i>
                </div>

                <div>
                    <h3>Edit Car</h3>

                    <p>
                        Update vehicle information, pricing and settings
                    </p>
                </div>

            </div>


            <a
                href="{{ route('admcar.index') }}"
                class="back-btn"
            >
                <i class="fas fa-arrow-left"></i>
                Back to Cars
            </a>

        </div>



        <!-- =========================================
             FORM CARD
        ========================================= -->

        <div class="car-edit-card">

            <form
                action="{{ route('admcar.update', $data->id) }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @method('PATCH')
                @csrf


                <!-- =========================================
                     BASIC INFORMATION
                ========================================= -->

                <div class="form-section">

                    <div class="section-title">

                        <div class="section-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>

                        <div>
                            <h5>Basic Information</h5>
                            <span>Enter the main details of this car</span>
                        </div>

                    </div>


                    <div class="row">


                        <!-- NAME -->

                        <div class="col-md-6 form-group">

                            <label>
                                <i class="fas fa-car"></i>
                                Car Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $data->name }}"
                                name="name"
                                placeholder="Enter car name"
                                required
                            >

                        </div>


                        <!-- DESCRIPTION -->

                        <div class="col-md-6 form-group">

                            <label>
                                <i class="fas fa-align-left"></i>
                                Description
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $data->description }}"
                                name="description"
                                placeholder="Enter description"
                                required
                            >

                        </div>


                    </div>

                </div>



                <!-- =========================================
                     PRICING
                ========================================= -->

                <div class="form-section">

                    <div class="section-title">

                        <div class="section-icon">
                            <i class="fas fa-pound-sign"></i>
                        </div>

                        <div>
                            <h5>Pricing</h5>
                            <span>Configure car pricing and airport surcharge</span>
                        </div>

                    </div>


                    <div class="row">


                        <!-- PRICE -->

                        <div class="col-md-6 form-group">

                            <label>
                                <i class="fas fa-tag"></i>
                                Price
                            </label>

                            <div class="input-icon-wrap">

                                <span>£</span>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $data->price }}"
                                    name="price"
                                    placeholder="Enter price"
                                    required
                                >

                            </div>

                        </div>


                        <!-- MIN PRICE -->

                        <div class="col-md-6 form-group">

                            <label>
                                <i class="fas fa-money-bill-wave"></i>
                                Minimum Price
                            </label>

                            <div class="input-icon-wrap">

                                <span>£</span>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $data->minprice }}"
                                    name="minprice"
                                    placeholder="Enter minimum price"
                                    required
                                >

                            </div>

                        </div>


                        <!-- AIRPORT SURCHARGE -->

                        <div class="col-md-6 form-group">

                            <label>
                                <i class="fas fa-plane"></i>
                                Airport Surcharge
                            </label>

                            <div class="input-icon-wrap">

                                <span>£</span>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{ $data->airport_surcharge }}"
                                    name="airport_surcharge"
                                    placeholder="Enter airport surcharge"
                                    required
                                >

                            </div>

                        </div>


                        <!-- MILEAGE -->

                        <div class="col-md-6 form-group">

                            <label>
                                <i class="fas fa-road"></i>
                                Mileage Multiplier
                            </label>

                            <input
                                type="number"
                                step="0.1"
                                class="form-control"
                                value="{{ $data->mileage_multiplier }}"
                                name="mileage_multiplier"
                                placeholder="Example: 4"
                            >

                            <small class="field-help">
                                Example: 4 = ×4. Leave blank to use distance matrix.
                            </small>

                        </div>


                    </div>

                </div>



                <!-- =========================================
                     IMAGE
                ========================================= -->

                <div class="form-section">

                    <div class="section-title">

                        <div class="section-icon">
                            <i class="fas fa-image"></i>
                        </div>

                        <div>
                            <h5>Car Image</h5>
                            <span>Update the vehicle image if required</span>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-6 form-group">

                            <label>
                                <i class="fas fa-upload"></i>
                                Upload New Image
                            </label>

                            <input
                                type="file"
                                class="form-control file-input"
                                name="image"
                                accept="image/*"
                            >

                            <small class="field-help">
                                Leave empty to keep the current image.
                            </small>

                        </div>


                        <div class="col-md-6 form-group">

                            <label>
                                <i class="fas fa-eye"></i>
                                Current Image
                            </label>

                            <div class="current-image-box">

                                @if($data->image)

                                    <a
                                        href="{{ url(Storage::url($data->image)) }}"
                                        target="_blank"
                                        class="image-preview-link"
                                    >

                                        <img
                                            src="{{ url(Storage::url($data->image)) }}"
                                            alt="{{ $data->name }}"
                                            class="car-preview-image"
                                        >

                                        <span>
                                            <i class="fas fa-external-link-alt"></i>
                                            View Image
                                        </span>

                                    </a>

                                @else

                                    <div class="no-image">
                                        <i class="fas fa-image"></i>
                                        No image available
                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>



                <!-- =========================================
                     SETTINGS
                ========================================= -->

                <div class="form-section">

                    <div class="section-title">

                        <div class="section-icon">
                            <i class="fas fa-sliders-h"></i>
                        </div>

                        <div>
                            <h5>Car Settings</h5>
                            <span>Configure quotation and display order</span>
                        </div>

                    </div>


                    <div class="row">


                        <!-- CALL FOR QUOTE -->

                        <div class="col-md-6 form-group">

                            <label>
                                <i class="fas fa-phone"></i>
                                Call For Quote?
                            </label>

                            <select
                                class="form-control"
                                name="call_for_quote"
                            >

                                <option
                                    value="0"
                                    {{ $data->call_for_quote == 0 ? 'selected' : '' }}
                                >
                                    No
                                </option>

                                <option
                                    value="1"
                                    {{ $data->call_for_quote == 1 ? 'selected' : '' }}
                                >
                                    Yes
                                </option>

                            </select>

                        </div>


                        <!-- SORT ORDER -->

                        <div class="col-md-6 form-group">

                            <label>
                                <i class="fas fa-sort"></i>
                                Sort Order
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                value="{{ $data->sort_order }}"
                                name="sort_order"
                                placeholder="Example: 0, 1, 2..."
                                required
                            >

                            <small class="field-help">
                                Controls the order in which cars are displayed.
                            </small>

                        </div>


                    </div>

                </div>



                <!-- =========================================
                     FORM FOOTER
                ========================================= -->

                <div class="form-footer">

                    <a
                        href="{{ route('admcar.index') }}"
                        class="cancel-btn"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="update-car-btn"
                    >
                        <i class="fas fa-save"></i>
                        Update Car
                    </button>

                </div>


            </form>

        </div>

    </div>

</div>



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
   HEADER
========================================= */

.car-edit-header {
    background: #fff;

    padding: 20px 24px;

    border-radius: 12px;

    margin-bottom: 20px;

    display: flex;

    align-items: center;

    justify-content: space-between;

    box-shadow: 0 4px 18px rgba(0,0,0,.06);
}


.car-edit-title {
    display: flex;

    align-items: center;

    gap: 15px;
}


.car-edit-icon {
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


.car-edit-header h3 {
    margin: 0;

    color: #172033;

    font-size: 21px;

    font-weight: 700;
}


.car-edit-header p {
    margin: 5px 0 0;

    color: #6b7280;

    font-size: 13px;
}


/* =========================================
   BACK BUTTON
========================================= */

.back-btn {
    display: inline-flex;

    align-items: center;

    gap: 7px;

    padding: 10px 16px;

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

    color: #fff !important;
}


/* =========================================
   MAIN CARD
========================================= */

.car-edit-card {
    background: #fff;

    border-radius: 12px;

    padding: 28px;

    box-shadow: 0 4px 18px rgba(0,0,0,.06);
}


/* =========================================
   FORM SECTION
========================================= */

.form-section {
    padding-bottom: 25px;

    margin-bottom: 25px;

    border-bottom: 1px solid #edf0f4;
}


.form-section:last-of-type {
    border-bottom: none;

    margin-bottom: 0;
}


.section-title {
    display: flex;

    align-items: center;

    gap: 12px;

    margin-bottom: 22px;
}


.section-icon {
    width: 38px;
    height: 38px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #eef5ff;

    color: #0d6efd;

    border-radius: 8px;

    font-size: 15px;
}


.section-title h5 {
    margin: 0;

    color: #172033;

    font-size: 16px;

    font-weight: 700;
}


.section-title span {
    display: block;

    margin-top: 3px;

    color: #8a93a2;

    font-size: 12px;
}


/* =========================================
   LABEL
========================================= */

.car-edit-card label {
    display: block;

    color: #263143;

    font-size: 14px;

    font-weight: 600;

    margin-bottom: 8px;
}


.car-edit-card label i {
    width: 18px;

    color: #0d6efd;

    margin-right: 4px;
}


/* =========================================
   FORM GROUP
========================================= */

.car-edit-card .form-group {
    margin-bottom: 20px;
}


/* =========================================
   INPUT
========================================= */

.car-edit-card .form-control {
    height: 45px;

    border: 1px solid #dfe3ea;

    border-radius: 7px;

    padding: 10px 13px;

    color: #172033;

    font-size: 14px;

    background: #fff;

    box-shadow: none;

    transition: all .2s;
}


.car-edit-card .form-control:focus {
    border-color: #0d6efd;

    box-shadow: 0 0 0 3px rgba(13,110,253,.10);

    outline: none;
}


.car-edit-card .form-control::placeholder {
    color: #9ca3af;
}


/* =========================================
   PRICE INPUT
========================================= */

.input-icon-wrap {
    position: relative;
}


.input-icon-wrap > span {
    position: absolute;

    left: 13px;

    top: 50%;

    transform: translateY(-50%);

    color: #6b7280;

    font-weight: 600;

    z-index: 2;
}


.input-icon-wrap .form-control {
    padding-left: 30px;
}


/* =========================================
   SELECT
========================================= */

.car-edit-card select.form-control {
    cursor: pointer;
}


/* =========================================
   HELP TEXT
========================================= */

.field-help {
    display: block;

    margin-top: 6px;

    color: #8a93a2;

    font-size: 12px;

    line-height: 1.5;
}


/* =========================================
   FILE INPUT
========================================= */

.file-input {
    padding-top: 8px !important;

    cursor: pointer;
}


/* =========================================
   CURRENT IMAGE
========================================= */

.current-image-box {
    min-height: 120px;

    border: 1px dashed #d8dee8;

    border-radius: 8px;

    background: #fafbfc;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 10px;
}


.image-preview-link {
    position: relative;

    display: inline-block;

    text-decoration: none !important;
}


.car-preview-image {
    width: 180px;
    height: 100px;

    object-fit: contain;

    border-radius: 7px;

    border: 1px solid #e5e7eb;

    background: #fff;

    padding: 5px;
}


.image-preview-link span {
    position: absolute;

    left: 50%;

    bottom: 8px;

    transform: translateX(-50%);

    background: rgba(13,110,253,.95);

    color: #fff;

    padding: 5px 9px;

    border-radius: 5px;

    font-size: 11px;

    white-space: nowrap;

    opacity: 0;

    transition: .2s;
}


.image-preview-link:hover span {
    opacity: 1;
}


.no-image {
    color: #9ca3af;

    font-size: 13px;

    text-align: center;
}


.no-image i {
    display: block;

    font-size: 25px;

    margin-bottom: 5px;
}


/* =========================================
   FORM FOOTER
========================================= */

.form-footer {
    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 10px;

    padding-top: 20px;

    border-top: 1px solid #edf0f4;
}


/* =========================================
   CANCEL
========================================= */

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


/* =========================================
   UPDATE BUTTON
========================================= */

.update-car-btn {
    border: none;

    padding: 10px 22px;

    background: #0d6efd;

    color: #fff;

    border-radius: 7px;

    font-size: 14px;

    font-weight: 600;

    cursor: pointer;

    transition: .2s;
}


.update-car-btn:hover {
    background: #0756c9;

    transform: translateY(-1px);

    box-shadow: 0 4px 10px rgba(13,110,253,.20);
}


/* =========================================
   MOBILE
========================================= */

@media (max-width: 768px) {

    #content {
        padding: 15px !important;
    }


    .car-edit-header {
        padding: 16px;

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;
    }


    .back-btn {
        width: 100%;

        justify-content: center;
    }


    .car-edit-card {
        padding: 20px;
    }


    .section-title {
        align-items: flex-start;
    }


    .current-image-box {
        margin-top: 5px;
    }


    .form-footer {
        flex-direction: column-reverse;

        align-items: stretch;
    }


    .cancel-btn,
    .update-car-btn {
        width: 100%;

        text-align: center;

        justify-content: center;
    }

}

</style>