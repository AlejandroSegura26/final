<template>
    <main class="main" style="width: 100%; height: 100%;">
        <!-- Breadcrumb -->
        <ol class="breadcrumb col-lg-12">
            <li class="breadcrumb-item"><a href="/principal">Tablero</a></li>
            <li class="breadcrumb-item"><a @click="menu=25" href="#">Servicios</a></li>
            <li class="breadcrumb-item">Manager</li>
        </ol>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-suitecase"></i>&nbsp;&nbsp;Proyectos&nbsp;
                      <button type="button" @click="abrirModal('servicio','registrar',0)" class="btn btn-secondary float-right">
                        <i class="fa fa-plus"></i>&nbsp;Agregar Servicio
                    </button>
                     <button type="button" @click="menu=27" class="btn btn-secondary float-right">
                        <i class="fa fa-plus"></i>&nbsp;ver servicios con proyectos
                    </button>
                   
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="nombre">Nombre</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarServicio(1,buscar,criterio)" class="form-control"
                                    placeholder="Texto a buscar">
                                <button type="submit" @click="listarServicio(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i>
                                    Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Servicio</th>
                                <th>Costo</th>
                       
                                <th>Estado del servicio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="servicio in arrayServicio" :key="servicio.id">
                             
                                <td> <template v-if="servicio.estado == 'disponible'">
                                     <button type="button" @click="abrirModal('servicio','agregar',servicio.id)" class="btn btn-warning btn-sm">
                                        <i class="fas fa-plus"></i>
                                    </button> &nbsp;
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarServicio(servicio.id)">
                                            <i class="far fa-eye-slash"></i>
                                        </button>
                                    </template>
                                    <template v-else ><button type="button" class="btn btn-success btn-sm" @click="activarServicio(servicio.id)">
                                            <i class="far fa-eye-slash"></i>
                                        </button> </template>
                                </td>
                      
                                <td v-text="servicio.nombre"></td>
                                <td v-text="servicio.costo"></td>
             
                                <td v-text="servicio.estado"></td>
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
            <!-- Fin de Listado Usuarios-->
            
             <template v-if="menu==27">
                    <verserviciosproyectos-component></verserviciosproyectos-component>
                    </template>

   <!--Inicio del modal agregar-->
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
                        <form v-if="tipoAccion==1" action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            
                           <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre"  class="form-control"
                                        placeholder="Nombre del servicio">
                                </div>

                            </div>
                          
                           <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Costo</label>
                                <div class="col-md-9">
                                    <input type="number" min="1"  v-model="costo"  class="form-control"
                                        placeholder="Costo">
                                </div>

                            </div>


                        </form>
                        <form v-if="tipoAccion==2" action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                           
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Proyecto a agregar Servicio</label>
                                <div class="col-md-9">
                                   <select class="form-control" v-model="id_proyecto">
                                        <option value="0">Seleccione una opción: </option>
                                        <option v-for="proyecto in arrayProyecto" :key="proyecto.id" :value="proyecto.id" v-text="proyecto.titulo">
                                        </option>
                                    </select>
                                </div>
                            </div>
              
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span><b>(*)</b>&nbsp;Campo obligatorio de ingresar</span>
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==2"  class="btn btn-success" @click="guardar()">Registrar</button>
                        <button type="button" v-if="tipoAccion==1"  class="btn btn-success" @click="registrar()">Guardar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
        </div>
    </main>
</template>

