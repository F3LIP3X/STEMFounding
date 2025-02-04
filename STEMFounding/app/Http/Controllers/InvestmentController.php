<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Investment;

class InvestmentController extends Controller {

    

    // Metodo crear una inversion
    public function createInvest( Request $request ) {

        $request->validate( [
            'project_id' => 'required|exists:projects,id',
            'amount' => 'required|numeric'
        ] );

        $user = auth()->user();
        $project = Project::find( $request->project_id );

        if ( $user->balance >= $request->amount && $project->state == 'active' ) {
            $amountToInvest = min($request->amount, $project->max_investment - $project->current_investment);

            if ($amountToInvest > 0) {
                $investment = Investment::create( [
                    'project_id' => $request->project_id,
                    'user_id' => $user->id,
                    'amount' => $amountToInvest
                ] );

                $user->balance -= $amountToInvest;
                $user->save();

                $investment->save();

                $project->current_investment += $amountToInvest;
                $project->save();
            }
        }

        return redirect()->back();
    }

    // Metodo para retornar una inversion
    public function returnInvestment( $id ) {

        $investment = Investment::find( $id );

        $user = auth()->user();

        if ( $user->id == $investment->user_id && $investment->created_at->diffInHours() < 24 ) {
            $investment->user->increment( 'balance', $investment->amount );
            $investment->project->decrement( 'current_investment', $investment->amount );
            if ($investment->project->current_investment < 0) {
                $investment->project->current_investment = 0;
            }
            $investment->project->save();
            $investment->delete();
        }

        return redirect()->back();
    }

    // Metodo para retirar dinero de un projecto y sumarlo al creador
    public function withdraw($id) {
        
        $project = Project::find($id);
        $user = auth()->user(); 

        if ($project->current_investment >= $project->min_investment && $project->user_id == $user->id) {
            $creator = $project->user;
            $creator->balance += $project->current_investment;
            $creator->save();

            $project->current_investment = 0;
            $project->state = 'inactive';
            $project->save();

            $mensaje = redirect()->back();
        } else {
            $mensaje = redirect()->back()->with(['error' => 'You cant withdraw money from this project, minimun investment is ' . $project->min_investment . '€']);
        }

        return $mensaje;
    }       

    // Metodo para mostrar la vista de inversiones
    public function showInvestments() {
        $user = auth()->user();
        $groupedInvestments = $user->investments->groupBy('project_id')->map(function ($investments) {
            return [
                'project' => $investments->first()->project,
                'total_amount' => $investments->sum('amount'),
                'latest_investment_date' => $investments->max('created_at'),
            ];
        });

        return view('userInvested', compact('groupedInvestments'));
    }

    //=========================REACT=============================

    //Metodo para sacar los inversores de un proyecto 
    public function getInvestments($id) {
        $investments = Investment::where('project_id', $id)->paginate(20);
        return response()->json($investments);
    }
    
    
}