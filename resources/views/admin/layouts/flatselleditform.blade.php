

<section id="main-content">
    <section class="wrapper">
        <!-- page start-->

        <div class="row">
            <div class="col-sm-12 offset-sm-4">
                <section class="panel">
                    <header class="panel-heading">
                        FLat Sell Wizard

                     <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="container">
                            <!-- Search Bar Form -->
                            <form method="post" action="{{ route('flat.voucher') }}" enctype="multipart/form-data">
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
                                                <label for="voucher_no">Paid To:</label>
                                                <input type="text" name="paid_to[]" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="category">Category:</label>
                                                <select name="categories[]" class="form-control" required>
                                                    <option value="expense">Income</option>
                                                    <option value="income">Expense</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                             <div class="form-group">
                                                 <label for="project">Customer Name</label>
                                                 <select name="Customer[]" class="form-control" required>
                                                     <!-- Options dynamically based on projects -->
                                                     @foreach($customers as $customer)
                                                         <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                     @endforeach

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
                                                 <label for="item">Flat Name</label>
                                                 <select id="flatDropdown" name="flat_numbers[]" class="form-control" required>

                                                  </select>
                                             </div>
                                         </div>


                                         <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="amount">Amount:</label>
                                                <input type="number" name="amounts[]" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="description">InstallMent Name:</label>
                                                <input type="text" name="descriptions[]" class="form-control" required>
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="note">Delay Charge:</label>
                                                <input type="number" name="delay_charge[]" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="note">Garage Money:</label>
                                                <input type="number" name="car_money[]" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="note">Utilities Charge:</label>
                                                <input type="number" name="utility_charge[]" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="note">Special Discount:</label>
                                                <input type="number" name="special_discount[]" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="note">Tiles Work:</label>
                                                <input type="number" name="tiles_work[]" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="note">Refund Money:</label>
                                                <input type="number" name="refund_money[]" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="note">Miscellaneous costs:</label>
                                                <input type="number" name="miscellaneous_cost[]" class="form-control" >
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                 <div class="form-group">
                                      <button type="submit" class="btn btn-primary" name="action" value="save_and_print">Update</button>
                                 </div>

                             </form>

                         </div>
                    </div>
                </section>
            </div>
        </div>



        <!-- right sidebar end -->
    </section>
</section>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
  function updateFlatDropdown(customerId) {
    $.ajax({
        url: '/getFlatsByCustomer/' + customerId,
        type: 'GET',
        dataType: 'json',
        success: function (flats) {
             console.log('Flats Response:', flats);

             $('#flatDropdown').empty();

             flats.forEach(function (flat) {
                 console.log('Flat:', flat);

                 var flatNumber = flat.flat_number;

                 if (flatNumber === undefined) {
                    console.error('Flat number is undefined. Check the property name in your response.');
                }

                 $('#flatDropdown').append('<option value="' + flat.id + '">' + flatNumber + '</option>');
            });
        },
        error: function (error) {
            console.error(error);
        }
    });
}

 $('select[name="Customer[]"]').on('change', function () {
    var selectedCustomerId = $(this).val();

     updateFlatDropdown(selectedCustomerId);
});

 var initialCustomerId = $('select[name="Customer[]"]').val();
updateFlatDropdown(initialCustomerId);

</script>





</body>

</html>





