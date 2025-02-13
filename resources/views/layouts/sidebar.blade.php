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
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-box"></i><span>Inventory List</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('finished_goods.index') }}">
              <i class="bi bi-circle"></i><span>Finished Goods</span>
            </a>
          </li>
          <li>
          <a href="{{ route('wip.index') }}">
              <i class="bi bi-circle"></i><span>Work In Process</span>
            </a>
          </li>
          <li>
             <a href="{{ route('cipat.index') }}">
              <i class="bi bi-circle"></i><span>Component Part</span>
            </a>
          </li>
          <li>
            <a href="components-buttons.html">
              <i class="bi bi-circle"></i><span>Raw Material</span>
            </a>
          </li>
        </ul>
      </li><!-- End Inventory List Nav -->

      <li class="nav-heading">Daily Inventory FG</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-check2-square"></i><span>Stok Daily FG</span>
        </a>
      </li><!-- End Forms Nav -->

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
        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right"></i><span>Logout</span>
        </a>
      </li>

    </ul>

</aside>