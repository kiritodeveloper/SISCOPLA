<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolePostRequest;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles=Role::with('permission')->get();
        return view('role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions=Permission::all();
        return view('role.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolePostRequest $request)
    {
        $role=new Role($request->all());
        $role->save();
        if(($request->get('lista'))!=null){
            foreach($request->get('lista') as $lis){
                $permission=Permission::find($lis);
                $role->attachPermission($permission);
            }
        }
        Session::flash('save','El rol fue creado exitosamente');
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rol=Role::where('id',Crypt::decrypt($id))->with("permission")->first();
        $permissions=Permission::all();
        return view('role.edit',compact('rol','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        \DB::select('DELETE FROM permission_role WHERE role_id='.$id);
        $role=Role::find($id);
        foreach($request->get('lista') as $lis){
            $permission=Permission::find($lis);
            $role->attachPermission($permission);
        }
        Session::flash('edit','Los permisos fueron modificados correctaente');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function eliminar(){
        $id=\Illuminate\Support\Facades\Input::get('id');
        $usuarios=\DB::table('role_user')->where('role_id',$id)->get();
        if(count($usuarios)>0){
            Session::flash('error','Algo ha salido mal');
            Session::flash('noticie','El Rol tiene usuarios dependiente, Cambie de rol a los usuarios e intentelo de nuevo');
            return "0";
        }else{
            $r=Role::find($id);
            \DB::table('permission_role')->where('role_id',$id)->delete();
            \DB::table('roles')->where('id',$id)->delete();
            Session::flash('delete','El Rol Ha sido eliminado correctamente');
            return "1";
        }
    }
    public function AddRole($id){
        $user=User::find($id);
        $roles=Role::with('permission')->get();
        $tiene=\DB::table('role_user')
            ->where('user_id',$id)
            ->get();
        foreach ($roles as $r) {
            foreach($tiene as $t){
                if($t->role_id==$r->id){
                    $r->state=true;
                    break;
                }else{
                    $r->state=false;
                }
            }
        }
        return view('role.addrole',compact('user','roles'));
    }
    public function SaveRol(Request $request,$id){
        \DB::table('role_user')->where('user_id',$id)->delete();
        $user=User::find($id);
        if($request->has('roles')){
            foreach($request->get('roles') as $rol){
                $role=Role::find($rol);
                $user->attachRole($role);
            }
        }
        Session::flash('save','Los Roles se Editaron Correctamente');
        return redirect()->route('user.index');
    }
}
