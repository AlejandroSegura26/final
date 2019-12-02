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
            <inboxadmin-component></inboxadmin-component>
        </template>
        <!-- Problemas -->
        <template v-if="menu==4">
            <problemasad-component></problemasad-component>
        </template>
        <!-- Métodos de Pago -->
        <template v-if="menu==5">
            <metodospago-component></metodospago-component>
        </template>
        <!-- Proyectos -->
        <template v-if="menu==6">
            <proyecto-component></proyecto-component>
        </template>
        <!-- Servicios -->
        <template v-if="menu==7">
            <servicioadmin-component></servicioadmin-component>
        </template>
        <!-- Facturas -->
        <template v-if="menu==8">
            <h1>Administrador / 7</h1>
        </template>
        <!-- Movimientos -->
        <template v-if="menu==9">
            <h1>Administrador / 8</h1>
        </template>
        <!-- Usuarios -->
        <template v-if="menu==10">
            <usuario-component></usuario-component>
        </template>
        <template v-if="menu==17">
            <aretiros-component></aretiros-component>
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
        <template v-if="menu==23">
            <inboxmanager-component></inboxmanager-component>
        </template>
        <template v-if="menu==30">
            <problemasdp-component></problemasdp-component>
        </template>
        <template v-if="menu==12">
           <proyectomanager-component></proyectomanager-component>
        </template>
        <template v-if="menu==6">
            <h1>D_Proyecto / 6</h1>
        </template>
        <template v-if="menu==25">
            <serviciomanager-component></serviciomanager-component>
        </template>
        <template v-if="menu==40">
            <sitio-component></sitio-component>
        </template>
        <template v-if="menu==20">
                <mretiros-component></mretiros-component>
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
       
        <template v-if="menu==31">
            <problemaspg-component></problemaspg-component>
        </template>
        <template v-if="menu==10">
             <proyectoprogramador-component></proyectoprogramador-component>
        </template>
        <template v-if="menu==7">
            <h1>Programador / 7</h1>
        </template>
        <template v-if="menu==8">
            <h1>Programador / 8</h1>
        </template>
        <template v-if="menu==19">
                <retiros-component></retiros-component>
            </template>
    <!-- Cliente -->
    @elseif(Auth::user()->rol_id == 4)
        <template v-if="menu==0">
            <h1>¡Bienvenido {{Auth::user()->usuario}}!</h1>
        </template>
        <template v-if="menu==1">
            <h1>Cliente / 1</h1>
        </template>
        <template v-if="menu==24">
           <inboxcliente-component></inboxcliente-component>
        </template>
        <template v-if="menu==4">
            <problemascliente-component></problemascliente-component>
        </template>
        <template v-if="menu==5">
            <h1>Cliente / 5</h1>
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
            <h1>Cliente / 8</h1>
        </template>
    @endif
@endsection
