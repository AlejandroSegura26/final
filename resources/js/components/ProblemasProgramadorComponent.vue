<template>
    <main class="main" style="width: 100%; height: 100%;">
        <!-- Breadcrumb -->
        <ol class="breadcrumb col-lg-12">
            <li class="breadcrumb-item"><a href="/principal">Tablero</a></li>
            <li class="breadcrumb-item">Problemas</li>
        </ol>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-bookmark"></i>&nbsp;&nbsp;Problemas&nbsp;
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="descripcion">Descripción</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarProblema(1,buscar,criterio)" class="form-control"
                                    placeholder="Texto a buscar">
                                <button type="submit" @click="listarProblema(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i>
                                    Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Programador</th>
                                <th>Proyecto</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="problema in arrayProblema" :key="problema.id">
                                <td>
                                    <template v-if="problema.estado == 1">
                                        <button type="button" @click="abrirModal('problema','actualizar',problema,problema.id)" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                        </button>
                                    </template>
                                </td>
                                <td v-if="problema.rol_id == 4"></td>
                                <td v-else v-text="problema.pnombre"></td>
                                <td v-text="problema.ptitulo"></td>
                                <td v-text="problema.descripcion"></td>
                                <td v-if="problema.estado == 1">En Progreso</td>
                                <td v-if="problema.estado == 2">Resuelto</td>
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
            <!-- Fin de Listado -->
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
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Estado</label>
                                <div class="col-md-9">
                                   <select class="form-control" v-model="estado">
                                        <option value="0">Seleccione una opción: </option>
                                        <option value="2">Resuelto</option>
                                    </select>
                                </div>
                            </div>
                            <div v-show="errorProblema" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjProblema" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span><b>(*)</b>&nbsp;Campo obligatorio de ingresar</span>
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==3" class="btn btn-warning" @click="actualizarProblema()">Actualizar</button>
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
                usuario_id: 0,
                descripcion: '',
                estado: 0,
                proyecto_id: 0,
                problema_id: 0,
                arrayProgramador:[],
                arrayProyecto: [],
                arrayProblema: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorProblema: 0,
                errorMostrarMsjProblema: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'descripcion',
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
            listarProblema(page,buscar,criterio) {
                let me = this;
                //Se le asigna a la ruta '/problema' los parametros 'buscar' y 'criterio' mediante el metodo get que se utiliza para buscar un registro de acuerdo a lo que ha ingresado el usuario en el input para buscar
                var url = '/problema/problemasadmin?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayProblema'
                    me.arrayProblema = respuesta.problemas.data;
                    //Guarda en el arreglo 'pagination' las variables necesarias para llevar a cabo estas tareas
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectProyecto( ) {
                let me = this;
                //Se le asigna a la ruta '/cliente' los parametros 'buscar' y 'criterio' mediante el metodo get que se utiliza para buscar un registro de acuerdo a lo que ha ingresado el usuario en el input para buscar
                var url = '/usuario/selectProyecto';
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayUsuario'
                    me.arrayProyecto  = respuesta.proyecto;
                    //Guarda en el arreglo 'pagination' las variables necesarias para llevar a cabo estas tareas
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectProgramador(){
               let me = this;
                //Se le asigna la ruta al controlador que realiza la peticion al modelo para recopilar todos los roles
                var url = '/usuario/selectProgramador';
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayRol'
                    me.arrayProgramador = respuesta.programador;
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
                me.listarProblema(page,buscar,criterio);
            },
            //Método para actualizar un registro de la tabla 'persona'
            actualizarProblema() {
                //Verifica que el método 'verificarCategoria' haya devuelto un valor, en ese caso, se muestran los errores al usuario que son arrojados debido a que algun campo obligatorio esta vacio
                if (this.validarProblema()) {
                    return;
                }
                let me = this;
                //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/actualizar' para llamar al controlador y ejecutar la tarea correspondiente
                axios.put('/problema/actualizarProblema',{
                    //Se le asignan los valores recopilados de los inputs del modal
                    'estado': this.estado,
                    'id': this.problema_id
                }).then(function (response) {
                    //Se llama al metodo 'cerrarModal' para ocultarlo y se vuelve a enlistar las categorias de forma descendente, es decir, el registro recien ingresado sera el primero
                    me.cerrarModal();
                    me.listarProblema(1,'','descripcion');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            //Método que sirve para mostrar en el modal errores cuando el usuario no ingresa texto en el input mediante el uso de un array del apartado de estilos
            validarProblema() {
                this.errorProblema = 0;
                this.errorMostrarMsjProblema = [];
                if (!this.estado) this.errorMostrarMsjProblema.push("Seleccione un estado.");
                if (this.errorMostrarMsjProblema.length) this.errorProblema = 1;
                return this.errorProblema;
            },
            //Método que sirve para mostrar el modal para guardar/actualizar un proveedor, en este se tiene 2 switch donde se hace uso del modelo correspondiente y la acción, se hace de esta manera debido a que se utiliza el mismo modal para ambas tareas mas sin embargo, los datos que se mandan al controlador son diferentes
            abrirModal(modelo, accion, data = [],id) {
                switch (modelo) {
                    case "problema":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Problema';
                                this.tipoAccion = 1;
                                this.usuario_id = 0;
                                this.proyecto_id = 0;
                                this.descripcion = '';
                                this.estado = 1;
                                break;
                            }
                            case 'asignar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Asignar problema a un programador';
                                this.tipoAccion = 2;
                                this.usuario_id = 0;
                                this.problema_id = id;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Cambiar estado del problema';
                                this.tipoAccion = 3;
                                this.estado = 0;
                                this.problema_id = id;
                                break;
                            }
                        }
                    }
                }
                this.selectProyecto();
                this.selectProgramador();
            },
            //Método que sirve para ocultar el modal una vez se pulsa sobre alguno de los 2 botones para cerrarlo
            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
                this.usuario_id = 0;
                this.proyecto_id = 0;
                this.descripcion = '';
                this.estado = 0;
                this.errorProblema = 0;
            },
        },
        //Se utiliza la propiedad 'mounted' para hacer el llamado a los métodos que se quieren cargar automaticamente una vez se muestra el componente 'usuario'
        mounted() {
            this.listarProblema(1,this.buscar,this.criterio);
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
