 <footer class="footer text-center text-sm-left">
     &copy; {{ date('Y') }} - {{ date('Y', strtotime('+1 year')) }} {{Config::get('constants.AppnameGlobe') }} <span class="text-muted d-none d-sm-inline-block float-right">Created by <i class="mdi mdi-heart text-danger"></i> by {{Config::get('constants.AppnameGlobe') }}</span>
 </footer>