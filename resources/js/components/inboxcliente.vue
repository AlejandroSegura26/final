<template>
    <main class="main" style="width: 100%; height: 100%;">
        <!-- Breadcrumb -->
        <ol class="breadcrumb col-lg-12">
            <li class="breadcrumb-item"><a href="/principal">Tablero</a></li>
            <li class="breadcrumb-item"><a @click="menu=24" href="#">Boletos</a></li>
            <li class="breadcrumb-item">Boletos Cliente</li>
        </ol>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-suitecase"></i>&nbsp;&nbsp;Boletos&nbsp;
                    
                    <button type="button" @click="abrirModal('inbox','nuevo',0,0)" class="btn btn-secondary float-right">
                        <i class="fa fa-plus"></i>&nbsp;Nuevo mensaje
                    </button>
                    
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Responder</th>
                                <th>Emisor</th>
                                <th>Receptor</th>
                                <th>Proyecto</th>
                                <th>Mensaje</th>
                                <th>Fecha Envio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="inbox in arrayinbox" :key="inbox.id">
                             
                                <template v-if ="inbox.estado == 'inicializado'">
                                <td>
                                  <button type="button" class="btn btn-success btn-sm" @click="abrirModal('inbox','mensaje',inbox.id_proyecto,inbox.id_manager)">
                                            <i class="far fa-envelope"></i>
                                        </button>
                                </td>
                                  </template>
                                  <template v-else>
                                          <td>Desactivado</td>
                                  </template>
                              <td v-text="inbox.nombre_emisor"></td>
                                <td v-text="inbox.nombre_receptor"></td>
                                <td v-text="inbox.titulo"></td>
                                <td v-text="inbox.mensaje"></td>
                                <td v-text="inbox.fecha_envio"></td>
                            </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin de Listado de los inbox -->
        </div>
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
                                <label class="col-md-3 form-control-label" for="text-input">Mensaje</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="mensaje"  class="form-control"
                                        placeholder="Mensaje...">
                                </div>

                            </div>


                        </form>
                         <form v-if="tipoAccion==2" action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Director De Proyecto</label>
                                <div class="col-md-9">
                                   <select class="form-control" v-model="id_manager">
                                        <option value="0">Seleccione una opción: </option>
                                        <option v-for="manager in arrayManager" :key="manager.id" :value="manager.id" v-text="manager.nombre">
                                        </option>
                                    </select>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Proyecto de referencia</label>
                                <div class="col-md-9">
                                   <select class="form-control" v-model="id_proyecto">
                                        <option value="0">Seleccione una opción: </option>
                                        <option v-for="proyecto in arrayProyecto" :key="proyecto.id" :value="proyecto.id" v-text="proyecto.titulo">
                                        </option>
                                    </select>
                                </div>
                            </div>
                           <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Mensaje</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="mensaje"  class="form-control"
                                        placeholder="Mensaje...">
                                </div>

                            </div>


                        </form>
                    </div>
                    <div class="modal-footer">
                        
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" class="btn btn-success" @click="enviarMensaje()">Enviar</button>

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
           
                arrayinbox: [],
                arrayProyecto:[],
                arrayManager:[],
                id_proyecto:0,
                id_manager:0,
                tipoAccion:0,
                tituloModal:'',
                mensaje:'',
                modal:0,
              
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
              
               offset: 3,
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
            listarinbox(page) {
                let me = this;
                
                var url = '/cliente/receptor?page='+ page;
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                   
                    me.arrayinbox = respuesta.inbox.data;
                   
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
          
            //Metodo para mostrar una determinada pagina y los registros asignados a ella
            cambiarPagina(page){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //Envia la peticion para visualizar los datos de esa pagina
                me.listarinbox(page);
            },
            //Método que sirve para mostrar el modal para guardar/actualizar un proveedor, en este se tiene 2 switch donde se hace uso del modelo correspondiente y la acción, se hace de esta manera debido a que se utiliza el mismo modal para ambas tareas mas sin embargo, los datos que se mandan al controlador son diferentes
            abrirModal(modelo, accion,id_proyecto,id_manager) {
                switch (modelo) {
                    case "inbox":
                    {
                        switch (accion) {
                            case 'mensaje':
                            {
                                this.modal = 1;
                                
                                this.tituloModal = 'Mandar Mensaje';
                                this.tipoAccion = 1;
                                this.id_proyecto = id_proyecto;
                                this.id_manager = id_manager;
                                this.mensaje = '';

                                break;
                            }
                            case 'nuevo':{
                                this.modal=1;
                                this.tituloModal = 'Mandar Mensaje';
                                this.tipoAccion = 2;
                                this.id_proyecto = 0;
                                this.id_manager = 0;
                                this.mensaje = '';
                              break;
                            }

                        }
                    }
                }
                this.selectManager();
                this.selectProyecto();
            },
          
            enviarMensaje(){
                        let me = this;
                        //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/desactivar' para llamar al controlador y ejecutar la tarea correspondiente
                        axios.post('/inbox/enviar',{
                            //Se le asignan los valores recopilados de los inputs del modal
                            'id_proyecto': this.id_proyecto,
                            'receptor':this.id_manager,
                            'mensaje':this.mensaje
                        }).then(function (response) {
                            //Se llama al metodo para enlistar las categorias y se muestra un mensaje mediante sweetalert
                            me.listarinbox(1);
                           
                            me.cerrarModal();
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
            },
            //Método que sirve para ocultar el modal una vez se pulsa sobre alguno de los 2 botones para cerrarlo
            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
             
                  this.id_proyecto = 0;
                                this.id_manager = 0;
                                this.mensaje = '';
            },
            selectProyecto(){
            let me = this;
                //Se le asigna la ruta al controlador que realiza la peticion al modelo para recopilar todos los roles
                var url = '/inbox/proyectoc';
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
            selectManager(){
               let me = this;
                //Se le asigna la ruta al controlador que realiza la peticion al modelo para recopilar todos los roles
                var url = '/inbox/manager';
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayRol'
                    me.arrayManager = respuesta.manager;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
          
           
        },
        //Se utiliza la propiedad 'mounted' para hacer el llamado a los métodos que se quieren cargar automaticamente una vez se muestra el componente 'usuario'
        mounted() {
          
            this.listarinbox(1);

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
