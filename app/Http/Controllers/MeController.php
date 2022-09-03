<?php

namespace App\Http\Controllers;

use App\Http\Resources\MyProjectItem;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeController extends Controller
{
    public function getProjects()
    {
        $payments = Payment::where('user_id', '=', Auth::user()->id)->get();
        // $backers = array();
        // foreach ($payments as $payment) {
        //     $user = User::find($payment->user_id);
        //     $backers[] = [
        //         "name" => $user->full_name,
        //         "project_amount_given" => $payment->project_amount_given,
        //         "paid_at" => Carbon::parse($payment->created_at)->diffForHumans()

        //     ];
        // }

        $myProjects = array();
        foreach ($payments as $payment) {
            $project = Project::findOrFail($payment->project_id);
            $myProjects[] = [
                "project_id" => $project->id,
                "name" => $project->name,
                "project_amount_given" => $payment->project_amount_given,
                'created_at' => $payment->created_at
            ];
        }
        return response(
            $myProjects,
            200
        );
    }
}
