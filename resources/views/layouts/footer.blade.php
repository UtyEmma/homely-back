          <footer>
              <div class="footer clearfix mb-0 text-muted">
                  <div class="float-start">
                      <p>2021 &copy; Mazer</p>
                  </div>
                  <div class="float-end">
                      <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                              href="http://ahmadsaugi.com">A. Saugi</a></p>
                  </div>
              </div>
          </footer>
        </div>
    </div>

    <div class="modal fade text-left" id="create-admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel110" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel110">
                        Create new Admin
                    </h5>
                    <button type="button" class="close"
                        data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                  <div class="card-header py-2 card-header-primary">
                    <p class="card-category">Register a New Admin</p>
                  </div>
                  <div class="card-body">
                      @if(session('response'))
                          <div class="alert alert-success">{{session('response')}}</div>
                      @endif

                      <form action="/register" method="POST" class="mt-4">
                          @csrf
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">
                                  <label class="bmd-label-floating">Firstname</label>
                                  <input type="text" name="firstname" class="form-control form-control-lg @error('firstname') is-invalid @enderror">
                                  @error('firstname')
                                      <small class="text-danger">{{ $message }}</small>
                                  @enderror
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                  <label class="bmd-label-floating">Lastname</label>
                                  <input type="text" name="lastname" class="form-control form-control-lg @error('firstname') is-invalid @enderror">
                                  @error('lastname')
                                      <small class="text-danger">{{ $message }}</small>
                                  @enderror
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                  <label class="bmd-label-floating">Email Address</label>
                                  <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror">
                                  @error('email')
                                      <small class="text-danger">{{ $message }}</small>
                                  @enderror
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="admin_role" class="">Role</label>
                                      <select class="form-control form-control-lg @error('role') is-invalid @enderror selectpicker" data-style="btn btn-link" name="role" id="admin_role">
                                          <option>Select Admin</option>
                                          <option>Administrator</option>
                                          <option>Super Administrator</option>
                                      </select>
                                      @error('role')
                                          <small class="text-danger">{{ $message }}</small>
                                      @enderror
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="bmd-label-floating" for="password">Default Password</label>
                                      <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" id="password">
                                      @error('password')
                                          <small class="text-danger">{{ $message }}</small>
                                      @enderror
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label class="bmd-label-floating" for="password_confirmation">Confirm Password</label>
                                      <input type="password" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation">
                                      @error('password')
                                          <small class="text-danger">{{ $message }}</small>
                                      @enderror
                                  </div>
                              </div>
                              </div>
                              <div class="col-md-12 mt-5">
                                  <div class="form-group text-center">
                                      <button type="submit" class="btn btn-primary btn-lg px-5">Register Admin</button>
                                      <div class="clearfix"></div>
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button"
                  class="btn btn-light-secondary"
                  data-bs-dismiss="modal">
                  <i class="bx bx-x d-block d-sm-none"></i>
                  <span class="d-none d-sm-block">Close</span>
              </button>

              <button type="button" class="btn btn-success ml-1"
                  data-bs-dismiss="modal">
                  <i class="bx bx-check d-block d-sm-none"></i>
                  <span class="d-none d-sm-block">Accept</span>
              </button>
          </div>
      </div>

    <script src="{{asset('vendors/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('vendors/apexcharts/apexcharts.js')}}"></script>
    <script src="{{asset('js/pages/dashboard.js')}}"></script>
    <script src="{{asset('vendors/simple-datatables/simple-datatables.js')}}"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
    <script src="{{asset('js/main.js')}}"></script>

    @if($errors->any())
        <script>
            toastr.options = {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "toast-top-center",
            }
      		toastr.error("Invalid Input Data");
        </script>
    @endif

    @if(Session::has('success'))
        <script>
            toastr.options = {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "toast-top-center",
            }
  	    	toastr.success("{{ session('success') }}", "Success");
        </script>
    @endif

    @if(Session::has('message'))
        <script>
            toastr.options = {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "toast-top-center",
            }
      		toastr.info("{{ session('message') }}", "Message");
        </script>
    @endif

    @if(Session::has('error'))
        <script>
            toastr.options = {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "toast-top-center",
            }
      		toastr.error("{{ session('error') }}", "Error");
        </script>
    @endif

    @if(Session::has('warning'))
        <script>
            toastr.options = {
                "closeButton" : true,
                "progressBar" : true,
                "positionClass": "toast-top-center",
            }
            toastr.error("{{ session('warning') }}", "Error");
        </script>
    @endif
</body>

</html>
