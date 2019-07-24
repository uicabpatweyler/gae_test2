<nav class="navbar navbar-expand-lg fixed-top navbar-dark blue900">

    <!-- Titulo de la aplicacion -->
    <span class="navbar-brand mr-auto mr-lg-0">G.A.E</span>

    <!-- Toggle-->
    <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- navbar-collapse offcanvas-collapse -->
    <div class="navbar-collapse offcanvas-collapse blue900" id="navbarMain">

      <!-- ul navbar-nav -->
      <ul class="navbar-nav mr-auto">

        <!-- Menú: Configuración -->
        <li class="nav-item dropdown ml-1">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownConfig" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-cogs"></i>
            Configuración
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdownConfig">
            <a class="dropdown-item" href="{{ route('escuelas.index') }}"><i class="fas fa-angle-right"></i> Escuelas</a>
            <a class="dropdown-item" href="{{ route('ciclos.index') }}"><i class="fas fa-angle-right"></i> Ciclos Escolares</a>
            <a class="dropdown-item" href="{{ route('grados.index') }}"><i class="fas fa-angle-right"></i> Grados Escolares</a>
            <a class="dropdown-item" href="{{ route('grupos.index') }}"><i class="fas fa-angle-right"></i> Grupos Escolares</a>
            <a class="dropdown-item" href="{{route('cuotas.index')}}"><i class="fas fa-angle-right"></i> Cuotas de Pago</a>
            <a class="dropdown-item" href="{{route('categorias.index')}}"><i class="fas fa-angle-right"></i> Categorías Artículos</a>
          </div>
        </li>

        <!-- Menú: Alumnos -->
        <li class="nav-item dropdown ml-1">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownAlumnos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-school"></i>
            Escuela
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdownAlumnos">
            <a class="dropdown-item" href="{{route('alumnos.index')}}"><i class="fas fa-angle-right"></i> Alumnos</a>
            <a class="dropdown-item" href="{{route('inscripciones.index')}}"><i class="fas fa-angle-right"></i> Inscripción</a>
            <a class="dropdown-item" href="{{route('reinscripciones.index')}}"><i class="fas fa-angle-right"></i> Re-Inscripción</a>
            <a class="dropdown-item" href="{{route('tutores.index')}}"><i class="fas fa-angle-right"></i> Tutores</a>
            <a class="dropdown-item" href="#"><i class="fas fa-angle-right"></i> Cambio de Grupo</a>
          </div>
        </li>

        <!-- Menú: Pagos -->
        <li class="nav-item dropdown ml-1">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownPagos" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-hand-holding-usd"></i>
            Pagos
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdownPagos">
            <a class="dropdown-item" href="#"><i class="fas fa-angle-right"></i> Pago de Inscripcion</a>
            <a class="dropdown-item" href="{{route('pagocolegiaturas.index')}}"><i class="fas fa-angle-right"></i> Pago de Colegiatura</a>
            <a class="dropdown-item" href="#"><i class="fas fa-angle-right"></i> Cancelar Pago</a>
          </div>
        </li>

        <!-- Menú: Ventas -->
        <li class="nav-item dropdown ml-1">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownVentas" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-cart-plus"></i>
            Ventas
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdownVentas">
            <a class="dropdown-item" href="#"><i class="fas fa-angle-right"></i> Libros y Playeras</a>
            <a class="dropdown-item" href="#"><i class="fas fa-angle-right"></i> Cancelar Venta</a>
          </div>
        </li>

        <!-- Menú: Impresiones -->
        <li class="nav-item dropdown ml-1">
          <a class="nav-link dropdown-toggle" href="#" id="dropdownImpresiones" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-print"></i>
            Impresiones
          </a>
          <div class="dropdown-menu" aria-labelledby="dropdownImpresiones">
            <a class="dropdown-item" href="{{route('alumnos.impresion.hojainscripcion')}}"><i class="fas fa-angle-right"></i> Hoja de Inscripción</a>
            <a class="dropdown-item" href="{{route('alumnos.impresion.reciboinscripcion')}}"><i class="fas fa-angle-right"></i> Recibo de Inscripción</a>
            <a class="dropdown-item" href="{{route('impresion.inscripcionespordia.listado')}}"><i class="fas fa-angle-right"></i> Reporte de Inscripción</a>
            <a class="dropdown-item" href="{{route('impresion.inscripciongradogrupo.index')}}"><i class="fas fa-angle-right"></i> Inscripciones por Grupo</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('alumnos.impresion.recibocolegiatura')}}"><i class="fas fa-angle-right"></i> Recibo de Colegiatura</a>
            <a class="dropdown-item" href="{{route('alumnos.impresion.recibocolegiatura')}}"><i class="fas fa-angle-right"></i> Reporte de Colegiaturas</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#"><i class="fas fa-angle-right"></i> Recibo de Venta</a>
            <a class="dropdown-item" href="#"><i class="fas fa-angle-right"></i> Lista de Asistencia</a>
          </div>
        </li>

      </ul>
      <!-- ul navbar-nav -->

      <!-- Dropdown del usuario -->
      <div class="dropdown">
        <button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="far fa-user-circle"></i>
          <span class="font-weight-light">{{ Auth::user()->name }}</span>

        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="#">
            <i class="far fa-user text-success"></i> <span class="font-weight-light">Mi Perfil</span>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <i class="fas fa-key text-info"></i> <span class="font-weight-light">Cambiar Password</span>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item"  href="{{ route('logout') }}"
             onclick="event.preventDefault();
             document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt text-danger"></i> <span class="font-weight-light">Salir</span>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </div>
      <!-- Dropdown del usuario -->

    </div>
    <!-- navbar-collapse offcanvas-collapse -->

  </nav>

  <!-- Nombre de la empresa -->
  <div class="nav-scroller  shadow-sm blue800">
    <span class="nav-link text-center text-uppercase font-weight-bolder text-white">
      <u>Irlanda y Asociados, S de R.L. de C.V.</u>
    </span>
  </div>
