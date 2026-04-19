<?php

namespace App\Repositories;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Routine;
use App\Models\Syllabus;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\FinalMark;
use App\Models\AssignedTeacher;
use App\Interfaces\CourseInterface;
use Illuminate\Support\Facades\DB;

class CourseRepository implements CourseInterface {
    public function create($request) {
        try {
            Course::create($request);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create School Course. '.$e->getMessage());
        }
    }

    public function getAll($session_id) {
        return Course::where('session_id', $session_id)->get();
    }

    public function getByClassId($class_id) {
        return Course::where('class_id', $class_id)->get();
    }

    public function findById($course_id) {
        return Course::find($course_id);
    }

    public function update($request) {
        try {
            Course::find($request->course_id)->update([
                'course_name'  => $request->course_name,
                'course_type'  => $request->course_type,
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to update Course. '.$e->getMessage());
        }
    }

    public function delete($id) {
        try {
            DB::transaction(function () use ($id) {
                AssignedTeacher::where('course_id', $id)->delete();
                Assignment::where('course_id', $id)->delete();
                Attendance::where('course_id', $id)->delete();
                Mark::where('course_id', $id)->delete();
                FinalMark::where('course_id', $id)->delete();
                Exam::where('course_id', $id)->delete();
                Routine::where('course_id', $id)->delete();
                Syllabus::where('course_id', $id)->delete();
                Course::where('id', $id)->delete();
            });
        } catch (\Exception $e) {
            throw new \Exception('Failed to delete Course. '.$e->getMessage());
        }
    }
}
