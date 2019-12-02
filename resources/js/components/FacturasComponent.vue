<template>
    <main class="main" style="width: 100%; height: 100%;">
        <!-- Breadcrumb -->
        <ol class="breadcrumb col-lg-12">
            <li class="breadcrumb-item"><a href="/principal">Tablero</a></li>
            <li class="breadcrumb-item">Director de proyectos</li>
            <li class="breadcrumb-item"><a @click="menu=5" href="#">Facturas</a></li>
            
        </ol>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-thumbtack"></i>&nbsp;&nbsp;Facturas&nbsp;
                    <button type="button" @click="abrirModal('factura','registrar',0)" class="btn btn-secondary float-right">
                        <i class="fa fa-plus"></i>&nbsp;Nuevo
                    </button>
                  
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="razon">Razon</option>
                                    <option value="codigo_factura">Codigo</option>
                                </select>
                                 <input type="text" v-model="buscar" @keyup.enter="listarFactura(1,buscar,criterio)" class="form-control"
                                    placeholder="Texto a buscar">
                                <button type="submit" @click="listarFactura(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i>
                                    Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Codigo</th>
                                <th>Razon</th>
                                <th>Cliente</th>
                                <th>Fecha de factura</th>
                                <th>Fecha de vencimiento</th>
                                <th>Monto</th>
                                <th>Monto pagado</th>                              
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                           <tr v-for="factura in arrayFactura" :key="factura.id">
                          <td>
                            <button type="button" @click="abrirModal('factura','actualizar',factura,factura.id)" class="btn btn-warning btn-sm">
                                        <i class="fas fa-pen"></i>
                            </button> &nbsp;
                            <template v-if="factura.estado_factura==0">
                             <button type="button" @click="cancelarFactura(factura.id)" class="btn btn-warning btn-sm">
                                        <i class="fas fa-eye-slash"></i>
                            </button> &nbsp;
                                </template>     
                          </td>
                          <td v-text="factura.codigo_factura"></td>
                          <td v-text="factura.razon"></td>
                          <td v-text="factura.nombre"></td>
                          <td v-text="factura.fecha_factura"></td>
                          <td v-text="factura.vencimiento_factura"></td>
                          <td v-text="factura.monto"></td>
                          <td v-text="factura.monto_pagado"></td>
                          <template v-if="factura.estado_factura==0">
                            <td  >Activo</td>
                          </template>     
                           <template v-if="factura.estado_factura==1">
                            <td  >Pagado</td>
                          </template>
                          <template v-if="factura.estado_factura==2">
                            <td >Cancelado</td>
                          </template>

                  </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin de Listado Usuarios -->

            <template style="margin-top:10px;" v-if="menu==15">
                <tareas-component></tareas-component>
            </template>


        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel"
            style="display: none; overflow-y: scroll; padding-top: 55px;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form v-if="tipoAccion != 3" action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Razon<b>(*)</b></label>
                                <div class="col-md-9">
                                    <input type="text" v-model="razon" class="form-control"
                                        placeholder="Ingrese razon de la factura ">
                                </div>
                            </div>
                            
                           <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Cliente <b>(*)</b></label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="id_cliente">
                                        <option value="0">Seleccione una opción: </option>
                                        <option v-for="cliente in arrayCliente" :key="cliente.id" :value="cliente.id" v-text="cliente.nombre"></option>
                                    </select>
                                </div>
                            </div>
                           
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Metodo de pago <b>(*)</b></label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="id_metodo">
                                        <option value="0">Seleccione una opción: </option>
                                        <option v-for="metodo in arrayMetodo" :key="metodo.id" :value="metodo.id" v-text="metodo.nombre_mp"></option>
                                    </select>
                                </div>
                            </div>
                               

                               
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Fecha vencimiento<b>(*)</b></label>
                                <div class="col-md-9">
                                    <input type="date" v-model="vencimiento_factura" class="form-control"
                                        placeholder="Ingrese la fecha vencimiento de vencimiento de la factura" min="<?php echo $fecha = date()?>" >

                                </div>
                            </div>
                            
                           <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Monto<b>(*)</b></label>
                                <div class="col-md-9">
                                    <input type="text" v-model="monto" class="form-control"
                                        placeholder="Ingrese monto de la factura ">
                                </div>
                            </div>
                          
                            <div v-show="errorProyecto" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjFactura" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
 
                    </div>
                    <div class="modal-footer">
                        <span><b>(*)</b>&nbsp;Campo obligatorio de ingresar</span>
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarFactura()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="actualizarFactura()">Actualizar</button>
 
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    </main>
</template>

