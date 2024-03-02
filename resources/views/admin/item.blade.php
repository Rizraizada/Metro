
@include('admin.layouts.Header')

@include('admin.layouts.sidebar')
    <section id="main-content">
    <section class="wrapper">
        <!-- page start-->
        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

        <div class="row">
            <div class="col-sm-12 offset-sm-4">
                <section class="panel">
                    <header class="panel-heading">
                        project Wizard

                     <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="container">
                            <!-- Search Bar Form -->
                            <form method="post" action="{{ route('projects.storeItem') }}" enctype="multipart/form-data">
                                 @csrf

                                 <div id="voucherContainer">
                                     <div class="row voucher-row">
                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="project_name">Item Name</label>
                                                 <input type="text" name="name" class="form-control" required>
                                             </div>
                                         </div>

                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="project_name">Purchase Date</label>
                                                 <input type="text" name="purchase_date" class="form-control" required>
                                             </div>
                                         </div>

                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="description">Supplier Information</label>
                                                 <input type="text" name="supplier" class="form-control" required>
                                             </div>
                                         </div>

                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="description">Item Details</label>
                                                 <input type="description" name="details" class="form-control" required>
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="form-group">
                                     <button type="submit" class="btn btn-primary">Save</button>
                                 </div>
                             </form>
                            <!-- End of Search Bar Form -->

                            <!-- Add the content of your wizard here -->
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Recent project
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12" style="margin-top: 10px;">
                                <div class="adv-table">
                                    <div id="voucher-table_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                    <table class="display table table-bordered table-striped" id="voucher-table">
                                          <thead>
                                              <tr>
                                                  <th>Item Name</th>
                                                  <th>Pusrchase Date</th>
                                                  <th>supplier</th>
                                                   <th>Details</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              @foreach ($dailyVisitorsItems as $item)
                                                  <tr>
                                                      <td>{{ $item->name }}</td>
                                                      <td>{{ $item->purchase_date }}</td>
                                                      <td>{{ $item->supplier }}</td>
                                                      <td>{{ $item->details }}</td>
                                                  </tr>
                                              @endforeach
                                          </tbody>
                                      </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- right sidebar end -->
    </section>
</section>



</body>
@include('admin.layouts.datatable')

</html>





