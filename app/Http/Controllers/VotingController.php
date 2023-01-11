<?php

namespace App\Http\Controllers;

use App\Models\Voting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class VotingController extends Controller
{
    public function index(){
        return view('voting.index', ['constituency' => config('global.constituency'), 'candidates' => config('global.candidates')]);
    }

    public function getCandidates(Request $request){
        try {
            $constituency = $request->get('constituency');
            $allCandidates = config('global.candidates');
            $candidates = $allCandidates[$constituency];
            return view('voting.ajax.candidates', ['candidates' => $candidates]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function saveVote(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'constituency' => 'required|string',
                'candidate' => 'required|string',
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }else{
                $vote = Voting::where('constituency', $request->get('constituency'))->where('candidate', $request->get('candidate'))->first();
                if(isset($vote)){
                    $vote->no_of_votes = $vote->no_of_votes + 1;
                    $save = $vote->save();
                    if(!$save){
                        return back()->with('warning', 'Vote was not updated successfully. Something went wrong!');
                    }else{
                        return back()->with('success','Vote was updated successfully!');
                    }
                }else{
                    $newVote = Voting::create([
                        'constituency' => $request->get('constituency'),
                        'candidate' => $request->get('candidate'),
                        'no_of_votes' => 1
                    ]);
                    if (!$newVote){
                        return back()->with('warning', 'Vote was not saved successfully. Something went wrong!');
                    }else{
                        return back()->with('success', 'Vote was saved successfully!');
                    }
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getDetails(){
        try {
            $details = Voting::orderBy('constituency')->get();
            if($details->isEmpty()){
                $details = [];
            }
            return view('voting.details', ['details' => $details]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
