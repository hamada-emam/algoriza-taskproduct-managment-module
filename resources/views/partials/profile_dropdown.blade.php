 <div class="dropdown">
     <button class="btn btn-secondary dropdown-toggle" type="button" id="adminDropdown" data-toggle="dropdown"
         aria-haspopup="true" aria-expanded="false">
         {{ Auth::user()?->name }}
     </button>
     <div class="dropdown-menu" aria-labelledby="adminDropdown">
         <a class="dropdown-item" href="#">Edit Profile</a>
         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
             @csrf
         </form>
         <a class="nav-link" href="#"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

     </div>
 </div>
