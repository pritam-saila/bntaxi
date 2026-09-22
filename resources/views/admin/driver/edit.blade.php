
    @include('admin.include.sidebar')
    <!-- Page Content  -->
    <div class="wrapper">
       <!-- Sidebar  -->
       <!-- Page Content  -->
       <div id="content">

          <div class="navbar-expand-lg navbar-light bg-light">
             <form action="{{route('admdriver.update',$data->id)}}" method="POST" enctype="multipart/form-data">
               @method('PATCH')
               @csrf
               <div class="col-12">
                     <div class="row">
                        <div class="col-md-6 form-group">
                           <label>Name</label>
                           <input type="text" class="form-control" value="{{$data->name}}" name="name" placeholder="Enter name" required="">
                        </div>

                        <div class="col-md-6 form-group">
                           <label>Email</label>
                           <input type="text" class="form-control" value="{{$data->email}}" name="email" placeholder="Enter email" required="">
                        </div>

                        <div class="col-md-6 form-group">
                           <label>phone</label>
                           <input type="text" class="form-control" value="{{$data->phone}}" name="phone" placeholder="Enter phone" required="">
                        </div>

                        <div class="col-md-6 form-group">
                           <label>Company Name</label>
                           <input type="text" class="form-control" value="{{$data->company_name}}" name="company_name" placeholder="Enter company name" required="">
                        </div>

                        <div class="col-md-6 form-group">
                           <label>address</label>
                           <input type="text" class="form-control" value="{{$data->address}}" name="address" placeholder="Enter address" required="">
                        </div>

                        <div class="col-md-6 form-group">
                           <label>vat number</label>
                           <input type="text" class="form-control" value="{{$data->vatnumber}}" name="vatnumber" placeholder="Enter vat number" required="">
                        </div>

                        <div class="col-md-6 form-group">
                           <label>company reg number</label>
                           <input type="text" class="form-control" value="{{$data->companyregnumber}}" name="companyregnumber" placeholder="Enter company reg number" required="">
                        </div>

                        <div class="col-md-6 form-group">
                           <label>vehicle reg number</label>
                           <input type="text" class="form-control" value="{{$data->vehicleregnumber}}" name="vehicleregnumber" placeholder="Enter vehicle reg number" required="">
                        </div>

                        <div class="col-md-6 form-group">
                           <label>make</label>
                           <input type="text" class="form-control" value="{{$data->make}}" name="make" placeholder="Enter make" required="">
                        </div>

                        <div class="col-md-6 form-group">
                           <label>model</label>
                           <input type="text" class="form-control" value="{{$data->model}}" name="model" placeholder="Enter model" required="">
                        </div>
                        <div class="col-md-6 form-group">
                           <label for="">Car Type  *</label>
                           <select name="cartype" class="form-control" placeholder="Car Type" required>
                              <?php foreach($distnceprice as $item ) {?>
                              <option value="<?= $item->id ?>" {{$item->id == $data->cartype ? 'selected' : ''}}><?= $item->name ?></option>
                              <?php } ?>
                           </select>
                        </div>

                        <div class="col-md-6 form-group">
                           <label>hire and reward insurance <a href="{{$data->hireandrewardinsurance ? url(Storage::url($data->hireandrewardinsurance)) : '#'}}">(view)</a></label>
                           <input type="file" class="form-control" name="hireandrewardinsurance">
                        </div>

                        <div class="col-md-6 form-group">
                           <label>goods intransit insuance <a href="{{$data->goodsintransitinsuance ? url(Storage::url($data->goodsintransitinsuance)) : '#'}}">(view)</a></label>
                           <input type="file" class="form-control" name="goodsintransitinsuance">
                        </div>

                        <div class="col-md-6 form-group">
                           <label>public liability insurance <a href="{{$data->publicliabilityinsurance ? url(Storage::url($data->publicliabilityinsurance)) : '#'}}">(view)</a></label>
                           <input type="file" class="form-control" name="publicliabilityinsurance">
                        </div>

                        <div class="col-md-6 form-group">
                           <label>driving insurance <a href="{{$data->drivinginsurance ? url(Storage::url($data->drivinginsurance)) : '#'}}">(view)</a></label>
                           <input type="file" class="form-control" name="drivinginsurance">
                        </div>

                        <div class="col-md-6 form-group">
                           <label>Status</label>
                           <select name="status" id="status" class="form-control">
                              <option value="1" {{$data->status == 1 ? 'selected' : ''}}>Active</option>
                              <option value="0" {{$data->status == 0 ? 'selected' : ''}}>Inactive</option>
                           </select>
                        </div>

                        <div class="col-md-6 form-group">
                           <label>Profile Image</label>
                           <input type="file" name="image" class="form-control">
                           @if($data->image)
                           <img src="{{url(Storage::url($data->image))}}" alt="driver image" style="max-width: 100px; margin-top: 10px;">
                           @endif
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
    
  <style>
     .trashclass{
      position: absolute;
      top: 10px;
      left: 25px;
      color: red;
     }
  </style>

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
