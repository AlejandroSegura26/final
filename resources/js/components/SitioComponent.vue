<template>
    <main class="main" style="width: 100%; height: 100%;">
        <!-- Breadcrumb -->
        <ol class="breadcrumb col-lg-12">
            <li class="breadcrumb-item"><a href="/principal">Tablero</a></li>
            <li class="breadcrumb-item">Sitio</li>
        </ol>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-map-marker"></i>&nbsp;&nbsp;Sitios&nbsp;
                    <button type="button" @click="abrirModal('sitio','registrar',0)" class="btn btn-secondary float-right">
                        <i class="fa fa-plus"></i>&nbsp;Nuevo
                    </button>
                    <a type="button" href="/sitio" class="btn btn-secondary float-right">
                        <i class="fa fa-eye"></i>&nbsp;Ver Sitio
                    </a>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="actividades">Actividades</option>
                                    <option value="acercade">Acerca de</option>
                                    <option value="ubicacion">Ubicación</option>
                                    <option value="piepagina">Pie de Página</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarSitio(1,buscar,criterio)" class="form-control"
                                    placeholder="Texto a buscar">
                                <button type="submit" @click="listarSitio(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i>
                                    Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Actividades</th>
                                <th>Acerca de</th>
                                <th>Ubicación</th>
                                <th>Pie de página</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="sitio in arraySitio" :key="sitio.id">
                                <td v-text="sitio.unombre"></td>
                                <td v-text="sitio.actividades"></td>
                                <td v-text="sitio.acercade"></td>
                                <td v-text="sitio.ubicacion"></td>
                                <td v-text="sitio.piepagina"></td>
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
                                <label class="col-md-3 form-control-label" for="text-input">Actividades</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="actividades" class="form-control"
                                        placeholder="Ingrese las actividades que realiza">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Acerca de</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="acercade" class="form-control"
                                        placeholder="Ingrese su informacion">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Ubicación</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="ubicacion" class="form-control"
                                        placeholder="Ingrese su ubicación">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Pie de página</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="piepagina" class="form-control"
                                        placeholder="Ingrese el pie de página">
                                </div>
                            </div>
                            <div v-show="errorSitio" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjSitio" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span><b>(*)</b>&nbsp;Campo obligatorio de ingresar</span>
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarSitio()">Guardar</button>
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
                id_sitio: 0,
                id_usuario: 0,
                actividades: '',
                acercade: '',
                ubicacion: '',
                piepagina: '',
                arraySitio: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorSitio: 0,
                errorMostrarMsjSitio: [],
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,
                criterio: 'actividades',
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
            listarSitio(page,buscar,criterio) {
                let me = this;
                //Se le asigna a la ruta '/cliente' los parametros 'buscar' y 'criterio' mediante el metodo get que se utiliza para buscar un registro de acuerdo a lo que ha ingresado el usuario en el input para buscar
                var url = '/site?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayUsuario'
                    me.arraySitio = respuesta.sitios.data;
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
                me.listarSitio(page,buscar,criterio);
            },
            //Método para registrar una categoria a la base de datos
            registrarSitio() {
                //Verifica que el método 'verificarCategoria' haya devuelto un valor, en ese caso, no se realiza ninguna tarea hasta que esto no sea cierto
                if (this.validarSitio()) {
                    return;
                }
                let me = this;
                //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/registrar' para llamar al controlador y ejecutar la tarea correspondiente
                axios.post('/site/registrar',{
                    //Se le asignan los valores recopilados de los inputs del modal
                    'actividades': this.actividades,
                    'acercade': this.acercade,
                    'ubicacion': this.ubicacion,
                    'piepagina': this.piepagina,
                }).then(function (response) {
                    //Se llama al metodo 'cerrarModal' para ocultarlo y se vuelve a enlistar las categorias de forma descendente, es decir, el registro recien ingresado sera el primero
                    me.cerrarModal();
                    me.listarSitio(1,'','actividades');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            //Método para actualizar un registro de la tabla 'persona'
            actualizarProyecto() {
                //Verifica que el método 'verificarCategoria' haya devuelto un valor, en ese caso, se muestran los errores al usuario que son arrojados debido a que algun campo obligatorio esta vacio
                if (this.validarProyecto()) {
                    return;
                }
                let me = this;
                //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/actualizar' para llamar al controlador y ejecutar la tarea correspondiente
                axios.put('/proyecto/actualizar',{
                    //Se le asignan los valores recopilados de los inputs del modal
                     'titulo': this.titulo,
                    'id_cliente': this.id_cliente,
                    'id_manager': this.id_manager,
                    'descripcion': this.descripcion,
                    'fecha_inicio': this.fecha_inicio,
                    'fecha_final': this.fecha_final,
                    'id': this.id_proyecto
                }).then(function (response) {
                    //Se llama al metodo 'cerrarModal' para ocultarlo y se vuelve a enlistar las categorias de forma descendente, es decir, el registro recien ingresado sera el primero
                    me.cerrarModal();
                    me.listarProyecto(1,'','titulo');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            //Método que sirve para mostrar en el modal errores cuando el usuario no ingresa texto en el input mediante el uso de un array del apartado de estilos
            validarSitio() {
                this.errorSitio = 0;
                this.errorMostrarMsjSitio = [];
                if (!this.actividades) this.errorMostrarMsjSitio.push("Actividades vacío");
                if (!this.acercade) this.errorMostrarMsjSitio.push("Acerca de vacío");
                if (!this.ubicacion) this.errorMostrarMsjSitio.push("Ubicación vacía");
                if (!this.piepagina) this.errorMostrarMsjSitio.push("Pie de página vacío");
                if (this.errorMostrarMsjSitio.length) this.errorSitio = 1;
                return this.errorSitio;
            },
            //Método que sirve para mostrar el modal para guardar/actualizar un proveedor, en este se tiene 2 switch donde se hace uso del modelo correspondiente y la acción, se hace de esta manera debido a que se utiliza el mismo modal para ambas tareas mas sin embargo, los datos que se mandan al controlador son diferentes
            abrirModal(modelo, accion, data = [],id) {
                switch (modelo) {
                    case "sitio":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Sitio';
                                this.tipoAccion = 1;
                                this.id_usuario = 0;
                                this.actividades = '';
                                this.acercade = '';
                                this.ubicacion = '';
                                this.piepagina = '';
                                break;
                            }
                        }
                    }
                }
            },
            //Método que sirve para ocultar el modal una vez se pulsa sobre alguno de los 2 botones para cerrarlo
            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
                this.id_sitio=0;
                this.actividades='';
                this.acercade='';
                this.ubicacion='';
                this.piepagina='';
                this.id_usuario=0;
                this.errorSitio= 0;
            }
        },
        //Se utiliza la propiedad 'mounted' para hacer el llamado a los métodos que se quieren cargar automaticamente una vez se muestra el componente 'usuario'
        mounted() {
            this.listarSitio(1,this.buscar,this.criterio);
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
