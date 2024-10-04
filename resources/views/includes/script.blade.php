       <!-- JAVASCRIPT -->
       <script src="{{ asset('js/jquery.min.js') }}"></script>
       <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
       <script src="{{ asset('js/metisMenu.min.js') }}"></script>
       <script src="{{ asset('js/simplebar.min.js') }}"></script>
       <script src="{{ asset('js/waves.min.js') }}"></script>
       <script src="{{ asset('js/feather.min.js') }}"></script>
       <!-- pace js -->
       <script src="{{ asset('js/pace.min.js') }}"></script>
       <!-- password addon init -->
       <script src="{{ asset('js/pass-addon.init.js') }}"></script>


       <script src="{{ asset('js/apexcharts.min.js') }}"></script>

       <!-- Plugins js-->
       <script src="{{ asset('js/jquery-jvectormap-1.2.2.min.js') }}"></script>
       <script src="{{ asset('js/jquery-jvectormap-world-mill-en.js') }}"></script>
       <!-- dashboard init -->

       <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

     
       <script src="{{ asset('js/select2.min.js') }}"></script>
       <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
       <script src="{{ asset('js/app.js') }}"></script>





       <script>
           @if (\Session::has('success'))
               Swal.fire({
                   title: "SUCCESS",
                   text: "{{ Session::get('success') }}",
                   icon: "success",
                   showCancelButton: 0,
                   confirmButtonColor: "#5156be",
                   cancelButtonColor: "#fd625e"
               })
           @endif
           @if (\Session::has('error'))
           Swal.fire({
                   title: "ERROR",
                   text: "{{ Session::get('error') }}",
                   icon: "error",
                   showCancelButton: 0,
                   confirmButtonColor: "#5156be",
                   cancelButtonColor: "#fd625e"
               })
           @endif
       </script>

       <script src="{{ asset('js/script.js') }}"></script>