<script>
    export default {
        //Propiedad 'data' de javascript donde se declaran las variables necesarias para el funcionamiento del modulo 'categorias', dentro de estas variables tenemos las encargadas de la paginacion, del crud, de la busqueda de registros y del activado y desactivado de la cliente
        data() {
            return {
                id_servicio: 0,
                arrayServicio: [],
                arrayProyecto:[],
                id_proyecto:0,
                costo:0,
                nombre:'',
                menu:0,
              modal:0,
              tipoAccion:0,
                tituloModal:'',
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'nombre',
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
            listarServicio(page,buscar,criterio) {
                let me = this;
                //Se le asigna a la ruta '/cliente' los parametros 'buscar' y 'criterio' mediante el metodo get que se utiliza para buscar un registro de acuerdo a lo que ha ingresado el usuario en el input para buscar
                var url = '/servicios?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayUsuario'
                    me.arrayServicio = respuesta.servicios.data;
                    //Guarda en el arreglo 'pagination' las variables necesarias para llevar a cabo estas tareas
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
          
            //Metodo para mostrar una determinada pagina y los registros asignados a ella
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //Envia la peticion para visualizar los datos de esa pagina
                me.listarServicio(page,buscar,criterio);
            },
            
            //Método para desactivar un usuario y no pueda acceder al sistema
            desactivarServicio(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: '¿Estás seguro de  desactivar el servicio?     ',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/desactivar' para llamar al controlador y ejecutar la tarea correspondiente
                        axios.put('/servicios/desactivar',{
                            //Se le asignan los valores recopilados de los inputs del modal
                            'id': id
                        }).then(function (response) {
                            //Se llama al metodo para enlistar las categorias y se muestra un mensaje mediante sweetalert
                            me.listarServicio(1,'','nombre');
                            swalWithBootstrapButtons.fire(
                            '¡Desactivado!',
                            'El servicio ha sido cancelado con éxito.',
                            'success'
                            )
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
           //Método para desactivar un usuario y no pueda acceder al sistema
            activarServicio(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: '¿Estás seguro de  activar el servicio?     ',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/desactivar' para llamar al controlador y ejecutar la tarea correspondiente
                        axios.put('/servicios/activar',{
                            //Se le asignan los valores recopilados de los inputs del modal
                            'id': id
                        }).then(function (response) {
                            //Se llama al metodo para enlistar las categorias y se muestra un mensaje mediante sweetalert
                            me.listarServicio(1,'','nombre');
                            swalWithBootstrapButtons.fire(
                            '¡activado!',
                            'El servicio ha sido activado con éxito.',
                            'success'
                            )
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
            selectProyecto(){
            let me = this;
                //Se le asigna la ruta al controlador que realiza la peticion al modelo para recopilar todos los roles
                var url = '/proyecto/admin';
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayRol'
                    me.arrayProyecto = respuesta.proyecto;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            
            //Método que sirve para mostrar el modal para guardar/actualizar un proveedor, en este se tiene 2 switch donde se hace uso del modelo correspondiente y la acción, se hace de esta manera debido a que se utiliza el mismo modal para ambas tareas mas sin embargo, los datos que se mandan al controlador son diferentes
            abrirModal(modelo, accion,id) {
                switch (modelo) {
                    case "servicio":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.id = id;
                                this.tituloModal = 'Registrar Servicio';
                                this.tipoAccion = 1;
                                
                                this.nombre = '';
                                
               
                                this.costo = 0;
                                break;
                            }
                            
                          case 'agregar':
                            {
                                this.modal = 1;
                                this.id = id;
                                this.tituloModal = 'Agregar servicio a proyecto';
                                this.tipoAccion = 2;
                                this.id_servicio=id;
                                this.nombre = '';
                                this.id_proyecto=0;
        
                                this.costo = 0;
                                break;
                            }

                        }
                    }
                }
                this.selectProyecto();

            },
            //Método que sirve para ocultar el modal una vez se pulsa sobre alguno de los 2 botones para cerrarlo
            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
                this.nombre = '';
                                this.id_proyecto=0;
                                this.id_servicio =0;
                                this.costo = 0;
                                
               
            },
          
          registrar(){
             let me = this;
             
                axios.post('/servicios/agregar',{
                  
                    'nombre': this.nombre,
                   
                    'costo':this.costo

                }).then(function (response) {
                    //Se llama al metodo 'cerrarModal' para ocultarlo y se vuelve a enlistar las categorias de forma descendente, es decir, el registro recien ingresado sera el primero
                    me.cerrarModal();
                    me.listarServicio(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
          },
          guardar(){
            let me = this;
                 axios.post('/servicios/proyecto',{
                  
                    'id_proyecto':this.id_proyecto,
                    'id_servicio':this.id_servicio,

                }).then(function (response) {
                    //Se llama al metodo 'cerrarModal' para ocultarlo y se vuelve a enlistar las categorias de forma descendente, es decir, el registro recien ingresado sera el primero
                    me.cerrarModal();
                  
                }).catch(function (error) {
                    console.log(error);
                });
          }
          
           
        },
        //Se utiliza la propiedad 'mounted' para hacer el llamado a los métodos que se quieren cargar automaticamente una vez se muestra el componente 'usuario'
        mounted() {
          
            this.listarServicio(1,this.buscar,this.criterio);

        }
    }
</script>