<template>
    <main class="main" style="width: 100%; height: 100%;">
        <!-- Breadcrumb -->
        <ol class="breadcrumb col-lg-12">
            <li class="breadcrumb-item"><a href="/principal">Tablero</a></li>
            <li class="breadcrumb-item"><a @click="menu=19" href="#">Retiros</a></li>
            <li class="breadcrumb-item">Solicitud de Retiros</li>
        </ol>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-suitecase"></i>&nbsp;&nbsp;Retiros&nbsp;
                      <button type="button" @click="abrirModal('gastos','registrar',0)" class="btn btn-secondary float-right">
                        <i class="fa fa-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="codigo_retiro">Codigo de retiro</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarGastos(1,buscar,criterio)" class="form-control"
                                    placeholder="Texto a buscar">
                                <button type="submit" @click="listarGastos(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i>
                                    Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>

                                <th>Codigo de retiro</th>
                                <th>Solicitante</th>
                                <th>Titulo de proyecto</th>
                                <th>Motivo</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Cantidad</th>
                                <th>Metodo de pago</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="gastos in arrayGastos" :key="gastos.id">

                                <td v-text="gastos.codigo_retiro"></td>
                                <td v-text="gastos.nombre"></td>
                                <td v-text="gastos.titulo"></td>
                                <td v-text="gastos.descripcion"></td>
                                <td v-text="gastos.fecha_gasto"></td>
                                <template v-if="gastos.estado == 0">
                                 <td>Pendiente</td>
                                </template>
                               <template v-if="gastos.estado == 1">
                                 <td>Aceptado</td>
                                </template>
                                <template v-if="gastos.estado == 2">
                                 <td>Rechazado</td>
                                </template>
                                <td v-text="gastos.monto"></td>
                                <td v-text="gastos.nombre_mp"></td>

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
                                <label class="col-md-3 form-control-label" for="text-input">Descripcion</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="descripcion" class="form-control"
                                        placeholder="Ingrese el motivo del retiro">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Codigo De Retiro</label>
                                <div class="col-md-9">
                                    <input type="text"  v-model="codigo_retiro" class="form-control"
                                        placeholder="Ingrese el codigo de retiro">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Proyectos Activos</label>
                                <div class="col-md-9">

                                    <select class="form-control" v-model="id_proyecto">
                                        <option value="0">Seleccione una opción: </option>
                                        <option v-for="proyecto in arrayProyecto" :key="proyecto.id" :value="proyecto.id" v-text="proyecto.titulo">
                                        </option>
                                    </select>

                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Metodos Activos para Pagos</label>
                                <div class="col-md-9">

                                    <select class="form-control" v-model="id_metodos">
                                        <option value="0">Seleccione una opción: </option>
                                        <option v-for="metodos in arrayMetodos" :key="metodos.id" :value="metodos.id" v-text="metodos.nombre_mp">
                                        </option>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Cantidad</label>
                                <div class="col-md-9">
                                    <input type="number" step="any" v-model="monto" min="0" class="form-control"
                                        placeholder="Ingrese la cantidad del retiro">
                                </div>

                            </div>
                            <div v-show="errorPeticion" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjPeticion" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span><b>(*)</b>&nbsp;Campo obligatorio de ingresar</span>
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarPeticion()">Guardar</button>

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
                id_gastos: 0,
                arrayGastos: [],
                arrayProyecto: [],
                arrayMetodos: [],
                errorPeticion:'',
                id_proyecto:0,
                id_metodos:0,
                codigo_retiro:'',
                descripcion:'',
                modal: 0,
                errorPeticion:'',
                tituloModal: '',
                tipoAccion: 0,
                monto:0,
                errorMostrarMsjPeticion:'',
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'codigo_retiro',
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
            listarGastos(page,buscar,criterio) {
                let me = this;
                //Se le asigna a la ruta '/cliente' los parametros 'buscar' y 'criterio' mediante el metodo get que se utiliza para buscar un registro de acuerdo a lo que ha ingresado el usuario en el input para buscar
                var url = '/retiro/programador?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayUsuario'
                    me.arrayGastos = respuesta.gastos.data;
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
                me.listarGastos(page,buscar,criterio);
            },

            abrirModal(modelo, accion, data = []) {
                switch (modelo) {
                    case "gastos":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Solicitar Retiro';
                                this.tipoAccion = 1;
                                this.codigo_retiro = '';
                                this.descripcion = '';
                                this.id_proyecto = 0;
                                this.id_metodos = 0;
                               this.monto=0;
                                break;
                            }


                        }
                    }
                }

                this.selectMetodoPago();
                this.selectProyecto();
            },
            //Método que sirve para ocultar el modal una vez se pulsa sobre alguno de los 2 botones para cerrarlo
            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
                this.codigo_retiro = 0;
                this.descripcion = '';
                this.id_proyecto = 0;
                this.id_metodos = 0;
              this.monto=0,
                this.errorProyecto= 0;
            },

            registrarPeticion(){
                let me = this;
                
                axios.post('/retiro/agregar',{
                    //Se le asignan los valores recopilados de los inputs del modal
                    'id_metodo_pago': this.id_metodos,
                    'id_proyecto': this.id_proyecto,
                    'descripcion':this.descripcion,
                    'codigo_retiro':this.codigo_retiro,
                    'monto':this.monto

                }).then(function (response) {
                    //Se llama al metodo 'cerrarModal' para ocultarlo y se vuelve a enlistar las categorias de forma descendente, es decir, el registro recien ingresado sera el primero
                    me.cerrarModal();
                    me.listarGastos(1,'','codigo_retiro');
                }).catch(function (error) {
                    console.log(error);
                });
            },

            selectMetodoPago(){
               let me = this;
                //Se le asigna la ruta al controlador que realiza la peticion al modelo para recopilar todos los roles
                var url = '/metodo/selectMetodoPago';
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayRol'
                    me.arrayMetodos = respuesta.metodo;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            selectProyecto(){
               let me = this;
                //Se le asigna la ruta al controlador que realiza la peticion al modelo para recopilar todos los roles
                var url = '/proyecto/selectProyecto';
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayRol'
                    me.arrayProyecto = respuesta.proyecto;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }


        },
        //Se utiliza la propiedad 'mounted' para hacer el llamado a los métodos que se quieren cargar automaticamente una vez se muestra el componente 'usuario'
        mounted() {

            this.listarGastos(1,this.buscar,this.criterio);

        }
    }
</script>
