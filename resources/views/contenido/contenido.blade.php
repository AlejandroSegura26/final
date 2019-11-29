@extends('principal')
@section('contenido')
    <!-- Administrador -->
    @if (Auth::user()->rol_id == 1)
        <!-- Tablero -->
        <template v-if="menu==0">
            <h1>¡Bienvenido {{Auth::user()->usuario}}!</h1>
        </template>
        <!-- Hitos -->
        <template v-if="menu==1">
            <h1>Administrador / 1</h1>
        </template>
        <!-- Tareas -->
        <template v-if="menu==2">
            <h1>Administrador / 2</h1>
        </template>
        <!-- Boletos -->
        <template v-if="menu==3">
            <h1>Administrador / 3</h1>
        </template>
        <!-- Métodos de Pago -->
        <template v-if="menu==4">
            <metodospago-component></metodospago-component>
        </template>
        <!-- Proyectos -->
        <template v-if="menu==5">
            <proyecto-component></proyecto-component>
        </template>
        <!-- Servicios -->
        <template v-if="menu==6">
            <h1>Administrador / 6</h1>
        </template>
        <!-- Facturas -->
        <template v-if="menu==7">
            <h1>Administrador / 7</h1>
        </template>
        <!-- Movimientos -->
        <template v-if="menu==8">
            <h1>Administrador / 8</h1>
        </template>
        <!-- Usuarios -->
        <template v-if="menu==9">
            <usuario-component></usuario-component>
        </template>
    <!-- Director Proyecto -->
    @elseif(Auth::user()->rol_id == 2)
        <template v-if="menu==0">
            <h1>¡Bienvenido {{Auth::user()->usuario}}!</h1>
        </template>
        <template v-if="menu==1">
            <hitos-component></hitos-component>
        </template>
        <template v-if="menu==2">
        <tareas-component></tareas-component>
        </template>
        <template v-if="menu==3">
            <h1>D_Proyecto / 3</h1>
        </template>
        <template v-if="menu==4">
            <h1>D_Proyecto / 4</h1>
        </template>
        <template v-if="menu==12">
           <proyectomanager-component></proyectomanager-component>
        </template>
        <template v-if="menu==6">
            <h1>D_Proyecto / 6</h1>
        </template>
        <template v-if="menu==7">
            <h1>D_Proyecto / 7</h1>
        </template>
        <template v-if="menu==8">
            <usuario-component></usuario-component>
        </template>
       
    <!-- Programador -->
    @elseif(Auth::user()->rol_id == 3)
        <template v-if="menu==0">
            <h1>¡Bienvenido {{Auth::user()->usuario}}!</h1>
        </template>
        <template v-if="menu==1">
            <h1>Programador / 1</h1>
        </template>
        <template v-if="menu==2">
            <h1>Programador / 2</h1>
        </template>
        <template v-if="menu==3">
            <h1>Programador / 3</h1>
        </template>
        <template v-if="menu==4">
            <h1>Programador / 4</h1>
        </template>
        <template v-if="menu==10">
             <proyectoprogramador-component></proyectoprogramador-component>
        </template>
        <template v-if="menu==6">
            <h1>Programador / 6</h1>
        </template>
        <template v-if="menu==7">
            <h1>Programador / 7</h1>
        </template>
        <template v-if="menu==8">
            <usuario-component></usuario-component>
        </template>
       
    <!-- Cliente -->
    @elseif(Auth::user()->rol_id == 4)
        <template v-if="menu==0">
            <h1>¡Bienvenido {{Auth::user()->usuario}}!</h1>
        </template>
        <template v-if="menu==1">
            <h1>Cliente / 1</h1>
        </template>
        <template v-if="menu==2">
            <h1>Cliente / 2</h1>
        </template>
        <template v-if="menu==3">
            <h1>Cliente / 3</h1>
        </template>
        <template v-if="menu==4">
            <h1>Cliente / 4</h1>
        </template>
        <template v-if="menu==11">
            <proyectocliente-component></proyectocliente-component>
        </template>
        <template v-if="menu==6">
            <h1>Cliente / 6</h1>
        </template>
        <template v-if="menu==7">
            <h1>Cliente / 7</h1>
        </template>
        <template v-if="menu==8">
            <usuario-component></usuario-component>
        </template>
    @endif
@endsection