<?php

namespace App\Repositories;

use App\Models\SchoolClass;
use App\Models\Course;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Section;
use App\Models\Routine;
use App\Models\Syllabus;
use App\Models\Promotion;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\FinalMark;
use App\Models\AssignedTeacher;
use App\Models\GradingSystem;
use App\Interfaces\SchoolClassInterface;
use Illuminate\Support\Facades\DB;

class SchoolClassRepository implements SchoolClassInterface {
    public function create($request) {
        try {
            SchoolClass::create($request);
        } catch (\Exception $e) {
            throw new \Exception('Failed to create School Class. '.$e->getMessage());
        }
    }

    public function getAllBySession($session_id) {
        return SchoolClass::where('session_id', $session_id)->get();
    }

    public function getAllBySessionAndTeacher($session_id, $teacher_id) {
        return AssignedTeacher::with('schoolClass')->where('teacher_id', $teacher_id)
                ->where('session_id', $session_id)
                ->get();
    }

    public function getAllWithCoursesBySession($session_id) {
        return SchoolClass::with(['courses','syllabi'])->where('session_id', $session_id)->get();
    }

    public function getClassesAndSections($session_id) {
        $school_classes = $this->getAllWithCoursesBySession($session_id);

        $sectionRepository = new SectionRepository();

        $school_sections = $sectionRepository->getAllBySession($session_id);

        $data = [
            'school_classes' => $school_classes,
            'school_sections'=> $school_sections,
        ];

        return $data;
    }

    public function findById($class_id) {
        return SchoolClass::find($class_id);
    }

    public function update($request) {
        try {
            SchoolClass::find($request->class_id)->update([
                'class_name'  => $request->class_name,
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Failed to update School Class. '.$e->getMessage());
        }
    }

    public function delete($id) {
        try {
            DB::transaction(function () use ($id) {
                AssignedTeacher::where('class_id', $id)->delete();
                Assignment::where('class_id', $id)->delete();
                Attendance::where('class_id', $id)->delete();
                Mark::where('class_id', $id)->delete();
                FinalMark::where('class_id', $id)->delete();
                Exam::where('class_id', $id)->delete();
                GradingSystem::where('class_id', $id)->delete();
                Promotion::where('class_id', $id)->delete();
                Routine::where('class_id', $id)->delete();
                Syllabus::where('class_id', $id)->delete();
                Course::where('class_id', $id)->delete();
                Section::where('class_id', $id)->delete();
                SchoolClass::where('id', $id)->delete();
            });
        } catch (\Exception $e) {
            throw new \Exception('Failed to delete class. '.$e->getMessage());
        }
    }
}
