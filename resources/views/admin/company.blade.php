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
                        Company Wizard

                     <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="container">
                            <!-- Search Bar Form -->
                            <form method="post" action="{{ route('company.store') }}" enctype="multipart/form-data">
                             @csrf

                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="name">Company Name</label>
                                         <input type="text" name="name" class="form-control" required>
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="address">Company Address</label>
                                         <input type="text" name="address" class="form-control" required>
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="phone">Phone</label>
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
                                         <label for="website">Website</label>
                                         <input type="text" name="website" class="form-control" required>
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="founded_date">Founded Date</label>
                                         <input type="date" name="founded_date" class="form-control" required>
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="description">Description</label>
                                         <textarea name="description" class="form-control" required></textarea>
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <label for="contact_person">Contact Person</label>
                                         <input type="text" name="contact_person" class="form-control" required>
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
                <section>
                <div class="row">
                                <div class="col-sm-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            Recent Company
                                        </header>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-12" style="margin-top: 10px;">
                                                    <div class="adv-table">
                                                        <div id="project-table_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                                            <table class="display table table-bordered table-striped" id="project-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Phone</th>
                                                                        <th>Email</th>
                                                                        <th>Address</th>
                                                                     </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($companies as $company)
                                                                        <tr>
                                                                            <td>{{ $company->name }}</td>
                                                                            <td>{{ $company->phone }}</td>
                                                                            <td>{{ $company->email }}</td>
                                                                            <td>{{ $company->address }}</td>
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
                </section>
            </div>
        </div>








@include('admin.layouts.datatable')






