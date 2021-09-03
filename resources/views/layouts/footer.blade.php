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