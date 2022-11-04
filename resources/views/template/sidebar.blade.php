    <!-- ======== sidebar-nav start =========== -->
    <aside class="sidebar-nav-wrapper">
      <div class="navbar-logo">
        <a href="index.html">
          <img src="" alt="MAZDA" />
        </a>
      </div>
      <nav class="sidebar-nav">
        <ul>
          <li class="nav-item {{ request()->is('/*') ? 'active' : '' }}">
            <a href="{{ url('/')}}">
              <span class="icon">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z"
                  />
                </svg>
              </span>
              <span class="text" class="active">Dashboard</span>
            </a>
          </li>
          <li class="nav-item nav-item-has-children ">
            <a href="#0" class="{{ request()->is('kategori*','bentuk*', 'sanksi*') ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_2" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
              <span class="icon">
                <i class="fas fa-pencil-ruler"></i>
              </span>
              <span class="text">Tata Tertib</span>
            </a>
            <ul id="ddmenu_2" class="collapse dropdown-nav  {{ request()->is('kategori*','bentuk*', 'sanksi*') ? 'show' : '' }}">
              <li>
                <a href="{{ url('kategori')}}" class="{{ request()->is('kategori*') ? 'active' : '' }}"> Kategori Pelanggaran </a>
              </li>
              <li>
                <a href="{{ route('bentuk')}}" class="{{ request()->is('bentuk*') ? 'active' : '' }}"> Bentuk Pelanggaran </a>
              </li>
              <li>
                <a href="{{ url('sanksi')}}" class="{{ request()->is('sanksi*') ? 'active' : '' }}"> Sanksi Pelanggaran </a>
              </li>
            </ul>
          </li>
          @if (auth()->user()->level=='admin' || auth()->user()->level=='guru')
          <li class="nav-item nav-item-has-children">
            <a href="#0" class="{{ request()->is('kelas*','isiKelas*') ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_31" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
              <span class="icon">
                <i class="fas fa-cogs"></i>
              </span>
              <span class="text">Data Kelas</span>
            </a>
            <ul id="ddmenu_31" class="collapse dropdown-nav {{ request()->is('kelas*','isiKelas*') ? 'show' : '' }}">
              <li>
                <a href="{{ url('kelas')}}" class="{{ request()->is('kelas*') ? 'active' : '' }}"> Kelas </a>
              </li>
              <li>
                <a href="{{ url('isiKelas')}}" class="{{ request()->is('isiKelas*') ? 'active' : '' }}"> Daftar Siswa</a>
              </li>
            </ul>
          </li>
          @endif
          @if (auth()->user()->level=='admin' || auth()->user()->level=='guru')
          <li class="nav-item {{ request()->is('siswa*') ? 'active' : '' }}">
            <a href="{{ url('siswa')}}" >
              <span class="icon">
                <i class="fas fa-users"></i>
              </span>
              <span class="text" >Data Siswa</span>
            </a>
          </li>
              
          <li class="nav-item {{ request()->is('pelanggaran*') ? 'active' : '' }}">
            <a href="{{ url('pelanggaran')}}">
              <span class="icon">
                <i class="fas fa-book"></i>
              </span>
              <span class="text" >Pelanggaran Siswa</span>
            </a>
          </li>
          @endif
          @if (auth()->user()->level=='admin')
          <li class="nav-item {{ request()->is('admin*') ? 'active' : '' }}">
            <a href="{{ url('admin')}}">
              <span class="icon">
                <i class="fas fa-cogs"></i>
              </span>
              <span class="text" >Data Admin</span>
            </a>
          </li>
              
          @endif
          {{-- @if(auth()->user()->level=='siswa')
          <li class="nav-item {{ request()->is('admin*') ? 'active' : '' }}">
            <a href="{{ url('admin')}}">
              <span class="icon">
                <i class="fas fa-cogs"></i>
              </span>
              <span class="text" >Data Admin</span>
            </a>
          </li>
          @endif --}}
        </ul>
      </nav>
    </aside>
    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->
    