@include('admin.layouts.Header')

@include('admin.layouts.sidebar')
    <section id="main-content">
    <section class="wrapper">
         <div class="row">
            <div class="col-sm-12 offset-sm-4">
                <section class="panel">
                    <header class="panel-heading">
                        Project Wizard
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="container">
                            <!-- Search Bar Form -->
                            <form action="{{ route('search.wizard') }}" method="post" class="form-inline" id="searchForm">
    @csrf
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group" style="margin-top: 20px;">
                <label for="project">Project:</label>
                <select name="project_id" class="form-control">
                    <option value="">Select a Project</option>
                    <!-- Options dynamically based on projects -->
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" class="form-control">
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" class="form-control">
            </div>
        </div>
        <!-- Hidden field for include_flat_vouchers always set to true -->
        <input type="hidden" name="include_flat_vouchers" value="true">

        <!-- Add the input fields for flat_vouchers here with a class "flatVoucherFields" -->

        <!-- Add more fields for flat_vouchers if needed -->
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Search</button>
        </div>
    </div>
</form>

        </section>
    </div>
</div>

        <div class="row">
            <div class="col-sm-12 offset-sm-4">
                <section class="panel">
                    <header class="panel-heading">
                        Bank Wizard
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="container">

                        <form action="{{ route('generatePdf') }}" method="post" class="form-inline" id="searchForm">
                             @csrf
                             <div class="row">
                                 <div class="col-md-4">
                                     <div class="form-group">
                                         <label for="bank_id">Select Bank:</label>
                                         <select name="bank_ids[]" class="form-control" multiple required>
                                             <option value="all">All Banks</option>
                                             @foreach($banks as $bank)
                                                 <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                             @endforeach
                                         </select>

                                     </div>
                                 </div>
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="start_date">Start Date:</label>
                                         <input type="date" name="start_date" class="form-control" required>
                                     </div>
                                 </div>
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="end_date">End Date:</label>
                                         <input type="date" name="end_date" class="form-control" required>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-sm-12 text-center">
                                     <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Generate PDF</button>
                                 </div>
                             </div>
                         </form>

                </section>
              </div>
          </div>


          <div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                Item Wizard
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-cog"></a>
                    <a href="javascript:;" class="fa fa-times"></a>
                </span>
            </header>
            <div class="panel-body">
                <div class="container">
                    <form action="{{ route('itemSearch') }}" method="get" class="form-horizontal" id="itemSearchForm">
                        @csrf
                        <div class="form-group">
                            <label for="project_id" class="col-md-2 control-label">Select Project:</label>
                            <div class="col-md-4">
                                <select name="project_id" class="form-control" required>
                                    <option value="">Select Project</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="item_id" class="col-md-2 control-label">Select Item:</label>
                            <div class="col-md-4">
                                <select name="item_ids[]" class="form-control">
                                    <option value="all">All Items</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="start_date" class="col-md-2 control-label">Start Date:</label>
                            <div class="col-md-4">
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end_date" class="col-md-2 control-label">End Date:</label>
                            <div class="col-md-4">
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Generate PDF</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>




          <div class="row">
            <div class="col-sm-12 offset-sm-4">
                <section class="panel">
                    <header class="panel-heading">
                        Full Details Wizard
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="container">

                        <form action="{{ route('fullDetails') }}" method="post" class="form-inline" id="searchForm">
                             @csrf
                             <div class="row">

                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="start_date">Start Date:</label>
                                         <input type="date" name="start_date" class="form-control" required>
                                     </div>
                                 </div>
                                 <div class="col-sm-4">
                                     <div class="form-group">
                                         <label for="end_date">End Date:</label>
                                         <input type="date" name="end_date" class="form-control" required>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-sm-12 text-center">
                                     <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Generate Full Details</button>
                                 </div>
                             </div>
                         </form>

                </section>
              </div>
          </div>

        <!-- right sidebar end -->
    </section>
</section>
<script>
    document.getElementById('includeFlatVouchers').addEventListener('change', function () {
        var flatVoucherFields = document.querySelectorAll('.flatVoucherFields');
        flatVoucherFields.forEach(function (field) {
            field.style.display = this.checked ? 'block' : 'none';
        });
    });
</script>

@include('admin.layouts.datatable')

</body>
</html>
