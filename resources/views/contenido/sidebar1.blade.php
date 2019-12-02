    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
          <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-clipboard-check"></i>
          </div>
          <div class="sidebar-brand-text mx-3">PFF</div>
        </a>
        <!-- Divider -->
        <hr class="sidebar-divider my-0">
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
          Módulos
        </div>
        <!-- Nav Item - Dashboard -->
        <li @click="menu=0" class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tablero</span></a>
        </li>
         <!-- Nav Item - Tareas Asignadas -->
         <li class="nav-item">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-tasks"></i>
            <span>Productividad</span>
          </a>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Hitos, Tareas y Boletos:</h6>
              <a @click="menu=1" class="collapse-item" href="#"><i class="fas fa-fw fa-thumbtack"></i>&nbsp;Hitos</a>
              <a @click="menu=2" class="collapse-item" href="#"><i class="fas fa-fw fa-list"></i>&nbsp;Tareas</a>
              <a @click="menu=3" class="collapse-item" href="#"><i class="fas fa-fw fa-comment-dots"></i>&nbsp;Boletos</a>
              <a @click="menu=4" class="collapse-item" href="#"><i class="fas fa-fw fa-bookmark"></i>&nbsp;Problemas</a>
            </div>
          </div>
        </li>
        <!-- Nav Item - Metodos de Pago -->
        <li @click="menu=5" class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-fw fa-credit-card"></i>
            <span>Métodos de Pago</span>
          </a>
        </li>
        <!-- Nav Item - servicioss -->
        <li @click="menu=6" class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-fw fa-suitcase"></i>
            <span>Proyectos</span>
          </a>
        </li>
        <!-- Nav Item - Servicios -->
        <li @click="menu=7" class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-fw fa-screwdriver"></i>
            <span>Servicios</span>
          </a>
        </li>
        <!-- Nav Item - Facturas -->
        <li @click="menu=8" class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Facturas</span>
          </a>
        </li>
        <!-- Nav Item - Movimientos -->
        <li @click="menu=9" class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-fw fa-money-check"></i>
            <span>Movimientos</span>
          </a>
        </li>

        <li @click="menu=17" class="nav-item">
            <a class="nav-link" href="#">
              <i class="fas fa-fw fa-money-check"></i>
              <span>Retiros</span>
            </a>
          </li>
        <!-- Nav Item - Usuarios -->
        <li @click="menu=10" class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-fw fa-user"></i>
            <span>Usuarios</span>
          </a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

      </ul>
      <!-- End of Sidebar -->
