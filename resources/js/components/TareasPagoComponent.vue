<template>
    <main class="main" style="width: 100%; height: 100%;">
        <!-- Breadcrumb -->
                <ol class="breadcrumb col-lg-12">
            <li class="breadcrumb-item"><a href="/principal">Tablero</a></li>
            <li class="breadcrumb-item"><a @click="menu=5" href="#">Director de proyectos</a></li>
            <li class="breadcrumb-item">Tareas</li>
        </ol>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-credit-card"></i>&nbsp;&nbsp;Métodos de Pago&nbsp;
                    <button type="button" @click="abrirModal('metodo','registrar')" class="btn btn-secondary float-right">
                        <i class="fa fa-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="nombre_mp">Nombre</option>
                                   
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarMetodo(1,buscar,criterio)" class="form-control"
                                    placeholder="Texto a buscar">
                                <button type="submit" @click="listarMetodo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i>
                                    Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                              <!--   <th>Opciones</th>-->
                                 
                                <th>Nombre</th>
                                <th>Cant. Min. Retiro</th>
                                <th>Cant. Max. Retiro</th>
                                <th>Cargo de Retiro</th>
                                <th>% por Cargo</th>
                                <th>Taza</th>
                                <th>Moneda</th>
                                <th>Días Hábiles</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="metodo in arrayMetodo" :key="metodo.id">
                                 <td>
                                    <button type="button" @click="abrirModal('metodo','actualizar',metodo)" class="btn btn-warning btn-sm">
                                        <i class="fas fa-pen"></i>
                                    </button> &nbsp;
                                    <template v-if="metodo.estado_mp">
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarMetodo(metodo.id)">
                                            <i class="far fa-eye-slash"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-info btn-sm" @click="activarMetodo(metodo.id)">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </template>
                                </td> 
                                <td v-text="metodo.nombre_mp"></td>
                                <td v-text="metodo.cantidad_minretiro"></td>
                                <td v-text="metodo.cantidad_maxretiro"></td>
                                <td v-text="metodo.cargo_retiro"></td>
                                <td v-text="metodo.porcentaje_cargo"></td>
                                <td v-text="metodo.taza_mp"></td>
                                <td v-text="metodo.moneda_mp"></td>
                                <td v-text="metodo.dias_habiles"></td>
                                <td v-text="metodo.estado_mp"></td>
                                
                                 
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
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre_mp" class="form-control"
                                        placeholder="Ingrese el nombre del metodo de pago">
                                </div>
                            </div>
                            <!--  <div class="form-group row">
                               <img :src="imagenm" class="img-circle" width="150" />
                                <label class="col-md-3 form-control-label" for="text-input">Imagen</label>
                                <div class="col-md-9">
                                     <input type="file"  class="form-control"   @change="obtenerImagen"/>
                                </div>
                            </div>-->
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Cantidad minima retiro</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="cantidad_minretiro" class="form-control"
                                        placeholder="Ingrese cantidad minima de retiro">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Cantidad maxima retiro</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="cantidad_maxretiro" class="form-control"
                                        placeholder="Ingrese cantidad maxima de retiro">
                                </div>
                            </div>
                            
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Cargo de retiro</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="cargo_retiro" class="form-control"
                                        placeholder="Ingrese carg de retoro">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Porcentaje de cargo</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="porcentaje_cargo" class="form-control"
                                        placeholder="Ingrese porcentaje de cargo">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Taza</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="taza_mp" class="form-control"
                                        placeholder="Ingrese taza">
                                </div>
                            </div>

                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Moneda</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="moneda_mp" class="form-control"
                                        placeholder="Ingrese Moneda">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Dias habiles</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="dias_habiles" class="form-control"
                                        placeholder="Ingrese dias habiles">
                                </div>
                            </div>

                            
                             
                            <div v-show="errorMetodo" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjMetodo" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span><b>(*)</b>&nbsp;Campo obligatorio de ingresar</span>
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarMetodo()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="actualizarMetodo()">Actualizar</button>
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
                 id:0,
                nombre_mp: '',
            //    imagen:'',
             //   imagenMiniatura:'',
                cantidad_minretiro: 0,
                cantidad_maxretiro: 0,
                cargo_retiro: 0,
                porcentaje_cargo: 0,
                taza_mp: 0,
                moneda_mp: '',
                dias_habiles: 0,
                arrayMetodo: [],
                arrayRol: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorMetodo: 0,
                errorMostrarMsjMetodo: [],
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
        /*    imagenm: function(){
                return this.imagenMiniatura;
            },*/
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

           /* obtenerImagen(e)
            {
                let file= e.target.files[0];
                console.log(file);
                this.imagen=file;
                 this.cargarImagen(file);
            },
            cargarImagen(file)
            {
                let reader= new FileReader();
                reader.onload= (e)=>
                {
                    this.imagenMiniatura=e.target.result;
                }
                reader.readAsDataURL(file);
            },*/
            //Metodo para obtener todos los registros de la bd mediante el uso del controlador definido y en este caso, se tiene tambien la implementacion de la paginacion para ver los registros de acuerdo a lo establecido en el modelo (10 modelos por pagina) y se implementa la busqueda de registros en este metodo debido a que es el que se encarga de mostrar los datos de acuerdo al criterio elegido si es que se ha introducido un texto o mostrar todos los datos en caso de que no sea asi
            listarMetodo(page,buscar,criterio) {
                let me = this;
                //Se le asigna a la ruta '/cliente' los parametros 'buscar' y 'criterio' mediante el metodo get que se utiliza para buscar un registro de acuerdo a lo que ha ingresado el usuario en el input para buscar
                var url = '/metodoPago?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                   
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                     
                    //Guarda los datos en el arreglo 'arrayUsuario'
                    me.arrayMetodo = respuesta.metodo.data;
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
                me.listarMetodo(page,buscar,criterio);
            },
            //Método para registrar una categoria a la base de datos
            registrarMetodo() {
                //Verifica que el método 'verificarCategoria' haya devuelto un valor, en ese caso, no se realiza ninguna tarea hasta que esto no sea cierto
                if (this.validarMetodo()) {
                    return;
                }
                let me = this;
                //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/registrar' para llamar al controlador y ejecutar la tarea correspondiente
                axios.post('/metodoPago/registrar',{
                    //Se le asignan los valores recopilados de los inputs del modal
                  //  'imagen_mp': this.imagen_mp,
                    'nombre_mp': this.nombre_mp,
                    'cantidad_minretiro': this.cantidad_minretiro,
                    'cantidad_maxretiro': this.cantidad_maxretiro,
                    'cargo_retiro': this.cargo_retiro,
                    'porcentaje_cargo': this.porcentaje_cargo,
                    'taza_mp': this.taza_mp,
                    'moneda_mp': this.moneda_mp,
                    'dias_habiles': this.dias_habiles,
                   // 'imagen': this.imagen
                }).then(function (response) {
                    //Se llama al metodo 'cerrarModal' para ocultarlo y se vuelve a enlistar las categorias de forma descendente, es decir, el registro recien ingresado sera el primero
                    me.cerrarModal();
                    me.listarMetodo(1,'','nombre_mp');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
           //Método para actualizar un registro de la tabla 'persona'
            actualizarMetodo() {
                //Verifica que el método 'verificarCategoria' haya devuelto un valor, en ese caso, se muestran los errores al usuario que son arrojados debido a que algun campo obligatorio esta vacio
                if (this.validarMetodo()) {
                    return;
                }
                let me = this;
                console.log(this.id);
                //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/actualizar' para llamar al controlador y ejecutar la tarea correspondiente
                axios.put('/metodoPago/actualizar',{
                    //Se le asignan los valores recopilados de los inputs del modal
                   'nombre_mp': this.nombre_mp,
                    'cantidad_minretiro': this.cantidad_minretiro,
                    'cantidad_maxretiro': this.cantidad_maxretiro,
                    'cargo_retiro': this.cargo_retiro,
                    'porcentaje_cargo': this.porcentaje_cargo,
                    'taza_mp': this.taza_mp,
                    'moneda_mp': this.moneda_mp,
                    'dias_habiles': this.dias_habiles,
                    'id': this.id,
                   // 'imagen': this.imagen
                }).then(function (response) {
                    //Se llama al metodo 'cerrarModal' para ocultarlo y se vuelve a enlistar las categorias de forma descendente, es decir, el registro recien ingresado sera el primero
                    me.cerrarModal();
                    me.listarMetodo(1,'','nombre_mp');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
      
            //Método que sirve para mostrar en el modal errores cuando el usuario no ingresa texto en el input mediante el uso de un array del apartado de estilos
            validarMetodo() {
                this.errorMetodo = 0;
                this.errorMostrarMsjMetodo = [];
                if (!this.nombre_mp) this.errorMostrarMsjMetodo.push("El nombre del metodo de pago no puede estar vacío.");
                if (!this.cantidad_minretiro) this.errorMostrarMsjMetodo.push("La cantidad minima de retiro no puede estar vacía.");
                if (!this.cantidad_maxretiro) this.errorMostrarMsjMetodo.push("La cantidad maxima de retiro no puede estar vacía.");
                if (!this.cargo_retiro) this.errorMostrarMsjMetodo.push("El cargo de retiro no puede estar vacío.");
                if (!this.porcentaje_cargo) this.errorMostrarMsjMetodo.push("El porcentaje de retiro no puede estar vacío.");
                if (!this.taza_mp) this.errorMostrarMsjMetodo.push("La taza no puede estar vacía.");
                if (!this.moneda_mp) this.errorMostrarMsjMetodo.push("La moneda no puede estar vacía.");
                if (!this.dias_habiles) this.errorMostrarMsjMetodo.push("Los dias habiles no puede estar vacíos.");
                if (this.errorMostrarMsjMetodo.length) this.errorMetodo = 1;
                return this.errorMetodo;
            },
            //Método que sirve para mostrar el modal para guardar/actualizar un proveedor, en este se tiene 2 switch donde se hace uso del modelo correspondiente y la acción, se hace de esta manera debido a que se utiliza el mismo modal para ambas tareas mas sin embargo, los datos que se mandan al controlador son diferentes
            abrirModal(modelo, accion, data = []) {
                switch (modelo) {
                    case "metodo":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar metodo de pago';
                                this.nombre_mp="";
                                this.cantidad_minretiro=0;
                                this.cantidad_maxretiro=0;
                                this.cargo_retiro=0;
                                this.porcentaje_cargo=0;
                                this.taza_mp=0;
                                this.moneda_mp="";
                                this.dias_habiles=0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.id=data['id'];
                                this.nombre_mp=data['nombre_mp'];
                                this.cantidad_minretiro=data['cantidad_minretiro'];;
                                this.cantidad_maxretiro=data['cantidad_maxretiro'];;
                                this.cargo_retiro=data['cargo_retiro'];;
                                this.porcentaje_cargo=data['porcentaje_cargo'];;
                                this.taza_mp=data['taza_mp'];;
                                this.moneda_mp=data['moneda_mp'];;
                                this.dias_habiles=data['dias_habiles'];
                                this.tipoAccion = 2;
                                break;
                            } 
                        }
                    }
                }
               // this.selectRol();
            },
            //Método que sirve para ocultar el modal una vez se pulsa sobre alguno de los 2 botones para cerrarlo
            cerrarModal() {
                this.modal=0;
            //   this.imagen_mp,
                this.nombre_mp="";
                this.cantidad_minretiro=0;
                this.cantidad_maxretiro=0;
                this.cargo_retiro=0;
                this.porcentaje_cargo=0;
                this.taza_mp=0;
                this.moneda_mp="";
                this.dias_habiles=0;
            },

            desactivarMetodo(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: '¿Estás seguro de desactivar este usuario?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/desactivar' para llamar al controlador y ejecutar la tarea correspondiente
                        axios.put('/metodoPago/desactivar',{
                            //Se le asignan los valores recopilados de los inputs del modal
                            'id': id
                        }).then(function (response) {
                            //Se llama al metodo para enlistar las categorias y se muestra un mensaje mediante sweetalert
                            me.listarMetodo(1,'','nombre_mp');
                            swalWithBootstrapButtons.fire(
                            '¡Desactivado!',
                            'El registro ha sido desactivado con éxito.',
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

            activarMetodo(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: '¿Estás seguro de activar este usuario?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/activar' para llamar al controlador y ejecutar la tarea correspondiente
                        axios.put('/metodoPago/activar',{
                            //Se le asignan los valores recopilados de los inputs del modal
                            'id': id
                        }).then(function (response) {
                            //Se llama al metodo para enlistar las categorias y se muestra un mensaje mediante sweetalert
                           me.listarMetodo(1,'','nombre_mp');
                            swalWithBootstrapButtons.fire(
                            '¡Activado!',
                            'El registro ha sido activado con éxito.',
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
            
        },
        //Se utiliza la propiedad 'mounted' para hacer el llamado a los métodos que se quieren cargar automaticamente una vez se muestra el componente 'usuario'
        mounted() {
            this.listarMetodo(1,this.buscar,this.criterio);
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