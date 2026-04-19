@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-start">
        @include('layouts.left-menu')
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-10 col-xl-10 col-xxl-10">
            <div class="row pt-2">
                <div class="col ps-4">
                    <h1 class="display-6 mb-3">
                        <i class="bi bi-cloud-sun"></i> Give Marks
                    </h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url()->previous()}}">My courses</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Give Marks</li>
                        </ol>
                    </nav>
                    @include('session-messages')
                    @if ($academic_setting['marks_submission_status'] == "on")
                    <p class="text-primary">
                        <i class="bi bi-exclamation-diamond-fill me-2"></i> Marks Submission Window is open now.
                    </p>
                    @endif
                    <p class="text-primary">
                        <i class="bi bi-exclamation-diamond-fill me-2"></i> Final Marks submission should be done only once in a Semester when the Marks Submission Window is open.
                    </p>
                    @if ($final_marks_submitted)
                    <p class="text-success">
                        <i class="bi bi-exclamation-diamond-fill me-2"></i> Marks are submitted.
                    </p>
                    @endif
                    <h3><i class="bi bi-diagram-2"></i> Class #{{request()->query('class_name')}}, Section #{{request()->query('section_name')}}</h3>
                    <h3><i class="bi bi-compass"></i> Course: {{request()->query('course_name')}}</h3>
                    <div class="alert alert-light border mt-3 mb-2" role="alert">
                        <h6 class="mb-1"><i class="bi bi-grid-3x3-gap-fill me-2"></i>Grade Input Sheet</h6>
                        <small class="text-muted d-block">Use the table below like an Excel sheet (rows = students, columns = grading components/exams).</small>
                        <small class="text-muted d-block">Recommended breakdown: <strong>60%</strong> performance task (attendance, quizzes, class activities) + <strong>40%</strong> examination (midterm/final).</small>
                    </div>
                    @if (!$final_marks_submitted && count($exams) > 0 && $academic_setting['marks_submission_status'] == "on")
                        <div class="col-3 mt-3">
                            <a type="button" href="{{route('course.final.mark.submit.show', ['class_id' => $class_id, 'class_name' => request()->query('class_name'), 'section_id' => $section_id, 'section_name' => request()->query('section_name'), 'course_id' => $course_id, 'course_name' => request()->query('course_name'), 'semester_id' => $semester_id])}}" class="btn btn-outline-primary" onclick="return confirm('Are you sure, you want to submit final marks?')"><i class="bi bi-check2"></i> Submit Final Marks</a>
                        </div>
                    @endif
                    <form action="{{route('course.mark.store')}}" method="POST">
                        @csrf
                        <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                        <div class="row mt-3">
                            <div class="col">
                                <div class="table-responsive">
                                    
                                    <table class="table table-hover table-bordered align-middle">
                                        <thead>
                                            <tr>
                                            <th scope="col">Student Name</th>
                                            @isset($exams)
                                                @foreach ($exams as $exam)
                                                <th scope="col"><a href="{{route('exam.rule.show', ['exam_id' => $exam->id])}}" data-bs-toggle="tooltip" data-bs-placement="top" title="View {{$exam->exam_name}} exam rules">{{$exam->exam_name}}</a></th>
                                                @endforeach
                                            @endisset
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @isset($exams)
                                                @isset($students_with_marks)
                                                    @foreach ($students_with_marks as $id => $students_with_mark)
                                                        @php
                                                            $markedExamCount = 0;
                                                        @endphp
                                                    <tr>
                                                        <td>{{$students_with_mark[0]->student->first_name}} {{$students_with_mark[0]->student->last_name}}</td>
                                                        @foreach ($students_with_mark as $st)
                                                            @php
                                                                $examName = strtolower($exams[$markedExamCount]->exam_name);
                                                                $isExamComponent = \Illuminate\Support\Str::contains($examName, ['exam', 'midterm', 'final']);
                                                            @endphp
                                                            <td>
                                                                <input type="number" min="0" max="100" step="0.01" class="form-control" name="student_mark[{{$students_with_mark[0]->student->id}}][{{$exams[$markedExamCount]->id}}]" value="{{$st->marks}}" placeholder="{{$isExamComponent ? '0-40' : '0-60'}}">
                                                            </td>
                                                            
                                                            @php
                                                                $markedExamCount++;
                                                            @endphp
                                                        @endforeach
                                                        @php
                                                            $students_with_markCount = count($students_with_mark);
                                                            $examCount = count($exams);
                                                            $gt = 0;
                                                            if($students_with_markCount < $examCount) {
                                                                $gt = $examCount - $students_with_markCount;
                                                            }
                                                        @endphp
                                                        @for ($i = 0; $i < $gt; $i++)
                                                            <td>
                                                                @php
                                                                    $examName = strtolower($exams[$markedExamCount]->exam_name);
                                                                    $isExamComponent = \Illuminate\Support\Str::contains($examName, ['exam', 'midterm', 'final']);
                                                                @endphp
                                                                <input type="number" min="0" max="100" step="0.01" class="form-control" name="student_mark[{{$students_with_mark[0]->student->id}}][{{$exams[$markedExamCount]->id}}]" placeholder="{{$isExamComponent ? '0-40' : '0-60'}}">
                                                            </td>
                                                            @php
                                                                $markedExamCount++;
                                                            @endphp
                                                        @endfor
                                                    </tr>
                                                    @endforeach
                                                @endisset
                                            @endisset
                                            @if(count($students_with_marks) < 1)
                                                @foreach ($sectionStudents as $sectionStudent)
                                                    <tr>
                                                        <td>{{$sectionStudent->student->first_name}} {{$sectionStudent->student->last_name}}</td>
                                                        @isset($exams)
                                                            @foreach ($exams as $exam)
                                                                <td>
                                                                    @php
                                                                        $examName = strtolower($exam->exam_name);
                                                                        $isExamComponent = \Illuminate\Support\Str::contains($examName, ['exam', 'midterm', 'final']);
                                                                    @endphp
                                                                    <input type="number" min="0" max="100" step="0.01" class="form-control" name="student_mark[{{$sectionStudent->student->id}}][{{$exam->id}}]" placeholder="{{$isExamComponent ? '0-40' : '0-60'}}">
                                                                </td>
                                                            @endforeach
                                                        @endisset
                                                    </tr>
                                                @endforeach
                                            @endif
                                            <input type="hidden" name="studentCount" value="{{count($sectionStudents)}}">
                                            <input type="hidden" name="semester_id" value="{{$semester_id}}">
                                            <input type="hidden" name="class_id" value="{{$class_id}}">
                                            <input type="hidden" name="section_id" value="{{$section_id}}">
                                            <input type="hidden" name="course_id" value="{{$course_id}}">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                        {{-- <div class="row justify-content-between mb-3"> --}}
                            @if(!$final_marks_submitted && count($exams) > 0)
                            <div class="col-3">
                                <button type="submit" class="btn btn-outline-primary"><i class="bi bi-check2"></i> Save</button>
                            </div>
                            @else
                                @if($final_marks_submitted)
                                <div class="col-5">
                                    <p class="text-success">
                                        <i class="bi bi-exclamation-diamond-fill me-2"></i> You have submitted Final Marks <i class="bi bi-stars"></i>.
                                    </p>
                                </div>
                                @else
                                <div class="col-5">
                                    <p class="text-primary">
                                        <i class="bi bi-exclamation-diamond-fill me-2"></i> Create Exam to give marks.
                                    </p>
                                </div>
                                @endif
                            @endif
                            {{-- <div class="col-3">
                                <button type="button" class="btn btn-outline-primary"><i class="bi bi-check2"></i> Submit Marks</button>
                            </div> --}}
                        {{-- </div> --}}
                    </form>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>
@endsection
