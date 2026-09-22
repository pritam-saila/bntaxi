@include('admin.include.sidebar')
<!-- Page Content  -->
<div class="wrapper">
   <!-- Sidebar  -->
   <!-- Page Content  -->
   <div id="content">

      <div class="navbar-expand-lg navbar-light bg-light">
         <form action="{{route('admdriver.store')}}" method="POST" enctype="multipart/form-data">
           @csrf
           <div class="col-12">
                 <div class="row">
                    <div class="col-md-6 form-group">
                       <label>Name</label>
                       <input type="text" class="form-control" name="name" placeholder="Enter name" required="">
                    </div>

                    <div class="col-md-6 form-group">
                       <label>Email</label>
                       <input type="email" class="form-control" name="email" placeholder="Enter email" required="">
                    </div>
                    
                    <div class="col-md-6 form-group">
                       <label>Password</label>
                       <input type="password" class="form-control" name="password" placeholder="Enter password" required="">
                    </div>

                    <div class="col-md-6 form-group">
                       <label>phone</label>
                       <input type="text" class="form-control" name="phone" placeholder="Enter phone" required="">
                    </div>

                    <div class="col-md-6 form-group">
                       <label>Company Name</label>
                       <input type="text" class="form-control" name="company_name" placeholder="Enter company name" required="">
                    </div>

                    <div class="col-md-6 form-group">
                       <label>address</label>
                       <input type="text" class="form-control" name="address" placeholder="Enter address" required="">
                    </div>

                    <div class="col-md-6 form-group">
                       <label>vat number</label>
                       <input type="text" class="form-control" name="vatnumber" placeholder="Enter vat number" required="">
                    </div>

                    <div class="col-md-6 form-group">
                       <label>company reg number</label>
                       <input type="text" class="form-control" name="companyregnumber" placeholder="Enter company reg number" required="">
                    </div>

                    <div class="col-md-6 form-group">
                       <label>vehicle reg number</label>
                       <input type="text" class="form-control" name="vehicleregnumber" placeholder="Enter vehicle reg number" required="">
                    </div>

                    <div class="col-md-6 form-group">
                       <label>make</label>
                       <input type="text" class="form-control" name="make" placeholder="Enter make" required="">
                    </div>

                    <div class="col-md-6 form-group">
                       <label>model</label>
                       <input type="text" class="form-control" name="model" placeholder="Enter model" required="">
                    </div>
                    <div class="col-md-6 form-group">
                       <label for="">Car Type  *</label>
                       <select name="cartype" class="form-control" required>
                          <?php foreach($distnceprice as $item ) {?>
                          <option value="<?= $item->id ?>"><?= $item->name ?></option>
                          <?php } ?>
                       </select>
                    </div>

                    <div class="col-md-6 form-group">
                       <label>hire and reward insurance</label>
                       <input type="file" class="form-control" name="hireandrewardinsurance">
                    </div>

                    <div class="col-md-6 form-group">
                       <label>goods intransit insuance</label>
                       <input type="file" class="form-control" name="goodsintransitinsuance">
                    </div>

                    <div class="col-md-6 form-group">
                       <label>public liability insurance</label>
                       <input type="file" class="form-control" name="publicliabilityinsurance">
                    </div>

                    <div class="col-md-6 form-group">
                       <label>driving insurance</label>
                       <input type="file" class="form-control" name="drivinginsurance">
                    </div>

                    <div class="col-md-6 form-group">
                       <label>Status</label>
                       <select name="status" id="status" class="form-control">
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                       </select>
                    </div>

                    <div class="col-md-6 form-group">
                       <label>Profile Image</label>
                       <input type="file" name="image" class="form-control">
                    </div>

                    <div class="col-md-12 mt-2">
                       <input type="submit" class="btn btn-success" value="Submit">
                    </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>