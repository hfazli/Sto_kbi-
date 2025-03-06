<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-heading">Master BOM</li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('inventory.index') }}">
            <i class="bi bi-box"></i><span>Inventory List</span>
        </a>
      </li><!-- End Inventory List Nav -->
      <li class="nav-heading">FG Forecast</li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('forecast.index') }}">
            <i class="fa-regular fa-file"></i><span>Forecast List</span>
        </a>
      </li><!-- End Inventory List Nav -->
      <li class="nav-heading">Price</li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('price.index') }}">
            <i class="bi bi-currency-dollar"></i><span>Price List</span>
        </a>
      </li><!-- End Price List Nav -->

      <li class="nav-heading">Reports</li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('reports.index') }}">
            <i class="bi bi-file-earmark-bar-graph"></i><span>Report STO</span>
        </a>
      </li><!-- End Reports Nav -->

      <li class="nav-heading">User Management</li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="bi bi-person"></i><span>User</span>
        </a>
      </li>

      <li class="nav-heading">AUTH</li>

      <li class="nav-item">
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <a class="nav-link" href="#" onclick="event.preventDefault(); showLogoutConfirmation();">
            <i class="bi bi-box-arrow-right"></i><span>Logout</span>
        </a>
      </li>

    </ul>

    <div class="text-center p-2 mt-4">
        <small>&copy; 2025 by Hedi Fazli</small>
    </div>

</aside>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function showLogoutConfirmation() {
    Swal.fire({
      title: 'Apakah Anda yakin?',
      text: "Anda akan keluar!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, keluar!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('logout-form').submit();
      }
    });
  }
</script>