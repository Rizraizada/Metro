
@include('admin.layouts.Header')

@include('admin.layouts.sidebar')
      <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .customer-form {
            width: 70%;
            margin: 20px auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-label {
            width: 150px;
            font-weight: bold;
        }

        .form-input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-button:hover {
            background-color: #45a049;
        }

        /* Custom style for wider modal */
        .modal-content {
            width: 175%; /* Adjust the width as needed */
            margin: 65px -31%;        }
    </style>


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
                        Customer Wizard

                     <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="container">
                            <!-- Search Bar Form -->
                            <form method="post" action="{{ route('customer.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div id="voucherContainer">
                                    <div class="row voucher-row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="project_name">Name</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="description">Phone</label>
                                                <input type="tel" name="phone" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="assigned_company">Assigned to project</label>
                                                <select name="assigned_company" id="assigned_company" class="form-control" required>
                                                    @foreach ($projects as $project)
                                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="details">Flat InstallMent</label>
                                                <input type="number" name="installment" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="details">Total InstallMent Have To Pay</label>
                                                <input type="number" name="total_installment" class="form-control" required>
                                            </div>
                                        </div>



                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Car Park</th>
                                                                <th>Car Money</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group">
                                                                         <input type="number" name="garage" class="form-control"  >
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-group">
                                                                         <input type="number" name="car_money" class="form-control"  >
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="col-md-6">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Utility Charge</th>
                                                                 <th>Special Discount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>
                                                                    <div class="form-group">
                                                                         <input type="number" name="utility_charge" class="form-control"  >
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <div class="form-group">
                                                                         <input type="number" name="special_discount" class="form-control"  >
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>


                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Tiles Work Charge</th>
                                                                 <th>Others Charge</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                            <td>
                                                                    <div class="form-group">
                                                                         <input type="number" name="tiles_charge" class="form-control"  >
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <div class="form-group">
                                                                         <input type="number" name="other_charge" class="form-control"  >
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>


                                                <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="details">Address</label>
                                                <textarea name="details" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="margin-left: 1px;">
                                            <div class="form-group">
                                                <label for="selected_flats">Flat</label>
                                                <select name="selected_flats[]" class="form-control" id="selected_flats">
                                                    <!-- Options will be dynamically added here using JavaScript -->
                                                </select>
                                                <button type="button" class="btn btn-success add-flat" style="margin-top: 10px;">Add More</button>
                                                <button type="button" class="btn btn-danger remove-flat" style="margin-top: 10px;">Remove</button>
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
                                                    <th>Name</th>
                                                   <th>Phone</th>
                                                   <th>Email</th>
                                                   <th>Assigned Company</th>
                                                   <th>Details</th>
                                                   <th>Action</th>
                                                </tr>
                                           </thead>
                                           <tbody>
                                           @foreach ($customers as $customer)
                                                <tr>
                                                    <td>{{ $customer->name }}</td>
                                                    <td>{{ $customer->phone }}</td>
                                                    <td>{{ $customer->email }}</td>
                                                    <td>{{ $customer->assignedCompany->name ?? 'N/A' }}</td>
                                                    <td>{{ $customer->details }}</td>

                                                    <td>
                                                         <a href="{{ route('generate.pdf', ['customerId' => $customer->id]) }}" class="btn btn-primary">PDF</a>
                                                         <a href="{{ route('customers.edit', ['id' => $customer->id]) }}" class="btn btn-warning">Edit</a>

                                                    </td>
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
<!-- Modal HTML -->





<!-- ... Your previous HTML code ... -->

<script>
    $(document).ready(function () {
         $(".add-flat").click(function () {
            var clone = $(this).closest('.form-group').clone();
            clone.find('select[name="selected_flats[]"]').attr('id', 'selected_flats_' + $('.form-group').length);
            clone.find('.add-flat').remove();
            $(this).closest('.form-group').after(clone);
        });

         $(document).on('click', '.remove-flat', function () {
            if ($('.form-group').length > 1) {
                $(this).closest('.form-group').remove();
            }
        });


    });
</script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
             function updateFlatDropdown() {
             var selectedProjectId = $('#assigned_company').val();

             $.ajax({
                 url: '/getFlatsByProject/' + selectedProjectId,
                 type: 'GET',
                 dataType: 'json',
                 success: function (flats) {
                     console.log('Flats Response:', flats);

                     var flatDropdown = $('#selected_flats'); // Change ID to match your Blade file
                     flatDropdown.empty();

                     flats.forEach(function (flat) {
                         console.log('Flat:', flat);

                         var flatNumber = flat.flat_number;

                         if (flatNumber === undefined) {
                             console.error('Flat number is undefined. Check the property name in your response.');
                         }

                         flatDropdown.append('<option value="' + flat.id + '">' + flatNumber + '</option>');
                     });
                 },
                 error: function (error) {
                     console.error('AJAX Error:', error);

                     if (error.responseJSON && error.responseJSON.error) {
                         console.error('Server Error:', error.responseJSON.error);
                     }
                 }
             });
         }

         $('#assigned_company').on('change', function () {
             updateFlatDropdown();
         });

         $(document).ready(function () {
             updateFlatDropdown();
         });

     </script>









</body>
@include('admin.layouts.datatable')

</html>





