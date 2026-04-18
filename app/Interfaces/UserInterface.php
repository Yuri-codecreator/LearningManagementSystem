<?php

namespace App\Interfaces;

interface UserInterface {
    public function createTeacher($request);

    public function updateTeacher($request);

    public function deleteTeacher($teacher_id);

    public function createStudent($request);

    public function updateStudent($request);

    public function deleteStudent($student_id);

    public function getAllStudents($current_session, $class_id, $section_id);

    public function getAllStudentsBySession($session_id);

    public function getAllStudentsBySessionCount($session_id);

    public function findStudent($id);

    public function findTeacher($id);

    public function getAllTeachers();

    public function changePassword($new_password);
}
