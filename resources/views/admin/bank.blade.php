




@include('admin.layouts.Header')

@include('admin.layouts.sidebar')
<section id="main-content">
    <section class="wrapper">
        <!-- page start-->

        <div class="row">
    <div class="col-sm-12 offset-sm-4">
        <section class="panel">
            <header class="panel-heading">
                Bank Book Wizard
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                    <a href="javascript:;" class="fa fa-cog"></a>
                    <a href="javascript:;" class="fa fa-times"></a>
                </span>
            </header>
            <div class="panel-body">
                <div class="container">
                    <!-- Search Bar Form -->
                    <form method="post" action="{{ route('banks.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bank_name">Bank Name:</label>
                                    <input type="text" name="bank_name" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_no">Branch Name:</label>
                                    <input type="text" name="branch_no" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deposit">Account Number:</label>
                                    <input type="number" name="deposit" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="owner">Accounts Owner:</label>
                                    <input type="text" name="owner" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="opening_balance">Opening Balance:</label>
                                    <input type="number" name="opening_balance" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="details">Details:</label>
                                    <input type="text" name="details" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="withdraw">With-Draw:</label>
                                    <input type="number" name="withdraw" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Bank</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>


        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Recent Bank

                </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12" style="margin-top: 10px;">
                                <div class="adv-table">
                                    <div id="voucher-table_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                    <table class="display table table-bordered table-striped" id="voucher-table">
                                    <thead>
                                           <tr>
                                            <th>Bank Name</th>
                                               <th>Branch No</th>
                                               <th>Owner</th>
                                               <th>Opening Balance</th>
                                               <th>Details</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           @foreach($banks as $bank)
                                               <tr>
                                                    <td>{{ $bank->bank_name }}</td>
                                                   <td>{{ $bank->branch_no }}</td>
                                                   <td>{{ $bank->owner }}</td>
                                                   <td>{{ $bank->opening_balance }}</td>
                                                   <td>{{ $bank->details }}</td>
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

@include('admin.layouts.datatable')






