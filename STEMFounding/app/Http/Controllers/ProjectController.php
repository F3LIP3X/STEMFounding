<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller{
    
    // Metodo para crear un nuevo proyecto
    public function createProject(Request $request){
        
        $user = auth()->user();

        $activeProjectsCount = $user->projects()->where('state', 'active')->count();
        $pendingProjectsCount = $user->projects()->where('state', 'pending')->count();


        if ($activeProjectsCount >= 2 || $pendingProjectsCount >= 2) {
            $mensaje = redirect()->back()->with('error', 'You cannot create more than 2 active projects or 2 pending projects.');
        } else {

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'url_Img' => 'required|url',
            'url_Video' => 'required|url',
            'limit_date' => ['required', 'date', 'after:today'],
            'min_investment' => 'required|numeric|min:10',
            'max_investment' => 'required|numeric',
        ]);

        // Creacion del objeto proyecto
        $project = new Project($validatedData);
        $project->save();

        $mensaje = redirect()->back()->with('success', 'Project created successfully!');

        }
        return $mensaje;
    }

    // Metodo para mostrar todos los proyectos activos, inactivos y pendientes en la ventana de guest
    public function showProjects(){
        $projects = Project::where('state', ['active', 'inactive'])->paginate(6); 
        return view('guest', compact('projects')); 
    }

    // Metodo para mostrar los proyectos activos, inactivos y pendientes en la ventana de user logeado
    public function showHomeProjects(){
        $projects = Project::where('state', ['active', 'inactive'])->paginate(6); 
        return view('home', compact('projects')); 
    }

    // Metodo para mostrar proyectos en la pagina de solicitudes
    public function showRequestProjects(){
        $projects = Project::where('state', 'pending')->with('user')->paginate(6); 
        return view('request', compact('projects')); 
    }

    // Metodo para cambiar el estado de el proyecto a activo
    public function activeStatus($id){

        $project = Project::find($id);
        $project->state = 'active';
        $project->save();
        return redirect()->back();
    }

    // Metodo para cambiar el estado de el proyecto a rechazado
    public function rejectStatus($id){

        $project = Project::find($id);
        $project->state = 'reject';
        $project->save();

        return redirect()->back();
    }
    
    // Metodo para mostrar detalles del proyecto
    public function showProjectDetails($id){
        
        $project = Project::find($id);
        return view('projectDetails', compact('project'));
    }

    // Metodo para editar un proyecto
    public function update(Request $request, $id){

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url_Img' => 'required|url',
            'url_Video' => 'required|url',
        ]);

        $project = Project::find($id);
        $project->title = $request->input('title');
        $project->description = $request->input('description');
        $project->url_Img = $request->input('url_Img');
        $project->url_Video = $request->input('url_Video');
        $project->save();

        return redirect()->back();
    }

    // Metodo para filtrar proyectos
    public function filterProjects(Request $request){

        $state = $request->input('state');
        $projects = Project::when($state, function ($query, $state) {
            return $query->where('state', $state);
        })->paginate(24);

        return view('home', compact('projects'));
    }

    // Metodo para desabilitar un proyecto
    public function disableProject($id){
        $project = Project::find($id);
        $project->state = 'inactive';
        $project->save();

        return redirect()->back();
    }

    // Metodo para eliminar un proyecto
    public function deleteProject($id){
        $project = Project::find($id);
        $project->delete();

        return redirect('/home');
    }

    // ========================REACT========================

    // Metodo para mostrar detalles del proyecto
    public function ProjectsDetails($id){
        $project = Project::find($id);
        return response()->json($project);
    }

    // Metodo para editar un proyecto desde React
    public function updateProject(Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url_Img' => 'required|url',
            'url_Video' => 'required|url',
        ]);

        $project = Project::find($id);

        $project->title = $request->input('title');
        $project->description = $request->input('description');
        $project->url_Img = $request->input('url_Img');
        $project->url_Video = $request->input('url_Video');
        $project->save();

        return response()->json();
    }

    // Metodo para desabilitar un proyecto desde React
    public function disableProjectReact($id) {
        $project = Project::find($id);

        $project->state = 'inactive';
        $project->save();

        return response()->json();
    }

    // Metodo para eliminar un proyecto desde React
    public function deleteProjectReact($id) {
        $project = Project::find($id);

        $project->delete();

        return response()->json(['success' => 'Project deleted successfully!']);
    }

    // Metodo para crear un nuevo proyecto
    public function createProjectReact(Request $request){
        
        // Validacion de los datos del formulario
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'url_Img' => 'required|url',
            'url_Video' => 'required|url',
            'limit_date' => ['required', 'date', 'after:today'],
            'min_investment' => 'required|numeric|min:10',
            'max_investment' => 'required|numeric',
        ]);

        // Creacion del objeto proyecto
        $project = new Project($validatedData);
        $project->save();

        // Redirigir de vuelta con un mensaje de exito
        return response()->json(['success' => 'Project created successfully!']);
    }

    public function filter($state){
        try {
            $projects = Project::where('state', $state)->get();
            return response()->json($projects);
        } catch (\Exception $error) {
            console.log($error);
        }
    }
}



