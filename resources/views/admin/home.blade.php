@include('admin.layouts.Header')

@include('admin.layouts.sidebar')

<body>


    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->
        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


        <div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                 Voucher Wizard
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-cog"></a>
                    <a href="javascript:;" class="fa fa-times"></a>
                      </span>
                  </header>
                  <div class="panel-body">
              <div class="container">

              <form method="post" action="{{ route('save.vouchers') }}">
                 @csrf

                <div id="voucherContainer">
                    <!-- Initial voucher fields -->
                    <div class="row voucher-row">
                    <div class="col-md-3">
                            <div class="form-group">
                                <label for="month">Month/Date:</label>
                                <input type="date" name="months[]" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="voucher_no">Voucher No:</label>
                                <input type="number" name="voucher_nos[]" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="voucher_no">Paid To/Supplier Name:</label>
                                <input type="text" name="paid_to[]" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="category">Category:</label>
                                <select name="categories[]" class="form-control" required>
                                    <!-- <option value="expense">Income</option> -->
                                    <option value="income">Expense</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                             <div class="form-group">
                                 <label for="project">Project:</label>
                                 <select name="project_ids[]" class="form-control" required>
                                     <!-- Options dynamically based on projects -->
                                     @foreach($projects as $project)
                                         <option value="{{ $project->id }}">{{ $project->name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group">
                                 <label for="item">Item:</label>
                                 <select name="item_ids[]" class="form-control" required>
                                     <!-- Options dynamically based on items -->
                                     @foreach($items as $item)
                                         <option value="{{ $item->id }}">{{ $item->name }}</option>
                                     @endforeach
                                 </select>
                             </div>
                         </div>

                         <div class="col-md-3">
                            <div class="form-group">
                                <label for="amount">Amount:</label>
                                <input type="number" name="amounts[]" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <input type="text" name="descriptions[]" class="form-control" required>
                            </div>
                        </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                  <label for="bank_id">Select Bank:</label>
                                  <select name="bank_ids[]" class="form-control" required>
                                      <!-- Options dynamically based on banks -->
                                      @foreach($banks as $bank)
                                          <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                         </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="payee">Checke-No/Cash:</label>
                                <input type="text" name="payees[]" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="note">Note:</label>
                                <input type="text" name="notes[]" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3" style="margin-top: 25px;">
                            <div class="form-group">
                                <button type="button" class="btn btn-danger remove-voucher">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>

                 <div class="form-group">
                     <button type="button" class="btn btn-success" id="addVoucher">Add Voucher</button>
                     <button type="submit" class="btn btn-primary">Save Vouchers</button>
                     <button type="submit" class="btn btn-primary" name="action" value="save_and_print">Save And Print</button>
                 </div>
             </form>
        </div>
    </div>




        </section>

        <div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                Recent Voucher
            </header>
            <div class="panel-body">
                <div class="row">

                    <div class="col-sm-12" style="margin-top: 10px;">
                        <div class="adv-table">
                            <div id="voucher-table_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <table class="display table table-bordered table-striped" id="voucher-table">
                                   <!-- ... (previous code) ... -->
<thead>
    <tr>
        <th>Month/Date</th>
        <th>Voucher No</th>
        <th>Paid To/Supplier Name</th>
        <th>Description</th>
        <th>Amount</th>
        <th>Payee</th>
        <th>Category</th>
        <th>Action</th> <!-- Add this line for the action column -->
    </tr>
</thead>
<tbody>
    @foreach($vouchers as $voucher)
        <tr>
            <td>{{ $voucher->month_date }}</td>
            <td>{{ $voucher->voucher_no }}</td>
            <td>{{ $voucher->paid_to }}</td>
            <td>{{ $voucher->description }}</td>
            <td>{{ $voucher->amount }}</td>
            <td>{{ $voucher->payee }}</td>
            <td>{{ $voucher->category }}</td>
            <td>
                <!-- Add a delete button with a form for each entry -->
                <form action="{{ route('delete.voucher', ['id' => $voucher->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
<!-- ... (remaining code) ... -->

                                </table>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>


<!--right sidebar end-->

</section>

<!-- Placed js at the end of the document so the pages load faster -->

<!--Core js-->
<script src="Admin/js/lib/jquery.js"></script>
<script src="Admin/bs3/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="Admin/js/accordion-menu/jquery.dcjqaccordion.2.7.js"></script>
<script src="Admin/js/scrollTo/jquery.scrollTo.min.js"></script>>
<script src="Admin/assets/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>

<script src="Admin/assets/jquery-steps-master/build/jquery.steps.js"></script>
<!--Easy Pie Chart-->
<script src="Admin/assets/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="Admin/assets/sparkline/jquery.sparkline.js"></script>
<!--jQuery Flot Chart-->
<script src="Admin/assets/flot-chart/jquery.flot.js"></script>
<script src="Admin/assets/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="Admin/assets/flot-chart/jquery.flot.resize.js"></script>
<script src="Admin/assets/flot-chart/jquery.flot.pie.resize.js"></script>


<!--common script init for all pages-->
<script src="Admin/js/scripts.js"></script>

<script>
 $(document).ready(function () {
    $('#voucher-table').DataTable();
});

</script>






<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            let voucherCount = 1;

            // Function to add a new voucher row
            function addVoucherRow() {
                voucherCount++;
                let newVoucherRow = $(".voucher-row:first").clone();

                // Update IDs and names to make them unique
                newVoucherRow.find("input, select").each(function () {
                    let currentId = $(this).attr("id");
                    let currentName = $(this).attr("name");

                    // Check if the element has an ID and a name
                    if (currentId && currentName) {
                        let newId = currentId.replace(/_\d+$/, "_" + voucherCount);
                        let newName = currentName.replace(/_\d+$/, "_" + voucherCount);

                        $(this).attr("id", newId);
                        $(this).attr("name", newName);
                        $(this).val(""); // Clear input values for the new row
                    }
                });

                newVoucherRow.find('.remove-voucher').click(function () {
                    $(this).closest('.voucher-row').remove();
                });

                $("#voucherContainer").append(newVoucherRow);
            }

            // Add voucher button click event
            $("#addVoucher").click(addVoucherRow);

            // Remove voucher button click event
            $(document).on('click', '.remove-voucher', function () {
                $(this).closest('.voucher-row').remove();
            });
        });
    </script>

<script>
    $(document).ready(function () {
        $('[name="month_1"]').datepicker({
            format: 'mm/dd/yyyy',  // Set the desired date format
            autoclose: true
        });
    });
</script>





<script>
    $(function ()
    {
        $("#wizard").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft"
        });

        $("#wizard-vertical").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            stepsOrientation: "vertical"
        });
    });


</script>

</body>
</html>
