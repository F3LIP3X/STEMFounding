<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {

    // Añadir balance
    public function addBalance( Request $request ) {

        $request->validate( [
            'funds' => 'nullable|numeric|min:0',
            'withdraw' => 'nullable|numeric|min:0',
            'iban' => 'required|alpha_num',
        ] );

        $user = auth()->user();

        $user->balance += $request->funds ?? 0;
        $user->balance -= $request->withdraw ?? 0;
        $user->iban = $request->iban;

        $user->save();

        return redirect()->back()->with( 'success', 'Transaction completed successfully!' );
    }

    // Metodo para banear un usuario
    public function banUser( $id ) {

        $user = User::find( $id );
        $change = $user->banned == 1 ? 0 : 1;
        $user->update( [ 'banned' => $change ] );

        if ($change == 1) {
            foreach ($user->projects as $project) {
                $project->update(['state' => 'inactive']);
            }
        } else {
            foreach ($user->projects as $project) {
                $project->update(['state' => 'pending']);
            }
        }
        
        return redirect()->back()->with( 'success', 'User banned!.' );

    }

    // Metodo para desbanear un usuario
    public function unbanUser($id)
    {
        $user = User::find($id);
        $user->update(['banned' => 0]);
        return redirect()->back()->with('success', 'User unbanned successfully!');
    }

    // Metodo para mostrar el perfil de un usuario y sus projectos
    public function showProfile( $id ) {

        $user = User::find( $id );
        $projects = $user->projects()->paginate( 10 );

        return view( 'profile', compact( 'user', 'projects' ) );
    }

    // Metodo para cambiar el role de un usuario
    public function changeRole( Request $request, $id ) {
        $request->validate( [
            'role' => 'required',
        ] );
        $user = User::find( $id );
        $user->update( [ 'role' => $request->input( 'role' ) ] );
        return redirect( '/home' );
    }

    // Metodo para mostrar los usuarios baneados
    public function filterUsers(Request $request) {

        $filter = $request->input('filter');
    
        if ($filter === 'true') {
            $users = User::query()->where('banned', 1)->paginate(10);
        } elseif ($filter === 'false') {
            $users = User::query()->where('banned', 0)->paginate(10);
        } else {
            $users = User::query()->paginate(10)->appends(request()->query());
        }

        return view('usersAdmin', compact('users'));
    }
    
    // Metodo para mostrar todos los usuarios
    public function showUsersAdmin(){
        $users = User::paginate(10);
        return view('usersAdmin', compact('users'));
    }

    // Metodo para cambiar la contraseña
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Verifica que la contraseña actual es la misma introducida
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta']);
        } else {
            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        return redirect()->back()->with('success', 'Password changed successfully!');
    }

    // Metodo para actualizar el nombre del usuario
    public function updateName(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        $user->name = $request->input('name');
        $user->save();

        return redirect()->back()->with('success', 'Name updated successfully!');
    }

    // =========================REACT===========================

    // Metodo para mostrar el perfil del usuario con ID 2 
    public function showUserTwoProfile() {
        $user = User::find(2);
        
        $projects = $user->projects()->paginate(10);
        return response()->json(['user' => $user, 'projects' => $projects]);
    }

    // Metodo para retirar fondos del usuario con ID 2
    public function withdrawFunds(Request $request) {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $user = User::find(2);

        if ($user->balance >= $request->amount) {
            $user->balance -= $request->amount;
            $user->save();

            $mensaje = response()->json(['success' => 'Funds withdrawn successfully!', 'user' => $user]);
        } else {
            $mensaje = response()->json(['error' => 'Insufficient funds']);
        }

        return $mensaje;
    }
}