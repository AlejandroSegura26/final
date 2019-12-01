<template>
    <main class="main" style="width: 100%; height: 100%;">
        <!-- Breadcrumb -->
        <ol class="breadcrumb col-lg-12">
            <li class="breadcrumb-item"><a href="/principal">Tablero</a></li>
            <li class="breadcrumb-item">Director de proyectos</li>
            <li class="breadcrumb-item"><a @click="menu=5" href="#">Hitos</a></li>
            
        </ol>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-thumbtack"></i>&nbsp;&nbsp;Hitos&nbsp;
                    <button type="button" @click="abrirModal('hito','registrar',0)" class="btn btn-secondary float-right">
                        <i class="fa fa-plus"></i>&nbsp;Nuevo
                    </button>
                     < <button type="button" @click="menu=15" class="btn btn-secondary float-right">
                        <i class="fa fa-plus"></i>&nbsp;Ver todas las tareas
                    </button> 
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="titulo">Titulo</option>
                                </select>
                                 <input type="text" v-model="buscar" @keyup.enter="listarHito(1,buscar,criterio)" class="form-control"
                                    placeholder="Texto a buscar">
                                <button type="submit" @click="listarHito(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i>
                                    Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Proyecto</th>
                                <th>Titulo</th>
                                <th>Fecha inicio</th>
                                <th>Fecha final</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="hito in arrayHito" :key="hito.id">
                                <td>
                                      <button type="button" @click="abrirModal('hito','actualizar',hito,hito.id)" class="btn btn-warning btn-sm">
                                        <i class="fas fa-pen"></i>
                                    </button> &nbsp;
                                      <button type="button" @click="abrirModal('hito','add',hito,hito.id)" class="btn btn-warning btn-sm">
                                        <i class="fas fa-plus"></i>
                                    </button> &nbsp;
                                       
                                        <template v-if="hito.estado">
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarHito(hito.id)">
                                            <i class="far fa-eye-slash"></i>
                                        </button>&nbsp;
                                    </template>
 


                                </td>
                                <td v-text="hito.ptitulo"></td>
                                <td v-text="hito.titulo"></td>
                                <td v-text="hito.fecha_inicio"></td>
                                <td v-text="hito.fecha_fin"></td>
                                <td v-text="hito.descripcion"></td>
                                  <template v-if="hito.estado">
                                     <td  >Activo</td>
                                   </template>     
                                    <template v-else>
                                            <td  >Terminado</td>
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
                                <label class="col-md-3 form-control-label" for="text-input">Proyecto <b>(*)</b></label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="id_proyecto">
                                        <option value="0">Seleccione una opción: </option>
                                        <option v-for="proyecto in arrayProyecto" :key="proyecto.id" :value="proyecto.id" v-text="proyecto.titulo"></option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Titulo</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="titulo" class="form-control"
                                        placeholder="Ingrese el titulo del proyecto">
                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Fecha Inicio<b>(*)</b></label>
                                <div class="col-md-9">

                                    <input type="date" v-model="fecha_inicio" class="form-control"
                                        placeholder="Ingrese la fecha de inicio" min="<?php echo $fecha = date()?>" >

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Fecha Final<b>(*)</b></label>
                                <div class="col-md-9">

                                    <input type="date" v-model="fecha_final   " class="form-control"
                                        placeholder="Ingrese la fecha de fin "   min="<?php echo $fecha = date()?>" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Descripcion <b>(*)</b></label>
                                <div class="col-md-9">
                                    <input type="text" v-model="descripcion" class="form-control"
                                        placeholder="Ingrese la descripcion">
                                </div>
                            </div>
                            <div v-show="errorProyecto" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjProyecto" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>

                         <form v-else action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            
                  
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Programador <b>(*)</b></label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="miembro_id">
                                        <option value="0">Seleccione una opción: </option>
                                        <option v-for="programador in arrayProgramador" :key="programador.id" :value="programador.id" v-text="programador.nombre"></option>
                                    </select>
                                </div>
                            </div>
                          
                             <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Fecha inicio<b>(*)</b></label>
                                <div class="col-md-9">

                                    <input type="date" v-model="fecha_inicio" class="form-control"
                                        placeholder="Ingrese la fecha de inicio" min="<?php echo $fecha = date()?>" >

                                </div>
                            </div>
                            
                             
                          
                              <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Horas<b>(*)</b></label>
                                <div class="col-md-9">
                                    <input type="text" v-model="horas" class="form-control"
                                        placeholder="Ingrese horas de trabajo ">
                                </div>
                            </div>
                          
                  
                          
                           <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Descripcion <b>(*)</b></label>
                                <div class="col-md-9">
                                    <input type="text" v-model="descripcion" class="form-control"
                                        placeholder="Ingrese la descripcion">
                                </div>
                            </div>
                            <div v-show="errorProyecto" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjTarea" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span><b>(*)</b>&nbsp;Campo obligatorio de ingresar</span>
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="registrarHito()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-warning" @click="actualizarHito()">Actualizar</button>
                        <button type="button" v-if="tipoAccion==3" class="btn btn-success" @click="agregarTarea()">Agregar</button>
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
                id_proyecto: 0,
                hito_id: 0,
                titulo: '',
                menu:0,
              miembro_id:0,
              horas:0,
                id_manager:0,
                descripcion: '',
                fecha_inicio: '',
                fecha_final: '',
                id_cliente: 0,
                id_programador:0,
                arrayProgramador:[],
                 rol:'',
                cantidad:0,
                tipo_pago:'',
                arrayHito: [],
                arrayProyecto: [],
                arrayManager: [],
                arrayCliente: [],
                modal: 0,
                tituloModal: '',
                tipoAccion: 0,
                errorProyecto: 0,
                errorTarea:0,
                errorMostrarMsjProyecto: [],
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
            listarHito(page,buscar,criterio) {
                let me = this;
                //Se le asigna a la ruta '/cliente' los parametros 'buscar' y 'criterio' mediante el metodo get que se utiliza para buscar un registro de acuerdo a lo que ha ingresado el usuario en el input para buscar
                var url = '/hito?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayUsuario'
                    me.arrayHito = respuesta.hito.data;
                    //Guarda en el arreglo 'pagination' las variables necesarias para llevar a cabo estas tareas
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            //Método para llenar un select con los datos de la tabla rol, mostrando solo aquellos que estan activados
            selectCliente() {
                let me = this;
                //Se le asigna la ruta al controlador que realiza la peticion al modelo para recopilar todos los roles
                var url = '/usuario/selectCliente';
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayRol'
                    me.arrayCliente = respuesta.cliente;
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
            //Metodo para mostrar una determinada pagina y los registros asignados a ella
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //Envia la peticion para visualizar los datos de esa pagina
                me.listarHito(page,buscar,criterio);
            },
            //Método para registrar una categoria a la base de datos
            registrarHito() {
                //Verifica que el método 'verificarCategoria' haya devuelto un valor, en ese caso, no se realiza ninguna tarea hasta que esto no sea cierto
                if (this.validarHito()) {
                    return;
                }
                let me = this;
                //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/registrar' para llamar al controlador y ejecutar la tarea correspondiente
                axios.post('/hito/registrar',{
                    //Se le asignan los valores recopilados de los inputs del modal
                    'id_proyecto': this.id_proyecto,
                    
                    'titulo': this.titulo,    
                    'descripcion': this.descripcion,
                    'fecha_inicio': this.fecha_inicio,
                    'fecha_final': this.fecha_final
                }).then(function (response) {
                    //Se llama al metodo 'cerrarModal' para ocultarlo y se vuelve a enlistar las categorias de forma descendente, es decir, el registro recien ingresado sera el primero
                    me.cerrarModal();
                    me.listarHito(1,'','titulo');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            //Método para actualizar un registro de la tabla 'persona'
            actualizarHito() {
                //Verifica que el método 'verificarCategoria' haya devuelto un valor, en ese caso, se muestran los errores al usuario que son arrojados debido a que algun campo obligatorio esta vacio
                if (this.validarHito()) {
                    return;
                }
                let me = this;
                //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/actualizar' para llamar al controlador y ejecutar la tarea correspondiente
                console.log(this.id_hito)
                axios.put('/hito/actualizar',{
                    //Se le asignan los valores recopilados de los inputs del modal
                   'id_proyecto': this.id_proyecto,
                    'titulo': this.titulo,    
                    'id': this.id_hito,
                    'descripcion': this.descripcion,
                    'fecha_inicio': this.fecha_inicio,
                    'fecha_final': this.fecha_final
                }).then(function (response) {
                    //Se llama al metodo 'cerrarModal' para ocultarlo y se vuelve a enlistar las categorias de forma descendente, es decir, el registro recien ingresado sera el primero
                    me.cerrarModal();
                    me.listarHito(1,'','titulo');
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            
            //Método que sirve para mostrar en el modal errores cuando el usuario no ingresa texto en el input mediante el uso de un array del apartado de estilos
            validarHito() {
                this.errorProyecto = 0;
                this.errorMostrarMsjProyecto = [];
              if (!this.id_proyecto) this.errorMostrarMsjProyecto.push("Debe elegir un proyecto");
                if (!this.titulo) this.errorMostrarMsjProyecto.push("El hito del proyecto no puede estar vacío.");
               if (!this.fecha_inicio) this.errorMostrarMsjProyecto.push("La fecha de inicio no puede estar vacia ");  
              if (!this.fecha_final) this.errorMostrarMsjProyecto.push("La fecha de fin no puede estar vacia vacia ");
              if (!this.descripcion) this.errorMostrarMsjProyecto.push("La descripcion no puede estar vacia ");

                if (this.errorMostrarMsjProyecto.length) this.errorProyecto = 1;
                return this.errorProyecto;
            },
         
            //Método que sirve para mostrar el modal para guardar/actualizar un proveedor, en este se tiene 2 switch donde se hace uso del modelo correspondiente y la acción, se hace de esta manera debido a que se utiliza el mismo modal para ambas tareas mas sin embargo, los datos que se mandan al controlador son diferentes
            abrirModal(modelo, accion, data = [],id) {
                switch (modelo) {
                    case "hito":
                    {
                        switch (accion) {
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Hito';
                                this.tipoAccion = 1;
                                this.titulo = '';
                                this.id_proyecto=0;
                                this.fecha_inicio='';
                                this.fecha_fin='';
                                this.descripcion='';
                                this.selectProyecto();
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Actualizar Hito';
                                this.tipoAccion = 2;
                                this.id_proyecto=data['id_proyecto'];
                                this.id_hito=id;
                                this.titulo = data['titulo'];
                                this.descripcion  = data['descripcion'];
                                this.fecha_inicio=data['fecha_inicio'];
                                this.fecha_fi = data['fecha_fin'];
                                this.selectProyecto();
                                break;
                            }
                             case 'add':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar tarea';
                                this.hito_id=data['id'];
                                this.miembro_id=0;
                                this.fecha_inicio=0;
                                this.horas=0;
                                this.descripcion="";
                                this.tipoAccion = 3;
                                this.selectProgramador(id);
                                break;
                            }
                        }
                    }
                }
                //this.selectCliente();
               // this.selectManager();
                
             
            },
            //Método que sirve para ocultar el modal una vez se pulsa sobre alguno de los 2 botones para cerrarlo
            cerrarModal() {
                this.modal = 0;
                this.tituloModal = '';
                 this.titulo = '';
                this.id_cliente=0;
                                this.id_manager=0;
                                this.descripcion='';
                                this.fecha_final='';
                                this.fecha_inicio='';
                                this.id_proyecto=0;
                                this.id_manager=0;
                                this.tipo_pago ='';
                                this.cantidad = 0;
                                this.id_programador = 0;
                this.errorProyecto= 0;
            },
            //Método para desactivar un usuario y no pueda acceder al sistema
            desactivarHito(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: '¿Estás seguro de   finalizar   el  proyecto?     ',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;
                        //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/desactivar' para llamar al controlador y ejecutar la tarea correspondiente
                        axios.post('/hito/desactivar',{
                            'id':id,
                        }).then(function (response) {
                            //Se llama al metodo para enlistar las categorias y se muestra un mensaje mediante sweetalert
                           console.log(response.data);
                          console.log(id);
                           if(response.data==1)
                             {
                              swalWithBootstrapButtons.fire(
                            '¡finalizado!',
                            'El proyecto ha sido finalizado con éxito.',
                            'success'
                            ) 
                                me.listarHito(1,'','titulo');
                             }
                          else
                            {
                                  swalWithBootstrapButtons.fire(
                          
                            'No puede finalzar este proyecto ya que tiene tareas activas.',
                           
                            ) 
                            }
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
            agregarTarea() {
                      console.log(this.hito_id);
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: '¿Estás seguro de  agregar esta tarea?     ',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;
              
                        //Mediante axios se hace una peticion mediante ajax gracias a la ruta '/categoria/desactivar' para llamar al controlador y ejecutar la tarea correspondiente
                        axios.post('/tarea/registrar',{
                            //Se le asignan los valores recopilados de los inputs del modal

                            'hito_id':this.hito_id,
                            'miembro_id':this.miembro_id,
                            'fecha_inicio':this.fecha_inicio,
                            'horas':this.horas,
                            'descripcion':this.descripcion,
                          

                        }).then(function (response) {
                            if(response.data==1)
                              {
                                
                            swalWithBootstrapButtons.fire(
                            '¡Agregado!',
                            'La tarea ha sido agregada con éxito.',
                            'success'
                            )
                              }
                          else
                            {
                              
                            swalWithBootstrapButtons.fire(
                            'No se puede agregar esta tarea ya que el hito no esta activo'
                            )
                            }
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
            selectProgramador(id){
           
               let me = this;
                //Se le asigna a la ruta '/cliente' los parametros 'buscar' y 'criterio' mediante el metodo get que se utiliza para buscar un registro de acuerdo a lo que ha ingresado el usuario en el input para buscar
                var url = '/usuario/selectProgramadorTarea?id=' + id;
                axios.get(url).then(function (response) {
                    //Se crea una variable respuesta que guardara los datos de la consulta mediante ajax
                    var respuesta = response.data;
                    //Guarda los datos en el arreglo 'arrayUsuario'
                    me.arrayProgramador = respuesta.programador;
 
                })
                .catch(function (error) {
                    console.log(error);
                });
            }

        },
        //Se utiliza la propiedad 'mounted' para hacer el llamado a los métodos que se quieren cargar automaticamente una vez se muestra el componente 'usuario'
        mounted() {

            this.listarHito(1,this.buscar,this.criterio);

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
