<div class="modal modal-primary fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2"><b>Editar Usuario</b></h4>
            </div>
            <div class="modal-body">

                    {!! Form::open(['route'=>'user.store', 'role' => 'form', 'method' => 'post']) !!}
                    <div id="wizard_two" class="form_wizard wizard_verticle">
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
                        </ul>

                        <div id="step-11">
                            <h4 class="StepTitle">Lugares</h4>
                            El Usuario pertenece a una:
                            <table class="table table-bordered">
                                <tr>
                                    <td><label>Direccion </label></td>
                                    <td><input type="radio" class="flat" name="type"  value="Unidad Mayor" onclick="seleEdit(this.value)"/></td>
                                </tr>
                                <tr>
                                    <td><label>Unidad Administrativa </label></td>
                                    <td><input type="radio" class="flat" name="type"  value="Unidad Dependiente" onclick="seleEdit(this.value)"/></td>
                                </tr>
                                <tr>
                                    <td><label>Facultad </label></td>
                                    <td><input type="radio" class="flat" name="type"  value="Facultad" onclick="seleEdit(this.value)"/></td>
                                </tr>
                                <tr>
                                    <td><label>Carrera </label></td>
                                    <td><input type="radio" class="flat" name="type"  value="Carrera" onclick="seleEdit(this.value)"/></td>
                                </tr>

                            </table>

                        </div>
                        <div id="step-22">
                            <h2 class="StepTitle" id="especifique">Especifique</h2>
                            <label class="mensaje" id="mensaje"></label>

                            <table  class="table table-bordered ">
                                <table  class="table table-bordered">
                                    <tr>
                                        <td>Direccion</td>
                                        <td>
                                            <select name="unidad_mayor" id="unidad_mayor_edit" class="form-control" onchange="cambioEdit(this.value,'unidad')">
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
                                            <select name="unidad_dependiente" id="unidad_dependiente_edit" class="form-control" >
                                                <option value="">Seleccione</option>

                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Facultad</td>
                                        <td>
                                            <select name="facultad" id="facultad_edit" class="form-control" onchange="cambioEdit(this.value,'facultad')">
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
                                            <select name="carrera" id="carrera_edit" class="form-control" >
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
                                    <td>{!! Form::text('name',null,["class"=>"form-control","placeholder"=>"Nombre","value"=>"",'required']) !!}</td>
                                </tr>
                                <tr>
                                    <td>{!! Form::label('last_name','Apellido') !!}</td>
                                    <td>{!! Form::text('last_name',null,["class"=>"form-control","placeholder"=>"Apellidos","value"=>"",'required']) !!}</td>
                                </tr>
                                <tr>
                                    <td>{!! Form::label('email','Correo Electronico') !!}</td>
                                    <td>{!! Form::email('email',null,["class"=>"form-control","placeholder"=>"Email","value"=>"",'required']) !!}</td>
                                </tr>
                                <tr>
                                    <td>{!! Form::label('celular','Celular') !!}</td>
                                    <td>{!! Form::text('celular',null,["class"=>"form-control","placeholder"=>"Nro. Celular","value"=>"",'required']) !!}</td>
                                </tr>
                                <tr>
                                    <td>{!! Form::label('rol','Rol') !!}</td>
                                    <td>
                                        <select name="rol" class="form-control" value="">
                                            <option value="">Seleccione</option>
                                            <option value="Administrador">Administrador</option>
                                            <option value="Secretario">Secretario</option>
                                            <option value="Personal">Personal</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {!! Form::close() !!}



            </div>


        </div>
    </div>
</div>