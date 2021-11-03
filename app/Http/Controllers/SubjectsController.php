<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubjectsController extends Controller
{
    
     // 자유 게시판 생성
     public function create(Request $req) {
        $validator = Validator::make($req->all(), [
            'title' => 'required|string',
            'content' => 'required|string',
            'grade' => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'false',
                'data' => $validator->errors()
            ], 200);
        }

        $subject = new Subject();
        $subject->subjectName = $req->title;
        $subject->grade = $req->grade;
        $subject->description = $req->content;

        $subject->save();

        $res = response()->json([
            'status' => 'success',
            'subject' => $subject,
        ], 200);

        return $res;
    }

    public function index() {
        $subjects = DB::table('subjects')
        ->select(
            DB::raw('subjects.id, subjects.subjectName,
            subjects.description, subjects.grade,
            subjects.created_at,subjects.updated_at'),
        )->orderBy('subjects.id', 'asc')->paginate(6);
        
    
        $res = response()->json([
            'status' => 'success',
            'subjects' => $subjects
        ],200);


        return $res;
      
    }

    public function show($selected_subject_id) {
        $subjects = DB::table('subjects')
        ->where('subjects.id', '=', $selected_subject_id)
        ->select(
            DB::raw('subjects.id, subjects.subjectName,
            subjects.description, subjects.grade,
            subjects.created_at,subjects.updated_at'),
        )->first();
        
        
        $ifAttend = DB::table('attends')
        ->join('users', 'users.id', '=', 'attends.user_id')
        ->where('attends.subject_id', '=', $selected_subject_id)
        ->where('users.id', '=' , auth()->user()->id) // where문 추가
        ->first();
        
        if($ifAttend) {
            $attend = true;
        } else {
            $attend = false;
        }
        $res = response()->json([
            'status' => 'success',
            'attend' => $attend,
            'subjects' => $subjects
        ],200);

        return $res;
      
    }

    public function delete(Request $req,$selected_id) {


        $subject = Subject::find($selected_id);

        // if ($req->user_id != $post->user_id) {
        //     $res = response()->json([
        //         'status' => 'false',
        //         'message' => '작성자가 아닙니다.' , $req->user_id,
        //     ], 200, [], JSON_UNESCAPED_UNICODE);

        //     return $res;
        // }

     

        $subject->delete();

        $res = response()->json([
            'status' => 'ture',
            'message' => '삭제가 되었습니다.',
        ], 200, [], JSON_UNESCAPED_UNICODE);

        return $res;
    }

    public function edit(Request $req,$selected_id) {
        $subject = Subject::find($selected_id);
        $validator = Validator::make($req->all(), [
        'subjectName' => 'required|string',
            'description' => 'required|string',
            'grade' => 'required|integer'
              
            ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'false',
                'data' => $validator->errors()
            ], 200);
        }

        // if ($req->user_id != $subject->user_id) {
        //     $res = response()->json([
        //         'status' => 'false',
        //         'message' => '작성자가 아닙니다.',
        //     ], 200, [], JSON_UNESCAPED_UNICODE);

        //     return $res;
        // }

     
        $subject->subjectName = $req->subjectName;
        $subject->grade = $req->grade;
        $subject->description = $req->description;

        $subject->save();

        $res = response()->json([
            'status' => 'success',
            'subject' => $subject,
        ], 200);

        return $res;
    }
}
