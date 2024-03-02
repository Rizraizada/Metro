@include('admin.layouts.Header')
@include('admin.layouts.sidebar')
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
                            <form method="post" action="{{ route('admin.flatselledit.update', ['id' => $flatvoucher->id]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div id="voucherContainer">
        <!-- Initial voucher fields -->
        <div class="row voucher-row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="month">Month/Date:</label>
                    <input type="date" name="months[]" class="form-control" required value="{{ $flatvoucher->month }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="voucher_no">Voucher No:</label>
                    <input type="number" name="voucher_nos[]" class="form-control" required value="{{ $flatvoucher->voucher_no }}">
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
                    <label for="paid_to">Paid To:</label>
                    <input type="text" name="paid_to[]" class="form-control" required value="{{ $flatvoucher->paid_to }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select name="categories[]" class="form-control" required>
                        <option value="expense" {{ $flatvoucher->category == 'expense' ? 'selected' : '' }}>Expense</option>
                        <option value="income" {{ $flatvoucher->category == 'income' ? 'selected' : '' }}>Income</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="customer">Customer Name</label>
                    <select name="Customer[]" class="form-control" required>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $customer->id == $flatvoucher->customer_id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="project">Project:</label>
                    <select name="project_ids[]" class="form-control" required>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ $project->id == $flatvoucher->project_id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="flat">Flat Name:</label>
                    <select id="flatDropdown" name="flat_numbers[]" class="form-control" required>
                        <!-- You may need to populate this dropdown dynamically based on the selected project -->
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="number" name="amounts[]" class="form-control" value="{{ $flatvoucher->amount }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="description">Installment Name:</label>
                    <input type="text" name="descriptions[]" class="form-control" required value="{{ $flatvoucher->description }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="payee">Check-No/Cash:</label>
                    <input type="text" name="payees[]" class="form-control" required value="{{ $flatvoucher->payee }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="note">Note:</label>
                    <input type="text" name="notes[]" class="form-control" required value="{{ $flatvoucher->note }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="delay_charge">Delay Charge:</label>
                    <input type="number" name="delay_charge[]" class="form-control" value="{{ $flatvoucher->delay_charge }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="car_money">Garage Money:</label>
                    <input type="number" name="car_money[]" class="form-control" value="{{ $flatvoucher->car_money }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="utility_charge">Utilities Charge:</label>
                    <input type="number" name="utility_charge[]" class="form-control" value="{{ $flatvoucher->utility_charge }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="special_discount">Special Discount:</label>
                    <input type="number" name="special_discount[]" class="form-control" value="{{ $flatvoucher->special_discount }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="tiles_work">Tiles Work:</label>
                    <input type="number" name="tiles_work[]" class="form-control" value="{{ $flatvoucher->tiles_work }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="refund_money">Refund Money:</label>
                    <input type="number" name="refund_money[]" class="form-control" value="{{ $flatvoucher->refund_money }}">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="miscellaneous_cost">Miscellaneous Costs:</label>
                    <input type="number" name="miscellaneous_cost[]" class="form-control" value="{{ $flatvoucher->miscellaneous_cost }}">
                </div>
            </div>

        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary" name="action" value="Update_and_print">Update</button>
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





