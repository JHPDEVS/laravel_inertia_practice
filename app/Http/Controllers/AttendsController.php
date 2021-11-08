<?php

namespace App\Http\Controllers;

use App\Models\Attend;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AttendsController extends Controller
{
    public function create(Request $req,$subjectID) {
        $validator = Validator::make($req->all(), [
            'user_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'false',
                'data' => $validator->errors()
            ], 200);
        }

        $attend = DB::table('attends')
        ->where('user_id', '=', $req->user_id)
        ->where('subject_id','=',$subjectID)
        ->first();
        
        if(!$attend) {
            $attend = new Attend();
            $attend->user_id = $req->user_id;
            $attend->subject_id = $subjectID;
            $attend->save();
        } else {
            $attend = Attend::all()
            ->where('user_id', '=', $req->user_id)
            ->where('subject_id','=',$subjectID)
            ->first()->delete();
            return response()->json([
                'status' => 'false',
                'req' => $req->user_id,
                'msg' => "수강취소 했습니다다",
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'msg' => "수강신청완료",
        ], 200);
    }
    public function index() {

        $attends = DB::table('attends')
        ->join('subjects', 'subjects.id', '=', 'attends.subject_id')
        ->where('attends.user_id', '=', auth()->user()->id)
        ->select(
            DB::raw('attends.id, subjects.id,subjects.subjectName,
            subjects.description, subjects.grade'),
        )->orderBy('attends.id', 'asc')->paginate(5);
     
        
        $subjects = DB::table('attends')
        ->join('subjects', 'attends.subject_id', '=', 'subjects.id')
        ->select(
            DB::raw('subjects.id, subjects.subjectName , attends.user_id , COUNT(attends.id) as count')
        )->groupBy('subjects.id')->orderBy('attends.id', 'asc')->get();

        $i = 0;
        $flag = true;

        foreach($attends as $row) {
            $flag = true;

            for ($i = 0; $i < $subjects->count(); $i++) {
                if ($row->id == $subjects[$i]->id) {
                    $row->attends_count = $subjects[$i]->count;
                    $flag = false;
                    break;
                }
            }

            if ($flag) {
                $row->attends_count = null;
            }
        }

        $attendsAllGrade = DB::table('attends')
        ->join('subjects', 'subjects.id', '=', 'attends.subject_id')
        ->where('attends.user_id', '=', auth()->user()->id)
        ->select(
            DB::raw('sum(subjects.grade) as count'))
        ->first();
        $res = response()->json([
            'status' => 'success',
            'attends' => $attends,
            'subjects' => $subjects,
            'allgrade' => $attendsAllGrade
        ],200);

        return $res;
      
    }

    public function getAttendUser($subjectID) {

        if(!(Auth::user()->email === 'park@naver.com')) {
            abort(403);
        }
        $attends = DB::table('attends')
        ->join('users', 'users.id', '=', 'attends.user_id')
        ->where('subject_id','=',$subjectID)
        ->select(
            DB::raw('users.id, users.name , users.email,users.profile_photo_path')
        )->groupBy('users.id')->orderBy('users.id', 'asc')->paginate(5);



        return inertia('Menu/AttendUsers',['attends'=>$attends]);
    }
}
