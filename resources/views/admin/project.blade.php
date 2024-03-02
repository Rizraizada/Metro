




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
                            <form method="post" action="{{ route('projects.storeProject') }}" enctype="multipart/form-data">
                                 @csrf

                                 <div id="voucherContainer">
                                     <div class="row voucher-row">
                                       <div class="col-md-6">
                                           <div class="form-group">
                                               <label for="company_id">Assigned To Company</label>
                                               <select name="company_id" class="form-control" required>
                                                   @foreach ($companys as $company)
                                                       <option value="{{ $company->id }}">{{ $company->name }}</option>
                                                   @endforeach
                                               </select>
                                           </div>
                                       </div>


                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="project_name">Project Name</label>
                                                 <input type="text" name="name" class="form-control" required>
                                             </div>
                                         </div>

                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="project_location">Project Location</label>
                                                 <input type="text" name="project_location" class="form-control" required>
                                             </div>
                                         </div>

                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="start_date">Start Date</label>
                                                 <input type="date" name="start_date" class="form-control" required>
                                             </div>
                                         </div>

                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="end_date">End Date</label>
                                                 <input type="date" name="end_date" class="form-control" required>
                                             </div>
                                         </div>

                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="description">Project Manager</label>
                                                 <input type="text" name="manager" class="form-control" required>
                                             </div>
                                         </div>

                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="description">Details</label>
                                                 <input type="description" name="description" class="form-control" required>
                                             </div>
                                         </div>

                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label for="description">Total Garage Slots</label>
                                                 <input type="Number" name="garage" class="form-control" required>
                                             </div>
                                         </div>

                                         <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="description">Flats Number</label>
                                                  <div id="flatsContainer">
                                                      <div class="flat-row">
                                                          <input type="text" name="flat_number[]" class="form-control" required>
                                                          <button type="button" class="btn btn-success add-flat"style='margin-top: 10px;'>Add More</button>
                                                          <button type="button" class="btn btn-danger remove-flat"style='margin-top: 10px;'>Remove</button>
                                                      </div>
                                                  </div>
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
                                                  <th>Project Name</th>
                                                  <th>Project Location</th>
                                                  <th>Start Date</th>
                                                  <th>End Date</th>
                                                  <th>Project Manager</th>
                                                  <th>Details</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              @foreach ($recentProjects as $project)
                                                  <tr>
                                                      <td>{{ $project->name }}</td>
                                                      <td>{{ $project->project_location }}</td>
                                                      <td>{{ $project->start_date }}</td>
                                                      <td>{{ $project->end_date }}</td>
                                                      <td>{{ $project->manager }}</td>
                                                      <td>{{ $project->description }}</td>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Add More Flats
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('add-flat')) {
                e.preventDefault();
                var flatsContainer = document.getElementById('flatsContainer');
                var newFlatRow = document.createElement('div');
                newFlatRow.classList.add('flat-row');
                newFlatRow.innerHTML = `
                    <input type="text" name="flat_number[]" class="form-control" required style='margin-top: 10px;'>
                     <button type="button" class="btn btn-danger remove-flat"style='margin-top: 10px;'>Remove</button>
                `;
                flatsContainer.appendChild(newFlatRow);
            }
        });

        // Remove Flats
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-flat')) {
                e.preventDefault();
                var flatRow = e.target.closest('.flat-row');
                flatRow.parentNode.removeChild(flatRow);
            }
        });
    });
</script>

</body>
@include('admin.layouts.datatable')

</html>