<script>
    export default {
        //Propiedad 'data' de javascript donde se declaran las variables necesarias para el funcionamiento del modulo 'categorias', dentro de estas variables tenemos las encargadas de la paginacion, del crud, de la busqueda de registros y del activado y desactivado de la cliente
        data() {
            return { 
                id_factura:0,
                titulo: '',
                menu:0,
                modal: 0,
                id_metodo:0,
                id_cliente:0,
                monto:0,
                razon:'',
                vencimiento_factura:0,
                arrayMetodo:[],
                arrayFactura:[],
                arrayCliente:[],
                tituloModal: '',
                tipoAccion: 0,
                errorProyecto: 0,
                errorTarea:0,
                errorMostrarMsjFactura: [],
               errorMostrarMsjTarea: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'titulo',
                buscar: ''
            }
        },
        //Métodos computados para realizar la paginacion, el metodo isActived -> devuelve la página actual, el metodo pagesNumber -> devuelve un arreglo con las diferentes paginas de acuerdo a cuantos registros se desean mostrar
        computed: {
            isActived: function() {
                return this.pagination.current_page;
            },
            pagesNumber: function() {
                //Verifica si la variable 'to' tiene algun valor, si no es caso, entonces inicializa el arreglo de las paginas como vacio y solo se mostraran los botones siguiente y anterior
                if (!this.pagination.to) {
                    return [];
                }
                //Se declara una variable que guarda la diferencia entre el valor de la pagina actual y un valor 'predeterminado'
                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                //Se declara una variable que sirve para ir a una pagina de todas
                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                //Se declara un arreglo el cual recibira todas las paginas creadas mediante el metodo paginate y se usara para mostrarse en la opcion correspondiente mediante directivas v-text
                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        //Métodos para mostrar, guardar, actualizar, desactivar y activar el usuario
        methods: {
            //Metodo para obtener todos los registros de la bd mediante el uso del controlador definido y en este caso, se tiene tambien la implementacion de la paginacion para ver los registros de acuerdo a lo establecido en el modelo (10 modelos por pagina) y se implementa la busqueda de registros en este metodo debido a que es el que se encarga de mostrar los datos de acuerdo al criterio elegido si es que se ha introducido un texto o mostrar todos los datos en caso de que no sea asi
            listarFactura(page,buscar,criterio) {
                 let me = this;
                //Se le asigna a la ruta '/cliente' los parametros 'buscar' y 'criterio' mediante el metodo get que se utiliza para buscar un registro de acuerdo a lo que ha ingresado el usuario en el input para buscar
                var url = '/factura?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayUsuario'
                    me.arrayFactura = respuesta.factura.data;
                    //Guarda en el arreglo 'pagination' las variables necesarias para llevar a cabo estas tareas
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                }); 
            },
 
       
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //Envia la peticion para visualizar los datos de esa pagina
                me.listarFactura(page,buscar,criterio);
            },
          registrarFactura() {
                //Verifica que el método 'verificarCategoria' haya devuelto un valor, en ese caso, no se realiza ninguna tarea hasta que esto no sea cierto
                if ( this.validarFactura()) {
                    return;
                }
                let me = this;
                //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/registrar' para llamar al controlador y ejecutar la tarea correspondiente
                axios.post('/factura/registrar',{
                    //Se le asignan los valores recopilados de los inputs del modal
                    'id_metodo': this.id_metodo,
                    'id_cliente':this.id_cliente,
                    'razon':this.razon,
                    'vencimiento_factura':this.vencimiento_factura,
                    'monto':this.monto
                }).then(function (response) {
                    //Se llama al metodo 'cerrarModal' para ocultarlo y se vuelve a enlistar las categorias de forma descendente, es decir, el registro recien ingresado sera el primero
                  
                  me.cerrarModal();
                    me.listarFactura(1,'','titulo');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
          
              actualizarFactura() {
                //Verifica que el método 'verificarCategoria' haya devuelto un valor, en ese caso, se muestran los errores al usuario que son arrojados debido a que algun campo obligatorio esta vacio
                if (this.validarFactura()) {
                    return;
                }
                let me = this;
                //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/actualizar' para llamar al controlador y ejecutar la tarea correspondiente
                
                axios.put('/factura/actualizar',{
                    //Se le asignan los valores recopilados de los inputs del modal  
                    'id': this.id_factura,
                     'id_metodo': this.id_metodo,
                    'id_cliente':this.id_cliente,
                    'razon':this.razon,
                    'vencimiento_factura':this.vencimiento_factura,
                    'monto':this.monto
                }).then(function (response) {
                    //Se llama al metodo 'cerrarModal' para ocultarlo y se vuelve a enlistar las categorias de forma descendente, es decir, el registro recien ingresado sera el primero
                   
                  me.cerrarModal();
                    me.listarFactura(1,'','titulo');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            //Método que sirve para mostrar en el modal errores cuando el usuario no ingresa texto en el input mediante el uso de un array del apartado de estilos
            validarFactura() {
                this.errorProyecto = 0;
                this.errorMostrarMsjFactura = [];
 
                if (!this.razon) this.errorMostrarMsjFactura.push("La razon no puede estar vacia ");
                if (!this.id_metodo) this.errorMostrarMsjFactura.push("Debe de elegir un metodo de pago ");
                if (!this.id_cliente) this.errorMostrarMsjFactura.push("Debe de elegir un cliente");
                if (!this.vencimiento_factura) this.errorMostrarMsjFactura.push("Debe elegir una fecha de vencimiento");
                if (!this.monto) this.errorMostrarMsjFactura.push("El monto no puede estar vacio ");
                if (this.errorMostrarMsjFactura.length) this.errorProyecto = 1;
                return this.errorProyecto;
            },
         
            //Método que sirve para mostrar el modal para guardar/actualizar un proveedor, en este se tiene 2 switch donde se hace uso del modelo correspondiente y la acción, se hace de esta manera debido a que se utiliza el mismo modal para ambas tareas mas sin embargo, los datos que se mandan al controlador son diferentes
            abrirModal(modelo, accion, data = [],id) {
                switch (modelo) {
                    case "factura":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar factura';
                                this.tipoAccion = 1;
                                this.id_metodo=0;
                                this.id_cliente=0;
                                this.razon=0;
                                this.vencimiento_factura=0;
                                this.monto=0;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Actualizar factura';
                                this.tipoAccion = 2;
                                this.id_factura=id;
                                this.id_metodo=data['id_metodo'];
                                this.id_cliente=data['id_cliente'];
                                this.razon=data['razon'];
                                this.vencimiento_factura=data['vencimiento_factura'];
                                this.monto=data['monto'];
                                break;
                            }
                 
                        }
                    }
                }
                this.selectMetodo();
                this.selectCliente();
            },
          cancelarFactura(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: '¿Estás seguro de cancelar esa factura?     ',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/desactivar' para llamar al controlador y ejecutar la tarea correspondiente
                        axios.post('/factura/cancelar',{
                            'id':id,
                        }).then(function (response) {
                            //Se llama al metodo para enlistar las categorias y se muestra un mensaje mediante sweetalert
                           
                              swalWithBootstrapButtons.fire(
                            '¡Cancelada!',
                            'El factura ha sido cancelada con éxito.',
                            'success'
                            ) 
                            me.listarFactura(1,'','titulo');
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                    }
                })
            },
            //Método que sirve para ocultar el modal una vez se pulsa sobre alguno de los 2 botones para cerrarlo
            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
                this.id_metodo=0;
                this.razon="";
                this.vencimiento_factura=0;
                this.monto=0;
                this.errorProyecto= 0;
            },
           
          selectMetodo( ) {
                 let me = this;
                //Se le asigna a la ruta '/cliente' los parametros 'buscar' y 'criterio' mediante el metodo get que se utiliza para buscar un registro de acuerdo a lo que ha ingresado el usuario en el input para buscar
                var url = '/metodo/selectMetodoPago';
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayUsuario'
                    me.arrayMetodo  = respuesta.metodo;
                    //Guarda en el arreglo 'pagination' las variables necesarias para llevar a cabo estas tareas
 
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectCliente( ) {
                 let me = this;
                //Se le asigna a la ruta '/cliente' los parametros 'buscar' y 'criterio' mediante el metodo get que se utiliza para buscar un registro de acuerdo a lo que ha ingresado el usuario en el input para buscar
                var url = '/usuario/selectCliente';
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayUsuario'
                    me.arrayCliente  = respuesta.cliente;
                    //Guarda en el arreglo 'pagination' las variables necesarias para llevar a cabo estas tareas
 
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
           
        },
        //Se utiliza la propiedad 'mounted' para hacer el llamado a los métodos que se quieren cargar automaticamente una vez se muestra el componente 'usuario'
        mounted() {

            this.listarFactura(1,this.buscar,this.criterio);

        }
    }
</script>
<!--Estilos para el modal y los mensajes de error-->
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3C29297A !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
<!--\ Fin de estilos para el modal y los mensajes de error-->
