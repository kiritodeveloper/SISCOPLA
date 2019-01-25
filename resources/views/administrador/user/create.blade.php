<div id="create" class="col-md-5 col-xs-12" style="display: block">
<div class="row">
    <div class="panel panel-primary">
        <div class="panel panel-boding">
            {!! Form::open(['route'=>'user.store', 'role' => 'form', 'method' => 'post']) !!}
            <div id="wizard_verticle" class="form_wizard wizard_verticle">
                <ul class="list-unstyled wizard_steps">
                    <li>
                        <a href="#step-11">
                            <span class="step_no">1</span>
                        </a>
                    </li>
                    <li>
                        <a href="#step-22">
                            <span class="step_no">2</span>
                        </a>
                    </li>
                    <li>
                        <a href="#step-33">
                            <span class="step_no">3</span>
                        </a>
                    </li>
                    <li>
                        <a href="#step-44">
                            <span class="step_no">4</span>
                        </a>
                    </li>
                </ul>

                <div id="step-11">
                    <h4 class="StepTitle">Lugares</h4>
                    El Usuario pertenece a una:
                    <br>
                    <br>
                    <table class="table table-bordered">
                        <tr>
                            <td><label>Direccion </label></td>
                            <td><input type="radio" class="flat" name="type"  value="Unidad Mayor" onclick="sele(this.value)"/></td>
                        </tr>
                        <tr>
                            <td><label>Unidad Administrativa</label></td>
                            <td><input type="radio" class="flat" name="type"  value="Unidad Dependiente" onclick="sele(this.value)"/></td>
                        </tr>
                        <tr>
                            <td><label>Facultad </label></td>
                            <td><input type="radio" class="flat" name="type"  value="Facultad" onclick="sele(this.value)"/></td>
                        </tr>
                        <tr>
                            <td><label>Carrera </label></td>
                            <td><input type="radio" class="flat" name="type"  value="Carrera" onclick="sele(this.value)"/></td>
                        </tr>

                    </table>

                </div>
                <div id="step-22">
                    <h2 class="StepTitle" id="especifique">Especifique</h2>
                    <label class="mensaje" id="mensaje"></label>

                    <table  class="table table-bordered table-striped">
                        <table  class="table table-bordered table-striped">
                            <tr>
                                <td>Direccion</td>
                                <td>
                                    <select name="unidad_mayor" id="unidad_mayor" class="form-control" onchange="cambio(this.value,'unidad')">
                                        <option value="">Seleccione</option>
                                        @foreach($unidads as $u)
                                            <option value="{{$u->id}}">{{$u->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Unidad Administrativa</td>
                                <td>
                                    <select name="unidad_dependiente" id="unidad_dependiente" class="form-control" >
                                        <option value="">Seleccione</option>

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Facultad</td>
                                <td>
                                    <select name="facultad" id="facultad" class="form-control" onchange="cambio(this.value,'facultad')">
                                        <option value="">Seleccione</option>
                                        @foreach($facultads as $u)
                                            <option value="{{$u->id}}">{{$u->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Carrera</td>
                                <td>
                                    <select name="carrera" id="carrera" class="form-control" >
                                        <option value="">Seleccione</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </table>
                </div>
                <div id="step-33">
                    <h3 class="StepTitle" >Nombre de la Oficina</h3>

                    <br>
                    <br>
                    <table class="table table-responsive">
                        <tr>
                            <td>{!! Form::label('name','Nombre') !!}</td>
                            <td>{!! Form::text('name',null,["class"=>"form-control","placeholder"=>"Nombre",'required']) !!}</td>
                        </tr>
                        <tr>
                            <td>{!! Form::label('last_name','Apellido') !!}</td>
                            <td>{!! Form::text('last_name',null,["class"=>"form-control","placeholder"=>"Apellidos",'required']) !!}</td>
                        </tr>
                        <tr>
                            <td>{!! Form::label('ci','Cedula de Identidad') !!}</td>
                            <td>{!! Form::text('ci',null,["class"=>"form-control","placeholder"=>"Cedula de Identidad",'required']) !!}</td>
                        </tr>
                        <tr>
                            <td>{!! Form::label('email','Correo Electronico') !!}</td>
                            <td>{!! Form::email('email',null,["class"=>"form-control","placeholder"=>"Email",'required']) !!}</td>
                        </tr>
                        <tr>
                            <td>{!! Form::label('celular','Celular') !!}</td>
                            <td>{!! Form::text('celular',null,["class"=>"form-control","placeholder"=>"Nro. Celular",'required'=>'required','onblur'=>"getpassword()"]) !!}</td>
                        </tr>

                    </table>
                </div>
                <div id="step-44">
                    <p><h4 class="StepTitle" id="especifique">Nota: Los siguientes carracteres son la contrase&ntilde;a con el cual el usuario podra ingresar al sistema,
                        tome nota de ellos y entreguelos al usuario que corresponde antes de guardar los datos. </h4></p>
                    <table class="table">
                        <tr>
                            <td>Nombre de Usuario</td>
                            <td>
                                <input type="text" disabled class="form-control" name="userna" id="userna">
                                <input type="hidden" name="username" id="username" value="" >
                            </td>
                        </tr>
                        <tr>
                            <td>Contrase&ntilde;a</td>
                            <td>
                                <input type="text" disabled class="form-control" name="pass" id="pass">
                                <input type="hidden" name="password" id="password" value="" >
                            </td>
                        </tr>
                    </table>
                    <p><b>En caso de no ver nada vuelva a la opcion 3 y llene todos los datos</b></p>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
    </div>
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel panel-boding">
                <center>
                <td>
                    
                </td>
                <td></td>
                <td>
                </td>
                        <a href="{{url('user_excel')}}" class="btn btn-success" target="_blank"><i class="fa fa-file-excel"></i> Descargar lista de usuarios</a>
                        </center>
            </div>
        </div>
    </div>
</div>